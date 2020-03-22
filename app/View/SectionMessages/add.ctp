<div class="sectionMessages form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Send Section Message'); ?></h1>
			</div>
		</div>
	</div>



	<div class="row">
		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Actions'); ?></div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
									<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('List Section Messages'), array('action' => 'index'), array('escape' => false)); ?></li>
							</ul>
						</div>
					</div>
				</div>
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('SectionMessage', array('role' => 'form')); ?>

				<div class="form-group"style="display:none">
					<?php echo $this->Form->input('user_id', array('class' => 'form-control', 'placeholder' => 'User Id'));?>
				</div>
				<br />
				<div class="form-group">
					<?php echo $this->Form->input('section_id', array('class' => 'form-control', 'label' => 'Choose Section', 'default' => '6', 'placeholder' => 'Section Id',  'onchange' => "myFunction(this.value)"));?>
				</div>
				<br />
				<div class="form-group" id='othernumbers' style='display:none'>
					<?php echo $this->Form->input('othernumbers', array('class' => 'form-control', 'placeholder' => 'hit enter after each number (27810000000)', 'type' => 'textarea', 'label' => 'Sms numbers'));?>
				</div>
				
				<div class="form-group">
				<br style="clear:both" />
					<?php echo $this->Form->input('smsmessage', array('class' => 'form-control', 'placeholder' => 'Sms Message (if different)', 'type' => 'textarea', 'label' => 'Sms Messge'));?>
				</div>
				<br style="clear:both" />
				<div class="form-group">
					<?php echo $this->Form->input('subject', array('class' => 'form-control', 'placeholder' => 'Subject', 'label' => 'Email Subject'));?>
				</div>
				<br />
				<div class="form-group">
					<?php echo $this->Form->input('message', array('class' => 'form-control', 'placeholder' => 'Email Message', 'label' => 'Email Messge'));?>
				</div>
				<br style="clear:both" />
				<br />
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
							<br style="clear:both" />
							<br style="clear:both" />
				<div class="form-group">
					<?php echo $this->Form->submit(__('Send Messages'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>

				<br style="clear:both" />
					<br style="clear:both" />
		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
      
<script type="text/javascript"> 
	function myFunction(value)
	{
		if(value == 100)
		{
			$("#othernumbers").show();
		} else {
			$("#othernumbers").hide();
		}
	}  
</script> 