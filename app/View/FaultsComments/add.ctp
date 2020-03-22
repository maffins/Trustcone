<div class="faultsComments form">
<style>
	.input {
		margin: 3px 0 5px 0;
	}
</style>
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Add Fault Comment'); ?></h1>
			</div>
		</div>
	</div>

		<div class="col-md-12">
			<?php echo $this->Form->create('FaultsComment', array('role' => 'form')); ?>
				<div class="form-group">
					<?php echo $this->Form->input('fault_id', array('class' => 'form-control',  'disabled' => 'disabled', 'placeholder' => 'Fault Id'));?>
					<?php echo $this->Form->input('fault_id_now', array('class' => 'form-control',  'type' => 'hidden', 'value' => $fault_id));?>
				</div>
			<br  style='clear:both' />
				<div class="form-group">
					<?php echo $this->Form->input('comment', array('class' => 'form-control', 'placeholder' => 'Your Comment'));?>
				</div>
			<?php if($user_type_id == 9): ?>
			<br  style='clear:both' />
				<div class="form-group">
					<?php echo $this->Form->input('comment_response', array('class' => 'form-control', 'placeholder' => 'Comment Response'));?>
				</div>
			<?php endif; ?>
			<br  style='clear:both' />
				<div class="form-group">
					<?php echo $this->Form->submit(__('Add comment'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
