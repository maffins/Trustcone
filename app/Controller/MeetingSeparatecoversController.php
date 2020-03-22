<?php
App::uses('AppController', 'Controller');
/**
 * MeetingSeparatecovers Controller
 *
 * @property MeetingSeparatecover $MeetingSeparatecover
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class MeetingSeparatecoversController extends AppController {

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
		$this->MeetingSeparatecover->recursive = 0;
		$this->set('meetingSeparatecovers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->MeetingSeparatecover->exists($id)) {
			throw new NotFoundException(__('Invalid meeting separatecover'));
		}
		$options = array('conditions' => array('MeetingSeparatecover.' . $this->MeetingSeparatecover->primaryKey => $id));
		$this->set('meetingSeparatecover', $this->MeetingSeparatecover->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->MeetingSeparatecover->create();
			if ($this->MeetingSeparatecover->save($this->request->data)) {
				$this->Session->setFlash(__('The meeting separatecover has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meeting separatecover could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$meetings = $this->MeetingSeparatecover->Meeting->find('list');
		$users = $this->MeetingSeparatecover->User->find('list');
		$this->set(compact('meetings', 'users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->MeetingSeparatecover->exists($id)) {
			throw new NotFoundException(__('Invalid meeting separatecover'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->MeetingSeparatecover->save($this->request->data)) {
				$this->Session->setFlash(__('The meeting separatecover has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meeting separatecover could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('MeetingSeparatecover.' . $this->MeetingSeparatecover->primaryKey => $id));
			$this->request->data = $this->MeetingSeparatecover->find('first', $options);
		}
		$meetings = $this->MeetingSeparatecover->Meeting->find('list');
		$users = $this->MeetingSeparatecover->User->find('list');
		$this->set(compact('meetings', 'users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->MeetingSeparatecover->id = $id;
		if (!$this->MeetingSeparatecover->exists()) {
			throw new NotFoundException(__('Invalid meeting separatecover'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->MeetingSeparatecover->delete()) {
			$this->Session->setFlash(__('The meeting separatecover has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The meeting separatecover could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
