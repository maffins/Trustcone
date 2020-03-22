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
				<h1><?php echo __('Overtimes Report') ?></h1>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->


		<div class="col-md-12">

			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
						<th ><?php echo __('Name'); ?></th>
						<th ><?php echo __('Salary Number'); ?></th>
						<th ><?php echo __('Directorate'); ?></th>
						<th ><?php echo __('Town'); ?></th>
						<th ><?php echo __('Month'); ?></th>
						<th ><?php echo __('Year'); ?></th>
						<th ><?php echo __('Claimed hours'); ?></th>
						<th ><?php echo __('Total Amount(R)'); ?></th>
						<th ><?php echo __('Decide'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($data as $preovertime):?>
							<tr>
								<td ><?php echo $preovertime['OvertimeRequester']['first_name'].' '.$preovertime['OvertimeRequester']['last_name'] ?>&nbsp;</td>
								<td ><?php echo $preovertime['OvertimeRequester']['salary_number'] ?>&nbsp;</td>
								<td ><?php echo $depts[$preovertime['OvertimeRequester']['department_id']] ?>&nbsp;</td>
								<td ><?php echo $preovertime['OvertimeRequester']['town'] ?>&nbsp;</td>
								<td ><?php echo h($months[$preovertime['Preovertime']['overtime_month']]); ?>&nbsp;</td>
								<td ><?php echo $preovertime['Preovertime']['overtime_year']; ?>&nbsp;</td>
								<td ><?php echo $preovertime[0]['total_sum'] ?></td>
								<td ><?php echo h($preovertime[0]['total_amount']); ?>&nbsp;</td>
								<td ><?php if( $preovertime['Overtime']['tracker'] == 6) { echo "Approved"; } else { echo "Declined"; } ?></td>
							</tr>
					<?php endforeach?>
				</tbody>
			</table>

			</div><!-- end col md 12 -->
	<br style="clear:both" />	<br style="clear:both" />
	<?php echo $this->Form->submit(__('Export to PDF >>'), array('class' => 'btn btn-default')); ?>
	<br style="clear:both" />	<br style="clear:both" />
  <?php echo $this->Html->link('<< Back to report home', array('controller' => 'Overtimes', 'action' => 'reports'), array('escape' => false)); ?>
	<br style="clear:both" />	<br style="clear:both" />
		</div> <!-- end col md 9 -->
	</div><!-- end row -->


</div><!-- end containing of content -->
