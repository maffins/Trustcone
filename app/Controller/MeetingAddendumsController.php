<?php
App::uses('AppController', 'Controller');
/**
 * MeetingAddendums Controller
 *
 * @property MeetingAddendum $MeetingAddendum
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class MeetingAddendumsController extends AppController {

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
		$this->MeetingAddendum->recursive = 0;
		$this->set('meetingAddendums', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->MeetingAddendum->exists($id)) {
			throw new NotFoundException(__('Invalid meeting addendum'));
		}
		$options = array('conditions' => array('MeetingAddendum.' . $this->MeetingAddendum->primaryKey => $id));
		$this->set('meetingAddendum', $this->MeetingAddendum->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->MeetingAddendum->create();
			if ($this->MeetingAddendum->save($this->request->data)) {
				$this->Session->setFlash(__('The meeting addendum has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meeting addendum could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$meetings = $this->MeetingAddendum->Meeting->find('list');
		$this->set(compact('meetings'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->MeetingAddendum->exists($id)) {
			throw new NotFoundException(__('Invalid meeting addendum'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->MeetingAddendum->save($this->request->data)) {
				$this->Session->setFlash(__('The meeting addendum has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meeting addendum could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('MeetingAddendum.' . $this->MeetingAddendum->primaryKey => $id));
			$this->request->data = $this->MeetingAddendum->find('first', $options);
		}
		$meetings = $this->MeetingAddendum->Meeting->find('list');
		$this->set(compact('meetings'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->MeetingAddendum->id = $id;
		if (!$this->MeetingAddendum->exists()) {
			throw new NotFoundException(__('Invalid meeting addendum'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->MeetingAddendum->delete()) {
			$this->Session->setFlash(__('The meeting addendum has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The meeting addendum could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('controller' => 'CounsilorDocuments', 'action' => 'index'));
	}
}
