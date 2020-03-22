<div class="maycoDocuments index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Mayco Documents'); ?></h1>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->

<?php $logged_user = AuthComponent::user();?>

	<div class="row">

        <?php if ($userSession['user_type_id'] != 9): ?>

        <?php if($logged_user['id'] == 51 ):?>
            <div class="col-md-3" style="">
         <?php else: ?>
            <div class="col-md-3" style="display: none">
         <?php endif;?>
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Actions'); ?></div>
					<div class="panel-body">
						<ul class="nav nav-pills nav-stacked">
							<li style="display: none"><a href="/users/logout">Click here to Logout</a></li>
							<?php if(AuthComponent::user()['user_type_id'] != 15 && AuthComponent::user()):?>
							<?php  if (AuthComponent::user()['user_type_id'] != 9) : ?>
							<?php if (AuthComponent::user()['user_type_id'] == 2 || AuthComponent::user()['user_type_id'] == 3 || AuthComponent::user()['user_type_id'] == 11 || AuthComponent::user()['user_type_id'] == 10 ):?>
							<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Urgent Documents'), array('controller' => 'documents', 'action' => 'urguent'), array('escape' => false)); ?> </li>
							<?php endif?>
							<?php if (AuthComponent::user()['user_type_id'] == 6 ):?>
							<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Reports'), array('controller' => 'pages', 'action' => 'report'), array('escape' => false)); ?> </li>
							<?php endif?>
							<?php if (AuthComponent::user()['user_type_id'] == 6 ):?>
							<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Settings'), array('controller' => 'pages', 'action' => 'settings'), array('escape' => false)); ?> </li>
							<?php endif?>
							<?php if (AuthComponent::user()['user_type_id'] != 6 && AuthComponent::user()['user_type_id'] != 15 && AuthComponent::user()['user_type_id'] != 27):?>
							<li style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Official Documents'), array('controller' => 'documents', 'action' => 'index'), array('escape' => false)); ?></li>
							<?php endif?>
							<?php if (AuthComponent::user()['user_type_id'] == 1 || AuthComponent::user()['user_type_id'] == 8 || AuthComponent::user()['user_type_id'] == 7 || AuthComponent::user()['user_type_id'] == 12 || AuthComponent::user()['user_type_id'] == 13 ):?>
                                <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Capture Official Document'), array('controller' => 'documents', 'action' => 'add'), array('escape' => false)); ?> </li>
                            <?php endif?>
							<li style="display:none "><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Users'), array('controller' => 'users', 'action' => 'index'), array('escape' => false)); ?></li>
							<?php
                     $userSession = AuthComponent::user();
                      if ($userSession['user_type_id'] == 3 || $userSession['user_type_id'] == 2 || $userSession['user_type_id'] == 11 || $userSession['user_type_id'] == 10):
                ?>

							<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('View Documents by directorates'), array('controller' => 'departments', 'action' => 'index'), array('escape' => false)); ?> </li>
							<?php if (AuthComponent::user()['user_type_id'] == 6 ):?>
							<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Reports'), array('controller' => 'pages', 'action' => 'report'), array('escape' => false)); ?> </li>
							<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Settings'), array('controller' => 'pages', 'action' => 'settings'), array('escape' => false)); ?> </li>
							<?php endif?>
							<?php
                 endif;

                     if ($userSession['user_type_id'] == 3 || $userSession['user_type_id'] == 2 ):
                ?>
							<li style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Council Documents'), array('controller' => 'CounsilorDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
							<li style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('MAYCO Documents'), array('controller' => 'MaycoDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
							<?php endif ; ?>
							<?php endif ; ?> <!-- /#sidebar-wrapper -->
							<?php endif; ?>
							<?php if (AuthComponent::user()['user_type_id'] == 15):?>
							<li  style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Council Documents'), array('controller' => 'CounsilorDocuments', 'action' => 'index'), array('escape' => false)); ?></li>

                                <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New MAYCO Meeting'), array('controller' => 'MaycoDocuments', 'action' => 'add'), array('escape' => false)); ?> </li>
							    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New Council Meeting'), array('controller' => 'CounsilorDocuments', 'action' => 'add'), array('escape' => false)); ?></li>

                            <?php endif?>

							<?php if (AuthComponent::user()['user_type_id'] == 9):?>
							<li style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Council Documents'), array('controller' => 'CounsilorDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
							<?php endif?>

							<?php if($logged_user['id'] == 51):?>
								<li style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('MAYCO Documents'), array('controller' => 'MaycoDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                             <?php endif?>

							<?php if($logged_user['id'] == 153):?>
							<li  style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Fault list'), array('controller' => 'Faults', 'action' => 'index'), array('escape' => false)); ?></li>
							<?php endif?>

							<?php if($userSession['user_type_id'] == 27):?>
							<li style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('MAYCO Documents'), array('controller' => 'MaycoDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
							<?php endif?>
							<li style="display:none"><a href="/users/logout"><span class="glyphicon glyphicon-user"></span>Logout</a></li>
						</ul>

					</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->
<?php endif; ?>

            <?php if($logged_user['id'] == 51 ):?>
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
					<th class="actions" <?php if($usertype != 15) :?> style ="display:none" <?php endif;?> ></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($meetings as $meeting): //print_r($meeting);?>
				<tr>
					<td ><?php echo h($meeting['Meeting']['idcounter']); ?>&nbsp;</td>
					<td >&nbsp;<?php echo $this->Html->link($meeting['Meeting']['name'], array('action' => 'view', $meeting['Meeting']['id']), array('escape' => false)); ?></td>
					<td   style="display: none"><?php echo h($meeting['Meeting']['user_id']); ?>&nbsp;</td>
					<td ><?php echo h($meeting['Meeting']['created']); ?>&nbsp;</td>
					<td class="actions" <?php if($usertype != 15) :?> style ="display:none" <?php endif;?> >
						<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $meeting['Meeting']['id']), array('escape' => false)); ?>
						<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $meeting['Meeting']['id']), array('escape' => false)); ?>
						<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('controller' => 'Meetings', 'action' => 'delete', $meeting['Meeting']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $meeting['Meeting']['id'])); ?>
						<?php if($logged_user['id'] == 51 ):?>
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>', array('action' => 'addmore', $meeting['Meeting']['id']), array('escape' => false)); ?>
					<?php endif;?>
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