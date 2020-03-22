<div class="MeetingSeparatecovers view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Meeting Separate Cover'); ?></h1>
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
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Meeting Agenda'), array('action' => 'edit', $meetingSeparatecover['MeetingSeparatecover']['id']), array('escape' => false)); ?> </li>
		<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Meeting Agenda'), array('action' => 'delete', $meetingSeparatecover['MeetingSeparatecover']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $meetingSeparatecover['MeetingSeparatecover']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Meeting Agendas'), array('action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Meeting Agenda'), array('action' => 'add'), array('escape' => false)); ?> </li>
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
			<?php echo h($meetingSeparatecover['MeetingSeparatecover']['id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Meeting'); ?></th>
		<td>
			<?php echo $this->Html->link($meetingSeparatecover['Meeting']['name'], array('controller' => 'meetings', 'action' => 'view', $meetingSeparatecover['Meeting']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Document Name'); ?></th>
		<td>
			<?php echo h($meetingSeparatecover['MeetingSeparatecover']['document_name']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Created'); ?></th>
		<td>
			<?php echo h($meetingSeparatecover['MeetingSeparatecover']['created']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Uploaded)by'); ?></th>
		<td>
			<?php echo h($meetingSeparatecover['MeetingSeparatecover']['uploaded)by']); ?>
			&nbsp;
		</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>
