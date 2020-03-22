<div class="meetingMinutes index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __($meeting.' - ')?><?php echo __('Meeting Minutes'); ?></h1>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->

    <?php $logged_user = AuthComponent::user(); ?>
<?php

?>
	<div class="row">
   <?php
        $all_types[1] = 38;
        $all_types[0] = 39;
        $all_types[2] = 40;
        $all_types[100] = 41; //This is for llf
        $all_types[8] = 42;
        $all_types[7] = 43;
        $all_types[4] = 44;
        $all_types[9] = 45;
        $all_types[3] = 46;
        $all_types[10] = 47;
        $all_types[5] = 48;
        $all_types[6] = 49;
        $all_types[11] = 50;
        $all_types[13] = 51;
        $all_types[12] = 52;

   ?>

		<?php if($logged_user['id'] == 51 || in_array($all_types[$type], unserialize($melogged['User']['permissions'])) ):?>
		<div class="col-md-3" style="">
				<div class="actions">
					<div class="panel panel-default">
						<div class="panel-heading"><?php echo __('Actions'); ?></div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
                                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Add Meeting Minutes'), array('controller' => 'MeetingMinutes', 'action' => 'add', $type), array('escape' => false)); ?></li>
							</ul>
						</div>
					</div>
				</div>
			</div><!-- end col md 3 -->
			<?php endif; ?>


			<div class="col-md-9">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
						<th nowrap><?php echo $this->Paginator->sort('id'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('meeting_id'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('document_name'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('created'); ?></th>
						<th nowrap style="display: none"><?php echo $this->Paginator->sort('uploaded by'); ?></th>
						<th class="actions" style="display: none"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($meetingMinutes as $meetingMinute):
 if($meetingMinute['MeetingMinute']['document_name'] != "" ):
?>
					<tr>
						<td nowrap><?php echo h($meetingMinute['MeetingMinute']['id']); ?>&nbsp;</td>
								<td>
			<?php echo $this->Html->link($meetingMinute['Meeting']['name'], array('controller' => 'meetings', 'action' => 'view', $meetingMinute['Meeting']['id'])); ?>
		</td>
						<td nowrap>
							<?php
                                    echo $this->Html->link($meetingMinute['MeetingMinute']['document_name'], array( 'action' => 'sendFile', $meetingMinute['MeetingMinute']['id']), array('target' => '_blank'));
							?>
							&nbsp;</td>
						<td nowrap><?php echo h($meetingMinute['MeetingMinute']['created']); ?>&nbsp;</td>
						<td nowrap style="display: none"><?php echo h($meetingMinute['MeetingMinute']['user_id']); ?>&nbsp;</td>
						<td class="actions" style="display: none">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $meetingMinute['MeetingMinute']['id']), array('escape' => false)); ?>
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $meetingMinute['MeetingMinute']['id']), array('escape' => false)); ?>
							<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $meetingMinute['MeetingMinute']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $meetingMinute['MeetingMinute']['id'])); ?>
						</td>
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
