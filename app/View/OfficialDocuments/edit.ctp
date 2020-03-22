<div class="officialDocuments form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Edit Official Document'); ?></h1>
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

																<li><?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;'.__('Delete'), array('action' => 'delete', $this->Form->value('OfficialDocument.id')), array('escape' => false), __('Are you sure you want to delete # %s?', $this->Form->value('OfficialDocument.id'))); ?></li>
																<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Official Documents'), array('action' => 'index'), array('escape' => false)); ?></li>
									<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Users'), array('controller' => 'users', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New User'), array('controller' => 'users', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('OfficialDocument', array('role' => 'form')); ?>

				<div class="form-group">
					<?php echo $this->Form->input('id', array('class' => 'form-control', 'placeholder' => 'Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('type', array('class' => 'form-control', 'placeholder' => 'Type'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('idcounter', array('class' => 'form-control', 'placeholder' => 'Idcounter'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('doc_name', array('class' => 'form-control', 'placeholder' => 'Doc Name'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('compiled_name', array('class' => 'form-control', 'placeholder' => 'Compiled Name'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('tracker', array('class' => 'form-control', 'placeholder' => 'Tracker'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('priority', array('class' => 'form-control', 'placeholder' => 'Priority'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('decision', array('class' => 'form-control', 'placeholder' => 'Decision'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('reason', array('class' => 'form-control', 'placeholder' => 'Reason'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('user_id', array('class' => 'form-control', 'placeholder' => 'User Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
