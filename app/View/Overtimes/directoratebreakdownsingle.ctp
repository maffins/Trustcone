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
function escalate(id, decision, tracker) {

		var comment = '';
		var declinecomme = "decline"+id; //close the comment box if for some reason the person decides to approve
		//Check if its declined then open the comment box if its empty
		if(decision == 2) {

			//Now check if we have a comment already
			var commentboxid = "declinecomment"+id;
			var comment = document.getElementById(commentboxid).value;
			if(!comment){
				//now open the box to enter the comment
				document.getElementById(declinecomme).style.display = 'block';
				return false;
			}
			if(!confirm("Are you sure you want decline the overtime requests")) {
				return false;
			}
      document.getElementById(commentboxid).style.backgroundColor = "yellow";
      document.getElementById("myBtn").disabled = true;
		} else {
				document.getElementById(declinecomme).style.display = 'none';
        if(!confirm("Are you sure you want to approve this request!")) {
          return false;
        }
		}

		 $.ajax({
				 url: "<?php echo Router::url(['controller' => 'Overtimes', 'action' => 'escalatesinglelast', true]); ?>",
				 cache :false,
				 type: 'POST',
				 data: {
						 id: id,
						 decision: decision,
						 comment: comment,
				 },
				 success: function(data) {
					 if(decision == 1)
					 {
						 alert('Approved and sent back to salaries');
					 } else {
						 alert('Declined and sent back to the requester');
					 }
					 window.location.reload();
				 },
				 error: function(data) { alert(data);return;
						 alert('There is a problem with savign the information '+data);
				 }
		 });

	}
</script>

<div class="preovertimes index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Overtimes CFO Report') ?></h1>
        <h4>
          <b>Department</b>: <?php echo $DepartmentName; ?>
          <br />
          <b>Unit</b>: <?php echo $DepartmentSectionsname?>
        </h4>

			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->

<?php
	$total_hours = 0;
?>

		<div class="col-md-12">
    <div class="panel-heading" style="padding:5px !important"><?php echo __(date('F').' - Totals'); ?>  <span style="float:right"> <?php echo $this->Html->link('Municipal summary', array('controller' => 'Overtimes', 'action' => 'index'), array('escape' => false)); ?></span>  <span style="float:right;margin:0 5px 0 5px"> | </span>  <span style="float:right"> <?php echo $this->Html->link('Directorates Summary', array('controller' => 'Overtimes', 'action' => 'directoratebreak'), array('escape' => false)); ?></span></div>
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
						<th ><?php echo __('Name'); ?></th>
						<th ><?php echo __('Salary Number'); ?></th>
						<th ><?php echo __('Department'); ?></th>
						<th ><?php echo __('Town'); ?></th>
						<th ><?php echo __('Month'); ?></th>
						<th ><?php echo __('Year'); ?></th>
						<th ><?php echo __('Work Done'); ?></th>
						<th ><?php echo __('Claimed hours'); ?></th>
						<th ><?php echo __('Total Amount(R)'); ?></th>
						<?php if(!$mm):?><th ><?php echo __('Decide'); ?></th><?php endif;?>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($preovertimes as $preovertime):?>
						<?php if($preovertime['Overtime']['total_hours']):?>
							<tr>
								<td ><?php echo $preovertime['OvertimeRequester']['first_name'].' '.$preovertime['OvertimeRequester']['last_name'] ?>&nbsp;</td>
								<td ><?php echo $preovertime['OvertimeRequester']['salary_number'] ?>&nbsp;</td>
								<td ><?php echo $depts[$preovertime['OvertimeRequester']['department_id']] ?>&nbsp;</td>
								<td ><?php echo $preovertime['OvertimeRequester']['town'] ?>&nbsp;</td>
								<td ><?php echo h($months[$preovertime['Preovertime']['overtime_month']]); ?>&nbsp;</td>
								<td ><?php echo $preovertime['Preovertime']['overtime_year']; ?>&nbsp;</td>
								<td ><?php echo $preovertime['Overtime']['whatsdone'] ?>&nbsp;</td>
								<td ><?php echo h($preovertime['Overtime']['total_hours']); $total_hours += $preovertime['Overtime']['total_hours']; ?>&nbsp;</td>
								<td ><?php echo $preovertime['Overtime']['rate'] ?></td>
                <?php if(!$mm):?>

                  <td >
                    <?php if($preovertime['Overtime']['tracker'] == 4):?>
                    <table>
                      <tr>
                        <td>Approve and send</td>
                        <td><input type="radio" name="escalate<?php echo $preovertime['Overtime']['id'] ?>" id="escalate<?php echo $preovertime['Overtime']['id'] ?>" onclick='escalate("<?php echo $preovertime['Overtime']['id']?>", "1", "5")'></td>
                      </tr>
                      <tr>
                        <td>Decline</td>
                        <td>
                          <input type="radio" name="escalate<?php echo $preovertime['Overtime']['id'] ?>" id="escalate<?php echo $preovertime['Overtime']['id'] ?>" onclick='escalate("<?php echo $preovertime['Overtime']['id'] ?>", "2", "5")'>
                          <div id="decline<?php echo $preovertime['Overtime']['id'] ?>" style="display: none">
                              <textarea name="declinecomment<?php echo $preovertime['Overtime']['id'] ?>" id="declinecomment<?php echo $preovertime['Overtime']['id'] ?>"></textarea>
                              <br />
                              <input type="button" id='myBtn' value="Save reason of decline"  onclick='escalate("<?php echo $preovertime['Overtime']['id']  ?>", "2", "5")'>
                          </div>
                        </td>
                      </tr>
                    </table>
                  <?php else:
                      if($preovertime['Overtime']['tracker'] == 6){ echo "Approved"; }
                      if($preovertime['Overtime']['tracker'] == 7){ echo "Declined"; }
                   endif;?>
                  </td>
              <?php endif;?>
							</tr>
						<?php endif;?>
					<?php endforeach?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="6">
						<b>Overal Hours</b>:
						</td>
						<td colspan="6">
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
