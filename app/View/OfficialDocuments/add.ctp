<div class="officialDocuments form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Official Documents'); ?></h1>
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col-md-9">
			<?php echo $this->Form->create('OfficialDocument', array('role' => 'form', 'enctype' => 'multipart/form-data')); ?>

				<div class="form-group">
					<?php echo $this->Form->input('type', array('class' => 'form-control', 'type' => 'select', 'options' => $allcommittees, 'label' => 'Select Department'));?>
				</div>
				<br style="clear:both" />
				<div class="form-group">
					<?php echo $this->Form->input('doc_name.', array('class' => 'form-control', 'placeholder' => 'Documents', 'label' => 'Documents', 'type' => 'file', 'multiple' => 'multiple'));?>
				</div>
				<br style="clear:both" />
				<div class="form-group">
					<?php echo $this->Form->input('comment', array('class' => 'form-control', 'label' => 'Any Comment', 'type' => 'textarea'));?>
				</div>
				<br style="clear:both" />
				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>
<br style="clear:both" /><br style="clear:both" />
		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
