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
		height: 200px;
	}
</style>
<script>
function escalate(id, decision, tracker) {

		var comment = '';
		var declinecomme = "decline"+id; //close the comment box if for some reason the person decides to approve
		//Check if its declined then open the comment box if its empty
		if(decision == 2) {
			//Now check if we have a comment already
			var commentboxid = "declinecomment"+id;
			var comment = document.getElementById(commentboxid).value;
			if(!comment){
				//now open the box to enter the comment
				document.getElementById(declinecomme).style.display = 'block';
				return false;
			}
		} else {
				document.getElementById(declinecomme).style.display = 'none';
		}

		 $.ajax({
				 url: "<?php echo Router::url(['controller' => 'Overtimes', 'action' => 'escalate', true, tracker]); ?>",
				 cache :false,
				 type: 'POST',
				 data: {
						 id: id,
						 decision: decision,
						 comment: comment,
				 },
				 success: function(data) {
					 if(decision == 1)
					 {
						 alert('Approved and escalated');
					 } else {
						 alert('Declined and sent back to the requester');
					 }
					 window.location.reload();
				 },
				 error: function(data) { alert(data);return;
						 alert('There is a problem with savign the information '+data);
				 }
		 });

	}
</script>
<?php
    $logged_user = AuthComponent::user();
    $permissions = unserialize($logged_user['permissions']);
?>
<div class="overtimes index">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Overtimes Reports'); ?></h1>
				<h4>
					<?php if($approver == 1):?>
						Managers view
					<?php endif;?>
					<?php if($approver == 2):?>
						Director view
					<?php endif;?>
					<?php if($approver == 3):?>
						Salaries view
					<?php endif;?>
					<?php if($approver == 4):?>
						CFO view
					<?php endif;?>
					<?php if($approver == 5):?>
						Municipal Manager View
					<?php endif;?>
				</h4>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->
	<div class="row">
		<div class="panel panel-default rounded border border-warning">
			<div class="panel-heading" style="padding:15px !important;font-weight:bold">PRE-OVERTIME REPORTS</div>
			<div class="panel-body">
				<?php if($approver == 1 || $approver == 2 || $approver == 4):?>
					<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('PRE-OVERTIME MANAGER REPORT'), array('controller' => 'Preovertimes', 'action' => 'report', $approver), array('escape' => false)); ?>
					<br />
				<?php endif;?>
				<?php if($approver == 2 || $approver == 4):?>
				<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('PRE-OVERTIME DIRECTOR REPORT'), array('controller' => 'Preovertimes', 'action' => 'directorreport', $approver), array('escape' => false)); ?>
					<br />
				<?php endif;?>
				<?php if($approver == 1 || $approver == 2 || $approver == 4):?>
				<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('SUMMARY REPORT'), array('controller' => 'Preovertimes', 'action' => 'summaryreport', $approver), array('escape' => false)); ?>
				<?php endif;?>
			</div>
		</div>

		<div class="panel panel-default rounded border border-warning">
			<div class="panel-heading" style="padding:15px !important;font-weight:bold">OVERTIME REPORTS</div>
			<div class="panel-body">
				<?php if($approver == 4 || $approver == 5):?>
					<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('APPROVED OVERTIME REPORTS - CFO & MM'), array('controller' => 'Overtimes', 'action' => 'index'), array('escape' => false)); ?>
					<br />
				<?php endif;?>
					<?php if($approver == 1 || $approver == 2 || $approver == 4 || $approver == 5):?>
						<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('OVERTIME MANAGER REPORT'), array('controller' => 'Overtimes', 'action' => 'report', $approver), array('escape' => false)); ?>
						<br />
					<?php endif;?>
				<?php if($approver == 2 || $approver == 4 || $approver == 5):?>
					<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('OVERTIME DIRECTOR REPORT'), array('controller' => 'Overtimes', 'action' => 'directorreport', $approver), array('escape' => false)); ?>
					<br />
				<?php endif;?>
				<?php if($approver == 4 || $approver == 5):
							if($approver == 4) {
								$who = 'CFO REPORT';
							} else {
								$who = 'MUNICIPAL MANAGER REPORT';
							}
					?>
					<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__($who), array('controller' => 'Overtimes', 'action' => 'cforeport', $approver), array('escape' => false)); ?>
					<br />
				<?php endif;?>
				<?php if($approver == 5):?>
					<?php //echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('MUNICIPAL MANAGER REPORT'), array('controller' => 'Overtimes', 'action' => 'mmreport', $approver), array('escape' => false)); ?>
					<br />
				<?php endif;?>
				<?php if($approver == 1 || $approver == 2 || $approver == 4):?>
					<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('SUMMARY REPORT'), array('controller' => 'Overtimes', 'action' => 'summaryreport', $approver), array('escape' => false)); ?>
			<?php endif;?>
			</div>
		</div>

	</div><!-- end row -->

</div><!-- end containing of content -->
