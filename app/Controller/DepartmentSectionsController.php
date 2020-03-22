<?php
App::uses('AppController', 'Controller');
/**
 * DepartmentSections Controller
 *
 * @property DepartmentSection $DepartmentSection
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class DepartmentSectionsController extends AppController {

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
		$this->DepartmentSection->recursive = 0;
		$this->set('departmentSections', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->DepartmentSection->exists($id)) {
			throw new NotFoundException(__('Invalid department section'));
		}
		$options = array('conditions' => array('DepartmentSection.' . $this->DepartmentSection->primaryKey => $id));
		$this->set('departmentSection', $this->DepartmentSection->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$rec = $this->DepartmentSection->find('first', ['order' => array('DepartmentSection.id' => 'DESC')]);

			$this->request->data['DepartmentSection']['permission'] = $rec['DepartmentSection']['permission']+1;
 			$this->request->data['DepartmentSection']['user_id'] = $this->Auth->user('id');
			$this->DepartmentSection->create();
			if ($this->DepartmentSection->save($this->request->data)) {
				$this->Session->setFlash(__('The department section has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The department section could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$users = $this->DepartmentSection->User->find('list');
		$departments = $this->DepartmentSection->Department->find('list');
		$this->set(compact('users', 'departments'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->DepartmentSection->exists($id)) {
			throw new NotFoundException(__('Invalid department section'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->DepartmentSection->save($this->request->data)) {
				$this->Session->setFlash(__('The department section has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The department section could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('DepartmentSection.' . $this->DepartmentSection->primaryKey => $id));
			$this->request->data = $this->DepartmentSection->find('first', $options);
		}
		$users = $this->DepartmentSection->User->find('list');
		$departments = $this->DepartmentSection->Department->find('list');
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
		$this->DepartmentSection->id = $id;
		if (!$this->DepartmentSection->exists()) {
			throw new NotFoundException(__('Invalid department section'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DepartmentSection->delete()) {
			$this->Session->setFlash(__('The department section has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The department section could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
