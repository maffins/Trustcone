<div class="faults form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Record Fault'); ?></h1>
			</div>
		</div>
	</div>

	<div class="row">
		<style>
			.btn-info {
				width: 60%;
				text-align: left;
			}
			.form-control {
				width: 40%;
			}
			label {
				width: 20%;
				float: left;
			}
			.input {
				margin: 3px 0 3px 0;
			}
		</style>
		<?php echo $this->Flash->render(); ?>

		<div class="col-md-12">
			<?php echo $this->Form->create('Fault', ['enctype' => 'multipart/form-data']); ?>

				<?php echo "<p class='btn btn-info'>Comma separate the names<p/>"; ?>
				<?php echo $this->Form->input('assigned_to', array('label' => 'Enter Names', 'class' => 'form-control', 'type' => 'textarea', 'placeholder' => ''));?>
				<?php echo $this->Form->input('fault_id', array('class' => 'form-control',  'type' => 'hidden', 'value' => $fault_id));?>

			    <?php echo "<br style='clear:both' />"; ?>
			  <?php echo $this->Form->submit(__('Add Comment'), array('class' => 'btn btn-default')); ?>
			<br />
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>