<div class="preovertimes form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Add Preovertime'); ?></h1>
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

																<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Preovertimes'), array('action' => 'index'), array('escape' => false)); ?></li>
									<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Users'), array('controller' => 'users', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New User'), array('controller' => 'users', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Departments'), array('controller' => 'departments', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New Department'), array('controller' => 'departments', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('Preovertime', array('role' => 'form')); ?>

				<div class="form-group">
					<?php echo $this->Form->input('user_id', array('class' => 'form-control', 'placeholder' => 'User Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('overtime_requester_id', array('class' => 'form-control', 'placeholder' => 'Overtime Requester Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('tracker', array('class' => 'form-control', 'placeholder' => 'Tracker'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('overtime_month', array('class' => 'form-control', 'placeholder' => 'Overtime Month'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('weekday', array('class' => 'form-control', 'placeholder' => 'Weekday'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('saturday', array('class' => 'form-control', 'placeholder' => 'Saturday'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('sunday', array('class' => 'form-control', 'placeholder' => 'Sunday'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('public_holiday', array('class' => 'form-control', 'placeholder' => 'Public Holiday'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('whatsdone', array('class' => 'form-control', 'placeholder' => 'Whatsdone'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('total_hours', array('class' => 'form-control', 'placeholder' => 'Total Hours'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('overal_hours', array('class' => 'form-control', 'placeholder' => 'Overal Hours'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('archived', array('class' => 'form-control', 'placeholder' => 'Archived'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
