<div class="counsilorDocuments form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h3><?php echo __('Add more documents to: '.$Meeting[0]['Meeting']['name']); ?></h3>
			</div>
		</div>
	</div>


	<div class="col-md-9">
			<?php echo $this->Form->create('Notice', array('role' => 'form', 'enctype' => 'multipart/form-data')); ?>

			<div class="form-group" style="display: none;">
				<?php echo $this->Form->input('meeting_id', array('class' => 'form-control', 'type' => 'text', 'value' => $meeting_id));?>
			</div>



			<h2 style="background-color:red"><?php echo __('Notice'); ?></h2>
			<br />
			<div class="form-group">
				<?php echo $this->Form->input('notice.', array('class' => 'form-control', 'label'=>'Notices Documents to add', 'placeholder' => 'Notices to upload',  'type' => 'file', 'multiple' => 'multiple'));?>
			</div>

			<br /><br />
			<div class="form-group">
				<?php echo $this->Form->submit(__('Upload All Documents'), array('class' => 'btn btn-default')); ?>
			</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
