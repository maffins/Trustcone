<div class="communicationLogs view">
<h2><?php echo __('Communication Log'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($communicationLog['CommunicationLog']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($communicationLog['User']['fname'], array('controller' => 'users', 'action' => 'view', $communicationLog['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($communicationLog['CommunicationLog']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Sent'); ?></dt>
		<dd>
			<?php echo h($communicationLog['CommunicationLog']['date_sent']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Communication Log'), array('action' => 'edit', $communicationLog['CommunicationLog']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Communication Log'), array('action' => 'delete', $communicationLog['CommunicationLog']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $communicationLog['CommunicationLog']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Communication Logs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Communication Log'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
