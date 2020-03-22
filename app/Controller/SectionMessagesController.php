<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * SectionMessages Controller
 *
 * @property SectionMessage $SectionMessage
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class SectionMessagesController extends AppController {

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
	public function index() {
		$sections = $this->SectionMessage->Section->find('list', ['order' => ['id' => 'DESC']]);

		$this->SectionMessage->recursive = 0;
		$this->set('sectionMessages', $this->Paginator->paginate());
		$this->set('sections', $sections);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SectionMessage->exists($id)) {
			throw new NotFoundException(__('Invalid section message'));
		}
		$options = array('conditions' => array('SectionMessage.' . $this->SectionMessage->primaryKey => $id));
		$this->set('sectionMessage', $this->SectionMessage->find('first', $options));
	}
	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() 
	{
		if ($this->request->is('post'))
		 {
			$sendemail = $this->request->data['SectionMessage']['sendemail'];
			unset($this->request->data['SectionMessage']['sendemail']);

			$sendsms = $this->request->data['SectionMessage']['sendsms'];
			unset($this->request->data['SectionMessage']['sendsms']);

			$other = $this->request->data['SectionMessage']['othernumbers'];
			unset($this->request->data['SectionMessage']['othernumbers']);

			$this->SectionMessage->create();
			if ($this->SectionMessage->save($this->request->data)) 
			{
				//This is for sending emails to others not part of counciler user type
				if($sendsms) 
				{
					if($other)
					{
						$this->sendsms($this->request->data['SectionMessage']['smsmessage'], $other, 1);						
					} else {
						$this->sendsms($this->request->data['SectionMessage']['smsmessage'], $this->request->data['SectionMessage']['section_id'], 0);
					}
				}

				if($sendemail) 
				{
					$this->sendemail($this->request->data['SectionMessage']['message'], $this->request->data['SectionMessage']['subject'], $this->request->data['SectionMessage']['section_id']);
				}

				$this->Session->setFlash(__('The section message has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The section message could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}

		$users = $this->SectionMessage->User->find('list');
		$sections = $this->SectionMessage->Section->find('list');
		$sections[100] = 'Other';

		$this->set(compact('users', 'sections'));
	}

	/**************************************************************************************************************************/

	  function sendsms($message = null, $section_id, $other)
	  {
	      $this->loadModel('User');
	      $users = $this->User->find('all');

	      $thedetails = [];
	      $torecive   = [];
	      $numbers    = "";

		  if($other)
		  {
			$numbers = preg_replace('#\s+#',',',trim($section_id));
			$numbers = $numbers . ',';

		  } else {
			foreach ($users as $user)
			{
				if( in_array($section_id, unserialize($user['User']['sections'])) )
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

		  }

	      $numbers .= '27817549884';

		  if(!$message)
		  {
			$this->Session->setFlash(__('You did not enter the message, please enter the message you want to send'), 'default', array('class' => 'alert alert-success'));
			return $this->redirect(array('action' => 'add'));
		  }
	      $smsText = urlencode($message);

	      //$url = "http://78.46.17.110/app/smsapi/index.php?key=5bd18d48532d6&type=text&title=&contacts={$numbers}&groupid=&senderid=MAFFINS&msg={$smsText}&time=&time_zone=";
	      $url = "http://148.251.196.36/app/smsapi/index.php?key=5c6d72f0f094d&type=text&contacts={$numbers}&senderid=Matjabheng&msg={$smsText}&time=";

	      $mystring = $this->get_data($url);
	  }

	  function sendemail($message = null, $subject = null, $section_id)
	  {
	      $Email = new CakeEmail();

	      $this->loadModel('User');
	      $users = $this->User->find('all');

	      foreach ($users as $user) {
	          if (in_array($section_id, unserialize($user['User']['sections']))) {
	            $Email->from(array('no-reply@matjabheng.com' => 'Matjhabeng Local Municipality Document Management System'))
	                ->template('newmeetingposted', 'default')
	                ->emailFormat('html')
	                ->viewVars(array('meeting' => $message))
	                //->to(trim($user['User']['email']))
	                //->to('mapaepae@gmail.com')
	                ->to('maffins@gmail.com')
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
		if (!$this->SectionMessage->exists($id)) {
			throw new NotFoundException(__('Invalid section message'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SectionMessage->save($this->request->data)) {
				$this->Session->setFlash(__('The section message has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The section message could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('SectionMessage.' . $this->SectionMessage->primaryKey => $id));
			$this->request->data = $this->SectionMessage->find('first', $options);
		}
		$users = $this->SectionMessage->User->find('list');
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
		$this->SectionMessage->id = $id;
		if (!$this->SectionMessage->exists()) {
			throw new NotFoundException(__('Invalid section message'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->SectionMessage->delete()) {
			$this->Session->setFlash(__('The section message has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The section message could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
