<div class="overtimes form">

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
			<?php echo $this->Form->create('Overtime', array('role' => 'form')); ?>

				<div class="form-group" style="display:none">
					<?php echo $this->Form->input('user_id', array('class' => 'form-control', 'placeholder' => 'User Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('department_id', array('class' => 'form-control', 'placeholder' => 'Department Id'));?>
				</div>
				<br style="clear:both" />
				<div class="form-group">
					<?php echo $this->Form->input('overtime_date', array('class' => 'form-control datepicker', 'type' => 'text', 'placeholder' => 'Overtime Date'));?>
				</div>
				<br style="clear:both" />
				<div class="form-group">
					<?php echo $this->Form->input('start_time', array('class' => '', 'placeholder' => 'Start Time'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('end_time', array('class' => '', 'placeholder' => 'End Time'));?>
				</div>
				<br style="clear:both" />
				<div class="form-group">
					<?php echo $this->Form->input('pay_number', array('class' => '', 'placeholder' => 'Pay Number'));?>
				</div>
				<br style="clear:both" />
				<div class="form-group">
					<?php echo $this->Form->input('whatsdone', array('class' => 'form-control', 'placeholder' => 'Work Done', 'label' => 'Work Done'));?>
				</div>
				<br style="clear:both" />
				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
<script>
	$('.datepicker').datepicker({
	    format: 'yyyy-mm-dd',
	    startDate: '-3d'
	});
</script>
