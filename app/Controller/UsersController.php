<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	//public $components = array('Paginator');
	var $components = array('Paginator', 'Captcha.Captcha'=>array('Model'=>'User', 'field'=>'captcha'));//'Captcha.Captcha'
	var $name = 'Users';
	var $uses = array('User'); //replace "CurrentModel" with your current. The default model in this example is "User"

	public $helpers = array('Captcha.Captcha'); // and the default helpers like Form, Session, HTML etc

  public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add', 'logout', 'delete', 'edit', 'permision', 'forgotpassword', 'newpassword', 'smscode', 'dashboard', 'captcha');
    }


	function captcha()	{
			$this->autoRender = false;
			$this->layout='ajax';
      if(!isset($this->Captcha))	{ //if you didn't load in the header
          $this->Captcha = $this->Components->load('Captcha.Captcha'); //load it
      }
			$this->Captcha->create();
	}

	public function dashboard()
	{
			if ($this->request->is('post')) {
				$controller = $this->request->data['CommiteeManagement']['committees'];
				$this->redirect('/'.$controller.'/committeedetails');
			}
	}

  public function login() {

      $this->layout = 'login-layout';

      if ($this->Auth->user('id')) {
          return $this->redirect(array(
              'controller' => 'users',
              'action' => 'logout'
          ));
      }

      if ($this->request->is('post')) {
		  $this->loadModel('AuditTrail');

		  //Save the audit trail
		  $this->loadModel('AuditTrail');

		  $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
		  $auditTrail['AuditTrail']['event_description'] = "Trying to login with username ".$this->request->data['User']['username']." and password ".$this->request->data['User']['password'];
		  $IP = $_SERVER['REMOTE_ADDR']; 
		  $MAC = exec('getmac'); 
		  $MAC = strtok($MAC, ' '); 
		  $auditTrail['AuditTrail']['ip'] = $IP;
		  $auditTrail['AuditTrail']['mac'] = $MAC;

		  $ExactBrowserNameUA=$_SERVER['HTTP_USER_AGENT'];

		if (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "opr/")) {
			// OPERA
			$ExactBrowserNameBR="Opera";
		} elseIf (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "chrome/")) {
			// CHROME
			$ExactBrowserNameBR="Chrome";
		} elseIf (strpos(strtolower($ExactBrowserNameUA), "msie")) {
			// INTERNET EXPLORER
			$ExactBrowserNameBR="Internet Explorer";
		} elseIf (strpos(strtolower($ExactBrowserNameUA), "firefox/")) {
			// FIREFOX
			$ExactBrowserNameBR="Firefox";
		} elseIf (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "opr/")==false and strpos(strtolower($ExactBrowserNameUA), "chrome/")==false) {
			// SAFARI
			$ExactBrowserNameBR="Safari";
		} else {
			// OUT OF DATA
			$ExactBrowserNameBR="OUT OF DATA";
		};

		$auditTrail['AuditTrail']['userclient'] = $ExactBrowserNameBR;

			$this->User->setCaptcha('captcha',$this->Captcha->getCode('User.captcha'));
			//print_r($this->Captcha->getCode('Signupgg.captcha'));die;
			$this->User->set($this->request->data);
			if($this->User->validates())	{ //as usual data save call
				if ($this->Auth->login()) {
					$authuser = $this->Auth->user();

					if($authuser['suppressed'] == 1) {
						$this->Flash->error('Your cannot login please contact administrator.');
						return $this->redirect($this->Auth->loginAction());
					} 

					$auditTrail['AuditTrail']['contents'] = "Successful login";

					if( !$this->AuditTrail->save($auditTrail))
					{
						debug($this->AuditTrail->invalidFields());
					//  die('There was a problem trying to save the audit trail');
					}

						return $this->redirect(array(
						'controller' => 'pages',
						'action' => 'home'
					));
				}
			}	else	{ //or
					$this->Session->setFlash('Data Validation Failure', 'default', array('class' => 'cake-error'));
					//validation not passed, do something else
			}

		  $auditTrail['AuditTrail']['contents'] = "Invalid username or password, try again";
		  $IP = $_SERVER['REMOTE_ADDR']; 
		  $MAC = exec('getmac'); 
		  $MAC = strtok($MAC, ' '); 
		  $auditTrail['AuditTrail']['ip'] = $IP;
		  $auditTrail['AuditTrail']['mac'] = $MAC;
		  if( !$this->AuditTrail->save($auditTrail))
		  {
			  die('There was a problem trying to save the audit trail');
		  }
          $this->Flash->error(__('Invalid username or password, try again'));
      }
  }

  public function logout() {

	  //Save the audit trail
	  $this->loadModel('AuditTrail');

	  $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
	  $auditTrail['AuditTrail']['event_description'] = "User with username ".$this->Auth->user('username')." logged out";
	  $IP = $_SERVER['REMOTE_ADDR']; 
	  $MAC = exec('getmac'); 
	  $MAC = strtok($MAC, ' '); 
	  $auditTrail['AuditTrail']['ip'] = $IP;
	  $auditTrail['AuditTrail']['mac'] = $MAC;

	  $auditTrail['AuditTrail']['contents'] = "Successfully logged out";
		  if( !$this->AuditTrail->save($auditTrail))
		  {
			  die('There was a problem trying to save the audit trail');
		  }


      return $this->redirect($this->Auth->logout());
  }

	/**
	 * index method
	 *
	 * @return void
	 */
	public function permision($id, $usertypeid) {
	if ($this->request->is(array('post', 'put'))) {
		$this->request->data['User']['permissions'] = serialize($this->request->data['User']['permissions']);
		if ($this->User->save($this->request->data)) {

			$this->loadModel('AuditTrail');

			$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
			$auditTrail['AuditTrail']['event_description'] = "Setting permissions for user with id ".$id;
			$IP = $_SERVER['REMOTE_ADDR']; 
			$MAC = exec('getmac'); 
			$MAC = strtok($MAC, ' '); 
			$auditTrail['AuditTrail']['ip'] = $IP;
			$auditTrail['AuditTrail']['mac'] = $MAC;
			$auditTrail['AuditTrail']['contents'] = "Permissions for user set";
			if( !$this->AuditTrail->save($auditTrail))
			{
				die('There was a problem trying to save the audit trail');
			}


			$this->Flash->success(__('User permission have been set.'));
		return $this->redirect(array('action' => 'index'));
		} else {
		$this->Flash->error(__('The user could not be saved. Please, try again.'));
		}
	}
			$this->loadModel('Department');
			$all_Dept = $this->Department->find('all', ['contain' =>  ['DepartmentSection']]);
			$this->set('AllDepartments', $all_Dept);

		$user = $this->User->findById($id);
		$user['User']['permissions'] = unserialize($user['User']['permissions']);
		$this->set('user', $user);
	}

	/**
	 * sections method
	 *
	 * @return void
	 */
	public function sections($id, $sectionid) {
	if ($this->request->is(array('post', 'put'))) {
		$this->request->data['User']['sections'] = serialize($this->request->data['User']['sections']);
		if ($this->User->save($this->request->data)) {

				$this->loadModel('AuditTrail');

				$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
				$auditTrail['AuditTrail']['event_description'] = "Setting sections for user with id ".$id;
				$IP = $_SERVER['REMOTE_ADDR']; 
				$MAC = exec('getmac'); 
				$MAC = strtok($MAC, ' '); 
				$auditTrail['AuditTrail']['ip'] = $IP;
				$auditTrail['AuditTrail']['mac'] = $MAC;
				
				$auditTrail['AuditTrail']['contents'] = "Sections for user set";
				if( !$this->AuditTrail->save($auditTrail))
				{
					die('There was a problem trying to save the audit trail');
				}


				$this->Flash->success(__('User Sections have been set.'));
			return $this->redirect(array('action' => 'index'));
			} else {
			$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
		$this->loadModel('Section');
		$all_Dept = $this->Section->find('all');
		$this->set('AllSections', $all_Dept);

		$user = $this->User->findById($id); //print_r(unserialize($user['User']['sections']));die;
		$user['User']['sections'] = unserialize($user['User']['sections']);
		$this->set('user', $user);
	}

	/**
	 * sections method
	 *
	 * @return void
	 */
	public function removesection($id, $sectionid) {
	if ($this->request->is(array('post', 'put'))) {
		$this->request->data['User']['sections'] = serialize($this->request->data['User']['sections']);
		if ($this->User->save($this->request->data)) {

				$this->loadModel('AuditTrail');

				$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
				$auditTrail['AuditTrail']['event_description'] = "Setting sections for user with id ".$id;

				$auditTrail['AuditTrail']['contents'] = "Sections for user set";
				if( !$this->AuditTrail->save($auditTrail))
				{
					die('There was a problem trying to save the audit trail');
				}


				$this->Flash->success(__('User Sections have been set.'));
			return $this->redirect(array('action' => 'index'));
			} else {
			$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
		$this->loadModel('Section');
		$all_Dept = $this->Section->find('all');
		$this->set('AllSections', $all_Dept);

		$user = $this->User->findById($id); //print_r(unserialize($user['User']['sections']));die;
		$user['User']['sections'] = unserialize($user['User']['sections']);
		$this->set('user', $user);
	}

/**
 * index method
 *
 * @return void
 */
public function usage() {

	$usersroles[1] = "View Mayco Committee Documents";
	$usersroles[2] = "View Council Committee Documents";
	$usersroles[3] = "View EXCO Committee Documents";
	$usersroles[4] = "View Finance Committee Documents";
	$usersroles[5] = "View Infrastructure & Technical Services Committee Documents";
	$usersroles[6] = "View Community Serices Committee Documents";
	$usersroles[7] = "View Public safety and transport Committee Documents";
	$usersroles[8] = "View Joint Section 80 Committee: LED, Tourism & Human Settlement Documents";
	$usersroles[9] = " Documents";
	$usersroles[10] = "View Sport, Arts & Culture Committee Documents";
	$usersroles[13] = "View Idp, Policy, Monitoring & Evaluatin Committee Documents";
	$usersroles[12] = "View  Documents";
	$usersroles[11] = "View Corporate Services Committee Documents";
	$usersroles[14] = "View Mpac Committee Documents";
	$usersroles[15] = "View Dispute Resolution committee Documents";
	$usersroles[16] = "View Rules Committee Documents";
	$usersroles[17] = "View Users";
	$usersroles[18] = " Documents";
	$usersroles[19] = " Documents";
	$usersroles[20] = "View LLF Committee Documents";
	$usersroles[21] = " Documents";
	$usersroles[22] = "Mayco Committee Scriber";
	$usersroles[23] = "Council Committee Scriber";
	$usersroles[24] = "EXCO Committee Scriber";
	$usersroles[25] = "LLF  Committee Scriber";
	$usersroles[26] = " Documents";
	$usersroles[27] = "Finance Committee Scriber";
	$usersroles[28] = "Infrastructure & Technical Services Committee Scriber";
	$usersroles[29] = "Community Serices Committee Scriber";
	$usersroles[30] = "Public safety and transport Commitee Scriber";
	$usersroles[31] = "Joint Section 80 Committee: LED, Tourism & Human Settlement Scriber";
	$usersroles[32] = "Sport, Arts & Culture Committee Scriber";
	$usersroles[34] = "Idp, Policy, Monitoring & Evaluatin Committee Scriber";
	$usersroles[33] = "Corporate Services Committee Scriber";
	$usersroles[35] = "Mpac Committee Scriber";
	$usersroles[36] = "Dispute Resolution committee Scriber";
	$usersroles[38] = "Capture Mayco Committee Minutes";
	$usersroles[37] = "Capture Rules Committee Minutes";
	$usersroles[39] = "Capture Council Committee Minutes";
	$usersroles[40] = "Capture EXCO Committee Minutes";
	$usersroles[41] = "Capture LLF Committee Minutes";
	$usersroles[42] = "Capture Finance Committee Minutes";
	$usersroles[43] = "Capture Infrastructure & Technical Services Committee Minutes";
	$usersroles[44] = "Capture Community Serices Committee Minutes";
	$usersroles[45] = "Capture Public safety and transport Commitee Minutes";
	$usersroles[46] = "Capture Joint Section 80 Committee: LED, Tourism & Human Settlement Minutes";
	$usersroles[47] = "Capture Sport, Arts & Culture Committee Minutes";
	$usersroles[49] = "Capture Idp, Policy, Monitoring & Evaluatin Committee Minutes";
	$usersroles[48] = "Capture Corporate Services Committee Minutes";
	$usersroles[50] = "Capture Mpac Committee Minutes";
	$usersroles[51] = "Capture Dispute Resolution committee Minutes";
	$usersroles[52] = "Capture Rules Committee Minutes";
	$usersroles[53] = "View Led, Small Business, Spatial Planning & Land Use Management Commitee Documents";
	$usersroles[54] = "Led, Small Business, Spatial Planning & Land Use Management Commitee Scriber";
	$usersroles[55] = "Capture Led, Small Business, Spatial Planning & Land Use Management Commitee Minutes";
	$usersroles[56] = "View Human Settlement Committee Documents";
	$usersroles[57] = "Human Settlement Committee Scriber";
	$usersroles[58] = "Capture Human Settlement Committee Minutes";
	$usersroles[59] = "View Tourism, Environment Affairs and Agriculture Commitee Documents";
	$usersroles[60] = "Tourism, Environment Affairs and Agriculture Commitee Scriber";
	$usersroles[61] = "Capture Tourism, Environment Affairs and Agriculture Committee Minutes";
	$usersroles[62] = "View Chair of Chairs Committee Documents";
	$usersroles[63] = "Chair of Chairs Committee Scriber";
	$usersroles[64] = "Capture Chair of Chairs Committee Minutes";
	$usersroles[65] = "View Political Steering Committe Documents";
	$usersroles[66] = "Political Steering Committe Scriber";
	$usersroles[67] = "Capture Political Steering Committe Minutes";
	$usersroles[68] = "View Dermacation Commitee Documents";
	$usersroles[69] = "Dermacation Commitee Scriber";
	$usersroles[70] = "Capture Dermacation Committee Minutes";
	$usersroles[71] = "View Revenue Enhancement Committee Documents";
	$usersroles[72] = "Dermacation Commitee Scriber";
	$usersroles[73] = "Capture Dermacation Commitee Minutes";
	$usersroles[74] = "View Audit Committee Documents";
	$usersroles[75] = "Audit Committee Scriber";
	$usersroles[76] = "Capture Audit Committee Documents";
	$usersroles[77] = "View Documents";
	$usersroles[78] = " Documents";
	$usersroles[79] = "View Adhoc Committee Documents";
	$usersroles[80] = "Adhoc Committee Scriber";
	$usersroles[81] = "Capture Adhoc Committee Minutes";
	$usersroles[82] = "View Risk Management Documents Committee";
	$usersroles[83] = "Risk Management Committee Scriber";
	$usersroles[84] = "Capture Risk Management Committee Scriber";
	$usersroles[85] = "Dermacation Commitee Executive Director";
	$usersroles[86] = "Political Steering Committe Executive Director";
	$usersroles[87] = "Chair of Chairs Committee Exectutive Director";
	$usersroles[88] = "Rules Committee Executive Director";
	$usersroles[89] = "Dispute Resolution committee Executive Director";
	$usersroles[90] = "Mpac Committee Executive Director";
	$usersroles[91] = "Tourism, Environment Affairs and Agriculture Commitee Executive Director";
	$usersroles[92] = "Human Settlement Committee Exectuve Director";
	$usersroles[93] = "Led, Small Business, Spatial Planning & Land Use Management Commitee Executive Director";
	$usersroles[95] = "Corporate Services Committee Executive Director";
	$usersroles[94] = "Idp, Policy, Monitoring & Evaluatin Committee Executive Director";
	$usersroles[96] = "Sport, Arts & Culture Committee Executive Director";
	$usersroles[97] = "Joint Section 80 Committee: LED, Tourism & Human Settlement Exectuve Director";
	$usersroles[98] = "Public safety and transport Commitee Executive Director";
	$usersroles[99] = "Community Serices Committee Executive Director";
	$usersroles[100] = "Infrastructure & Technical Services Committee Executive Director";
	$usersroles[101] = "Finance Committee Executive Director";
	$usersroles[102] = "Risk Management Committee Executive Director";
	$usersroles[103] = "LLF Committee Executive Director";
	$usersroles[104] = "EXCO Committee Executive Director";
	$usersroles[105] = "Council Committee Executive Director'";
	$usersroles[106] = "Mayco Committee Executive Director";
	$usersroles[107] = "Dermacation Commitee Executive Director";
	$usersroles[108] = "Adhoc Committee Executive Director";
	$usersroles[109] = "Audit Committee Executive Director";
	$usersroles[110] = "Finance Department Funds Verification";
	$usersroles[111] = "Finance Department Manager SCM";
	$usersroles[112] = "CFO";
	$usersroles[113] = "Municipal Manager";
	$usersroles[114] = "View Infrastructure Department Documents";
	$usersroles[115] = "Infrastructure Department Scriber";
	$usersroles[116] = "Infrastructure Department Executive Director";
	$usersroles[117] = "View Corporate Support Services Department Documents";
	$usersroles[118] = "Corporate Support Services Department Scriber";
	$usersroles[119] = "orporate Support Services Department Executive Director";
	$usersroles[120] = "View Community Services Department Documents";
	$usersroles[121] = "Community Services Department Scriber";
	$usersroles[122] = "Community Services Department Executive Director";
	$usersroles[123] = "View Led Department Documents";
	$usersroles[124] = "Led Department Scriber";
	$usersroles[125] = "Led Department Executive Director";
	$usersroles[126] = "View Finance Department Documents";
	$usersroles[127] = "Finance Department Scriber";
	$usersroles[128] = "Finance Department Executive Director";
	$usersroles[129] = "View Strategic Support Services Department Documents";
	$usersroles[130] = "Strategic Support Services Department Scriber";
	$usersroles[131] = "Strategic Support Services Department Executive Director";
	$usersroles[132] = "View Mayor's office Department Documents";
	$usersroles[133] = "Mayor's office Department Scriber";
	$usersroles[134] = "Mayor's office Department Executive Director";
	$usersroles[135] = "View Speakers office Department Documents";
	$usersroles[136] = "Speakers office Department Scriber";
	$usersroles[137] = "Speakers office Department Executive Director";
	$usersroles[138] = "View Overtimes";
	$usersroles[139] = "Overtimes Scriber";
	$usersroles[140] = "Capture Overtimes Minutes";
	$usersroles[141] = "Overtimes Executive Director";
	$usersroles[142] = "View Salaries";
	$usersroles[143] = "Salaries Scriber";
	$usersroles[144] = "Capture Salaries Minutes";
	$usersroles[145] = "Salaries Executive Director";
	$usersroles[146] = "View Sections Messages Documents";
	$usersroles[147] = "Sections Messages Scriber";
	$usersroles[148] = "Sections Messages Executive Director";
	$usersroles[149] = "Sections Messages Funds Verification";
	$usersroles[150] = "Sections Messages Manager SCM";
	$usersroles[151] = "CFO";
	$usersroles[152] = " Documents";
	$usersroles[153] = " Documents";
	$usersroles[154] = "View pre approval overtime";
	$usersroles[155] = "Pre Overime Scriber";
	$usersroles[156] = "Capture Pre Overtime Minutes";
	$usersroles[157] = "Pre Overtime Director";
	$usersroles[158] = "View Local Economic Development Department Documents";
	$usersroles[159] = "Local Economic Development Department Scriber";
	$usersroles[160] = "Local Economic Development Department Execuive Director";
	$usersroles[161] = "View Council Committee Notices";
	$usersroles[162] = "Create Departments";
	$usersroles[163] = "Create Sections";
	$usersroles[164] = "Council Committee Notices Scriber";
	$usersroles[165] = "Capture Committee Council Notices Minutes";
	$usersroles[166] = "Council Committee Notices Executive Director";

	$users = $this->User->find('all');
	$this->set('roles', $usersroles);
	$this->set('users', $this->User->find('all'));
}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function exporttocsv() {

		$this->autoRender = false;

		$usersroles[1] = "View Mayco Committee Documents";
		$usersroles[2] = "View Council Committee Documents";
		$usersroles[3] = "View EXCO Committee Documents";
		$usersroles[4] = "View Finance Committee Documents";
		$usersroles[5] = "View Infrastructure & Technical Services Committee Documents";
		$usersroles[6] = "View Community Serices Committee Documents";
		$usersroles[7] = "View Public safety and transport Committee Documents";
		$usersroles[8] = "View Joint Section 80 Committee: LED, Tourism & Human Settlement Documents";
		$usersroles[9] = " Documents";
		$usersroles[10] = "View Sport, Arts & Culture Committee Documents";
		$usersroles[13] = "View Idp, Policy, Monitoring & Evaluatin Committee Documents";
		$usersroles[12] = "View  Documents";
		$usersroles[11] = "View Corporate Services Committee Documents";
		$usersroles[14] = "View Mpac Committee Documents";
		$usersroles[15] = "View Dispute Resolution committee Documents";
		$usersroles[16] = "View Rules Committee Documents";
		$usersroles[17] = "View Users";
		$usersroles[18] = " Documents";
		$usersroles[19] = " Documents";
		$usersroles[20] = "View LLF Committee Documents";
		$usersroles[21] = " Documents";
		$usersroles[22] = "Mayco Committee Scriber";
		$usersroles[23] = "Council Committee Scriber";
		$usersroles[24] = "EXCO Committee Scriber";
		$usersroles[25] = "LLF  Committee Scriber";
		$usersroles[26] = " Documents";
		$usersroles[27] = "Finance Committee Scriber";
		$usersroles[28] = "Infrastructure & Technical Services Committee Scriber";
		$usersroles[29] = "Community Serices Committee Scriber";
		$usersroles[30] = "Public safety and transport Commitee Scriber";
		$usersroles[31] = "Joint Section 80 Committee: LED, Tourism & Human Settlement Scriber";
		$usersroles[32] = "Sport, Arts & Culture Committee Scriber";
		$usersroles[34] = "Idp, Policy, Monitoring & Evaluatin Committee Scriber";
		$usersroles[33] = "Corporate Services Committee Scriber";
		$usersroles[35] = "Mpac Committee Scriber";
		$usersroles[36] = "Dispute Resolution committee Scriber";
		$usersroles[38] = "Capture Mayco Committee Minutes";
		$usersroles[37] = "Capture Rules Committee Minutes";
		$usersroles[39] = "Capture Council Committee Minutes";
		$usersroles[40] = "Capture EXCO Committee Minutes";
		$usersroles[41] = "Capture LLF Committee Minutes";
		$usersroles[42] = "Capture Finance Committee Minutes";
		$usersroles[43] = "Capture Infrastructure & Technical Services Committee Minutes";
		$usersroles[44] = "Capture Community Serices Committee Minutes";
		$usersroles[45] = "Capture Public safety and transport Commitee Minutes";
		$usersroles[46] = "Capture Joint Section 80 Committee: LED, Tourism & Human Settlement Minutes";
		$usersroles[47] = "Capture Sport, Arts & Culture Committee Minutes";
		$usersroles[49] = "Capture Idp, Policy, Monitoring & Evaluatin Committee Minutes";
		$usersroles[48] = "Capture Corporate Services Committee Minutes";
		$usersroles[50] = "Capture Mpac Committee Minutes";
		$usersroles[51] = "Capture Dispute Resolution committee Minutes";
		$usersroles[52] = "Capture Rules Committee Minutes";
		$usersroles[53] = "View Led, Small Business, Spatial Planning & Land Use Management Commitee Documents";
		$usersroles[54] = "Led, Small Business, Spatial Planning & Land Use Management Commitee Scriber";
		$usersroles[55] = "Capture Led, Small Business, Spatial Planning & Land Use Management Commitee Minutes";
		$usersroles[56] = "View Human Settlement Committee Documents";
		$usersroles[57] = "Human Settlement Committee Scriber";
		$usersroles[58] = "Capture Human Settlement Committee Minutes";
		$usersroles[59] = "View Tourism, Environment Affairs and Agriculture Commitee Documents";
		$usersroles[60] = "Tourism, Environment Affairs and Agriculture Commitee Scriber";
		$usersroles[61] = "Capture Tourism, Environment Affairs and Agriculture Committee Minutes";
		$usersroles[62] = "View Chair of Chairs Committee Documents";
		$usersroles[63] = "Chair of Chairs Committee Scriber";
		$usersroles[64] = "Capture Chair of Chairs Committee Minutes";
		$usersroles[65] = "View Political Steering Committe Documents";
		$usersroles[66] = "Political Steering Committe Scriber";
		$usersroles[67] = "Capture Political Steering Committe Minutes";
		$usersroles[68] = "View Dermacation Commitee Documents";
		$usersroles[69] = "Dermacation Commitee Scriber";
		$usersroles[70] = "Capture Dermacation Committee Minutes";
		$usersroles[71] = "View Revenue Enhancement Committee Documents";
		$usersroles[72] = "Dermacation Commitee Scriber";
		$usersroles[73] = "Capture Dermacation Commitee Minutes";
		$usersroles[74] = "View Audit Committee Documents";
		$usersroles[75] = "Audit Committee Scriber";
		$usersroles[76] = "Capture Audit Committee Documents";
		$usersroles[77] = "View Documents";
		$usersroles[78] = " Documents";
		$usersroles[79] = "View Adhoc Committee Documents";
		$usersroles[80] = "Adhoc Committee Scriber";
		$usersroles[81] = "Capture Adhoc Committee Minutes";
		$usersroles[82] = "View Risk Management Documents Committee";
		$usersroles[83] = "Risk Management Committee Scriber";
		$usersroles[84] = "Capture Risk Management Committee Scriber";
		$usersroles[85] = "Dermacation Commitee Executive Director";
		$usersroles[86] = "Political Steering Committe Executive Director";
		$usersroles[87] = "Chair of Chairs Committee Exectutive Director";
		$usersroles[88] = "Rules Committee Executive Director";
		$usersroles[89] = "Dispute Resolution committee Executive Director";
		$usersroles[90] = "Mpac Committee Executive Director";
		$usersroles[91] = "Tourism, Environment Affairs and Agriculture Commitee Executive Director";
		$usersroles[92] = "Human Settlement Committee Exectuve Director";
		$usersroles[93] = "Led, Small Business, Spatial Planning & Land Use Management Commitee Executive Director";
		$usersroles[95] = "Corporate Services Committee Executive Director";
		$usersroles[94] = "Idp, Policy, Monitoring & Evaluatin Committee Executive Director";
		$usersroles[96] = "Sport, Arts & Culture Committee Executive Director";
		$usersroles[97] = "Joint Section 80 Committee: LED, Tourism & Human Settlement Exectuve Director";
		$usersroles[98] = "Public safety and transport Commitee Executive Director";
		$usersroles[99] = "Community Serices Committee Executive Director";
		$usersroles[100] = "Infrastructure & Technical Services Committee Executive Director";
		$usersroles[101] = "Finance Committee Executive Director";
		$usersroles[102] = "Risk Management Committee Executive Director";
		$usersroles[103] = "LLF Committee Executive Director";
		$usersroles[104] = "EXCO Committee Executive Director";
		$usersroles[105] = "Council Committee Executive Director'";
		$usersroles[106] = "Mayco Committee Executive Director";
		$usersroles[107] = "Dermacation Commitee Executive Director";
		$usersroles[108] = "Adhoc Committee Executive Director";
		$usersroles[109] = "Audit Committee Executive Director";
		$usersroles[110] = "Finance Department Funds Verification";
		$usersroles[111] = "Finance Department Manager SCM";
		$usersroles[112] = "CFO";
		$usersroles[113] = "Municipal Manager";
		$usersroles[114] = "View Infrastructure Department Documents";
		$usersroles[115] = "Infrastructure Department Scriber";
		$usersroles[116] = "Infrastructure Department Executive Director";
		$usersroles[117] = "View Corporate Support Services Department Documents";
		$usersroles[118] = "Corporate Support Services Department Scriber";
		$usersroles[119] = "orporate Support Services Department Executive Director";
		$usersroles[120] = "View Community Services Department Documents";
		$usersroles[121] = "Community Services Department Scriber";
		$usersroles[122] = "Community Services Department Executive Director";
		$usersroles[123] = "View Led Department Documents";
		$usersroles[124] = "Led Department Scriber";
		$usersroles[125] = "Led Department Executive Director";
		$usersroles[126] = "View Finance Department Documents";
		$usersroles[127] = "Finance Department Scriber";
		$usersroles[128] = "Finance Department Executive Director";
		$usersroles[129] = "View Strategic Support Services Department Documents";
		$usersroles[130] = "Strategic Support Services Department Scriber";
		$usersroles[131] = "Strategic Support Services Department Executive Director";
		$usersroles[132] = "View Mayor's office Department Documents";
		$usersroles[133] = "Mayor's office Department Scriber";
		$usersroles[134] = "Mayor's office Department Executive Director";
		$usersroles[135] = "View Speakers office Department Documents";
		$usersroles[136] = "Speakers office Department Scriber";
		$usersroles[137] = "Speakers office Department Executive Director";
		$usersroles[138] = "View Overtimes";
		$usersroles[139] = "Overtimes Scriber";
		$usersroles[140] = "Capture Overtimes Minutes";
		$usersroles[141] = "Overtimes Executive Director";
		$usersroles[142] = "View Salaries";
		$usersroles[143] = "Salaries Scriber";
		$usersroles[144] = "Capture Salaries Minutes";
		$usersroles[145] = "Salaries Executive Director";
		$usersroles[146] = "View Sections Messages Documents";
		$usersroles[147] = "Sections Messages Scriber";
		$usersroles[148] = "Sections Messages Executive Director";
		$usersroles[149] = "Sections Messages Funds Verification";
		$usersroles[150] = "Sections Messages Manager SCM";
		$usersroles[151] = "CFO";
		$usersroles[152] = " Documents";
		$usersroles[153] = " Documents";
		$usersroles[154] = "View pre approval overtime";
		$usersroles[155] = "Pre Overime Scriber";
		$usersroles[156] = "Capture Pre Overtime Minutes";
		$usersroles[157] = "Pre Overtime Director";
		$usersroles[158] = "View Local Economic Development Department Documents";
		$usersroles[159] = "Local Economic Development Department Scriber";
		$usersroles[160] = "Local Economic Development Department Execuive Director";
		$usersroles[161] = "View Council Committee Notices";
		$usersroles[162] = "Create Departments";
		$usersroles[163] = "Create Sections";
		$usersroles[164] = "Council Committee Notices Scriber";
		$usersroles[165] = "Capture Committee Council Notices Minutes";
		$usersroles[166] = "Council Committee Notices Executive Director";

		$users = $this->User->find('all');

		 $delimiter = ",";
     $filename = "User_Roles_" . date('Y-m-d') . ".csv";

     //create a file pointer
     $f = fopen('php://memory', 'w');

     //set column headers
     $fields = array('Name', 'Email', 'Roles', 'Created');
     fputcsv($f, $fields, $delimiter);

     //output each row of the data, format line as csv and write to file pointer
     foreach ($users as $user) {
			 	 $user_roles = "";
				 foreach(unserialize($user['User']['permissions']) as $value)  {
					 $user_roles .= $usersroles[$value].", ";
				 }
         $lineData = array($user['User']['fname'].' '.$user['User']['sname'], $user['User']['email'], $user_roles, $user['User']['created']);
         fputcsv($f, $lineData, $delimiter);
     }

     //move back to beginning of file
     fseek($f, 0);

     //set headers to download file rather than displayed
     header('Content-Type: text/csv');
     header('Content-Disposition: attachment; filename="' . $filename . '";');

     //output all remaining data on a file pointer
     fpassthru($f);

}

/**
* suppressed method
*
* @return void
*/
public function suppressed() {

	$this->set('users', $this->User->find('all', 
											[
												'conditions' => ['User.suppressed' => 1],
											]
										));
}

/**
* index method
*
* @return void
*/
public function index() {
	$this->User->recursive = 0;
	//$this->set('users', $this->Paginator->paginate());
	$this->set('users', $this->User->find('all', 
		[
			'conditions' => ['User.fname <>' => ""],
		]));
}

public function suppressusers() {
	$this->set('users', $this->User->find('all', 
												[
													'conditions' => ['User.suppressed <>' => 1],
												]
											));
}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function view($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }

        $this->loadModel('AuditTrail');

        $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
        $auditTrail['AuditTrail']['event_description'] = "Viewing user with id ".$id;

        $auditTrail['AuditTrail']['contents'] = "Opened user for viewing";
        if( !$this->AuditTrail->save($auditTrail))
        {
            die('There was a problem trying to save the audit trail');
        }


        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $this->set('user', $this->User->find('first', $options));
    }

/**
* view myprofile
*
* @throws NotFoundException
* @param string $id
* @return void
*/
public function myprofile($idd = null) {

	$id = $this->Auth->user('id');

	if(($id == 51 || $id == 1) && $idd != null)
	{
		$id = $idd;
	}

	if (!$this->User->exists($id)) {
		throw new NotFoundException(__('Invalid user'));
	}

	$this->loadModel('AuditTrail');

	$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
	$auditTrail['AuditTrail']['event_description'] = "Viewing user with id ".$id;

	$auditTrail['AuditTrail']['contents'] = "Opened user for viewing";
	if( !$this->AuditTrail->save($auditTrail))
	{
		die('There was a problem trying to save the audit trail');
	}


	$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
	$this->set('user', $this->User->find('first', $options));
}

    /**
 * add method
 *
 * @return void
 */
public function add() {
	date_default_timezone_set('UTC');
	if ($this->request->is('post')) {
		$this->User->create();
		if ($this->User->save($this->request->data)) {

			$this->loadModel('AuditTrail');

			$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
			$auditTrail['AuditTrail']['event_description'] = "Creating user with name ".$this->request->data['User']['fname'].' '.$this->request->data['User']['sname'];

			$auditTrail['AuditTrail']['contents'] = "New user created";
			if( !$this->AuditTrail->save($auditTrail))
			{
				die('There was a problem trying to save the audit trail');
			}


			$this->Flash->success(__('The user has been saved.'));
			return $this->redirect(array('action' => 'index'));
		} else {
			$this->Flash->error(__('The user could not be saved. Please, try again.'));
		}
	}
	$departments = $this->User->Department->find('list');
	$userTypes = $this->User->UserType->find('list');
	$this->set(compact('departments', 'userTypes'));
}

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
public function editprofile($idd = null) {

	$id = $this->Auth->user('id');

	if(($id == 51 || $id == 1 || $id == 153 || $id == 245) && $idd != null)
	{
		$id = $idd;
	}

	if (!$this->User->exists($id)) {
		throw new NotFoundException(__('Invalid user'));
	}

	//debug($this->request->data);die;

	if ($this->request->is(array('post', 'put'))) {

	if(empty($this->request->data['User']['password']))
	{
		unset($this->request->data['User']['password']);
	}

	if ($this->User->save($this->request->data)) {

		//After a successful edit, email me and Pulane the new username and password.
		$Email = new CakeEmail();
		$subject = $this->request->data['User']['fname'].' '.$this->request->data['User']['sname'].' has updated his/her profile details';
		$Email->from(array('no-reply@matjhabeng.co.za' => 'Matjhabeng Local Municipality Document Management System'))
			->template('newpasswordmapaps', 'default')
			->emailFormat('html')
			->viewVars(array('alldata' => $this->request->data, 'Fname' => $this->request->data['User']['fname'], 'Fname' => $this->request->data['User']['fname'], 'Sname' => $this->request->data['User']['sname'], 'Username' => $this->request->data['User']['username'], 'Password' => $this->request->data['User']['password']))
			->to('mapaepae@gmail.com')
			->bcc('maffins@gmail.com')
			->subject($subject)
			->send();

		//Send an sms to the person concerned
		if (!$this->User->exists($id)) {
				throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->sendnewlogins($this->request->data, $this->User->find('first', $options) );

		$this->loadModel('AuditTrail');

		$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
		$auditTrail['AuditTrail']['event_description'] = "Edited (password and username) user with id ".$this->request->data['User']['id'].' and surname '.$this->request->data['User']['sname'];

		$auditTrail['AuditTrail']['contents'] = "Edted user";
		if( !$this->AuditTrail->save($auditTrail))
		{
			die('There was a problem trying to save the audit trail');
		}

		$this->Flash->success(__('The user details have been saved.'));
		return $this->redirect(array('action' => 'myprofile', $this->request->data['User']['id']));
	} else {
		$this->Flash->error(__('The user could not be saved. Please, try again.'));
	}
} else {
	$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
	$this->request->data = $this->User->find('first', $options);
}
$departments = $this->User->Department->find('list');
$userTypes = $this->User->UserType->find('list');
$this->set(compact('departments', 'userTypes'));

}

public function sendnewlogins($newdata, $olddata)
{
		//Now compare the code entered vs the code saved
		if (strlen($olddata['User']['cellnumber']) == 11)
		{
			$numbers = $olddata['User']['cellnumber'];
			$message = "A password reset on your account was done. Your username is {$olddata['User']['username']} and your new password is: {$newdata['User']['password']}\nPlease contact your administrator if you didn't make this request.";
			$smsText = urlencode($message);

			$url = "http://78.46.17.110/app/smsapi/index.php?key=5bd18d48532d6&type=text&title=&contacts={$numbers}&groupid=&senderid=MAFFINS&msg={$smsText}&time=&time_zone=";

			$mystring = $this->get_data($url);
	  }
}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function editadmin($id = null) {

        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }

        //debug($this->request->data);die;

        if ($this->request->is(array('post', 'put'))) {
            if(empty($this->request->data['User']['password']))
            {
                unset($this->request->data['User']['password']);
            } else {
                //$this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);
            }

            //print_r($this->request->data);die;
            if ($this->User->save($this->request->data)) {

                $this->loadModel('AuditTrail');

                $auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
                $auditTrail['AuditTrail']['event_description'] = "Edited user with id ".$this->request->data['User']['id'].' and surname '.$this->request->data['User']['sname'];

                $auditTrail['AuditTrail']['contents'] = "Edted user";
                if( !$this->AuditTrail->save($auditTrail))
                {
                    die('There was a problem trying to save the audit trail');
                }

                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        $departments = $this->User->Department->find('list');
        $userTypes = $this->User->UserType->find('list');
        $this->set(compact('departments', 'userTypes'));
    }

    public function forgotpassword()
    {
        $this->layout = 'login-layout';

        if ($this->Auth->user('id')) {
            return $this->redirect(array(
                'controller' => 'users',
                'action' => 'logout'
            ));
        }

        if ($this->request->is('post')) {
            $this->loadModel('AuditTrail');

            //Save the audit trail
            $this->loadModel('AuditTrail');

            $auditTrail['AuditTrail']['user_id'] = 0;
            $auditTrail['AuditTrail']['event_description'] = "Trying to reset password with email ".$this->request->data['User']['email'];

            //Next check if the email actually exist
            //if it does exist then, generate the code
            //And send it to the registered sms

            $user = $this->User->find('first', array(
                'conditions' => array('User.email' => $this->request->data['User']['email'])
            ));
            if ($user['User']['email'] == $this->request->data['User']['email']){
                //Generate Code and save it in database, then move on to page to reset the password
                $code = mt_rand(100000,999999);
                //Save it in the database agains the user then sms it to the same user.
                //I need the user id so i get the user details$user = $this->User->find('first', $conditions);
                $this->User->id = $user['User']['id'];

                $this->User->saveField('resetcode', $code);

                //Now sms the code to the user
                $smsText = urlencode($code);
                $numbers = $user['User']['cellnumber'];
                if(strlen($numbers) == '11')
                {
					$url = "http://148.251.196.36/app/smsapi/index.php?key=5c6d72f0f094d&type=text&contacts={$numbers}&senderid=Matjabheng&msg={$smsText}&time=";

                    //$url = "http://148.251.196.36/app/smsapi/index.php?key=58e35a737fb7d&type=text&contacts={$numbers}&senderid=Matjabheng&msg={$smsText}&time=";
                    //echo $url."<br />";
                    $mystring = $this->get_data($url);
                    //echo $mystring; die;
                    //Now redirect to the page where the reset password can be entered
                    return $this->redirect(array('action' => 'smscode', $user['User']['id']));

                } else {
                    $this->Flash->error(__('The cellnumber on record '.$numbers.' is not valid please contact the administrator for assistance'));
                    return $this->redirect(array('action' => 'login'));
                }

            } else {
                $this->Flash->error(__('The email address ('.$this->request->data['User']['email'].') entered was not found please contact the administrator for assistance'));
                return $this->redirect(array('action' => 'login'));
            }
        }
    }

    public function smscode($user_id)
    {
        if ($this->request->is('post')) {
            //First retrieve the save code

            $options1 = array('conditions' => array('User.' . $this->User->primaryKey => $this->request->data['User']['user_id']));
            $user  = $this->User->find('first', $options1);

            //Now compare the code entered vs the code saved
            if($this->request->data['User']['resetcode'] == $user['User']['resetcode'])
            {
                return $this->redirect(array('action' => 'newpassword', $this->request->data['User']['user_id']));
            } else {
                $this->Flash->error(__('The reset code ('.$this->request->data['User']['resetcode'].') entered was not found please contact the administrator for assistance'));
                return $this->redirect(array('action' => 'smscode', $this->request->data['User']['user_id']));
            }
        }
        $this->set('user_id', $user_id);
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

    public function newpassword($user_id = null)
    {
        if ($this->request->is('post')) {

           if($this->request->data['User']['password'] != $this->request->data['User']['password1'])
           {
               $this->Flash->error(__('The confirm password does not match the first password.'));
               return $this->redirect(array('action' => 'newpassword'));
           }

            unset($this->request->data['User']['password1']);

            $this->User->id = $this->request->data['User']['user_id'];
            //$passwordHasher = new BlowfishPasswordHasher();
           // $this->request->data['User']['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
            $this->User->saveField('password', $this->request->data['User']['password']);

            $Email = new CakeEmail();

            $this->loadModel('User');
            $options1 = array('conditions' => array('User.' . $this->User->primaryKey => $this->request->data['User']['user_id']));
            $user  = $this->User->find('first', $options1);

            $subject = "Matjhabeng Local Municipality - Password reset successful";

            $Email->from(array('no-reply@matjhabeng.co.za' => 'Matjhabeng Local Municipality Document Management System'))
                ->template('passwordreset', 'default')
                ->emailFormat('html')
                ->viewVars(array('details' => 'Password reset successfull', 'password' => $this->request->data['User']['password'], 'user' => $user))
                ->to($user['User']['email'])
								->bcc('maffins@gmail.com')
								->bcc('mapaepae@gmail.com')
			          ->subject($subject)
                ->send();

								$this->sendnewlogins($this->request->data, $this->User->find('first', $options1) );

            $this->Flash->success(__('Your password has been reset successfully, please with your recent password.'));
            return $this->redirect(array('action' => 'login'));
        }
        $this->set('user_id', $user_id);
	}
	

		/**
	 * sections method
	 *
	 * @return void
	 */
	public function removeuser($user_id, $sectionid) {
		//Disable the layout
		$this->layout = false;
		//Get the user first
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $user_id));
		$user = $this->User->find('first', $options);
		$sections = unserialize($user['User']['sections']);
		//Return the difference without the section to be removed for that user
		$sections = array_diff($sections, [$sectionid]);

		//Now serialize this and save again
		$data['User']['sections'] = serialize($sections);
		$data['User']['id'] = $user_id;
		//Now remove the section from this user

		if ($this->User->save($data)) {

			$this->loadModel('AuditTrail');

			$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
			$auditTrail['AuditTrail']['event_description'] = "User removed from section with id ".$sectionid;

			$auditTrail['AuditTrail']['contents'] = "user removed from section";
			if( !$this->AuditTrail->save($auditTrail))
			{
				die('There was a problem trying to save the audit trail');
			}
			//1
			$this->Flash->success(__('User successfully removed from section.'));
			return $this->redirect(array('controller' => 'Sections', 'action' => 'sectionusers', $sectionid));
		} else {
			$this->Flash->error(__('The user could not be removed from the section. Please, try again.'));
		}
	}

	public function suppress ($user_id) {
		$this->layout = false;
		$user['User']['suppressed'] = 1;
		$this->User->id = $user_id;
		$this->User->save($user);

		$this->loadModel('AuditTrail');
		$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
		$auditTrail['AuditTrail']['event_description'] = "User with id ".$user_id.' has been disabled to receive any notifications';

		$auditTrail['AuditTrail']['contents'] = "User successfully suppresed";
		if( !$this->AuditTrail->save($auditTrail))
		{
			die('There was a problem trying to save the audit trail');
		}

		$this->Flash->success(__('User successfully suppressed.'));
		return $this->redirect(array('action' => 'suppressusers', $sectionid));		
	}

	public function removesuppression ($user_id) {
		$this->layout = false;
		$user['User']['suppressed'] = 0;
		$this->User->id = $user_id;
		$this->User->save($user);

		$this->loadModel('AuditTrail');
		$auditTrail['AuditTrail']['user_id'] = $this->Auth->user('id');
		$auditTrail['AuditTrail']['event_description'] = "User with id ".$user_id.' has been allowed to receive any notifications again.';

		$auditTrail['AuditTrail']['contents'] = "User successfully enabled to receive messages";
		if( !$this->AuditTrail->save($auditTrail))
		{
			die('There was a problem trying to save the audit trail');
		}

		$this->Flash->success(__('User successfully suppressed.'));
		return $this->redirect(array('action' => 'suppressed', $sectionid));		
	}

}
