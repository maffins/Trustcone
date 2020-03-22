<div class="faultsComments index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Faults Comments'); ?></h1>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->



	<div class="row">


		<div class="col-md-12">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
						<th nowrap><?php echo $this->Paginator->sort('id'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('user_id'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('fault_id'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('comment'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('comment_response'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('date_responded'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('created'); ?></th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($faultsComments as $faultsComment): ?>
					<tr>
						<td nowrap><?php echo h($faultsComment['FaultsComment']['id']); ?>&nbsp;</td>
								<td>
			<?php echo $this->Html->link($faultsComment['User']['fname'], array('controller' => 'users', 'action' => 'view', $faultsComment['User']['id'])); ?>
		</td>
								<td>
			<?php echo $this->Html->link($faultsComment['Fault']['name'], array('controller' => 'faults', 'action' => 'view', $faultsComment['Fault']['id'])); ?>
		</td>
						<td nowrap><?php echo h($faultsComment['FaultsComment']['comment']); ?>&nbsp;</td>
						<td nowrap><?php echo h($faultsComment['FaultsComment']['comment_response']); ?>&nbsp;</td>
						<td nowrap><?php echo h($faultsComment['FaultsComment']['date_responded']); ?>&nbsp;</td>
						<td nowrap><?php echo h($faultsComment['FaultsComment']['created']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $faultsComment['FaultsComment']['id']), array('escape' => false)); ?>
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $faultsComment['FaultsComment']['id']), array('escape' => false)); ?>
							<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $faultsComment['FaultsComment']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $faultsComment['FaultsComment']['id'])); ?>
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