<div class="meetingMinutes form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Add Meeting Minutes for '.$meeting); ?></h1>
			</div>
		</div>
	</div>



	<div class="row">

		<div class="col-md-9">
			<?php echo $this->Form->create('MeetingMinute', array('role' => 'form', 'enctype' => 'multipart/form-data')); ?>

			<div class="form-group" style="display: none">
				<?php echo $this->Form->input('typeed', array('class' => 'form-control', 'label'=>'', 'type' => 'hidden', 'value' => $type));?>
			</div>
			<div class="form-group">
				<?php echo $this->Form->input('minutes.', array('class' => 'form-control', 'label'=>'Add minutes', 'placeholder' => 'Minutes upload',  'type' => 'file', 'multiple' => 'multiple'));?>
			</div>
			<br />
			<br />
				<div class="form-group">
					<?php echo $this->Form->submit(__('Add Minutes'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
