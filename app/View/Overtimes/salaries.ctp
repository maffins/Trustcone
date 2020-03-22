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
				<h1><?php echo __('Salaries Department: - Approved Overtimes'); ?></h1>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->
	<div class="page-header">
		<h5><?php echo __('Search filters'); ?></h5>
		<?php echo $this->Form->create('Overtime', array('role' => 'form')); ?>
			<table class="table-striped">
				<tr>
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
	<div class="row">

		<div class="col-md-12">
			<table cellpadding="0" cellspacing="0" class="table table-striped" style="margin: 0 auto" id="fidu-tables">
				<thead>
					<tr>
						<th ><?php echo __('Overtime Requester'); ?></th>
						<th>Approved Hours</th>
						<th>Approved Amount(R)</th>
						<th ><?php echo __('Send for payment'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($overtimes as $overtime): ?>
					<tr>
								<td>
			<?php echo $this->Html->link($overtime['OvertimeRequester']['first_name'].' '.$overtime['OvertimeRequester']['last_name'], array('controller' => 'Overtimes', 'action' => 'view', $overtime['Overtime']['id'])); ?>
		</td>
		<td><?php echo $overtime[0]['total_sum']?></td>
		<td><?php echo $overtime[0]['total_rate']?></td>
			<td >
				<input type="button" value="Send" onclick="salariesprocessed('<?php echo $overtime['Overtime']['id']?>')">
				</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<br style="clear:both" />
			<br style="clear:both" />

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
		            alert('The salary was successfully processed');
								window.location.reload();
		        },
		        error: function(data) {
		            alert('There was a problem in archiving this overtime '+data);
		        }
		    });
		}

		function salariesprocessed(id) {

		    $.ajax({
		        url: "<?php echo Router::url(['controller' => 'Overtimes', 'action' => 'salariesprocessed', true]); ?>",
		        cache :false,
		        type: 'POST',
		        data: {
		            id: id
		        },
		        success: function(data) {
		            alert('The salary was successfully processed');
								window.location.reload();
		        },
		        error: function(data) {
		            alert('There is a problem in closing this overtime '+data);
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
