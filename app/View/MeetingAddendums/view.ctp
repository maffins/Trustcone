<div class="meetingAddendums view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Meeting Addendum'); ?></h1>
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
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Meeting Addendum'), array('action' => 'edit', $meetingAddendum['MeetingAddendum']['id']), array('escape' => false)); ?> </li>
		<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Meeting Addendum'), array('action' => 'delete', $meetingAddendum['MeetingAddendum']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $meetingAddendum['MeetingAddendum']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Meeting Addendums'), array('action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Meeting Addendum'), array('action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Meetings'), array('controller' => 'meetings', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Meeting'), array('controller' => 'meetings', 'action' => 'add'), array('escape' => false)); ?> </li>
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
			<?php echo h($meetingAddendum['MeetingAddendum']['id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Type'); ?></th>
		<td>
			<?php echo h($meetingAddendum['MeetingAddendum']['type']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Meeting'); ?></th>
		<td>
			<?php echo $this->Html->link($meetingAddendum['Meeting']['name'], array('controller' => 'meetings', 'action' => 'view', $meetingAddendum['Meeting']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Document Name'); ?></th>
		<td>
			<?php echo h($meetingAddendum['MeetingAddendum']['document_name']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Original Name'); ?></th>
		<td>
			<?php echo h($meetingAddendum['MeetingAddendum']['original_name']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Created'); ?></th>
		<td>
			<?php echo h($meetingAddendum['MeetingAddendum']['created']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('User Id'); ?></th>
		<td>
			<?php echo h($meetingAddendum['MeetingAddendum']['user_id']); ?>
			&nbsp;
		</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>

