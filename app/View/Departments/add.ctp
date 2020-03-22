<div class="departments form">
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
	</style>
	<?php echo $this->Form->create('Department'); ?>
	<fieldset>
		<p class='btn btn-info'>Add New Directorate<p/>
	<?php
		echo $this->Form->input('name', ['class' => 'form-control']);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<br />
<br />
<br />
