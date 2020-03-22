<div class="auditTrails form">
<?php echo $this->Form->create('AuditTrail'); ?>
	<fieldset>
		<legend><?php echo __('Add Audit Trail'); ?></legend>
	<?php
		echo $this->Form->input('event_description');
		echo $this->Form->input('contents');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Audit Trails'), array('action' => 'index')); ?></li>
	</ul>
</div>
