<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Notices Controller
 *
 * @property Notices $Notices
 * @property PaginatorComponent $Paginator
 */
class NoticesController extends AppController {

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
					$message = $this->request->data['Notices']['message'];
					$subject = $this->request->data['Notices']['subject'];

					if(!$subject)
					{
						$subject = "A Notice is hereby posted for your attention.";
					}
					if(!$message)
					{
						$message = "A Notice is hereby posted for your attention. Please login to http://trustconetest.co.za/users/login to view it.";
					}
					if($this->request->data['Notices']['sendemail']){
	 						$this->sendemail($message, $subject );
					}
					if($this->request->data['Notices']['sendsms']){
						 $this->sendsms($message);
				  }

					$this->Session->setFlash(__('Your messages have been sent.'), 'default', array('class' => 'alert alert-success'));

					return $this->redirect(array('Controller' => 'Notices', 'action' => 'committeedetails'));
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
			$subject = "A Notice is hereby posted for your attention.";
		}
		if(!$message)
		{
			$message = "A Notice is hereby posted for your attention. Please login to http://trustconetest.co.za/users/login to view it.";
		}
		//Build an array of attachments
		$attachments = [];
		foreach ($data['Notices']['files'] as $value) {
			$attachments[$value['name']] = $value['tmp_name'];
		}

		foreach ($users as $user) {
				if (in_array(161, unserialize($user['User']['permissions']))) {
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

	 $allmeetings = $this->Meeting->find('all', ['fields'=>'DISTINCT name, idcounter, created, user_id, minutes, minutes_created, minutes_og_meeting', 'conditions'=>['Meeting.type' => 24], 'order' => ['id' => 'DESC']]);
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


public function sendFile($id) {

    $options = array('conditions' => array('Notice.' . $this->Notice->primaryKey => $id));
    $file = $this->Notice->find('first', $options);

    $path = '/webroot/uploads/notices/'.$file['Notice']['document_name'];


    //echo $path;die;
    $this->response->file(
                            $path,
                            [
                                'download' => true,
                                'name' => $file['notice']['document_name']
                            ]
    );
    // Return response object to prevent controller from trying to render
    // a view

    $this->loadModel('AuditTrail');
    $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
    $auditTrail['AuditTrail']['event_description'] = "Opened to view document with id ".$id." item Notice ".$_SERVER['REMOTE_ADDR'];

    $auditTrail['AuditTrail']['contents'] = "Opened to view document with id ".$id." item Notice ".$_SERVER['REMOTE_ADDR'];
    if( !$this->AuditTrail->save($auditTrail))
    {
        die('There was a problem trying to save the audit trail for viewing counsiler notice document');
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
		 $options = array('conditions' => array('Meeting.' . $this->Meeting->primaryKey => $id, 'Meeting.type' => 24));
		 // $options = array('conditions' => array('MeetingAgenda.type' => 1));

		 $theMeeting = $this->Meeting->find('all', $options);

		 /*
			* This is for the notice documents
			*/
		 $options1 = array('conditions' => array('Notice.meeting_id' => $id));

		 $notices = $this->Notice->find('all', $options1);

		 $this->set('Notice', $notices);
		 $this->set('Meeting', $theMeeting[0]);

		 $this->loadModel('AuditTrail');
		 $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
		 $auditTrail['AuditTrail']['event_description'] = "Viewing the meeting details counsilor notice meeting id ".$id." ip ".$_SERVER['REMOTE_ADDR'];

		 $auditTrail['AuditTrail']['contents'] = "Viewing the meeting details counsiler notice meeting id ".$id." ".$_SERVER['REMOTE_ADDR'];
		 if( !$this->AuditTrail->save($auditTrail))
		 {
				 die('There was a problem trying to save the audit trail for viewing Council document');
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

			$this->loadModel('Meeting');
			$meeting = [];
			$meeting['Meeting']['user_id'] = $this->Auth->user('id');
			$meeting['Meeting']['type']    = 24;
			$meeting['Meeting']['name']    = $meetingName = $this->request->data['Notice']['meeting'];

			//Before saving the meeting, get the previous id counter and increment it then save.
			//Retrieve it and most important is the type when retrieving then afterwards simply add 1
			$previousMeeting = $this->Meeting->find('first', array('conditions' => array('Meeting.type' => 24),
																							'order' => array('Meeting.id' => 'DESC') ));
			// print_r($previousMeeting);die;

			$meeting['Meeting']['idcounter'] = $previousMeeting['Meeting']['idcounter']+1;

			$this->Meeting->save($meeting);
			$meeting_id = $this->Meeting->getLastInsertId();

            $NoticeDocuments = $this->request->data['Notice']['notice'];
            $NoticeDetails = [];

            foreach( $NoticeDocuments as $upload)
            {
                $this->Notice->create();

                if ($meetingName) {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'notices' . DS . $file['name']);
                    //prepare the filename for database entry
                    $NoticeDetails['Notice']['original_name'] = $original_name;
                    $NoticeDetails['Notice']['document_name'] = $file['name'];
                } else {
                    $NoticeDetails['Notice']['document_name'] = 'No Document';
                }

                $NoticeDetails['Notice']['user_id']    = $this->Auth->user('id');
                $NoticeDetails['Notice']['meeting_id'] = $meeting_id;

                if ($this->Notice->save($NoticeDetails)) {

                    $this->Flash->success(__('Uploaded notices successfuly.'));

                } else {
                    die('Cannot save the notice');
                }
            }

            $this->loadModel('AuditTrail');
            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Adding a cousiler notic document ".$_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "Adding a counsiler notice document ".$_SERVER['REMOTE_ADDR'];
            if( !$this->AuditTrail->save($auditTrail))
            {
                die('There was a problem trying to save the audit trail for adding counsiler document');
            }

            //This is for sending emails to others not part of counciler user type
            $this->sendsms();
            $this->sendemail();

            $this->Flash->success(__('Uploaded successfuly.'));
            return $this->redirect(array('action' => 'index'));
		}

        $this->loadModel('AuditTrail');
        $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
        $auditTrail['AuditTrail']['event_description'] = "Open the add cousiler notice add page ".$_SERVER['REMOTE_ADDR'];

        $auditTrail['AuditTrail']['contents'] = "Open the add cousiler notice document page ".$_SERVER['REMOTE_ADDR'];
        if( !$this->AuditTrail->save($auditTrail))
        {
            die('There was a problem trying to save the audit trail for editing counsiler notice document');
        }

		$this->loadModel('User');
		$users = $this->User->find('list');
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
					if( in_array(161, unserialize($user['User']['permissions'])) )
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

			$numbers .= '27817548884';
			//$numbers = '27635866058';
//echo $numbers;die;
			if(!$message)
			{
				$message = "A Notice is hereby posted for your attention. Please login to http://trustconetest.co.za/users/login to view it.";
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
					$subject = "A Notice is hereby posted for your attention.";
			  }
				if(!$message)
				{
					$message = "A Notice is hereby posted for your attention. Please login to http://trustconetest.co.za/users/login to view it.";
				}
        foreach ($users as $user) {
            if (in_array(161, unserialize($user['User']['permissions']))) {
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
		if ($this->request->is('post')) {

						ini_set('upload_max_filesize', '40M');
						$this->loadModel('Meeting');
						$meeting = [];

						$meeting['Notice']['user_id'] = $this->Auth->user('id');
						$meeting['Notice']['type']    = 24;
						$meeting['Notice']['name']    = $meetingName = $this->request->data['Notices']['meeting'];

						$this->Meeting->save($meeting);
						$meeting_id = $this->Meeting->getLastInsertId();

						$NoticeDocuments = $this->request->data['Notices']['documents'];
						$NoticeDetails = [];

						foreach( $NoticeDocuments as $upload)
						{
								$this->Notice->create();

								if ($meetingName) {
										$file = $upload;//put the data into a var for easy use
										$original_name = $file['name'];
										$file['name'] = preg_replace('/\s+/', '_', $file['name']);
										move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'addendum' . DS . $file['name']);
										//prepare the filename for database entry
										$NoticeDetails['Notice']['original_name'] = $original_name;
										$NoticeDetails['Notice']['document_name'] = $file['name'];
								} else {
										$NoticeDetails['Notice']['document_name'] = 'No Document';
								}

								$NoticeDetails['Notice']['user_id']    = $this->Auth->user('id');
								$NoticeDetails['Notice']['meeting_id'] = $meeting_id;

								if ($this->Notice->save($NoticeDetails)) {

										$this->Flash->success(__('Uploaded notices successfuly.'));

								} else {
										die('Cannot save the notice');
								}
						}

						$this->loadModel('AuditTrail');
						$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
						$auditTrail['AuditTrail']['event_description'] = "Adding a cousiler notic document ".$_SERVER['REMOTE_ADDR'];

						$auditTrail['AuditTrail']['contents'] = "Adding a counsiler notice document ".$_SERVER['REMOTE_ADDR'];
						if( !$this->AuditTrail->save($auditTrail))
						{
								die('There was a problem trying to save the audit trail for adding counsiler document');
						}

						//This is for sending emails to others not part of counciler user type
						//$this->sendsms();
						//$this->sendemail();

						$this->Flash->success(__('Uploaded successfuly.'));
						return $this->redirect(array('action' => 'index'));
		}

				$this->loadModel('AuditTrail');
				$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
				$auditTrail['AuditTrail']['event_description'] = "Open the add cousiler notice add page ".$_SERVER['REMOTE_ADDR'];

				$auditTrail['AuditTrail']['contents'] = "Open the add cousiler notice document page ".$_SERVER['REMOTE_ADDR'];
				if( !$this->AuditTrail->save($auditTrail))
				{
						die('There was a problem trying to save the audit trail for editing counsiler notice document');
				}

		$users = $this->Notices->User->find('list');
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
		$this->Notices->id = $id;
		if (!$this->Notices->exists()) {
			throw new NotFoundException(__('Invalid counsilor notice document'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Notices->delete()) {
			$this->Session->setFlash(__('The counsilor notice document has been deleted.'), 'default', array('class' => 'alert alert-success'));

            $this->loadModel('AuditTrail');

            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Deleting a cousiler notice document with id {$id} and ip ".$_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "Deleting a cousiler notice document ".$_SERVER['REMOTE_ADDR'];
            if( !$this->AuditTrail->save($auditTrail))
            {
                die('There was a problem trying to save the audit trail for adding counsiler document');
            }

        } else {
			$this->Session->setFlash(__('The counsilor notice document could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));

            $this->loadModel('AuditTrail');

            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Attempted to delete a cousiler notice document ".$id." ip ".$_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "Attempted to delete a cousiler notice document";
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

        $tafura    = "Notice";
        $directory = "notices";
        $docname   = "Counsilor Notice Meeting";


        $options = array('conditions' => array($tafura.'.' . $this->$tafura->primaryKey => $id));
        $file = $this->$tafura->find('first', $options);

        //Get the meeting name
        $this->loadModel('Meeting');
        $options1 = array('conditions' => array('Meeting.' . $this->Meeting->primaryKey => $file[$tafura]['meeting_id'], 'Meeting.type' => 24));
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

        $who = "Cousilor";


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

            ini_set('upload_max_filesize', '40M');

            $meeting_id = $this->request->data['Notices']['meeting_id'];

            //First save the meeting agenda
            $noticeDocuments = $this->request->data['Notices']['notice'];
            $noticeDetails = [];

            foreach ($noticeDocuments as $upload) {
                $this->MeetingNotice->create();

                if ($meeting_id) {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'notices' . DS . $file['name']);
                    //prepare the filename for database entry
                    $noticeDetails['Notice']['original_name'] = $original_name;
                    $noticeDetails['Notice']['document_name'] = $file['name'];
                } else {
                    $noticeDetails['Notice']['document_name'] = 'No Document';
                }


                $noticeDetails['Notice']['user_id'] = $this->Auth->user('id');
                $noticeDetails['Notice']['meeting_id'] = $meeting_id;

                if ($this->Notice->save($noticeDetails)) {

                    $this->Flash->success(__('Uploaded cousilor notice successfuly.'));

                } else {
                    die('Cannot save the cousilor notice documents');
                }
            }

            $this->loadModel('AuditTrail');
            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Adding more documeents to cousiler notice document " . $_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "Adding more documenents counsiler notice document " . $_SERVER['REMOTE_ADDR'];
            if (!$this->AuditTrail->save($auditTrail)) {
                die('There was a problem trying to save the audit trail for adding counsiler notice document');
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


     $users = $this->Notice->User->find('list');
        $this->set(compact('users'));
        $this->set('meeting_id', $meet_id);
        $this->set('Meeting', $theMeeting);
    }

  }
