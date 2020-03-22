<style>
.form-control {
    width: 200px!important;
    float: left !important;
}
#filtertable td {
	font-weight: bold;!important;
}
</style>
<script>
function enableResend(overtime_id) {

			if(!confirm("Are you sure you want to enable the requester to resend the overtime!")) {
				return false;
			}

		 $.ajax({
				 url: "<?php echo Router::url(['controller' => 'Overtimes', 'action' => 'updateresend', true, tracker]); ?>",
				 cache :false,
				 type: 'POST',
				 data: {
						 id: overtime_id
				 },
				 success: function(data) {
						 alert('Updated successfully');
					   window.location.reload();
				 },
				 error: function(data) { alert(data);return;
						 alert('There is a problem with saving the information '+data);
				 }
		 });

	}
</script>
<div class="preovertimes index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Overtimes Managers Report') ?></h1>
        <h4>
          <?php if($who == 4):?><b>All directorates and units</b><?php endif;?>
          <?php if($who == 2):?><b>Directorate: <?php echo $maindetails['Department']['name']; ?></b><?php endif;?>
          <?php if($who == 1):?>
            <b>Directorate</b>: <?php echo $maindetails['Department']['name']; ?>
            <br />
            <b>Unit</b>: <?php

           foreach ($deparsections as $sec) {
            echo $DepartmentSections[$sec];
          }?>
          <?php endif;?>
        </h4>


			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->


	<div class="row">
		<div class="col-md-12">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading" style="padding:5px !important"><?php echo __('Filters'); ?></div>
						<div class="panel-body">
						<?php echo $this->Form->create('Overtime', array('role' => 'form')); ?>
							<table id='filtertable' class="table table-striped table-dark">
								<tr>
									<th colspan='12'>
										Choose the options below depending on what you need
									</th>
									<tr>
										<td>Employee</td>
										<td>
											<div class="form-group">
												<?php echo $this->Form->input('employee', array('class' => 'form-control', 'type' => 'select', 'options' => $employees, 'label' => false, 'placeholder' => 'Tracker'));?>
											</div>
										</td>
										<td>Salary Number</td>
										<td>
											<div class="form-group">
												<?php echo $this->Form->input('salary_number', array('class' => 'form-control', 'label' => false, 'placeholder' => 'Salary Number'));?>
											</div>
										</td>
                    <td><?php if($who != 2):?>Directorate <?php else:?>Units<?php endif;?></td>
										<td>
                      <?php if($who == 1):?>
                        <?php echo $maindetails['Department']['name']; ?>
                      <?php endif;?>
                      <?php if($who == 4):?>
                        <div class="form-group">
  												<?php echo $this->Form->input('department_id', array('class' => 'form-control', 'type' => 'select', 'options' => $depts, 'label' => false, 'style' => 'disabled:disabled!important'));?>
  											</div>
                      <?php endif;?>
                      <?php if($who == 2):?>
                        <div class="form-group">
    											<?php echo $this->Form->input('department_section_id', array('class' => 'form-control', 'type' => 'select', 'options' => $sectins, 'label' => false, 'style' => 'disabled:disabled!important'));?>
    										</div>
                      <?php endif;?>
										</td>
                    <td>
										<div class="form-group">
											<?php echo $this->Form->submit(__('Search >>'), array('class' => 'btn btn-default')); ?>
										</div>
									</td>
								</tr>

							</table>
						<?php echo $this->Form->end() ?>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

<?php
	$total_hours = 0;
?>

		<div class="col-md-12">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
						<th ><?php echo __('Captured by'); ?></th>
						<th ><?php echo __('Name'); ?></th>
						<th ><?php echo __('Year'); ?></th>
						<th ><?php echo __('Month'); ?></th>
						<th ><?php echo __('Salary Number'); ?></th>
						<th ><?php echo __('Directorate'); ?></th>
						<th ><?php echo __('Unit'); ?></th>
						<th ><?php echo __('Town'); ?></th>
						<th ><?php echo __('Work Done'); ?></th>
						<th ><?php echo __('Total hours'); ?></th>
						<th ><?php echo __('Motivation'); ?></th>
						<th ><?php echo __('Status'); ?></th>
						<th ><?php echo __('created'); ?></th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($preovertimes as $preovertime):?>
						<?php if($preovertime['Overtime']['total_hours']):?>
							<tr>
								<td ><?php echo $preovertime['User']['fname'].' '.$preovertime['User']['sname'] ?>&nbsp;</td>
								<td ><?php echo $preovertime['OvertimeRequester']['fist_name'].' '.$preovertime['OvertimeRequester']['last_name'] ?>&nbsp;</td>
								<td ><?php echo $preovertime['Preovertime']['overtime_year']; ?>&nbsp;</td>
								<td ><?php echo h($months[$preovertime['Preovertime']['overtime_month']]); ?>&nbsp;</td>
								<td ><?php echo $preovertime['OvertimeRequester']['salary_number'] ?>&nbsp;</td>
								<td ><?php echo $depts[$preovertime['OvertimeRequester']['department_id']] ?>&nbsp;</td>
								<td ><?php echo $sectins[$preovertime['OvertimeRequester']['department_section_id']] ?>&nbsp;</td>
								<td ><?php echo $preovertime['OvertimeRequester']['town'] ?>&nbsp;</td>
								<td ><?php echo $preovertime['Overtime']['whatsdone'] ?>&nbsp;</td>
								<td ><?php echo h($preovertime['Overtime']['total_hours']); $total_hours += $preovertime['Overtime']['total_hours']; ?>&nbsp;</td>
								<td ><?php echo $preovertime['Overtime']['motivation'] ?></td>
                <td><?php 
                  if($who == 1 || $who == 2){
                    if( ($preovertime['Overtime']['tracker'] != 10) ) { echo 'Approved'; } else { echo "Declined";
                      if($who != 2):
                      if(!$preovertime['Overtime']['enable_resend']):
                    ?>
                      <br />
                      <input type="button" id='button<?php echo $preovertime['Overtime']['id']?>' value="Enable Resend" onclick="enableResend('<?php echo $preovertime['Overtime']['id']?>')" />
                    <?php
                  else:
                    ?>
                  <b>(Enabled for Resend)</b>
                  <?php endif;endif;
                    }
                  }
                   ?>
                 </td>
								<td ><?php echo h($preovertime['Overtime']['created']); ?>&nbsp;</td>
							</tr>
						<?php endif;?>
					<?php endforeach?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="6">
						<b>Overal Hours</b>:
						</td>
						<td colspan="7">
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


</div><!-- end containing of content -->
