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

<?php
		$allControllers[0] = '-- Select Committe --';
		$allControllers['CounsilorDocuments'] = 'Counsilor Documents';
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

		$manager_approvers  = ['6' => 146, '1' => 147, '2' => 161, '5' => 148, '13' => 149, '3' => 150, '7' => 151, '8' => 152, '9' => 153 ];
		//This is for the permissions now
		$director_approvers = ['6' => 116, '1' => 119, '2' => 160, '5' => 122, '13' => 125, '3' => 128, '7' => 131, '68' => 134, '9' => 137 ];


?>
<div class="panel panel-default rounded border border-warning">
	<div class="panel-heading">OVERTIMES</div>
	<div class="panel-body">
		<?php if( in_array(154, $permissions) ):?>
				<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('PRE APPROVAL OVERTIMES'), array('controller' => 'OvertimeRequesters', 'action' => 'index'), array('escape' => false)); ?>
		<?php endif?>
	<br />
		<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('OVERTIMES'), array('controller' => 'Overtimes', 'action' => 'index'), array('escape' => false)); ?>
	<br />
			<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('PRE-OVERTIME REPORT'), array('controller' => 'Preovertimes', 'action' => 'report'), array('escape' => false)); ?>
				<br />
			<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('OVERTIME REPORT'), array('controller' => 'Overtimes', 'action' => 'report'), array('escape' => false)); ?>

		<div style='display:none'>
		<?php if( in_array(112, $permissions) ):?>
				<li style="height: 61px !important;<?php if($controller == 'Overtimes'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('SALARIES'), array('controller' => 'Overtimes', 'action' => 'salaries'), array('escape' => false)); ?> </li>
		<?php endif?>
		<?php if( in_array(112, $permissions) ):?>
				<li style="<?php if($controller == 'Overtimes'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;'.__('OVERTIME REPORT'), array('controller' => 'Overtimes', 'action' => 'cforeport'), array('escape' => false)); ?> </li>
		<?php endif?>
		<?php if( array_intersect($manager_approvers, $permissions) ):?>
				<li style="<?php if($controller == 'Overtimes'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;'.__('OVERTIME REPORT'), array('controller' => 'Overtimes', 'action' => 'managerreport'), array('escape' => false)); ?> </li>
		<?php endif?>
		<?php if( array_intersect($director_approvers, $permissions)  ):?>
				<li style="<?php if($controller == 'Overtimes'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;'.__('OVERTIME REPORT'), array('controller' => 'Overtimes', 'action' => 'directorreport'), array('escape' => false)); ?> </li>
		<?php endif?>
</div>
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
