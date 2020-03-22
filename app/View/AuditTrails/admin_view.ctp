<div class="auditTrails view">
<h2><?php echo __('Audit Trail'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($auditTrail['AuditTrail']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Event Description'); ?></dt>
		<dd>
			<?php echo h($auditTrail['AuditTrail']['event_description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contents'); ?></dt>
		<dd>
			<?php echo h($auditTrail['AuditTrail']['contents']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($auditTrail['AuditTrail']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Audit Trail'), array('action' => 'edit', $auditTrail['AuditTrail']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Audit Trail'), array('action' => 'delete', $auditTrail['AuditTrail']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $auditTrail['AuditTrail']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Audit Trails'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Audit Trail'), array('action' => 'add')); ?> </li>
	</ul>
</div>
