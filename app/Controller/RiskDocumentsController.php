<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * RiskDocuments Controller
 *
 * @property RiskDocument $RiskDocument
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class RiskDocumentsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'Session');

	public function viewmembers() {

		$this->loadModel('User');
		$users = $this->User->find('all');
		$allmembers = [];

		foreach ($users as $user)
		{
				if( in_array(82, unserialize($user['User']['permissions'])) )
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
					$message = $this->request->data['RiskDocument']['message'];
					$subject = $this->request->data['RiskDocument']['subject'];

					if(!$subject)
					{
						$subject = "RISK MANAGEMENT COMMITTEE Meeting documents are posted.";
					}
					if(!$message)
					{
						$message = "RISK MANAGEMENT COMMITTEE Meeting documents are posted. Please login to http://trustconetest.co.za/users/login to view documents.";
					}

					if($this->request->data['RiskDocument']['sendsms']){
						 $this->sendsms($message);
					}
					if($this->request->data['RiskDocument']['sendemail']){
						 $this->sendemail($message, $subject);
					}
					$this->Session->setFlash(__('Your messages have been sent.'), 'default', array('class' => 'alert alert-success'));

					return $this->redirect(array('Controller' => 'RiskDocument', 'action' => 'committeedetails'));
			}
		}


/**
 * index method
 *
 * @return void
 */
public function index() {

		$this->loadModel('Meeting');

		$allmeetings = $this->Meeting->find('all', ['fields'=>'DISTINCT name, idcounter, created, user_id', 'conditions'=>['Meeting.type' => 23]]);
		$this->set('meetings', $allmeetings);

		$this->set('usertype', $this->Auth->user()['user_type_id']);
		$this->loadModel('AuditTrail');

		$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
		$auditTrail['AuditTrail']['event_description'] = "Opened the meetings page ".$_SERVER['REMOTE_ADDR'];

		$auditTrail['AuditTrail']['contents'] = "Opened the meetings page ".$_SERVER['REMOTE_ADDR'];
		if( !$this->AuditTrail->save($auditTrail))
		{
				die('There was a problem trying to save the audit trail for viewing all Risk documents');
		}
}

