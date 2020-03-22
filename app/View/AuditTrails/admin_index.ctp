<div class="auditTrails index">
	<h2><?php echo __('Audit Trails'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('event_description'); ?></th>
			<th><?php echo $this->Paginator->sort('contents'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($auditTrails as $auditTrail): ?>
	<tr>
		<td><?php echo h($auditTrail['AuditTrail']['id']); ?>&nbsp;</td>
		<td><?php echo h($auditTrail['AuditTrail']['event_description']); ?>&nbsp;</td>
		<td><?php echo h($auditTrail['AuditTrail']['contents']); ?>&nbsp;</td>
		<td><?php echo h($auditTrail['AuditTrail']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $auditTrail['AuditTrail']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $auditTrail['AuditTrail']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $auditTrail['AuditTrail']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $auditTrail['AuditTrail']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Audit Trail'), array('action' => 'add')); ?></li>
	</ul>
</div>
