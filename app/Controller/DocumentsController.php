<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Documents Controller
 *
 * @property Document $Document
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class DocumentsController extends AppController {
	/**
	 * Components
	 *
	 * @var array
	 */
		public $components = array('Paginator', 'Flash', 'Session');

	  public function beforeFilter() {
	        parent::beforeFilter();
	  }

	public function viewmembers() {

		$this->loadModel('User');
		$users = $this->User->find('all');
		$allmembers = [];

		foreach ($users as $user)
		{
				if( in_array(21, unserialize($user['User']['permissions'])) )
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
					$message = $this->request->data['Document']['message'];
					$subject = $this->request->data['Document']['subject'];

					if(!$subject)
					{
						$subject = "MAYCO Meeting documents are posted.";
					}
					if(!$message)
					{
						$message = "MAYCO Meeting documents are posted. Please login to http://trustconetest.co.za/users/login to view documents.";
					}

					if($this->request->data['Document']['sendsms']){
						 $this->sendsms($message);
					}
					if($this->request->data['Document']['sendemail']){
						 $this->sendemail($message, $subject);
					}
					$this->Session->setFlash(__('Your messages have been sent.'), 'default', array('class' => 'alert alert-success'));

					return $this->redirect(array('Controller' => 'Document', 'action' => 'committeedetails'));
			}
		}

    /**************************************************************************************************************************/

    function sendsms($message=null)
    {
        $this->loadModel('User');
        $users = $this->User->find('all');

        $thedetails = [];
        $torecive   = [];
        $numbers    = "";

        foreach ($users as $user)
        {
            if( in_array(21, unserialize($user['User']['permissions'])) )
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

        $numbers .= '27823087961,27817549884';

				if(!$message)
				{
					$message = "Official documents are posted. Please login to http://trustconetest.co.za/users/login to view documents.";
				}
        $smsText = urlencode($message);

			//	$url = "http://78.46.17.110/app/smsapi/index.php?key=5bd18d48532d6&type=text&title=&contacts={$numbers}&groupid=&senderid=MAFFINS&msg={$smsText}&time=&time_zone=";
			$url = "http://148.251.196.36/app/smsapi/index.php?key=5c6d72f0f094d&type=text&contacts={$numbers}&senderid=Matjabheng&msg={$smsText}&time=";

        $mystring = $this->get_data($url);
    }

    function sendemail($message=null, $subject=null)
    {
        $Email = new CakeEmail();

        $this->loadModel('User');
        $users = $this->User->find('all');

				if(!$subject)
				{
					$subject = "Official documents are posted.";
				}
				if(!$message)
				{
					$message = "Official documents are posted. Please login to http://trustconetest.co.za/users/login to view documents.";
				}

        foreach ($users as $user) {
            if (in_array(21, unserialize($user['User']['permissions']))) {
                $Email->from(array('no-reply@matjhabeng.co.za' => 'Matjhabeng Local Municipality Document Management System'))
                    ->template('newmeetingposted', 'default')
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
 * index method
 *
 * @return void
 */
	public function index() {
        /**
         * if the user type is not 1 then chances are this persom might have to approve documents
         * So now check first if there are documents that he needs to approve
         */
        $can_approve = 0;
        $ceo = 0;
        $cfo = 0;
        $dataApprove = [];
        $usertype = $this->Auth->user()['user_type_id'];
        $kondisheni = $usertype;
       // echo $usertype.' This is the user type';

        //Redirect this user to the documents he or she uploads
        if($usertype == 15 || $usertype == 9)
        {
            //return $this->redirect(array('controller' => 'CounsilorDocuments', 'action' => 'index'));
        }

        if($usertype == 11)
        {
            $kondisheni = 2;
        }

        if($usertype == 10)
        {
            $kondisheni = 3;
        }

        if($usertype == 12)
        {
            $kondisheni = 8;
        }

        if($usertype == 13)
        {
            $kondisheni = 7;
        }
      //  echo $usertype.' This is the user type '.$kondisheni;

        $in = 0;

        $condition = " documents.final <> 1 and ( documents.tracker = '".$kondisheni.  "'";

        if($this->Auth->user()['user_type_id'] != 1)
        {
            if ( $usertype == 3 )
            {
                //The previous reason must show for the ceo
                $ceo = 1;
                $condition .= " or documents.tracker = 8 )";
                $in = 1;
            }

            if ( $usertype == 2 )
            {
                //The previous reason must show for the ceo
                $cfo = 2;
                $condition .= " or documents.tracker = 7 )";
                $in = 1;
            }


            if ( $usertype == 10 )
            {
                //The previous reason must show for the ceo
                $ceo = 1;
                $condition .= " or documents.tracker = 8 )";
                $in = 1;
            }

            if ( $usertype == 11 )
            {
                //The previous reason must show for the ceo
                $cfo = 2;
                $condition .= " or documents.tracker = 7 )";
                $in = 1;
            }

            if ( $usertype == 7 ) //This is for cfo secretary
            {
                //The previous reason must show for the ceo
                $cfo = 0; //Prevent them from seeing request for the actual document
                $condition .= " or documents.tracker = 2 )";
                $in = 1;
            }

            if ( $usertype == 8 ) //This is for cfo secretary
            {
                //The previous reason must show for the ceo
                $ceo = 0; //Prevent them from seeing request for the actual document
                $condition .= " or documents.tracker = 3 )";
                $in = 1;
            }

            if ( $usertype == 13 ) //This is for cfo secretary
            {
                //The previous reason must show for the ceo
                $cfo = 0; //Prevent them from seeing request for the actual document
                $condition .= " or documents.tracker = 2 )";
                $in = 1;
            }

            if ( $usertype == 12 ) //This is for cfo secretary
            {
                //The previous reason must show for the ceo
                $ceo = 0; //Prevent them from seeing request for the actual document
                $condition .= " or documents.tracker = 3 )";
                $in = 1;
            }

            if ( $usertype == 9 ) //This is for cfo secretary
            {
                //The previous reason must show for the ceo
                $ceo = 0; //Prevent them from seeing request for the actual document
                $condition .= " or documents.tracker = 1333 )";
                $in = 1;
            }

            if( !$in )
            {
            	$condition .= " )";
            }

           $query = "SELECT documents.*, departments.name, departments.id FROM documents
                    join departments on departments.id = documents.department_id
                    where {$condition} ";
//echo $query;
           $dataApprove = $this->Document->query($query);

            $can_approve = 1;

            $councillor = 0;

            if ( $usertype == 9 ){
                $councillor = 1;
                $this->set('councillor', $councillor);
            }
        }

        /**
         * This should only list my own documents
         * Take care of the fact that once the document has been approved by the ceo or declined it must then dissapear from my list
         */
        $this->Paginator->settings = array(
            'conditions' => array('Document.final <>' => 1)
        );
        $data = $this->Paginator->paginate('Document');
//var_dump($data);die;
		//$this->Document->recursive = 0;
		//$this->set('documents', $this->Paginator->paginate());
		$this->set('documents', $data);
		$this->set('documentsApprove', $dataApprove);
		$this->set('canapprove', $can_approve);
        $this->set('user_type_id', $this->Auth->user()['user_type_id']);
        $this->set('user_id', $this->Auth->user('id'));
		$this->set('ceo', $ceo);
		$this->set('cfo', $cfo);



        $this->loadModel('AuditTrail');

        $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
        $auditTrail['AuditTrail']['event_description'] = "Viewing the documents page";

        $auditTrail['AuditTrail']['contents'] = "Viewing the documents page";
        if( !$this->AuditTrail->save($auditTrail))
        {
            die('There was a problem trying to save the audit trail');
        }

    }

    public function escalate() {

        $this->autoRender = false;

        $id = $this->request->data['id'];

        if (!$this->Document->exists($id)) {
            throw new NotFoundException(__('The document you are requesting for cannot be located'));
        }

        $user_type_id = $this->Auth->user('user_type_id');
        $subject = 'Escalated document';

        $auditTrail['AuditTrail']['event_description'] = "User with id ".$this->Auth->user('id')."
				                                          has approved document with id  ".$id;

        $template = "escalated";
        $subject = 'Document compiled with id '.$id.' has been escalated';

        //Save the audit trail
        $this->loadModel('AuditTrail');
        //Save the document trail
        $this->loadModel('DocumentsTracker');

        if ($this->request->is(['post', 'put'])) {
            //Determine the escalations
            $goes_to = 3;

            $conditions = array("User.user_type_id" => $goes_to);
            $Approver = $this->Document->User->find('first', array('conditions' => $conditions));

            /************************** Save the reason and redirect back ********************************/

            $documentTracker['DocumentsTracker']['user_id'] = $this->Auth->user('id');
            $documentTracker['DocumentsTracker']['document_id'] = $id;
            $documentTracker['DocumentsTracker']['status_id'] = 1;
            $documentTracker['DocumentsTracker']['level_id'] = 1;
            $documentTracker['DocumentsTracker']['date_brought'] = date('Y-m-d');
            $documentTracker['DocumentsTracker']['assigned_to'] = $user_type_id;
            $documentTracker['DocumentsTracker']['brought_by'] = $user_type_id;
            $documentTracker['DocumentsTracker']['assignee_updated'] = '3';
            $documentTracker['DocumentsTracker']['update_reason'] = 'The document has been escalated by CFO secretary';

            if ($user_type_id == 3) {
                $documentTracker['DocumentsTracker']['updated_by'] = 3;
            }

            if ($user_type_id == 10) {
                $documentTracker['DocumentsTracker']['updated_by'] = 10;
            }

            //update tracker on document
            $this->Document->id = $id;
            $this->Document->saveField('tracker', 3);

            if ($this->DocumentsTracker->save($documentTracker)) {

            } else {
                debug($this->DocumentsTracker->invalidFields());
            }
            $redirect = 1;
            $auditTrail['AuditTrail']['event_description'] = "User with id " . $this->Auth->user('id') . "
				                                          has decided to escalate and a notification has been sent to ";


            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['contents'] = "Document escalated";

            if (!$this->AuditTrail->save($auditTrail)) {
                die('There was a problem trying to save the audit trail');
            }

            $redirect = 1;
            if ($redirect) {

                $actual_document = $this->Document->findById($id);

                $Email = new CakeEmail();

                if ( $this->Auth->user()['user_type_id'] == 3 || $this->Auth->user()['user_type_id'] == 10 ) //3 is the ceo
                {
                    $subject = $subject . ' by ' . $this->Auth->user()['fname'] . ' ' . $this->Auth->user()['sname'];
                    //Send the notification to the logged in user.
                    $Email->from(array('no-reply@documentstracker.com' => 'Matjhabeng Local Municipality Document Management System'))
                        ->template($template, 'default')
                        ->emailFormat('html')
                        ->viewVars(array('details' => 'Document has been escalated'))
                        ->to($actual_document['Document']['email'])
                        ->bcc('maffins@gmail.com')
                        ->subject($subject)
                        ->send();
                } else {
                    $subject = $subject . ' by ' . $Approver['User']['fname'] . ' ' . $Approver['User']['sname'];

                    $Email->from(array('no-reply@documentstracker.com' => 'Matjhabeng Local Municipality Document Management System'))
                        ->template($template, 'default')
                        ->emailFormat('html')
                        ->viewVars(array('details' => 'Document has been escalated'))
                        ->to($actual_document['Document']['email'])
                        ->bcc('maffins@gmail.com')
                        ->subject($subject)
                        ->send();
                }


                $this->Flash->success(__('Your decision and reason was successfully saved and notification sent.'));
                return $this->redirect(array('action' => 'index'));
            }
        }
        $options = array('conditions' => array('Document.' . $this->Document->primaryKey => $id), 'contain' => '');
        $this->set('document', $this->Document->find('first', $options));

        echo 1;
    }


    public function bringhardcopy() {

        $this->autoRender = false;

        $id = $this->request->data['id'];

        if (!$this->Document->exists($id)) {
            throw new NotFoundException(__('The document you are requesting for cannot be located'));
        }

        $user_type_id = $this->Auth->user('user_type_id');

        $auditTrail['AuditTrail']['event_description'] = "User with id ".$this->Auth->user('id')."
				                                          is requesting document with id  ".$id;

        $condition = "";

        if ( $user_type_id == 2 || $user_type_id == 11 ) {
            $subject = 'Document compiled with id '.$id.' has been requested by the CFO';

            //get the user who will get the email i.e secretary
            $conditions = array("User.user_type_id" => 7);

        } else {
            $subject = 'Document compiled with id '.$id.' has been requested by the CEO/MM';
            $conditions = array("User.user_type_id" => 8);
        }

        $secretary = $this->Document->User->find('all', array('conditions' => $conditions));

        //Save the audit trail
        $this->loadModel('AuditTrail');

        if ($this->request->is(['post', 'put'])) {

            $auditTrail['AuditTrail']['event_description'] = "User with id " . $this->Auth->user('id') . "
				                                          has requested document from secretary  document id ".$id;

            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['contents'] = "Document request";

            if (!$this->AuditTrail->save($auditTrail)) {
                die('There was a problem trying to save the audit trail');
            }
            $actual_document = $this->Document->findById($id);

            $Email = new CakeEmail();

            foreach ($secretary as $mgrs) {

                $subject = $subject . ' by ' . $this->Auth->user()['fname'] . ' ' . $this->Auth->user()['sname'];
                $Email->from(array('no-reply@documentstracker.com' => 'Matjhabeng Local Municipality Document Management System'))
                    ->template("bringhardcopy", 'default')
                    ->emailFormat('html')
                    ->subject($subject)
                    ->viewVars(array('details' => $actual_document))
                    ->to($mgrs['User']['email'])
                    ->bcc('maffins@gmail.com')
                    ->send();
            }
        }

        echo 1;
    }
    public function finalclose() {

        $this->autoRender = false;

        $id = $this->request->data['id'];
        $decision = $this->request->data['what'];
        $app_decl = "";

        if ($decision == 10) {
            $app_decl = "Approved";
        } else {
            $app_decl = "Declined";
        }


        $this->Document->id = $id;
        $this->Document->saveField('tracker', $decision); //10 is for final approval

        if (!$this->Document->exists($id)) {
            throw new NotFoundException(__('The document you are requesting for cannot be located'));
        }

        $auditTrail['AuditTrail']['event_description'] = "User with id ".$this->Auth->user('id')."
				                                          is sending the final decision to document owner  ".$id;

        $subject = 'Document compiled with id '.$id.' has been '.$app_decl.' by the CEO/MM';

        //Save the audit trail
        $this->loadModel('AuditTrail');

        if ($this->request->is(['post', 'put'])) {

            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['contents'] = "Document {$app_decl} by the CEO";

            if (!$this->AuditTrail->save($auditTrail)) {
                die('There was a problem trying to save the audit trail');
            }
            $actual_document = $this->Document->findById($id);

            $Email = new CakeEmail();

            $subject = $subject ;
//            //Send the notification to the logged in user.
            $Email->from(array('no-reply@documentstracker.com' => 'Matjhabeng Local Municipality Document Management System'))
                ->subject($subject)
                ->template("finalclose", 'default')
                ->emailFormat('html')
                ->viewVars(array('details' => $actual_document, 'decision' => $decision))
                ->to($actual_document['Document']['email'])
                ->bcc('maffins@gmail.com')
                ->send();
        }

        echo 1;
    }

    public function finalized() {

        $this->autoRender = false;

        $id = $this->request->data['id'];
        $comment = $this->request->data['comment'];

        if (!$this->Document->exists($id)) {
            throw new NotFoundException(__('The document you are requesting for cannot be located'));
        }

        $user_type_id = $this->Auth->user('user_type_id');

        $auditTrail['AuditTrail']['event_description'] = "Document with id  ".$id." has been given the final approval";

        //Save the audit trail
        $this->loadModel('AuditTrail');

        if ($this->request->is(['post', 'put'])) {

            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['contents'] = "Document given final approval";

            if (!$this->AuditTrail->save($auditTrail)) {
                die('There was a problem trying to save the audit trail');
            }
            $actual_document = $this->Document->findById($id);
            //update tracker on document
            $this->Document->id = $id;
            $this->Document->saveField('final', 1); //10 is for final approval

            if ( $user_type_id == 7 || $user_type_id == 13 )
            {
                $this->Document->saveField('cfo_finalize', $comment); //10 is for final approval
            }

            if ( $user_type_id == 8 || $user_type_id == 12 )
            {
                $this->Document->saveField('ceo_finalize', $comment); //10 is for final approval
            }


            $Email = new CakeEmail();

            $subject =  'Document with id ' . $id . ' final approval';
            //Send the notification to the logged in user.
            $Email->from(array('no-reply@documentstracker.com' => 'Matjhabeng Local Municipality Document Management System'))
                ->template("finalized", 'default')
                ->emailFormat('html')
                ->viewVars(array('details' => $actual_document, 'comment' => $comment))
                ->to($actual_document['Document']['email'])
                ->bcc('maffins@gmail.com')
                ->subject($subject)
                ->send();
        }

        echo 1;
    }

    public function remove() {

        $this->autoRender = false;

        $id = $this->request->data['id'];

        if (!$this->Document->exists($id)) {
            throw new NotFoundException(__('The document you are requesting for cannot be located'));
        }

        $user_type_id = $this->Auth->user('user_type_id');
        $subject = 'Declined document';

        $auditTrail['AuditTrail']['event_description'] = "User with id ".$this->Auth->user('id')."
				                                          has approved document with id  ".$id;

        // yes button was clicked
        $decision = 1;
        $template = "removed";
        $subject = 'Document compiled with id '.$id.' has been declined by CFO';

        //Save the audit trail
        $this->loadModel('AuditTrail');
        //Save the document trail
        $this->loadModel('DocumentsTracker');

        if ($this->request->is(['post', 'put'])) {
            //Determine the escalations
            $goes_to = 20;

            $conditions = array("User.user_type_id" => $goes_to);
            $Approver = $this->Document->User->find('first', array('conditions' => $conditions));

            /************************** Save the reason and redirect back ********************************/

            $documentTracker['DocumentsTracker']['user_id'] = $this->Auth->user('id');
            $documentTracker['DocumentsTracker']['document_id'] = $id;
            $documentTracker['DocumentsTracker']['status_id'] = 1;
            $documentTracker['DocumentsTracker']['level_id'] = 1;
            $documentTracker['DocumentsTracker']['date_brought'] = date('Y-m-d');
            $documentTracker['DocumentsTracker']['assigned_to'] = $user_type_id;
            $documentTracker['DocumentsTracker']['brought_by'] = $user_type_id;
            $documentTracker['DocumentsTracker']['assignee_updated'] = $decision;
            $documentTracker['DocumentsTracker']['update_reason'] = 'The document has been declined by CFO';

            if ($user_type_id == 3 || $user_type_id == 10) {
                $documentTracker['DocumentsTracker']['updated_by'] = $user_type_id;
            }

            //update tracker on document
            $this->Document->id = $id;
            $this->Document->saveField('tracker', $goes_to);
            $this->Document->saveField('decision', 20);

            if ($this->DocumentsTracker->save($documentTracker)) {

            } else {
                debug($this->DocumentsTracker->invalidFields());
            }
            $redirect = 1;
            $auditTrail['AuditTrail']['event_description'] = "User with id " . $this->Auth->user('id') . "
				                                          has decided to escalate and a notification has been sent to ";


            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['contents'] = "Document declined";

            if (!$this->AuditTrail->save($auditTrail)) {
                die('There was a problem trying to save the audit trail');
            }

            $redirect = 1;
            if ($redirect) {

                $actual_document = $this->Document->findById($id);

                $Email = new CakeEmail();

                if ($this->Auth->user()['user_type_id'] == 3 || $this->Auth->user()['user_type_id'] == 10) //3 is the ceo
                {
                    $subject = $subject . ' by ' . $this->Auth->user()['fname'] . ' ' . $this->Auth->user()['sname'];
                    //Send the notification to the logged in user.
                    $Email->from(array('no-reply@documentstracker.com' => 'Matjhabeng Local Municipality Document Management System'))
                        ->template($template, 'default')
                        ->emailFormat('html')
                        ->viewVars(array('details' => 'Document has been declined'))
                        ->to($actual_document['Document']['email'])
                        ->bcc('maffins@gmail.com')
                        ->subject($subject)
                        ->send();
                } else {
                    $subject = $subject . ' by ' . $Approver['User']['fname'] . ' ' . $Approver['User']['sname'];

                    $Email->from(array('no-reply@documentstracker.com' => 'Matjhabeng Local Municipality Document Management System'))
                        ->template($template, 'default')
                        ->emailFormat('html')
                        ->viewVars(array('details' => 'Document has been declined'))
                        ->to($actual_document['Document']['email'])
                        ->subject($subject)
                        ->send();
                }


                $this->Flash->success(__('Your decision and reason was successfully saved and notification sent.'));
                return $this->redirect(array('action' => 'index'));
            }
        }
        $options = array('conditions' => array('Document.' . $this->Document->primaryKey => $id), 'contain' => '');
        $this->set('document', $this->Document->find('first', $options));

        echo 1;
    }

    public function approved() {

        $this->autoRender = false;

        $id = $this->request->data['id'];

        if (!$this->Document->exists($id)) {
            throw new NotFoundException(__('The document you are requesting for cannot be located'));
        }

        $user_type_id = $this->Auth->user('user_type_id');
        $subject = 'Document approved by ';
        $who = "";
        if ($user_type_id == 1) {
            $who = "Compiler";
        }

        if ($user_type_id == 2) {
            $who = "CFO";
            $email_body = "The CFO has approved this document with id ".$id;
            $decision = 1;
        }

        if ($user_type_id == 3) {
            $who = "CEO/Municipal manager";
            $email_body = "The CEO/Municipal manager has approved this document with id ".$id;
            $decision = 3;
        }

        if ($user_type_id == 8) {
            $who = "CEO/Municipal Secretary";
            $email_body = "The CEO/Municipal secretary will be informing you about the decision taken on your document with document id ".$id;
        }

        if ($user_type_id == 7) {
            $who = "CFO Secretary";
            $email_body = "The CFO secretary ".$id;
        }

        if ($user_type_id == 11) {
            $who = "Acting CFO";
            $email_body = "The CFO has approved this document with id ".$id;
            $decision = 1;
        }

        if ($user_type_id == 10) {
            $who = "Acting CEO/Municipal manager";
            $email_body = "The CEO/Municipal manager has approved this document with id ".$id;
            $decision = 3;
        }

        if ($user_type_id == 12) {
            $who = "Acting CEO/Municipal Secretary";
            $email_body = "The CEO/Municipal secretary will be informing you about the decision taken on your document with document id ".$id;
        }

        if ($user_type_id == 13) {
            $who = "Acting CFO Secretary";
            $email_body = "The CFO secretary ".$id;
        }

        if ($user_type_id == 14) {
            $who = "CEO/CFO Secretary";
            $email_body = "The CFO secretary ".$id;
        }

        $auditTrail['AuditTrail']['event_description'] = "User ({$who}) with id ".$this->Auth->user('id')."
				                                          has approved document with id  ".$id;

        // yes button was clicked

        $template = "approved";
        $subject = 'Document compiled with id '.$id.' has been approved';

        //Save the audit trail
        $this->loadModel('AuditTrail');
        //Save the document trail
        $this->loadModel('DocumentsTracker');

        if ($this->request->is(['post', 'put'])) {
            //Determine the escalations
            $goes_to = 7;

            if ($user_type_id == 3 || $user_type_id == 12)
            {
                $goes_to = 8;
            }

            $conditions = array("User.user_type_id" => $goes_to);
            $Approver = $this->Document->User->find('first', array('conditions' => $conditions));

            /************************** Save the reason and redirect back ********************************/

            $documentTracker['DocumentsTracker']['user_id'] = $this->Auth->user('id');
            $documentTracker['DocumentsTracker']['document_id'] = $id;
            $documentTracker['DocumentsTracker']['status_id'] = 1;
            $documentTracker['DocumentsTracker']['level_id'] = 1;
            $documentTracker['DocumentsTracker']['date_brought'] = date('Y-m-d');
            $documentTracker['DocumentsTracker']['assigned_to'] = $user_type_id;
            $documentTracker['DocumentsTracker']['brought_by'] = $user_type_id;
            $documentTracker['DocumentsTracker']['assignee_updated'] = $decision;
            $documentTracker['DocumentsTracker']['update_reason'] = 'The document has been approved by CFO';

            if ($user_type_id == 3 || $user_type_id == 12)
            {
                $documentTracker['DocumentsTracker']['updated_by'] = $user_type_id;
            }

            //update tracker on document
            $this->Document->id = $id;
            $this->Document->saveField('tracker', $goes_to);
            $this->Document->saveField('decision', $decision);

            if ($this->DocumentsTracker->save($documentTracker)) {

            } else {
                debug($this->DocumentsTracker->invalidFields());
            }
            $redirect = 1;
            $auditTrail['AuditTrail']['event_description'] = "User with id " . $this->Auth->user('id') . "
				                                          has decided to  " . $decision . " and a notification has been sent to ";


            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['contents'] = "Making a decision on document";

            if (!$this->AuditTrail->save($auditTrail)) {
                die('There was a problem trying to save the audit trail');
            }

            if ($redirect) {

                $actual_document = $this->Document->findById($id);

                $Email = new CakeEmail();

                if ($this->Auth->user()['user_type_id'] == 3 || $this->Auth->user()['user_type_id'] == 12) //3 is the ceo
                {
                    $subject = $subject . ' by ' . $this->Auth->user()['fname'] . ' ' . $this->Auth->user()['sname'];
                    //Send the notification to the logged in user.
                    $Email->from(array('no-reply@documentstracker.com' => 'Matjhabeng Local Municipality Document Management System'))
                        ->template($template, 'default')
                        ->emailFormat('html')
                        ->viewVars(array('details' => $email_body))
                        ->to($actual_document['Document']['email'])
                        ->bcc('maffins@gmail.com')
                        ->subject($subject)
                        ->send();
                } else {
                    $subject = $subject . ' by ' . $Approver['User']['fname'] . ' ' . $Approver['User']['sname'];

                    $Email->from(array('no-reply@documentstracker.com' => 'Matjhabeng Local Municipality Document Management System'))
                        ->template($template, 'default')
                        ->emailFormat('html')
                        ->viewVars(array('details' => $email_body))
                        ->to($actual_document['Document']['email'])
                        ->subject($subject)
                        ->send();
                }


                $this->Flash->success(__('Your decision and reason was successfully saved and notification sent.'));
                return $this->redirect(array('action' => 'index'));
            }
        }
        $options = array('conditions' => array('Document.' . $this->Document->primaryKey => $id), 'contain' => '');
        $this->set('document', $this->Document->find('first', $options));

        echo 1;
    }

    public function declined()
    {
        $this->autoRender = false;
        $id = $this->request->data['id'];
        $comment = $this->request->data['comment'];

        if (!$this->Document->exists($id)) {
            throw new NotFoundException(__('The document you are requesting for cannot be located'));
        }

        $user_type_id = $this->Auth->user('user_type_id');

        $who = "";
        if ($user_type_id == 1) {
            $who = "Compiler";
        }
        if ($user_type_id == 2) {
            $who = "CFO";
            $email_body = "The CFO has declined this document with id ".$id;
            $subject = 'Document declined by CFO';
            $goes_to = 7;
            $decision = 2;
        }
        if ($user_type_id == 3) {
            $who = "CEO/Municipal manager";
            $email_body = "The CEO/Municipal manager has approved this document with id ".$id;
            $subject = 'Document declined by CEO/Municipal manager';
            $goes_to = 8;
            $decision = 4;
        }
        if ($user_type_id == 8) {
            $who = "CEO/Municipal Secretary";
            $email_body = "The CEO/Municipal secretary will be informing you about the decision taken on your document with document id ".$id;
            $subject = 'Document declined by CEO/Municipal manager';
            $decision = 4;

        }
        if ($user_type_id == 7) {
            $who = "CFO Secretary";
            $email_body = "The CFO secretary ".$id;
            $subject = 'Document declined by CFO';
            $decision = 2;
        }

        /***************************************************************************************************************/

        if ($user_type_id == 11) {
            $who = "Acting CFO";
            $email_body = "The CFO has declined this document with id ".$id;
            $subject = 'Document declined by CFO';
            $goes_to = 7;
            $decision = 2;
        }
        if ($user_type_id == 10) {
            $who = "Acting CEO/Municipal manager";
            $email_body = "The CEO/Municipal manager has approved this document with id ".$id;
            $subject = 'Document declined by CEO/Municipal manager';
            $goes_to = 8;
            $decision = 4;
        }
        if ($user_type_id == 12) {
            $who = "Acting CEO/Municipal Secretary";
            $email_body = "The CEO/Municipal secretary will be informing you about the decision taken on your document with document id ".$id;
            $subject = 'Document declined by CEO/Municipal manager';
            $decision = 4;

        }
        if ($user_type_id == 13) {
            $who = "Acting CFO Secretary";
            $email_body = "The CFO secretary ".$id;
            $subject = 'Document declined by CFO';
            $decision = 2;
        }

        $auditTrail['AuditTrail']['event_description'] = "User ({$who}) with id ".$this->Auth->user('id')."
				                                          has declined document with id  ".$id;

        $template = "declined";

        //Save the audit trail
        $this->loadModel('AuditTrail');
        //Save the document trail
        $this->loadModel('DocumentsTracker');

        if ($this->request->is(['post', 'put'])) {
            //Determine the escalations
            $conditions = array("User.user_type_id" => $goes_to);
            $Approver = $this->Document->User->find('first', array('conditions' => $conditions));

            /************************** Save the reason and redirect back ********************************/

            $documentTracker['DocumentsTracker']['user_id'] = $this->Auth->user('id');
            $documentTracker['DocumentsTracker']['document_id'] = $id;
            $documentTracker['DocumentsTracker']['status_id'] = 1;
            $documentTracker['DocumentsTracker']['level_id'] = 1;
            $documentTracker['DocumentsTracker']['date_brought'] = date('Y-m-d');
            $documentTracker['DocumentsTracker']['assigned_to'] = $user_type_id;
            $documentTracker['DocumentsTracker']['brought_by'] = $user_type_id;
            $documentTracker['DocumentsTracker']['assignee_updated'] = $decision;
            $documentTracker['DocumentsTracker']['update_reason'] = "The document has been declined by the CFO";

            if ($user_type_id == 3|| $user_type_id == 10)
            {
                $documentTracker['DocumentsTracker']['updated_by'] = $user_type_id;
            }

            //update tracker on document
            $this->Document->id = $id;
            $this->Document->saveField('tracker', $goes_to);
            $this->Document->saveField('decision', $decision);
            $this->Document->saveField('reason', $comment);

            if ($this->DocumentsTracker->save($documentTracker)) {

            } else {
                debug($this->DocumentsTracker->invalidFields());
            }
            $redirect = 1;
            $auditTrail['AuditTrail']['event_description'] = "User with id " . $this->Auth->user('id') . "
				                                          has decided to decline and a notification has been sent to ";


            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['contents'] = "Making a decision on document";

            if (!$this->AuditTrail->save($auditTrail)) {
                die('There was a problem trying to save the audit trail');
            }

            if ($redirect) {

                $actual_document = $this->Document->findById($id);

                $conditions = array("User.user_type_id" => $goes_to);
                $Approver = $this->Document->User->find('first', array('conditions' => $conditions));

                $Email = new CakeEmail();

                $subject = $subject . ' by ' . $Approver['User']['fname'] . ' ' . $Approver['User']['sname'];

                foreach ($Approver as $mgrs) {
                    $Email->from(array('no-reply@documentstracker.com' => 'Matjhabeng Local Municipality Document Management System'))
                        ->template($template, 'default')
                        ->emailFormat('html')
                        ->viewVars(array('details' => $email_body))
                        ->to($mgrs['User']['email'])
                        ->bcc('maffins@gmail.com')
                        ->subject($subject)
                        ->send();
                }

                $this->Flash->success(__('Your decision and reason was successfully saved and notification sent.'));
                return $this->redirect(array('action' => 'index'));
            }
        }
        $options = array('conditions' => array('Document.' . $this->Document->primaryKey => $id), 'contain' => '');
        $this->set('document', $this->Document->find('first', $options));

        echo 1;
    }

    public function departmentdocuments($dept_id)
    {
        $this->Paginator->settings = array(
            'conditions' => array('Document.department_id =' => $dept_id),
        );
        $data = $this->Paginator->paginate('Document');

        $department = $this->Document->Department->findById($dept_id);

        $this->set('department', $department);
        $this->set('documents', $data);

        $this->loadModel('AuditTrail');

        $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
        $auditTrail['AuditTrail']['event_description'] = "Viewing the documents documents in department id ".$dept_id;

        $auditTrail['AuditTrail']['contents'] = "Viewing the documents in department with id ".$dept_id;
        if( !$this->AuditTrail->save($auditTrail))
        {
            die('There was a problem trying to save the audit trail');
        }

    }

    public function urguent() {
        $this->Paginator->settings = array(
            'conditions' => array('Document.priority =' =>'high', 'Document.tracker <>' =>'10', 'Document.tracker =' => $this->Auth->user()['user_type_id'] )
        );
        $data = $this->Paginator->paginate('Document');

        $this->set('documents', $data);

        $this->loadModel('AuditTrail');

        $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
        $auditTrail['AuditTrail']['event_description'] = "Viewing the urguent documents ";

        $auditTrail['AuditTrail']['contents'] = "Viewing the urgent documents ";
        if( !$this->AuditTrail->save($auditTrail))
        {
            die('There was a problem trying to save the audit trail');
        }

    }

    public function reports($dept_id = 1) {

        if ($this->request->is('post')) {
         print_r($this->request->data);
        }
        $query = "SELECT documents.*, departments.name, departments.id FROM documents
                    join departments on departments.id = documents.department_id ";

        $data = $this->Document->query($query);

        $all_data = [];
        foreach($data as $dt) {
        }

        $all_data = $data;
//print_r($all_data);
        $departments = $this->Document->Department->find('list');

        $this->set('departments', $departments);

        $this->set('documents', $all_data);

        $this->loadModel('AuditTrail');

        $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
        $auditTrail['AuditTrail']['event_description'] = "Viewing the documents documents in department id ".$dept_id;

        $auditTrail['AuditTrail']['contents'] = "Viewing the documents in department with id ".$dept_id;
        if( !$this->AuditTrail->save($auditTrail))
        {
            die('There was a problem trying to save the audit trail');
        }
    }

    public function sendFile($id) {
        $options = array('conditions' => array('Document.' . $this->Document->primaryKey => $id));
        $file = $this->Document->find('first', $options);
        $path = '/webroot/uploads/documents_compiled/'.$file['Document']['compiled_document'];
       // echo $path;die;
        $this->response->file(
                                $path,
                                [
                                    'download' => true,
                                    'name' => $file['Document']['document_name']
                                ]
        );
        // Return response object to prevent controller from trying to render
        // a view
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
		if (!$this->Document->exists($id)) {
			throw new NotFoundException(__('Invalid document'));
		}
		$options = array('conditions' => array('Document.' . $this->Document->primaryKey => $id));
		$this->set('document', $this->Document->find('first', $options));

        $this->loadModel('AuditTrail');

        $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
        $auditTrail['AuditTrail']['event_description'] = "Viewing a document with id ".$id;

        $auditTrail['AuditTrail']['contents'] = "Viewing a document";
        if( !$this->AuditTrail->save($auditTrail))
        {
            die('There was a problem trying to save the audit trail');
        }
	}

    /*************************************************************************************************
     * @param null $id
     */
    public function decide($id = null)
    {
        if(!$id) {
            $id = $this->request->data['DocumentsTracker']['id'];
        }

		if (!$this->Document->exists($id)) {
			throw new NotFoundException(__('The document you are requesting for cannot be located'));
		}

        $decision = 0;
        $goes_to = 0;
        $user_type_id = $this->Auth->user('user_type_id');
        $subject = 'Document compiled need your review';
        $email_body = 'Document compiled need your review';

        $auditTrail['AuditTrail']['event_description'] = "User with id ".$this->Auth->user('id')."
				                                          is viewing document with id  ".$id." inorder to make a decision";

        if (isset($this->request->data['submit1'])) {
            // yes button was clicked
            $decision = 1;
            $template = "approved";
            $subject = 'Document compiled with id '.$id.' has been approved';
            $email_body = "Your document was approved with the following reason ".$this->request->data['DocumentRequest']['reason'];
        } else if (isset($this->request->data['submit2'])) {
            // no button was clicked
            $decision = 2;
            $template = "declined";
            $subject = 'Document compiled with id '.$id.' has been declined' ;
            $email_body = 'Document was declined '.$this->request->data['DocumentRequest']['reason'];
        }

        //Save the audit trail
        $this->loadModel('AuditTrail');
        //Save the document trail
        $this->loadModel('DocumentsTracker');

        if ($this->request->is(['post', 'put'])) {
            //Determine the escalations
            if (in_array($user_type_id, [2, 3, 10, 11])) {
                if ($user_type_id == 2) {
                    $goes_to = 3;
                } else {
                    $goes_to = 10;
                }
            }

            $conditions = array("User.user_type_id" => $goes_to);
            $Approver = $this->Document->User->find('first', array('conditions' => $conditions));

            /************************** Save the reason and redirect back ********************************/

            $documentTracker['DocumentsTracker']['user_id'] = $this->Auth->user('id');
            $documentTracker['DocumentsTracker']['document_id'] = $id;
            $documentTracker['DocumentsTracker']['status_id'] = 1;
            $documentTracker['DocumentsTracker']['level_id'] = 1;
            $documentTracker['DocumentsTracker']['date_brought'] = date('Y-m-d');
            $documentTracker['DocumentsTracker']['assigned_to'] = $user_type_id;
            $documentTracker['DocumentsTracker']['brought_by'] = $user_type_id;
            $documentTracker['DocumentsTracker']['assignee_updated'] = $decision;
            $documentTracker['DocumentsTracker']['update_reason'] = $this->request->data['DocumentRequest']['reason'];

            if ($user_type_id == 3 || $user_type_id == 10)
            {
                $documentTracker['DocumentsTracker']['updated_by'] = $user_type_id;
            }

            //update tracker on document
            $this->Document->id = $id;
            if ($decision == 2) $goes_to = 10;
            $this->Document->saveField('tracker', $goes_to);

            if ($this->DocumentsTracker->save($documentTracker)) {

            } else {
                debug($this->DocumentsTracker->invalidFields());
            }
            $redirect = 1;
            $auditTrail['AuditTrail']['event_description'] = "User with id " . $this->Auth->user('id') . "
				                                          has decided to  " . $decision . " and a notification has been sent to ";


            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['contents'] = "Making a decision on document";

            if (!$this->AuditTrail->save($auditTrail)) {
                die('There was a problem trying to save the audit trail');
            }

            if ($redirect) {

                $actual_document = $this->Document->findById($id);

                $Email = new CakeEmail();

                if ($this->Auth->user()['user_type_id'] == 3 || $this->Auth->user()['user_type_id'] == 10) //3 is the ceo
                {
                    $subject = $subject . ' by ' . $this->Auth->user()['fname'] . ' ' . $this->Auth->user()['sname'];
                    //Send the notification to the logged in user.
                    $Email->from(array('no-reply@documentstracker.com' => 'Matjhabeng Local Municipality Document Management System'))
                        ->template($template, 'default')
                        ->emailFormat('html')
                        ->viewVars(array('details' => $email_body))
                        ->to($actual_document['Document']['email'])
                        ->bcc('maffins@gmail.com')
                        ->subject($subject)
                        ->send();
                } else {
                    $subject = $subject . ' by ' . $Approver['User']['fname'] . ' ' . $Approver['User']['sname'];

                    $Email->from(array('no-reply@documentstracker.com' => 'Matjhabeng Local Municipality Document Management System'))
                        ->template($template, 'default')
                        ->emailFormat('html')
                        ->viewVars(array('details' => $email_body))
                        ->to($actual_document['Document']['email'])
                        ->bcc('maffins@gmail.com')
                        ->subject($subject)
                        ->send();
                }


                $this->Flash->success(__('Your decision and reason was successfully saved and notification sent.'));
                return $this->redirect(array('action' => 'index'));
            }
        }
		$options = array('conditions' => array('Document.' . $this->Document->primaryKey => $id), 'contain' => '');
		$this->set('document', $this->Document->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {

        date_default_timezone_set('UTC');

		if ($this->request->is('post')) {
			$this->Document->create();
			$this->request->data['Document']['status'] = 'Sent to Manager';

            $myUploads = $this->request->data['Document']['compiled_document'];
            unset($this->request->data['Document']['compiled_document']);

            $allGood = 0;

            foreach( $myUploads as $upload)
            {
                if (!empty($upload['name']))
                {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'documents_compiled' . DS . $file['name']);
                    //prepare the filename for database entry
                    $this->request->data['Document']['compiled_document'] = $file['name'];
                    $this->request->data['Document']['original_name'] = $original_name;

                } else {
                    $this->request->data['Document']['compiled_document'] = 'No Document';
                }

                //Save the audit trail
                $this->loadModel('AuditTrail');
                if ($this->Auth->user()['user_type_id'] == 8 || $this->Auth->user()['user_type_id'] == 12) {
                    $this->request->data['Document']['tracker'] = 3;
                } else {
                    $this->request->data['Document']['tracker'] = 2;
                }

                $this->request->data['Document']['user_id'] = $this->Auth->user('id');

                /**
                 * This section is to check if we have all the users
                 * If not then notify the user
                 * the same code is also on line
                 */

                $conditions = array("User.approver" => 1, "User.user_type_id" => 2);

                $Approver = $this->Document->User->find('all', array('conditions' => $conditions));

                if (!$Approver) {

                    $conditions = array("User.approver" => 1, "User.user_type_id" => 11);

                    $Approver = $this->Document->User->find('all', array('conditions' => $conditions));

                    if (!$Approver)
                    {
                        //This means the next approver does not exist so notify and redirect
                        $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
                        $auditTrail['AuditTrail']['event_description'] = "Document with name " . $this->request->data['Document']['compiled_document'] . " could not be saved because all users are not yet created";

                        $auditTrail['AuditTrail']['contents'] = "Document creation failed";
                        if (!$this->AuditTrail->save($auditTrail)) {
                            die('There was a problem trying to save the audit trail on checking users');
                        }
                        $this->Flash->error(__('The document creation could not continue as the CFO has not been created yet in the system.'));
                        // return $this->redirect(array('action' => 'add'));
                        $allGood = 1;
                    }
                }

                $this->Document->create();
                if ($this->Document->save($this->request->data)) {
                    //Save the tracking of the document
                    $doc_id = $this->Document->id;

                    $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
                    $auditTrail['AuditTrail']['event_description'] = "Compiling a document by user with id " . $this->request->data['Document']['fname'] . ' ' . $this->request->data['Document']['sname'] . "
                    and the document id is " . $doc_id;

                    $auditTrail['AuditTrail']['contents'] = "Document compiled to send";

                    if (!$this->AuditTrail->save($auditTrail)) {
                        die('There was a problem trying to save the audit trail');

                    }

                    if (!$Approver) {
                        $this->Flash->error(__('The CFO was not found in the system please contact the administrator.'));
                       // return $this->redirect(array('action' => 'index'));
                        $allGood = 1;
                    }

                    $Email = new CakeEmail();
                    //GEt all the list managers in that department, and email all of them.
                    foreach ($Approver as $mgrs) {
                        $emails = $mgrs['User']['email'];
                        $Email->template('documentcompiled', 'default')
                            ->viewVars(array('details' => $this->request->data['Document']))
                            ->emailFormat('html')
                            ->subject('Document needing your attention')
                            ->to($emails)
                            ->bcc('maffins@gmail.com')
                            ->from('no-reply@documents.co.za')
                            ->send();

                        //This is if we have an acting CFO
                        $conditions = array("User.approver" => 1, "User.user_type_id" => 11);

                        $Approver = $this->Document->User->find('all', array('conditions' => $conditions));

                        if (!$Approver)
                        {

                        } else {
                            foreach ($Approver as $mgrs) {
                                $emails = $mgrs['User']['email'];
                                $Email->template('documentcompiled', 'default')
                                    ->viewVars(array('details' => $this->request->data['Document']))
                                    ->emailFormat('html')
                                    ->subject('Document needing your attention')
                                    ->to($emails)
                                    ->bcc('maffins@gmail.com')
                                    ->from('no-reply@documents.co.za')
                                    ->send();
                            }
                        }
                    }

                    //Also send email to document owner
                    $emails = $this->request->data['Document']['email'];
                    $Email->template('documentcompiled', 'default')
                        ->viewVars(array('details' => $this->request->data['Document']))
                        ->emailFormat('html')
                        ->subject('Your document has been captured')
                        ->to($emails)
                        ->from('no-reply@documents.co.za')
                        ->send();

                    //Now also email hte one who compiled the document
                    $conditions = array("User.id" => $this->Auth->user('id'));
                    $compiler = $this->Document->User->find('all', array('conditions' => $conditions));
                    $emails = $compiler[0]['User']['email'];
                    $Email->template('documentcompiled', 'default')
                        ->viewVars(array('details' => $this->request->data['Document']))
                        ->emailFormat('html')
                        ->subject('Your document has been captured')
                        ->to($emails)
                        ->from('no-reply@documents.co.za')
                        ->send();

                    $this->loadModel('DocumentsTracker');

                    $documentTracker['DocumentsTracker']['user_id'] = $this->Auth->user('id');
                    $documentTracker['DocumentsTracker']['document_id'] = $doc_id;
                    $documentTracker['DocumentsTracker']['status_id'] = 1;
                    $documentTracker['DocumentsTracker']['level_id'] = 1;
                    $documentTracker['DocumentsTracker']['date_brought'] = date('Y-m-d');
                    $documentTracker['DocumentsTracker']['assigned_to'] = 2;
                    $documentTracker['DocumentsTracker']['brought_by'] = 2;

                    if (!$this->DocumentsTracker->save($documentTracker)) {
                        debug($this->DocumentsTracker->invalidFields());
                    }

                    $this->Flash->success(__('The document has been saved.'));

                    $this->loadModel('AuditTrail');

                    $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
                    $auditTrail['AuditTrail']['event_description'] = "Successfully created document with id " . $doc_id;

                    $auditTrail['AuditTrail']['contents'] = "Successfully created a document";
                    if (!$this->AuditTrail->save($auditTrail)) {
                        die('There was a problem trying to save the audit trail');
                    }

                   // return $this->redirect(array('action' => 'index'));
                    $allGood = 2;

                } else {
                    die('There was a problem in execution');
                    $this->Flash->error(__('The document could not be saved. Please, try again.'));
                }
            }

            if($allGood == 1)
            {
                $this->Flash->error(__('The CFO was not found in the system please contact the administrator.'));
            }

            if($allGood == 1)
            {
                $this->Flash->error(__('Successfully created a document/s.'));
            }
             return $this->redirect(array('action' => 'index'));

		}

		$users = $this->Document->User->findById($this->Auth->user('id'));
		$departments = $this->Document->Department->find('list');
		$this->set(compact('users', 'departments'));

        $this->loadModel('AuditTrail');

        $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
        $auditTrail['AuditTrail']['event_description'] = "Open the compile document page";

        $auditTrail['AuditTrail']['contents'] = "Opened the compile document page";
        if( !$this->AuditTrail->save($auditTrail))
        {
            die('There was a problem trying to save the audit trail');
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
        if (!$this->Document->exists($id)) {
            throw new NotFoundException(__('Invalid document'));
        }


        if ($this->request->is(array('post', 'put'))) {

            $this->request->data['Document']['status'] = 'Sent to Manager';
            //Check if there is a way leave certificate

            if(!empty($this->request->data['Document']['compiled_document']['name']))
            {
                $file = $this->request->data['Document']['compiled_document']; //put the data into a var for easy use
                move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' .DS.'documents_compiled'.DS. $file['name']);

                //prepare the filename for database entry
                $this->request->data['Document']['compiled_document'] = $this->request->data['Document']['compiled_document']['name'];
            } else {
                $this->request->data['Document']['compiled_document'] = 'No Document';
            }
            //Save the audit trail
            $this->loadModel('AuditTrail');
            $this->request->data['Document']['tracker'] = 2;
            /**
             * This section is to check if we have all the users
             * If not then notify the user
             * the same code is also on line
             */

            if ($this->Document->save($this->request->data)) {
                //Save the tracking of the document
                $doc_id = $this->Document->id;

                $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
                $auditTrail['AuditTrail']['event_description'] = "Compiling a document by user with id ". $this->request->data['Document']['fname'].' '.$this->request->data['Document']['sname']."
				and the document id is ".$doc_id;

                $auditTrail['AuditTrail']['contents'] = "Document compiled to send";

                if( !$this->AuditTrail->save($auditTrail))
                {
                    die('There was a problem trying to save the audit trail');

                }
                $this->Flash->success(__('Edited successfuly.'));

                $this->loadModel('AuditTrail');

                $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
                $auditTrail['AuditTrail']['event_description'] = "Successfully edited document with id ".$doc_id;

                $auditTrail['AuditTrail']['contents'] = "Successfully edited a document";
                if( !$this->AuditTrail->save($auditTrail))
                {
                    die('There was a problem trying to save the audit trail');
                }

                return $this->redirect(array('action' => 'index'));

            } else {
                $this->Flash->error(__('The document could not be edited. Please, try again.'));
            }
        }else {
            $options = array('conditions' => array('Document.' . $this->Document->primaryKey => $id));
            $this->request->data = $this->Document->find('first', $options);
        }


        $users = $this->Document->User->find('list');
        $departments = $this->Document->Department->find('list');
        $this->set(compact('users', 'departments'));
    }

    public function editCFO($id = null) {
        if (!$this->Document->exists($id)) {
            throw new NotFoundException(__('Invalid document'));
        }

        if ($this->request->is(array('post', 'put'))) {

            $this->request->data['Document']['status'] = 'Sent to Manager';
            //Check if there is a way leave certificate

            if(!empty($this->request->data['Document']['compiled_document']['name']))
            {
                $file = $this->request->data['Document']['compiled_document']; //put the data into a var for easy use
                move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' .DS.'documents_compiled'.DS. $file['name']);

                //prepare the filename for database entry
                $this->request->data['Document']['compiled_document'] = $this->request->data['Document']['compiled_document']['name'];
            } else {
                unset($this->request->data['Document']['compiled_document']);
            }
            //Save the audit trail
            $this->loadModel('AuditTrail');

            $user_type_id = $this->Auth->user()['user_type_id'];

            $tireka = "";
            $reason = $this->request->data['Document']['edit_reason'];
            unset($this->request->data['Document']['edit_reason']);

            if ($user_type_id == 7 || $user_type_id == 13)
            {
                $tireka = 2;
                $this->request->data['Document']['edit_cfo'] = $reason;
            }
            if ($user_type_id == 8 || $user_type_id == 12)
            {
                $tireka = 3;
                $this->request->data['Document']['edit_ceo'] = $reason;
            }
            $conditions = array("User.user_type_id" => $tireka);
            $ceo_cfo = $this->Document->User->find('first', array('conditions' => $conditions));

            $this->request->data['Document']['tracker'] = $tireka;
            /**
             * This section is to check if we have all the users
             * If not then notify the user
             * the same code is also on line
             */

            if ($this->Document->save($this->request->data)) {
                //Save the tracking of the document
                $doc_id = $this->Document->id;
                $actual_document = $this->Document->findById($doc_id);
                //Email the relevant person (Either CFO or CEO)
                $Email = new CakeEmail();
                //GEt all the list managers in that department, and email all of them.
//print_r($ceo_cfo);die;
                    $emails = $ceo_cfo['User']['email'];
                    $Email->template('editeddocument', 'default')
                        ->viewVars(array('details' => $actual_document, 'comment' => $reason))
                        ->emailFormat('html')
                        ->subject('Document edited by Secretary needing your attention')
                        ->to($emails)
                        ->bcc('maffins@gmail.com')
                        ->from('no-reply@documents.co.za')
                        ->send();

                $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
                $auditTrail['AuditTrail']['event_description'] = "Edit a document by user with id ". $this->request->data['Document']['fname'].' '.$this->request->data['Document']['sname']."
				previously declined and the document id is ".$doc_id;

                $auditTrail['AuditTrail']['contents'] = "Document edited ";

                if( !$this->AuditTrail->save($auditTrail))
                {
                    die('There was a problem trying to save the audit trail');

                }
                $this->Flash->success(__('Edited successfuly.'));

                $this->loadModel('AuditTrail');

                $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
                $auditTrail['AuditTrail']['event_description'] = "Successfully edited document with id ".$doc_id;

                $auditTrail['AuditTrail']['contents'] = "Successfully edited a document";
                if( !$this->AuditTrail->save($auditTrail))
                {
                    die('There was a problem trying to save the audit trail');
                }

                return $this->redirect(array('action' => 'index'));

            } else {
                $this->Flash->error(__('The document could not be edited. Please, try again.'));
            }
        }else {
            $options = array('conditions' => array('Document.' . $this->Document->primaryKey => $id));
            $this->request->data = $this->Document->find('first', $options);
        }


        $users = $this->Document->User->find('list');
        $departments = $this->Document->Department->find('list');
        $this->set(compact('users', 'departments'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Document->id = $id;
        if (!$this->Document->exists()) {
            throw new NotFoundException(__('Invalid document'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Document->delete()) {
            $this->Flash->success(__('The document has been deleted.'));
        } else {
            $this->Flash->error(__('The document could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * acting report method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function actingreports($id = null)
    {
        $this->loadModel('AuditTrail');
        $this->AuditTrail->recursive = 0;
        $this->set('auditTrails', $this->Paginator->paginate());
    }
}
