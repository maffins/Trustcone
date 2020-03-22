<div class="maycoDocuments index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('MPAC SECTION 79 COMMITTEE'); ?></h1>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->

<?php $logged_user = AuthComponent::user();

    $permissions = unserialize($logged_user['permissions']);
?>
	<div class="row">

		<?php if( in_array(35, $permissions) ):?>
            <div class="col-md-3" style="">
         <?php else: ?>
            <div class="col-md-3" style="display: none">
         <?php endif;?>
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Actions'); ?></div>
					<div class="panel-body">
						<ul class="nav nav-pills nav-stacked">
							<li style="<?php if($controller == 'EightyDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New Mpac Committee'), array('controller' => 'MpacDocuments', 'action' => 'add'), array('escape' => false)); ?> </li>
						</ul>
					</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

			<?php if( in_array(35, $permissions) ):?>
                <div class="col-md-9" style="">
            <?php else: ?>
                    <div class="col-md-12" >
            <?php endif;?>
			<table cellpadding="0" cellspacing="0" class="table table-striped" style="margin: 0 auto">
				<thead>
				<tr>
					<th ><?php echo $this->Paginator->sort('id'); ?></th>
					<th ><?php echo $this->Paginator->sort('name'); ?></th>
					<th  style="display: none"><?php echo $this->Paginator->sort('uploaded_by'); ?></th>
					<th ><?php echo $this->Paginator->sort('created'); ?></th>
					<?php if($logged_user['id'] == 51 || $logged_user['id'] == 1 || $logged_user['id'] == 245) :?>
<td class="actions"><?php endif;?>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($meetings as $meeting): //print_r($meeting);?>
				<tr>
					<td ><?php echo h($meeting['Meeting']['idcounter']); ?>&nbsp;</td>
					<td >&nbsp;<?php echo $this->Html->link($meeting['Meeting']['name'], array('action' => 'view', $meeting['Meeting']['id']), array('escape' => false)); ?></td>
					<td   style="display: none"><?php echo h($meeting['Meeting']['user_id']); ?>&nbsp;</td>
					<td ><?php echo h($meeting['Meeting']['created']); ?>&nbsp;</td>
					<?php if($logged_user['id'] == 51 || $logged_user['id'] == 1 || $logged_user['id'] == 245) :?>
<td class="actions">
						<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $meeting['Meeting']['id']), array('escape' => false)); ?>
						<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $meeting['Meeting']['id']), array('escape' => false)); ?>
						<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('controller' => 'Meetings', 'action' => 'delete', $meeting['Meeting']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $meeting['Meeting']['id'])); ?>
						<?php if($logged_user['id'] == 51 || $logged_user['id'] == 245 ):?>
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>', array('action' => 'addmore', $meeting['Meeting']['id']), array('escape' => false)); ?>
					<?php endif;?>
					</td>
					<?php endif;?>
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
