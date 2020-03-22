<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * OfficialDocuments Controller
 *
 * @property OfficialDocument $OfficialDocument
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class OfficialDocumentsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'Session');

/**
 * index method
 *
 * @return void
 */
public function index()
{
	$allControllers = ['0' => 'INFRASTRUCTURE', '1' => 'CORPORATE SUPPORT SERVICES', '2' => 'COMMUNITY SERVICES', '3' => 'LED', '4' => 'FINANCE',
										 '5' => 'STRATEGIC SUPPORT SERVICES', '6' => "MAYOR'S OFFICE", '7' => "SPEAKER'S OFFICE"];

	//This is for the permissions now
	$approvers = ['0' => 116, '1' => 119, '2' => 122, '3' => 125, '4' => 128, '5' => 131, '6' => 134, '7' => 137 ];

	$sribers 	 = ['0' => 115, '1' => 118, '2' => 121, '3' => 124, '4' => 127, '5' => 130, '6' => 133, '7' => 136 ];

	$this->set('alldata', $allControllers);

		//build the typs depending
		$types = "";
		foreach($approvers as $key=>$value)
		{
			if(in_array($value, unserialize($this->Auth->user()['permissions'])))
			{
				$types[] = $key;
			}
		}

		if( in_array(110, unserialize($this->Auth->user()['permissions'])) || in_array(111, unserialize($this->Auth->user()['permissions'])) || in_array(112, unserialize($this->Auth->user()['permissions'])) || in_array(113, unserialize($this->Auth->user()['permissions'])) )
		{
			if(in_array(110, unserialize($this->Auth->user()['permissions']))) {
					$tracker = 3;
					$this->set('approver', 2);
			}

			if(in_array(111, unserialize($this->Auth->user()['permissions']))) {
					$tracker = 4;
					$this->set('approver', 3);
			}

			if(in_array(112, unserialize($this->Auth->user()['permissions']))) {
					$tracker = 5;
					$this->set('approver', 4);
			}

			if(in_array(113, unserialize($this->Auth->user()['permissions']))) {
					$tracker = 6;
					$this->set('approver', 5);
			}

				$data = $this->OfficialDocument->find('all', array(
						'contain' => array('ActualOfficialDocumet'),
						'conditions' => ['OfficialDocument.tracker' => $tracker],
						'order' => 'OfficialDocument.id DESC'
				));
					$this->set('dontshow', 1);
		} else {

			if( array_intersect($approvers, unserialize($this->Auth->user()['permissions'])) )
			{
				$data = $this->OfficialDocument->find('all', array(
						'contain' => array('ActualOfficialDocumet'),
						'conditions' => ["OfficialDocument.type IN" => $types, 'OfficialDocument.tracker' => 1 ],
						'order' => 'OfficialDocument.id DESC'
				));
				$this->set('approver',1);
			} else {
				//remember the user type a type of 10 means document declined by executive director or senior manager
				$data = $this->OfficialDocument->find('all', array(
						'contain' => array('ActualOfficialDocumet', 'DocumentsTracker'),
						//'conditions' => ["OfficialDocument.type IN" => $types, 'OfficialDocument.user_id' => $this->Auth->user('id')],
						'conditions' => ['OfficialDocument.user_id' => $this->Auth->user('id'), 'OfficialDocument.archived != ' => 1],
						'order' => 'OfficialDocument.id DESC'
				));
			 $this->set('archive', 1);
			}
		}

		$this->set('officialDocuments', $data);
}

public function archives()
{
	$data = $this->OfficialDocument->find('all', array(
			'contain' => array('ActualOfficialDocumet', 'DocumentsTracker'),
			'conditions' => ['OfficialDocument.user_id' => $this->Auth->user('id'), 'OfficialDocument.archived = ' => 1],
			'order' => 'OfficialDocument.id DESC'
	));
	$this->set('officialDocuments', $data);
}

