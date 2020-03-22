			<div class="MaycoDocument form">

				<div class="row">
					<div class="col-md-12">
						<div class="page-header">
							<h1><?php echo __('RESEND MPAC SECTION 79 COMMITTEE MESSAGES'); ?></h1>
						</div>
					</div>
				</div>

          <div class="col-md-9">
					<?php echo $this->Form->create('MpacDocument', array('role' => 'form', 'enctype' => 'multipart/form-data')); ?>

					<h3>Subject</h3>

					<div class="form-group">
						<?php echo $this->Form->input('subject', array('class' => 'form-control', 'type' => 'text', 'placeholder' => 'Email Subject'));?>
					</div>
					<br style="clear:both" />

					<h3>Message</h3>
					<br style="clear:both" />
					<div class="form-group">
						<?php echo $this->Form->input('message', array('class' => 'form-control', 'label'=>'Both Sms and Email', 'placeholder' => 'Type new message here',  'type' => 'textarea'));?>
					</div>
<br style="clear:both" />
					<h2><?php echo __('Message Type (<small>Tick either one or both</small>)'); ?></h2>
					<br style="clear:both" />
					<div class="form-group">
						<label for="sendemail">Send emails</label>
						<?php echo $this->Form->checkbox('sendemail', array('class' => 'form-control', 'label'=>'Send emails'));?>
					</div>
					<br style="clear:both" />
						<div class="form-group">
							<label for="sendemail">Send sms's</label>
							<?php echo $this->Form->checkbox('sendsms', array('class' => 'form-control', 'label'=>'Send sms'));?>
						</div>
<br style="clear:both" />
					<div class="form-group">
						<?php echo $this->Form->submit(__('Send Messages'), array('class' => 'btn btn-default')); ?>
					</div>

					<?php echo $this->Form->end() ?>

				</div><!-- end col md 12 -->
			</div><!-- end row -->
		</div>
