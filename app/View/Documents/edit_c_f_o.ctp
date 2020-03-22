<div class="form-vertical" style="margin-top: -10px;">
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
	<?php echo $this->Flash->render(); ?>

	<?php echo $this->Form->create('Document', ['enctype' => 'multipart/form-data']); ?>
	<fieldset>
        <a href="/Documents/index" class="button">  << Back</a> <br />
        <legend><?php echo __('Add Document for signing'); ?></legend>

        <?php
		echo $this->Form->input('id');

	    echo "<p class='btn btn-info'>Department<p/>";
		echo $this->Form->input('department_id', ['label' => __('Document from which Directories'), 'class' => 'form-control']);

		echo "<br /><p class='btn btn-info'>Contact Details<p/>";
		echo "<br style='clear:both' />";
		echo $this->Form->input('fname', array('label' => __('First Name'), 'class' => 'form-control'));
		echo "<br style='clear:both' />";
		echo $this->Form->input('sname', array('label' => __('Van'), 'class' => 'form-control'));
		echo "<br style='clear:both' />";
		echo $this->Form->input('email', ['required' => 'required', 'class' => 'form-control']);
		echo "<br style='clear:both' />";
		echo $this->Form->input('cellnumber', ['required' => 'required', 'class' => 'form-control']);
		echo "<br style='clear:both' />";
		echo "<br /><p class='btn btn-info'>Document Details<p/>";
		echo "<br style='clear:both' />";
		echo $this->Form->input('name', array('label' => 'Document type', 'class' => 'form-control'));
		echo "<br style='clear:both' />";
		$options = ['' => '- Select -', 'normal' => 'Normal', 'low' => 'Low', 'high' => 'High'];
		echo $this->Form->input('priority', array('label' => 'Document priority', 'type' => 'select', 'options' => $options, 'class' => 'form-control'));
		echo "<br style='clear:both' />";
		echo "<br /><p class='btn btn-info'>Upload the document *</p>";
		echo "<br style='clear:both' />";echo "<br style='clear:both' />";
		echo $this->Form->input('compiled_document', array('label' => 'Upload here', 'type' => 'file', 'class' => 'form-control'));
		echo "<br style='clear:both' />";
		echo $this->Form->input('document_date', array('label' => 'Document Date <br />(<small>YYYY-mm-dd</small>)', 'class' => 'form-control datepicker', 'type' => 'text'));
		echo "<br style='clear:both' />";
		echo $this->Form->input('edit_reason', array('label' => 'What you have done', 'required' => 'required', 'class' => 'form-control', 'type' => 'textarea'));

		?>
	</fieldset>
	<br />
	<?php echo $this->Form->end(__('Send Document'), ['class' => 'btn btn-default']); ?>
</div>

<script>
	// When the document is ready
	$(document).ready(function () {
		$('#DocumentDocumentDate').datepicker({
			format: "yyyy-mm-dd"
		});

	});
</script>

