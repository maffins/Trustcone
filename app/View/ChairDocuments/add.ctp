			<div class="MaycoDocument form">

				<div class="row">
					<div class="col-md-12">
						<div class="page-header">
							<h1><?php echo __('CHAIR OF CHAIRS SECTION 79 COMMITTEE'); ?></h1>
						</div>
					</div>
				</div>

                <div class="col-md-9">
					<?php echo $this->Form->create('ChairDocument', array('role' => 'form', 'enctype' => 'multipart/form-data')); ?>

					<div class="form-group" style="display: none;">
						<?php echo $this->Form->input('user_id', array('class' => 'form-control', 'placeholder' => 'User Id'));?>
					</div>

					<h2><?php echo __('Meeting name'); ?></h2>

					<div class="form-group">
						<?php echo $this->Form->input('meeting', array('class' => 'form-control', 'placeholder' => 'Meeting name'));?>
					</div>
					<br />

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
<br />
					<h2><?php echo __('Separate Covers'); ?></h2>

					<div class="form-group">
						<?php echo $this->Form->input('separatecovers.', array('class' => 'form-control', 'label'=>'Separate Covers', 'placeholder' => 'Separate Covers',  'type' => 'file', 'multiple' => 'multiple'));?>
					</div><br />

					<h2><?php echo __('Addendum'); ?></h2>
					<br />
					<div class="form-group">
						<?php echo $this->Form->input('addendum.', array('class' => 'form-control', 'label'=>'Addendum items', 'placeholder' => 'Addendums to upload',  'type' => 'file', 'multiple' => 'multiple'));?>
					</div>
					<br />
						<h2><?php echo __('Must Notifications go out?'); ?></h2>
						<br />
						<div class="form-group" style="padding-left:20px">
							<?php echo $this->Form->input('notifications', array('class' => 'form-control', 'label'=>'<br /><b>Notifications</b>', 'data-toggle' => 'collapse', 'data-target'=>'#collapseExample', 'aria-expanded'=>'false', 'aria-controls'=>'collapseExample', 'placeholder' => '',  'type' => 'checkbox'));?>
						</div>
						<br /><br />
						<div class="collapse" id="collapseExample">
						  <div class="card card-body">
								<div class="col-md-9">

								<div class="form-group">
									<?php echo $this->Form->input('subject', array('class' => 'form-control', 'type' => 'text', 'placeholder' => 'Email Subject', 'label' => 'Email Subject'));?>
								</div>
								<br style="clear:both" />

								<br style="clear:both" />
								<div class="form-group">
									<?php echo $this->Form->input('message', array('class' => 'form-control', 'label'=>'Both Sms and Email', 'placeholder' => 'Type new message here',  'type' => 'textarea'));?>
								</div>
							<br style="clear:both" />
								<br style="clear:both" />
								<div class="form-group">
									<label for="sendemail">Send emails(only)</label>
									<?php echo $this->Form->checkbox('sendemail', array('class' => 'form-control', 'label'=>'Send emails'));?>
								</div>
								<br style="clear:both" />
									<div class="form-group">
										<label for="sendemail">Send sms's(only)</label>
										<?php echo $this->Form->checkbox('sendsms', array('class' => 'form-control', 'label'=>'Send sms'));?>
									</div>

							</div>
						</div>
					</div>
<br style="clear:both" />
				<br /><br />
					<div class="form-group">
						<?php echo $this->Form->submit(__('Upload All Documents'), array('class' => 'btn btn-default')); ?>
					</div>

					<?php echo $this->Form->end() ?>

				</div><!-- end col md 12 -->
			</div><!-- end row -->
		</div>
