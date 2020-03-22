<div class="overtimes form">
<style>

</style>
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Edit Overtime'); ?></h1>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Actions'); ?></div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
									<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Overtimes'), array('action' => 'index'), array('escape' => false)); ?></li>
							</ul>
						</div>
					</div>
				</div>
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php
			$weekdaytotal = 0;
			$saturday = 0;
			$sunday = 0;
			$public_holiday = 0;
			foreach($nownow['Preovertime'] as $now){
				$weekdaytotal += $now['weekday'];
				$saturday     += $now['saturday'];
				$sunday += $now['sunday'];
				$public_holiday += $now['public_holiday'];
			}
			$prev = $this->Session->read('alldata');
			$this->Session->delete('alldata');

			$prev = $OvertimeReason['Overtime'];
			?>
		<fieldset>

				<table class="table-striped" width='55%'>
					<tr>
						<td colspan="3" style="text-align:center;padding:10px 0 0 0">
							<b>Below is the reason why it was declined:</b>
							<hr />
							<?php echo $OvertimeReason['OvertimeReason']['reason']?>
							<hr />
						</td>
					</tr>
				</table>
				<hr />
			<fieldset> 
			<?php echo $this->Form->create('Overtime', array('role' => 'form')); ?>
			<div class="form-group" style="display:none">
			<?php echo $this->Form->input('old_overtime_id', array('class' => 'form-control', 'type' => 'text', 'value' => $prev['id'], 'placeholder' => 'User Id'));?>
		 </div>
				<div class="form-group" style="display:none">
					<?php echo $this->Form->input('user_id', array('class' => 'form-control', 'value' => $prev['user_id'], 'placeholder' => 'User Id'));?>
				</div>
				<div class="form-group" style="display:none">
					<?php echo $this->Form->input('tracker', array('class' => 'form-control', 'value' => $tracker));?>
				</div>

					<?php echo $this->Form->hidden('overtime_requester_id', ['class' => 'form-control', 'type' => 'text', 'value' => $allrequesters['id'], 'label' => 'Employee']);?>


				<div class="form-group">
					<?php echo $this->Form->input('preovertime_id', ['class' => 'form-control', 'default' => $prev['preovertime_id'], 'options' => $preovertimes, 'label' => 'Pre Approved Overtimes']);?>
				</div>
				<br style="clear:both" />
				<div class="form-group">
					<?php echo $this->Form->input('period', array('class' => 'form-control', 'options' => $period, 'default' => $prev['period'], 'type' => 'select', 'label' => 'Day of work', 'placeholder' => 'Day of work'));?>
				</div>
				<br style="clear:both" />
				<div class="form-group">
					<?php echo $this->Form->input('overtime_date', array('class' => 'form-control datepicker', 'value' => $prev['overtime_date'], 'type' => 'text', 'placeholder' => 'Overtime Date'));?>
				</div>

				<br style="clear:both" />
				<div class="form-group">
					<?php echo $this->Form->input('start_time', array('type' => 'time', 'value' => $prev['start_time'], 'timeFormat' => 12, 'placeholder' => 'Start Time'));?>
				</div>
				<br style="clear:both" />
				<div class="form-group">
					<?php echo $this->Form->input('end_time', array('class' => '', 'value' => $prev['end_time'], 'timeFormat' => 12, 'placeholder' => 'End Time'));?>
				</div>

				<div class="form-group" style="display:none">
					<?php echo $this->Form->input('pay_number', array('class' => '', 'value' => $prev['pay_number'], 'placeholder' => 'Pay Number'));?>
				</div>
				<br style="clear:both" />
				<div class="form-group">
					<?php echo $this->Form->input('whatsdone', array('class' => 'form-control', 'value' => $prev['whatsdone'], 'placeholder' => 'Work Done', 'label' => 'Work Done'));?>
				</div>
				<?php if($type):?>
					<br style="clear:both" />
					<div class="form-group">
						<?php echo $this->Form->input('motivation', array('class' => 'form-control', 'value' => $prev['motivation'], 'placeholder' => 'Motivation why your time is over the limit', 'label' => 'Motivation'));?>
					</div>
				<?php endif;?>
				<br style="clear:both" />
				<div class="form-group">
					<?php echo $this->Form->button(__('Submit'), array('class' => 'btn btn-default', 'id' => 'submitbutton', 'type' => 'button')); ?>
				</div>

			<?php //echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
<?php
// $this->Js->get('#OvertimeOvertimeRequesterId')->event('change',
// 																											$this->Js->request( [ 'controller'=>'Overtimes', 'action'=>'getallpreovertime'],
// 																																					[ 'update'=>'#OvertimePreovertimeId', 'async' => true,
// 																																						'method' => 'post', 'dataExpression'=>true,
// 																																						'data'=> $this->Js->serializeForm( [ 'isForm' => true, 'inline' => true ])
// 																																					])
// 																																				);
 ?>
<script>
//Get Current Date
var date = new Date();

//Create Variable for first day of current month
var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);

//Create variable for last day of next month
var lastDay = new Date(date.getFullYear(), date.getMonth() + 2, 0);
//alert(lastDay+'the last day');
$( ".datepicker" ).datepicker({
	  format: 'yyyy-mm-dd',
		minDate: firstDay,
		maxDate: lastDay,
		//stepMonths: 0
});

	$( "#submitbutton" ).click(function() {

		if($("#OvertimeOvertimeDate").val() == "") {
			alert('Please enter the date of overtime.');
			return false;
		}

		if($("#OvertimeWhatsdone").val() == "") {
			alert('Please enter the work you did.');
			return false;
		}

 		$("#OvertimeEditagainForm").submit();
	});
</script>
