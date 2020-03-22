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
			if(!confirm("Are you sure you want to decline this request!")) {
				return false;
			}
		} else {
				document.getElementById(declinecomme).style.display = 'none';
				if(!confirm("Are you sure you want to approve this requests")) {
					return false;
				}
		}

		 $.ajax({
				 url: "<?php echo Router::url(['controller' => 'Preovertimes', 'action' => 'escalate', true, tracker]); ?>",
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
						 alert('Approved and escalated ');
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

<div class="preovertimes index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Pre Overtime Requests for: ').$requester['overtime_requesters']['first_name'].' '.$requester['overtime_requesters']['last_name'];?></h1>
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
					</h4>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->


	<div class="row">
<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span><< Back', array('controller' => 'OvertimeRequesters', 'action' => 'index'), array('escape' => false)); ?>

<?php
	if($preovertime['Preovertime']['tracker'] == 0) {
?>
		<div class="col-md-3" style="display:none">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Actions'); ?></div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New Request'), array('action' => 'add', $id), array('escape' => false)); ?></li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->
<?php } ?>

		<div class="col-md-12">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
						<th ><?php echo __('Tracker'); ?></th>
						<th ><?php echo __('Month'); ?></th>
						<th ><?php echo __('Weekday'); ?></th>
						<th ><?php echo __('Saturday'); ?></th>
						<th ><?php echo __('Sunday'); ?></th>
						<th ><?php echo __('Public holiday'); ?></th>
						<th ><?php echo __('Reason'); ?></th>
						<th ><?php echo __('Total hours'); ?></th>
						<th ><?php echo __('Decision'); ?></th>
						<th ><?php echo __('created'); ?></th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
			  <?php $counter = 0;?>
				<?php foreach ($preovertimes as $preovertime): $counter++;?>
					<tr>
						<td ><?php
							if($preovertime['Preovertime']['tracker'] == 0){
								echo "Initial Stage";
							}
							if($preovertime['Preovertime']['tracker'] == 1){
								echo "Sent to manager";
							}
							if($preovertime['Preovertime']['tracker'] == 2){
								echo "Sent to director";
							}
							if($preovertime['Preovertime']['tracker'] == 11){
								echo "Declined by manager";
							}
							if($preovertime['Preovertime']['tracker'] == 12){
								echo "Declined by director";
							}

						?>&nbsp;</td>
						<td ><?php echo h($months[$preovertime['Preovertime']['overtime_month']].' '.$preovertime['Preovertime']['overtime_year']); ?>&nbsp;</td>
						<td ><?php echo $preovertime['Preovertime']['weekday'] ?>&nbsp;</td>
						<td ><?php echo $preovertime['Preovertime']['saturday'] ?>&nbsp;</td>
						<td ><?php echo $preovertime['Preovertime']['sunday'] ?>&nbsp;</td>
						<td ><?php echo $preovertime['Preovertime']['public_holiday'] ?>&nbsp;</td>
						<td ><?php echo h($preovertime['Preovertime']['whatsdone']); ?>&nbsp;</td>
						<td ><?php echo h($preovertime['Preovertime']['total_hours']); ?>&nbsp;</td>
						<td >
						<?php

							if(($preovertime['Preovertime']['tracker'] == 1 && $approver) || ($preovertime['Preovertime']['tracker'] == 2 && $approver)) {

								if($approver == 1) {
									if($preovertime['Preovertime']['tracker'] == 1) { //means nothign has been done yet so make a decision
									?>
										<table>
											<tr>
												<td>Approve and send</td>
												<td><input type="radio" name="escalate<?php echo $preovertime['Preovertime']['id'] ?>" id="escalate<?php echo $preovertime['Preovertime']['id'] ?>" onclick='escalate("<?php echo $preovertime['Preovertime']['id']?>", "1", "<?php echo $preovertime['Preovertime']['tracker']?>")'></td>
											</tr>
											<tr>
												<td>Decline</td>
												<td>
													<input type="radio" name="escalate<?php echo $preovertime['Preovertime']['id'] ?>" id="escalate<?php echo $preovertime['Preovertime']['id'] ?>" onclick='escalate("<?php echo $preovertime['Preovertime']['id'] ?>", "2", "<?php echo $preovertime['Preovertime']['tracker']?>")'>
													<div id="decline<?php echo $preovertime['Preovertime']['id'] ?>" style="display: none">
															<textarea name="declinecomment<?php echo $preovertime['Preovertime']['id'] ?>" id="declinecomment<?php echo $preovertime['Preovertime']['id'] ?>"></textarea>
															<input type="button" value="Save reason of decline"  onclick='escalate("<?php echo $preovertime['Preovertime']['id']  ?>", "2", "<?php echo $preovertime['Preovertime']['tracker']?>")'>
													</div>
												</td>
											</tr>
										</table>
						   <?php } else {
								 	if($preovertime['Preovertime']['tracker'] == 2) {
								?>
								  Approved and sent to Director
							<?php } else {
								?>
									Declined by manager
								<?php
									}
								}
							}

							if($approver == 2) {
								if($preovertime['Preovertime']['tracker'] == 2) { //means nothign has been done yet so make a decision
								?>
									<table>
										<tr>
											<td>Approve and send</td>
											<td><input type="radio" name="escalate<?php echo $preovertime['Preovertime']['id'] ?>" id="escalate<?php echo $preovertime['Preovertime']['id'] ?>" onclick='escalate("<?php echo $preovertime['Preovertime']['id']?>", "1", "<?php echo $preovertime['Preovertime']['tracker']?>")'></td>
										</tr>
										<tr>
											<td>Decline</td>
											<td>
												<input type="radio" name="escalate<?php echo $preovertime['Preovertime']['id'] ?>" id="escalate<?php echo $preovertime['Preovertime']['id'] ?>" onclick='escalate("<?php echo $preovertime['Preovertime']['id'] ?>", "2", "<?php echo $preovertime['Preovertime']['tracker']?>")'>
												<div id="decline<?php echo $preovertime['Preovertime']['id'] ?>" style="display: none">
														<textarea name="declinecomment<?php echo $preovertime['Preovertime']['id'] ?>" id="declinecomment<?php echo $preovertime['Preovertime']['id'] ?>"></textarea>
														<input type="button" value="Save reason of decline"  onclick='escalate("<?php echo $preovertime['Preovertime']['id']  ?>", "2", "<?php echo $preovertime['Preovertime']['tracker']?>")'>
												</div>
											</td>
										</tr>
									</table>
					   <?php } else {
							 	if($preovertime['Preovertime']['tracker'] == 3) {
							?>
							  Approved
						<?php } else {
							?>
								Declined by director
							<?php
								}
							}
						}?>
									<?php
								} else if($preovertime['Preovertime']['tracker'] == 3 || $preovertime['Preovertime']['tracker'] == 11 || $preovertime['Preovertime']['tracker'] == 10) {
										if ( $preovertime['Preovertime']['tracker'] == 3) {
											echo 'Overtime pre approval approved by Director';
											?>
												<br /><input type="button" value="In Overtime Stage" onclick="archive('<?php echo $preovertime['Preovertime']['id']?>')">
											<?php

										} else if ( $preovertime['Preovertime']['tracker'] == 10) {
											echo 'Declined by manager';
										} else if ( $preovertime['Preovertime']['tracker'] == 11) {
											echo 'Declined by director';
										}
										if(!$approver) {
									}
								}
						?>&nbsp;
					</td>
						<td ><?php echo h(substr($preovertime['Preovertime']['created'], 0, 10)); ?>&nbsp;</td>

						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $preovertime['Preovertime']['id'], $id), array('escape' => false)); ?>
							<?php
								if($preovertime['Preovertime']['tracker'] == 0){
							?>
								<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $preovertime['Preovertime']['id']), array('escape' => false)); ?>
								<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $preovertime['Preovertime']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $preovertime['Preovertime']['id'])); ?>
							<?php } ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="10">
							<div class="form-group">
								<?php
								if($counter > 0) {
									if($preovertime['Preovertime']['tracker'] == 0){
										echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>Send Pre Overtime to Manager', array('action' => 'sendPreovertime', $preovertime['OvertimeRequester']['id']), array('escape' => false));
									}
								} else {
									echo 'Currently no items';
								}
								?>
							</div>

						<?php echo $this->Form->end() ?>
						</td>
					</tr>
				</tfoot>
			</table>
			<?php
				if($preovertime['Preovertime']['tracker'] == 0 && $counter < 1){
			?>
				<fieldset>
	    		<legend>Capture hours for approvals</legend>
						<?php echo $this->Form->create('Preovertime', ['role' => 'form', 'action' => 'add']); ?>

							<div class="form-group">
								<?php echo $this->Form->input('overtime_requester_id', array('class' => 'form-control', 'type' => 'hidden', 'value' => $id, 'placeholder' => 'Overtime Requester Id'));?>
							</div>
							<div class="form-group">
								<?php echo $this->Form->input('overtime_year', array('class' => 'form-control', 'value' => date("Y"), 'readonly'));?>
							</div>
							<br style="clear:both" />
							<div class="form-group">
								<?php echo $this->Form->input('overtime_month', array('class' => 'form-control', 'placeholder' => 'Overtime Month', 'type' => 'select', 'options' => $months));?>
							</div>
							<br style="clear:both" />
							<div class="form-group">
								<?php echo $this->Form->input('weekday', array('class' => 'form-control', 'label' => 'Is it on a week day?', 'placeholder' => 'Number of hours'));?>
							</div>
							<br style="clear:both" />
							<div class="form-group">
								<?php echo $this->Form->input('saturday', array('class' => 'form-control', 'label' => 'Is it on a saturday?', 'placeholder' => 'Number of hours'));?>
							</div>
							<br style="clear:both" />
							<div class="form-group">
								<?php echo $this->Form->input('sunday', array('class' => 'form-control', 'label' => 'Is it on a sunday?', 'placeholder' => 'Number of hours'));?>
							</div>
							<br style="clear:both" />
							<div class="form-group">
								<?php echo $this->Form->input('public_holiday', array('class' => 'form-control', 'label' => 'Is it on a public holiday?', 'placeholder' => 'Number of hours'));?>
							</div>
							<div class="form-group sty" style="display:none">
								<?php echo $this->Form->input('total_hours', array('class' => 'form-control', 'placeholder' => 'Total Hours', 'onblur' => "goCalcluate"));?>
							</div>
							<br style="clear:both" />
							<div class="form-group">
								<?php echo $this->Form->input('whatsdone', array('class' => 'form-control', 'label' => 'Reason for overtime', 'placeholder' => 'Reason for overtime'));?>
							</div>
							<br style="clear:both" />
							<div class="form-group" id='buttondiv'>
								<?php echo $this->Form->button(__('Add Overtime'), array('class' => 'btn btn-default', 'id' => 'submitbutton', 'type' => 'button')); ?>
							</div>

						<?php echo $this->Form->end() ?>
					</fieldset>
				<?php
					}
		    ?>
			</div><!-- end col md 12 -->
	<br style="clear:both" />	<br style="clear:both" />	<br style="clear:both" />	<br style="clear:both" />	<br style="clear:both" />	<br style="clear:both" />
		</div> <!-- end col md 9 -->
	</div><!-- end row -->


