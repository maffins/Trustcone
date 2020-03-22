<div class="meetingMinutes index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __($meeting.' - Meeting Minutes'); ?></h1>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->

    <?php $logged_user = AuthComponent::user(); ?>

	<div class="row">


			<div class="col-md-9">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
						<th nowrap><?php echo $this->Paginator->sort('meeting_id'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('document_name'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('created'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($meetingMinutes as $meetingMinute):
 if($meetingMinute['MeetingMinute']['document_name'] != "" ):
?>
					<tr>
								<td>
			<?php echo $this->Html->link($meetingMinute['Meeting']['name'], array('controller' => 'meetings', 'action' => 'view', $meetingMinute['Meeting']['id'])); ?>
		</td>
						<td nowrap>
							<?php
                                    echo $this->Html->link($meetingMinute['MeetingMinute']['document_name'], array( 'action' => 'sendFile', $meetingMinute['MeetingMinute']['id']), array('target' => '_blank'));
							?>
							&nbsp;</td>
					</tr>
				<?php
				 endif;
				 endforeach; ?>
				</tbody>
			</table>

			<p style="display:none;"
				<small><?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?></small>
			</p>

			<?php
			$params = $this->Paginator->params();
			if ($params['pageCount'] > 1) {
			?>
			<ul class="pagination pagination-sm" style="display: none">
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