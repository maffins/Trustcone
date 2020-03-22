<div class="statuses view">
<h2><?php echo __('Status'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($status['Status']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($status['Status']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($status['Status']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($status['Status']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Status'), array('action' => 'edit', $status['Status']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Status'), array('action' => 'delete', $status['Status']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $status['Status']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Statuses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Status'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Documents Trackers'), array('controller' => 'documents_trackers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Documents Tracker'), array('controller' => 'documents_trackers', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Documents Trackers'); ?></h3>
	<?php if (!empty($status['DocumentsTracker'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Document Id'); ?></th>
		<th><?php echo __('Status Id'); ?></th>
		<th><?php echo __('Level Id'); ?></th>
		<th><?php echo __('Updated By'); ?></th>
		<th><?php echo __('Brought By'); ?></th>
		<th><?php echo __('Date Brought'); ?></th>
		<th><?php echo __('Date Updated'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($status['DocumentsTracker'] as $documentsTracker): ?>
		<tr>
			<td><?php echo $documentsTracker['id']; ?></td>
			<td><?php echo $documentsTracker['document_id']; ?></td>
			<td><?php echo $documentsTracker['status_id']; ?></td>
			<td><?php echo $documentsTracker['level_id']; ?></td>
			<td><?php echo $documentsTracker['updated_by']; ?></td>
			<td><?php echo $documentsTracker['brought_by']; ?></td>
			<td><?php echo $documentsTracker['date_brought']; ?></td>
			<td><?php echo $documentsTracker['date_updated']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'documents_trackers', 'action' => 'view', $documentsTracker['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'documents_trackers', 'action' => 'edit', $documentsTracker['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'documents_trackers', 'action' => 'delete', $documentsTracker['id']), array('confirm' => __('Are you sure you want to delete # %s?', $documentsTracker['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Documents Tracker'), array('controller' => 'documents_trackers', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
