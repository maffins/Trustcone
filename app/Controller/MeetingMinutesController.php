<?php
App::uses('AppController', 'Controller');
/**
 * MeetingMinutes Controller
 *
 * @property MeetingMinute $MeetingMinute
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class MeetingMinutesController extends AppController {

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
	public function index($type) {
		$this->MeetingMinute->recursive = 0;
		$condition = ['MeetingMinute.type' => $type, 'MeetingMinute.document_name !=' => ''];
        $data = $this->Paginator->paginate('MeetingMinute', $condition);

        $allControllers[0] = 'Counsilor Documents';
        $allControllers[1] = 'Mayco Documents';
        $allControllers[2] = 'ExcoDocuments';
        $allControllers[8] = 'FinanceDocuments';
        $allControllers[7] = 'Infrastructure Technical Services';
        $allControllers[4] = 'CommunityServices';
        $allControllers[9] = 'PublicSafityDocuments';
        $allControllers[3] = 'EightyDocuments';
        $allControllers[10] = 'SpotsArtsCultureDocuments';
        $allControllers[5] = 'Corporate Services Documents';
        $allControllers[6] = 'Idp Policy Monitoring Documents';
        $allControllers[11] = 'Mpac Documents';
        $allControllers[13] = 'Dispute Resolution Documents';
        $allControllers[12] = 'Rules Documents';

        $this->loadModel('User');
        $options3 = array('conditions' => array('User.' . $this->User->primaryKey => $this->Auth->user('id')));
        $loggedInUser = $this->User->find('first', $options3);

        $this->set('meeting', $allControllers[$type]);
        $this->set('meetingMinutes', $data);
        $this->set('type', $type);
        $this->set('melogged', $loggedInUser);
	}

    public function sendFile($id) {


        $this->loadModel('MeetingMinute');
        $tafura    = "MeetingMinute";
        $directory = "sports_art_culture_minutes";

        $options = array('conditions' => array($tafura.'.' . $this->$tafura->primaryKey => $id, $tafura.'.type' => 10));
        $file = $this->$tafura->find('first', $options);
        $path = '/webroot/uploads/'.$directory.'/'.$file[$tafura]['document_name'];
// echo $path;die;
        $this->response->file(
            $path,
            [
                'download' => true,
                'name' => $file[$tafura]['document_name']
            ]
        );
// Return response object to prevent controller from trying to render
// a view

        $this->loadModel('AuditTrail');
        $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
        $auditTrail['AuditTrail']['event_description'] = "Opened to view document SPORT, ARTS & CULTURE SECTION 80 COMMITTEEwith id ".$id." item ".$directory." ".$_SERVER['REMOTE_ADDR'];

        $auditTrail['AuditTrail']['contents'] = "Opened to view SPORT, ARTS & CULTURE SECTION 80 COMMITTEE document with id ".$id." item ".$directory." ".$_SERVER['REMOTE_ADDR'];
        if( !$this->AuditTrail->save($auditTrail))
        {
            die('There was a problem trying to save the audit trail for viewing SPORT, ARTS & CULTURE SECTION 80 COMMITTEESection 80 meeting document');
        }

        return $this->response;


    }
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->MeetingMinute->exists($id)) {
			throw new NotFoundException(__('Invalid meeting minute'));
		}
		$options = array('conditions' => array('MeetingMinute.' . $this->MeetingMinute->primaryKey => $id));
		$this->set('meetingMinute', $this->MeetingMinute->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($type) {

		if ($this->request->is('post')) {

            $minutesDocuments = $this->request->data['MeetingMinute']['minutes'];
            $minutesDetails = [];
            $folder = "";

            if ($this->request->data['MeetingMinute']['typeed'] == 0) {
                $folder = "";
            }
            if ($this->request->data['MeetingMinute']['typeed'] == 1) {
                $folder = "mayco_";
            }
            if ($this->request->data['MeetingMinute']['typeed'] == 2) {
                $folder = "exco_";
            }
            if ($this->request->data['MeetingMinute']['typeed'] == 3) {
                $folder = "eighty_";
            }
            if ($this->request->data['MeetingMinute']['typeed'] == 4) {
                $folder = "community_service_";
            }
            if ($this->request->data['MeetingMinute']['typeed'] == 5) {
                $folder = "corporate_service_";
            }
            if ($this->request->data['MeetingMinute']['typeed'] == 6) {
                $folder = "idp_policy_";
            }
            if ($this->request->data['MeetingMinute']['typeed'] == 7) {
                $folder = "infrastructure_service_";
            }
            if ($this->request->data['MeetingMinute']['typeed'] == 8) {
                $folder = "finance_";
            }
            if ($this->request->data['MeetingMinute']['typeed'] == 9) {
                $folder = "public_safity_";
            }
            if ($this->request->data['MeetingMinute']['typeed'] == 10) {
                $folder = "sports_art_culture_";
            }
            if ($this->request->data['MeetingMinute']['typeed'] == 11) {
                $folder = "mpac_";
            }
            if ($this->request->data['MeetingMinute']['typeed'] == 12) {
                $folder = "rules_";
            }
            if ($this->request->data['MeetingMinute']['typeed'] == 13) {
                $folder = "dispute_resolution_";
            }


            foreach ($minutesDocuments as $upload) {
                $this->MeetingMinute->create();

                $file = $upload;//put the data into a var for easy use

                $original_name = $file['name'];
                $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . $folder . 'minutes' . DS . $file['name']);
//prepare the filename for database entry
                $minutesDetails['MeetingMinute']['document_name'] = $file['name'];
                $minutesDetails['MeetingMinute']['original_name'] = $original_name;

                $minutesDetails['MeetingMinute']['user_id'] = $this->Auth->user('id');
                $minutesDetails['MeetingMinute']['meeting_id'] = 0;
                $minutesDetails['MeetingMinute']['type'] = $this->request->data['MeetingMinute']['typeed'];

                if ($this->MeetingMinute->save($minutesDetails)) {

                    $this->Flash->success(__('Minutes uploaded successfuly.'));
                    return $this->redirect(array('action' => 'index', $this->request->data['MeetingMinute']['typeed']));

                } else {
                    die('Cannot save the minutes');
                }
            }
        }

        $allControllers[0] = 'Counsilor Documents';
        $allControllers[1] = 'Mayco Documents';
        $allControllers[2] = 'ExcoDocuments';
        $allControllers[8] = 'FinanceDocuments';
        $allControllers[7] = 'Infrastructure Technical Services';
        $allControllers[4] = 'CommunityServices';
        $allControllers[9] = 'PublicSafityDocuments';
        $allControllers[3] = 'EightyDocuments';
        $allControllers[10] = 'SpotsArtsCultureDocuments';
        $allControllers[5] = 'Corporate Services Documents';
        $allControllers[6] = 'Idp Policy Monitoring Documents';
        $allControllers[11] = 'Mpac Documents';
        $allControllers[13] = 'Dispute Resolution Documents';
        $allControllers[12] = 'Rules Documents';

        $this->set('meeting', $allControllers[$type]);
        $this->set('type', $type);

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
		if (!$this->MeetingMinute->exists($id)) {
			throw new NotFoundException(__('Invalid meeting minute'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->MeetingMinute->save($this->request->data)) {
				$this->Session->setFlash(__('The meeting minute has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meeting minute could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('MeetingMinute.' . $this->MeetingMinute->primaryKey => $id));
			$this->request->data = $this->MeetingMinute->find('first', $options);
		}
		$meetings = $this->MeetingMinute->Meeting->find('list');
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
		$this->MeetingMinute->id = $id;
		if (!$this->MeetingMinute->exists()) {
			throw new NotFoundException(__('Invalid meeting minute'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->MeetingMinute->delete()) {
			$this->Session->setFlash(__('The meeting minute has been deleted.'), 'default', array('class' => 'alert alert-success'));

            $this->loadModel('AuditTrail');

            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Deleted minutes with id ".$id." ".$_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "Deleted minutes with id ".$id." ".$_SERVER['REMOTE_ADDR'];;
            if( !$this->AuditTrail->save($auditTrail))
            {
                die('There was a problem trying to save the audit trail for adding counsiler document '.$id." ".$_SERVER['REMOTE_ADDR']);
            }

		} else {
			$this->Session->setFlash(__('The meeting minute could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));

            $this->loadModel('AuditTrail');

            $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
            $auditTrail['AuditTrail']['event_description'] = "Attempted to Delete minutes with id ".$id." ".$_SERVER['REMOTE_ADDR'];

            $auditTrail['AuditTrail']['contents'] = "Attempted to Delete minutes with id ".$id." ".$_SERVER['REMOTE_ADDR'];;
            if( !$this->AuditTrail->save($auditTrail))
            {
                die('There was a problem trying to save the audit trail for adding counsiler document '.$id." ".$_SERVER['REMOTE_ADDR']);
            }


        }
		return $this->redirect(array('controller' => 'CounsilorDocuments', 'action' => 'edit',$mainid));
	}
}
