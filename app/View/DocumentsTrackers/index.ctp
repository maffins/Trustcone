<div class="documentsTrackers index">
	<h2><?php echo __('Documents Trackers'); ?></h2>
	<table cellpadding="0" cellspacing="0" class="table-striped">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('document_id'); ?></th>
			<th><?php echo $this->Paginator->sort('status_id'); ?></th>
			<th><?php echo $this->Paginator->sort('level_id'); ?></th>
			<th><?php echo $this->Paginator->sort('updated_by'); ?></th>
			<th><?php echo $this->Paginator->sort('brought_by'); ?></th>
			<th><?php echo $this->Paginator->sort('date_brought'); ?></th>
			<th><?php echo $this->Paginator->sort('date_updated'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($documentsTrackers as $documentsTracker): ?>
	<tr>
		<td><?php echo h($documentsTracker['DocumentsTracker']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($documentsTracker['Document']['name'], array('controller' => 'documents', 'action' => 'view', $documentsTracker['Document']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($documentsTracker['Status']['name'], array('controller' => 'statuses', 'action' => 'view', $documentsTracker['Status']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($documentsTracker['Level']['name'], array('controller' => 'levels', 'action' => 'view', $documentsTracker['Level']['id'])); ?>
		</td>
		<td><?php echo h($documentsTracker['DocumentsTracker']['updated_by']); ?>&nbsp;</td>
		<td><?php echo h($documentsTracker['DocumentsTracker']['brought_by']); ?>&nbsp;</td>
		<td><?php echo h($documentsTracker['DocumentsTracker']['date_brought']); ?>&nbsp;</td>
		<td><?php echo h($documentsTracker['DocumentsTracker']['date_updated']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $documentsTracker['DocumentsTracker']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $documentsTracker['DocumentsTracker']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $documentsTracker['DocumentsTracker']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $documentsTracker['DocumentsTracker']['id']))); ?>
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
