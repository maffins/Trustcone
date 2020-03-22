<div class="counsilorDocuments form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('CAPTURE COUNCIL NOTICE DOCUMENTS'); ?></h1>
			</div>
		</div>
	</div>


	<div class="col-md-9">
			<?php echo $this->Form->create('Notice', array('role' => 'form', 'enctype' => 'multipart/form-data')); ?>

			<div class="form-group" style="display: none;">
				<?php echo $this->Form->input('user_id', array('class' => 'form-control', 'placeholder' => 'User Id'));?>
			</div>

			<h2><?php echo __('Notice name'); ?></h2>

			<div class="form-group">
				<?php echo $this->Form->input('meeting', array('class' => 'form-control', 'placeholder' => 'Notice name'));?>
			</div>
			<br />

			<h2 style="background-color:red"><?php echo __('Notice Documents'); ?></h2>
			<br />
			<div class="form-group">
				<?php echo $this->Form->input('notice.', array('class' => 'form-control', 'label'=>'Notice Documents', 'placeholder' => 'Notices to upload',  'type' => 'file', 'multiple' => 'multiple'));?>
			</div>

			<br /><br />
			<div class="form-group">
				<?php echo $this->Form->submit(__('Upload All Documents'), array('class' => 'btn btn-default')); ?>
			</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
