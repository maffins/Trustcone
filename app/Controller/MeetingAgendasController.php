<?php
App::uses('AppController', 'Controller');
/**
 * MeetingAgendas Controller
 *
 * @property MeetingAgenda $MeetingAgenda
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SecurityComponent $Security
 * @property SessionComponent $Session
 */
class MeetingAgendasController extends AppController {

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
		$this->MeetingAgenda->recursive = 0;
		$this->set('meetingAgendas', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->MeetingAgenda->exists($id)) {
			throw new NotFoundException(__('Invalid meeting agenda'));
		}
		$options = array('conditions' => array('MeetingAgenda.' . $this->MeetingAgenda->primaryKey => $id));
		$this->set('meetingAgenda', $this->MeetingAgenda->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->MeetingAgenda->create();
			if ($this->MeetingAgenda->save($this->request->data)) {
				$this->Session->setFlash(__('The meeting agenda has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meeting agenda could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$meetings = $this->MeetingAgenda->Meeting->find('list');
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
		if (!$this->MeetingAgenda->exists($id)) {
			throw new NotFoundException(__('Invalid meeting agenda'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->MeetingAgenda->save($this->request->data)) {
				$this->Session->setFlash(__('The meeting agenda has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meeting agenda could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('MeetingAgenda.' . $this->MeetingAgenda->primaryKey => $id));
			$this->request->data = $this->MeetingAgenda->find('first', $options);
		}
		$meetings = $this->MeetingAgenda->Meeting->find('list');
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
		$this->MeetingAgenda->id = $id;
		if (!$this->MeetingAgenda->exists()) {
			throw new NotFoundException(__('Invalid meeting agenda'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->MeetingAgenda->delete()) {
			$this->Session->setFlash(__('The meeting agenda has been deleted.'), 'default', array('class' => 'alert alert-success'));

            $this->loadModel('AuditTrail');

            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Deleted agenda with id ".$id." ".$_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "Deleted agenda with id ".$id." ".$_SERVER['REMOTE_ADDR'];;
            if( !$this->AuditTrail->save($auditTrail))
            {
                die('There was a problem trying to save the audit trail for adding counsiler document '.$id." ".$_SERVER['REMOTE_ADDR']);
            }

        } else {
			$this->Session->setFlash(__('The meeting agenda could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));

			$this->loadModel('AuditTrail');

            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Attempted to Delete agenda with id ".$id." ".$_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "Attempted to Delete agenda with id ".$id." ".$_SERVER['REMOTE_ADDR'];;
            if( !$this->AuditTrail->save($auditTrail))
            {
                die('There was a problem trying to save the audit trail for adding counsiler document '.$id." ".$_SERVER['REMOTE_ADDR']);
            }

        }
		return $this->redirect(array('controller' => 'CounsilorDocuments', 'action' => 'edit', $mainid));
	}
}
