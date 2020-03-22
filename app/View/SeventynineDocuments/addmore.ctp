			<div class="MaycoDocument form">

				<div class="row">
					<div class="col-md-12">
						<div class="page-header">
                            <h3><?php echo __('Add more documents to: '.$Meeting[0]['Meeting']['name']); ?></h3>
						</div>
					</div>
				</div>
                <?php if ($userSession['user_type_id'] != 9): ?>
                <div class="col-md-3" style="display: none">
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
                                    <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Capture Document'), array('controller' => 'documents', 'action' => 'add'), array('escape' => false)); ?> </li>
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

                                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Capture Documents'), array('controller' => 'CounsilorDocuments', 'action' => 'add'), array('escape' => false)); ?></li>

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
                                    <li><a href="/users/logout"><span class="glyphicon glyphicon-user"></span>Logout</a></li>
                                </ul>

                            </div><!-- end body -->
                        </div><!-- end panel -->
                    </div><!-- end actions -->
                </div><!-- end col md 3 -->
            <?php endif;?>
                <div class="col-md-9">
					<?php echo $this->Form->create('MaycoDocument', array('role' => 'form', 'enctype' => 'multipart/form-data')); ?>

					<div class="form-group" style="display: none;">
						<?php echo $this->Form->input('meeting_id', array('class' => 'form-control', 'type' => 'text', 'value' => $meeting_id));?>
					</div>

					<h2><?php echo __('Agenda'); ?></h2>
					<br />
					<div class="form-group">
						<?php echo $this->Form->input('agenda.', array('class' => 'form-control', 'label'=>'Agenda Documents', 'placeholder' => 'Documents to upload',  'type' => 'file', 'multiple' => 'multiple'));?>
					</div>
					<br />

					<h2><?php echo __('Previous meeting minutes'); ?></h2>

					<div class="form-group">
						<?php echo $this->Form->input('minutes.', array('class' => 'form-control', 'label'=>'Previous minutes', 'placeholder' => 'Documents to upload',  'type' => 'file', 'multiple' => 'multiple'));?>
					</div>
					<br />

					<h2><?php echo __('Items'); ?></h2>

					<div class="form-group">
						<?php echo $this->Form->input('items.', array('class' => 'form-control', 'label'=>'Items', 'placeholder' => 'Items',  'type' => 'file', 'multiple' => 'multiple'));?>
					</div><br />

					<h2><?php echo __('Annexures'); ?></h2>

					<div class="form-group">
						<?php echo $this->Form->input('attachments.', array('class' => 'form-control', 'label'=>'Attachments', 'placeholder' => 'Attachments',  'type' => 'file', 'multiple' => 'multiple'));?>
					</div>

					<br /><br />
					<div class="form-group">
						<?php echo $this->Form->submit(__('Upload All Documents'), array('class' => 'btn btn-default')); ?>
					</div>

					<?php echo $this->Form->end() ?>

				</div><!-- end col md 12 -->
			</div><!-- end row -->
		</div>
