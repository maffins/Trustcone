<?php
App::uses('AppController', 'Controller');
/**
 * CommunicationLogs Controller
 *
 * @property CommunicationLog $CommunicationLog
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class CommunicationLogsController extends AppController {

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
		$this->CommunicationLog->recursive = 0;
		$this->set('communicationLogs', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CommunicationLog->exists($id)) {
			throw new NotFoundException(__('Invalid communication log'));
		}
		$options = array('conditions' => array('CommunicationLog.' . $this->CommunicationLog->primaryKey => $id));
		$this->set('communicationLog', $this->CommunicationLog->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CommunicationLog->create();
			if ($this->CommunicationLog->save($this->request->data)) {
				$this->Flash->success(__('The communication log has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The communication log could not be saved. Please, try again.'));
			}
		}
		$users = $this->CommunicationLog->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CommunicationLog->exists($id)) {
			throw new NotFoundException(__('Invalid communication log'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CommunicationLog->save($this->request->data)) {
				$this->Flash->success(__('The communication log has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The communication log could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CommunicationLog.' . $this->CommunicationLog->primaryKey => $id));
			$this->request->data = $this->CommunicationLog->find('first', $options);
		}
		$users = $this->CommunicationLog->User->find('list');
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
		$this->CommunicationLog->id = $id;
		if (!$this->CommunicationLog->exists()) {
			throw new NotFoundException(__('Invalid communication log'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->CommunicationLog->delete()) {
			$this->Flash->success(__('The communication log has been deleted.'));
		} else {
			$this->Flash->error(__('The communication log could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