public function sendFile($id, $which) {

		$tafura    = "";
		$directory = "";

		if($which == 1)
		{
				$this->loadModel('MeetingAgenda');
				$tafura    = "MeetingAgenda";
				$directory = "risk_agenda";
		}

		if($which == 2)
		{
				$this->loadModel('MeetingMinute');
				$tafura    = "MeetingMinute";
				$directory = "risk_minutes";
		}

		if($which == 3)
		{
				$this->loadModel('MeetingItem');
				$tafura    = "MeetingItem";
				$directory = "risk_items";
		}

		if($which == 4)
		{
				$this->loadModel('MeetingAttachment');
				$tafura    = "MeetingAttachment";
				$directory = "risk_attachments";
		}

		if($which == 5)
		{
				$this->loadModel('MeetingSeparatecover');
				$tafura    = "MeetingSeparatecover";
				$directory = "risk_separateCovers";
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
				$directory = "risk_notice";
		}

		if($which == 8)
		{
				$this->loadModel('MeetingAddendum');
				$tafura    = "MeetingAddendum";
				$directory = "risk_addendum";
		}

		$options = array('conditions' => array($tafura.'.' . $this->$tafura->primaryKey => $id, $tafura.'.type' => 23));
		$file = $this->$tafura->find('first', $options);
		$path = '/webroot/uploads/'.$directory.'/'.$file[$tafura]['document_name'];
		// echo $path;die;
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

		$auditTrail['AuditTrail']['contents'] = "Opened to view Risk document with id ".$id." item ".$directory." ".$_SERVER['REMOTE_ADDR'];
		if( !$this->AuditTrail->save($auditTrail))
		{
				die('There was a problem trying to save the audit trail for viewing Risk document');
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
		$options = array('conditions' => array('Meeting.' . $this->Meeting->primaryKey => $id, 'Meeting.type' => 23));
		// $options = array('conditions' => array('MeetingAgenda.type' => 23));

		$theMeeting = $this->Meeting->find('all', $options);

		/*
		 * This is for the agenda
		 */
		$this->loadModel('MeetingAgenda');
		$options1 = array('conditions' => array('MeetingAgenda.meeting_id' => $id, 'MeetingAgenda.type' => 23));

		$agenda = $this->MeetingAgenda->find('all', $options1);

		$this->set('usertype', $this->Auth->user()['user_type_id']);

		/*
		 * This is for the minutes
		 */
		$this->loadModel('MeetingMinutes');
		$options2 = array('conditions' => array('MeetingMinutes.meeting_id' => $id, 'MeetingMinutes.type' => 23));

		$MeetingMinutes = $this->MeetingMinutes->find('all', $options2);

		/*
		 * This is for the items
		 */
		$this->loadModel('MeetingItems');
		$options3 = array('conditions' => array('MeetingItems.meeting_id' => $id, 'MeetingItems.type' => 23));

		$Meetingitems = $this->MeetingItems->find('all', $options3);

		/*
		 * This is for the attachments
		 */
		$this->loadModel('MeetingAttachments');
		$options4 = array('conditions' => array('MeetingAttachments.meeting_id' => $id, 'MeetingAttachments.type' => 23));

		$MeetingAttachments = $this->MeetingAttachments->find('all', $options4);

		/*
								 * This is for the separate covers
								 */
		$this->loadModel('MeetingSeparatecovers');
		$options5 = array('conditions' => array('MeetingSeparatecovers.meeting_id' => $id, 'MeetingSeparatecovers.type' => 23));

		$MeetingSeparateCovers = $this->MeetingSeparatecovers->find('all', $options5);

		$this->set('usertype', $this->Auth->user()['user_type_id']);

		$this->set('MeetingSeparatecovers', $MeetingSeparateCovers);
		/*
		 * This is for the the notice
		 */
		$this->loadModel('MeetingNotice');
		$options6 = array('conditions' => array('MeetingNotice.meeting_id' => $id, 'MeetingNotice.type' => 23));

		$Notices = $this->MeetingNotice->find('all', $options6);

		/*
		 * This is for the the addendum
		 */
		$this->loadModel('MeetingAddendum');
		$options7 = array('conditions' => array('MeetingAddendum.meeting_id' => $id, 'MeetingAddendum.type' => 23));

		$Addendums = $this->MeetingAddendum->find('all', $options7);

		$this->set('usertype', $this->Auth->user()['user_type_id']);

		$this->set('Addendums', $Addendums);
		$this->set('Notice', $Notices);
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
				die('There was a problem trying to save the audit trail for viewing Risk document');
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
				$meeting['Meeting']['name']    = $meetingName = $this->request->data['RiskDocument']['meeting'];
				$meeting['Meeting']['type']    = 23;
				//Before saving the meeting, get the previous id counter and increment it then save.
				//Retrieve it and most important is the type when retrieving then afterwards simply add 1
				$previousMeeting = $this->Meeting->find('first', array('conditions' => array('Meeting.type' => 23),
						'order' => array('Meeting.id' => 'DESC') ));

				$meeting['Meeting']['idcounter'] = $previousMeeting['Meeting']['idcounter']+1;
				$this->Meeting->save($meeting);
				$meeting_id = $this->Meeting->getLastInsertId();

				//First save the meeting agenda
				$this->loadModel('MeetingAgenda');
				$agendaDocuments = $this->request->data['RiskDocument']['agenda'];
				$agendaDetails = [];

				foreach( $agendaDocuments as $upload)
				{
						$this->MeetingAgenda->create();

						if ($meetingName) {
								$file = $upload;//put the data into a var for easy use
								$original_name = $file['name'];
								$file['name'] = preg_replace('/\s+/', '_', $file['name']);
								move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'risk_agenda' . DS . $file['name']);
								//prepare the filename for database entry
								$agendaDetails['MeetingAgenda']['original_name'] = $original_name;
								$agendaDetails['MeetingAgenda']['document_name'] = $file['name'];
						} else {
								$agendaDetails['MeetingAgenda']['document_name'] = 'No Document';
						}


						$agendaDetails['MeetingAgenda']['user_id'] = $this->Auth->user('id');
						$agendaDetails['MeetingAgenda']['meeting_id'] = $meeting_id;
						$agendaDetails['MeetingAgenda']['type']       = 23;

						if ($this->MeetingAgenda->save($agendaDetails)) {

								$this->Flash->success(__('Uploaded successfuly.'));

						} else {
								die('Cannot save the agenda');
						}
				}

				//First save the meeting previous minutes
				$this->loadModel('MeetingMinute');
				$minutesDocuments = $this->request->data['RiskDocument']['minutes'];
				$minutesDetails = [];

				foreach( $minutesDocuments as $upload)
				{
						$this->MeetingMinute->create();

						if ($meetingName) {
								$file = $upload;//put the data into a var for easy use
								$original_name = $file['name'];
								$file['name'] = preg_replace('/\s+/', '_', $file['name']);
								move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'risk_minutes' . DS . $file['name']);
								//prepare the filename for database entry
								$minutesDetails['MeetingMinute']['document_name'] = $file['name'];
								$minutesDetails['MeetingMinute']['original_name'] = $original_name;
						} else {
								$minutesDetails['MeetingMinute']['document_name'] = 'No Document';
						}


						$minutesDetails['MeetingMinute']['user_id']    = $this->Auth->user('id');
						$minutesDetails['MeetingMinute']['meeting_id'] = $meeting_id;
						$minutesDetails['MeetingMinute']['type']       = 23;

						if ($this->MeetingMinute->save($minutesDetails)) {

								$this->Flash->success(__('Uploaded successfuly.'));

						} else {
								die('Cannot save the minutes');
						}
				}

				//First save the meeting items
				$this->loadModel('MeetingItem');
				$itemsDocuments = $this->request->data['RiskDocument']['items'];
				$itemsDetails = [];

				foreach( $itemsDocuments as $upload)
				{
						$this->MeetingItem->create();

						if ($meetingName) {
								$file = $upload;//put the data into a var for easy use
								$original_name = $file['name'];
								$file['name'] = preg_replace('/\s+/', '_', $file['name']);
								move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'risk_items' . DS . $file['name']);
								//prepare the filename for database entry
								$itemsDetails['MeetingItem']['document_name'] = $file['name'];
								$itemsDetails['MeetingItem']['original_name'] = $original_name;
						} else {
								$itemsDetails['MeetingItem']['document_name'] = 'No Document';
						}


						$itemsDetails['MeetingItem']['user_id']    = $this->Auth->user('id');
						$itemsDetails['MeetingItem']['meeting_id'] = $meeting_id;
						$itemsDetails['MeetingItem']['type']       = 23;

						if ($this->MeetingItem->save($itemsDetails)) {

								$this->Flash->success(__('Uploaded successfuly.'));

						} else {
								die('Cannot save the items');
						}
				}

				//First save the meeting attachments
				$this->loadModel('MeetingAttachment');
				$attachmentDocuments = $this->request->data['RiskDocument']['attachments'];
				$attachmentDetails = [];

				foreach( $attachmentDocuments as $upload)
				{
						$this->MeetingAttachment->create();

						if ($meetingName) {
								$file = $upload;//put the data into a var for easy use
								$original_name = $file['name'];
								$file['name'] = preg_replace('/\s+/', '_', $file['name']);
								move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'risk_attachments' . DS . $file['name']);
								//prepare the filename for database entry
								$attachmentDetails['MeetingAttachment']['document_name'] = $file['name'];
								$attachmentDetails['MeetingAttachment']['original_name'] = $original_name;
						} else {
								$attachmentDetails['MeetingAttachment']['document_name'] = 'No Document';
						}


						$attachmentDetails['MeetingAttachment']['user_id']    = $this->Auth->user('id');
						$attachmentDetails['MeetingAttachment']['meeting_id'] = $meeting_id;
						$attachmentDetails['MeetingAttachment']['type']       = 23;

						if ($this->MeetingAttachment->save($attachmentDetails)) {

								$this->Flash->success(__('Uploaded successfuly.'));

						} else {
								die('Cannot save the attachments');
						}
				}


				//First save the meeting separate covers
				$this->loadModel('MeetingSeparatecover');
				$separateCoversDocuments = $this->request->data['RiskDocument']['separatecovers'];
				$separeCoverDetails = [];

				foreach( $separateCoversDocuments as $upload)
				{
						$this->MeetingSeparatecover->create();

						if ($meetingName) {
								$file = $upload;//put the data into a var for easy use
								$original_name = $file['name'];
								$file['name'] = preg_replace('/\s+/', '_', $file['name']);
								move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'risk_separateCovers' . DS . $file['name']);
								//prepare the filename for database entry
								$separeCoverDetails['MeetingSeparatecover']['document_name'] = $file['name'];
								$separeCoverDetails['MeetingSeparatecover']['original_name'] = $original_name;
						} else {
								$separeCoverDetails['MeetingSeparatecover']['document_name'] = 'No Document';
						}

						$separeCoverDetails['MeetingSeparatecover']['user_id'] = $this->Auth->user('id');
						$separeCoverDetails['MeetingSeparatecover']['meeting_id'] = $meeting_id;
						$separeCoverDetails['MeetingSeparatecover']['type']       = 23;

						if ($this->MeetingSeparatecover->save($separeCoverDetails)) {

								$this->Flash->success(__('Uploaded successfuly.'));

						} else {
								die('Cannot save the separate covers documents');
						}
				}

				//First save the meeting addendum
				$this->loadModel('MeetingAddendum');
				$addendumDocuments = $this->request->data['RiskDocument']['addendum'];
				$addendumDetails = [];

				foreach( $addendumDocuments as $upload)
				{
						$this->MeetingAddendum->create();

						if ($meetingName) {
								$file = $upload;//put the data into a var for easy use
								$original_name = $file['name'];
								$file['name'] = preg_replace('/\s+/', '_', $file['name']);
								move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'risk_addendum' . DS . $file['name']);
								//prepare the filename for database entry
								$addendumDetails['MeetingAddendum']['original_name'] = $original_name;
								$addendumDetails['MeetingAddendum']['document_name'] = $file['name'];
						} else {
								$addendumDetails['MeetingAddendum']['document_name'] = 'No Document';
						}

						$addendumDetails['MeetingAddendum']['user_id'] = $this->Auth->user('id');
						$addendumDetails['MeetingAddendum']['meeting_id'] = $meeting_id;
						$addendumDetails['MeetingAddendum']['type']       = 23;

						if ($this->MeetingAddendum->save($addendumDetails)) {

								$this->Flash->success(__('Uploaded notice successfuly.'));

						} else {
								die('Cannot save the notice');
						}
				}

				$this->loadModel('AuditTrail');
				$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
				$auditTrail['AuditTrail']['event_description'] = "Adding a Risk document ".$_SERVER['REMOTE_ADDR'];

				$auditTrail['AuditTrail']['contents'] = "Adding a Risk document ".$_SERVER['REMOTE_ADDR'];
				if( !$this->AuditTrail->save($auditTrail))
				{
						die('There was a problem trying to save the audit trail for adding Risk document');
				}

        $notifications = $this->request->data['RiskDocument']['notifications'];
        unset($this->request->data['RiskDocument']['notifications']);

        $sendemail = $this->request->data['RiskDocument']['sendemail'];
        unset($this->request->data['RiskDocument']['sendemail']);

        $sendsms = $this->request->data['RiskDocument']['sendsms'];
        unset($this->request->data['RiskDocument']['sendsms']);

        //This is for sending emails to others not part of counciler user type
        if($notifications) {
          if($sendsms) {
            $this->sendsms($this->request->data['RiskDocument']['message']);
          }
          if($sendemail) {
            $this->sendemail($this->request->data['RiskDocument']['message'], $this->request->data['RiskDocument']['subject']);
          }
        }else {
					$this->sendsms();
					$this->sendemail();
				}

				$this->Flash->success(__('Uploaded successfuly.'));
				return $this->redirect(array('Controller' => 'RiskDocument', 'action' => 'index'));
		}

		$this->loadModel('AuditTrail');
		$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
		$auditTrail['AuditTrail']['event_description'] = "Open the add Risk add page ".$_SERVER['REMOTE_ADDR'];

		$auditTrail['AuditTrail']['contents'] = "Open the add Risk document page ".$_SERVER['REMOTE_ADDR'];
		if( !$this->AuditTrail->save($auditTrail))
		{
				die('There was a problem trying to save the audit trail for editing Risk document');
		}

		$users = $this->RiskDocument->User->find('list');
		$this->set(compact('users'));
}

