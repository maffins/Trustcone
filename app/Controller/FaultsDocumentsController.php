<?php
App::uses('AppController', 'Controller');
/**
 * FaultsDocuments Controller
 *
 * @property FaultsDocument $FaultsDocument
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class FaultsDocumentsController extends AppController {

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
		$this->FaultsDocument->recursive = 0;
		$this->set('faultsDocuments', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->FaultsDocument->exists($id)) {
			throw new NotFoundException(__('Invalid faults document'));
		}
		$options = array('conditions' => array('FaultsDocument.' . $this->FaultsDocument->primaryKey => $id));
		$this->set('faultsDocument', $this->FaultsDocument->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->FaultsDocument->create();
			if ($this->FaultsDocument->save($this->request->data)) {
				$this->Session->setFlash(__('The faults document has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The faults document could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$faults = $this->FaultsDocument->Fault->find('list');
		$this->set(compact('faults'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->FaultsDocument->exists($id)) {
			throw new NotFoundException(__('Invalid faults document'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->FaultsDocument->save($this->request->data)) {
				$this->Session->setFlash(__('The faults document has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The faults document could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('FaultsDocument.' . $this->FaultsDocument->primaryKey => $id));
			$this->request->data = $this->FaultsDocument->find('first', $options);
		}
		$faults = $this->FaultsDocument->Fault->find('list');
		$this->set(compact('faults'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->FaultsDocument->id = $id;
		if (!$this->FaultsDocument->exists()) {
			throw new NotFoundException(__('Invalid faults document'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->FaultsDocument->delete()) {
			$this->Session->setFlash(__('The faults document has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The faults document could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
