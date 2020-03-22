<div class="faults form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Edit Fault'); ?></h1>
			</div>
		</div>
	</div>



	<div class="row">

		<div class="col-md-9">
			<?php echo $this->Form->create('Fault', array('role' => 'form')); ?>

				<div class="form-group">
					<?php echo $this->Form->input('id', array('class' => 'form-control', 'placeholder' => 'Id'));?>
				</div>
			<br  style='clear:both' />
				<div class="form-group">
					<?php echo $this->Form->input('name', array('class' => 'form-control', 'type' => 'text', 'placeholder' => 'Name'));?>
				</div>
			<br  style='clear:both' />
				<div class="form-group">
					<?php echo $this->Form->input('area', array('class' => 'form-control', 'label' => 'Town / Township / Ward number / Location', 'type' => 'textarea', 'placeholder' => 'Area'));?>
				</div>
			<br  style='clear:both' />
				<div class="form-group">
					<?php echo $this->Form->input('address', array('class' => 'form-control', 'label' => 'Street Name', 'type' => 'text', 'placeholder' => 'Address'));?>
				</div>
			<br  style='clear:both' />
				<div class="form-group">
					<?php echo $this->Form->input('status', array('class' => 'form-control', 'placeholder' => 'Status'));?>
				</div>
			<br  style='clear:both' />
				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
