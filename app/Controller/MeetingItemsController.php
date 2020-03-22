<?php
App::uses('AppController', 'Controller');
/**
 * MeetingItems Controller
 *
 * @property MeetingItem $MeetingItem
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class MeetingItemsController extends AppController {

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
		$this->MeetingItem->recursive = 0;
		$this->set('meetingItems', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->MeetingItem->exists($id)) {
			throw new NotFoundException(__('Invalid meeting item'));
		}
		$options = array('conditions' => array('MeetingItem.' . $this->MeetingItem->primaryKey => $id));
		$this->set('meetingItem', $this->MeetingItem->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->MeetingItem->create();
			if ($this->MeetingItem->save($this->request->data)) {
				$this->Session->setFlash(__('The meeting item has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meeting item could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$meetings = $this->MeetingItem->Meeting->find('list');
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
		if (!$this->MeetingItem->exists($id)) {
			throw new NotFoundException(__('Invalid meeting item'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->MeetingItem->save($this->request->data)) {
				$this->Session->setFlash(__('The meeting item has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meeting item could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('MeetingItem.' . $this->MeetingItem->primaryKey => $id));
			$this->request->data = $this->MeetingItem->find('first', $options);
		}
		$meetings = $this->MeetingItem->Meeting->find('list');
		$this->set(compact('meetings'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null, $mainid) {
		$this->MeetingItem->id = $id;
		if (!$this->MeetingItem->exists()) {
			throw new NotFoundException(__('Invalid meeting item'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->MeetingItem->delete()) {
			$this->Session->setFlash(__('The meeting item has been deleted.'), 'default', array('class' => 'alert alert-success'));

            $this->loadModel('AuditTrail');

            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Deleted meeting item with id ".$id." ".$_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "Deleted meeting item with id ".$id." ".$_SERVER['REMOTE_ADDR'];;
            if( !$this->AuditTrail->save($auditTrail))
            {
                die('There was a problem trying to save the audit trail for adding counsiler document '.$id." ".$_SERVER['REMOTE_ADDR']);
            }

        } else {
			$this->Session->setFlash(__('The meeting item could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));

            $this->loadModel('AuditTrail');

            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Attempted to Delete meeting item with id ".$id." ".$_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "Attempted to Delete meeting item with id ".$id." ".$_SERVER['REMOTE_ADDR'];;
            if( !$this->AuditTrail->save($auditTrail))
            {
                die('There was a problem trying to save the audit trail for adding counsiler document '.$id." ".$_SERVER['REMOTE_ADDR']);
            }

        }
		return $this->redirect(array('controller' => 'CounsilorDocuments', 'action' => 'edit',$mainid));
	}
}
