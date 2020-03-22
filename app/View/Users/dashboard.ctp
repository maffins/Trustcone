<div class="container-fluid">
	<?php
	    $logged_user = AuthComponent::user();
	    $permissions = unserialize($logged_user['permissions']);
	    $controller = $this->params['controller'];
	?>
	<style>
		.rounded {
			width: 450px;
			float: left;
			margin: 20px;
		}
		.panel-heading {
			padding: 5px !important;
		}
		.alert {
			margin-bottom: 10px;
		}
		.rounded {
			height: 150px;
		}
	</style>
	<div class="alert alert-info">
  <strong>DASHBOARD</strong>
</div>
<?php
		$allControllers[0] = '-- Select Committe --';
		$allControllers['CounsilorDocuments'] = 'Counsilor Documents';
		$allControllers['Notices'] = 'Councillors Notices';
		$allControllers['MaycoDocuments'] = 'Mayco Documents';
		$allControllers['ExcoDocuments'] = 'ExcoDocuments';
		$allControllers['LedDocuments'] = 'Led, Small Bus, Spatial Planning & Land Use Management';
		$allControllers['FinanceDocuments'] = 'Finance Documents';
		$allControllers['InfrastructureTechnicalServices'] = 'Infrastructure Technical Services';
		$allControllers['CommunityServices'] = 'Community Services';
		$allControllers['PublicSafityDocuments'] = 'PublicSafityDocuments';
		$allControllers['EightyDocuments'] = 'Eighty Documents';
		$allControllers['SpotsArtsCultureDocuments'] = 'Spots Arts Culture Documents';
		$allControllers['CorporateServicesDocuments'] = 'Corporate Services Documents';
		$allControllers['IdpPolicyMonitoringDocuments'] = 'Idp Policy Monitoring Documents';
		$allControllers['MpacDocuments'] = 'Mpac Documents';
		$allControllers['DisputeResolutionDocuments'] = 'Dispute Resolution Documents';
		$allControllers['RulesDocuments'] = 'Rules Documents';
		$allControllers['ChairDocuments'] = 'Chair Documents';
		$allControllers['AuditDocuments'] = 'Audit Documents';
		$allControllers['DermacationDocuments'] = 'Dermacation Documents';
		$allControllers['PoliticalDocuments'] = 'Political Documents';
		$allControllers['RevenueDocuments'] = 'Revenue Documents';
		$allControllers['AdhocCommittees'] = 'Adhoc Documents';
		$allControllers['RiskDocuments'] = 'Risk Management Documents';
		$allControllers['TourismDocuments'] = 'Tourism, Environment Affairs and Agriculture';
		$allControllers['HumanDocuments'] = 'Human Settlement Committee';
		$allControllers['LlfDocuments'] = 'Llf Committee';
		$allControllers['SpecialPrograms'] = 'Special Programs';

?>
<div class="panel panel-default rounded border border-warning">
	<div class="panel-heading">MANAGE COMMITTEE</div>
	<div class="panel-body">
		<?php echo $this->Form->create('CommiteeManagement', array('role' => 'form', 'enctype' => 'multipart/form-data')); ?>

		<?php echo $this->Form->input('committees',array('type'=>'select','options'=>$allControllers, 'label'=>'Select Committee')); ?>
<br />
		<?php echo $this->Form->end(__('View')); ?>
	</div>
</div>

	<div class="panel panel-default rounded border border-warning">

	  <div class="panel-heading">USER MANAGEMENT</div>
	  <div class="panel-body">
			<?php if( in_array(17, $permissions) ):?>
				<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('USERS'), array('controller' => 'Users', 'action' => 'index'), array('escape' => false)); ?>
				<br />
				<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('USERS TYPES'), array('controller' => 'UserTypes', 'action' => 'index'), array('escape' => false)); ?>
				<br />
				<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('USERS SECTIONS'), array('controller' => 'Sections', 'action' => 'index'), array('escape' => false)); ?>
				<br />
				<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('USERS USAGE REPORT'), array('controller' => 'Users', 'action' => 'usage'), array('escape' => false)); ?>
				<br />
				<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('SUPPRESS NOTIFICATIONS'), array('controller' => 'Users', 'action' => 'suppressed'), array('escape' => false)); ?>

			<?php endif ?>
		</div>
  </div>
	<div class="panel panel-default rounded border border-warning">
		<div class="panel-heading">OVERTIME MANAGEMENT</div>
			<div class="panel-body">
					<?php if( in_array(162, $permissions) ):?>
					<?php echo $this->Html->link('<span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;'.__('DIRECTORATES'), array('controller' => 'Departments', 'action' => 'index'), array('escape' => false)); ?> </li>
					<?php endif?>
						<br />
					<?php if( in_array(163, $permissions) ):?>
						<?php echo $this->Html->link('<span class="glyphicon glyphicon-tower"></span>&nbsp;&nbsp;'.__('UNITS'), array('controller' => 'DepartmentSections', 'action' => 'index'), array('escape' => false)); ?> </li>
					<?php endif?>
			</div>

	</div>
		<div class="panel panel-default rounded border border-warning">
		  <div class="panel-heading">REPORTS</div>
		  <div class="panel-body">
				<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('PRE-OVERTIME'), array('controller' => 'Preovertimes', 'action' => 'report'), array('escape' => false)); ?>
					<br />
				<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('OVERTIME'), array('controller' => 'Overtimes', 'action' => 'report',1), array('escape' => false)); ?>
					<br />
				<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('AUDIT TRAIL'), array('controller' => 'AuditTrails', 'action' => 'index'), array('escape' => false)); ?>
  		</div>
		</div>


		<br style="clear:both" />
			<hr style="display:block" />

</div>
<script type="">
	function getControllerSend(){
		var Controller = $('#CommiteeManagementCommittees').val();
		window.location.href  = '/documentstracker.co.za/'+Controller+'/committeedetails';
		return false;
	}
</script>