</div><!-- end containing of content -->
<script>

$( "#submitbutton" ).click(function() {
	var total = 0;
	total = Number(total) + Number($("#PreovertimeWeekday").val());
	total = Number(total) + Number($("#PreovertimeSaturday").val());
	total = Number(total) + Number($("#PreovertimeSunday").val());
	total = Number(total) + Number($("#PreovertimePublicHoliday").val());

	if(total == 0) {
		alert('Cannot save zero pre overtime hours');
		return false;
	}

	if($("#PreovertimeWhatsdone").val() == "") {
		alert('Please enter the overtime that you intend to do.');
		return false;
	}

	$.ajax({
		  method: "POST",
		  url: "/Preovertimes/checktotals",
		  data: { total_hours: total, requester_id: $('#PreovertimeOvertimeRequesterId').val() }
		})
  .done(function( msg ) {
    if( msg == 0){
			$("#PreovertimeAddForm").submit();
		} else {
			//Disable everything
			alert("You have applied to work "+msg+" hours, unfortunately you are allowed to work 60 hours each month!!\n\n Please resubmit hours less or equal to 60!!");
			$('#PreovertimeWeekday').val("")
			$('#PreovertimeSaturday').val("")
			$('#PreovertimeSunday').val("")
			$('#PreovertimePublicHoliday').val("")
			$("#submitbutton").css('color','red');
		}
  });
});

function archive(id) {

    $.ajax({
        url: "<?php echo Router::url(['controller' => 'Preovertimes', 'action' => 'finalclose', true]); ?>",
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


</script>
