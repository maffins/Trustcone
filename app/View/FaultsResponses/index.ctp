<div class="faultsResponses index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Faults Responses'); ?></h1>
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
								<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New Faults Response'), array('action' => 'add'), array('escape' => false)); ?></li>
								<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List'.__('Faults'), array('controller' => 'faults', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New'.__('Fault'), array('controller' => 'faults', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List'.__('Users'), array('controller' => 'users', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New'.__('User'), array('controller' => 'users', 'action' => 'add'), array('escape' => false)); ?> </li>
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
						<th nowrap><?php echo $this->Paginator->sort('fault_id'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('user_id'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('comments'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('assigned_to'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('date_actioned'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('date_completed'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('status'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('action_taken'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('created'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('modified'); ?></th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($faultsResponses as $faultsResponse): ?>
					<tr>
						<td nowrap><?php echo h($faultsResponse['FaultsResponse']['id']); ?>&nbsp;</td>
								<td>
			<?php echo $this->Html->link($faultsResponse['Fault']['name'], array('controller' => 'faults', 'action' => 'view', $faultsResponse['Fault']['id'])); ?>
		</td>
								<td>
			<?php echo $this->Html->link($faultsResponse['User']['fname'], array('controller' => 'users', 'action' => 'view', $faultsResponse['User']['id'])); ?>
		</td>
						<td nowrap><?php echo h($faultsResponse['FaultsResponse']['comments']); ?>&nbsp;</td>
						<td nowrap><?php echo h($faultsResponse['FaultsResponse']['assigned_to']); ?>&nbsp;</td>
						<td nowrap><?php echo h($faultsResponse['FaultsResponse']['date_actioned']); ?>&nbsp;</td>
						<td nowrap><?php echo h($faultsResponse['FaultsResponse']['date_completed']); ?>&nbsp;</td>
						<td nowrap><?php echo h($faultsResponse['FaultsResponse']['status']); ?>&nbsp;</td>
						<td nowrap><?php echo h($faultsResponse['FaultsResponse']['action_taken']); ?>&nbsp;</td>
						<td nowrap><?php echo h($faultsResponse['FaultsResponse']['created']); ?>&nbsp;</td>
						<td nowrap><?php echo h($faultsResponse['FaultsResponse']['modified']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $faultsResponse['FaultsResponse']['id']), array('escape' => false)); ?>
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $faultsResponse['FaultsResponse']['id']), array('escape' => false)); ?>
							<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $faultsResponse['FaultsResponse']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $faultsResponse['FaultsResponse']['id'])); ?>
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