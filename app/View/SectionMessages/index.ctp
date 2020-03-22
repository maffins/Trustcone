<div class="sectionMessages index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Messages Sent'); ?></h1>
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
								<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New Section Message'), array('action' => 'add'), array('escape' => false)); ?></li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
						<th nowrap><?php echo $this->Paginator->sort(''); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('Sent By'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('section_id'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('Sms Message'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('Email Message'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('Email Subject'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('Date Sent'); ?></th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($sectionMessages as $sectionMessage): ?>
					<tr>
						<td nowrap><?php echo h($sectionMessage['SectionMessage']['id']); ?>&nbsp;</td>
								<td>
			<?php echo $this->Html->link($sectionMessage['User']['fname'], array('controller' => 'users', 'action' => 'view', $sectionMessage['User']['id'])); ?>
		</td>
						<td nowrap><?php echo h($sections[$sectionMessage['SectionMessage']['section_id']]); ?>&nbsp;</td>
						<td nowrap><?php echo h($sectionMessage['SectionMessage']['smsmessage']); ?>&nbsp;</td>
						<td nowrap><?php echo h($sectionMessage['SectionMessage']['message']); ?>&nbsp;</td>
						<td nowrap><?php echo h($sectionMessage['SectionMessage']['subject']); ?>&nbsp;</td>
						<td nowrap><?php echo h($sectionMessage['SectionMessage']['created']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $sectionMessage['SectionMessage']['id']), array('escape' => false)); ?>
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
