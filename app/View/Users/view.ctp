<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl class="table-striped">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
    <br style="clear:both" />
		<dt><?php echo __('Department'); ?></dt>
		<dd>
			<?php echo $this->Html->link($user['Department']['name'], array('controller' => 'departments', 'action' => 'view', $user['Department']['id'])); ?>
			&nbsp;
		</dd> <br style="clear:both" />
		<dt><?php echo __('User Type'); ?></dt>
		<dd>
			<?php echo $this->Html->link($user['UserType']['name'], array('controller' => 'user_types', 'action' => 'view', $user['UserType']['id'])); ?>
			&nbsp;
		</dd>   <br style="clear:both" />
		<dt><?php echo __('Fname'); ?></dt>
		<dd>
			<?php echo h($user['User']['fname']); ?>
			&nbsp;
		</dd> <br style="clear:both" />
		<dt><?php echo __('Sname'); ?></dt>
		<dd>
			<?php echo h($user['User']['sname']); ?>
			&nbsp;
		</dd> <br style="clear:both" />
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd> <br style="clear:both" />
		<dt><?php echo __('Cellnumber'); ?></dt>
		<dd>
			<?php echo h($user['User']['cellnumber']); ?>
			&nbsp;
		</dd> <br style="clear:both" />
		<dt><?php echo __('Telephone'); ?></dt>
		<dd>
			<?php echo h($user['User']['telephone']); ?>
			&nbsp;
		</dd>  <br style="clear:both" />
		<dt><?php echo __('Physical Address'); ?></dt>
		<dd>
			<?php echo h($user['User']['physical_address']); ?>
			&nbsp;
		</dd>   <br style="clear:both" />
		<dt><?php echo __('Postal Address'); ?></dt>
		<dd>
			<?php echo h($user['User']['postal_address']); ?>
			&nbsp;
		</dd>  <br style="clear:both" />
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>   <br style="clear:both" />
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($user['User']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<br style="clear: both;" />
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $user['User']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Communication Logs'); ?></h3>
	<?php if (!empty($user['CommunicationLog'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Date Sent'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['CommunicationLog'] as $communicationLog): ?>
		<tr>
			<td><?php echo $communicationLog['id']; ?></td>
			<td><?php echo $communicationLog['user_id']; ?></td>
			<td><?php echo $communicationLog['email']; ?></td>
			<td><?php echo $communicationLog['date_sent']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'communication_logs', 'action' => 'view', $communicationLog['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'communication_logs', 'action' => 'edit', $communicationLog['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'communication_logs', 'action' => 'delete', $communicationLog['id']), array('confirm' => __('Are you sure you want to delete # %s?', $communicationLog['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Communication Log'), array('controller' => 'communication_logs', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Documents'); ?></h3>
	<?php if (!empty($user['Document'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Department Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Typeofuse'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Document'] as $document): ?>
		<tr>
			<td><?php echo $document['id']; ?></td>
			<td><?php echo $document['user_id']; ?></td>
			<td><?php echo $document['department_id']; ?></td>
			<td><?php echo $document['name']; ?></td>
			<td><?php echo $document['typeofuse']; ?></td>
			<td><?php echo $document['created']; ?></td>
			<td><?php echo $document['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'documents', 'action' => 'view', $document['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'documents', 'action' => 'edit', $document['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'documents', 'action' => 'delete', $document['id']), array('confirm' => __('Are you sure you want to delete # %s?', $document['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Document'), array('controller' => 'documents', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
