<div class="meetingItems index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Meeting Items'); ?></h1>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->



	<div class="row">

		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Actions'); ?></div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New Meeting Item'), array('action' => 'add'), array('escape' => false)); ?></li>
								<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List'.__('Meetings'), array('controller' => 'meetings', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New'.__('Meeting'), array('controller' => 'meetings', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
						<th nowrap><?php echo $this->Paginator->sort('id'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('meeting_id'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('document_name'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('created'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('uploaded)by'); ?></th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($meetingItems as $meetingItem): ?>
					<tr>
						<td nowrap><?php echo h($meetingItem['MeetingItem']['id']); ?>&nbsp;</td>
								<td>
			<?php echo $this->Html->link($meetingItem['Meeting']['name'], array('controller' => 'meetings', 'action' => 'view', $meetingItem['Meeting']['id'])); ?>
		</td>
						<td nowrap><?php echo h($meetingItem['MeetingItem']['document_name']); ?>&nbsp;</td>
						<td nowrap><?php echo h($meetingItem['MeetingItem']['created']); ?>&nbsp;</td>
						<td nowrap><?php echo h($meetingItem['MeetingItem']['uploaded)by']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $meetingItem['MeetingItem']['id']), array('escape' => false)); ?>
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $meetingItem['MeetingItem']['id']), array('escape' => false)); ?>
							<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $meetingItem['MeetingItem']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $meetingItem['MeetingItem']['id'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

			<p>
				<small><?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?></small>
			</p>

			<?php
			$params = $this->Paginator->params();
			if ($params['pageCount'] > 1) {
			?>
			<ul class="pagination pagination-sm">
				<?php
					echo $this->Paginator->prev('&larr; Previous', array('class' => 'prev','tag' => 'li','escape' => false), '<a onclick="return false;">&larr; Previous</a>', array('class' => 'prev disabled','tag' => 'li','escape' => false));
					echo $this->Paginator->numbers(array('separator' => '','tag' => 'li','currentClass' => 'active','currentTag' => 'a'));
					echo $this->Paginator->next('Next &rarr;', array('class' => 'next','tag' => 'li','escape' => false), '<a onclick="return false;">Next &rarr;</a>', array('class' => 'next disabled','tag' => 'li','escape' => false));
				?>
			</ul>
			<?php } ?>

		</div> <!-- end col md 9 -->
	</div><!-- end row -->


</div><!-- end containing of content -->