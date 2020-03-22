<style>
.form-control {
    width: 200px!important;
    float: left !important;
}
#filtertable td {
	font-weight: bold;!important;
}
</style>
<div class="preovertimes index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Summary Report') ?></h1>
        <h4>
          <small>All departments included</small>
        </h4>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->

<?php
	$total_hours = 0;
?>

		<div class="col-md-12">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
        <tr>
          <td><b>Month</b></td>
          <td></td>
        </tr>
        <tr>
          <td><b>Total Requesters</b></td>
          <td></td>
        </tr>
        <tr>
          <td><b>Total approved</b></td>
          <td></td>
        </tr>
        <tr>
          <td><b>Total Declined</b></td>
          <td></td>
        </tr>
        <?php if($who == 4):?>
          <tr>
            <td><b>Total Amount</b></td>
            <td></td>
          </tr>
        <?php endif;?>  
			</table>

			</div><!-- end col md 12 -->
	<br style="clear:both" />	<br style="clear:both" />
	<br style="clear:both" />	<br style="clear:both" />
  <?php echo $this->Html->link('<< Back to report home', array('controller' => 'Overtimes', 'action' => 'reports'), array('escape' => false)); ?>

	<br style="clear:both" />	<br style="clear:both" />
		</div> <!-- end col md 9 -->
	</div><!-- end row -->
  <br /><br />

</div><!-- end containing of content -->
