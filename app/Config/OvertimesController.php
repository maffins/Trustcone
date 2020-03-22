<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Overtimes Controller
 *
 * @property Overtime $Overtime
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class OvertimesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'Session');
	public $helpers = array('Js');
	public $paginate = array(
					'limit' => 25,
					'order' => array(
							'Overtime.id' => 'desc'
					)
			);

	public $period = ['' => '- Select -', 1 => 'Weekday', 2 => 'Saturday', 3 => 'Sunday', 4 => 'Public Holiday'];
	public $manager_approvers  = ['6' => 146, '1' => 147, '2' => 161, '5' => 148, '13' => 149, '3' => 150, '7' => 151, '8' => 152, '9' => 153 ];
	//This is for the permissions now
	public $director_approvers = ['6' => 116, '1' => 119, '2' => 160, '5' => 122, '13' => 125, '3' => 128, '7' => 131, '68' => 134, '9' => 137 ];

	public $allControllers = ['0' => 'INFRASTRUCTURE', '1' => 'CORPORATE SUPPORT SERVICES', '2' => 'COMMUNITY SERVICES',
														'3' => 'LED', '4' => 'FINANCE', '5' => 'STRATEGIC SUPPORT SERVICES', '6' => "MAYOR'S OFFICE",
														'7' => "SPEAKER'S OFFICE"];
	public $months = [ '0' => '- Select Month -',
                    "1" => "January", "2" => "February", "3" => "March", "4" => "April",
                    "5" => "May", "6" => "June", "7" => "July", "8" => "August",
                    "9" => "September", "10" => "October", "11" => "November", "12" => "December",
                ];

