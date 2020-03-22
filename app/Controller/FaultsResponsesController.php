<?php
App::uses('AppController', 'Controller');
/**
 * FaultsResponses Controller
 *
 * @property FaultsResponse $FaultsResponse
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class FaultsResponsesController extends AppController {

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
		$this->FaultsResponse->recursive = 0;
		$this->set('faultsResponses', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->FaultsResponse->exists($id)) {
			throw new NotFoundException(__('Invalid faults response'));
		}
		$options = array('conditions' => array('FaultsResponse.' . $this->FaultsResponse->primaryKey => $id));
		$this->set('faultsResponse', $this->FaultsResponse->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->FaultsResponse->create();
			if ($this->FaultsResponse->save($this->request->data)) {
				$this->Session->setFlash(__('The faults response has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The faults response could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$faults = $this->FaultsResponse->Fault->find('list');
		$users = $this->FaultsResponse->User->find('list');
		$this->set(compact('faults', 'users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->FaultsResponse->exists($id)) {
			throw new NotFoundException(__('Invalid faults response'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->FaultsResponse->save($this->request->data)) {
				$this->Session->setFlash(__('The faults response has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The faults response could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('FaultsResponse.' . $this->FaultsResponse->primaryKey => $id));
			$this->request->data = $this->FaultsResponse->find('first', $options);
		}
		$faults = $this->FaultsResponse->Fault->find('list');
		$users = $this->FaultsResponse->User->find('list');
		$this->set(compact('faults', 'users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->FaultsResponse->id = $id;
		if (!$this->FaultsResponse->exists()) {
			throw new NotFoundException(__('Invalid faults response'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->FaultsResponse->delete()) {
			$this->Session->setFlash(__('The faults response has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The faults response could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
