<div class="documentsTrackers form">
<?php echo $this->Form->create('DocumentsTracker'); ?>
	<fieldset>
		<legend><?php echo __('Edit Documents Tracker'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('document_id');
		echo $this->Form->input('status_id');
		echo $this->Form->input('level_id');
		echo $this->Form->input('updated_by');
		echo $this->Form->input('brought_by');
		echo $this->Form->input('date_brought');
		echo $this->Form->input('date_updated');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('DocumentsTracker.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('DocumentsTracker.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Documents Trackers'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Documents'), array('controller' => 'documents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Document'), array('controller' => 'documents', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Statuses'), array('controller' => 'statuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Status'), array('controller' => 'statuses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Levels'), array('controller' => 'levels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Level'), array('controller' => 'levels', 'action' => 'add')); ?> </li>
	</ul>
</div>