/**************************************************************************************************************************/

function sendsms($message = null)
{
		$this->loadModel('User');
		$users = $this->User->find('all');

		$thedetails = [];
		$torecive   = [];
		$numbers    = "";

		if(!$message)
		{
			$message = "RISK MANAGEMENT COMMITTEE Meeting documents are posted. Please login to http://trustconetest.co.za/users/login to view documents.";
		}

		foreach ($users as $user)
		{
				if( in_array(82, unserialize($user['User']['permissions'])) )
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

		$smsText = urlencode($message);

		#$url = "http://78.46.17.110/app/smsapi/index.php?key=5bd18d48532d6&type=text&title=&contacts={$numbers}&groupid=&senderid=MAFFINS&msg={$smsText}&time=&time_zone=";
		$url = "http://148.251.196.36/app/smsapi/index.php?key=5c6d72f0f094d&type=text&contacts={$numbers}&senderid=Matjabheng&msg={$smsText}&time=";

		 $mystring = $this->get_data($url);

}


function sendemail($message = null, $subject = null)
{
		$Email = new CakeEmail();

		$this->loadModel('User');
		$users = $this->User->find('all');

		if(!$subject)
		{
			$subject = "RISK MANAGEMENT COMMITTEE Meeting documents are posted";
		}
		if(!$message)
		{
			$message = "RISK MANAGEMENT COMMITTEE Meeting documents are posted. Please login to http://trustconetest.co.za/users/login to view documents.";
		}

		foreach ($users as $user) {
				if (in_array(82, unserialize($user['User']['permissions']))) {
						$Email->from(array('no-reply@matjhabeng.co.za' => 'Matjhabeng Local Municipality Document Management System'))
								->template('newmeetingposted', 'default')
								->emailFormat('html')
								->viewVars(array('meeting' => $message))
								->to($user['User']['email'])
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
				$directory = "revenue_separateCovers";
				$docname   = "Separate covers";
		}

		if($which == 6)
		{
				$this->loadModel('Meeting');
				$tafura    = "Meeting";
				$directory = "meeting_minutes";
				$docname   = "Minutes";
		}

		if($which == 7)
		{
				$this->loadModel('MeetingNotice');
				$tafura    = "MeetingNotice";
				$directory = "risk_notice";
				$docname   = "Minutes";
		}

		if($which == 8)
		{
				$this->loadModel('MeetingAddendum');
				$tafura    = "MeetingAddendum";
				$directory = "risk_addendum";
				$docname   = "Minutes";
		}

		$options = array('conditions' => array($tafura.'.' . $this->$tafura->primaryKey => $id, $tafura.'.type' => 23));
		$file = $this->$tafura->find('first', $options);

		//Get the meeting name
		$this->loadModel('Meeting');
		$options1 = array('conditions' => array('Meeting.' . $this->Meeting->primaryKey => $file[$tafura]['meeting_id'], 'Meeting.type' => 23));
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
		$Email->from(array('no-reply@documentstracker.com' => 'Matjhabeng Local Municipality Document Management System'))
				->template('cantdownload_Risk', 'default')
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
				die('There was a problem trying to save the audit trail for viewing Risk document');
		}

}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
public function edit($id = null) {
		if (!$this->RiskDocument->exists($id)) {
				throw new NotFoundException(__('Invalid Risk document'));
		}
		if ($this->request->is(array('post', 'put'))) {
				if ($this->RiskDocument->save($this->request->data)) {
						$this->Session->setFlash(__('The Risk document has been saved.'), 'default', array('class' => 'alert alert-success'));
						return $this->redirect(array('action' => 'index'));
				} else {
						$this->Session->setFlash(__('The Risk document could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
				}
		} else {
				$options = array('conditions' => array('RiskDocument.' . $this->RiskDocument->primaryKey => $id));
				$this->request->data = $this->RiskDocument->find('first', $options);
		}
		$users = $this->RiskDocument->User->find('list');
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
		$this->RiskDocument->id = $id;
		if (!$this->RiskDocument->exists()) {
				throw new NotFoundException(__('Invalid Risk document'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->RiskDocument->delete()) {
				$this->Session->setFlash(__('The Risk document has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
				$this->Session->setFlash(__('The Risk document could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
}


/**
 * add method
 *
 * @return void
 */
public function addmore($meet_id) {

		if ($this->request->is('post')) {

				ini_set('upload_max_filesize', '20M');

				$meeting_id = $this->request->data['RiskDocument']['meeting_id'];

				//First save the meeting agenda
				$this->loadModel('MeetingAgenda');
				$agendaDocuments = $this->request->data['RiskDocument']['agenda'];
				$agendaDetails = [];

				foreach ($agendaDocuments as $upload) {
						$this->MeetingAgenda->create();

						if ($meeting_id) {
								$file = $upload;//put the data into a var for easy use
								$original_name = $file['name'];
								$file['name'] = preg_replace('/\s+/', '_', $file['name']);
								move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'risk_agenda' . DS . $file['name']);
								//prepare the filename for database entry
								$agendaDetails['MeetingAgenda']['original_name'] = $original_name;
								$agendaDetails['MeetingAgenda']['document_name'] = $file['name'];
						} else {
								$agendaDetails['MeetingAgenda']['document_name'] = 'No Document';
						}


						$agendaDetails['MeetingAgenda']['user_id'] = $this->Auth->user('id');
						$agendaDetails['MeetingAgenda']['meeting_id'] = $meeting_id;
						$agendaDetails['MeetingAgenda']['type'] = 23;

						if ($this->MeetingAgenda->save($agendaDetails)) {

								$this->Flash->success(__('Uploaded successfuly.'));

						} else {
								die('Cannot save the agenda');
						}
				}

				//First save the meeting previous minutes
				$this->loadModel('MeetingMinute');
				$minutesDocuments = $this->request->data['RiskDocument']['minutes'];
				$minutesDetails = [];

				foreach ($minutesDocuments as $upload) {
						$this->MeetingMinute->create();

						if ($meeting_id) {
								$file = $upload;//put the data into a var for easy use
								$original_name = $file['name'];
								$file['name'] = preg_replace('/\s+/', '_', $file['name']);
								move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'risk_minutes' . DS . $file['name']);
								//prepare the filename for database entry
								$minutesDetails['MeetingMinute']['document_name'] = $file['name'];
								$minutesDetails['MeetingMinute']['original_name'] = $original_name;
						} else {
								$minutesDetails['MeetingMinute']['document_name'] = 'No Document';
						}


						$minutesDetails['MeetingMinute']['user_id'] = $this->Auth->user('id');
						$minutesDetails['MeetingMinute']['meeting_id'] = $meeting_id;
						$minutesDetails['MeetingMinute']['type'] = 23;

						if ($this->MeetingMinute->save($minutesDetails)) {

								$this->Flash->success(__('Uploaded successfuly.'));

						} else {
								die('Cannot save the minutes');
						}
				}

				//First save the meeting items
				$this->loadModel('MeetingItem');
				$itemsDocuments = $this->request->data['RiskDocument']['items'];
				$itemsDetails = [];

				foreach ($itemsDocuments as $upload) {
						$this->MeetingItem->create();

						if ($meeting_id) {
								$file = $upload;//put the data into a var for easy use
								$original_name = $file['name'];
								$file['name'] = preg_replace('/\s+/', '_', $file['name']);
								move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'risk_items' . DS . $file['name']);
								//prepare the filename for database entry
								$itemsDetails['MeetingItem']['document_name'] = $file['name'];
								$itemsDetails['MeetingItem']['original_name'] = $original_name;
						} else {
								$itemsDetails['MeetingItem']['document_name'] = 'No Document';
						}


						$itemsDetails['MeetingItem']['user_id'] = $this->Auth->user('id');
						$itemsDetails['MeetingItem']['meeting_id'] = $meeting_id;
						$itemsDetails['MeetingItem']['type'] = 23;

						if ($this->MeetingItem->save($itemsDetails)) {

								$this->Flash->success(__('Uploaded successfuly.'));

						} else {
								die('Cannot save the items');
						}
				}

				//First save the meeting attachments
				$this->loadModel('MeetingAttachment');
				$attachmentDocuments = $this->request->data['RiskDocument']['attachments'];
				$attachmentDetails = [];

				foreach ($attachmentDocuments as $upload) {
						$this->MeetingAttachment->create();

						if ($meeting_id) {
								$file = $upload;//put the data into a var for easy use
								$original_name = $file['name'];
								$file['name'] = preg_replace('/\s+/', '_', $file['name']);
								move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'risk_attachments' . DS . $file['name']);
								//prepare the filename for database entry
								$attachmentDetails['MeetingAttachment']['document_name'] = $file['name'];
								$attachmentDetails['MeetingAttachment']['original_name'] = $original_name;
						} else {
								$attachmentDetails['MeetingAttachment']['document_name'] = 'No Document';
						}


						$attachmentDetails['MeetingAttachment']['user_id'] = $this->Auth->user('id');
						$attachmentDetails['MeetingAttachment']['meeting_id'] = $meeting_id;
						$attachmentDetails['MeetingAttachment']['type'] = 23;

						if ($this->MeetingAttachment->save($attachmentDetails)) {

								$this->Flash->success(__('Uploaded successfuly.'));

						} else {
								die('Cannot save the attachments');
						}
				}

				//First save the meeting separate covers
				$this->loadModel('MeetingSeparatecover');
				$separateCoversDocuments = $this->request->data['RiskDocument ']['separatecovers'];
				$separeCoverDetails = [];

				foreach ($separateCoversDocuments as $upload) {
						$this->MeetingSeparatecover->create();

						if ($meeting_id) {
								$file = $upload;//put the data into a var for easy use
								$original_name = $file['name'];
								$file['name'] = preg_replace('/\s+/', '_', $file['name']);
								move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'risk_separatecovers' . DS . $file['name']);
								//prepare the filename for database entry
								$separeCoverDetails['MeetingSeparatecover']['document_name'] = $file['name'];
								$separeCoverDetails['MeetingSeparatecover']['original_name'] = $original_name;
						} else {
								$separeCoverDetails['MeetingSeparatecover']['document_name'] = 'No Document';
						}

						$separeCoverDetails['MeetingSeparatecover']['user_id'] = $this->Auth->user('id');
						$separeCoverDetails['MeetingSeparatecover']['meeting_id'] = $meeting_id;
						$separeCoverDetails['MeetingSeparatecover']['type'] = 23;

						if ($this->MeetingSeparatecover->save($separeCoverDetails)) {

								$this->Flash->success(__('Uploaded successfuly.'));

						} else {
								die('Cannot save the separate covers documents');
						}
				}

				//First save the meeting addendum
				$this->loadModel('MeetingAddendum');
				$addendumDocuments = $this->request->data['RiskDocument']['addendum'];
				$addendumDetails = [];

				foreach( $addendumDocuments as $upload)
				{
						$this->MeetingAddendum->create();

						if ($meetingName) {
								$file = $upload;//put the data into a var for easy use
								$original_name = $file['name'];
								$file['name'] = preg_replace('/\s+/', '_', $file['name']);
								move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'risk_addendum' . DS . $file['name']);
								//prepare the filename for database entry
								$addendumDetails['MeetingAddendum']['original_name'] = $original_name;
								$addendumDetails['MeetingAddendum']['document_name'] = $file['name'];
						} else {
								$addendumDetails['MeetingAddendum']['document_name'] = 'No Document';
						}

						$addendumDetails['MeetingAddendum']['user_id'] = $this->Auth->user('id');
						$addendumDetails['MeetingAddendum']['meeting_id'] = $meeting_id;
						$addendumDetails['MeetingAddendum']['type'] = 23;

						if ($this->MeetingAddendum->save($addendumDetails)) {

								$this->Flash->success(__('Uploaded addendum successfuly.'));

						} else {
								die('Cannot save the addendum');
						}
				}

				$this->loadModel('AuditTrail');
				$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
				$auditTrail['AuditTrail']['event_description'] = "Adding a Risk document " . $_SERVER['REMOTE_ADDR'];

				$auditTrail['AuditTrail']['contents'] = "Adding a Risk document " . $_SERVER['REMOTE_ADDR'];
				if (!$this->AuditTrail->save($auditTrail)) {
						die('There was a problem trying to save the audit trail for adding Risk document');
				}


				$this->Flash->success(__('Added documents to meeting successfuly.'));
				return $this->redirect(array('Controller' => 'RiskDocument', 'action' => 'index'));


				$this->loadModel('AuditTrail');
				$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
				$auditTrail['AuditTrail']['event_description'] = "Open the add Risk add page " . $_SERVER['REMOTE_ADDR'];

				$auditTrail['AuditTrail']['contents'] = "Open the add Risk document page " . $_SERVER['REMOTE_ADDR'];
				if (!$this->AuditTrail->save($auditTrail)) {
						die('There was a problem trying to save the audit trail for editing Risk document');
				}
		}

		$this->loadModel('Meeting');
		if (!$this->Meeting->exists($meet_id)) {
				throw new NotFoundException(__('Invalid meeting'));
		}
		$options = array('conditions' => array('Meeting.' . $this->Meeting->primaryKey => $meet_id, 'Meeting.type' => 23));

		$theMeeting = $this->Meeting->find('all', $options);

		$users = $this->RiskDocument->User->find('list');
		$this->set(compact('users'));
		$this->set('meeting_id', $meet_id);
		$this->set('Meeting', $theMeeting);
}

}