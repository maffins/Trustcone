<div class="meetings view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Meeting'); ?></h1>
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Actions'); ?></div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Meeting'), array('action' => 'edit', $meeting['Meeting']['id']), array('escape' => false)); ?> </li>
		<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Meeting'), array('action' => 'delete', $meeting['Meeting']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $meeting['Meeting']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Meetings'), array('action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Meeting'), array('action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Meeting Agendas'), array('controller' => 'meeting_agendas', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Meeting Agenda'), array('controller' => 'meeting_agendas', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Meeting Attachments'), array('controller' => 'meeting_attachments', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Meeting Attachment'), array('controller' => 'meeting_attachments', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Meeting Items'), array('controller' => 'meeting_items', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Meeting Item'), array('controller' => 'meeting_items', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Meeting Minutes'), array('controller' => 'meeting_minutes', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Meeting Minute'), array('controller' => 'meeting_minutes', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">			
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<tbody>
				<tr>
		<th><?php echo __('Id'); ?></th>
		<td>
			<?php echo h($meeting['Meeting']['id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Name'); ?></th>
		<td>
			<?php echo h($meeting['Meeting']['name']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Uploaded By'); ?></th>
		<td>
			<?php echo h($meeting['Meeting']['uploaded_by']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Created'); ?></th>
		<td>
			<?php echo h($meeting['Meeting']['created']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Modified'); ?></th>
		<td>
			<?php echo h($meeting['Meeting']['modified']); ?>
			&nbsp;
		</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>

<div class="related row">
	<div class="col-md-12">
	<h3><?php echo __('Related Meeting Agendas'); ?></h3>
	<?php if (!empty($meeting['MeetingAgenda'])): ?>
	<table cellpadding = "0" cellspacing = "0" class="table table-striped">
	<thead>
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Meeting Id'); ?></th>
		<th><?php echo __('Document Name'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Uploaded)by'); ?></th>
		<th class="actions"></th>
	</tr>
	<thead>
	<tbody>
	<?php foreach ($meeting['MeetingAgenda'] as $meetingAgenda): ?>
		<tr>
			<td><?php echo $meetingAgenda['id']; ?></td>
			<td><?php echo $meetingAgenda['meeting_id']; ?></td>
			<td><?php echo $meetingAgenda['document_name']; ?></td>
			<td><?php echo $meetingAgenda['created']; ?></td>
			<td><?php echo $meetingAgenda['uploaded)by']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-search"></span>'), array('controller' => 'meeting_agendas', 'action' => 'view', $meetingAgenda['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>'), array('controller' => 'meeting_agendas', 'action' => 'edit', $meetingAgenda['id']), array('escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>'), array('controller' => 'meeting_agendas', 'action' => 'delete', $meetingAgenda['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $meetingAgenda['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
<?php endif; ?>

	<div class="actions">
		<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Meeting Agenda'), array('controller' => 'meeting_agendas', 'action' => 'add'), array('escape' => false, 'class' => 'btn btn-default')); ?> 
	</div>
	</div><!-- end col md 12 -->
</div>
<div class="related row">
	<div class="col-md-12">
	<h3><?php echo __('Related Meeting Attachments'); ?></h3>
	<?php if (!empty($meeting['MeetingAttachment'])): ?>
	<table cellpadding = "0" cellspacing = "0" class="table table-striped">
	<thead>
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Meeting Id'); ?></th>
		<th><?php echo __('Document Name'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Uploaded)by'); ?></th>
		<th class="actions"></th>
	</tr>
	<thead>
	<tbody>
	<?php foreach ($meeting['MeetingAttachment'] as $meetingAttachment): ?>
		<tr>
			<td><?php echo $meetingAttachment['id']; ?></td>
			<td><?php echo $meetingAttachment['meeting_id']; ?></td>
			<td><?php echo $meetingAttachment['document_name']; ?></td>
			<td><?php echo $meetingAttachment['created']; ?></td>
			<td><?php echo $meetingAttachment['uploaded)by']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-search"></span>'), array('controller' => 'meeting_attachments', 'action' => 'view', $meetingAttachment['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>'), array('controller' => 'meeting_attachments', 'action' => 'edit', $meetingAttachment['id']), array('escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>'), array('controller' => 'meeting_attachments', 'action' => 'delete', $meetingAttachment['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $meetingAttachment['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
<?php endif; ?>

	<div class="actions">
		<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Meeting Attachment'), array('controller' => 'meeting_attachments', 'action' => 'add'), array('escape' => false, 'class' => 'btn btn-default')); ?> 
	</div>
	</div><!-- end col md 12 -->
</div>
<div class="related row">
	<div class="col-md-12">
	<h3><?php echo __('Related Meeting Items'); ?></h3>
	<?php if (!empty($meeting['MeetingItem'])): ?>
	<table cellpadding = "0" cellspacing = "0" class="table table-striped">
	<thead>
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Meeting Id'); ?></th>
		<th><?php echo __('Document Name'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Uploaded)by'); ?></th>
		<th class="actions"></th>
	</tr>
	<thead>
	<tbody>
	<?php foreach ($meeting['MeetingItem'] as $meetingItem): ?>
		<tr>
			<td><?php echo $meetingItem['id']; ?></td>
			<td><?php echo $meetingItem['meeting_id']; ?></td>
			<td><?php echo $meetingItem['document_name']; ?></td>
			<td><?php echo $meetingItem['created']; ?></td>
			<td><?php echo $meetingItem['uploaded)by']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-search"></span>'), array('controller' => 'meeting_items', 'action' => 'view', $meetingItem['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>'), array('controller' => 'meeting_items', 'action' => 'edit', $meetingItem['id']), array('escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>'), array('controller' => 'meeting_items', 'action' => 'delete', $meetingItem['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $meetingItem['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
<?php endif; ?>

	<div class="actions">
		<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Meeting Item'), array('controller' => 'meeting_items', 'action' => 'add'), array('escape' => false, 'class' => 'btn btn-default')); ?> 
	</div>
	</div><!-- end col md 12 -->
</div>
<div class="related row">
	<div class="col-md-12">
	<h3><?php echo __('Related Meeting Minutes'); ?></h3>
	<?php if (!empty($meeting['MeetingMinute'])): ?>
	<table cellpadding = "0" cellspacing = "0" class="table table-striped">
	<thead>
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Meeting Id'); ?></th>
		<th><?php echo __('Document Name'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Uploaded)by'); ?></th>
		<th class="actions"></th>
	</tr>
	<thead>
	<tbody>
	<?php foreach ($meeting['MeetingMinute'] as $meetingMinute): ?>
		<tr>
			<td><?php echo $meetingMinute['id']; ?></td>
			<td><?php echo $meetingMinute['meeting_id']; ?></td>
			<td><?php echo $meetingMinute['document_name']; ?></td>
			<td><?php echo $meetingMinute['created']; ?></td>
			<td><?php echo $meetingMinute['uploaded)by']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-search"></span>'), array('controller' => 'meeting_minutes', 'action' => 'view', $meetingMinute['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>'), array('controller' => 'meeting_minutes', 'action' => 'edit', $meetingMinute['id']), array('escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>'), array('controller' => 'meeting_minutes', 'action' => 'delete', $meetingMinute['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $meetingMinute['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
<?php endif; ?>

	<div class="actions">
		<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Meeting Minute'), array('controller' => 'meeting_minutes', 'action' => 'add'), array('escape' => false, 'class' => 'btn btn-default')); ?> 
	</div>
	</div><!-- end col md 12 -->
</div>
