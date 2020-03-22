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
				<?php echo "<p class='btn btn-info'>Fault details<p/>"; ?>
			    <?php
                   $faultnames = ['0' => '-- Select Fault --', 'Burst pipe' => 'Burst pipe', 'Leaking sewerage' => 'Leaking sewerage', 'Power failure' => 'Power failure', 'Water disruption' => 'Water disruption', 'Other' => 'Other'];
                ?>
                <?php echo $this->Form->input('name', array('label' => 'Fault Name', 'class' => 'form-control', 'type' => 'select', 'options' => $faultnames));?>
             <div id='showother' style='clear: both;display: none'>
                <?php echo $this->Form->input('nameother', array('label' => 'Other', 'class' => 'form-control', 'type' => 'text', 'placeholder' => ''));?>
			</div>
            <?php echo "<br style='clear:both' />"; ?>
            <?php echo $this->Form->input('date_started', array('label' => 'Date fault reported', 'id' => 'DocumentDocumentDate', 'class' => 'form-control', 'type' => 'text', 'placeholder' => 'YYYY-MM-DD'));?>

            <br  style='clear:both' />
			<br  style='clear:both' />
            <?php echo "<p class='btn btn-info'>Location details<p/>"; ?>
			<?php echo $this->Form->input('area', array('label' => 'Location', 'type' => 'text', 'class' => 'form-control', 'placeholder' => 'Location'));?>
			<?php echo "<br style='clear:both' />"; ?>
			<?php echo $this->Form->input('wardnumber', array('label' => 'Ward number', 'type' => 'text', 'class' => 'form-control', 'placeholder' => 'Ward number'));?>
			<?php echo "<br style='clear:both' />"; ?>
					<?php echo $this->Form->input('address', array('label' => 'Street Name', 'type' => 'text', 'class' => 'form-control', 'placeholder' => 'Street Name'));?>
				<?php echo "<br style='clear:both' />"; ?>
			  <?php echo $this->Form->submit(__('Report fault'), array('class' => 'btn btn-default')); ?>
			<br />
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
<script>

    $( "#FaultName" ).change(function() {

        if($( "#FaultName" ).val() == 'Other')
		{
            $( "#showother" ).slideDown( "slow");
		} else {

            $( "#showother" ).slideUp( "slow");
        }
    });

    // When the document is ready
    $(document).ready(function () {
        $('#DocumentDocumentDate').datepicker({
            format: "yyyy-mm-dd"
        });

    });
</script>