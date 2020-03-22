<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Preovertimes Controller
 *
 * @property Preovertime $Preovertime
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class PreovertimesController extends AppController {

	public $manager_approvers  = ['6' => 146, '1' => 147, '2' => 161, '5' => 148, '13' => 149, '3' => 150, '7' => 151, '8' => 152, '9' => 153 ];
	//This is for the permissions now
	public $director_approvers = ['6' => 116, '1' => 119, '2' => 160, '5' => 122, '13' => 125, '3' => 128, '7' => 131, '68' => 134, '9' => 137 ];
	public $period = ['' => '- Select -', 1 => 'Weekday', 2 => 'Saturday', 3 => 'Sunday', 4 => 'Public Holiday'];

	public $allControllers = ['0' => 'INFRASTRUCTURE', '1' => 'CORPORATE SUPPORT SERVICES', '2' => 'COMMUNITY SERVICES', '3' => 'LED', '4' => 'FINANCE',
												 '5' => 'STRATEGIC SUPPORT SERVICES', '6' => "MAYOR'S OFFICE", '7' => "SPEAKER'S OFFICE"];
	public $months = [ "0" => '- Select Month -',
										"1" => "January", "2" => "February", "3" => "March", "4" => "April",
										"5" => "May", "6" => "June", "7" => "July", "8" => "August",
										"9" => "September", "10" => "October", "11" => "November", "12" => "December",
								];

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
	public function index($id, $approver=null) {

		$data = $this->Preovertime->find('all', array(
				'contain' => array('OvertimeRequester'),
				'conditions' => ["Preovertime.overtime_requester_id " => $id, 'Preovertime.overtime_inprocess <> 1' ],
				'order' => 'Preovertime.id DESC'
		));

		$option = ['0' => '- Choose -', '1' => 'Yes', '2' => 'No'];
		$this->set('id', $id);
		$this->set('option', $option);
		$month_names = ["- Choose Month -", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		$arry = array_flip($month_names);
		$month_nams[$arry[date('F', strtotime('+1 month'))]] = date('F', strtotime('+1 month'));
		$this->set('months', $month_nams);

		$this->loadModel('OvertimeRequester'); //or you can load it in beforeFilter()
    $requester = $this->OvertimeRequester->query("SELECT * FROM overtime_requesters where id = $id");
		$requester = $requester[0];
    $this->set('requester', $requester);
		$this->set('preovertimes', $data);
		$this->set('approver', $approver);
	}

 public function report($who = null) {
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

		if(!$comma_separated) { $comma_separated = 0; }

		if($who != 4 && $who != 2)
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
			$condition = 'OvertimeRequester.department_section_id IN ('.$comma_sep_secti.') AND Preovertime.tracker NOT IN (0, 1)';

		}

		if($who == 2) {
			$directorsarr = array_intersect($this->director_approvers, unserialize($this->Auth->user()['permissions']));

			$thekey = key($directorsarr);
			$theedepartmetn = $this->Department->find('first',[
									'contain' => array('DepartmentSection'),
									'conditions' => ['Department.id' => $thekey ],
									'order' => 'Department.id DESC'
							]);

			$sec[] = [' - Select Unit - '];
			foreach($theedepartmetn['DepartmentSection'] as $sects) {
				$sec[$sects['id']] = $sects['name'];
			}
			$this->set('maindetails', $theedepartmetn);
			$this->set('sectins', $sec);
			$condition = 'OvertimeRequester.department_id IN ('.$thekey.') AND Preovertime.tracker NOT IN (0, 1)';
		}

	 if ($this->request->is('post')) {

 		 if($this->request->data['Preovertime']['employee']) {
 			 $condition1 = 'OvertimeRequester.id = '.$this->request->data['Overtime']['employee'];
 		 }
 		 if($this->request->data['Preovertime']['department_id']) {
 				$condition3 = 'OvertimeRequester.department_id = '.$this->request->data['Overtime']['department_id'];
 		}
		 if($this->request->data['Preovertime']['salary_number']) {
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
		$data = $this->Preovertime->find('all', [
			'contain' => ['OvertimeRequester', 'DepartmentSection', 'Department'],
			 'joins' => [
				 [
						 'table' => 'department_sections',
						 'type' => 'INNER',
						 'conditions' => [
								 'OvertimeRequester.department_id = department_sections.department_id '
						 ]
				 ]
			 ],
				'conditions' => [$condition],
				'order' => 'OvertimeRequester.id DESC',
				'group' => 'Preovertime.id'
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


	 public function mgrsummary()
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

			if(!$comma_separated) { $comma_separated = 0; }

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

	    $condition = " department_sections.id IN ($comma_sep_secti) ";

			$this->set('maindetails', $theedepartmetn);
			$this->set('deparsections', $all_depts_secti);

		 if ($this->request->is('post')) {

	 		 if($this->request->data['Preovertime']['employee']) {
	 			 $condition1 = 'OvertimeRequester.id = '.$this->request->data['Overtime']['employee'];
	 		 }
	 		 if($this->request->data['Preovertime']['department_id']) {
	 			$condition3 = 'OvertimeRequester.department_id = '.$this->request->data['Overtime']['department_id'];
	 			}
			 if($this->request->data['Preovertime']['salary_number']) {
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
			$data = $this->Preovertime->find('all', [
				'contain' => ['OvertimeRequester', 'DepartmentSection', 'Department'],
				 'joins' => [
					 [
							 'table' => 'department_sections',
							 'type' => 'INNER',
							 'conditions' => [
									 'OvertimeRequester.department_id = department_sections.department_id '
							 ]
					 ]
				 ],
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
			$depts = [' - Select Department - '];
			foreach ($departments as $value) {
				$depts[$value['Department']['id']] = $value['Department']['name'];
			}
	    $this->set('depts', $depts);
	    $this->set('requester', $requester);
	 		$this->set('preovertimes', $data);
	 		$this->set('period', $this->period);
	 		$this->set('months', $this->months);
	 	}


 public function directorreport($who) {

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
								'conditions' => ["Department.id IN ({$comma_separated})" ],
								'order' => 'Department.id DESC'
						));
		$this->set('maindetails', $theedepartmetn);

		$this->loadModel('OvertimeRequester');
		$theovertimereq = $this->OvertimeRequester->find('all', array(
								'conditions' => ["OvertimeRequester.department_id IN ({$comma_separated})" ]
						));

		$marekwesta = [];

		 foreach ($theovertimereq as $value) {
			 $marekwesta[] = $value['OvertimeRequester']['id'];
		 }
		$rikwestaid = implode(",", $marekwesta);

		if($who == 2) {
			$directorsarr = array_intersect($this->director_approvers, unserialize($this->Auth->user()['permissions']));
			$thekey = key($directorsarr);
			$theedepartmetn = $this->Department->find('first',[
									'contain' => array('DepartmentSection'),
									'conditions' => ['Department.id' => $thekey ],
									'order' => 'Department.id DESC'
							]);

			$sec[] = [' - Select Unit - '];
			foreach($theedepartmetn['DepartmentSection'] as $sects) {
				$sec[$sects['id']] = $sects['name'];
			}
			$this->set('sectins', $sec);
		}

		$this->set('who', $who);

	 $condition = "OvertimeRequester.department_id IN ({$comma_separated}) AND Preovertime.tracker NOT IN (0,1,2)";

	if ($this->request->is('post')) {

		if($this->request->data['Preovertime']['employee']) {
			$condition1 = 'OvertimeRequester.id = '.$this->request->data['Preovertime']['employee'];
		}
		if($this->request->data['Preovertime']['department_id']) {
		 $condition3 = 'OvertimeRequester.department_id = '.$this->request->data['Preovertime']['department_id'];
		 }
			if($this->request->data['Preovertime']['employee']) {
				$condition5 = 'OvertimeRequester.id = '.$this->request->data['Preovertime']['employee'];
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
	}

	 //Add an extra layer now of sections
	  $data = $this->Preovertime->find('all', [
		 	 'conditions' => [$condition],
			 'order' => 'OvertimeRequester.id DESC',
			 'group' => 'Preovertime.id'
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
	 $depts = [' - Select Department - '];
	 foreach ($departments as $value) {
		 $depts[$value['Department']['id']] = $value['Department']['name'];
	 }
	 $this->set('depts', $depts);
	 $this->set('requester', $requester);
	 $this->set('preovertimes', $data);
	 $this->set('period', $this->period);
	 $this->set('months', $this->months);

 	}

 public function summaryreport() {
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
 									'conditions' => ["Department.id IN ({$comma_separated})" ],
 									'order' => 'Department.id DESC'
 							));
 			$this->set('maindetails', $theedepartmetn);

 		$condition = '';

 		if ($this->request->is('post')) {

 			if($this->request->data['Preovertime']['employee']) {
 				$condition1 = 'OvertimeRequester.id = '.$this->request->data['Preovertime']['employee'];
 			}
 			if($this->request->data['Preovertime']['department_id']) {
 			 $condition3 = 'OvertimeRequester.department_id = '.$this->request->data['Preovertime']['department_id'];
 			 }
 				if($this->request->data['Preovertime']['employee']) {
 					$condition5 = 'OvertimeRequester.id = '.$this->request->data['Preovertime']['employee'];
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
 		}

 		 //Add an extra layer now of sections
 		  $data = $this->Preovertime->find('all', [
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
 		 $depts = [' - Select Department - '];
 		 foreach ($departments as $value) {
 			 $depts[$value['Department']['id']] = $value['Department']['name'];
 		 }
 		 $this->set('depts', $depts);
 		 $this->set('requester', $requester);
 		 $this->set('preovertimes', $data);
 		 $this->set('period', $this->period);
 		 $this->set('months', $this->months);
	 }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null, $requester_id = null) {
		if (!$this->Preovertime->exists($id)) {
			throw new NotFoundException(__('Invalid preovertime'));
		}
		$options = array('conditions' => array('Preovertime.' . $this->Preovertime->primaryKey => $id));
		$this->set('preovertime', $this->Preovertime->find('first', $options));
		$this->set('requester_id', $requester_id);
	}


 public function sendPreovertime($Overtime_requester_id = null)
	{
		$this->autoRender = false;
	  if (!$Overtime_requester_id) {
	    throw new NotFoundException(__('Overtime Requester id missing'));
	  }

	  $this->Preovertime->updateAll(
	      ['Preovertime.tracker' => 1],
	      ['Preovertime.overtime_requester_id' => $Overtime_requester_id]
	  );
		$requester_id = $Overtime_requester_id;

		//Now email the manager
		$this->loadModel('OvertimeRequester');
		$options = array('conditions' => array('OvertimeRequester.' . $this->OvertimeRequester->primaryKey => $requester_id));
		$requester = $this->OvertimeRequester->find('first', $options);

		//Get all the manager_approvers
		$this->loadModel('DepartmentSection');
		$allpermsdepartment = $this->DepartmentSection->find('all');
		$thismanager_approvers = [];
		foreach ($allpermsdepartment as $value) {
			$thismanager_approvers[$value['DepartmentSection']['id']] = $value['DepartmentSection']['permission'];
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

		$permission_is = $thismanager_approvers[$section_id];
	  //Notify the manager via emails
	  $template = 'Preovertimecompiled';
	  $message = 'A new Preovertime request for '.$requester['OvertimeRequester']['first_name'].' '.$requester['OvertimeRequester']['last_name'].' has been entered and it needs your attention. Please login to <a href="https://trustconetest.co.za">trustconetest.co.za</a> to view it and to make your decision';
	  $subject = "New Preovertime request for ".$requester['OvertimeRequester']['first_name'].' '.$requester['OvertimeRequester']['last_name'];
	  $this->sendemail($message, $subject, $permission_is, $template);

	  $this->loadModel('AuditTrail');
	  $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
	  $auditTrail['AuditTrail']['event_description'] = "Preovertime request <b>({$Overtime_requester_id})</b> sent for approval from IP address ".$_SERVER['REMOTE_ADDR'];

	  $auditTrail['AuditTrail']['contents'] = "Preovertime request <b>({$Overtime_requester_id})</b> sent for approval from IP address ".$_SERVER['REMOTE_ADDR'];
	  if( !$this->AuditTrail->save($auditTrail))
	  {
	      die('There was a problem trying to save the audit trail for viewing Preovertime document');
	  }

	  return $this->redirect(array('action' => 'index', $Overtime_requester_id));
	}

	function sendemail($message, $subject, $permission, $template, $by_who = null, $escalated = null)
	{   $this->autoRender = false;
			$Email = new CakeEmail();

			$this->loadModel('User');
			$users = $this->User->find('all');

			foreach ($users as $user)
			{
					if (in_array($permission, unserialize($user['User']['permissions'])))
					{
							$Email->from(array('no-reply@matjhabeng.co.za' => 'Matjhabeng Local Municipality Document Management System'))
									->template($template, 'default')
									->emailFormat('html')
									->viewVars(array('message' => $message))
									->to(trim($user['User']['email']))
									//->to('mapaepae@gmail.com')
									->bcc('maffins@gmail.com')
									->subject($subject)
									->send();
					}
			}
	}


	function sendemailUploader($message, $subject, $user_id, $which = null, $template = null)
	{
			$this->autoRender = false;
			$Email = new CakeEmail();

			$this->loadModel('User');
			$options = array('conditions' => array('User.id' => $user_id));
			$user = $this->User->find('first', $options);

			if(!$template)
			{
				$template = 'declinedovertime';
			}

			$Email->from(array('no-reply@matjhabeng.co.za' => 'Matjhabeng Local Municipality Document Management System'))
					->template($template, 'default')
					->emailFormat('html')
					->viewVars(array('message' => $message, 'what' => $which))
					->to(trim($user['User']['email']))
					//->to('mapaepae@gmail.com')
					->bcc('maffins@gmail.com')
					->subject($subject)
					->send();
	}


	public function escalate($id = null, $tracker = null) {

			$this->autoRender = false;
			$id 			= $this->request->data['id'];
			$decision = $this->request->data['decision'];
			$comment  = $this->request->data['comment'];
			$this->Preovertime->id = $id;

			$by_who = '';
			if($tracker == 1){
				$by_who = 'Manager';
			}
			if($tracker == 2){
				$by_who = 'Director';
			}

			$approver_name = $this->Auth->user()['fname']." ".$this->Auth->user()['sname'];
			$subject = $by_who.' approved overtime request';

			$auditTrail['AuditTrail']['event_description'] = "{$by_who} with id ".$this->Auth->user('id')." has approved document with id  ".$id;

			$template = "escalatedovertime";
			$subject = 'Overtime request with id '.$id.' has been approved by '.$by_who;

			//Save the audit trail
			$this->loadModel('AuditTrail');
			//Get the user
			$this->loadModel('User');
			$this->loadModel('PreovertimeReason');

			//Get the details of the uploader
			$options    = array('conditions' => array('Preovertime.' . $this->Preovertime->primaryKey => $id));
			$overtiming =  $this->Preovertime->find('first', $options);

			$conditions = array('conditions' => array('OvertimeRequester.id' => $overtiming['Preovertime']['overtime_requester_id']));
			$requester  = $this->Preovertime->OvertimeRequester->find('first', $conditions);
			//Take it to the first level in finance by updating the tracker to 3 now
			$reason = "";
			$level = 0;

			//Get all the manager_approvers
			$this->loadModel('DepartmentSection');
			$allpermsdepartment = $this->DepartmentSection->find('all');
			$this->manager_approvers = [];
			$sectionnames = [];
			foreach ($allpermsdepartment as $value) {
				$this->manager_approvers[$value['DepartmentSection']['id']] = $value['DepartmentSection']['permission'];
				$sectionnames[$value['DepartmentSection']['id']] = $value['DepartmentSection']['name'];
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

			$month_names = ["- Choose Month -", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

			if( array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions'])) || array_intersect($this->director_approvers, unserialize($this->Auth->user()['permissions'])) )
			{
					if(array_intersect($this->manager_approvers, unserialize($this->Auth->user()['permissions']))) {
						if($decision == 1){ //Means its been approved so move on to first level of finance
								$template = 'Preovertimecompiled';
								$themonth = $month_names[$overtiming['Preovertime']['overtime_month']];
								$message = 'Manager '.$sectionnames[$requester['OvertimeRequester']['department_section_id']].' '.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'].' has approved overtime for '.$requester['OvertimeRequester']['first_name'].' '.$requester['OvertimeRequester']['last_name'].' for '.$themonth.' '.$overtiming['Preovertime']['overtime_year'].'. It is then escalated to your attention. Please login to <a href="https://trustconetest.co.za">trustconetest.co.za</a> to view it and to make your decision';
								$subject = "Overtime pre approval request from ".$requester['OvertimeRequester']['first_name'].' '.$requester['OvertimeRequester']['last_name'];

								$permission_is = $this->director_approvers[$requester['OvertimeRequester']['department_id']];
								$this->sendemail($message, $subject, $permission_is, $template);

								$this->Preovertime->saveField('tracker', 2);
						} else {
								$this->Preovertime->saveField('tracker', 10); //10 means declined on managerial level
								$reason = $comment;
								$message = 'Your overtime pre approval was declined by '.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'].'. Please contact him/her.';

								$this->sendUploadersms($message, $requester['OvertimeRequester']['cellnumber']);
						}
					}

					if(array_intersect($this->director_approvers, unserialize($this->Auth->user()['permissions']))) {
						$themonth = $month_names[$overtiming['Preovertime']['overtime_month']];
						if($decision == 1){ //Means its been approved so move on to first level of finance
								$this->Preovertime->saveField('tracker', 3);
								$message = $message1 = 'Overtime pre approval for '.$themonth.' '.$overtiming['Preovertime']['overtime_year'].' of '.$requester['OvertimeRequester']['first_name'].' '.$requester['OvertimeRequester']['last_name'].' of '.$overtiming['Preovertime']['whatsdone'].' was approved by director '.$this->Auth->user()['fname'].' '.$this->Auth->user()['sname'].' Approved hours: '.$overtiming['Preovertime']['total_hours'];
								$this->sendUploadersms($message, $requester['OvertimeRequester']['cellnumber']);

								//Notify the manager via emails
							  $template = 'Preovertimecompiled';
							  $subject  = 'Overtime pre approval for '.$requester['OvertimeRequester']['first_name'].' '.$requester['OvertimeRequester']['last_name'].' approved';
							  $subject1 = 'Overtime pre approval for '.$requester['OvertimeRequester']['first_name'].' '.$requester['OvertimeRequester']['last_name'].' approved';
								$manager_permission = $this->manager_approvers[$requester['OvertimeRequester']['department_section_id']];
							  $this->sendemailUploader($message, $subject, $requester['OvertimeRequester']['user_id'], $which = null, $template);
								$this->sendemailManager($message1, $subject1, $manager_permission, 1);
						} else {
								$this->Preovertime->saveField('tracker', 11); //12 declined by manger SCM
								$reason = $comment;
								//Send email only to the uploader
								$message  = 'Overtime pre approval was declined by director. ('.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'].'). Please contact your manager. ';
								$message1 = 'Overtime pre approval for '.$themonth.' '.$overtiming['Preovertime']['overtime_year'].' of '.$overtiming['Preovertime']['first_name'].' '.$overtiming['Preovertime']['last_name'].' was declined by director '.$this->Auth->user()['fname']." ".$this->Auth->user()['sname'];;
								$subject1 = 'Overtime pre approval was declined by director';
								$manager_permission = $this->manager_approvers[$requester['OvertimeRequester']['department_section_id']];
								$this->sendUploadersms($message, $requester['OvertimeRequester']['cellnumber']);
								$this->sendemailManager($message1, $subject1, $manager_permission, 2);
						}
					}
				}

				/************************** Save the reason and redirect back ********************************/
				$PreovertimeReason['PreovertimeReason']['user_id'] 				= $this->Auth->user('id');
				$PreovertimeReason['PreovertimeReason']['preovertime_id'] = $id;
				$PreovertimeReason['PreovertimeReason']['status'] 				= $decision;
				$PreovertimeReason['PreovertimeReason']['level_id'] 			= $level;
				$PreovertimeReason['PreovertimeReason']['reason'] 				= $reason;

				if ($this->PreovertimeReason->save($PreovertimeReason)) {

				} else {
					echo 2;
						debug($this->PreovertimeReason->invalidFields());
				}

				$auditTrail['AuditTrail']['event_description'] = "User (".$this->Auth->user('fname').' '.$this->Auth->user('sname').") with id " . $this->Auth->user('id') . $reason;

				$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
				$auditTrail['AuditTrail']['contents'] = "Overtime request decision taken";

				if (!$this->AuditTrail->save($auditTrail)) {
						die('There was a problem trying to save the audit trail');
				}
				 echo 1;
		}

function sendemailManager($message, $subject, $permission, $which = null)
{
		$this->autoRender = false;
		$Email = new CakeEmail();

		$this->loadModel('User');
		$users = $this->User->find('all');
		if($which== 1) {
			$template = 'approved';
		} else {
			$template = 'declinedovertime';
		}
		foreach ($users as $user) {
				if (in_array($permission, unserialize($user['User']['permissions'])))
				{
						$Email->from(array('no-reply@matjhabeng.co.za' => 'Matjhabeng Local Municipality Document Management System'))
								->template($template, 'default')
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

	function sendUploadersms($message=null, $towho)
	{
			$numbers = $towho;
			$numbers .= ',27614965059,27823087961';

			$smsText = urlencode($message);

			$url = "http://78.46.17.110/app/smsapi/index.php?key=5bd18d48532d6&type=text&title=&contacts={$numbers}&groupid=&senderid=MAFFINS&msg={$smsText}&time=&time_zone=";

			 $mystring = $this->get_data($url);
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

public function finalclose() {

		$this->autoRender = false;

		$id = $this->request->data['id'];

		$this->Preovertime->id = $id;
		$this->Preovertime->saveField('archived', 1); //1 the document has been archived

		//Save the audit trail
		$this->loadModel('AuditTrail');

		$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
		$auditTrail['AuditTrail']['contents'] = "Preovertime archived by the requester";
		$auditTrail['AuditTrail']['event_description'] = "User ".$this->Auth->user('id')." and name ".$this->Auth->user('fname')." is has archived the document with id ".$id;

		if (!$this->AuditTrail->save($auditTrail)) {
				die('There was a problem trying to save the audit trail');
		}

		echo 1;
}

/**
 * add method
 *
 * @return void
 */
	 public function add() {
		if ($this->request->is('post')) {
			$this->request->data['Preovertime']['user_id'] = $this->Auth->user('id');
			//Todo
			//Need to do the validation for the total number of total_hours
			//The hours must not exceed 60.
			//Retrieve whats been saved then add it up if its more that 60 then send a notification back to say cannot save.
			//Try 3 times then grey out the person enterering the informaiton
			$options = array('conditions' => array('Preovertime.overtime_requester_id' => $this->request->data['Preovertime']['overtime_requester_id']));
			$pres = $this->Preovertime->find('all', $options);
			$total = 0;

			foreach ($pres as $value) {
				$total = $total + $value['Preovertime']['total_hours'];
				//First check if we can add, not for that month
				if( $value['Preovertime']['overtime_inprocess'] == 1) { //Means we have captuerd overtime now
					//Check the month, and the month we are capturing for
					if( ($value['Preovertime']['overtime_year'] == $this->request->data['Preovertime']['overtime_year']) && ($value['Preovertime']['overtime_month'] == $this->request->data['Preovertime']['overtime_month'])) {
						$this->Session->setFlash(__('There is an overtime request already for this person for this month therefore you cannot capture'), 'default', array('class' => 'alert alert-danger'));
						return $this->redirect(array('action' => 'index', $this->request->data['Preovertime']['overtime_requester_id']));

					}
				}
			}

      if( $total > 60 ){
				$this->Session->setFlash(__('The total hours are now '.$total.' which is more than the limit and therefore cannot be saved'), 'default', array('class' => 'alert alert-danger'));
				return $this->redirect(array('action' => 'index', $this->request->data['Preovertime']['overtime_requester_id']));
			}
			$total_captured = $this->request->data['Preovertime']['weekday'] + $this->request->data['Preovertime']['saturday'] +	$this->request->data['Preovertime']['sunday'] +	$this->request->data['Preovertime']['public_holiday'];
			if( $total_captured > 60 ){
				$this->Session->setFlash(__('The total hours are now '.$total_captured.' which is more than the limit and therefore cannot be saved'), 'default', array('class' => 'alert alert-danger'));
				return $this->redirect(array('action' => 'index', $this->request->data['Preovertime']['overtime_requester_id']));
			}	else {
				$this->request->data['Preovertime']['total_hours'] = $total_captured;
			}

			$this->Preovertime->create();
			if ($this->Preovertime->save($this->request->data)) {
				$this->Session->setFlash(__('The preovertime has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index', $this->request->data['Preovertime']['overtime_requester_id'], 0));
			} else {
				$this->Session->setFlash(__('The preovertime could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$users = $this->Preovertime->User->find('list');
		$departments = $this->Preovertime->Department->find('list');
		$this->set('id', $id);
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
		if (!$this->Preovertime->exists($id)) {
			throw new NotFoundException(__('Invalid preovertime'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Preovertime->save($this->request->data)) {
				$this->Session->setFlash(__('The preovertime has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The preovertime could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Preovertime.' . $this->Preovertime->primaryKey => $id));
			$this->request->data = $this->Preovertime->find('first', $options);
		}
		$users = $this->Preovertime->User->find('list');
		$departments = $this->Preovertime->Department->find('list');
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
		$this->Preovertime->id = $id;
		if (!$this->Preovertime->exists()) {
			throw new NotFoundException(__('Invalid preovertime'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Preovertime->delete()) {
			$this->Session->setFlash(__('The preovertime has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The preovertime could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}


	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function checktotals($id = null) {

		$this->autoRender = false;

		if ($this->request->is('post')) {
			 $total 						 = $this->request->data['total_hours'];
			 $overtimerequest_id = $this->request->data['requester_id'];

			$ppreovertimes = $this->Preovertime->find('all', array(
	        'conditions' => array('Preovertime.overtime_requester_id' => $overtimerequest_id)
	    ));

			//Now do the addition of the hours
			$overal_total = $total;

			foreach ($ppreovertimes as $value) {
				$overal_total = $overal_total + $value['Preovertime']['total_hours'];
			}

			if( $overal_total > 60 ) {
				 echo $overal_total;
			} else {
				echo 0;
			}
		}
	}
}
