<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * CounsilorDocuments Controller
 *
 * @property CounsilorDocument $CounsilorDocument
 * @property PaginatorComponent $Paginator
 */
class CounsilorDocumentsController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
		public $components = array('Paginator');

	public function viewmembers() {

		$this->loadModel('User');
		$users = $this->User->find('all');
		$allmembers = [];

		foreach ($users as $user)
		{
				if( in_array(2, unserialize($user['User']['permissions'])) )
				{
						$allmembers[] = $user;
				}
		}

		$this->set('allusers', $allmembers);
	}

	  public function committeedetails() {

		}

		public function messageresend() {
				if ($this->request->is('post')) {
					$message = $this->request->data['CounsilorDocument']['message'];
					$subject = $this->request->data['CounsilorDocument']['subject'];

					if(!$subject)
					{
						$subject = "Council Meeting documents are posted.";
					}
					if(!$message)
					{
						$message = "Council Meeting documents are posted. Please login to https://trustconetest.co.za/users/login to view documents.";
					}
					if($this->request->data['CounsilorDocument']['sendemail']){
						 //$this->sendemailAttachment($message, $subject, $this->request->data);
	 						$this->sendemail($message, $subject, 22 );
					}
					if($this->request->data['CounsilorDocument']['sendsms']){
						 $this->sendsms($message, 22);
				  }

					$this->Session->setFlash(__('Your messages have been sent.'), 'default', array('class' => 'alert alert-success'));

					return $this->redirect(array('Controller' => 'CounsilorDocument', 'action' => 'committeedetails'));
			}
		}
		/********************************/

