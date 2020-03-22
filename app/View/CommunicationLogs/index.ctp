<div class="communicationLogs index">
	<h2><?php echo __('Communication Logs'); ?></h2>
	<table cellpadding="0" cellspacing="0" class="table-striped table">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<th><?php echo $this->Paginator->sort('date_sent'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($communicationLogs as $communicationLog): ?>
	<tr>
		<td><?php echo h($communicationLog['CommunicationLog']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($communicationLog['User']['fname'], array('controller' => 'users', 'action' => 'view', $communicationLog['User']['id'])); ?>
		</td>
		<td><?php echo h($communicationLog['CommunicationLog']['email']); ?>&nbsp;</td>
		<td><?php echo h($communicationLog['CommunicationLog']['date_sent']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $communicationLog['CommunicationLog']['id'])); ?>
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

