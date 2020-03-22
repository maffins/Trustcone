<?php
App::uses('AppController', 'Controller');
/**
 * AuditTrails Controller
 *
 * @property AuditTrail $AuditTrail
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SecurityComponent $Security
 * @property SessionComponent $Session
 */
class AuditTrailsController extends AppController {

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Js');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'Security', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->AuditTrail->recursive = 0;
		//$allmeetings = $this->AuditTrail->find('all');
		
		$this->set('auditTrails', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->AuditTrail->exists($id)) {
			throw new NotFoundException(__('Invalid audit trail'));
		}
		$options = array('conditions' => array('AuditTrail.' . $this->AuditTrail->primaryKey => $id));
		$this->set('auditTrail', $this->AuditTrail->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->AuditTrail->create();
			if ($this->AuditTrail->save($this->request->data)) {
				$this->Flash->success(__('The audit trail has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The audit trail could not be saved. Please, try again.'));
			}
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
		if (!$this->AuditTrail->exists($id)) {
			throw new NotFoundException(__('Invalid audit trail'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->AuditTrail->save($this->request->data)) {
				$this->Flash->success(__('The audit trail has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The audit trail could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('AuditTrail.' . $this->AuditTrail->primaryKey => $id));
			$this->request->data = $this->AuditTrail->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->AuditTrail->id = $id;
		if (!$this->AuditTrail->exists()) {
			throw new NotFoundException(__('Invalid audit trail'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->AuditTrail->delete()) {
			$this->Flash->success(__('The audit trail has been deleted.'));
		} else {
			$this->Flash->error(__('The audit trail could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
