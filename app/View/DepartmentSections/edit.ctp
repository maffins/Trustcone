<div class="departmentSections form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Edit Directorate Section'); ?></h1>
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

																<li><?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;'.__('Delete'), array('action' => 'delete', $this->Form->value('DepartmentSection.id')), array('escape' => false), __('Are you sure you want to delete # %s?', $this->Form->value('DepartmentSection.id'))); ?></li>
																<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Department Sections'), array('action' => 'index'), array('escape' => false)); ?></li>
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
			<?php echo $this->Form->create('DepartmentSection', array('role' => 'form')); ?>

			<div class="form-group">
				<?php echo $this->Form->input('department_id', array('class' => 'form-control', 'label' => 'Choose Parent Directory', 'placeholder' => 'Department Id'));?>
			</div>
			<br style="clear:both" />
			<div class="form-group">
				<?php echo $this->Form->input('name', array('class' => 'form-control', 'label' => 'Section Name', 'placeholder' => 'Name'));?>
			</div>
			<br style="clear:both" />
			<div class="form-group">
				<?php echo $this->Form->input('permision', array('class' => 'form-control', 'label' => 'Section Name', 'placeholder' => 'Name'));?>
			</div>
			<br style="clear:both" />
			<div class="form-group">
				<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
			</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