public function reports() {

		$this->loadModel('OvertimeRequester');

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
		$theDept = [];
		foreach ($alldepartment as $value) {
			$this->departments[$value['Department']['id']] = $value['Department']['permission'];
			$theDept[$value['Department']['id']] = $value['Department']['permission'];
		}
		//Get all the manager_approvers
		$this->loadModel('Department');
		$alldepartment = $this->Department->find('all');
		$this->director_approvers = [];
		foreach ($alldepartment as $value) {
			$this->director_approvers[$value['Department']['id']] = $value['Department']['director_permission'];
		}

			if(array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions'])))
			{
					$this->set('approver', 1); //A manager
			}

			if(array_intersect($this->director_approvers, unserialize($this->Auth->user()['permissions']))) {
					$this->set('approver', 2); // a director
			}

			if(in_array(112, unserialize($this->Auth->user()['permissions']))) {
					$this->set('approver', 4); //Are the cfo
			}

			if(in_array(113, unserialize($this->Auth->user()['permissions']))) {
					$this->set('approver', 5); //Are the cfo
			}

			if(in_array(142, unserialize($this->Auth->user()['permissions']))) { //Salaries department
				//This is the CFO and must be able to see all
					$tracker = '5,3,6';
					$this->set('approver', 3); //Salaries department
			}
}

public function overtimeindex() {

}

public function index() {

	$this->loadModel('OvertimeRequester');

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
	$theDept = [];
	foreach ($alldepartment as $value) {
		$this->departments[$value['Department']['id']] = $value['Department']['permission'];
		$theDept[$value['Department']['id']] = $value['Department']['permission'];
	}
	//Get all the manager_approvers
	$this->loadModel('Department');
	$alldepartment = $this->Department->find('all');
	$this->director_approvers = [];
	foreach ($alldepartment as $value) {
		$this->director_approvers[$value['Department']['id']] = $value['Department']['director_permission'];
	}

	if( array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions'])) || array_intersect($this->director_approvers, unserialize($this->Auth->user()['permissions'])) || array_intersect([112, 113], unserialize($this->Auth->user()['permissions'])) || array_intersect([142], unserialize($this->Auth->user()['permissions'])) )
	{
		if(array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions']))) {
			$whatineed = array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions']));

				$all_departments = array_intersect($this->departments, unserialize($this->Auth->user()['permissions']));
				$all_departments = array_flip($all_departments);
				$comma_separated = implode(",", $all_departments);
				$all_depts_secti = array_flip($whatineed);
				$comma_sep_secti = implode(",", $all_depts_secti);
				$tracker = 1;

				$this->set('approver', 1);
				$data = $this->OvertimeRequester->find('all', [
					'contain' => ['OvertimeReason', 'Preovertime', 'OvertimeRequester', 'Overtime', 'Department', 'User'],
					'joins' => [
												[
														'table' => 'preovertimes',
														'type' => 'INNER',
														'conditions' => [
																'preovertimes.overtime_requester_id = OvertimeRequester.id'
															]
												],
												[
														'table' => 'overtimes',
														'type' => 'INNER',
														'conditions' => [
																							'overtimes.overtime_requester_id = OvertimeRequester.id', 'overtimes.tracker' => 1
																						]
												]
											],
						'conditions' => [ "OvertimeRequester.department_id IN ({$comma_separated})", ],
						'order' => 'OvertimeRequester.id DESC',
						'group' => 'OvertimeRequester.salary_number'
				]);
				$this->set('approver', 1);
		}

		if(array_intersect($this->director_approvers, unserialize($this->Auth->user()['permissions']))) {
				//This is for director and must be department dependant
				$all_departments = array_intersect($this->director_approvers, unserialize($this->Auth->user()['permissions']));
				$all_departments = array_flip($all_departments);
				$comma_separated = implode(",", $all_departments);
				$tracker = 2;
				$this->set('approver', 2);
				$data = $this->OvertimeRequester->find('all', [
					'contain' => ['OvertimeReason', 'Preovertime', 'OvertimeRequester', 'Overtime', 'Department', 'User'],
					'joins' => [
									[
											'table' => 'preovertimes',
											'type' => 'INNER',
											'conditions' => [
																				'preovertimes.overtime_requester_id = OvertimeRequester.id'
																			]
									],
									[
											'table' => 'overtimes',
											'type' => 'INNER',
											'conditions' => [
																				'overtimes.overtime_requester_id = OvertimeRequester.id', 'overtimes.tracker' => 2
																			]
									]
							],
						'conditions' => [ "OvertimeRequester.department_id IN ({$comma_separated})"],
						'order' => 'OvertimeRequester.id DESC',
						'group' => 'OvertimeRequester.salary_number'
				]);
		}

			if(in_array(113, unserialize($this->Auth->user()['permissions']))) {
				//This is the CFO and must be able to see all
					$tracker = 4;
					$this->set('approver', 5);
					$data = $this->OvertimeRequester->find('all', [
						'contain' => ['OvertimeReason', 'OvertimeRequester', 'Overtime', 'Preovertime', 'Department', 'User'],
						'joins' => [
										[
												'table' => 'preovertimes',
												'type' => 'INNER',
												'conditions' => [
																					'preovertimes.overtime_requester_id = OvertimeRequester.id'
																				]
										],
										[
												'table' => 'overtimes',
												'type' => 'INNER',
												'conditions' => [
																					'overtimes.overtime_requester_id = OvertimeRequester.id'
																				]
										]
								],
							'conditions' => [ 'overtimes.tracker = 4' ],
							'order' => 'OvertimeRequester.id DESC',
							'group' => 'OvertimeRequester.salary_number'
					]);

			}

			if(in_array(112, unserialize($this->Auth->user()['permissions']))) {
				//This is the CFO and must be able to see all
					$tracker = 4;
					$this->set('approver', 4);
					$data = $this->OvertimeRequester->find('all', [
						'contain' => ['OvertimeReason', 'OvertimeRequester', 'Overtime', 'Preovertime', 'Department', 'User'],
						'joins' => [
										[
												'table' => 'preovertimes',
												'type' => 'INNER',
												'conditions' => [
																					'preovertimes.overtime_requester_id = OvertimeRequester.id'
																				]
										],
										[
												'table' => 'overtimes',
												'type' => 'INNER',
												'conditions' => [
																					'overtimes.overtime_requester_id = OvertimeRequester.id'
																				]
										]
								],
							'conditions' => [ 'overtimes.tracker in (4,6,7)' ],
							'order' => 'OvertimeRequester.id DESC',
							'group' => 'OvertimeRequester.salary_number'
					]);

			}

		if(in_array(142, unserialize($this->Auth->user()['permissions']))) { //Salaries department
			//This is the CFO and must be able to see all
				$tracker = '5,3,6';
				$this->set('approver', 3);
				$data = $this->OvertimeRequester->find('all', [
					'contain' => ['OvertimeReason', 'Preovertime', 'OvertimeRequester', 'Overtime', 'Department', 'User'],
					'joins' => [
									[
											'table' => 'preovertimes',
											'type' => 'INNER',
											'conditions' => [
																				'preovertimes.overtime_requester_id = OvertimeRequester.id'
																			]
									],
									[
											'table' => 'overtimes',
											'type' => 'INNER',
											'conditions' => [
																				'overtimes.overtime_requester_id = OvertimeRequester.id'
																			]
									]
							],
						'conditions' => [ 'overtimes.tracker in (3)' ],
						'order' => 'OvertimeRequester.id DESC',
						'group' => 'OvertimeRequester.salary_number'
				]);

		}

	} else {
		$this->set('approver', 0);

		$all_departments = array_intersect($this->departments, unserialize($this->Auth->user()['permissions']));
		$all_departments = array_flip($all_departments);
		$comma_separated = implode(",", $all_departments);

			//remember the user type a type of 10 means document declined by executive director or senior manager
			$data = $this->OvertimeRequester->find('all', [
				'joins' => [
								[
										'table' => 'preovertimes',
										'type' => 'INNER',
										'conditions' => [
												'preovertimes.overtime_requester_id = OvertimeRequester.id', 'preovertimes.Tracker = 3'
										]
								]
						],
					'conditions' => [ "OvertimeRequester.department_id  IN ({$comma_separated}) AND OvertimeRequester.user_id = ".$this->Auth->user('id')],
					'order' => 'OvertimeRequester.id DESC',
					'group' => 'OvertimeRequester.salary_number'
			]
		);
		 $this->set('archive', 1);
	}
	$this->loadModel('DepartmentSection');
	$dept_sections = $this->DepartmentSection->find('all');
	$thevalues = [];
	foreach ($dept_sections as $value) {
		$thevalues[$value['DepartmentSection']['id']] = $value['DepartmentSection']['name'];
	}

	$this->set('department_sections', $thevalues);
	$this->set('overtimeRequesters', $data);
	$this->set('departments', $theDept);
	$this->set('months', $this->months);

	if(in_array(112, unserialize($this->Auth->user()['permissions']))) {
		//$this->render('cfoview');
		$this->render('cfofirst');
	}
	if(in_array(113, unserialize($this->Auth->user()['permissions']))) {
		//$this->render('cfoview');
		$this->render('mmfirst');
	}
}

public function directoratebreak() {
	$this->loadModel('Department');
	$alldepartment = $this->Department->find('all');
	$this->departments = [];
	$theDept = [];
	foreach ($alldepartment as $value) {
		//Get the totals for that department
		$this->loadModel('OvertimeRequester');

		$data = $this->OvertimeRequester->find('all', [
			'contain' => ['OvertimeReason', 'OvertimeRequester', 'Overtime', 'Preovertime', 'Department', 'User'],
			'joins' => [
							[
									'table' => 'preovertimes',
									'type' => 'INNER',
									'conditions' => [
																		'preovertimes.overtime_requester_id = OvertimeRequester.id'
																	]
							],
							[
									'table' => 'overtimes',
									'type' => 'INNER',
									'conditions' => [
																		'overtimes.overtime_requester_id = OvertimeRequester.id'
																	]
							]
					],
				'conditions' => [ 'overtimes.tracker in (4,6,7)', 'OvertimeRequester.department_id' => $value['Department']['id'] ],
				'order' => 'OvertimeRequester.id DESC',
				'group' => 'OvertimeRequester.salary_number'
		]);

		$total_hours = 0;
		$total_amoint = 0;
		foreach ($data as $value) {
			foreach ($value['Overtime'] as $Kvalue) {
				$total_hours   += $Kvalue['total_hours'];
				$total_amoint += $Kvalue['rate'];
				$trackers = $Kvalue['tracker'];
			}
		}
		$thisdepartments[$value['Department']['id']] = [$value['Department']['name'], $total_hours, $total_amoint, $trackers] ;
	}

	$this->set('Departments', $thisdepartments);

	if(in_array(113, unserialize($this->Auth->user()['permissions']))) {
		$this->set('mm', 1);
	} else {
		$this->set('mm', 0);
	}
}

public function overtimereview($overtimeRequester_id) {

	$this->loadModel('OvertimeRequester');

	$data = $this->OvertimeRequester->find('first', [
		'contain' => ['OvertimeReason', 'Preovertime', 'OvertimeRequester', 'Department', 'User'],
		'joins' => [
						[
								'table' => 'preovertimes',
								'type' => 'INNER',
								'conditions' => [
																	'preovertimes.overtime_requester_id = OvertimeRequester.id'
																]
						]
				],
			'conditions' => [ "OvertimeRequester.id" => $overtimeRequester_id],
			'order' => 'OvertimeRequester.id DESC',
			'group' => 'OvertimeRequester.salary_number'
	]);
	$this->loadModel('DepartmentSection');
	$dept_sections = $this->DepartmentSection->find('all');
	$thevalues = [];
	foreach ($dept_sections as $value) {
		$thevalues[$value['DepartmentSection']['id']] = $value['DepartmentSection']['name'];
	}
	$this->set('department_sections', $thevalues);
	$this->set('overtimeRequesters', $data);
	$this->set('months', $this->months);
}

public function salaryitems() {
	$this->Session->delete('alldata');
	//Get all the manager_approvers
	$this->loadModel('DepartmentSection');
	$allpermsdepartment = $this->DepartmentSection->find('all');
	$this->manager_approvers = [];
	foreach ($allpermsdepartment as $value) {
		$units[$value['DepartmentSection']['id']] = $value['DepartmentSection']['name'];
	}
	//Get all the manager_approvers
	$this->loadModel('Department');
	$alldepartment = $this->Department->find('all');
	$this->departments = [];
	$theDept = [];
	$this->director_approvers = [];
	foreach ($alldepartment as $value) {
		$theDept[$value['Department']['id']] = $value['Department']['name'];
	}

  $this->loadModel('OvertimeRequester');

	$data = $this->OvertimeRequester->find('all', [
		'contain' => ['OvertimeReason', 'Preovertime', 'OvertimeRequester', 'Overtime', 'Department', 'User'],
		'joins' => [
						[
								'table' => 'preovertimes',
								'type' => 'INNER',
								'conditions' => [
																	'preovertimes.overtime_requester_id = OvertimeRequester.id'
																]
						],
						[
								'table' => 'overtimes',
								'type' => 'INNER',
								'conditions' => [
																	'overtimes.overtime_requester_id = OvertimeRequester.id'
																]
						]
				],
			'conditions' => [ 'overtimes.tracker in (3,4,5,6)' ],
			'order' => 'OvertimeRequester.id DESC',
			'group' => 'OvertimeRequester.salary_number'
	]);

	foreach ($data as $overtimeRequester){
		$overtimeRequester_id .= $overtimeRequester['OvertimeRequester']['id'].',';
	}

  $overtimeRequester_id = substr( $overtimeRequester_id, 0, -1);

	$data = $this->Overtime->find('all', array(
			'contain' => ['OvertimeReason', 'Preovertime', 'OvertimeRequester'],
			'conditions' => ['Overtime.tracker in (3)', "Overtime.overtime_requester_id IN ({$overtimeRequester_id})" ],
			'group' => ['OvertimeRequester.salary_number', 'Overtime.period'],
			'order' => 'Overtime.id DESC'
	));

	$data_for_hours = $this->Overtime->find('all', array(
			'contain' => ['OvertimeReason', 'Preovertime', 'OvertimeRequester'],
			'conditions' => ['Overtime.tracker in (3)', "Overtime.overtime_requester_id IN ({$overtimeRequester_id})" ],
			'fields' => ['sum(Overtime.total_hours) as total_sum', 'OvertimeRequester.salary_number'],
			'group' => ['OvertimeRequester.salary_number', 'Overtime.period'],
			'order' => 'Overtime.id DESC'
	));

	$summed = [];
	foreach($data_for_hours as $clive) {
		 $summed[$clive['OvertimeRequester']['salary_number']+$clive['Overtime']['id']] = $clive[0]['total_sum'];
	}

 $this->set('overtimes', $data);
 $this->set('summed', $summed);
 $this->set('period', $this->period);
 $this->set('departments', $theDept);
 $this->set('units', $units);
}

public function overtimeitems($overtimeRequester_id = null, $tracker = null) {
		$this->Session->delete('alldata');
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
		$theDept = [];
		foreach ($alldepartment as $value) {
			$this->departments[$value['Department']['id']] = $value['Department']['permission'];
			$theDept[$value['Department']['id']] = $value['Department']['permission'];
		}
		//Get all the manager_approvers
		$this->loadModel('Department');
		$alldepartment = $this->Department->find('all');
		$this->director_approvers = [];
		foreach ($alldepartment as $value) {
			$this->director_approvers[$value['Department']['id']] = $value['Department']['director_permission'];
		}

		if( array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions'])) || in_array(112, unserialize($this->Auth->user()['permissions'])) || in_array(142, unserialize($this->Auth->user()['permissions'])) ||
		array_intersect($this->director_approvers, unserialize($this->Auth->user()['permissions'])) )
		{
			if(array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions']))) {
				$whatineed = array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions']));

					$all_departments = array_intersect($this->departments, unserialize($this->Auth->user()['permissions']));
					$all_departments = array_flip($all_departments);
					$comma_separated = implode(",", $all_departments);
					$all_depts_secti = array_flip($whatineed);
					$comma_sep_secti = implode(",", $all_depts_secti);

					$tracker = 1;
					$this->set('approver', 1);
					$data = $this->Overtime->find('all', array(
							'contain' => ['OvertimeReason', 'Preovertime', 'OvertimeRequester'],
							'conditions' => ['Overtime.tracker' => $tracker, 'Overtime.overtime_requester_id' => $overtimeRequester_id],
							'order' => 'Overtime.id DESC'
					));

			}

			if(array_intersect($this->director_approvers, unserialize($this->Auth->user()['permissions']))) {
					//This is for director and must be department dependant
					$all_departments = array_intersect($this->departments, unserialize($this->Auth->user()['permissions']));
					$all_departments = array_flip($all_departments);
					$comma_separated = implode(",", $all_departments);
					$tracker = 2;
					$this->set('approver', 2);
					$data = $this->Overtime->find('all', array(
							'contain' => ['OvertimeReason', 'Preovertime', 'OvertimeRequester'],
							'conditions' => ['Overtime.tracker' => $tracker, 'Overtime.overtime_requester_id' => $overtimeRequester_id],
							'order' => 'Overtime.id DESC'
					));

			}

			if(in_array(112, unserialize($this->Auth->user()['permissions']))) {
				//This is the CFO and must be able to see all
					$tracker = 5;
					$this->set('approver', 5);
					$data = $this->Overtime->find('all', array(
							'contain' => ['OvertimeReason', 'Preovertime', 'OvertimeRequester'],
							'conditions' => ['Overtime.tracker' => $tracker, 'Overtime.overtime_requester_id' => $overtimeRequester_id],
							'order' => 'Overtime.id DESC'
					));
			}

			if(in_array(142, unserialize($this->Auth->user()['permissions']))) {
				//This is the CFO and must be able to see all
					$tracker = 4;
					$this->set('approver', 3);
					$data = $this->Overtime->find('all', array(
							'contain' => ['OvertimeReason', 'Preovertime', 'OvertimeRequester'],
							'conditions' => ['Overtime.tracker in (3,4,5,6)', 'Overtime.overtime_requester_id' => $overtimeRequester_id],
							'order' => 'Overtime.id DESC'
					));
			}

		} else {
				//remember the user type a type of 10 means document declined by executive director or senior manager
				$data = $this->Overtime->find('all', array(
						'contain' => ['OvertimeReason', 'Preovertime', 'OvertimeRequester'],
						'conditions' => ['Overtime.user_id' => $this->Auth->user('id'), 'Overtime.archived != ' => 1, 'Overtime.tracker != ' => 100, 'Overtime.overtime_requester_id' => $overtimeRequester_id],
						'order' => 'Overtime.id DESC'
				));
			 $this->set('approver', 0);
			 $this->set('archive', 1);
			// $tracker = 0;
		}

    $this->set('overtimes', $data);
		$this->set('tracker', $tracker);
		$this->set('overtimeRequester_id', $overtimeRequester_id);
		$this->set('period', $this->period);
		$this->loadModel('OvertimeRequester');
		$options = array('conditions' => array('OvertimeRequester.' . $this->OvertimeRequester->primaryKey => $overtimeRequester_id));
		$this->set('overtimeRequester', $this->OvertimeRequester->find('first', $options));

		$this->loadModel('AuditTrail');
		$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
		$auditTrail['AuditTrail']['event_description'] = "Viewed overtime request from IP address ".$_SERVER['REMOTE_ADDR'];

		$auditTrail['AuditTrail']['contents'] = "Viewed overtime request from IP address ".$_SERVER['REMOTE_ADDR'];
		if( !$this->AuditTrail->save($auditTrail))
		{
				die('There was a problem trying to save the audit trail for viewing Overtime document');
		}
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Overtime->exists($id)) {
			throw new NotFoundException(__('Invalid overtime'));
		}
		$options = array('conditions' => array('Overtime.' . $this->Overtime->primaryKey => $id));
		$this->set('overtime', $this->Overtime->find('first', $options));

		$this->loadModel('AuditTrail');
		$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
		$auditTrail['AuditTrail']['event_description'] = "Viewed overtime request <b>({$id})</b> from IP address ".$_SERVER['REMOTE_ADDR'];

		$auditTrail['AuditTrail']['contents'] = "Viewed overtime request from IP address ".$_SERVER['REMOTE_ADDR'];
		if( !$this->AuditTrail->save($auditTrail))
		{
				die('There was a problem trying to save the audit trail for viewing Overtime document');
		}
	}

/**
 * add method
 *
 * @return void
 */

public function add($overtimeRequester_id, $tracker = null, $type = null) {

		$perioding = [1 => 'weekday', 2 => 'saturday', 3 => 'sunday', 4 => 'public_holiday'];

		if ($this->request->is('post')) {
				$this->Session->write('alldata', $this->request->data['Overtime']);
				$determine = $this->iscorrectday($this->request->data['Overtime']['overtime_date']);

				$end_time   = date("H:i", strtotime("{$this->request->data['Overtime']['end_time']['hour']}:{$this->request->data['Overtime']['end_time']['min']} {$this->request->data['Overtime']['end_time']['meridian']}"));
				$start_time = date("H:i", strtotime("{$this->request->data['Overtime']['start_time']['hour']}:{$this->request->data['Overtime']['start_time']['min']} {$this->request->data['Overtime']['start_time']['meridian']}"));

				if($this->request->data['Overtime']['end_time']['meridian'] == 'am' && $this->request->data['Overtime']['start_time']['meridian'] == 'pm'){
					$end_time = strtotime($end_time)+86400;
				} else {
					$end_time = strtotime($end_time);
				}

				if(strtotime($start_time) > $end_time) {
					$this->Session->setFlash(__('End time cannot be before starttime.'), 'default', array('class' => 'alert alert-danger'));
					return $this->redirect(array('action' => 'add', $this->request->data['Overtime']['overtime_requester_id'],$this->request->data['Overtime']['tracker']));
				}

				if(strtotime($start_time) == $end_time) {
					$this->Session->setFlash(__('You cannot start and end at the same time.'), 'default', array('class' => 'alert alert-danger'));
					return $this->redirect(array('action' => 'add', $this->request->data['Overtime']['overtime_requester_id'],$this->request->data['Overtime']['tracker']));
				}

				$tots = ($end_time - strtotime($start_time)) / 3600;

				$this->request->data['Overtime']['total_hours'] = $tots;

				if($this->request->data['Overtime']['period'] == 1) {

					if($determine != 1) {
						$this->Session->setFlash(__('The date you picked is not a weekday, you will have to recapture the overtime.'), 'default', array('class' => 'alert alert-danger'));
						return $this->redirect(array('action' => 'add',$this->request->data['Overtime']['overtime_requester_id'],$this->request->data['Overtime']['tracker']));
					}

					$sunrise = "7:00 am";
					$sunset  = "4:00 pm";
					$date2   = strtotime($sunrise);
					$date3   = strtotime($sunset);
					$date1   = strtotime("{$this->request->data['Overtime']['end_time']['hour']}:{$this->request->data['Overtime']['end_time']['min']} {$this->request->data['Overtime']['end_time']['meridian']}");
					$date0   = strtotime("{$this->request->data['Overtime']['start_time']['hour']}:{$this->request->data['Overtime']['start_time']['min']} {$this->request->data['Overtime']['start_time']['meridian']}");

					if ($date0 > $date2 && $date0 < $date3)
					{
						$this->Session->setFlash(__('You are not allowed to work overtime before knock off time.<br /> You may work from 16:00 to 07:00 during weekdays.<br />You have to recapture the overtime.'), 'default', array('class' => 'alert alert-danger'));
						return $this->redirect(array('action' => 'add',$this->request->data['Overtime']['overtime_requester_id'],$this->request->data['Overtime']['tracker']));
					}
					if ($date1 > $date2 && $date0 < $date3)
					{
						$this->Session->setFlash(__('You are not allowed to work overtime before knock off time.<br /> You may work from 16:00 to 07:00 during weekdays.<br />You have to recapture the overtime.'), 'default', array('class' => 'alert alert-danger'));
					  return $this->redirect(array('action' => 'add',$this->request->data['Overtime']['overtime_requester_id'],$this->request->data['Overtime']['tracker']));
					}
				} else if ( $this->request->data['Overtime']['period'] == 2 ) {

					if($determine != 2) {
						$this->Session->setFlash(__('A day you have picked is Saturday, then your date is invalid.'), 'default', array('class' => 'alert alert-danger'));
						return $this->redirect(array('action' => 'add',$this->request->data['Overtime']['overtime_requester_id'],$this->request->data['Overtime']['tracker']));
					}
				} else if ( $this->request->data['Overtime']['period'] == 3 ) {

					if($determine != 3) {
						$this->Session->setFlash(__('The day you picked is not Sunday, then your day is not valid.'), 'default', array('class' => 'alert alert-danger'));
						return $this->redirect(array('action' => 'add',$this->request->data['Overtime']['overtime_requester_id'],$this->request->data['Overtime']['tracker']));
					}
				}

				//First get the pre-overtime
				$this->loadModel('Preovertime');
				$options = array('conditions' => array('Preovertime.' . $this->Preovertime->primaryKey => $this->request->data['Overtime']['preovertime_id']));
				$thePreOvertime = $this->Preovertime->find('first', $options);

				//Check if we dealing with the same month here
				$monthcaptured = substr($this->request->data['Overtime']['overtime_date'], 5, 2);

				if(abs($monthcaptured) != $thePreOvertime['Preovertime']['overtime_month']) {

					$this->Session->setFlash(__('The month you picked is not the same as the one approved.<br />You are approved for month '.$thePreOvertime['Preovertime']['overtime_month'].' you chose '.$monthcaptured), 'default', array('class' => 'alert alert-danger'));
					return $this->redirect(array('action' => 'add',$this->request->data['Overtime']['overtime_requester_id'], $this->request->data['Overtime']['tracker']));

				}
				//Verify that your start and end time for that day do not overlap
				$testtimes = $this->Overtime->find('all', array(
						'conditions' => ['Overtime.overtime_requester_id' => $this->request->data['Overtime']['overtime_requester_id'] ]
				));

				foreach($testtimes as $nowtime)
				{
					//First check if its the same date before doing anytihng
					if( strtotime($nowtime['Overtime']['overtime_date']) == strtotime($this->request->data['Overtime']['overtime_date']) ) {
						//Now lets deal with the times
						$start_saved_time = strtotime($nowtime['Overtime']['start_time']);
						$end_saved_time = strtotime($nowtime['Overtime']['end_time']);

						if( ($start_saved_time < strtotime($start_time)) && (strtotime($start_time) < $end_saved_time) )
						{
							$this->Session->setFlash(__('The start time you picked is in between another task for the same day. '), 'default', array('class' => 'alert alert-danger'));
							return $this->redirect(array('action' => 'add',$this->request->data['Overtime']['overtime_requester_id'], $this->request->data['Overtime']['tracker']));
						}

						if( ( $start_saved_time < $end_time ) && ( $end_time < $end_saved_time ) )
						{
							$this->Session->setFlash(__('The end time you picked is in between another task for the same day. '), 'default', array('class' => 'alert alert-danger'));
							return $this->redirect(array('action' => 'add',$this->request->data['Overtime']['overtime_requester_id'], $this->request->data['Overtime']['tracker']));
						}

					}
				}

			$this->request->data['Overtime']['user_id'] = $this->Auth->user('id');

			if(!$this->request->data['Overtime']['motivation']){

				$previous_overtime = $this->Overtime->find('all', array(
						'conditions' => ['Overtime.preovertime_id' => $this->request->data['Overtime']['preovertime_id'] ]
				));
				$this->loadModel('OvertimeRequester');
				$conditions = array('conditions' => array('OvertimeRequester.' . $this->OvertimeRequester->primaryKey => $this->request->data['Overtime']['overtime_requester_id']));
				$requester  = $this->Preovertime->OvertimeRequester->find('first', $conditions);

				$total = $tots;
				foreach ($previous_overtime as $value) {
					# Now add the overtimes and make sure its not more than 60

					if($value['Overtime']['period'] == $this->request->data['Overtime']['period']) {
						$total = $total + $value['Overtime']['total_hours'];
					}
				}
				if($total > $thePreOvertime['Preovertime'][$perioding[$this->request->data['Overtime']['period']]]) {
					//Go back and a
					$this->Session->setFlash(__('You have exceeded your pre approved hours for '.$perioding[$this->request->data['Overtime']['period']].'. Please give reasons why'), 'default', array('class' => 'alert alert-danger'));
					return $this->redirect(array('action' => 'add',$this->request->data['Overtime']['overtime_requester_id'],$this->request->data['Overtime']['tracker'], 1));
				}
			}

			$this->Overtime->create();
			if ($this->Overtime->save($this->request->data)) {
				$OvertimeId = $this->Overtime->getLastInsertId();
				$id = $OvertimeId;
				$this->Session->setFlash(__('The overtime has been captured successfully.'), 'default', array('class' => 'alert alert-success'));

				//Update the pre-overtime, just that item so it wont show
				$this->loadModel('Preovertime');
				$this->Preovertime->saveField('overtime_inprocess', 1);

				$this->loadModel('AuditTrail');
				$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
				$auditTrail['AuditTrail']['event_description'] = "Overtime request <b>({$id})</b> captured from IP address ".$_SERVER['REMOTE_ADDR'];

				$auditTrail['AuditTrail']['contents'] = "Overtime request <b>({$id})</b> captured from IP address ".$_SERVER['REMOTE_ADDR'];
				if( !$this->AuditTrail->save($auditTrail))
				{
						die('There was a problem trying to save the audit trail for viewing Overtime document');
				}
				return $this->redirect(array('action' => 'overtimeitems',$this->request->data['Overtime']['overtime_requester_id'],$this->request->data['Overtime']['tracker']));
			} else {
				$this->Session->setFlash(__('The overtime could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}

		$users = $this->Overtime->User->find('list');
		$this->loadModel('OvertimeRequester');
		$OvertimeRequester = $this->OvertimeRequester->find('first', ['conditions' => ['OvertimeRequester.id' => $overtimeRequester_id]]);
//print_r($OvertimeRequester);
		$allrequesters['id']   = $OvertimeRequester['OvertimeRequester']['id'];
		$allrequesters['name'] = $OvertimeRequester['OvertimeRequester']['first_name'].' '.$OvertimeRequester['OvertimeRequester']['last_name'];
//echo $overtimeRequester_id.' give me this id<br />';
		$overtimes_capturedd = $this->Overtime->find('all', array(
				'conditions' => ['Overtime.overtime_requester_id' => $overtimeRequester_id, 'Overtime.tracker' => 0]
		));

		$weekdaytotal = 0;
		$saturday = 0;
		$sunday = 0;
		$public_holiday = 0;
		foreach($overtimes_capturedd as $now){
			if($now['Overtime']['period'] == 1)
			$weekdaytotal += $now['Overtime']['total_hours'];

			if($now['Overtime']['period'] == 2)
			$saturday     += $now['Overtime']['total_hours'];

			if($now['Overtime']['period'] == 3)
			$sunday += $now['Overtime']['total_hours'];

			if($now['Overtime']['period'] == 4)
			$public_holiday += $now['Overtime']['total_hours'];
		}

		$todeduct['weekday'] = $weekdaytotal;
		$todeduct['saturday'] = $saturday;
		$todeduct['sunday'] = $sunday;
		$todeduct['public_holiday'] = $public_holiday;

		$requester_pre_overtime = $this->getallpreovertime($overtimeRequester_id);

		$this->set('todeduct', $todeduct);
		$this->set('preovertimes', $requester_pre_overtime);
		$this->set('type', $type);
		$this->set(compact('users', 'allrequesters'));
		$this->set('nownow', $OvertimeRequester);
		$this->set('period', $this->period);
		$this->set('tracker', $tracker);
		$this->set('months', $this->months);
	}

public function iscorrectday($date) {

	$timestamp = strtotime($date);
	$weekday= date("l", $timestamp );
	$normalized_weekday = strtolower($weekday);

	if ($normalized_weekday == "saturday") {
		return 2;
	} else if($normalized_weekday == "sunday") {
	    return 3;
	} else {
	    return 1;
	}
}

	public function getallpreovertime($overtime_requester_id) {
			//$overtime_requester_id = $this->request->data['Overtime']['overtime_requester_id'];

			$this->loadModel('Preovertime');
			$preovertimes = $this->Preovertime->find('all', array(
				'conditions' => ['Preovertime.overtime_requester_id' => $overtime_requester_id, 'Preovertime.tracker' => 3],
				'recursive' => -1
				));
			$thevalues = ['0' => '- Select Pre Approved Action -'];
			foreach ($preovertimes as $value) {
				$thevalues[$value['Preovertime']['id']] = $value['Preovertime']['whatsdone'];
			}

			return $thevalues;
			//$this->set('preovertimes', $thevalues);
			//$this->layout = 'ajax';
		}

	public function checktimes() {
			$preovertime_id = $this->request->data['Overtime']['preovertime_id'];

			$this->loadModel('Preovertime');
			$preovertimes = $this->Preovertime->find('first', array(
				'conditions' => ['Preovertime.id' => $preovertime_id]
				));


			$this->set('preovertimes', $thevalues);
			$this->layout = 'ajax';
		}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Overtime->exists($id)) {
			throw new NotFoundException(__('Invalid overtime'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Overtime->save($this->request->data)) {
				$this->Session->setFlash(__('The overtime has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The overtime could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Overtime.' . $this->Overtime->primaryKey => $id));
			$this->request->data = $this->Overtime->find('first', $options);
		}
		$users = $this->Overtime->User->find('list');
		$departments = $this->Overtime->Department->find('list');
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
		$this->Overtime->id = $id;
		if (!$this->Overtime->exists()) {
			throw new NotFoundException(__('Invalid overtime'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Overtime->delete()) {
			$this->Session->setFlash(__('The overtime has been deleted.'), 'default', array('class' => 'alert alert-success'));

			$this->loadModel('AuditTrail');
			$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
			$auditTrail['AuditTrail']['event_description'] = "Overtime request <b>({$id})</b> deleted from IP address ".$_SERVER['REMOTE_ADDR'];

			$auditTrail['AuditTrail']['contents'] = "Overtime request <b>({$id})</b> deleted from IP address ".$_SERVER['REMOTE_ADDR'];
			if( !$this->AuditTrail->save($auditTrail))
			{
					die('There was a problem trying to save the audit trail for viewing Overtime document');
			}
		} else {
			$this->Session->setFlash(__('The overtime could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	function sendsms($message=null, $towho)
	{
		//echo $message.'<br />'.$towho;
			$numbers = $towho;
			$numbers .= ',27614965059,27823087961';

			$smsText = urlencode($message);

			$url = "http://148.251.196.36/app/smsapi/index.php?key=58e35a737fb7d&type=text&contacts={$numbers}&senderid=Matjabheng&msg={$smsText}&time=";

			 $mystring = $this->get_data($url);
			 //var_dump($mystring);
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

	function sendemail($message, $subject, $permission, $template, $by_who = null, $escalated = null)
	{
			$Email = new CakeEmail();

			$this->loadModel('User');
			$users = $this->User->find('all');

			foreach ($users as $user)
			{
					if($permission == '-1')
					{
						$Email->from(array('no-reply@matjhabeng.co.za' => 'Matjhabeng Local Municipality Document Management System'))
								->template($template, 'default')
								->emailFormat('html')
								->viewVars(array('message' => $message))
								->to(trim($this->Auth->user('email')))
								//->to('mapaepae@gmail.com')
								->bcc('maffins@gmail.com')
								->subject($subject)
								->send();
					} else {
						if (in_array($permission, unserialize($user['User']['permissions'])))
						{
								$Email->from(array('no-reply@matjhabeng.co.za' => 'Matjhabeng Local Municipality Document Management System'))
										->template($template, 'default')
										->emailFormat('html')
										->viewVars(array('message' => $message, 'by_who' => $by_who, 'escalated' => $escalated))
										->to(trim($user['User']['email']))
										//->to('mapaepae@gmail.com')
										->bcc('maffins@gmail.com')
										->subject($subject)
										->send();
						}
					}
			}
	}

	public function salaries()
	{
		if ($this->request->is('post')) {
				//Get the date ranges
				if($this->request->data['Overtime']['departments'])
				{
					$data = $this->Overtime->find('all', array(
							'contain' => ['OvertimeReason'],
							'conditions' => ['Overtime.tracker IN (5,6)', 'Overtime.department_id' => $this->request->data['Overtime']['departments']],
							'order' => 'Overtime.id DESC'
					));
				}
			} else {
				$data = $this->Overtime->find('all', array(
						'contain' => ['OvertimeReason'],
						'conditions' => ['Overtime.tracker IN (5,6)'],
						'order' => 'Overtime.id DESC'
				));
			}

		    $this->set('overtimes', $data);

				$this->loadModel('Department'); //or you can load it in beforeFilter()
				$departments = $this->Department->find('all');
				$depts = [' - Select Directorate - '];
				foreach ($departments as $value) {
					$depts[$value['Department']['id']] = $value['Department']['name'];
				}

				$this->set('departments', $depts);

				$this->loadModel('AuditTrail');
				$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
				$auditTrail['AuditTrail']['event_description'] = "Viewed the approved overtime request from IP address ".$_SERVER['REMOTE_ADDR'];

				$auditTrail['AuditTrail']['contents'] = "Viewed the approved overtime request from IP address ".$_SERVER['REMOTE_ADDR'];
				if( !$this->AuditTrail->save($auditTrail))
				{
						die('There was a problem trying to save the audit trail for viewing Overtime document');
				}
	}

public function summaryreport($who)
{
	//Get all the manager_approvers
	$this->loadModel('DepartmentSection');
	$allpermsdepartment = $this->DepartmentSection->find('all');
	$this->manager_approvers = [];
	$dept_sections = [];
	foreach ($allpermsdepartment as $value) {
		$this->manager_approvers[$value['DepartmentSection']['id']] = $value['DepartmentSection']['permission'];
		$dept_sections[$value['DepartmentSection']['id']] = $value['DepartmentSection']['name'];
	}
	$this->set('DepartmentSections', $dept_sections);
	//Get all the manager_approvers
	$this->loadModel('Department');
	$alldepartment = $this->Department->find('all');
	$this->departments = [];
	foreach ($alldepartment as $value) {
		$this->departments[$value['Department']['id']] = $value['Department']['permission'];
	}
	//Get all the manager_approvers
	$this->loadModel('Department');
	$alldepartment = $this->Department->find('all');
	$this->director_approvers = [];
	foreach ($alldepartment as $value) {
		$this->director_approvers[$value['Department']['id']] = $value['Department']['director_permission'];
	}

	$whatineed = array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions']));
	$all_departments = array_intersect($this->departments, unserialize($this->Auth->user()['permissions']));
	$all_departments = array_flip($all_departments);
	$comma_separated = implode(",", $all_departments);
	$all_depts_secti = array_flip($whatineed);
	$comma_sep_secti = implode(",", $all_depts_secti);

if($who != 4){
	$theedepartmetn = $this->Department->find('first', array(
							'contain' => array('DepartmentSection'),
							'joins' => [
											[
													'table' => 'department_sections',
													'type' => 'INNER',
													'conditions' => [
															'Department.id = department_sections.department_id '
													]
											]
									],
							'conditions' => ["Department.id IN ({$comma_separated})", 'department_sections.id IN ('.$comma_sep_secti.')' ],
							'order' => 'Department.id DESC'
					));

} else {
	$theedepartmetn = $this->Department->find('first', array(
							'contain' => array('DepartmentSection'),
							'joins' => [
											[
													'table' => 'department_sections',
													'type' => 'INNER',
													'conditions' => [
															'Department.id = department_sections.department_id '
													]
											]
									],
							'order' => 'Department.id DESC'
					));

}

	$this->set('maindetails', $theedepartmetn);
	$this->set('deparsections', $all_depts_secti);

	$this->loadModel('OvertimeRequester');
	if($who != 4){
		$theovertimereq = $this->OvertimeRequester->find('all', array(
								'conditions' => ["OvertimeRequester.department_id IN ({$comma_separated}) " ]
						));
	} else {
		$theovertimereq = $this->OvertimeRequester->find('all');
	}

	$marekwesta = [];

	 foreach ($theovertimereq as $value) {
		 $marekwesta[] = $value['OvertimeRequester']['id'];
	 }
	$rikwestaid = implode(",", $marekwesta);

	$condition = '';
	//echo $condition;die;
 if ($this->request->is('post')) {

	 if($this->request->data['Overtime']['employee']) {
		 $condition1 = 'OvertimeRequester.id = '.$this->request->data['Overtime']['employee'];
	 }

	 if($this->request->data['Overtime']['department_id']) {
		$condition3 = 'OvertimeRequester.department_id = '.$this->request->data['Overtime']['department_id'];
		}
		 if($this->request->data['Overtime']['salary_number']) {
			 $condition5 = 'OvertimeRequester.salary_number = \''.$this->request->data['Overtime']['salary_number'].'\'';
		 }

		//Now build the condition
		if($condition1) {
			$condition = $condition1;
		}
		if($condition2) {
			 if($condition) {
				 $condition .= ' AND '.$condition2;
			 } else {
				 $condition = $condition2;
			 }
		}
		if($condition3) {
			 if($condition) {
				 $condition .= ' AND '.$condition3;
			 } else {
				 $condition = $condition3;
			 }
		}
		if($condition5) {
			 if($condition) {
				 $condition .= ' AND '.$condition5;
			 } else {
				 $condition = $condition5;
			 }
		}
 }

	//Add an extra layer now of sections
	$data = $this->Overtime->find('all', [
		'contain' => ['OvertimeRequester', 'DepartmentSection'],
			'conditions' => [$condition],
			'order' => 'OvertimeRequester.id DESC'
	]);

	$option = ['0' => '- Choose -', '1' => 'Yes', '2' => 'No'];
	$this->set('option', $option);
	$month_names = ["- Choose Month -", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	$this->set('months', $month_names);

	$this->loadModel('OvertimeRequester'); //or you can load it in beforeFilter()
	$requester = $this->OvertimeRequester->find('all');
	$employees = [' - Select Employee - '];
	$uploaders = [' - Select Uploader - '];
	foreach ($requester as $value) {
		$employees[$value['OvertimeRequester']['id']] = $value['OvertimeRequester']['first_name'].' '.$value['OvertimeRequester']['last_name'];
		$uploaders[$value['User']['id']] = $value['User']['fname'].' '.$value['User']['sname'];
	}
	$this->set('employees', $employees);
	$this->set('uploaders', $uploaders);

	$this->loadModel('Department'); //or you can load it in beforeFilter()
	$departments = $this->Department->find('all');
	$depts = [' - Select Directorate - '];
	foreach ($departments as $value) {
		$depts[$value['Department']['id']] = $value['Department']['name'];
	}
	$this->set('depts', $depts);
	$this->set('requester', $requester);
	$this->set('preovertimes', $data);
	$this->set('period', $this->period);
	$this->set('months', $this->months);
	$this->set('who', $who);
}


	public function mmreport($who)
	{
		if($who != 5) {
			$this->autoRender = false;
			throw new NotFoundException(__('You are not the municipal manager so therefore you cannot view this report'));
		}
		//Get all the manager_approvers
		$this->loadModel('DepartmentSection');
		$allpermsdepartment = $this->DepartmentSection->find('all');
		$this->manager_approvers = [];
		$dept_sections = [];
		foreach ($allpermsdepartment as $value) {
			$this->manager_approvers[$value['DepartmentSection']['id']] = $value['DepartmentSection']['permission'];
			$dept_sections[$value['DepartmentSection']['id']] = $value['DepartmentSection']['name'];
		}
		$this->set('DepartmentSections', $dept_sections);
		//Get all the manager_approvers
		$this->loadModel('Department');
		$alldepartment = $this->Department->find('all');
		$this->departments = [];
		foreach ($alldepartment as $value) {
			$this->departments[$value['Department']['id']] = $value['Department']['permission'];
		}
		//Get all the manager_approvers
		$this->loadModel('Department');
		$alldepartment = $this->Department->find('all');
		$this->director_approvers = [];
		foreach ($alldepartment as $value) {
			$this->director_approvers[$value['Department']['id']] = $value['Department']['director_permission'];
		}

		$whatineed = array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions']));
		$all_departments = array_intersect($this->departments, unserialize($this->Auth->user()['permissions']));
		$all_departments = array_flip($all_departments);
		$comma_separated = implode(",", $all_departments);
		$all_depts_secti = array_flip($whatineed);
		$comma_sep_secti = implode(",", $all_depts_secti);

		$theedepartmetn = $this->Department->find('first', array(
								'contain' => array('DepartmentSection'),
								'joins' => [
												[
														'table' => 'department_sections',
														'type' => 'INNER',
														'conditions' => [
																'Department.id = department_sections.department_id '
														]
												]
										],
								//'conditions' => ["Department.id IN ({$comma_separated})", 'department_sections.id IN ('.$comma_sep_secti.')' ],
								'order' => 'Department.id DESC'
						));

		$this->set('maindetails', $theedepartmetn);
		$this->set('deparsections', $all_depts_secti);

		$this->loadModel('OvertimeRequester');
		$theovertimereq = $this->OvertimeRequester->find('all');

		$marekwesta = [];

		 foreach ($theovertimereq as $value) {
			 $marekwesta[] = $value['OvertimeRequester']['id'];
		 }
		$rikwestaid = implode(",", $marekwesta);

		$condition = ' Overtime.tracker NOT IN (0, 1, 2, 3, 4, 10, 11, 12)';
		//echo $condition;die;
	 if ($this->request->is('post')) {

		 if($this->request->data['Overtime']['employee']) {
			 $condition1 = 'OvertimeRequester.id = '.$this->request->data['Overtime']['employee'];
		 }

		 if($this->request->data['Overtime']['department_id']) {
			$condition3 = 'OvertimeRequester.department_id = '.$this->request->data['Overtime']['department_id'];
			}
			 if($this->request->data['Overtime']['salary_number']) {
				 $condition5 = 'OvertimeRequester.salary_number = \''.$this->request->data['Overtime']['salary_number'].'\'';
			 }

			//Now build the condition
			if($condition1) {
				$condition = $condition1;
			}
			if($condition2) {
				 if($condition) {
					 $condition .= ' AND '.$condition2;
				 } else {
					 $condition = $condition2;
				 }
			}
			if($condition3) {
				 if($condition) {
					 $condition .= ' AND '.$condition3;
				 } else {
					 $condition = $condition3;
				 }
			}
			if($condition5) {
				 if($condition) {
					 $condition .= ' AND '.$condition5;
				 } else {
					 $condition = $condition5;
				 }
			}
	 }

		//Add an extra layer now of sections
		$data = $this->Overtime->find('all', [
			'contain' => ['OvertimeRequester', 'DepartmentSection'],
				'conditions' => [$condition],
				'order' => 'OvertimeRequester.id DESC'
		]);

		$option = ['0' => '- Choose -', '1' => 'Yes', '2' => 'No'];
		$this->set('option', $option);
		$month_names = ["- Choose Month -", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		$this->set('months', $month_names);

		$this->loadModel('OvertimeRequester'); //or you can load it in beforeFilter()
		$requester = $this->OvertimeRequester->find('all');
		$employees = [' - Select Employee - '];
		$uploaders = [' - Select Uploader - '];
		foreach ($requester as $value) {
			$employees[$value['OvertimeRequester']['id']] = $value['OvertimeRequester']['first_name'].' '.$value['OvertimeRequester']['last_name'];
			$uploaders[$value['User']['id']] = $value['User']['fname'].' '.$value['User']['sname'];
		}
		$this->set('employees', $employees);
		$this->set('uploaders', $uploaders);

		$this->loadModel('Department'); //or you can load it in beforeFilter()
		$departments = $this->Department->find('all');
		$depts = [' - Select Directorate - '];
		foreach ($departments as $value) {
			$depts[$value['Department']['id']] = $value['Department']['name'];
		}
		$this->set('depts', $depts);
		$this->set('requester', $requester);
		$this->set('preovertimes', $data);
		$this->set('period', $this->period);
		$this->set('months', $this->months);
	}

	public function cforeport($who)
	{
		if($who != 4 || $who != 5) {
			$this->autoRender = false;
			throw new NotFoundException(__('You are not the cfo so therefore you cannot view this report'));
		}
		//Get all the manager_approvers
		$this->loadModel('DepartmentSection');
		$allpermsdepartment = $this->DepartmentSection->find('all');
		$this->manager_approvers = [];
		$dept_sections = [];
		foreach ($allpermsdepartment as $value) {
			$this->manager_approvers[$value['DepartmentSection']['id']] = $value['DepartmentSection']['permission'];
			$dept_sections[$value['DepartmentSection']['id']] = $value['DepartmentSection']['name'];
		}
		$this->set('DepartmentSections', $dept_sections);
		//Get all the manager_approvers
		$this->loadModel('Department');
		$alldepartment = $this->Department->find('all');
		$this->departments = [];
		foreach ($alldepartment as $value) {
			$this->departments[$value['Department']['id']] = $value['Department']['permission'];
		}
		//Get all the manager_approvers
		$this->loadModel('Department');
		$alldepartment = $this->Department->find('all');
		$this->director_approvers = [];
		foreach ($alldepartment as $value) {
			$this->director_approvers[$value['Department']['id']] = $value['Department']['director_permission'];
		}

		$whatineed = array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions']));
		$all_departments = array_intersect($this->departments, unserialize($this->Auth->user()['permissions']));
		$all_departments = array_flip($all_departments);
		$comma_separated = implode(",", $all_departments);
		$all_depts_secti = array_flip($whatineed);
		$comma_sep_secti = implode(",", $all_depts_secti);

		$theedepartmetn = $this->Department->find('first', array(
								'contain' => array('DepartmentSection'),
								'joins' => [
												[
														'table' => 'department_sections',
														'type' => 'INNER',
														'conditions' => [
																'Department.id = department_sections.department_id '
														]
												]
										],
								//'conditions' => ["Department.id IN ({$comma_separated})", 'department_sections.id IN ('.$comma_sep_secti.')' ],
								'order' => 'Department.id DESC'
						));

		$this->set('maindetails', $theedepartmetn);
		$this->set('deparsections', $all_depts_secti);

		$this->loadModel('OvertimeRequester');
		$theovertimereq = $this->OvertimeRequester->find('all');

		$marekwesta = [];

		 foreach ($theovertimereq as $value) {
			 $marekwesta[] = $value['OvertimeRequester']['id'];
		 }
		$rikwestaid = implode(",", $marekwesta);

		$condition = ' Overtime.tracker IN (5, 6,7)';
		//echo $condition;die;
	 if ($this->request->is('post')) {

		 if($this->request->data['Overtime']['employee']) {
			 $condition1 = 'OvertimeRequester.id = '.$this->request->data['Overtime']['employee'];
		 }

		 if($this->request->data['Overtime']['department_id']) {
			$condition3 = 'OvertimeRequester.department_id = '.$this->request->data['Overtime']['department_id'];
			}
			 if($this->request->data['Overtime']['salary_number']) {
				 $condition5 = 'OvertimeRequester.salary_number = \''.$this->request->data['Overtime']['salary_number'].'\'';
			 }

			//Now build the condition
			if($condition1) {
				$condition = $condition1;
			}
			if($condition2) {
				 if($condition) {
					 $condition .= ' AND '.$condition2;
				 } else {
					 $condition = $condition2;
				 }
			}
			if($condition3) {
				 if($condition) {
					 $condition .= ' AND '.$condition3;
				 } else {
					 $condition = $condition3;
				 }
			}
			if($condition5) {
				 if($condition) {
					 $condition .= ' AND '.$condition5;
				 } else {
					 $condition = $condition5;
				 }
			}
	 }

		//Add an extra layer now of sections
		$data = $this->Overtime->find('all', [
			'contain' => ['OvertimeRequester', 'DepartmentSection'],
				'conditions' => [$condition],
				'order' => 'OvertimeRequester.id DESC'
		]);

		$option = ['0' => '- Choose -', '1' => 'Yes', '2' => 'No'];
		$this->set('option', $option);
		$month_names = ["- Choose Month -", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		$this->set('months', $month_names);

		$this->loadModel('OvertimeRequester'); //or you can load it in beforeFilter()
		$requester = $this->OvertimeRequester->find('all');
		$employees = [' - Select Employee - '];
		$uploaders = [' - Select Uploader - '];
		foreach ($requester as $value) {
			$employees[$value['OvertimeRequester']['id']] = $value['OvertimeRequester']['first_name'].' '.$value['OvertimeRequester']['last_name'];
			$uploaders[$value['User']['id']] = $value['User']['fname'].' '.$value['User']['sname'];
		}
		$this->set('employees', $employees);
		$this->set('uploaders', $uploaders);

		$this->loadModel('Department'); //or you can load it in beforeFilter()
		$departments = $this->Department->find('all');
		$depts = [' - Select Directorate - '];
		foreach ($departments as $value) {
			$depts[$value['Department']['id']] = $value['Department']['name'];
		}
		$this->set('depts', $depts);
		$this->set('requester', $requester);
		$this->set('preovertimes', $data);
		$this->set('period', $this->period);
		$this->set('months', $this->months);
		$this->set('approver', $who);
	}

	public function report($who = null)
	{
		//Get all the manager_approvers
		$this->loadModel('DepartmentSection');
		$allpermsdepartment = $this->DepartmentSection->find('all');
		$this->manager_approvers = [];
		$dept_sections = [];
		foreach ($allpermsdepartment as $value) {
			$this->manager_approvers[$value['DepartmentSection']['id']] = $value['DepartmentSection']['permission'];
			$dept_sections[$value['DepartmentSection']['id']] = $value['DepartmentSection']['name'];
		}
		$this->set('DepartmentSections', $dept_sections);
		//Get all the manager_approvers
		$this->loadModel('Department');
		$alldepartment = $this->Department->find('all');
		$this->departments = [];
		foreach ($alldepartment as $value) {
			$this->departments[$value['Department']['id']] = $value['Department']['permission'];
		}
		//Get all the manager_approvers
		$this->loadModel('Department');
		$alldepartment = $this->Department->find('all');
		$this->director_approvers = [];
		foreach ($alldepartment as $value) {
			$this->director_approvers[$value['Department']['id']] = $value['Department']['director_permission'];
		}

		$whatineed = array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions']));
		$all_departments = array_intersect($this->departments, unserialize($this->Auth->user()['permissions']));
		$all_departments = array_flip($all_departments);
		$comma_separated = implode(",", $all_departments);
		$all_depts_secti = array_flip($whatineed);
		$comma_sep_secti = implode(",", $all_depts_secti);

		if ($who != 2 && $who != 4) {
			$condition = 'OvertimeRequester.department_section_id IN ('.$comma_sep_secti.') AND Overtime.tracker NOT IN (0, 1)';
		}

		if($who == 1)
		{
			$theedepartmetn = $this->Department->find('first', array(
									'contain' => array('DepartmentSection'),
									'joins' => [
													[
															'table' => 'department_sections',
															'type' => 'INNER',
															'conditions' => [
																	'Department.id = department_sections.department_id '
															]
													]
											],
									'conditions' => ['department_sections.id IN ('.$comma_sep_secti.')' ],
									'order' => 'Department.id DESC'
							));

			$this->set('maindetails', $theedepartmetn);
			$this->set('deparsections', $all_depts_secti);
	}

		$this->loadModel('OvertimeRequester');
		if($who != 4 && $who != 2 && $who != 4)
		{
			$theovertimereq = $this->OvertimeRequester->find('all', array(
									'conditions' => [" OvertimeRequester.department_section_id IN ({$comma_sep_secti})" ]
							));
		} else {
			$theovertimereq = $this->OvertimeRequester->find('all');
		}

		$marekwesta = [];

		 foreach ($theovertimereq as $value) {
			 $marekwesta[] = $value['OvertimeRequester']['id'];
		 }
		$rikwestaid = implode(",", $marekwesta);

		if(!$rikwestaid) { $rikwestaid = 0; }

 		//$condition = 'Overtime.overtime_requester_id IN ('.$rikwestaid.')';

		if($who == 2) {
			$directorsarr = array_intersect($this->director_approvers, unserialize($this->Auth->user()['permissions']));

			$thekey = key($directorsarr);
			$theedepartmetn = $this->Department->find('first',[
									'contain' => array('DepartmentSection'),
									'conditions' => ['Department.id' => $thekey ],
									'order' => 'Department.id DESC'
							]);

			$sec[] = ' - Select Unit - ';
			foreach($theedepartmetn['DepartmentSection'] as $sects) {
				$sec[$sects['id']] = $sects['name'];
			}
			$this->set('maindetails', $theedepartmetn);
			$this->set('sectins', $sec);
			$condition = 'OvertimeRequester.department_id IN ('.$thekey.') AND Overtime.tracker NOT IN (0, 1)';
		}

		if($who == 4) {
			$condition = ' Overtime.tracker NOT IN (0, 1)';
		}

	 if ($this->request->is('post')) {

		 if($this->request->data['Overtime']['employee']) {
			 $condition1 = 'OvertimeRequester.id = '.$this->request->data['Overtime']['employee'];
		 }
		 if($this->request->data['Overtime']['department_id']) {
			$condition3 = 'OvertimeRequester.department_id = '.$this->request->data['Overtime']['department_id'];
			}
			 if($this->request->data['Overtime']['salary_number']) {
				 $condition5 = 'OvertimeRequester.salary_number = \''.$this->request->data['Overtime']['salary_number'].'\'';
			 }

			//Now build the condition
			if($condition1) {
				$condition = $condition1;
			}
			if($condition2) {
				 if($condition) {
					 $condition .= ' AND '.$condition2;
				 } else {
					 $condition = $condition2;
				 }
			}
			if($condition3) {
				 if($condition) {
					 $condition .= ' AND '.$condition3;
				 } else {
					 $condition = $condition3;
				 }
			}
			if($condition5) {
				 if($condition) {
					 $condition .= ' AND '.$condition5;
				 } else {
					 $condition = $condition5;
				 }
			}
	 }

		//Add an extra layer now of sections
		$data = $this->Overtime->find('all', [
			'contain' => ['OvertimeRequester', 'DepartmentSection'],
				'conditions' => [$condition],
				'order' => 'OvertimeRequester.id DESC'
		]);

		$option = ['0' => '- Choose -', '1' => 'Yes', '2' => 'No'];
		$this->set('option', $option);
		$month_names = ["- Choose Month -", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		$this->set('months', $month_names);

		$this->loadModel('OvertimeRequester'); //or you can load it in beforeFilter()
		$requester = $this->OvertimeRequester->find('all');
		$employees = [' - Select Employee - '];
		$uploaders = [' - Select Uploader - '];
		foreach ($requester as $value) {
			$employees[$value['OvertimeRequester']['id']] = $value['OvertimeRequester']['first_name'].' '.$value['OvertimeRequester']['last_name'];
			$uploaders[$value['User']['id']] = $value['User']['fname'].' '.$value['User']['sname'];
		}
		$this->set('employees', $employees);
		$this->set('uploaders', $uploaders);

		$this->loadModel('Department'); //or you can load it in beforeFilter()
		$departments = $this->Department->find('all');
		$depts = [' - Select Directorate - '];
		foreach ($departments as $value) {
			$depts[$value['Department']['id']] = $value['Department']['name'];
		}

		if($who == 2) {
			$directorsarr = array_intersect($this->director_approvers, unserialize($this->Auth->user()['permissions']));
			$thekey = key($directorsarr);
			$theedepartmetn = $this->Department->find('first',[
									'contain' => array('DepartmentSection'),
									'conditions' => ['Department.id' => $thekey ],
									'order' => 'Department.id DESC'
							]);

			//$sec[] = ' - Select Unit - ';
			foreach($theedepartmetn['DepartmentSection'] as $sects) {
				$sec[$sects['id']] = $sects['name'];
			}
			$this->set('maindetails', $theedepartmetn);
			$this->set('sectins', $sec);
		}

		$this->set('depts', $depts);
		$this->set('requester', $requester);
		$this->set('preovertimes', $data);
		$this->set('period', $this->period);
		$this->set('months', $this->months);
		$this->set('who', $who);
}


	public function directoratebreakdownsingleone($dept_section_id)
	{
		//Get all the manager_approvers
		$this->loadModel('DepartmentSection');
		$allpermsdepartment = $this->DepartmentSection->find('first', ['conditions' => ['DepartmentSection.id' => $dept_section_id ]]);

		$this->set('DepartmentSectionsname', $allpermsdepartment['DepartmentSection']['name']);
		$this->set('DepartmentName', $allpermsdepartment['Department']['name']);

		//Get all the manager_approvers
		$this->loadModel('Department');
		$alldepartment = $this->Department->find('all');
		$this->director_approvers = [];
		foreach ($alldepartment as $value) {
			$this->director_approvers[$value['Department']['id']] = $value['Department']['director_permission'];
		}

		$whatineed = array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions']));
		$all_departments = array_intersect($this->departments, unserialize($this->Auth->user()['permissions']));
		$all_departments = array_flip($all_departments);
		$comma_separated = implode(",", $all_departments);
		$all_depts_secti = array_flip($whatineed);
		$comma_sep_secti = implode(",", $all_depts_secti);

		$theedepartmetn = $this->Department->find('first', array(
								'contain' => array('DepartmentSection'),
								'joins' => [
												[
														'table' => 'department_sections',
														'type' => 'INNER',
														'conditions' => [
																'Department.id = department_sections.department_id '
														]
												]
										],
								'conditions' => ['department_sections.id IN ('.$dept_section_id.')' ],
								'order' => 'Department.id DESC'
						));

		$this->set('maindetails', $theedepartmetn);
		$this->set('deparsections', $all_depts_secti);

		$this->loadModel('OvertimeRequester');
		$theovertimereq = $this->OvertimeRequester->find('all', array(
								'conditions' => [" OvertimeRequester.department_section_id IN ({$dept_section_id})" ]
						));

		$marekwesta = [];

		 foreach ($theovertimereq as $value) {
			 $marekwesta[] = $value['OvertimeRequester']['id'];
		 }
		$rikwestaid = implode(",", $marekwesta);

		if(!$rikwestaid) { $rikwestaid = 0; }

 		$condition = 'Overtime.overtime_requester_id IN ('.$rikwestaid.') and Overtime.tracker IN (4,6,7) ';
		//echo $condition;die;
	 if ($this->request->is('post')) {

		 if($this->request->data['Overtime']['employee']) {
			 $condition1 = 'OvertimeRequester.id = '.$this->request->data['Overtime']['employee'];
		 }
		 if($this->request->data['Overtime']['department_id']) {
			$condition3 = 'OvertimeRequester.department_id = '.$this->request->data['Overtime']['department_id'];
			}
			 if($this->request->data['Overtime']['salary_number']) {
				 $condition5 = 'OvertimeRequester.salary_number = \''.$this->request->data['Overtime']['salary_number'].'\'';
			 }

			//Now build the condition
			if($condition1) {
				$condition = $condition1;
			}
			if($condition2) {
				 if($condition) {
					 $condition .= ' AND '.$condition2;
				 } else {
					 $condition = $condition2;
				 }
			}
			if($condition3) {
				 if($condition) {
					 $condition .= ' AND '.$condition3;
				 } else {
					 $condition = $condition3;
				 }
			}
			if($condition5) {
				 if($condition) {
					 $condition .= ' AND '.$condition5;
				 } else {
					 $condition = $condition5;
				 }
			}
	 }
//Tarisa pano
		//Add an extra layer now of sections
		$data = $this->Overtime->find('all', [
			'contain' => ['OvertimeRequester', 'DepartmentSection'],
				'conditions' => [$condition],
				'order' => 'OvertimeRequester.id DESC',
				'group' => 'OvertimeRequester.salary_number'
		]);

		//Add an extra layer now of sections
		$data_now = $this->Overtime->find('all', [
			'contain' => ['OvertimeRequester', 'DepartmentSection'],
				'conditions' => [$condition],
				'order' => 'OvertimeRequester.id DESC',
				'fields' => ['sum(Overtime.total_hours) as total_sum', 'sum(Overtime.rate) as total_rate', 'OvertimeRequester.salary_number'],
				'group' => 'OvertimeRequester.salary_number'
		]);

		$summed = [];
		foreach($data_now as $clive) {
			 $summed[$clive['OvertimeRequester']['salary_number']+$clive['Overtime']['id']] = $clive[0]['total_sum'];
	 		 $summed[$clive['OvertimeRequester']['salary_number']+$clive['Overtime']['id']+$clive['Overtime']['id']] = $clive[0]['total_rate'];
		}

	  $this->set('summed', $summed);

		$option = ['0' => '- Choose -', '1' => 'Yes', '2' => 'No'];
		$this->set('option', $option);
		$month_names = ["- Choose Month -", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		$this->set('months', $month_names);

		$this->loadModel('OvertimeRequester'); //or you can load it in beforeFilter()
		$requester = $this->OvertimeRequester->find('all');
		$employees = [' - Select Employee - '];
		$uploaders = [' - Select Uploader - '];
		foreach ($requester as $value) {
			$employees[$value['OvertimeRequester']['id']] = $value['OvertimeRequester']['first_name'].' '.$value['OvertimeRequester']['last_name'];
			$uploaders[$value['User']['id']] = $value['User']['fname'].' '.$value['User']['sname'];
		}
		$this->set('employees', $employees);
		$this->set('uploaders', $uploaders);

		$this->loadModel('Department'); //or you can load it in beforeFilter()
		$departments = $this->Department->find('all');
		$depts = [' - Select Directorate - '];
		foreach ($departments as $value) {
			$depts[$value['Department']['id']] = $value['Department']['name'];
		}
		$this->set('depts', $depts);
		$this->set('requester', $requester);
		$this->set('preovertimes', $data);
		$this->set('period', $this->period);
		$this->set('months', $this->months);
		if(in_array(113, unserialize($this->Auth->user()['permissions']))) {
			$this->set('mm', 1);
		} else {
			$this->set('mm', 0);
		}
}

	public function directoratebreakdownsingle($dept_section_id)
	{
		//Get all the manager_approvers
		$this->loadModel('DepartmentSection');
		$allpermsdepartment = $this->DepartmentSection->find('first', ['conditions' => ['DepartmentSection.id' => $dept_section_id ]]);

		$this->set('DepartmentSectionsname', $allpermsdepartment['DepartmentSection']['name']);
		$this->set('DepartmentName', $allpermsdepartment['Department']['name']);

		//Get all the manager_approvers
		$this->loadModel('Department');
		$alldepartment = $this->Department->find('all');
		$this->director_approvers = [];
		foreach ($alldepartment as $value) {
			$this->director_approvers[$value['Department']['id']] = $value['Department']['director_permission'];
		}

		$whatineed = array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions']));
		$all_departments = array_intersect($this->departments, unserialize($this->Auth->user()['permissions']));
		$all_departments = array_flip($all_departments);
		$comma_separated = implode(",", $all_departments);
		$all_depts_secti = array_flip($whatineed);
		$comma_sep_secti = implode(",", $all_depts_secti);

		$theedepartmetn = $this->Department->find('first', array(
								'contain' => array('DepartmentSection'),
								'joins' => [
												[
														'table' => 'department_sections',
														'type' => 'INNER',
														'conditions' => [
																'Department.id = department_sections.department_id '
														]
												]
										],
								'conditions' => ['department_sections.id IN ('.$dept_section_id.')' ],
								'order' => 'Department.id DESC'
						));

		$this->set('maindetails', $theedepartmetn);
		$this->set('deparsections', $all_depts_secti);

		$this->loadModel('OvertimeRequester');
		$theovertimereq = $this->OvertimeRequester->find('all', array(
								'conditions' => [" OvertimeRequester.department_section_id IN ({$dept_section_id})" ]
						));

		$marekwesta = [];

		 foreach ($theovertimereq as $value) {
			 $marekwesta[] = $value['OvertimeRequester']['id'];
		 }
		$rikwestaid = implode(",", $marekwesta);

		if(!$rikwestaid) { $rikwestaid = 0; }

 		$condition = 'Overtime.overtime_requester_id IN ('.$rikwestaid.') and Overtime.tracker = 4 ';
		//echo $condition;die;
	 if ($this->request->is('post')) {

		 if($this->request->data['Overtime']['employee']) {
			 $condition1 = 'OvertimeRequester.id = '.$this->request->data['Overtime']['employee'];
		 }
		 if($this->request->data['Overtime']['department_id']) {
			$condition3 = 'OvertimeRequester.department_id = '.$this->request->data['Overtime']['department_id'];
			}
			 if($this->request->data['Overtime']['salary_number']) {
				 $condition5 = 'OvertimeRequester.salary_number = \''.$this->request->data['Overtime']['salary_number'].'\'';
			 }

			//Now build the condition
			if($condition1) {
				$condition = $condition1;
			}
			if($condition2) {
				 if($condition) {
					 $condition .= ' AND '.$condition2;
				 } else {
					 $condition = $condition2;
				 }
			}
			if($condition3) {
				 if($condition) {
					 $condition .= ' AND '.$condition3;
				 } else {
					 $condition = $condition3;
				 }
			}
			if($condition5) {
				 if($condition) {
					 $condition .= ' AND '.$condition5;
				 } else {
					 $condition = $condition5;
				 }
			}
	 }

		//Add an extra layer now of sections
		$data = $this->Overtime->find('all', [
			'contain' => ['OvertimeRequester', 'DepartmentSection'],
				'conditions' => [$condition],
				'order' => 'OvertimeRequester.id DESC'
		]);

		$option = ['0' => '- Choose -', '1' => 'Yes', '2' => 'No'];
		$this->set('option', $option);
		$month_names = ["- Choose Month -", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		$this->set('months', $month_names);

		$this->loadModel('OvertimeRequester'); //or you can load it in beforeFilter()
		$requester = $this->OvertimeRequester->find('all');
		$employees = [' - Select Employee - '];
		$uploaders = [' - Select Uploader - '];
		foreach ($requester as $value) {
			$employees[$value['OvertimeRequester']['id']] = $value['OvertimeRequester']['first_name'].' '.$value['OvertimeRequester']['last_name'];
			$uploaders[$value['User']['id']] = $value['User']['fname'].' '.$value['User']['sname'];
		}
		$this->set('employees', $employees);
		$this->set('uploaders', $uploaders);

		$this->loadModel('Department'); //or you can load it in beforeFilter()
		$departments = $this->Department->find('all');
		$depts = [' - Select Directorate - '];
		foreach ($departments as $value) {
			$depts[$value['Department']['id']] = $value['Department']['name'];
		}
		$this->set('depts', $depts);
		$this->set('requester', $requester);
		$this->set('preovertimes', $data);
		$this->set('period', $this->period);
		$this->set('months', $this->months);
		if(in_array(113, unserialize($this->Auth->user()['permissions']))) {
			$this->set('mm', 1);
		} else {
			$this->set('mm', 0);
		}
}

	public function directorreport($who)
	{
		//Get all the manager_approvers
		$this->loadModel('DepartmentSection');
		$allpermsdepartment = $this->DepartmentSection->find('all');
		$this->manager_approvers = [];
		$dept_sections = [];
		foreach ($allpermsdepartment as $value) {
			$this->manager_approvers[$value['DepartmentSection']['id']] = $value['DepartmentSection']['permission'];
			$dept_sections[$value['DepartmentSection']['id']] = $value['DepartmentSection']['name'];
		}
		$this->set('DepartmentSections', $dept_sections);
		//Get all the manager_approvers
		$this->loadModel('Department');
		$alldepartment = $this->Department->find('all');
		$this->departments = [];
		foreach ($alldepartment as $value) {
			$this->departments[$value['Department']['id']] = $value['Department']['permission'];
		}
		//Get all the manager_approvers
		$this->loadModel('Department');
		$alldepartment = $this->Department->find('all');
		$this->director_approvers = [];
		foreach ($alldepartment as $value) {
			$this->director_approvers[$value['Department']['id']] = $value['Department']['director_permission'];
		}

		$whatineed = array_intersect($this->director_approvers, unserialize($this->Auth->user()['permissions']));
		//$all_departments = array_intersect($this->departments, unserialize($this->Auth->user()['permissions']));
		//$all_departments = array_flip($all_departments);
		//$comma_separated = implode(",", $all_departments);
		$all_depts_secti = array_flip($whatineed);
		$comma_separated = implode(",", $all_depts_secti);
//print_r($comma_separated);die;
	if($who != 4){
			$theedepartmetn = $this->Department->find('first', array(
									'contain' => array('DepartmentSection'),
									'joins' => [
													[
															'table' => 'department_sections',
															'type' => 'INNER',
															'conditions' => [
																	'Department.id = department_sections.department_id '
															]
													]
											],
									'conditions' => ["Department.id IN ({$comma_separated})" ],
									'order' => 'Department.id DESC'
							));
	} else {
		$theedepartmetn = $this->Department->find('first', array(
								'contain' => array('DepartmentSection'),
								'joins' => [
												[
														'table' => 'department_sections',
														'type' => 'INNER',
														'conditions' => [
																'Department.id = department_sections.department_id '
														]
												]
										],
								'order' => 'Department.id DESC'
						));
	}

		$this->set('maindetails', $theedepartmetn);
		$this->set('deparsections', $all_depts_secti);

		$this->loadModel('OvertimeRequester');
		if($who != 4){
			$theovertimereq = $this->OvertimeRequester->find('all', array(
									'conditions' => ["OvertimeRequester.department_id IN ({$comma_separated}) " ]
							));
		} else {
			$theovertimereq = $this->OvertimeRequester->find('all');
		}

		$marekwesta = [];

		 foreach ($theovertimereq as $value) {
			 $marekwesta[] = $value['OvertimeRequester']['id'];
		 }
		$rikwestaid = implode(",", $marekwesta);

		//$condition = 'Overtime.overtime_requester_id IN ('.$rikwestaid.')';
		if($who != 4){
			$condition = "OvertimeRequester.department_id IN ({$comma_separated}) AND Overtime.tracker NOT IN (0,1,2)";
		} else {
			$condition = " Overtime.tracker NOT IN (0,1,2)";
		}

		//echo $condition;die;
	 if ($this->request->is('post')) {

		 if($this->request->data['Overtime']['employee']) {
			 $condition1 = 'OvertimeRequester.id = '.$this->request->data['Overtime']['employee'];
		 }
		 if($this->request->data['Overtime']['department_id']) {
			$condition3 = 'OvertimeRequester.department_id = '.$this->request->data['Overtime']['department_id'];
			}
			 if($this->request->data['Overtime']['salary_number']) {
				 $condition5 = 'OvertimeRequester.salary_number = \''.$this->request->data['Overtime']['salary_number'].'\'';
			 }

			//Now build the condition
			if($condition1) {
				$condition = $condition1;
			}
			if($condition2) {
				 if($condition) {
					 $condition .= ' AND '.$condition2;
				 } else {
					 $condition = $condition2;
				 }
			}
			if($condition3) {
				 if($condition) {
					 $condition .= ' AND '.$condition3;
				 } else {
					 $condition = $condition3;
				 }
			}
			if($condition5) {
				 if($condition) {
					 $condition .= ' AND '.$condition5;
				 } else {
					 $condition = $condition5;
				 }
			}
	 }

		//Add an extra layer now of sections
		$data = $this->Overtime->find('all', [
			'contain' => ['OvertimeRequester', 'DepartmentSection'],
				'conditions' => [$condition],
				'order' => 'OvertimeRequester.id DESC'
		]);

		$option = ['0' => '- Choose -', '1' => 'Yes', '2' => 'No'];
		$this->set('option', $option);
		$month_names = ["- Choose Month -", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		$this->set('months', $month_names);

		$this->loadModel('OvertimeRequester'); //or you can load it in beforeFilter()
		$requester = $this->OvertimeRequester->find('all');
		$employees = [' - Select Employee - '];
		$uploaders = [' - Select Uploader - '];
		foreach ($requester as $value) {
			$employees[$value['OvertimeRequester']['id']] = $value['OvertimeRequester']['first_name'].' '.$value['OvertimeRequester']['last_name'];
			$uploaders[$value['User']['id']] = $value['User']['fname'].' '.$value['User']['sname'];
		}
		$this->set('employees', $employees);
		$this->set('uploaders', $uploaders);

		$this->loadModel('Department'); //or you can load it in beforeFilter()
		$departments = $this->Department->find('all');
		$depts = [' - Select Directorate - '];
		foreach ($departments as $value) {
			$depts[$value['Department']['id']] = $value['Department']['name'];
		}

		if($who == 2) {
			$directorsarr = array_intersect($this->director_approvers, unserialize($this->Auth->user()['permissions']));
			$thekey = key($directorsarr);
			$theedepartmetn = $this->Department->find('first',[
									'contain' => array('DepartmentSection'),
									'conditions' => ['Department.id' => $thekey ],
									'order' => 'Department.id DESC'
							]);

			$sec[] = ' - Select Unit - ';
			foreach($theedepartmetn['DepartmentSection'] as $sects) {
				$sec[$sects['id']] = $sects['name'];
			}
			$this->set('maindetails', $theedepartmetn);
			$this->set('sectins', $sec);
		}

		$this->set('who', $who);
		$this->set('depts', $depts);
		$this->set('requester', $requester);
		$this->set('preovertimes', $data);
		$this->set('period', $this->period);
		$this->set('months', $this->months);
		if(in_array(113, unserialize($this->Auth->user()['permissions']))) {
			$this->set('mm', 1);
		} else {
			$this->set('mm', 0);
		}

	}

	public function sendovertime($requester_id)
	{
		//Update the preovertimes, this indicates that its being processed
		$this->loadModel('Preovertime');
		$this->Preovertime->updateAll(
	    ['Preovertime.overtime_inprocess' => 1],
	    ['Preovertime.overtime_requester_id' => $requester_id]
		);

		//Update the overtimes now
		$this->Overtime->updateAll(
			['Overtime.tracker' => 1],
			['Overtime.overtime_requester_id' => $requester_id]
		);

		//Now email the manager
		$this->loadModel('OvertimeRequester');
		$options = array('conditions' => array('OvertimeRequester.' . $this->OvertimeRequester->primaryKey => $requester_id));
		$requester = $this->OvertimeRequester->find('first', $options);

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
		}
		//Get all the manager_approvers
		$this->loadModel('Department');
		$alldepartment = $this->Department->find('all');
		$this->director_approvers = [];
		foreach ($alldepartment as $value) {
			$this->director_approvers[$value['Department']['id']] = $value['Department']['director_permission'];
		}

		//Department of the requester to determine your manager
		$department_id = $requester['OvertimeRequester']['department_id'];
		$section_id 	 = $requester['OvertimeRequester']['department_section_id']; //This is for managers

		$permission_is = $this->manager_approvers[$section_id];
		//Notify the manager via emails
		$template = 'overtimecompiled';
		$message = $requester['OvertimeRequester']['first_name'].' '.$requester['OvertimeRequester']['last_name'].' has claimed an overtime. Please login to <a href="trustconetest.co.za">trustconetest.co.za</a> to view it and to make your decision';
		$subject = "Overtime claim of ".$requester['OvertimeRequester']['first_name'].' '.$requester['OvertimeRequester']['last_name'];
		$this->sendemail($message, $subject, $permission_is, $template);

		$id = $requester_id;

		$this->loadModel('AuditTrail');
		$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
		$auditTrail['AuditTrail']['event_description'] = "Overtime requester with id <b>({$id})</b> sent for approval from IP address ".$_SERVER['REMOTE_ADDR'];

		$auditTrail['AuditTrail']['contents'] = "Overtime requester with <b>({$id})</b> sent for approval from IP address ".$_SERVER['REMOTE_ADDR'];
		if( !$this->AuditTrail->save($auditTrail))
		{
				die('There was a problem trying to save the audit trail for viewing Overtime document');
		}

		return $this->redirect(array('action' => 'index'));
	}


		public function resendtomanager()
		{
			$this->autoRender = false;
			$overtime_id = $this->request->data['id'];

			//Update the overtime so it goes to manager
			$this->Overtime->id = $overtime_id;
			$this->Overtime->saveField('tracker', 1);

			$theeOvertime = $this->Overtime->query("SELECT * FROM overtimes where id = ".$overtime_id);

			//Now email the manager
			$this->loadModel('OvertimeRequester');
			$options = array('conditions' => array('OvertimeRequester.' . $this->OvertimeRequester->primaryKey => $theeOvertime[0]['overtimes']['overtime_requester_id']));
			$requester = $this->OvertimeRequester->find('first', $options);

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
			}
			//Get all the manager_approvers
			$this->loadModel('Department');
			$alldepartment = $this->Department->find('all');
			$this->director_approvers = [];
			foreach ($alldepartment as $value) {
				$this->director_approvers[$value['Department']['id']] = $value['Department']['director_permission'];
			}

			//Department of the requester to determine your manager
			$department_id = $requester['OvertimeRequester']['department_id'];
			$section_id 	 = $requester['OvertimeRequester']['department_section_id']; //This is for managers

			$permission_is = $this->manager_approvers[$section_id];
			//Notify the manager via emails
			$template = 'overtimecompiled';
			$message = $requester['OvertimeRequester']['first_name'].' '.$requester['OvertimeRequester']['last_name'].' has resubmitted a claim for overtime. Please login to <a href="trustconetest.co.za">trustconetest.co.za</a> to view it and to make your decision';
			$subject = "Edited Overtime claim from ".$requester['OvertimeRequester']['first_name'].' '.$requester['OvertimeRequester']['last_name'];
			$this->sendemail($message, $subject, $permission_is, $template);

			$id = $requester_id;

			$this->loadModel('AuditTrail');
			$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
			$auditTrail['AuditTrail']['event_description'] = "Edited Overtime requester with id <b>({$id})</b> sent for approval from IP address ".$_SERVER['REMOTE_ADDR'];

			$auditTrail['AuditTrail']['contents'] = "Edited Overtime requester with <b>({$id})</b> sent for approval from IP address ".$_SERVER['REMOTE_ADDR'];
			if( !$this->AuditTrail->save($auditTrail))
			{
					die('There was a problem trying to save the audit trail for viewing Edited Overtime document');
			}

			return $this->redirect(array('action' => 'index'));
}


 public function sendtocfo() {
		$this->autoRender = false;

		//Get all the overtimes so as to update
		$this->loadModel('OvertimeRequester');

		$data = $this->OvertimeRequester->find('all', [
			'contain' => ['OvertimeReason', 'Preovertime', 'OvertimeRequester', 'Overtime', 'Department', 'User'],
			'joins' => [
							[
									'table' => 'preovertimes',
									'type' => 'INNER',
									'conditions' => [
																		'preovertimes.overtime_requester_id = OvertimeRequester.id'
																	]
							],
							[
									'table' => 'overtimes',
									'type' => 'INNER',
									'conditions' => [
																		'overtimes.overtime_requester_id = OvertimeRequester.id'
																	]
							]
					],
				'conditions' => [ 'overtimes.tracker in (3)' ],
				'order' => 'OvertimeRequester.id DESC',
				'group' => 'OvertimeRequester.salary_number'
		]);

		foreach ($data as $overtimeRequester){
			$overtimeRequester_id .= $overtimeRequester['OvertimeRequester']['id'].',';
		}

		$overtimeRequester_id = substr( $overtimeRequester_id, 0, -1);

		$data = $this->Overtime->find('all', array(
				'contain' => ['OvertimeReason', 'Preovertime', 'OvertimeRequester'],
				'conditions' => ['Overtime.tracker in (3)', "Overtime.overtime_requester_id IN ({$overtimeRequester_id})" ],
				'order' => 'Overtime.id DESC'
		));

		//Now loop all the overtimes and updated
		foreach ($data as $value) {
			$this->Overtime->id = $value['Overtime']['id'] ;
			$this->Overtime->saveField('tracker', 4);
		}

		$by_who = 'Salaries Department';
		$subject = 'Overtime approval request ';
		$message = 'A new overtimes approvals request has been submitted to you from the salaries department. Please login to <a href="trustconetest.co.za">trustconetest.co.za</a> to view it and to make your decision';
		$by_who = 'Salaries';
		$template = "escalatedovertime";
		//put notifications here
		$this->sendemail($message, $subject, 112, $template, $by_who, 1); //the 1110 is the permission
		return $this->redirect(array('controller' => 'Overtimes', 'action' => 'index'));
 }

  public function saverate() {
 		$this->autoRender = false;
 		$id 	= $this->request->data['id'];
 		$rate	= $this->request->data['rate'];

 		$this->Overtime->id = $id;
 		$this->Overtime->saveField('rate', $rate);
 		//poor code here
 		//$this->Overtime->saveField('tracker', 4);
  }

	public function updateresend() {

			$this->autoRender = false;
			$overtime_id 			= $this->request->data['id'];

			$this->Overtime->id = $overtime_id;
			$this->Overtime->saveField('enable_resend', 1);

			$theeOvertime = $this->Overtime->query("SELECT * FROM overtimes where id = ".$overtime_id);
			$requester = $this->Overtime->OvertimeRequester->find('first', [ 'condition' => ['Overtime.id' => $overtime_id] ]);

			$towho = $requester['OvertimeRequester']['cellnumber'];
			//Send email only to the uploader
			$template = 'declined';
			//$message = 'Your request for approval was declined by '.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'].'.';
			$subject = 'Permission is been granted to resubmit';
			$message = $smsmessage = 'Permission has been granted for you to resubmit your overtime worked on the '.$theeOvertime[0]['overtimes']['whatsdone'].' for '.$theeOvertime[0]['overtimes']['total_hours'].' hours on '.$theeOvertime[0]['overtimes']['overtime_date'];

			//Send an sms to the requester and an email to the uploader
			$this->sendsms($smsmessage, $towho);
			$this->sendemailUploader($message, $subject, $requester['OvertimeRequester']['user_id'], $which);

			$this->loadModel('AuditTrail');
			$auditTrail['AuditTrail']['event_description'] =$message;
			$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
			$auditTrail['AuditTrail']['contents'] = "Overtime request decision taken";
			if (!$this->AuditTrail->save($auditTrail)) {
					die('There was a problem trying to save the audit trail');
			}

	}

	public function escalate($id = null, $tracker = null) {

			$this->autoRender = false;
			$id 			= $this->request->data['id'];
			$decision = $this->request->data['decision'];
			$comment  = $this->request->data['comment'];

			$by_who = '';
			if($tracker == 1){
				$by_who = 'Manager';
			}
			if($tracker == 2){
				$by_who = 'Director';
			}
			if($tracker == 3){
				$by_who = 'Salaries Department';
			}
			if($tracker == 4){
				$by_who = 'CFO';
			}

			$approver_name = $this->Auth->user()['fname']." ".$this->Auth->user()['sname'];
			$subject = $by_who.' approved overtime request';

			$theeOvertime = $this->Overtime->query("SELECT * FROM overtimes where id = ".$id);

			$requester = $this->Overtime->OvertimeRequester->find('first', [ 'condition' => ['Overtime.id' => $id] ]);

			$towho = $requester['OvertimeRequester']['cellnumber'];

			$auditTrail['AuditTrail']['event_description'] = "{$by_who} with id ".$this->Auth->user('id')."
																								has approved document with id  ".$id;

			$template = "escalatedovertime";
			$subject = 'Overtime request with id '.$id.' has been approved by '.$by_who;

			//Save the audit trail
			$this->loadModel('AuditTrail');
			//Get the user
			$this->loadModel('User');
			$this->loadModel('OvertimeReason');

			//Take it to the first level in finance by updating the tracker to 3 now
			$reason = "";
			$this->Overtime->id = $id;
			$level = 0;

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
			}
			//Get all the manager_approvers
			$this->loadModel('Department');
			$alldepartment = $this->Department->find('all');
			$this->director_approvers = [];
			foreach ($alldepartment as $value) {
				$this->director_approvers[$value['Department']['id']] = $value['Department']['director_permission'];
			}

			if( array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions'])) || in_array(112, unserialize($this->Auth->user()['permissions'])) || array_intersect($this->director_approvers, unserialize($this->Auth->user()['permissions'])) )
			{
				if(array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions']))) {
					if($decision == 1){ //Means its been approved so move on to first level of finance
						  $level = 2;
							$this->Overtime->saveField('tracker', 2);
							$reason = 'Overtime request has been approved by ('.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'].') and sent to director';
							//Send email notification to the next finace guy, and to the uploader of the document
							$template = 'approved';
							$which = 2;
							$message = 'Overtime request from '.$requester['Overtime']['fname'].' '.$requester['Overtime']['sname'].' has been put in that needs your attention. Please login to <a href="trustconetest.co.za">trustconetest.co.za</a> to view it and to make your decision.<br />'.$reason;
							$subject = "Overtime request approved";
							$result = array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions']));
							$this->sendemail($message, $subject, $result[0], $template, $by_who, $escalated); //the 1110 is the permission
					} else {
							$this->Overtime->saveField('tracker', 10); //10 means declined on executive level
							$reason = $comment;
							$which = 1;
							$level = 2;
							//Send email only to the uploader
							$template = 'declined';
							//$message = 'Your request for approval was declined by '.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'].'.';
							$subject = 'Overtime request  declined by manager';
							$smsmessage = 'Your overtime worked on the '.$theeOvertime[0]['overtimes']['whatsdone'].' for '.$theeOvertime[0]['overtimes']['total_hours'].' hours on '.$theeOvertime[0]['overtimes']['overtime_date'].', was declined by the manager, please contact him/her.';
							$message = 'Your overtime worked on the '.$theeOvertime[0]['overtimes']['whatsdone'].' for '.$theeOvertime[0]['overtimes']['total_hours'].' hours on '.$theeOvertime[0]['overtimes']['overtime_date'].', was declined by the manager, please contact him/her.';

							//Send an sms to the requester and an email to the uploader
							$this->sendsms($smsmessage, $towho);
							$this->sendemailUploader($message, $subject, $requester['OvertimeRequester']['user_id'], $which);
					}
				}

				if(array_intersect($this->director_approvers, unserialize($this->Auth->user()['permissions']))) {
					if($decision == 1){ //Means its been approved so move on to first level of finance
							$this->Overtime->saveField('tracker', 3);
							$level = 3;
							$reason = 'Overtime request has been approved by director ('.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'].') and sent CFO';
							//Send email notification to the next finace guy, and to the uploader of the document
							$template = 'approved';
							$which = 2;
							$message = 'Overtime request from '.$requester['Overtime']['fname'].' '.$requester['Overtime']['sname'].' has been compiled that needs your attention. Please login to <a href="trustconetest.co.za">trustconetest.co.za</a> to view it and to make your decision. <br />'.$reason;
							$subject = "Overtime approval request from - ".$this->allControllers[$overtiming['Overtime']['department_id']];
							$result = array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions']));
							$this->sendemail($message, $subject, $result[0], $template, $by_who, $escalated);
					} else {
							$this->Overtime->saveField('tracker', 11); //12 declined by manger SCM
							$reason = $comment;
							$which = 1;
							$level = 3;
							//Send email only to the uploader
							$template = 'declined';
							$message = 'Your request for approval was declined by director. ('.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'].')';
							$subject = 'Overtime request  declined by director';
							$smsmessage = 'Your overtime worked on the '.$theeOvertime[0]['overtimes']['whatsdone'].' for '.$theeOvertime[0]['overtimes']['total_hours'].' hours on '.$theeOvertime[0]['overtimes']['overtime_date'].', was declined by the director, please contact your manager.';

							//Send an sms to the requester and an email to the uploader
							$this->sendsms($smsmessage, $towho);
							$this->sendemailUploader($message, $subject, $requester['OvertimeRequester']['user_id'], $which);

							$deptSection = $this->DepartmentSection->find('first', ['condition' => ['DepartmentSection.id' => $requester['OvertimeRequester']['department_section_id']]]);
							$manager_permission = $deptSection['DepartmentSection']['permission'];

							$message1 = "The overtime of {$requester['OvertimeRequester']['first_name']} {$requester['OvertimeRequester']['last_name']} worked for {$theeOvertime[0]['overtimes']['whatsdone']} for {$theeOvertime[0]['overtimes']['total_hours']} hour/s on {$theeOvertime[0]['overtimes']['overtime_date']} is declined by a Director";
							$subject1 = "Overtime declined by director";

							$this->sendemailManager($message1, $subject1, $manager_permission, 2);
					}
				}

				if(in_array(112, unserialize($this->Auth->user()['permissions']))) {

					if($decision == 1){ //Means its been approved so move on to first level of finance

							$smsmessage = 'Overtime '.$theeOvertime[0]['overtimes']['whatsdone'].', approved for '.$theeOvertime[0]['overtimes']['total_hours'].' hours';

							$this->Overtime->saveField('tracker', 6);
							$which = 2;
							$level = 4;
							$message = 'Overtime approved by the CFO ('.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'].'). The overtime is ('.$theeOvertime[0]['overtimes']['whatsdone'].') approved for '.$theeOvertime[0]['overtimes']['total_hours'].' hours';
							//Send email notification to the next finace guy, and to the uploader of the document
							$template = 'approved';
							$message = $reason;
							$subject = "Overtime request approval by the CFO";
							$smsmessage = 'Overtime '.$theeOvertime[0]['overtimes']['whatsdone'].', approved for '.$theeOvertime[0]['overtimes']['total_hours'].' hours';

							//Send an sms to the requester and an email to the uploader
							$this->sendsms($smsmessage, $towho);
							$this->sendemailUploader($message, $subject, $theeOvertime[0]['overtimes']['user_id'], $which);
					} else {
							$this->Overtime->saveField('tracker', 7); //10 means declined on executive level
							$reason = $comment;
							$which = 1;
							$level = 4;
							//Send email only to the uploader
							$template = 'declined';
							$message = 'Your overtime request for approval was declined by the CFO please login to see the reason.';
							$subject = 'Overtime request declined by CFO';

							$smsmessage = 'Your overtime worked on the '.$theeOvertime[0]['overtimes']['whatsdone'].' for '.$theeOvertime[0]['overtimes']['total_hours'].' on '.$theeOvertime[0]['overtimes']['overtime_date'].', declined by the CFO, please contact him/her.';

							$this->sendsms($smsmessage, $towho);
							$this->sendemailUploader($smsmessage, $subject, $theeOvertime[0]['overtimes']['user_id'], $which);
					}
				}

			}
			  $decision = 1;
				/************************** Save the reason and redirect back ********************************/
				$overtimeReason['OvertimeReason']['user_id'] = $this->Auth->user('id');
				$overtimeReason['OvertimeReason']['overtime_id'] = $id;
				$overtimeReason['OvertimeReason']['status'] = $decision;
				$overtimeReason['OvertimeReason']['level_id'] = $level;
				$overtimeReason['OvertimeReason']['reason'] = $reason;

				if ($this->OvertimeReason->save($overtimeReason)) {

				} else {
					echo 2;
						debug($this->OvertimeReason->invalidFields());
				}

				$auditTrail['AuditTrail']['event_description'] = "User (".$this->Auth->user('fname').' '.$this->Auth->user('sname').") with id " . $this->Auth->user('id') . $reason;

				$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
				$auditTrail['AuditTrail']['contents'] = "Overtime request decision taken";

				if (!$this->AuditTrail->save($auditTrail)) {
						die('There was a problem trying to save the audit trail');
				}
				 echo 1;
		}

public function editagain($overtime_id, $overtime_requester_id, $type=null) {

	$perioding = [1 => 'weekday', 2 => 'saturday', 3 => 'sunday', 4 => 'public_holiday'];

	if ($this->request->is('post')) {
			$this->Session->write('alldata', $this->request->data['Overtime']);
			$determine = $this->iscorrectday($this->request->data['Overtime']['overtime_date']);
			$overtime_to_ignore = $this->request->data['Overtime']['old_overtime_id'];
      unset($this->request->data['Overtime']['old_overtime_id']);
			$this->request->data['Overtime']['linked_to'] = $overtime_to_ignore;

			$end_time   = date("H:i", strtotime("{$this->request->data['Overtime']['end_time']['hour']}:{$this->request->data['Overtime']['end_time']['min']} {$this->request->data['Overtime']['end_time']['meridian']}"));
			$start_time = date("H:i", strtotime("{$this->request->data['Overtime']['start_time']['hour']}:{$this->request->data['Overtime']['start_time']['min']} {$this->request->data['Overtime']['start_time']['meridian']}"));

			if($this->request->data['Overtime']['end_time']['meridian'] == 'am' && $this->request->data['Overtime']['start_time']['meridian'] == 'pm'){
				$end_time = strtotime($end_time)+86400;
			} else {
				$end_time = strtotime($end_time);
			}

			if(strtotime($start_time) > $end_time) {
				$this->Session->setFlash(__('End time cannot be before starttime.'), 'default', array('class' => 'alert alert-danger'));
				return $this->redirect(array('action' => 'editagain', $overtime_to_ignore, $this->request->data['Overtime']['overtime_requester_id']));
			}

			if(strtotime($start_time) == $end_time) {
				$this->Session->setFlash(__('You cannot start and end at the same time.'), 'default', array('class' => 'alert alert-danger'));
				return $this->redirect(array('action' => 'editagain', $overtime_to_ignore, $this->request->data['Overtime']['overtime_requester_id']));
			}

			$tots = ($end_time - strtotime($start_time)) / 3600;

			$this->request->data['Overtime']['total_hours'] = $tots;

			if($this->request->data['Overtime']['period'] == 1) {

				if($determine != 1) {
					$this->Session->setFlash(__('The date you picked is not a weekday, you will have to recapture the overtime.'), 'default', array('class' => 'alert alert-danger'));
					return $this->redirect(array('action' => 'editagain', $overtime_to_ignore, $this->request->data['Overtime']['overtime_requester_id']));
				}

				$sunrise = "7:00 am";
				$sunset  = "4:00 pm";
				$date2   = strtotime($sunrise);
				$date3   = strtotime($sunset);
				$date1   = strtotime("{$this->request->data['Overtime']['end_time']['hour']}:{$this->request->data['Overtime']['end_time']['min']} {$this->request->data['Overtime']['end_time']['meridian']}");
				$date0   = strtotime("{$this->request->data['Overtime']['start_time']['hour']}:{$this->request->data['Overtime']['start_time']['min']} {$this->request->data['Overtime']['start_time']['meridian']}");

				if ($date0 > $date2 && $date0 < $date3)
				{
					$this->Session->setFlash(__('You are not allowed to work overtime before knock off time.<br /> You may work from 16:00 to 07:00 during weekdays.<br />You have to recapture the overtime.'), 'default', array('class' => 'alert alert-danger'));
					return $this->redirect(array('action' => 'editagain', $overtime_to_ignore, $this->request->data['Overtime']['overtime_requester_id']));
				}
				if ($date1 > $date2 && $date0 < $date3)
				{
					$this->Session->setFlash(__('You are not allowed to work overtime before knock off time.<br /> You may work from 16:00 to 07:00 during weekdays.<br />You have to recapture the overtime.'), 'default', array('class' => 'alert alert-danger'));
					return $this->redirect(array('action' => 'editagain', $overtime_to_ignore, $this->request->data['Overtime']['overtime_requester_id']));
				}
			} else if ( $this->request->data['Overtime']['period'] == 2 ) {

				if($determine != 2) {
					$this->Session->setFlash(__('A day you have picked is Saturday, then your date is invalid.'), 'default', array('class' => 'alert alert-danger'));
					return $this->redirect(array('action' => 'editagain', $overtime_to_ignore, $this->request->data['Overtime']['overtime_requester_id']));
				}
			} else if ( $this->request->data['Overtime']['period'] == 3 ) {

				if($determine != 3) {
					$this->Session->setFlash(__('The day you picked is not Sunday, then your day is not valid.'), 'default', array('class' => 'alert alert-danger'));
					return $this->redirect(array('action' => 'editagain', $overtime_to_ignore, $this->request->data['Overtime']['overtime_requester_id']));
				}
			}

			//First get the pre-overtime
			$this->loadModel('Preovertime');
			$options = array('conditions' => array('Preovertime.' . $this->Preovertime->primaryKey => $this->request->data['Overtime']['preovertime_id']));
			$thePreOvertime = $this->Preovertime->find('first', $options);

			//Check if we dealing with the same month here
			$monthcaptured = substr($this->request->data['Overtime']['overtime_date'], 5, 2);

			if(abs($monthcaptured) != $thePreOvertime['Preovertime']['overtime_month']) {

				$this->Session->setFlash(__('The month you picked is not the same as the one approved.<br />You are approved for month '.$thePreOvertime['Preovertime']['overtime_month'].' you chose '.$monthcaptured), 'default', array('class' => 'alert alert-danger'));
				return $this->redirect(array('action' => 'editagain', $overtime_to_ignore, $this->request->data['Overtime']['overtime_requester_id']));

			}
			//Verify that your start and end time for that day do not overlap
			$testtimes = $this->Overtime->find('all', array(
					'conditions' => ['Overtime.overtime_requester_id' => $this->request->data['Overtime']['overtime_requester_id'] ]
			));

		$this->request->data['Overtime']['user_id'] = $this->Auth->user('id');

		if(!$this->request->data['Overtime']['motivation']){

			$previous_overtime = $this->Overtime->find('all', array(
					'conditions' => ['Overtime.preovertime_id' => $this->request->data['Overtime']['preovertime_id'] ]
			));
			$this->loadModel('OvertimeRequester');
			$conditions = array('conditions' => array('OvertimeRequester.' . $this->OvertimeRequester->primaryKey => $this->request->data['Overtime']['overtime_requester_id']));
			$requester  = $this->Preovertime->OvertimeRequester->find('first', $conditions);

			$total = $tots;
			foreach ($previous_overtime as $value) {
				# Now add the overtimes and make sure its not more than 60
				//Need to exclude the time for the previous entry that is being edited
				if($value['Overtime']['id'] != $overtime_to_ignore) {
					if($value['Overtime']['period'] == $this->request->data['Overtime']['period']) {
						$total = $total + $value['Overtime']['total_hours'];
					}
				}
			}
$total = 0;
			if($total > $thePreOvertime['Preovertime'][$perioding[$this->request->data['Overtime']['period']]]) {
				//Go back and a
				$this->Session->setFlash(__('You have exceeded your pre approved hours for '.$perioding[$this->request->data['Overtime']['period']].'. Please give reasons why'), 'default', array('class' => 'alert alert-danger'));
				return $this->redirect(array('action' => 'editagain', $overtime_to_ignore, $this->request->data['Overtime']['overtime_requester_id'], 1));
			}
		}

		$this->Overtime->create();
		if ($this->Overtime->save($this->request->data)) {
			$OvertimeId = $this->Overtime->getLastInsertId();
			$id = $OvertimeId;
			$this->Session->setFlash(__('The overtime has been captured successfully.'), 'default', array('class' => 'alert alert-success'));

			//Update the pre-overtime, just that item so it wont show
			$this->loadModel('Preovertime');
			$this->Preovertime->saveField('overtime_inprocess', 1);

			//Update the previous overtime tracker
			$this->Overtime->id = $overtime_to_ignore;
			$this->Overtime->saveField('tracker', 100);

			$this->loadModel('AuditTrail');
			$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
			$auditTrail['AuditTrail']['event_description'] = "Overtime request <b>({$id})</b> captured from IP address ".$_SERVER['REMOTE_ADDR'];

			$auditTrail['AuditTrail']['contents'] = "Overtime request <b>({$id})</b> captured from IP address ".$_SERVER['REMOTE_ADDR'];
			if( !$this->AuditTrail->save($auditTrail))
			{
					die('There was a problem trying to save the audit trail for viewing Overtime document');
			}
			return $this->redirect(array('action' => 'overtimeitems',$this->request->data['Overtime']['overtime_requester_id'],$this->request->data['Overtime']['tracker']));
		} else {
			$this->Session->setFlash(__('The overtime could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
	}

	$this->loadModel('OvertimeReason');
	$this->loadModel('OvertimeRequester');
	$OvertimeReason= $this->OvertimeReason->find('first', ['conditions' => ['OvertimeReason.overtime_id' => $overtime_id], 'order' => 'OvertimeReason.id DESC']);
	$OvertimeRequester = $this->OvertimeRequester->find('first', ['conditions' => ['OvertimeRequester.id' => $overtime_requester_id]]);
//print_r($OvertimeRequester);
	$allrequesters['id']   = $OvertimeRequester['OvertimeRequester']['id'];
	$allrequesters['name'] = $OvertimeRequester['OvertimeRequester']['first_name'].' '.$OvertimeRequester['OvertimeRequester']['last_name'];
	$requester_pre_overtime = $this->getallpreovertime($overtime_requester_id);

	$this->set('preovertimes', $requester_pre_overtime);

	$this->set('allrequesters', $allrequesters);
	$this->set('OvertimeReason', $OvertimeReason);
	$this->set('theeOvertime', $theeOvertime);
	$this->set('period', $this->period);
	$this->set('type', $type);
}

	public function escalatecfo($id = null, $tracker = null) {
			$this->autoRender = false;
			$this->loadModel('AuditTrail');
			$this->loadModel('User');
			$this->loadModel('OvertimeReason');
			$this->loadModel('DepartmentSection');
			$this->loadModel('OvertimeRequester');
			//$id 			= $this->request->data['id'];
			$decision = $this->request->data['decision'];
			$comment  = $this->request->data['comment'];
			$by_who 	= 'CFO';
			$approver_name = $this->Auth->user()['fname']." ".$this->Auth->user()['sname'];
			$subject  = $by_who.' (CFO) approved overtime request';

			$template = "escalatedovertime";
			$reason 	= "";
			$data = $this->OvertimeRequester->find('all', [
				'contain' => ['OvertimeReason', 'OvertimeRequester', 'Overtime', 'Preovertime', 'Department', 'User'],
				'joins' => [
								[
										'table' => 'preovertimes',
										'type' => 'INNER',
										'conditions' => [
																			'preovertimes.overtime_requester_id = OvertimeRequester.id'
																		]
								],
								[
										'table' => 'overtimes',
										'type' => 'INNER',
										'conditions' => [
																			'overtimes.overtime_requester_id = OvertimeRequester.id'
																		]
								]
						],
					'conditions' => [ 'overtimes.tracker = 4' ],
					'order' => 'OvertimeRequester.id DESC',
					'group' => 'OvertimeRequester.salary_number'
			]);

			$months = date('F');

			if($decision == 1){
				//This approval is for everything
				foreach ($data as $value)
				{
						$total_hours = "";
						$weekdaytotal = 0;
						$saturday = 0;
						$sunday = 0;
						$public_holiday = 0;
						$amount = 0;

						foreach ($value['Overtime'] as $overtm) {
							$this->Overtime->id = $overtm['id'];
							$this->Overtime->saveField('tracker', 6);

							$amount += $overtm['rate'];

							if($overtm['period'] == 1)
							$weekdaytotal += $overtm['total_hours'];

							if($overtm['period'] == 2)
							$saturday     += $overtm['total_hours'];

							if($overtm['period'] == 3)
							$sunday += $overtm['total_hours'];

							if($overtm['period'] == 4)
							$public_holiday += $overtm['total_hours'];

						}
            $toputhours = 0;
						if($weekdaytotal) {
							$total_hours .= "Weekday hours ".$weekdaytotal;
							$toputhours += $weekdaytotal;
						}
						if($saturday) {
							$total_hours .= ", Saturday hours ".$saturday;
							$toputhours += $saturday;
						}
						if($sunday) {
							$total_hours .= ", Sunday hours ".$sunday;
							$toputhours += $sunday;
						}
						if($public_holiday) {
							$total_hours .= ", Public holiday ".$public_holiday;
							$toputhours += $public_holiday;
						}

						$subject = 'Overtime request has been approved by CFO - '.$by_who;

						$smsmessage = $message1 = $message = "CFO has approved ".$value['OvertimeRequester']['first_name']." ".$value['OvertimeRequester']['last_name']." (".$value['OvertimeRequester']['salary_number'].") overtime of {$toputhours} hours for August 2018. Amount approved is R{$amount}";
						//Send email notification to the next finace guy, and to the uploader of the document
						$template = 'approved';
						$subject = $subject1 = "Overtime request approved by the CFO";
						$permission = 142;
						$this->sendemailSalaries($message1, $subject1, $permission, $which = null);
						/************************** Save the reason and redirect back ********************************/
						$overtimeReason['OvertimeReason']['user_id'] = $this->Auth->user('id');
						$overtimeReason['OvertimeReason']['overtime_id'] = $overtm['id'];
						$overtimeReason['OvertimeReason']['status'] = 1;
						$overtimeReason['OvertimeReason']['level_id'] = 4;
						$overtimeReason['OvertimeReason']['reason'] = $smsmessage;

						if ($this->OvertimeReason->save($overtimeReason)) {
						} else {
							echo 2;
							debug($this->OvertimeReason->invalidFields());
						}

						$auditTrail['AuditTrail']['event_description'] = "CFO (".$this->Auth->user('fname').' '.$this->Auth->user('sname').") with id " . $this->Auth->user('id') . $reason;
						$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
						$auditTrail['AuditTrail']['contents'] = "CFO has made a decision on overtime";

						if (!$this->AuditTrail->save($auditTrail)) {
								die('There was a problem trying to save the audit trail');
						}
					//}
				}
			} else {
				foreach ($data as $value)
				{
						//$requester = $this->Overtime->OvertimeRequester->find('first', [ 'condition' => ['OvertimeRequester.id' => $value['OvertimeRequester']['id']] ]);
						$towho = $value['OvertimeRequester']['cellnumber'];
						$deptSection = $this->DepartmentSection->find('first', ['condition' => ['DepartmentSection.id' => $value['OvertimeRequester']['department_section_id']]]);

						$manager_permission = $deptSection['DepartmentSection']['permission'];
						$total_hours = "";
						$weekdaytotal = 0;
						$saturday = 0;
						$sunday = 0;
						$public_holiday = 0;
						foreach ($value['Overtime'] as $overtm) {
							$this->Overtime->id = $overtm['id'];
							$this->Overtime->saveField('tracker', 7);
							if($overtm['period'] == 1)
							$weekdaytotal += $overtm['total_hours'];

							if($overtm['period'] == 2)
							$saturday     += $overtm['total_hours'];

							if($overtm['period'] == 3)
							$sunday += $overtm['total_hours'];

							if($overtm['period'] == 4)
							$public_holiday += $overtm['total_hours'];

						}

						if($weekdaytotal) {
							$total_hours .= "Weekday hours ".$weekdaytotal;
						}
						if($saturday) {
							$total_hours .= ", Saturday hours ".$saturday;
						}
						if($sunday) {
							$total_hours .= ", Sunday hours ".$sunday;
						}
						if($public_holiday) {
							$total_hours .= ", Public holiday ".$public_holiday;
						}

						$reason = $comment;
						//Send email only to the uploader
						$template = 'declined';
						$message = 'CFO has declined your overtime for '.$total_hours.', for the month of '.date('F').'Please contact your manager';
						$message1 = 'CFO has declined your overtime for '.$total_hours.', for the month of '.date('F').'<br /> The overtime is for '.$value['OvertimeRequester']['first_name'].' '.$value['OvertimeRequester']['last_name'].' with salary number '.$value['OvertimeRequester']['salary_number'].' with the following reason: '.$reason;
						$subject = 'Overtime request declined by CFO';
						$subject1 = 'Overtime request declined by CFO';
						$reason = $smsmessage = 'CFO has declined your overtime for '.$total_hours.', for the month of '.date('F');

						$this->sendsms($smsmessage, $towho);
						$this->sendemailUploader($smsmessage, $subject, $value['OvertimeRequester']['user_id'], 1);
						$this->sendemailManager($message1, $subject1, $manager_permission, 1);
						/************************** Save the reason and redirect back ********************************/
						$overtimeReason['OvertimeReason']['user_id'] = $this->Auth->user('id');
						$overtimeReason['OvertimeReason']['overtime_id'] = 1;
						$overtimeReason['OvertimeReason']['status'] = 2;
						$overtimeReason['OvertimeReason']['level_id'] = 4;
						$overtimeReason['OvertimeReason']['reason'] = $reason;

						if ($this->OvertimeReason->save($overtimeReason)) {

						} else {
							echo 2;
								debug($this->OvertimeReason->invalidFields());
						}

						$auditTrail['AuditTrail']['event_description'] = "CFO (".$this->Auth->user('fname').' '.$this->Auth->user('sname').") with id " . $this->Auth->user('id') . $reason;
						$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
						$auditTrail['AuditTrail']['contents'] = "CFO has made a decision on overtime";

						if (!$this->AuditTrail->save($auditTrail)) {
								die('There was a problem trying to save the audit trail');
						}
					}
			}

			echo 1;
}

public function escalatedirector($id = null, $tracker = null) {
		$this->autoRender = false;
		$this->loadModel('AuditTrail');
		$this->loadModel('User');
		$this->loadModel('OvertimeReason');
		$this->loadModel('DepartmentSection');
		$this->loadModel('OvertimeRequester');

		$department_id = $this->request->data['id'];
		$decision = $this->request->data['decision'];
		$comment  = $this->request->data['comment'];

		$by_who 	= 'CFO';
		$approver_name = $this->Auth->user()['fname']." ".$this->Auth->user()['sname'];
		$subject  = $by_who.' (CFO) approved overtime request';
		$template = "escalatedovertime";
		$reason 	= "";
		$data = $this->OvertimeRequester->find('all', [
			'contain' => ['OvertimeReason', 'OvertimeRequester', 'Overtime', 'Preovertime', 'Department', 'User'],
			'joins' => [
							[
									'table' => 'preovertimes',
									'type' => 'INNER',
									'conditions' => [
																		'preovertimes.overtime_requester_id = OvertimeRequester.id'
																	]
							],
							[
									'table' => 'overtimes',
									'type' => 'INNER',
									'conditions' => [
																		'overtimes.overtime_requester_id = OvertimeRequester.id'
																	]
							]
					],
				'conditions' => [ 'overtimes.tracker = 4', 'OvertimeRequester.department_id' => $department_id ],
				'order' => 'OvertimeRequester.id DESC',
				'group' => 'OvertimeRequester.salary_number'
		]);
		$decision = 2;
		$months = date('F');
		if($decision == 1){
			//This approval is for everything
			foreach ($data as $value)
			{
				$total_hours = 0;
				$total_hours = "";
				$weekdaytotal = 0;
				$saturday = 0;
				$sunday = 0;
				$public_holiday = 0;
				$amount = 0;

				foreach ($value['Overtime'] as $overtm) {
					$this->Overtime->id = $overtm['id'];
					$this->Overtime->saveField('tracker', 6);

					$amount += $overtm['rate'];

					if($overtm['period'] == 1)
					$weekdaytotal += $overtm['total_hours'];

					if($overtm['period'] == 2)
					$saturday     += $overtm['total_hours'];

					if($overtm['period'] == 3)
					$sunday += $overtm['total_hours'];

					if($overtm['period'] == 4)
					$public_holiday += $overtm['total_hours'];

				}
				$toputhours = 0;
				if($weekdaytotal) {
					$total_hours .= "Weekday hours ".$weekdaytotal;
					$toputhours += $weekdaytotal;
				}
				if($saturday) {
					$total_hours .= ", Saturday hours ".$saturday;
					$toputhours += $saturday;
				}
				if($sunday) {
					$total_hours .= ", Sunday hours ".$sunday;
					$toputhours += $sunday;
				}
				if($public_holiday) {
					$total_hours .= ", Public holiday ".$public_holiday;
					$toputhours += $public_holiday;
				}

				$subject = 'Overtime request has been approved by CFO - '.$by_who;

				$smsmessage = $message1 = $message = "CFO has approved ".$value['OvertimeRequester']['first_name']." ".$value['OvertimeRequester']['last_name']." (".$value['OvertimeRequester']['salary_number'].") overtime of {$toputhours} hours for August 2018. Amount approved is R{$amount}";

					$template = 'approved';
					$subject = $subject1 = "Overtime request approved by the CFO";
					$permission = 142;
					$this->sendemailSalaries($message1, $subject1, $permission, $which = null);
					/************************** Save the reason and redirect back ********************************/
					$overtimeReason['OvertimeReason']['user_id'] = $this->Auth->user('id');
					$overtimeReason['OvertimeReason']['overtime_id'] = $overtm['id'];
					$overtimeReason['OvertimeReason']['status'] = 1;
					$overtimeReason['OvertimeReason']['level_id'] = 4;
					$overtimeReason['OvertimeReason']['reason'] = $smsmessage;

					if ($this->OvertimeReason->save($overtimeReason)) {
					} else {
						echo 2;
						debug($this->OvertimeReason->invalidFields());
					}

					$auditTrail['AuditTrail']['event_description'] = "CFO (".$this->Auth->user('fname').' '.$this->Auth->user('sname').") with id " . $this->Auth->user('id') . $reason;
					$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
					$auditTrail['AuditTrail']['contents'] = "CFO has made a decision on overtime";

					if (!$this->AuditTrail->save($auditTrail)) {
							die('There was a problem trying to save the audit trail');
					}
			}
		} else {
			foreach ($data as $value)
			{
					$towho = $value['OvertimeRequester']['cellnumber'];
					$deptSection = $this->DepartmentSection->find('first', ['condition' => ['DepartmentSection.id' => $value['OvertimeRequester']['department_section_id']]]);

					$manager_permission = $deptSection['DepartmentSection']['permission'];
					$total_hours = "";
					foreach ($value['Overtime'] as $overtm) {
						$this->Overtime->id = $overtm['id'];
						$this->Overtime->saveField('tracker', 7);

						if($overtm['period'] == 1)
						$weekdaytotal += $overtm['total_hours'];

						if($overtm['period'] == 2)
						$saturday     += $overtm['total_hours'];

						if($overtm['period'] == 3)
						$sunday += $overtm['total_hours'];

						if($overtm['period'] == 4)
						$public_holiday += $overtm['total_hours'];

					}

					if($weekdaytotal) {
						$total_hours .= "Weekday hours ".$weekdaytotal;
					}
					if($saturday) {
						$total_hours .= ", Saturday hours ".$saturday;
					}
					if($sunday) {
						$total_hours .= ", Sunday hours ".$sunday;
					}
					if($public_holiday) {
						$total_hours .= ", Public holiday ".$public_holiday;
					}

					$reason = $comment;
					//Send email only to the uploader
					$template = 'declined';
					$message = 'CFO has declined your overtime for '.$total_hours.', for the month of '.date('F').'Please contact your manager';
					$message1 = 'CFO has declined your overtime for '.$total_hours.', for the month of '.date('F').'<br /> The overtime is for '.$requester['OvertimeRequester']['first_name'].' '.$requester['OvertimeRequester']['last_name'].' with salary number '.$requester['OvertimeRequester']['salary_number'].' with the following reason: '.$reason;
					$subject = 'Overtime request declined by CFO';
					$subject1 = 'Overtime request declined by CFO';
					$reason = $smsmessage = 'CFO has declined your overtime for '.$total_hours.' hours, for the month of '.date('F').'Please contact your manager';

					$this->sendsms($smsmessage, $towho);
					$this->sendemailUploader($smsmessage, $subject, $requester['OvertimeRequester']['user_id'], 1);
					$this->sendemailManager($message1, $subject1, $manager_permission, 1);
					/************************** Save the reason and redirect back ********************************/
					$overtimeReason['OvertimeReason']['user_id'] = $this->Auth->user('id');
					$overtimeReason['OvertimeReason']['overtime_id'] = $requester['OvertimeRequester']['id'];
					$overtimeReason['OvertimeReason']['status'] = 2;
					$overtimeReason['OvertimeReason']['level_id'] = 4;
					$overtimeReason['OvertimeReason']['reason'] = $reason;

					if ($this->OvertimeReason->save($overtimeReason)) {

					} else {
						echo 2;
							debug($this->OvertimeReason->invalidFields());
					}

					$auditTrail['AuditTrail']['event_description'] = "CFO (".$this->Auth->user('fname').' '.$this->Auth->user('sname').") with id " . $this->Auth->user('id') . $reason;
					$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
					$auditTrail['AuditTrail']['contents'] = "CFO has made a decision on overtime";

					if (!$this->AuditTrail->save($auditTrail)) {
							die('There was a problem trying to save the audit trail');
					}
				}
		}

		echo 1;
}


public function escalatesingle($id = null, $tracker = null) {
		$this->autoRender = false;
		$this->loadModel('AuditTrail');
		$this->loadModel('User');
		$this->loadModel('OvertimeReason');
		$this->loadModel('DepartmentSection');
		$this->loadModel('OvertimeRequester');
		$overtime_id = $this->request->data['id'];
		$decision = $this->request->data['decision'];
		$comment  = $this->request->data['comment'];
		//$department_id = 1;
		//$decision = 1;
		$by_who 	= 'CFO';
		$approver_name = $this->Auth->user()['fname']." ".$this->Auth->user()['sname'];
		$subject  = $by_who.' (CFO) approved overtime request';
		$template = "escalatedovertime";
		$reason 	= "";
		$decision = 2;
		$overtime_id = 18;
		$data = $this->OvertimeRequester->find('all', [
			'contain' => ['OvertimeReason', 'OvertimeRequester', 'Overtime', 'Preovertime', 'Department', 'User'],
			'joins' => [
							[
									'table' => 'preovertimes',
									'type' => 'INNER',
									'conditions' => [
																		'preovertimes.overtime_requester_id = OvertimeRequester.id'
																	]
							],
							[
									'table' => 'overtimes',
									'type' => 'INNER',
									'conditions' => [
																		'overtimes.overtime_requester_id = OvertimeRequester.id'
																	]
							]
					],
				'conditions' => [ 'overtimes.tracker = 4', 'overtimes.id' => $overtime_id ],
				'order' => 'OvertimeRequester.id DESC',
				'group' => 'OvertimeRequester.salary_number'
		]);


		$months = date('F');
		if($decision == 1){
			//This approval is for everything
			foreach ($data as $value)
			{
				$total_hours = 0;
				$total_hours = "";
				$weekdaytotal = 0;
				$saturday = 0;
				$sunday = 0;
				$public_holiday = 0;
				$amount = 0;

				foreach ($value['Overtime'] as $overtm) {
					$this->Overtime->id = $overtm['id'];
					$this->Overtime->saveField('tracker', 6);

					$amount += $overtm['rate'];

					if($overtm['period'] == 1)
					$weekdaytotal += $overtm['total_hours'];

					if($overtm['period'] == 2)
					$saturday     += $overtm['total_hours'];

					if($overtm['period'] == 3)
					$sunday += $overtm['total_hours'];

					if($overtm['period'] == 4)
					$public_holiday += $overtm['total_hours'];

				}

				$toputhours = 0;
				if($weekdaytotal) {
					$total_hours .= "Weekday hours ".$weekdaytotal;
					$toputhours += $weekdaytotal;
				}
				if($saturday) {
					$total_hours .= ", Saturday hours ".$saturday;
					$toputhours += $saturday;
				}
				if($sunday) {
					$total_hours .= ", Sunday hours ".$sunday;
					$toputhours += $sunday;
				}
				if($public_holiday) {
					$total_hours .= ", Public holiday ".$public_holiday;
					$toputhours += $public_holiday;
				}

				$subject = 'Overtime request has been approved by CFO - '.$by_who;

				$smsmessage = $message1 = $message = "CFO has approved ".$value['OvertimeRequester']['first_name']." ".$value['OvertimeRequester']['last_name']." (".$value['OvertimeRequester']['salary_number'].") overtime of {$toputhours} hours for August 2018. Amount approved is R{$amount}";

					$template = 'approved';
					$subject = $subject1 = "Overtime request approved by the CFO";

					$permission = 142;
					$this->sendemailSalaries($message1, $subject1, $permission, $which = null);
					/************************** Save the reason and redirect back ********************************/
					$overtimeReason['OvertimeReason']['user_id'] = $this->Auth->user('id');
					$overtimeReason['OvertimeReason']['overtime_id'] = $overtm['id'];
					$overtimeReason['OvertimeReason']['status'] = 1;
					$overtimeReason['OvertimeReason']['level_id'] = 4;
					$overtimeReason['OvertimeReason']['reason'] = $smsmessage;

					if ($this->OvertimeReason->save($overtimeReason)) {
					} else {
						echo 2;
						debug($this->OvertimeReason->invalidFields());
					}

					$auditTrail['AuditTrail']['event_description'] = "CFO (".$this->Auth->user('fname').' '.$this->Auth->user('sname').") with id " . $this->Auth->user('id') . $reason;
					$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
					$auditTrail['AuditTrail']['contents'] = "CFO has made a decision on overtime";

					if (!$this->AuditTrail->save($auditTrail)) {
							die('There was a problem trying to save the audit trail');
					}
				}
	} else {
			foreach ($data as $value)
			{

					//$requester = $this->Overtime->OvertimeRequester->find('first', [ 'condition' => ['OvertimeRequester.id' => $value['OvertimeRequester']['id']] ]);
					$towho = $value['OvertimeRequester']['cellnumber'];
					$deptSection = $this->DepartmentSection->find('first', ['condition' => ['DepartmentSection.id' => $value['OvertimeRequester']['department_section_id']]]);

					$manager_permission = $deptSection['DepartmentSection']['permission'];

					$total_hours = 0;
					foreach ($value['Overtime'] as $overtm) {
						$this->Overtime->id = $overtm['id'];
						//$this->Overtime->saveField('tracker', 7);
						$total_hours += $overtm['total_hours'];
					}
					$reason = $comment;
					//Send email only to the uploader
					$template = 'declined';
					$message = 'CFO has declined your overtime for '.$total_hours.' hours, for the month of '.date('F').'Please contact your manager';
					$message1 = 'CFO has declined your overtime for '.$total_hours.' hours, for the month of '.date('F').'<br /> The overtime is for '.$value['OvertimeRequester']['first_name'].' '.$value['OvertimeRequester']['last_name'].' with salary number '.$value['OvertimeRequester']['salary_number'].', with the following reason '.$reason;
					$subject = 'Overtime request declined by CFO';
					$subject1 = 'Overtime request declined by CFO';
					$reason = $smsmessage = 'CFO has declined your overtime for '.$total_hours.' hours, for the month of '.date('F').'Please contact your manager';

					$this->sendsms($smsmessage, $towho);
					$this->sendemailUploader($smsmessage, $subject, $value['OvertimeRequester']['user_id'], 1);
					$this->sendemailManager($message1, $subject1, $manager_permission, 1); die;
					/************************** Save the reason and redirect back ********************************/
					$overtimeReason['OvertimeReason']['user_id'] = $this->Auth->user('id');
					$overtimeReason['OvertimeReason']['overtime_id'] = $value['OvertimeRequester']['id'];
					$overtimeReason['OvertimeReason']['status'] = 2;
					$overtimeReason['OvertimeReason']['level_id'] = 4;
					$overtimeReason['OvertimeReason']['reason'] = $reason;

					if ($this->OvertimeReason->save($overtimeReason)) {

					} else {
						echo 2;
							debug($this->OvertimeReason->invalidFields());
					}

					$auditTrail['AuditTrail']['event_description'] = "CFO (".$this->Auth->user('fname').' '.$this->Auth->user('sname').") with id " . $this->Auth->user('id') . $reason;
					$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
					$auditTrail['AuditTrail']['contents'] = "CFO has made a decision on overtime";

					if (!$this->AuditTrail->save($auditTrail)) {
							die('There was a problem trying to save the audit trail');
					}
				}
		}

		echo 1;
}

public function escalatedeptsec($id = null, $tracker = null) {
		$this->autoRender = false;
		$this->loadModel('AuditTrail');
		$this->loadModel('User');
		$this->loadModel('OvertimeReason');
		$this->loadModel('DepartmentSection');
		$this->loadModel('OvertimeRequester');
		$department_section_id = $this->request->data['id'];
		$decision = $this->request->data['decision'];
		$comment  = $this->request->data['comment'];

		$by_who 	= 'CFO';
		$approver_name = $this->Auth->user()['fname']." ".$this->Auth->user()['sname'];
		$subject  = $by_who.' (CFO) approved overtime request';
		$template = "escalatedovertime";
		$reason 	= "";
		$data = $this->OvertimeRequester->find('all', [
			'contain' => ['OvertimeReason', 'OvertimeRequester', 'Overtime', 'Preovertime', 'Department', 'User'],
			'joins' => [
							[
									'table' => 'preovertimes',
									'type' => 'INNER',
									'conditions' => [
																		'preovertimes.overtime_requester_id = OvertimeRequester.id'
																	]
							],
							[
									'table' => 'overtimes',
									'type' => 'INNER',
									'conditions' => [
																		'overtimes.overtime_requester_id = OvertimeRequester.id'
																	]
							]
					],
				'conditions' => [ 'overtimes.tracker = 4', 'OvertimeRequester.department_section_id' => $department_section_id ],
				'order' => 'OvertimeRequester.id DESC',
				'group' => 'OvertimeRequester.salary_number'
		]);

		$months = date('F');
		if($decision == 1){
			//This approval is for everything
			foreach ($data as $value)
			{
					$total_hours = 0;
					$total_hours = "";
					$weekdaytotal = 0;
					$saturday = 0;
					$sunday = 0;
					$public_holiday = 0;
					$amount = 0;

					foreach ($value['Overtime'] as $overtm) {
						$this->Overtime->id = $overtm['id'];
						$this->Overtime->saveField('tracker', 6);

						$amount += $overtm['rate'];

						if($overtm['period'] == 1)
						$weekdaytotal += $overtm['total_hours'];

						if($overtm['period'] == 2)
						$saturday     += $overtm['total_hours'];

						if($overtm['period'] == 3)
						$sunday += $overtm['total_hours'];

						if($overtm['period'] == 4)
						$public_holiday += $overtm['total_hours'];

					}
					$toputhours = 0;
					if($weekdaytotal) {
						$total_hours .= "Weekday hours ".$weekdaytotal;
						$toputhours += $weekdaytotal;
					}
					if($saturday) {
						$total_hours .= ", Saturday hours ".$saturday;
						$toputhours += $saturday;
					}
					if($sunday) {
						$total_hours .= ", Sunday hours ".$sunday;
						$toputhours += $sunday;
					}
					if($public_holiday) {
						$total_hours .= ", Public holiday ".$public_holiday;
						$toputhours += $public_holiday;
					}

					$subject = 'Overtime request has been approved by CFO - '.$by_who;

					$smsmessage = $message1 = $message = "CFO has approved ".$value['OvertimeRequester']['first_name']." ".$value['OvertimeRequester']['last_name']." (".$value['OvertimeRequester']['salary_number'].") overtime of {$toputhours} hours for August 2018. Amount approved is R{$amount}";

					$template = 'approved';
					$subject = $subject1 = "Overtime request approved by the CFO";
					$permission = 142;
					$this->sendemailSalaries($message1, $subject1, $permission, $which = null);
					/************************** Save the reason and redirect back ********************************/
					$overtimeReason['OvertimeReason']['user_id'] = $this->Auth->user('id');
					$overtimeReason['OvertimeReason']['overtime_id'] = 1;
					$overtimeReason['OvertimeReason']['status'] = 1;
					$overtimeReason['OvertimeReason']['level_id'] = 4;
					$overtimeReason['OvertimeReason']['reason'] = $smsmessage;

					if ($this->OvertimeReason->save($overtimeReason)) {
					} else {
						echo 2;
						debug($this->OvertimeReason->invalidFields());
					}

					$auditTrail['AuditTrail']['event_description'] = "CFO (".$this->Auth->user('fname').' '.$this->Auth->user('sname').") with id " . $this->Auth->user('id') . $reason;
					$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
					$auditTrail['AuditTrail']['contents'] = "CFO has made a decision on overtime";

					if (!$this->AuditTrail->save($auditTrail)) {
							die('There was a problem trying to save the audit trail');
					}
			}
		} else {
			foreach ($data as $value)
			{
					$towho = $value['OvertimeRequester']['cellnumber'];
					$deptSection = $this->DepartmentSection->find('first', ['condition' => ['DepartmentSection.id' => $value['OvertimeRequester']['department_section_id']]]);

					$manager_permission = $deptSection['DepartmentSection']['permission'];
					$total_hours = 0;
					$total_hours = "";
					$weekdaytotal = 0;
					$saturday = 0;
					$sunday = 0;
					$public_holiday = 0;
					foreach ($value['Overtime'] as $overtm) {
						$this->Overtime->id = $overtm['id'];
						$this->Overtime->saveField('tracker', 7);
						if($overtm['period'] == 1)
						$weekdaytotal += $overtm['total_hours'];

						if($overtm['period'] == 2)
						$saturday     += $overtm['total_hours'];

						if($overtm['period'] == 3)
						$sunday += $overtm['total_hours'];

						if($overtm['period'] == 4)
						$public_holiday += $overtm['total_hours'];

					}

					if($weekdaytotal) {
						$total_hours .= "Weekday hours ".$weekdaytotal;
					}
					if($saturday) {
						$total_hours .= ", Saturday hours ".$saturday;
					}
					if($sunday) {
						$total_hours .= ", Sunday hours ".$sunday;
					}
					if($public_holiday) {
						$total_hours .= ", Public holiday ".$public_holiday;
					}

					$reason = $comment;
					//Send email only to the uploader
					$template = 'declined';
					$message = 'CFO has declined your overtime for '.$total_hours.', for the month of '.date('F').'Please contact your manager';
					$message1 = 'CFO has declined your overtime for '.$total_hours.', for the month of '.date('F').' <br /> The overtime is for '.$value['OvertimeRequester']['first_name'].' '.$value['OvertimeRequester']['last_name'].' with salary number '.$value['OvertimeRequester']['salary_number'].' with the following reason: '.$reason;
					$subject = 'Overtime request declined by CFO';
					$subject1 = 'Overtime request declined by CFO';
					$reason = $smsmessage = 'CFO has declined your overtime for '.$total_hours.', for the month of '.date('F');

					$this->sendsms($smsmessage, $towho);
					$this->sendemailUploader($smsmessage, $subject, $requester['OvertimeRequester']['user_id'], 1);
					$this->sendemailManager($message1, $subject1, $manager_permission, 1);
					/************************** Save the reason and redirect back ********************************/
					$overtimeReason['OvertimeReason']['user_id'] = $this->Auth->user('id');
					$overtimeReason['OvertimeReason']['overtime_id'] = $value['OvertimeRequester']['id'];
					$overtimeReason['OvertimeReason']['status'] = 2;
					$overtimeReason['OvertimeReason']['level_id'] = 4;
					$overtimeReason['OvertimeReason']['reason'] = $reason;

					if ($this->OvertimeReason->save($overtimeReason)) {

					} else {
						echo 2;
							debug($this->OvertimeReason->invalidFields());
					}

					$auditTrail['AuditTrail']['event_description'] = "CFO (".$this->Auth->user('fname').' '.$this->Auth->user('sname').") with id " . $this->Auth->user('id') . $reason;
					$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
					$auditTrail['AuditTrail']['contents'] = "CFO has made a decision on overtime";

					if (!$this->AuditTrail->save($auditTrail)) {
							die('There was a problem trying to save the audit trail');
					}
				}
		}

		echo 1;
}


function sendemailSalaries($message, $subject, $permission, $which = null)
{
		$this->autoRender = false;
		$Email = new CakeEmail();

		$this->loadModel('User');
		$users = $this->User->find('all');
		foreach ($users as $user) {
				if (in_array($permission, unserialize($user['User']['permissions'])))
				{
						$Email->from(array('no-reply@matjhabeng.co.za' => 'Matjhabeng Local Municipality Document Management System'))
								->template('approved', 'default')
								->emailFormat('html')
								->viewVars(array('message' => $message, 'by_who' => 'CFO', 'escalated' => $escalated))
								->to(trim($user['User']['email']))
								//->to('mapaepae@gmail.com')
								->bcc('maffins@gmail.com')
								->subject($subject)
								->send();
				}
			}
}


function sendemailManager($message, $subject, $permission, $which = null)
{
		$this->autoRender = false;
		$Email = new CakeEmail();

		$this->loadModel('User');
		$users = $this->User->find('all');
		foreach ($users as $user) {
				if (in_array($permission, unserialize($user['User']['permissions'])))
				{
						$Email->from(array('no-reply@matjhabeng.co.za' => 'Matjhabeng Local Municipality Document Management System'))
								->template('declinedovertime', 'default')
								->emailFormat('html')
								->viewVars(array('message' => $message, 'by_who' => 'CFO', 'escalated' => $escalated))
								->to(trim($user['User']['email']))
								//->to('mapaepae@gmail.com')
								->bcc('maffins@gmail.com')
								->subject($subject)
								->send();
				}
			}
}

function sendemailUploader($message, $subject, $user_id, $which = null)
{
		$this->autoRender = false;
		$Email = new CakeEmail();

		$this->loadModel('User');
		$options = array('conditions' => array('User.id' => $user_id));
		$user = $this->User->find('first', $options);

		$Email->from(array('no-reply@matjhabeng.co.za' => 'Matjhabeng Local Municipality Document Management System'))
				->template('declinedovertime', 'default')
				->emailFormat('html')
				->viewVars(array('message' => $message, 'what' => $which))
				->to(trim($user['User']['email']))
				//->to('mapaepae@gmail.com')
				->bcc('maffins@gmail.com')
				->subject($subject)
				->send();
}

	public function finalclose() {

			$this->autoRender = false;

			$id = $this->request->data['id'];

			$this->Overtime->id = $id;
			$this->Overtime->saveField('archived', 1); //1 the document has been archived

			//Save the audit trail
			$this->loadModel('AuditTrail');

			$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
			$auditTrail['AuditTrail']['contents'] = "Overtime archived by the requester";
			$auditTrail['AuditTrail']['event_description'] = "User ".$this->Auth->user('id')." and name ".$this->Auth->user('fname')." is has archived the document with id ".$id;

			if (!$this->AuditTrail->save($auditTrail)) {
					die('There was a problem trying to save the audit trail');
			}

			echo 1;
	}

	public function salariesprocessed() {

			$this->autoRender = false;

			$id = $this->request->data['id'];

			$this->Overtime->id = $id;
			$this->Overtime->saveField('tracker', 5); //1 the document has been archived

			//Save the audit trail
			$this->loadModel('AuditTrail');

			$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
			$auditTrail['AuditTrail']['contents'] = "Overtime processed in the salaries department";
			$auditTrail['AuditTrail']['event_description'] = "User ".$this->Auth->user('id')." and name ".$this->Auth->user('fname')." has processed the overtime requested in the salaries department with id ".$id;

			if (!$this->AuditTrail->save($auditTrail)) {
					die('There was a problem trying to save the audit trail');
			}

			echo 1;
	}

public function directoratebreakdown($department_id) {

		$this->loadModel('Department');
		$department = $this->Department->find('first', ['conditions' => ['Department.id' => $department_id]]);

		foreach ($department['DepartmentSection'] as $value) {
			//Get the totals for that department
			$this->loadModel('OvertimeRequester');
			$data = $this->OvertimeRequester->find('all', [
				'contain' => ['OvertimeReason', 'OvertimeRequester', 'Overtime', 'Preovertime', 'Department', 'User'],
				'joins' => [
								[
										'table' => 'preovertimes',
										'type' => 'INNER',
										'conditions' => [
																			'preovertimes.overtime_requester_id = OvertimeRequester.id'
																		]
								],
								[
										'table' => 'overtimes',
										'type' => 'INNER',
										'conditions' => [
																			'overtimes.overtime_requester_id = OvertimeRequester.id'
																		]
								]
						],
					'conditions' => [ 'overtimes.tracker in (4,6,7)', 'OvertimeRequester.department_section_id' => $value['id'] ],
					'order' => 'OvertimeRequester.id DESC',
					'group' => 'OvertimeRequester.salary_number'
			]);//i must incorporate the month

			$total_hours = 0;
			$total_amoint = 0;
			foreach ($data as $valuee) {
				foreach ($valuee['Overtime'] as $Kvalue) {
					$total_hours 	+= $Kvalue['total_hours'];
					$total_amoint += $Kvalue['rate'];
					$trackers = $Kvalue['tracker'];
				}
			}

			$thisdepartments[$value['id']] = [$value['name'], $total_hours, $total_amoint, $trackers] ;
		}
		$this->set('departmentname', $department['Department']['name']);
		$this->set('departmentsections', $thisdepartments);
		if(in_array(113, unserialize($this->Auth->user()['permissions']))) {
			$this->set('mm', 1);
		} else {
			$this->set('mm', 0);
		}
	}

}
