<?php
App::uses('AppController', 'Controller');
/**
 * MeetingAttachments Controller
 *
 * @property MeetingAttachment $MeetingAttachment
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SecurityComponent $Security
 * @property SessionComponent $Session
 */
class MeetingAttachmentsController extends AppController {

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
		$this->MeetingAttachment->recursive = 0;
		$this->set('meetingAttachments', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->MeetingAttachment->exists($id)) {
			throw new NotFoundException(__('Invalid meeting attachment'));
		}
		$options = array('conditions' => array('MeetingAttachment.' . $this->MeetingAttachment->primaryKey => $id));
		$this->set('meetingAttachment', $this->MeetingAttachment->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->MeetingAttachment->create();
			if ($this->MeetingAttachment->save($this->request->data)) {
				$this->Session->setFlash(__('The meeting attachment has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meeting attachment could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$meetings = $this->MeetingAttachment->Meeting->find('list');
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
		if (!$this->MeetingAttachment->exists($id)) {
			throw new NotFoundException(__('Invalid meeting attachment'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->MeetingAttachment->save($this->request->data)) {
				$this->Session->setFlash(__('The meeting attachment has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meeting attachment could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('MeetingAttachment.' . $this->MeetingAttachment->primaryKey => $id));
			$this->request->data = $this->MeetingAttachment->find('first', $options);
		}
		$meetings = $this->MeetingAttachment->Meeting->find('list');
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
		$this->MeetingAttachment->id = $id;
		if (!$this->MeetingAttachment->exists()) {
			throw new NotFoundException(__('Invalid meeting attachment'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->MeetingAttachment->delete()) {
			$this->Session->setFlash(__('The meeting attachment has been deleted.'), 'default', array('class' => 'alert alert-success'));

            $this->loadModel('AuditTrail');

            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Deleted attachment item with id ".$id." ".$_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "Deleted attachment item with id ".$id." ".$_SERVER['REMOTE_ADDR'];;
            if( !$this->AuditTrail->save($auditTrail))
            {
                die('There was a problem trying to save the audit trail for adding counsiler document '.$id." ".$_SERVER['REMOTE_ADDR']);
            }

		} else {
			$this->Session->setFlash(__('The meeting attachment could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));

            $this->loadModel('AuditTrail');

            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Attempted to Delete attachment with id ".$id." ".$_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "Attempted to Delete attachment with id ".$id." ".$_SERVER['REMOTE_ADDR'];;
            if( !$this->AuditTrail->save($auditTrail))
            {
                die('There was a problem trying to save the audit trail for adding counsiler document '.$id." ".$_SERVER['REMOTE_ADDR']);
            }

		}
		return $this->redirect(array('controller' => 'CounsilorDocuments', 'action' => 'edit', $mainid));
	}
}
