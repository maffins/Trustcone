<style>
.form-control {
    width: 200px!important;
    float: left !important;
}
#filtertable td {
	font-weight: bold;!important;
}
#PreovertimeDepartmentId {disabled:disabled}
</style>
<div class="preovertimes index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Pre Overtime Managers Summary') ?></h1>
        <h4>
          <b>Department</b>: <?php echo $maindetails['Department']['name']; ?>
          <br />
          <b>Section</b>: <?php

           foreach ($deparsections as $sec) {
            echo $DepartmentSections[$sec];
          }?>
        </h4>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->


	<div class="row">

<?php
	$total_hours = 0;
?>

		<div class="col-md-12">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
						<th ><?php echo __('Name'); ?></th>
						<th ><?php echo __('Year'); ?></th>
						<th ><?php echo __('Month'); ?></th>
						<th ><?php echo __('Total hours'); ?></th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($preovertimes as $preovertime): ?>
						<?php if($preovertime['Preovertime']['total_hours']):?>
							<tr>
								<td ><?php echo $preovertime['OvertimeRequester']['fist_name'].' '.$preovertime['OvertimeRequester']['last_name'] ?>&nbsp;</td>
								<td ><?php echo $preovertime['Preovertime']['overtime_year']; ?>&nbsp;</td>
								<td ><?php echo h($months[$preovertime['Preovertime']['overtime_month']]); ?>&nbsp;</td>
								<td ><?php echo h($preovertime['Preovertime']['total_hours']); $total_hours += $preovertime['Preovertime']['total_hours']; ?>&nbsp;</td>
							</tr>
						<?php endif;?>
					<?php endforeach?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2">
						<b>Overal Hours</b>:
						</td>
						<td colspan="2">
							<b><?php echo $total_hours?></b>
						</td>
					</tr>
				</tfoot>
			</table>

			</div><!-- end col md 12 -->
	<br style="clear:both" />	<br style="clear:both" />
	<?php echo $this->Form->submit(__('Export to PDF >>'), array('class' => 'btn btn-default')); ?>
	<br style="clear:both" />	<br style="clear:both" />
  <?php echo $this->Html->link('<< Back to report home', array('controller' => 'Overtimes', 'action' => 'reports'), array('escape' => false)); ?>

	<br style="clear:both" />	<br style="clear:both" />
		</div> <!-- end col md 9 -->
	</div><!-- end row -->
  <br /><br />

</div><!-- end containing of content -->
