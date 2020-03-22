<div class="departmentSections form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Add Directorate Unit'); ?></h1>
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

																<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Directorates Units'), array('action' => 'index'), array('escape' => false)); ?></li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Directorates'), array('controller' => 'departments', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New Directorate'), array('controller' => 'departments', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div>
					</div>
				</div>
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('DepartmentSection', array('role' => 'form')); ?>

				<div class="form-group">
					<?php echo $this->Form->input('department_id', array('class' => 'form-control', 'label' => 'Choose Parent Directorate', 'placeholder' => 'Department Id'));?>
				</div>
				<br style="clear:both" />
				<div class="form-group">
					<?php echo $this->Form->input('name', array('class' => 'form-control', 'label' => 'Unit Name', 'placeholder' => 'Name'));?>
				</div>
				<br style="clear:both" />
				<div class="form-group" style="display:none">
					<?php echo $this->Form->input('permission', array('class' => 'form-control', 'label' => 'Permission', 'placeholder' => 'Name'));?>
				</div>
				<br style="clear:both" />
				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
