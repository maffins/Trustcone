<style>
		.paginate_button {
				padding: 5px;
				background-color: yellow;
				font-weight: bold;
				margin: 3px;
				border: 1px solid black;
		}
		ul {
				list-style-type: none;
				margin: 0;
				padding: 0;
				overflow: hidden;
				background-color: #333333;
		}

		li {
				float: left;
		}

		li a {
				display: block;
				color: white !important;
				text-align: center;
				padding: 16px;
				text-decoration: none;
		}

		li a:hover {
				background-color: #111111;
		}
		h2 {
			width: 35%;
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
<div class="overtimes index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Overtimes Report for Manager'); ?></h1>
				<h4>Department - <?php echo $department_name?></h4>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h5><?php echo __('Search filters'); ?></h5>
				<?php echo $this->Form->create('Overtime', array('role' => 'form')); ?>
					<table class="table-striped">
						<tr>
							<td>Select Month</td>
							<td>
								<div class="form-group">
									<?php echo $this->Form->select('months', $months, ['class' => 'form-control', 'style' => 'width: 150px !important']);?>
								</div>
							</td>
							<td>Select Department</td>
							<td>
								<div class="form-group">
									<?php echo $this->Form->select('departments', $departments, ['class' => 'form-control', 'style' => 'width: 150px !important']);?>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<div class="form-group">
									<?php echo $this->Form->submit(__('Filter >>'), array('class' => 'btn btn-default')); ?>
								</div>
							</td>
					</tr>
					<?php echo $this->Form->end() ?>
					</table>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->
	<div class="row">

		<div class="col-md-12">
			<table cellpadding="0" cellspacing="0" class="table table-striped" style="margin: 0 auto" id="fidu-tables">
				<thead>
					<tr>
						<th ><?php echo __('id'); ?></th>
						<th ><?php echo __('Overtime Requester'); ?></th>
						<th ><?php echo __('Level'); ?></th>
						<th ><?php echo __('Reason'); ?></th>
						<th ><?php echo __('Overtime Date'); ?></th>
						<th ><?php echo __('start_time'); ?></th>
						<th ><?php echo __('end_time'); ?></th>
						<th ><?php echo __('Pay Number'); ?></th>
						<th ><?php echo __('Work done'); ?></th>
						<th style="display:none" ><?php echo __('created'); ?></th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($overtimes as $overtime): ?>
					<tr>
						<td ><?php echo h($overtime['Overtime']['id']); ?>&nbsp;</td>
								<td>
			<?php echo $this->Html->link($overtime['User']['fname'].' '.$overtime['User']['sname'], array('controller' => 'users', 'action' => 'view', $overtime['User']['id'])); ?>
		</td>
		<td >
			<?php
				if($overtime['Overtime']['tracker'] == 0) {
					echo "<b>Initial Stage</b> <br />";
			  }
				if($overtime['Overtime']['tracker'] == 1) {
					echo "<b>Management</b> <br />";
			  }
				if($overtime['Overtime']['tracker'] == 2) {
					echo "<b>Director </b> <br />";
			  }
				if($overtime['Overtime']['tracker'] == 3) {
					echo "<b>Salaries </b> <br />";
			  }
				echo $overtime['Department']['name'];
			?>&nbsp;
	 </td>
	<td >
					<?php
						foreach($overtime['OvertimeReason'] as $docTracker) {
							echo h($docTracker['reason']).'<br />---------------<br/>';
						}
					 ?></td>
						<td ><?php echo h($overtime['Overtime']['overtime_date']); ?>&nbsp;</td>
						<td ><?php echo h($overtime['Overtime']['start_time']); ?>&nbsp;</td>
						<td ><?php echo h($overtime['Overtime']['end_time']); ?>&nbsp;</td>
						<td ><?php echo h($overtime['Overtime']['pay_number']); ?>&nbsp;</td>
						<td ><?php echo h($overtime['Overtime']['whatsdone']); ?>&nbsp;</td>
						<td style="display:none" ><?php echo h($overtime['Overtime']['created']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $overtime['Overtime']['id']), array('escape' => false)); ?>
							<?php if($overtime['Overtime']['tracker'] == 0) { echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $overtime['Overtime']['id']), array('escape' => false)); } ?>
							<?php if($overtime['Overtime']['tracker'] == 0) { echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $overtime['Overtime']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $overtime['Overtime']['id'])); } ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>


		</div> <!-- end col md 9 -->
	</div><!-- end row -->


</div><!-- end containing of content -->

<script>

    $(document).ready(function() {
        $('#fidu-tables').DataTable();
    } );



function archive(id) {

    $.ajax({
        url: "<?php echo Router::url(['controller' => 'Overtimes', 'action' => 'finalclose', true]); ?>",
        cache :false,
        type: 'POST',
        data: {
            id: id
        },
        success: function(data) {
            alert('Document succesfully archived');
						window.location.reload();
        },
        error: function(data) {
            alert('There is a problem in archiving your document for final time '+data);
        }
    });
}

function approveSave(id, checkboxID, tafuraID, checkboxDeclinedID) {
    if (document.getElementById(checkboxID).checked) {

        $.ajax({
            url: "<?php echo Router::url(['controller' => 'Overtimes', 'action' => 'approved', true]); ?>",
            cache :false,
            type: 'POST',
            data: {
                id: id,
            },
            success: function(data) {
                alert('Approval done and notifications sent to the owner and the secretaray');
                document.getElementById(checkboxID).setAttribute('disabled', 'disabled');
                document.getElementById(checkboxDeclinedID).setAttribute('disabled', 'disabled');
                document.getElementById(tafuraID).style.backgroundColor = 'green';
            },
            error: function(data) {
                alert('There is a problem approve save  '+data);
            }
        });
    }
}

</script>