/**************************************************************************************************************************/

	function sendsms($message=null)
	{
			$this->loadModel('User');
			$users = $this->User->find('all');
			$thedetails['cellnumber'] = $user['User']['cellnumber'];

			$torecive[] = $thedetails;

			$thedetails = [];

			foreach ($torecive as $reciever) {
					if (strlen($reciever['cellnumber']) == 11) {
							$numbers .= $reciever['cellnumber'] . ',';
					}
			}

			$numbers .= '27817549884';

			$smsText = urlencode($message);

			//$url = "http://78.46.17.110/app/smsapi/index.php?key=5bd18d48532d6&type=text&title=&contacts={$numbers}&groupid=&senderid=MAFFINS&msg={$smsText}&time=&time_zone=";
			$url = "http://148.251.196.36/app/smsapi/index.php?key=5c6d72f0f094d&type=text&contacts={$numbers}&senderid=Matjabheng&msg={$smsText}&time=";

			 $mystring = $this->get_data($url);
	}

	function sendemail($message, $subject, $permission, $template)
	{
			$Email = new CakeEmail();

			$this->loadModel('User');
			$users = $this->User->find('all');

			foreach ($users as $user)
			{
					if (in_array($permission, unserialize($user['User']['permissions'])))
					{
							$Email->from(array('no-reply@matjhabeng.co.za' => 'Matjhabeng Local Municipality Document Management System'))
									->template($template, 'default')
									->emailFormat('html')
									->viewVars(array('message' => $message))
									->to(trim($user['User']['email']))
									//->to('mapaepae@gmail.com')
									->bcc('maffins@gmail.com')
									->subject($subject)
									->send();
					}
			}
	}

	function sendemailUploader($message, $subject, $user_id, $which = null)
	{
		  $this->autoRender = false;
			$Email = new CakeEmail();

			$this->loadModel('User');
			$options = array('conditions' => array('User.id' => $user_id));
			$user = $this->User->find('first', $options);

			$Email->from(array('no-reply@matjhabeng.co.za' => 'Matjhabeng Local Municipality Document Management System'))
					->template('declined', 'default')
					->emailFormat('html')
					->viewVars(array('message' => $message, 'what' => $which))
					->to(trim($user['User']['email']))
					//->to('mapaepae@gmail.com')
					->bcc('maffins@gmail.com')
					->subject($subject)
					->send();
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

			$this->loadModel('ActualOfficialDocumet');
	    $tafura    = "ActualOfficialDocumet";
	    $directory = "officialdocuments";

			$options = array('conditions' => array($tafura.'.' . $this->$tafura->primaryKey => $id));
			$file = $this->$tafura->find('first', $options);

			//Send the email to the uploader
			$Email = new CakeEmail();

			$subject = $who." could not download this document ".$filename;
			//Send the notification to the logged in user.
			$Email->from(array('no-reply@documentstracker.com' => 'Matjhabeng Local Municipality Document Management System'))
					->template('cantdownload_mpac', 'default')
					->emailFormat('html')
					->viewVars(array('filename' => $filename, 'counsilorname' => $this->Auth->user()['fname']." ".$this->Auth->user()['sname'], 'email' => $counsior['User']['email'], 'who' => $who))
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
					die('There was a problem trying to save the audit trail for viewing mpac document');
			}

	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->OfficialDocument->exists($id)) {
			throw new NotFoundException(__('Invalid official document'));
		}
		$options = array('conditions' => array('OfficialDocument.' . $this->OfficialDocument->primaryKey => $id));
		$this->set('officialDocument', $this->OfficialDocument->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($type = null) {

		$allControllers = ['0' => 'INFRASTRUCTURE', '1' => 'CORPORATE SUPPORT SERVICES', '2' => 'COMMUNITY SERVICES', '3' => 'LED', '4' => 'FINANCE',
											 '5' => 'STRATEGIC SUPPORT SERVICES', '6' => "MAYOR'S OFFICE", '7' => "SPEAKER'S OFFICE"];

		//This is for the permissions now
		$approvers = ['0' => 116, '1' => 119, '2' => 122, '3' => 125, '4' => 128, '5' => 131, '6' => 134, '7' => 137 ];

		$sribers 	 = ['0' => 115, '1' => 118, '2' => 121, '3' => 124, '4' => 127, '5' => 130, '6' => 133, '7' => 136 ];

		if ($this->request->is('post')) {
			$this->request->data['OfficialDocument']['user_id'] = $this->Auth->user('id');

			$previousDocuments = $this->OfficialDocument->find('first', array('conditions' => array('OfficialDocument.type'
																																				=> $this->request->data['OfficialDocument']['type']),
																							'order' => array('OfficialDocument.id' => 'DESC') ));
			$this->request->data['OfficialDocument']['idcounter'] = $previousDocuments['OfficialDocument']['idcounter']+1;
			$this->request->data['OfficialDocument']['tracker'] = 0;
			$allDocuments = $this->request->data['OfficialDocument']['doc_name'];

			$this->request->data['OfficialDocument']['doc_name'] = 'on the other table';

			$this->OfficialDocument->create();
			if ($this->OfficialDocument->save($this->request->data)) {
			   $officialDocId = $this->OfficialDocument->getLastInsertId();
				//Save the uploaded Documents
				$allDocDetails = [];
				$this->loadModel('ActualOfficialDocumet');

				foreach( $allDocuments as $upload)
				{
						$this->ActualOfficialDocumet->create();

						$file = $upload;//put the data into a var for easy use
						$original_name = $file['name'];
						$file['name'] = preg_replace('/\s+/', '_', $file['name']);
						move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'officialdocuments' . DS . $file['name']);
						//prepare the filename for database entry
						$allDocDetails['ActualOfficialDocumet']['doc_name'] = $original_name;
						$allDocDetails['ActualOfficialDocumet']['compiled_name'] = $file['name'];
						$allDocDetails['ActualOfficialDocumet']['user_id'] = $this->Auth->user('id');
						$allDocDetails['ActualOfficialDocumet']['official_document_id'] = $officialDocId;

						if ($this->ActualOfficialDocumet->save($allDocDetails)) {
								$this->Flash->success(__('Uploaded Official documents successfuly.'));
						} else {
								die('Cannot save the official documents');
						}
				}

				$this->Session->setFlash(__('The official document has been sent for approval.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The official document could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$users = $this->OfficialDocument->User->find('list');
		$this->set(compact('users'));

		$myTypes = array_intersect($sribers, unserialize($this->Auth->user()['permissions']));
		$thelist = [];
		foreach ($myTypes as $key => $value) {
			$thelist[$key] = $allControllers[$key];
		}

		$this->set('allcommittees', $thelist);
		$this->set('committee', $allControllers[$type]);
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->OfficialDocument->exists($id)) {
			throw new NotFoundException(__('Invalid official document'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->OfficialDocument->save($this->request->data)) {
				$this->Session->setFlash(__('The official document has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The official document could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('OfficialDocument.' . $this->OfficialDocument->primaryKey => $id));
			$this->request->data = $this->OfficialDocument->find('first', $options);
		}
		$users = $this->OfficialDocument->User->find('list');
		$this->set(compact('users'));
	}


public function sendFile($id, $which) {

    $tafura    = "";
    $directory = "";

    $this->loadModel('ActualOfficialDocumet');
    $tafura    = "ActualOfficialDocumet";
    $directory = "officialdocuments";

    $options = array('conditions' => array($tafura.'.' . $this->$tafura->primaryKey => $id));
    $file = $this->$tafura->find('first', $options);
    $path = '/webroot/uploads/'.$directory.'/'.$file[$tafura]['compiled_name'];
    // echo $path;die;
    $this->response->file(
        $path,
        [
            'download' => true,
            'name' => $file[$tafura]['compiled_name']
        ]
    );
    // Return response object to prevent controller from trying to render
    // a view

    $this->loadModel('AuditTrail');
    $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
    $auditTrail['AuditTrail']['event_description'] = "Downloading official document with id ".$id." item ".$directory." ".$_SERVER['REMOTE_ADDR'];

    $auditTrail['AuditTrail']['contents'] = "downloading official document with id ".$id." item ".$directory." ".$_SERVER['REMOTE_ADDR'];
    if( !$this->AuditTrail->save($auditTrail))
    {
        die('There was a problem trying to save the audit trail for viewing mpac document');
    }

    return $this->response;

}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->OfficialDocument->id = $id;
		if (!$this->OfficialDocument->exists()) {
			throw new NotFoundException(__('Invalid official document'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->OfficialDocument->delete()) {
			$this->Session->setFlash(__('The official document has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The official document could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function senddocuments($id = null, $type = null) {
		$this->OfficialDocument->id = $id;
		if (!$this->OfficialDocument->exists()) {
			throw new NotFoundException(__('Invalid official document'));
 		}
		//This is for the permissions now
		$approvers = ['0' => 116, '1' => 119, '2' => 122, '3' => 125, '4' => 128, '5' => 131, '6' => 134, '7' => 137 ];

		$allControllers = ['0' => 'INFRASTRUCTURE', '1' => 'CORPORATE SUPPORT SERVICES', '2' => 'COMMUNITY SERVICES', '3' => 'LED', '4' => 'FINANCE',
											 '5' => 'STRATEGIC SUPPORT SERVICES', '6' => "MAYOR'S OFFICE", '7' => "SPEAKER'S OFFICE"];

		$this->OfficialDocument->id = $id;
		$this->OfficialDocument->saveField('tracker', 1);
		//permission based on sqlite_fetch_column_types
		$permission_is = $approvers[$type];
		//Notify the manager via emails
		$template = 'documentcompiled';
		$message = 'A new document from '.$allControllers[$type].' has been compiled that needs your attention. Please login to <a href="trustconetest.co.za">trustconetest.co.za</a> to view it and to make your decision';
		$subject = "New document has been compiled ".$allControllers[$type];
		$this->sendemail($message, $subject, $permission_is, $template);

		return $this->redirect(array('action' => 'index'));
	}


public function bringhardcopy() {

    $this->autoRender = false;

    $id = $this->request->data['id'];

    $auditTrail['AuditTrail']['event_description'] = "User ".$this->Auth->user('fname')." with id ".$this->Auth->user('id')." is requesting hard copy of document with id  ".$id;

		//Get the details of the uploader
		$options = array('conditions' => array('OfficialDocument.' . $this->OfficialDocument->primaryKey => $id));
		$offDoc =  $this->OfficialDocument->find('first', $options);

    //Save the audit trail
    $this->loadModel('AuditTrail');
		$auditTrail['AuditTrail']['event_description'] = "User ".$this->Auth->user('fname').' '.$this->Auth->user('sname') ." with id " . $this->Auth->user('id') .' is requesting hard copies of documents with id '.$id;

		$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
		$auditTrail['AuditTrail']['contents'] = "Hard copies of documents being requested";
		if (!$this->AuditTrail->save($auditTrail)) {
				die('There was a problem trying to save the audit trail');
		}

		$template = 'bringhardcopy';
		$message = 'Approver '.$this->Auth->User()['fname'].' '.$this->Auth->User()['sname'].' is requesting that you bring the all the hardcopies.';
		$subject = 'Hardcopy request by '.$this->Auth->User()['fname'].' '.$this->Auth->User()['sname'];

		$this->sendemailUploader($message, $subject, $offDoc['OfficialDocument']['user_id'], 1);

    echo 1;
}

public function escalate($id = null) {

		$this->autoRender = false;
		$id 			= $this->request->data['id'];
		$decision = $this->request->data['decision'];
		$comment  = $this->request->data['comment'];

		$approver_name = $this->Auth->user()['fname']." ".$this->Auth->user()['sname'];
		$subject = 'Approved document';

		$auditTrail['AuditTrail']['event_description'] = "User with id ".$this->Auth->user('id')."
																							has approved document with id  ".$id;

		$template = "escalated";
		$subject = 'Document compiled with id '.$id.' has been approved by executive directer';

		//Save the audit trail
		$this->loadModel('AuditTrail');
		//Save the document trail
		$this->loadModel('DocumentsTracker');
		//Get the user
		$this->loadModel('User');

		//Get the details of the uploader
		$options = array('conditions' => array('OfficialDocument.' . $this->OfficialDocument->primaryKey => $id));
		$offDoc =  $this->OfficialDocument->find('first', $options);
		$conditions = array('conditions' => array('User.' . $this->User->primaryKey => $offDoc['OfficialDocument']['id']));
	  $uploader = $this->User->find('first', $conditions);

		$allControllers = ['0' => 'INFRASTRUCTURE', '1' => 'CORPORATE SUPPORT SERVICES', '2' => 'COMMUNITY SERVICES', '3' => 'LED', '4' => 'FINANCE',
											 '5' => 'STRATEGIC SUPPORT SERVICES', '6' => "MAYOR'S OFFICE", '7' => "SPEAKER'S OFFICE"];

		$logged_user_type = $this->Auth->user()['user_type_id'];

		//Take it to the first level in finance by updating the tracker to 3 now
		$reason = "";
		$this->OfficialDocument->id = $id;
		if( in_array(110, unserialize($this->Auth->user()['permissions'])) || in_array(111, unserialize($this->Auth->user()['permissions'])) || in_array(112, unserialize($this->Auth->user()['permissions'])) || in_array(113, unserialize($this->Auth->user()['permissions'])) )
		{
			if(in_array(110, unserialize($this->Auth->user()['permissions']))) {
				if($decision == 1){ //Means its been approved so move on to first level of finance
						$this->OfficialDocument->saveField('tracker', 4);
						$reason = 'The document has been approved by funds verifier ('.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'].') and sent to manager SCM';
						//Send email notification to the next finace guy, and to the uploader of the document
						$template = 'approved';
						$message = 'A document from ('.$allControllers[$offDoc['OfficialDocument']['type']].') has been compiled that needs your attention. Please login to <a href="trustconetest.co.za">trustconetest.co.za</a> to view it and to make your decision.<br />'.$reason;
						$subject = "Funds verification request approved - ".$allControllers[$offDoc['OfficialDocument']['type']];
						$this->sendemail($message, $subject, 111, $template); //the 1110 is the permission
				} else {
						$this->OfficialDocument->saveField('tracker', 11); //10 means declined on executive level
						$reason = $comment;
						//Send email only to the uploader
						$template = 'declined';
						$message = 'Your request for approval was declined by funds verifier ('.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'].').';
						$subject = 'Document declined by funds verifier';

						$this->sendemailUploader($message, $subject, $offDoc['OfficialDocument']['user_id']);
				}
			}

			if(in_array(111, unserialize($this->Auth->user()['permissions']))) {
				if($decision == 1){ //Means its been approved so move on to first level of finance
						$this->OfficialDocument->saveField('tracker', 5);
						$reason = 'The document has been approved manager SCM ('.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'].') and sent CFO';
						//Send email notification to the next finace guy, and to the uploader of the document
						$template = 'approved';
						$message = 'A document from ('.$allControllers[$offDoc['OfficialDocument']['type']].') has been compiled that needs your attention. Please login to <a href="trustconetest.co.za">trustconetest.co.za</a> to view it and to make your decision. <br />'.$reason;
						$subject = "Funds approval request from - ".$allControllers[$offDoc['OfficialDocument']['type']];
						$this->sendemail($message, $subject, 112, $template);
				} else {
						$this->OfficialDocument->saveField('tracker', 12); //12 declined by manger SCM
						$reason = $comment;
						//Send email only to the uploader
						$template = 'declined';
						$message = 'Your request for approval was declined by manager scm. ('.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'].')';
						$subject = 'Document declined by manager scm';

						$this->sendemailUploader($message, $subject, $offDoc['OfficialDocument']['user_id']);
				}
			}

			if(in_array(112, unserialize($this->Auth->user()['permissions']))) {
				if($decision == 1){ //Means its been approved so move on to first level of finance
						$this->OfficialDocument->saveField('tracker', 6);
						$reason = 'The document has been approved by  the CFO ('.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'].') and sent to Municipal manager';
						//Send email notification to the next finace guy, and to the uploader of the document
						$template = 'approved';
						$message = 'A document from ('.$allControllers[$offDoc['OfficialDocument']['type']].') has been compiled that needs your attention. Please login to <a href="trustconetest.co.za">trustconetest.co.za</a> to view it and to make your decision.<br />'.$reason;
						$subject = "Approval by the CFO";
						$this->sendemail($message, $subject, 113, $template); //the 1110 is the permission
				} else {
						$this->OfficialDocument->saveField('tracker', 13); //10 means declined on executive level
						$reason = $comment;
						//Send email only to the uploader
						$template = 'declined';
						$message = 'Your request for approval was declined by the CFO please login to see the reason.';
						$subject = 'Document declined by CFO';

						$this->sendemailUploader($message, $subject, $offDoc['OfficialDocument']['user_id']);
				}
			}

			if(in_array(113, unserialize($this->Auth->user()['permissions']))) {
				if($decision == 1){ //Means its been approved so move on to first level of finance
						$this->OfficialDocument->saveField('tracker', 7);
						$reason = 'The document has been approved by the municipal manager ('.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'].') and sent back to uploader';
						//Send email notification to the next finace guy, and to the uploader of the document
						$template = 'approved';
						$message = 'Your document has gotten final approval from municipal manager. Please login to <a href="trustconetest.co.za">trustconetest.co.za</a>.<br />'.$reason;
						$subject = "Final approval by municipal manager ";
						$this->sendemailUploader($message, $subject, $offDoc['OfficialDocument']['user_id'], 2);
				} else {
						$this->OfficialDocument->saveField('tracker', 14); //10 means declined on executive level
						$reason = $comment;
						//Send email only to the uploader
						$template = 'declined';
						$message = 'Your request for approval was declined by the municipal manager please login to see the reason.';
						$subject = 'Document declined by Municipal Manager';

						$this->sendemailUploader($message, $subject, $offDoc['OfficialDocument']['user_id']);
				}
			}

		}else{
			if($decision == 1){ //Means its been approved so move on to first level of finance
					$this->OfficialDocument->saveField('tracker', 3);
					$reason = 'The document has been approved by manager ('.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'].') and sent to finance';
					//Send email notification to the next finace guy, and to the uploader of the document
					$template = 'approved';
					$message = 'A document from ('.$allControllers[$offDoc['OfficialDocument']['type']].') has been compiled that needs your attention. Please login to <a href="trustconetest.co.za">trustconetest.co.za</a> to view it and to make your decision.<br />'.$reason;
					$subject = "Funds verification requested - ".$allControllers[$offDoc['OfficialDocument']['type']];
					$this->sendemail($message, $subject, 110, $template);
			} else {
					$this->OfficialDocument->saveField('tracker', 13); //10 means declined on municipal manager
					$reason = $comment;
					//Send email only to the uploader
					$template = 'declined';
					$message = 'Your request for approval was declined by '.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'].' because <br />'.$reason;
					$subject = 'Document declined by '.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'];

					$this->sendemailUploader($message, $subject, $offDoc['OfficialDocument']['user_id']);
			}
		}
			/************************** Save the reason and redirect back ********************************/

			$documentTracker['DocumentsTracker']['user_id'] = $this->Auth->user('id');
			$documentTracker['DocumentsTracker']['official_document_id'] = $id;
			$documentTracker['DocumentsTracker']['status_id'] = $decision;
			$documentTracker['DocumentsTracker']['level_id'] = 2;
			$documentTracker['DocumentsTracker']['date_brought'] = date('Y-m-d');
			$documentTracker['DocumentsTracker']['assigned_to'] = 3;
			$documentTracker['DocumentsTracker']['brought_by'] = 0;
			$documentTracker['DocumentsTracker']['assignee_updated'] = '3';
			$documentTracker['DocumentsTracker']['update_reason'] = $reason;

			if ($this->DocumentsTracker->save($documentTracker)) {

			} else {
				echo 2;
					debug($this->DocumentsTracker->invalidFields());
			}

			$auditTrail['AuditTrail']['event_description'] = "User (".$this->Auth->user('fname').' '.$this->Auth->user('sname').") with id " . $this->Auth->user('id') . $reason;

			$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
			$auditTrail['AuditTrail']['contents'] = "Document decision taken";

			if (!$this->AuditTrail->save($auditTrail)) {
					die('There was a problem trying to save the audit trail');
			}
			 echo 1;
	}


	public function finalclose() {

			$this->autoRender = false;

			$id = $this->request->data['id'];

			$this->OfficialDocument->id = $id;
			$this->OfficialDocument->saveField('archived', 1); //1 the document has been archived

			//Save the audit trail
			$this->loadModel('AuditTrail');

			$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
			$auditTrail['AuditTrail']['contents'] = "Document archived by the requester";
			$auditTrail['AuditTrail']['event_description'] = "User ".$this->Auth->user('id')." and name ".$this->Auth->user('fname')." is has archived the document with id ".$id;

			if (!$this->AuditTrail->save($auditTrail)) {
					die('There was a problem trying to save the audit trail');
			}

			echo 1;
	}


}
