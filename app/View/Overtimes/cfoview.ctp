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
function escalatecfo(id, decision, total_hours, total_amount, month) {

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
			if(!confirm("Are you sure you want to save the reason for declining this request!")) {
				return false;
			}

		} else {
				document.getElementById(declinecomme).style.display = 'none';
		}
alert('id '+id+' decision '+decision+' comment '+comment+' total hours '+total_hours+' total amount '+total_amount+' month '+month);
		 $.ajax({
				 url: "<?php echo Router::url(['controller' => 'Overtimes', 'action' => 'escalatecfo', true, tracker]); ?>",
				 cache :false,
				 type: 'POST',
				 data: {
						 id: id,
						 decision: decision,
						 comment: comment,
						 total_hours: total_hours,
						 total_amount: total_amount,
						 month: month
				 },
				 success: function(data) {
					 if(decision == 1)
					 {
						 alert('Approved and sent to employee, uploader and to the salaries department.');
					 } else {
						 alert('Declined and sent back to employee, uploader and to the salaries department.');
					 }
					 window.location.reload();
				 },
				 error: function(data) { alert(data);return;
						 alert('There is a problem with saving your decision '+data);
				 }
		 });

	}
</script>

<div class="overtimeRequesters index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('CFO VIEW'); ?></h1>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->

	<div class="row">

		<div class="col-md-12">

			<table cellpadding="0" cellspacing="0" class="table table-striped" style="margin: 0 auto" id="fidu-tables">
				<thead>
					<tr>
						<th ><?php echo __('Name'); ?></th>
						<th ><?php echo __('cellnumber'); ?></th>
						<th ><?php echo __('Salary Number'); ?></th>
						<th ><?php echo __('Department'); ?></th>
						<th ><?php echo __('section'); ?></th>
						<th ><?php echo __('town'); ?></th>
						<th ><?php echo __('email'); ?></th>
						<th ><?php echo __('Month approved'); ?></th>
						<th ><?php echo __('Total Hours'); ?></th>
						<th ><?php echo __('Total Mount'); ?></th>
						<th ><?php echo __('Decision'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($overtimeRequesters as $overtimeRequester): ?>
					<tr>
						<td >
							<?php echo $this->Html->link($overtimeRequester['OvertimeRequester']['first_name'].' '.$overtimeRequester['OvertimeRequester']['last_name'], array('controller' => 'Overtimes', 'action' => 'overtimeitems', $overtimeRequester['OvertimeRequester']['id'], $overtimeRequester['Overtime'][0]['tracker'])); ?>
						</td>
						<td ><?php echo h($overtimeRequester['OvertimeRequester']['cellnumber']); ?>&nbsp;</td>
						<td ><?php echo h($overtimeRequester['OvertimeRequester']['salary_number']); ?>&nbsp;</td>
						<td>
							<?php echo $this->Html->link($overtimeRequester['Department']['name'], array('controller' => 'departments', 'action' => 'view', $overtimeRequester['Department']['id'])); ?>
						</td>
						<td ><?php echo h($overtimeRequester['OvertimeRequester']['section']); ?>&nbsp;</td>
						<td ><?php echo h($overtimeRequester['OvertimeRequester']['town']); ?>&nbsp;</td>
						<td ><?php echo h($overtimeRequester['OvertimeRequester']['email']); ?>&nbsp;</td>
						<td ><?php echo h($months[$overtimeRequester['Preovertime'][0]['overtime_month']]); ?>&nbsp;</td>

						<td ><?php
							$total_hours = 0;
							$total_amoun = 0;
								foreach($overtimeRequester['Overtime'] as $reqeuesters) {
									$total_hours += $reqeuesters['total_hours'];
									$total_amoun += $reqeuesters['rate'];
								}
							echo h($total_hours); ?>&nbsp;
						</td>
						<td ><?php echo h($total_amoun); ?>&nbsp;</td>
						<td >
							<table>
								<tr>
									<td>Approve and send</td>
									<td><input type="radio" name="escalatecfo<?php echo $overtimeRequester['OvertimeRequester']['id'] ?>" id="escalatecfo<?php echo $overtimeRequester['OvertimeRequester']['id'] ?>" onclick='escalatecfo("<?php echo $overtimeRequester['OvertimeRequester']['id']?>", "1", "<?php echo $total_hours?>", "<?php echo $total_amoun?>", "<?php echo h($months[$overtimeRequester['Preovertime'][0]['overtime_month']]); ?>")'></td>
								</tr>
								<tr>
									<td>Decline</td>
									<td>
										<input type="radio" name="escalatecfo<?php echo $overtimeRequester['OvertimeRequester']['id'] ?>" id="escalatecfo<?php echo $overtimeRequester['OvertimeRequester']['id'] ?>" onclick='escalatecfo("<?php echo $overtimeRequester['OvertimeRequester']['id'] ?>", "2", "<?php echo $total_hours?>", "<?php echo $total_amoun?>", "<?php echo h($months[$overtimeRequester['Preovertime'][0]['overtime_month']]); ?>")'>
										<div id="decline<?php echo $overtimeRequester['OvertimeRequester']['id'] ?>" style="display: none">
												<textarea name="declinecomment<?php echo $overtimeRequester['OvertimeRequester']['id'] ?>" id="declinecomment<?php echo $overtimeRequester['OvertimeRequester']['id'] ?>"></textarea>
												<input type="button" value="Save reason of decline"  onclick='escalatecfo("<?php echo $overtime['OvertimeRequester']['id']  ?>", "2", "<?php echo $total_hours?>", "<?php echo $total_amoun?>", "<?php echo h($months[$overtimeRequester['Preovertime'][0]['overtime_month']]); ?>")'>
										</div>
									</td>
								</tr>
							</table>
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
</script>
