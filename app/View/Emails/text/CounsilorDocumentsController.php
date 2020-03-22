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

/**
 * index method
 *
 * @return void
 */
	public function index() {
	    $this->loadModel('Meeting');

	    $allmeetings = $this->Meeting->find('all', ['fields'=>'DISTINCT name, created, user_id', 'conditions'=>['Meeting.type' => 0]]);
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

        $options = array('conditions' => array($tafura.'.' . $this->$tafura->primaryKey => $id, $tafura.'.type' => 0));
        $file = $this->$tafura->find('first', $options);
        $path = '/webroot/uploads/'.$directory.'/'.$file[$tafura]['document_name'];
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

        $this->set('usertype', $this->Auth->user()['user_type_id']);

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
            die('There was a problem trying to save the audit trail for viewing mayco document');
        }

    }


    /**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {

            ini_set('upload_max_filesize', '20M');

            //First save the meeting name
            $this->loadModel('Meeting');
            $meeting = [];

            $meeting['Meeting']['user_id'] = $this->Auth->user('id');
            $meeting['Meeting']['name']        = $meetingName = $this->request->data['CounsilorDocument']['meeting'];

            $this->Meeting->save($meeting);
            $meeting_id = $this->Meeting->getLastInsertId();

            //First save the meeting agenda
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
                $this->MeetingItem->create();

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

            $this->loadModel('AuditTrail');
            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Adding a cousiler document ".$_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "Adding a counsiler document ".$_SERVER['REMOTE_ADDR'];
            if( !$this->AuditTrail->save($auditTrail))
            {
                die('There was a problem trying to save the audit trail for adding counsiler document');
            }

            /*
             * Now that the upload was successful
             * Time to send the sms notifications.
             */
            $this->loadModel('User');
            $users = $this->User->find('all', array('conditions'=>array('User.user_type_id' => 9) ));

            $thedetails = [];
            $torecive   = [];
            $numbers    = "";

            $smsText = urlencode("Council Meeting documents are posted. Please login to http://trustconetest.co.za/users/login to view documents.");

            foreach ($users as $user)
            {
                $thedetails['name']       = $user['User']['fname'].' '.$user['User']['sname'];
                $thedetails['cellnumber'] = $user['User']['cellnumber'];
                $thedetails['email']      = $user['User']['email'];
                //$thedetails['email']      = 'maffins@gmail.com';
                //$thedetails['email']      = 'mapaepae@gmail.com';

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

                  $subject = "Council Meeting documents are posted";

                  $Email->from(array('no-reply@lejweleputswa.com' => 'Matjhabeng Local Municipality Document Management System'))
                        ->template('newmeetingposted', 'default')
                        ->emailFormat('html')
                        ->viewVars(array('meeting' => 'Council'))
                        ->to($reciever['email'])
                        ->bcc('maffins@gmail.com')
                        ->subject($subject)
                        ->send();
            }

           // $numbers = '27635866058,27823087961,';
            if($numbers != ',')
            {
                $numbers = substr($numbers, 0, -1);

                $url = "http://148.251.196.36/app/smsapi/index.php?key=58e35a737fb7d&type=text&contacts={$numbers}&senderid=Matjabheng&msg={$smsText}&time=";

               // echo $url."<br /><br />";

                $mystring = $this->get_data($url);

                //echo $mystring; die;

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
//		if (!$this->CounsilorDocument->exists($id)) {
//			throw new NotFoundException(__('Invalid counsilor document'));
//		}
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
        $Email->from(array('no-reply@lejweleputswa.com' => 'Matjhabeng Local Municipality Document Management System'))
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


}

