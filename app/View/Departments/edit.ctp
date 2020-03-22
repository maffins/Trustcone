<div class="departments form">
	<style>
		.btn-info {
			width: 60%;
			text-align: left;
		}
		.form-control {
			width: 40%;
		}
		label {
			width: 20%;
			float: left;
		}
	</style>
	<?php echo $this->Form->create('Department'); ?>
	<fieldset>
		<p class='btn btn-info'>Edit Directorate<p/>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', ['class' => 'form-control']);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Departments'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Documents'), array('controller' => 'documents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Document'), array('controller' => 'documents', 'action' => 'add')); ?> </li>
	</ul>
</div>
