<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * FaultsComments Controller
 *
 * @property FaultsComment $FaultsComment
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property RequestHandlerComponent $RequestHandler
 * @property SessionComponent $Session
 */
class FaultsCommentsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'RequestHandler', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->FaultsComment->recursive = 0;
		$this->set('faultsComments', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->FaultsComment->exists($id)) {
			throw new NotFoundException(__('Invalid faults comment'));
		}
		$options = array('conditions' => array('FaultsComment.' . $this->FaultsComment->primaryKey => $id));
		$this->set('faultsComment', $this->FaultsComment->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($id)
    {
        if ($this->request->is('post')) {

            $fault_id = $this->request->data['FaultsComment']['fault_id_now'];

            $this->request->data['FaultsComment']['user_id'] = $this->Auth->user('id');
            $this->request->data['FaultsComment']['fault_id'] = $fault_id;
            $actual_comment = $this->request->data['FaultsComment']['comment'];
            unset($this->request->data['FaultsComment']['fault_id_now']);

            //print_r($this->request->data);die;
            $this->FaultsComment->create();

            if ($this->FaultsComment->save($this->request->data)) {

                //Compose and email and send to the counsilor who reported the fault
                $Email = new CakeEmail();

                $this->loadModel('Fault');
                $options = array('conditions' => array('Fault.' . $this->Fault->primaryKey => $fault_id));
                $fault = $this->Fault->find('first', $options);

                $this->loadModel('User');
                $options = array('conditions' => array('User.' . $this->User->primaryKey => $fault['User']['id']));
                $counsilor = $this->User->find('first', $options);

                $subject = "Fault Comment added";
                //Send the notification to the logged in user.
                $Email->from(array('no-reply@lejweleputswa.com' => 'Documents Tracker Faults'))
                    ->template('faultcomment', 'default')
                    ->emailFormat('html')
                    ->viewVars(array('comment' => $actual_comment, 'name' => $counsilor['User']['fname'] . ' ' . $counsilor['User']['sname']))
                    ->to($counsilor['User']['email'])
                    ->bcc('maffins@gmail.com')
                    ->subject($subject)
                    ->send();

                $this->Session->setFlash(__('The faults comment has been saved and the reporting counsilor has been notified.'), 'default', array('class' => 'alert alert-success'));
                return $this->redirect(array('action' => 'view', 'controller' => 'Faults', $fault_id));
            } else {
                $this->Session->setFlash(__('The faults comment could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
            }
        }

		$users = $this->FaultsComment->User->find('list');
		$faults = $this->FaultsComment->Fault->find('list');
		$this->set(compact('users', 'faults'));
        $this->set('user_type_id', $this->Auth->user()['user_type_id']);
        $this->set('fault_id', $id);
 }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->FaultsComment->exists($id)) {
			throw new NotFoundException(__('Invalid faults comment'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->FaultsComment->save($this->request->data)) {
				$this->Session->setFlash(__('The faults comment has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The faults comment could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('FaultsComment.' . $this->FaultsComment->primaryKey => $id));
			$this->request->data = $this->FaultsComment->find('first', $options);
		}
		$users = $this->FaultsComment->User->find('list');
		$faults = $this->FaultsComment->Fault->find('list');
		$this->set(compact('users', 'faults'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->FaultsComment->id = $id;
		if (!$this->FaultsComment->exists()) {
			throw new NotFoundException(__('Invalid faults comment'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->FaultsComment->delete()) {
			$this->Session->setFlash(__('The faults comment has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The faults comment could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
