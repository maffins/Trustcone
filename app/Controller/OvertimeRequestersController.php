<?php
App::uses('AppController', 'Controller');
/**
 * OvertimeRequesters Controller
 *
 * @property OvertimeRequester $OvertimeRequester
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class OvertimeRequestersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'Session');

	public $manager_approvers  = ['6' => 146, '1' => 147, '5' => 148, '13' => 149, '3' => 150, '7' => 151, '8' => 152, '9' => 153 ];
	//This is for the permissions now
	public $director_approvers = ['6' => 116, '1' => 119, '5' => 122, '13' => 125, '3' => 128, '7' => 131, '68' => 134, '9' => 137 ];
	public $allControllers = ['0' => 'INFRASTRUCTURE', '1' => 'Corporate Support Services', '2' => 'Local Economic Development', '13' => 'LED', '4' => 'Office of the Municipal Manager',
												 '5' => 'Community Services', '6' => "Infrastructure", '7' => "Strategic Support Services"];

/**
 * index method
 *
 * @return void
 */
	public function index() {

		//Get all the manager_approvers
		$this->loadModel('DepartmentSection');
		$allpermsdepartment = $this->DepartmentSection->find('all');
		$this->manager_approvers = [];
		foreach ($allpermsdepartment as $value) {
			$this->manager_approvers[$value['DepartmentSection']['id']] = $value['DepartmentSection']['permission'];
		}
		//Get all the manager_approvers
		$this->loadModel('Department');
		$alldepartment = $this->Department->find('all');
		$this->departments = [];
		foreach ($alldepartment as $value) {
			$this->departments[$value['Department']['id']] = $value['Department']['permission'];
			$this->director_approvers[$value['Department']['id']] = $value['Department']['director_permission'];
		}

		if( array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions'])) || array_intersect($this->director_approvers, unserialize($this->Auth->user()['permissions'])) )
		{
			if(array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions']))) {
				  $whatineed = array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions']));
					$all_departments = array_intersect($this->departments, unserialize($this->Auth->user()['permissions']));
					$all_departments = array_flip($all_departments);
					$comma_separated = implode(",", $all_departments);
					$all_depts_secti = array_flip($whatineed);
					$comma_sep_secti = implode(",", $all_depts_secti);
					//Add an extra layer now of sections
					$tracker = 1;
					$this->set('approver', 1);
					$data = $this->OvertimeRequester->find('all', [
						'fields' => ['DISTINCT OvertimeRequester.id', 'OvertimeRequester.*', 'Department.*', 'User.*'],
						'joins' => [
										[
												'table' => 'preovertimes',
												'type' => 'INNER',
												'conditions' => [
														'preovertimes.overtime_requester_id = OvertimeRequester.id', 'preovertimes.Tracker = 1'
												]
										]
								],
							'conditions' => [ "OvertimeRequester.department_id IN ({$comma_separated})", "OvertimeRequester.department_section_id IN ({$comma_sep_secti})"],
							'order' => 'OvertimeRequester.id DESC'
					]);
			}

			if(array_intersect($this->director_approvers, unserialize($this->Auth->user()['permissions']))) {
					//This is for director and must be department dependant
					$all_departments = array_intersect($this->departments, unserialize($this->Auth->user()['permissions']));
					$all_departments = array_flip($all_departments);
					$comma_separated = implode(",", $all_departments);
					$tracker = 2;
					$this->set('approver', 2);
					$data = $this->OvertimeRequester->find('all', [
						'joins' => [
						        [
						            'table' => 'preovertimes',
						            'type' => 'INNER',
						            'conditions' => [
						                'preovertimes.overtime_requester_id = OvertimeRequester.id', 'preovertimes.Tracker = 2'
						            ]
						        ]
						    ],
							'conditions' => [ "OvertimeRequester.department_id IN ({$comma_separated})"],
							'order' => 'OvertimeRequester.id DESC'
					]);
			}
		} else {
			$this->set('approver', 0);
				//remember the user type a type of 10 means document declined by executive director or senior manager
				$data = $this->OvertimeRequester->find('all', array(
						'conditions' => ["OvertimeRequester.user_id" => $this->Auth->user('id') ]
				));
			 $this->set('archive', 1);
		}
		$this->loadModel('DepartmentSection');
		$dept_sections = $this->DepartmentSection->find('all');
		$dept_sec = [];
		foreach ($dept_sections as $value) {
			$dept_sec[$value['DepartmentSection']['id']] = $value['DepartmentSection']['name'];
		}

		$this->set('department_sections', $dept_sec);
		$this->set('overtimeRequesters', $data);
		$this->set('departments', $this->allControllers);
	}

	public function getallsection() {
			$department_id = $this->request->data['OvertimeRequester']['department_id'];

			$this->loadModel('DepartmentSection');
			$dept_sections = $this->DepartmentSection->find('all', array(
				'conditions' => ['DepartmentSection.department_id' => $department_id],
				'recursive' => -1
				));
			$thevalues = [];
			foreach ($dept_sections as $value) {
				$thevalues[$value['DepartmentSection']['id']] = $value['DepartmentSection']['name'];
			}

			$this->set('departments', $thevalues);
			$this->layout = 'ajax';
		}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->OvertimeRequester->exists($id)) {
			throw new NotFoundException(__('Invalid overtime requester'));
		}
		$options = array('conditions' => array('OvertimeRequester.' . $this->OvertimeRequester->primaryKey => $id));
		$this->set('overtimeRequester', $this->OvertimeRequester->find('first', $options));
	}

  public function get_data($url)
  {
      $ch = curl_init();
      $timeout = 5;
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
      curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
  }

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->request->data['OvertimeRequester']['user_id'] = $this->Auth->user('id');
			$this->OvertimeRequester->create();
			if ($this->OvertimeRequester->save($this->request->data)) {
				$this->Session->setFlash(__('The overtime requester has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The overtime requester could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$users = $this->OvertimeRequester->User->find('list');
		$departments = $this->OvertimeRequester->Department->find('list');

		$all_depts = array_flip($departments);
		$this->loadModel('Department');
		$alldepartment = $this->Department->find('all');
		$this->departments = [];
		$theDept = [];
		foreach ($alldepartment as $value) {
			$theDept[$value['Department']['id']] = $value['Department']['permission'];
		}
		$whatineed = array_intersect($theDept, unserialize($this->Auth->user()['permissions']));
		$options[15] = '- Choose -';
		foreach ($whatineed as $key => $value) {
			$options[$key] = $departments[$key];
		}

		$this->set('depts', $options);
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
		if (!$this->OvertimeRequester->exists($id)) {
			throw new NotFoundException(__('Invalid overtime requester'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->OvertimeRequester->save($this->request->data)) {
				$this->Session->setFlash(__('The overtime requester has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The overtime requester could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('OvertimeRequester.' . $this->OvertimeRequester->primaryKey => $id));
			$this->request->data = $this->OvertimeRequester->find('first', $options);
		}
		$users = $this->OvertimeRequester->User->find('list');
		$departments = $this->OvertimeRequester->Department->find('list');
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
		$this->OvertimeRequester->id = $id;
		if (!$this->OvertimeRequester->exists()) {
			throw new NotFoundException(__('Invalid overtime requester'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->OvertimeRequester->delete()) {
			$this->Session->setFlash(__('The overtime requester has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The overtime requester could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