function sendemailAttachment($message=null, $subject=null, $data)
{
		$Email = new CakeEmail();

		$this->loadModel('User');
		$users = $this->User->find('all');

		if(!$subject)
		{
			$subject = "Council Meeting documents are posted.";
		}
		if(!$message)
		{
			$message = "Council Meeting documents are posted. Please login to https://trustconetest.co.za/users/login to view documents.";
		}
		//Build an array of attachments
		$attachments = [];
		foreach ($data['CounsilorDocument']['files'] as $value) {
			$attachments[$value['name']] = $value['tmp_name'];
		}

		foreach ($users as $user) {
				if (in_array(2, unserialize($user['User']['permissions']))) {
						$Email->from(array('no-reply@matjhabeng.co.za' => 'Matjhabeng Local Municipality Document Management System'))
								->template('newmeetingposted', 'default')
								->domain('www.trustconetest.co.za')
								->emailFormat('html')
								->viewVars(array('meeting' => $message))
								->attachments($attachments)
								->to(trim($user['User']['email']))
								//->to('maffins@gmail.com')
								->bcc('maffins@gmail.com')
								->subject($subject)
								->send();
				}
	}
//die;
}
/**
 * index method
 *
 * @return void
 */
	public function index() {
	    $this->loadModel('Meeting');

	    $allmeetings = $this->Meeting->find('all', ['fields'=>'DISTINCT name, idcounter, created, user_id, minutes, minutes_created, minutes_og_meeting', 'conditions'=>['Meeting.type' => 0], 'order' => ['id' => 'DESC']]);
        $this->set('meetings', $allmeetings);

        $this->set('usertype', $this->Auth->user()['user_type_id']);
        $this->loadModel('AuditTrail');

        $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
        $auditTrail['AuditTrail']['event_description'] = "Opened the meetings page ".$_SERVER['REMOTE_ADDR'];

        $auditTrail['AuditTrail']['contents'] = "Opened the meetings page ".$_SERVER['REMOTE_ADDR'];
        if( !$this->AuditTrail->save($auditTrail))
        {
            die('There was a problem trying to save the audit trail for viewing all counsiler documents');
        }

	}


    public function sendFile($id, $which) {

	    $tafura    = "";
	    $directory = "";

        if($which == 1)
        {
            $this->loadModel('MeetingAgenda');
            $tafura    = "MeetingAgenda";
            $directory = "agenda";
        }

        if($which == 2)
        {
            $this->loadModel('MeetingMinute');
            $tafura    = "MeetingMinute";
            $directory = "minutes";
        }

        if($which == 3)
        {
            $this->loadModel('MeetingItem');
            $tafura    = "MeetingItem";
            $directory = "items";
        }

        if($which == 4)
        {
            $this->loadModel('MeetingAttachment');
            $tafura    = "MeetingAttachment";
            $directory = "attachments";
        }

        if($which == 5)
        {
            $this->loadModel('MeetingSeparatecover');
            $tafura    = "MeetingSeparatecover";
            $directory = "separateCovers";
        }

        if($which == 6)
        {
            $this->loadModel('Meeting');
            $tafura    = "Meeting";
            $directory = "meeting_minutes";
        }

        if($which == 7)
        {
            $this->loadModel('MeetingNotice');
            $tafura    = "MeetingNotice";
            $directory = "notice";
        }

        if($which == 8)
        {
            $this->loadModel('MeetingAddendum');
            $tafura    = "MeetingAddendum";
            $directory = "addendum";
        }

        $options = array('conditions' => array($tafura.'.' . $this->$tafura->primaryKey => $id, $tafura.'.type' => 0));
        $file = $this->$tafura->find('first', $options);
        if($which == 6) {
            $path = '/webroot/uploads/' . $directory . '/' . $file[$tafura]['minutes'];
        }else{
            $path = '/webroot/uploads/'.$directory.'/'.$file[$tafura]['document_name'];
        }

        //echo $path;die;
        $this->response->file(
                                $path,
                                [
                                    'download' => true,
                                    'name' => $file[$tafura]['document_name']
                                ]
        );
        // Return response object to prevent controller from trying to render
        // a view

        $this->loadModel('AuditTrail');
        $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
        $auditTrail['AuditTrail']['event_description'] = "Opened to view document with id ".$id." item ".$directory." ".$_SERVER['REMOTE_ADDR'];

        $auditTrail['AuditTrail']['contents'] = "Opened to view document with id ".$id." item ".$directory." ".$_SERVER['REMOTE_ADDR'];
        if( !$this->AuditTrail->save($auditTrail))
        {
            die('There was a problem trying to save the audit trail for viewing counsiler document');
        }

        return $this->response;


    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function view($id = null) {

        $this->loadModel('Meeting');
        if (!$this->Meeting->exists($id)) {
            throw new NotFoundException(__('Invalid meeting'));
        }
        $options = array('conditions' => array('Meeting.' . $this->Meeting->primaryKey => $id, 'Meeting.type' => 0));
        // $options = array('conditions' => array('MeetingAgenda.type' => 1));

        $theMeeting = $this->Meeting->find('all', $options);

        /*
         * This is for the agenda
         */
        $this->loadModel('MeetingAgenda');
        $options1 = array('conditions' => array('MeetingAgenda.meeting_id' => $id, 'MeetingAgenda.type' => 0));

        $agenda = $this->MeetingAgenda->find('all', $options1);

        $this->set('usertype', $this->Auth->user()['user_type_id']);

        /*
         * This is for the minutes
         */
        $this->loadModel('MeetingMinutes');
        $options2 = array('conditions' => array('MeetingMinutes.meeting_id' => $id, 'MeetingMinutes.type' => 0));

        $MeetingMinutes = $this->MeetingMinutes->find('all', $options2);

        /*
         * This is for the items
         */
        $this->loadModel('MeetingItems');
        $options3 = array('conditions' => array('MeetingItems.meeting_id' => $id, 'MeetingItems.type' => 0));

        $Meetingitems = $this->MeetingItems->find('all', $options3);

        /*
         * This is for the attachments
         */
        $this->loadModel('MeetingAttachments');
        $options4 = array('conditions' => array('MeetingAttachments.meeting_id' => $id, 'MeetingAttachments.type' => 0));

        $MeetingAttachments = $this->MeetingAttachments->find('all', $options4);

				/*
         * This is for the separate covers
         */
        $this->loadModel('MeetingSeparatecovers');
        $options5 = array('conditions' => array('MeetingSeparatecovers.meeting_id' => $id, 'MeetingSeparatecovers.type' => 0));

        $MeetingSeparateCovers = $this->MeetingSeparatecovers->find('all', $options5);

				/*
				 * This is for the the notice
				 */
				$this->loadModel('MeetingNotice');
				$options6 = array('conditions' => array('MeetingNotice.meeting_id' => $id, 'MeetingNotice.type' => 0));

				$Notices = $this->MeetingNotice->find('all', $options6);

				/*
				 * This is for the the addendum
				 */
				$this->loadModel('MeetingAddendum');
				$options7 = array('conditions' => array('MeetingAddendum.meeting_id' => $id, 'MeetingAddendum.type' => 0));

				$Addendums = $this->MeetingAddendum->find('all', $options7);

        $this->set('usertype', $this->Auth->user()['user_type_id']);

				$this->set('Addendums', $Addendums);
				$this->set('Notice', $Notices);
				$this->set('MeetingSeparatecovers', $MeetingSeparateCovers);
        $this->set('MeetingAttachments', $MeetingAttachments);
        $this->set('Meeting', $theMeeting[0]);
        $this->set('previousminutes', $MeetingMinutes);
        $this->set('Meetingitems', $Meetingitems);
        $this->set('Agenda', $agenda);

        $this->loadModel('AuditTrail');
        $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
        $auditTrail['AuditTrail']['event_description'] = "Viewing the meeting details meeting id ".$id." ip ".$_SERVER['REMOTE_ADDR'];

        $auditTrail['AuditTrail']['contents'] = "Viewing the meeting details meeting id ".$id." ".$_SERVER['REMOTE_ADDR'];
        if( !$this->AuditTrail->save($auditTrail))
        {
            die('There was a problem trying to save the audit trail for viewing Council document');
        }

    }



public function addnotice() {
	if ($this->request->is('post')) {
		ini_set('upload_max_filesize', '20M');
		$this->CounsilorDocument->create();

		$this->request->data['CounsilorDocument']['user_id'] = $this->Auth->user('id');

		if ($this->CounsilorDocument->save($this->request->data)) {
			$this->Flash->success(__('The notice has been saved successfully.'));
			return $this->redirect(array('action' => 'noticeindex'));
		} else {
			$this->Flash->error(__('The notice could not be saved. Please, try again.'));
		}
	}
}
    /**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {

            ini_set('upload_max_filesize', '40M');

            //First save the meeting name
            $this->loadModel('Meeting');
            $meeting = [];

            $meeting['Meeting']['user_id'] = $this->Auth->user('id');
            $meeting['Meeting']['name']    = $meetingName = $this->request->data['CounsilorDocument']['meeting'];

            //Before saving the meeting, get the previous id counter and increment it then save.
            //Retrieve it and most important is the type when retrieving then afterwards simply add 1
            $previousMeeting = $this->Meeting->find('first', array('conditions' => array('Meeting.type' => 0),
                                                    'order' => array('Meeting.id' => 'DESC') ));
           // print_r($previousMeeting);die;

            $meeting['Meeting']['idcounter'] = $previousMeeting['Meeting']['idcounter']+1;

            $this->Meeting->save($meeting);
            $meeting_id = $this->Meeting->getLastInsertId();

						//First save the meeting addendum
            $this->loadModel('MeetingAddendum');
            $addendumDocuments = $this->request->data['CounsilorDocument']['addendum'];
            $addendumDetails = [];

            foreach( $addendumDocuments as $upload)
            {
                $this->MeetingAddendum->create();

                if ($meetingName) {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'addendum' . DS . $file['name']);
                    //prepare the filename for database entry
                    $addendumDetails['MeetingAddendum']['original_name'] = $original_name;
                    $addendumDetails['MeetingAddendum']['document_name'] = $file['name'];
                } else {
                    $addendumDetails['MeetingAddendum']['document_name'] = 'No Document';
                }

                $addendumDetails['MeetingAddendum']['user_id'] = $this->Auth->user('id');
                $addendumDetails['MeetingAddendum']['meeting_id'] = $meeting_id;

                if ($this->MeetingAddendum->save($addendumDetails)) {

                    $this->Flash->success(__('Uploaded notice successfuly.'));

                } else {
                    die('Cannot save the notice');
                }
            }

						//First save the meeting notices
            $this->loadModel('MeetingNotice');
            $noticeDocuments = $this->request->data['CounsilorDocument']['notice'];
            $noticeDetails = [];

            foreach( $noticeDocuments as $upload)
            {
                $this->MeetingNotice->create();

                if ($meetingName) {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'notice' . DS . $file['name']);
                    //prepare the filename for database entry
                    $noticeDetails['MeetingNotice']['original_name'] = $original_name;
                    $noticeDetails['MeetingNotice']['document_name'] = $file['name'];
                } else {
                    $noticeDetails['MeetingNotice']['document_name'] = 'No Document';
                }

                $noticeDetails['MeetingNotice']['user_id'] = $this->Auth->user('id');
                $noticeDetails['MeetingNotice']['meeting_id'] = $meeting_id;

                if ($this->MeetingNotice->save($noticeDetails)) {

                    $this->Flash->success(__('Uploaded notice successfuly.'));

                } else {
                    die('Cannot save the notice');
                }
            }

						//Second save the meeting agenda
            $this->loadModel('MeetingAgenda');
            $agendaDocuments = $this->request->data['CounsilorDocument']['agenda'];
            $agendaDetails = [];

            foreach( $agendaDocuments as $upload)
            {
                $this->MeetingAgenda->create();

                if ($meetingName) {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'agenda' . DS . $file['name']);
                    //prepare the filename for database entry
                    $agendaDetails['MeetingAgenda']['original_name'] = $original_name;
                    $agendaDetails['MeetingAgenda']['document_name'] = $file['name'];
                } else {
                    $agendaDetails['MeetingAgenda']['document_name'] = 'No Document';
                }


                $agendaDetails['MeetingAgenda']['user_id'] = $this->Auth->user('id');
                $agendaDetails['MeetingAgenda']['meeting_id'] = $meeting_id;

                if ($this->MeetingAgenda->save($agendaDetails)) {

                    $this->Flash->success(__('Uploaded successfuly.'));

                } else {
                    die('Cannot save the agenda');
                }
            }

            //First save the meeting previous minutes
            $this->loadModel('MeetingMinute');
            $minutesDocuments = $this->request->data['CounsilorDocument']['minutes'];
            $minutesDetails = [];

            foreach( $minutesDocuments as $upload)
            {
                $this->MeetingMinute->create();

                if ($meetingName) {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'minutes' . DS . $file['name']);
                    //prepare the filename for database entry
                    $minutesDetails['MeetingMinute']['document_name'] = $file['name'];
                    $minutesDetails['MeetingMinute']['original_name'] = $original_name;
                } else {
                    $minutesDetails['MeetingMinute']['document_name'] = 'No Document';
                }


                $minutesDetails['MeetingMinute']['user_id'] = $this->Auth->user('id');
                $minutesDetails['MeetingMinute']['meeting_id']  = $meeting_id;

                if ($this->MeetingMinute->save($minutesDetails)) {

                    $this->Flash->success(__('Uploaded successfuly.'));

                } else {
                    die('Cannot save the minutes');
                }
            }

            //First save the meeting items
            $this->loadModel('MeetingItem');
            $itemsDocuments = $this->request->data['CounsilorDocument']['items'];
            $itemsDetails = [];

            foreach( $itemsDocuments as $upload)
            {
                $this->MeetingItem->create();

                if ($meetingName) {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'items' . DS . $file['name']);
                    //prepare the filename for database entry
                    $itemsDetails['MeetingItem']['document_name'] = $file['name'];
                    $itemsDetails['MeetingItem']['original_name'] = $original_name;
                } else {
                    $itemsDetails['MeetingItem']['document_name'] = 'No Document';
                }


                $itemsDetails['MeetingItem']['user_id'] = $this->Auth->user('id');
                $itemsDetails['MeetingItem']['meeting_id']  = $meeting_id;

                if ($this->MeetingItem->save($itemsDetails)) {

                    $this->Flash->success(__('Uploaded successfuly.'));

                } else {
                    die('Cannot save the items');
                }
            }

            //First save the meeting attachments
            $this->loadModel('MeetingAttachment');
            $attachmentDocuments = $this->request->data['CounsilorDocument']['attachments'];
            $attachmentDetails = [];

            foreach( $attachmentDocuments as $upload)
            {
                $this->MeetingAttachment->create();

                if ($meetingName) {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'attachments' . DS . $file['name']);
                    //prepare the filename for database entry
                    $attachmentDetails['MeetingAttachment']['document_name'] = $file['name'];
                    $attachmentDetails['MeetingAttachment']['original_name'] = $original_name;
                } else {
                    $attachmentDetails['MeetingAttachment']['document_name'] = 'No Document';
                }


                $attachmentDetails['MeetingAttachment']['user_id'] = $this->Auth->user('id');
                $attachmentDetails['MeetingAttachment']['meeting_id'] = $meeting_id;

                if ($this->MeetingAttachment->save($attachmentDetails)) {

                    $this->Flash->success(__('Uploaded successfuly.'));

                } else {
                    die('Cannot save the attachments');
                }
            }


            //First save the meeting separate covers
            $this->loadModel('MeetingSeparatecover');
            $separateCoversDocuments = $this->request->data['CounsilorDocument']['separatecovers'];
            $separeCoverDetails = [];

            foreach( $separateCoversDocuments as $upload)
            {
                $this->MeetingSeparatecover->create();

                if ($meetingName) {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'separateCovers' . DS . $file['name']);
                    //prepare the filename for database entry
                    $separeCoverDetails['MeetingSeparatecover']['document_name'] = $file['name'];
                    $separeCoverDetails['MeetingSeparatecover']['original_name'] = $original_name;
                } else {
                    $separeCoverDetails['MeetingSeparatecover']['document_name'] = 'No Document';
                }


                $separeCoverDetails['MeetingSeparatecover']['user_id'] = $this->Auth->user('id');
                $separeCoverDetails['MeetingSeparatecover']['meeting_id'] = $meeting_id;

                if ($this->MeetingSeparatecover->save($separeCoverDetails)) {

                    $this->Flash->success(__('Uploaded successfuly.'));

                } else {
                    die('Cannot save the separate covers documents');
                }
            }

            //First save the meeting addendum
            $this->loadModel('MeetingAddendum');
            $addendumDocuments = $this->request->data['CounsilorDocument']['addendum'];
            $addendumDetails = [];

            foreach( $addendumDocuments as $upload)
            {
                $this->MeetingAddendum->create();

                if ($meetingName) {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'addendum' . DS . $file['name']);
                    //prepare the filename for database entry
                    $addendumDetails['MeetingAddendum']['original_name'] = $original_name;
                    $addendumDetails['MeetingAddendum']['document_name'] = $file['name'];
                } else {
                    $addendumDetails['MeetingAddendum']['document_name'] = 'No Document';
                }

                $addendumDetails['MeetingAddendum']['user_id'] = $this->Auth->user('id');
                $addendumDetails['MeetingAddendum']['meeting_id'] = $meeting_id;
                $addendumDetails['MeetingAddendum']['type']       = 5;

                if ($this->MeetingAddendum->save($addendumDetails)) {

                    $this->Flash->success(__('Uploaded notice successfuly.'));

                } else {
                    die('Cannot save the notice');
                }
            }

						$notifications = $this->request->data['CounsilorDocument']['notifications'];
						unset($this->request->data['CounsilorDocument']['notifications']);

						$sendemail = $this->request->data['CounsilorDocument']['sendemail'];
						unset($this->request->data['CounsilorDocument']['sendemail']);

						$sendsms = $this->request->data['CounsilorDocument']['sendsms'];
						unset($this->request->data['CounsilorDocument']['sendsms']);

            $this->loadModel('AuditTrail');
            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Adding a cousiler document ".$_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "Adding a counsiler document ".$_SERVER['REMOTE_ADDR'];
            if( !$this->AuditTrail->save($auditTrail))
            {
                die('There was a problem trying to save the audit trail for adding counsiler document');
            }

            //This is for sending emails to others not part of counciler user type
						if($notifications) {
							if($sendsms) {
								$this->sendsms($this->request->data['CounsilorDocument']['message']);
							}
							if($sendemail) {
		            $this->sendemail($this->request->data['CounsilorDocument']['message'], $this->request->data['CounsilorDocument']['subject']);
							}
						}else {
              $this->sendsms();
              $this->sendemail();
            }

            $this->Flash->success(__('Uploaded successfuly.'));
            return $this->redirect(array('action' => 'index'));
		}

        $this->loadModel('AuditTrail');
        $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
        $auditTrail['AuditTrail']['event_description'] = "Open the add cousiler add page ".$_SERVER['REMOTE_ADDR'];

        $auditTrail['AuditTrail']['contents'] = "Open the add cousiler document page ".$_SERVER['REMOTE_ADDR'];
        if( !$this->AuditTrail->save($auditTrail))
        {
            die('There was a problem trying to save the audit trail for editing counsiler document');
        }

		$users = $this->CounsilorDocument->User->find('list');
		$this->set(compact('users'));
	}

	/********************************/

	function sendsms($message=null)
	{
			$this->loadModel('User');
			$users = $this->User->find('all');

			$thedetails = [];
			$torecive   = [];
			$numbers    = "";

			foreach ($users as $user)
			{
					if( in_array(2, unserialize($user['User']['permissions'])) )
					{
							$thedetails['cellnumber'] = $user['User']['cellnumber'];

							$torecive[] = $thedetails;

							$thedetails = [];
					}
			}

			foreach ($torecive as $reciever) {
					if (strlen($reciever['cellnumber']) == 11) {
							$numbers .= $reciever['cellnumber'] . ',';
					}
			}

			$numbers .= '27817549884';
			//$numbers = '27635866058';

			if(!$message)
			{
				$message = "Council Meeting documents are posted. Please login to https://trustconetest.co.za/users/login to view documents.";
			}
			$smsText = urlencode($message);

			//$url = "http://78.46.17.110/app/smsapi/index.php?key=5bd18d48532d6&type=text&title=&contacts={$numbers}&groupid=&senderid=MAFFINS&msg={$smsText}&time=&time_zone=";
			$url = "http://148.251.196.36/app/smsapi/index.php?key=5c6d72f0f094d&type=text&contacts={$numbers}&senderid=Matjabheng&msg={$smsText}&time=";

			$mystring = $this->get_data($url);

	}

	/********************************/

    function sendemail($message=null, $subject=null)
    {
        $Email = new CakeEmail();

        $this->loadModel('User');
        $users = $this->User->find('all');

				if(!$subject)
				{
					$subject = "Council documents are posted.";
			  }
				if(!$message)
				{
					$message = "Council Meeting documents are posted. Please login to https://trustconetest.co.za/users/login to view documents.";
				}

        foreach ($users as $user) {
            if (in_array(2, unserialize($user['User']['permissions']))) {
                $Email->from(array('no-reply@matjhabeng.co.za' => 'Matjhabeng Local Municipality Document Management System'))
                    ->template('newmeetingposted', 'default')
										->domain('www.trustconetest.co.za')
                    ->emailFormat('html')
                    ->viewVars(array('meeting' => $message))
                    ->to(trim($user['User']['email']))
                    //->to('mapaepae@gmail.com')
                    ->bcc('maffins@gmail.com')
                    ->subject($subject)
                    ->send();
            }
        }

    }

	public function get_data($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {

		if ($this->request->is(array('post', 'put'))) {
            ini_set('upload_max_filesize', '20M');

            //First save the meeting name
            $this->loadModel('Meeting');
            $meeting = [];

            $meeting['Meeting']['user_id'] = $this->Auth->user('id');
            $meeting['Meeting']['name']    = $meetingName = $this->request->data['CounsilorDocument']['meeting'];
            $meeting['Meeting']['id']      = $this->request->data['CounsilorDocument']['maindid'];

            $this->Meeting->save($meeting);
            $meeting_id = $this->request->data['CounsilorDocument']['maindid'];

            //First save the meeting agenda
            $this->loadModel('MeetingAgenda');
            $agendaDocuments = $this->request->data['CounsilorDocument']['agenda'];
            $agendaDetails = [];

            foreach( $agendaDocuments as $upload)
            {
                $this->MeetingAgenda->create();

                if ($meetingName) {
                    $file = $upload;//put the data into a var for easy use
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'agenda' . DS . $file['name']);
                    //prepare the filename for database entry
                    $agendaDetails['MeetingAgenda']['document_name'] = $file['name'];

                } else {
                    $agendaDetails['MeetingAgenda']['document_name'] = 'No Document';
                }


                $agendaDetails['MeetingAgenda']['user_id'] = $this->Auth->user('id');
                $agendaDetails['MeetingAgenda']['meeting_id'] = $meeting_id;

                if($agendaDetails['MeetingAgenda']['document_name']) {
                    if ($this->MeetingAgenda->save($agendaDetails)) {

                        $this->Flash->success(__('Uploaded successfuly.'));

                    } else {
                        die('Cannot save the agenda');
                    }
                }
            }

            //First save the meeting previous minutes
            $this->loadModel('MeetingMinute');
            $minutesDocuments = $this->request->data['CounsilorDocument']['minutes'];
            $minutesDetails = [];

            foreach( $minutesDocuments as $upload)
            {
                $this->MeetingMinute->create();

                if ($meetingName) {
                    $file = $upload;//put the data into a var for easy use
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'minutes' . DS . $file['name']);
                    //prepare the filename for database entry
                    $minutesDetails['MeetingMinute']['document_name'] = $file['name'];

                } else {
                    $minutesDetails['MeetingMinute']['document_name'] = 'No Document';
                }


                $minutesDetails['MeetingMinute']['user_id'] = $this->Auth->user('id');
                $minutesDetails['MeetingMinute']['meeting_id']  = $meeting_id;

                if($minutesDetails['MeetingMinute']['document_name'])
                {
                    if ($this->MeetingMinute->save($minutesDetails)) {

                        $this->Flash->success(__('Uploaded successfuly.'));

                    } else {
                        die('Cannot save the minutes');
                    }
                }
            }

            //First save the meeting items
            $this->loadModel('MeetingItem');
            $itemsDocuments = $this->request->data['CounsilorDocument']['items'];
            $itemsDetails = [];

            foreach( $itemsDocuments as $upload)
            {
                $this->MeetingItem->create();

                if ($meetingName) {
                    $file = $upload;//put the data into a var for easy use
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'items' . DS . $file['name']);
                    //prepare the filename for database entry
                    $itemsDetails['MeetingItem']['document_name'] = $file['name'];

                } else {
                    $itemsDetails['MeetingItem']['document_name'] = 'No Document';
                }


                $itemsDetails['MeetingItem']['user_id'] = $this->Auth->user('id');
                $itemsDetails['MeetingItem']['meeting_id']  = $meeting_id;

                if($itemsDetails['MeetingItem']['document_name']) {
                    if ($this->MeetingItem->save($itemsDetails)) {

                        $this->Flash->success(__('Uploaded successfuly.'));

                    } else {
                        die('Cannot save the items');
                    }
                }
            }

            //First save the meeting attachments
            $this->loadModel('MeetingAttachment');
            $attachmentDocuments = $this->request->data['CounsilorDocument']['attachments'];
            $attachmentDetails = [];

            foreach( $attachmentDocuments as $upload)
            {
                $this->MeetingItem->create();

                if ($meetingName) {
                    $file = $upload;//put the data into a var for easy use
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'attachments' . DS . $file['name']);
                    //prepare the filename for database entry
                    $attachmentDetails['MeetingAttachment']['document_name'] = $file['name'];

                } else {
                    $attachmentDetails['MeetingAttachment']['document_name'] = 'No Document';
                }


                $attachmentDetails['MeetingAttachment']['user_id'] = $this->Auth->user('id');
                $attachmentDetails['MeetingAttachment']['meeting_id'] = $meeting_id;

                if($attachmentDetails['MeetingAttachment']['document_name']) {
                   // print_r($attachmentDetails);die;
                    if ($this->MeetingAttachment->save($attachmentDetails)) {

                        $this->Flash->success(__('Uploaded successfuly.'));

                    } else {
                        die('Cannot save the attachments');
                    }
                }
            }

            $this->loadModel('AuditTrail');

            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Eidting cousiler documents with id ".$id." ".$_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "Viewing the documents page";
            if( !$this->AuditTrail->save($auditTrail))
            {
                die('There was a problem trying to save the audit trail for adding counsiler document '.$id." ".$_SERVER['REMOTE_ADDR']);
            }

            return $this->redirect(array('action' => 'index'));

		} else {
//			$options = array('conditions' => array('CounsilorDocument.' . $this->CounsilorDocument->primaryKey => $id));
//			$this->request->data = $this->CounsilorDocument->find('first', $options);
            $this->loadModel('Meeting');

            $allmeetings = $this->Meeting->find('all', ['fields'=>'DISTINCT name, created, user_id', 'conditions'=>['Meeting.id' => $id] ]);

            $this->set('meetings', $allmeetings);
		}


        $this->loadModel('AuditTrail');

        $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
        $auditTrail['AuditTrail']['event_description'] = "Open the counsiler document for edit page ".$_SERVER['REMOTE_ADDR'];

        $auditTrail['AuditTrail']['contents'] = "Open the counsiler document edit page ".$_SERVER['REMOTE_ADDR'];
        if( !$this->AuditTrail->save($auditTrail))
        {
            die('There was a problem trying to save the audit trail for editing counsiler document');
        }

        $this->set('maindid', $id);
		$users = $this->CounsilorDocument->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->CounsilorDocument->id = $id;
		if (!$this->CounsilorDocument->exists()) {
			throw new NotFoundException(__('Invalid counsilor document'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->CounsilorDocument->delete()) {
			$this->Session->setFlash(__('The counsilor document has been deleted.'), 'default', array('class' => 'alert alert-success'));

            $this->loadModel('AuditTrail');

            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Deleting a cousiler document with id {$id} and ip ".$_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "Deleting a cousiler document ".$_SERVER['REMOTE_ADDR'];
            if( !$this->AuditTrail->save($auditTrail))
            {
                die('There was a problem trying to save the audit trail for adding counsiler document');
            }

        } else {
			$this->Session->setFlash(__('The counsilor document could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));

            $this->loadModel('AuditTrail');

            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Attempted to delete a cousiler document ".$id." ip ".$_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "Attempted to delete a cousiler document";
            if( !$this->AuditTrail->save($auditTrail))
            {
                die('There was a problem trying to save the audit trail for adding counsiler document '.$id." ip ".$_SERVER['REMOTE_ADDR']);
            }
		}
		return $this->redirect(array('action' => 'index'));
	}

public function cantdownload($id, $which) {

        $tafura    = "";
        $directory = "";
        $docname   = "";

        if($which == 1)
        {
            $this->loadModel('MeetingAgenda');
            $tafura    = "MeetingAgenda";
            $directory = "agenda";
            $docname   = "Meeting Agenda";
        }

        if($which == 2)
        {
            $this->loadModel('MeetingMinute');
            $tafura    = "MeetingMinute";
            $directory = "minutes";
            $docname   = "Minutes";
        }

        if($which == 3)
        {
            $this->loadModel('MeetingItem');
            $tafura    = "MeetingItem";
            $directory = "items";
            $docname   = "Meeting Items";
        }

        if($which == 4)
        {
            $this->loadModel('MeetingAttachment');
            $tafura    = "MeetingAttachment";
            $directory = "attachments";
            $docname   = "Attachments";
        }

        if($which == 5)
        {
            $this->loadModel('MeetingSeparatecover');
            $tafura    = "MeetingSeparatecover";
            $directory = "separateCovers";
            $docname   = "separateCovers";
        }

        if($which == 7)
        {
            $this->loadModel('MeetingNotice');
            $tafura    = "MeetingNotice";
            $directory = "notice";
            $docname   = "notice";
        }

        if($which == 8)
        {
            $this->loadModel('MeetingAddendum');
            $tafura    = "MeetingAddendum";
            $directory = "addendum";
            $docname   = "addendum";
        }

        $options = array('conditions' => array($tafura.'.' . $this->$tafura->primaryKey => $id, $tafura.'.type' => 0));
        $file = $this->$tafura->find('first', $options);

        //Get the meeting name
        $this->loadModel('Meeting');
        $options1 = array('conditions' => array('Meeting.' . $this->Meeting->primaryKey => $file[$tafura]['meeting_id'], 'Meeting.type' => 0));
        $meeting  = $this->Meeting->find('first', $options1);


        //Get the user details
        $this->loadModel('User');
        $options2 = array('conditions' => array('User.' . $this->User->primaryKey => $file[$tafura]['user_id']));
        $uploader = $this->User->find('first', $options2);

        //Get the council details
        $this->loadModel('User');
        $options3 = array('conditions' => array('User.' . $this->User->primaryKey => $this->Auth->user('id')));
        $counsior = $this->User->find('first', $options3);

        $filename      = $file[$tafura]['document_name'];
        $meetingName   = $meeting['Meeting']['name'];
        $counsior_name = $counsior['User']['fname']." ".$counsior['User']['sname'];

        //Send the email to the uploader
        $Email = new CakeEmail();

        $who = "Councillor";

        if( $this->Auth->user()['user_type_id'] == 3)
        {
            $who = "CEO/Municipal Manager";
        }


        if( $this->Auth->user()['user_type_id'] == 2)
        {
            $who = "CFO";
        }

    $subject = $who." could not download this document ".$filename;
        //Send the notification to the logged in user.
        $Email->from(array('no-reply@matjhabeng.com' => 'Matjhabeng Local Municipality Document Management System'))
            ->template('cantdownload', 'default')
            ->emailFormat('html')
            ->viewVars(array('filename' => $filename, 'meetingname' => $meetingName, 'counsilorname' => $counsior_name, 'email' => $counsior['User']['email'], 'who' => $who))
            ->to($uploader['User']['email'])
            ->bcc('maffins@gmail.com')
            ->subject($subject)
            ->send();

        $this->set('filename', $filename);
        $this->set('meetingName', $meetingName);
        $this->set('uploaderName', $uploader['User']['fname']." ".$uploader['User']['sname']);

        $this->loadModel('AuditTrail');
        $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
        $auditTrail['AuditTrail']['event_description'] = "Tried to view document ".$docname." with id ".$id." item ".$directory." ".$_SERVER['REMOTE_ADDR']." But was not successful";

        $auditTrail['AuditTrail']['contents'] = "tried to view document with id ".$id." item ".$directory." ".$_SERVER['REMOTE_ADDR'];
        if( !$this->AuditTrail->save($auditTrail))
        {
            die('There was a problem trying to save the audit trail for viewing counsiler document');
        }

    }



    /**
     * add more documents to an existing meeting method
     *
     * @return void
     */

    public function addmore($meet_id) {


        if ($this->request->is('post')) {

            ini_set('upload_max_filesize', '20M');

            $meeting_id = $this->request->data['CounsilorDocument']['meeting_id'];


            //First save the meeting agenda
            $this->loadModel('MeetingNotice');
            $noticeDocuments = $this->request->data['CounsilorDocument']['notice'];
            $noticeDetails = [];

            foreach ($noticeDocuments as $upload) {
                $this->MeetingNotice->create();

                if ($meeting_id) {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'notice' . DS . $file['name']);
                    //prepare the filename for database entry
                    $noticeDetails['MeetingNotice']['original_name'] = $original_name;
                    $noticeDetails['MeetingNotice']['document_name'] = $file['name'];
                } else {
                    $noticeDetails['MeetingNotice']['document_name'] = 'No Document';
                }


                $noticeDetails['MeetingNotice']['user_id'] = $this->Auth->user('id');
                $noticeDetails['MeetingNotice']['meeting_id'] = $meeting_id;

                if ($this->MeetingNotice->save($noticeDetails)) {

                    $this->Flash->success(__('Uploaded successfuly.'));

                } else {
                    die('Cannot save the notice');
                }
            }

						//First save the meeting agenda
						$this->loadModel('MeetingAddendum');
						$addendumDocuments = $this->request->data['CounsilorDocument']['addendum'];
						$addendumDetails = [];

						foreach ($addendumDocuments as $upload) {
								$this->MeetingNotice->create();

								if ($meeting_id) {
										$file = $upload;//put the data into a var for easy use
										$original_name = $file['name'];
										$file['name'] = preg_replace('/\s+/', '_', $file['name']);
										move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'addendum' . DS . $file['name']);
										//prepare the filename for database entry
										$addendumDetails['MeetingAddendum']['original_name'] = $original_name;
										$addendumDetails['MeetingAddendum']['document_name'] = $file['name'];
								} else {
										$addendumDetails['MeetingAddendum']['document_name'] = 'No Document';
								}


								$addendumDetails['MeetingAddendum']['user_id'] = $this->Auth->user('id');
								$addendumDetails['MeetingAddendum']['meeting_id'] = $meeting_id;

								if ($this->MeetingAddendum->save($addendumDetails)) {

										$this->Flash->success(__('Uploaded successfuly.'));

								} else {
										die('Cannot save the addendum');
								}
						}

            //First save the meeting agenda
            $this->loadModel('MeetingAgenda');
            $agendaDocuments = $this->request->data['CounsilorDocument']['agenda'];
            $agendaDetails = [];

            foreach ($agendaDocuments as $upload) {
                $this->MeetingAgenda->create();

                if ($meeting_id) {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'agenda' . DS . $file['name']);
                    //prepare the filename for database entry
                    $agendaDetails['MeetingAgenda']['original_name'] = $original_name;
                    $agendaDetails['MeetingAgenda']['document_name'] = $file['name'];
                } else {
                    $agendaDetails['MeetingAgenda']['document_name'] = 'No Document';
                }


                $agendaDetails['MeetingAgenda']['user_id'] = $this->Auth->user('id');
                $agendaDetails['MeetingAgenda']['meeting_id'] = $meeting_id;

                if ($this->MeetingAgenda->save($agendaDetails)) {

                    $this->Flash->success(__('Uploaded successfuly.'));

                } else {
                    die('Cannot save the agenda');
                }
            }

            //First save the meeting previous minutes
            $this->loadModel('MeetingMinute');
            $minutesDocuments = $this->request->data['CounsilorDocument']['minutes'];
            $minutesDetails = [];

            foreach ($minutesDocuments as $upload) {
                $this->MeetingMinute->create();

                if ($meeting_id) {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'minutes' . DS . $file['name']);
                    //prepare the filename for database entry
                    $minutesDetails['MeetingMinute']['document_name'] = $file['name'];
                    $minutesDetails['MeetingMinute']['original_name'] = $original_name;
                } else {
                    $minutesDetails['MeetingMinute']['document_name'] = 'No Document';
                }


                $minutesDetails['MeetingMinute']['user_id'] = $this->Auth->user('id');
                $minutesDetails['MeetingMinute']['meeting_id'] = $meeting_id;

                if ($this->MeetingMinute->save($minutesDetails)) {

                    $this->Flash->success(__('Uploaded successfuly.'));

                } else {
                    die('Cannot save the minutes');
                }
            }

            //First save the meeting items
            $this->loadModel('MeetingItem');
            $itemsDocuments = $this->request->data['CounsilorDocument']['items'];
            $itemsDetails = [];

            foreach ($itemsDocuments as $upload) {
                $this->MeetingItem->create();

                if ($meeting_id) {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'items' . DS . $file['name']);
                    //prepare the filename for database entry
                    $itemsDetails['MeetingItem']['document_name'] = $file['name'];
                    $itemsDetails['MeetingItem']['original_name'] = $original_name;
                } else {
                    $itemsDetails['MeetingItem']['document_name'] = 'No Document';
                }


                $itemsDetails['MeetingItem']['user_id'] = $this->Auth->user('id');
                $itemsDetails['MeetingItem']['meeting_id'] = $meeting_id;

                if ($this->MeetingItem->save($itemsDetails)) {

                    $this->Flash->success(__('Uploaded successfuly.'));

                } else {
                    die('Cannot save the items');
                }
            }

            //First save the meeting attachments
            $this->loadModel('MeetingAttachment');
            $attachmentDocuments = $this->request->data['CounsilorDocument']['attachments'];
            $attachmentDetails = [];

            foreach ($attachmentDocuments as $upload) {
                $this->MeetingAttachment->create();

                if ($meeting_id) {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'attachments' . DS . $file['name']);
                    //prepare the filename for database entry
                    $attachmentDetails['MeetingAttachment']['document_name'] = $file['name'];
                    $attachmentDetails['MeetingAttachment']['original_name'] = $original_name;
                } else {
                    $attachmentDetails['MeetingAttachment']['document_name'] = 'No Document';
                }


                $attachmentDetails['MeetingAttachment']['user_id'] = $this->Auth->user('id');
                $attachmentDetails['MeetingAttachment']['meeting_id'] = $meeting_id;

                if ($this->MeetingAttachment->save($attachmentDetails)) {

                    $this->Flash->success(__('Uploaded successfuly.'));

                } else {
                    die('Cannot save the attachments');
                }
            }


            //First save the meeting separate covers
            $this->loadModel('MeetingSeparatecover');
            $separateCoversDocuments = $this->request->data['CounsilorDocument']['separatecovers'];
            $separeCoverDetails = [];

            foreach ($separateCoversDocuments as $upload) {
                $this->MeetingSeparatecover->create();

                if ($meeting_id) {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'separateCovers' . DS . $file['name']);
                    //prepare the filename for database entry
                    $separeCoverDetails['MeetingSeparatecover']['document_name'] = $file['name'];
                    $separeCoverDetails['MeetingSeparatecover']['original_name'] = $original_name;
                } else {
                    $separeCoverDetails['MeetingSeparatecover']['document_name'] = 'No Document';
                }


                $separeCoverDetails['MeetingSeparatecover']['user_id'] = $this->Auth->user('id');
                $separeCoverDetails['MeetingSeparatecover']['meeting_id'] = $meeting_id;

                if ($this->MeetingSeparatecover->save($separeCoverDetails)) {

                    $this->Flash->success(__('Uploaded successfuly.'));

                } else {
                    die('Cannot save the separate covers documents');
                }
            }

            //First save the meeting addendum
            $this->loadModel('MeetingAddendum');
            $addendumDocuments = $this->request->data['CounsilorDocument']['addendum'];
            $addendumDetails = [];

            foreach( $addendumDocuments as $upload)
            {
                $this->MeetingAddendum->create();

                if ($meetingName) {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'addendum' . DS . $file['name']);
                    //prepare the filename for database entry
                    $addendumDetails['MeetingAddendum']['original_name'] = $original_name;
                    $addendumDetails['MeetingAddendum']['document_name'] = $file['name'];
                } else {
                    $addendumDetails['MeetingAddendum']['document_name'] = 'No Document';
                }

                $addendumDetails['MeetingAddendum']['user_id'] = $this->Auth->user('id');
                $addendumDetails['MeetingAddendum']['meeting_id'] = $meeting_id;
                $addendumDetails['MeetingAddendum']['type'] = 0;

                if ($this->MeetingAddendum->save($addendumDetails)) {

                    $this->Flash->success(__('Uploaded addendum successfuly.'));

                } else {
                    die('Cannot save the addendum');
                }
            }

            $this->loadModel('AuditTrail');
            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Adding more documeents to cousiler document " . $_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "Adding more documenents counsiler document " . $_SERVER['REMOTE_ADDR'];
            if (!$this->AuditTrail->save($auditTrail)) {
                die('There was a problem trying to save the audit trail for adding counsiler document');
            }


            $this->Flash->success(__('Documents added to meeting successfuly.'));
            return $this->redirect(array('action' => 'index'));


            $this->loadModel('AuditTrail');
            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Adding more documents " . $_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "adding more documents page " . $_SERVER['REMOTE_ADDR'];
            if (!$this->AuditTrail->save($auditTrail)) {
                die('There was a problem trying to save the audit trail for editing counsiler document');
            }
        }

     $this->loadModel('Meeting');

     if (!$this->Meeting->exists($meet_id)) {
         throw new NotFoundException(__('Invalid meeting'));
     }
     $options = array('conditions' => array('Meeting.' . $this->Meeting->primaryKey => $meet_id, 'Meeting.type' => 0));

     $theMeeting = $this->Meeting->find('all', $options);


     $users = $this->CounsilorDocument->User->find('list');
        $this->set(compact('users'));
        $this->set('meeting_id', $meet_id);
        $this->set('Meeting', $theMeeting);
    }

    public function addminutes($meeting_id)
    {
        $this->loadModel('Meeting');

        if ($this->request->is('post')) {

            ini_set('upload_max_filesize', '20M');

            $attachmentDocuments = $this->request->data['CounsilorDocument']['minutes'];

            $file = $attachmentDocuments;//put the data into a var for easy use
            $original_name = $file['name'];
            $file['name'] = preg_replace('/\s+/', '_', $file['name']);
            move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'meeting_minutes' . DS . $file['name']);
            //prepare the filename for database entry
            $meetingMinutes['Meeting']['minutes'] = $file['name'];
            $meetingMinutes['Meeting']['minutes_og_meeting'] = $original_name;
            $meetingMinutes['Meeting']['minutes_created'] = date('Y-m-d');

            $this->Meeting->id = $this->request->data['CounsilorDocument']['id'];

            if ($this->Meeting->save($meetingMinutes)) {

                $this->Flash->success(__('The current meeting have been added successfuly.'));

                //Now before returning to the home pate send out email and sms notification.
                /*
                 * Now that the upload was successful
                 * Time to send the sms notifications.
                 */
                $this->loadModel('User');
                $users = $this->User->find('all', array('conditions'=>array('User.user_type_id' => 9) ));

                $thedetails = [];
                $torecive   = [];
                $numbers    = "";

                $smsText = urlencode("Council <?php echo __('Meeting minutes are posted. Please login to'); ?> https://trustconetest.co.za/users/login to view documents.");

                foreach ($users as $user)
                {
                    $thedetails['name']       = $user['User']['fname'].' '.$user['User']['sname'];
                    $thedetails['cellnumber'] = $user['User']['cellnumber'];
                    //$thedetails['email']      = $user['User']['email'];
                    $thedetails['email']      = 'maffins@gmail.com';
                    $thedetails['email']      = 'mapaepae@gmail.com';

                    $torecive[] = $thedetails;

                    $thedetails = [];
                }

                $Email = new CakeEmail();

                //Now loop and send the text messages

                foreach ($torecive as $reciever)
                {
                    if(strlen($reciever['cellnumber']) == 11)
                    {
                        $numbers .= $reciever['cellnumber'].',';
                    }

                    //AS we loop and buld the list of numbers to recieve sms, send emails as well

                    $subject = "Council Meeting minutes posted";

                    $Email->from(array('no-reply@matjhabeng.com' => 'Matjhabeng Local Municipality Document Management System'))
                        ->template('newminutesposted', 'default')
                        ->emailFormat('html')
                        ->viewVars(array('meeting' => 'Council'))
                        ->to($reciever['email'])
                        ->bcc('maffins@gmail.com')
                        ->subject($subject)
                        ->send();
                }

                //This is for sending emails to others not part of counciler user type
                //$this->sendemail();

                //$numbers = '27635866058,27823087961,';
                if($numbers != ',')
                {
                    $numbers = substr($numbers, 0, -1);

                    //$numbers = $numbers."27714035216,27823087961,27716799290,27722475486,27716078080,27716864487,27828822416,27716078170,27767907601,27825583161";

                    $url = "http://148.251.196.36/app/smsapi/index.php?key=58e35a737fb7d&type=text&contacts={$numbers}&senderid=Matjabheng&msg={$smsText}&time=";

                    // echo $url."<br /><br />";

                     $mystring = $this->get_data($url);

                    //echo $mystring; die;

                }


                return $this->redirect(array('action' => 'index'));

            } else {
                die('Cannot save the agenda');
            }
        }


        if (!$this->Meeting->exists($meeting_id)) {
            throw new NotFoundException(__('Invalid meeting'));
        }
        $options = array('conditions' => array('Meeting.' . $this->Meeting->primaryKey => $meeting_id, 'Meeting.type' => 0));

        $theMeeting = $this->Meeting->find('all', $options);


        $users = $this->CounsilorDocument->User->find('list');
        $this->set(compact('users'));
        $this->set('meeting_id', $meeting_id);
        $this->set('Meeting', $theMeeting);
    }
}
