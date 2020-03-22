<?php
App::uses('AppController', 'Controller');
/**
 * TemporaryCommittees Controller
 *
 * @property TemporaryCommittee $TemporaryCommittee
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property nComponent $n
 * @property SessionComponent $Session
 */
class TemporaryCommitteesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'N', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->TemporaryCommittee->recursive = 0;
		$this->set('temporaryCommittees', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->TemporaryCommittee->exists($id)) {
			throw new NotFoundException(__('Invalid temporary committee'));
		}
		$options = array('conditions' => array('TemporaryCommittee.' . $this->TemporaryCommittee->primaryKey => $id));
		$this->set('temporaryCommittee', $this->TemporaryCommittee->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TemporaryCommittee->create();
			if ($this->TemporaryCommittee->save($this->request->data)) {
				$this->Session->setFlash(__('The temporary committee has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The temporary committee could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$users = $this->TemporaryCommittee->User->find('list');
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
		if (!$this->TemporaryCommittee->exists($id)) {
			throw new NotFoundException(__('Invalid temporary committee'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->TemporaryCommittee->save($this->request->data)) {
				$this->Session->setFlash(__('The temporary committee has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The temporary committee could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('TemporaryCommittee.' . $this->TemporaryCommittee->primaryKey => $id));
			$this->request->data = $this->TemporaryCommittee->find('first', $options);
		}
		$users = $this->TemporaryCommittee->User->find('list');
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
		$this->TemporaryCommittee->id = $id;
		if (!$this->TemporaryCommittee->exists()) {
			throw new NotFoundException(__('Invalid temporary committee'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->TemporaryCommittee->delete()) {
			$this->Session->setFlash(__('The temporary committee has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The temporary committee could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
