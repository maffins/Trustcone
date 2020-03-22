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
      if(!confirm("Are you sure you want to decline all the overtime requests in this directorate")) {
        return false;
      }
      document.getElementById("myBtn").disabled = true;
		} else {
				document.getElementById(declinecomme).style.display = 'none';
        if(!confirm("Are you sure you want to approve all the overtime requests")) {
          return false;
        }
		}

		 $.ajax({
				 url: "<?php echo Router::url(['controller' => 'Overtimes', 'action' => 'escalatedeptsec', true, tracker]); ?>",
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
						 alert('Approved and sent back to salaries ');
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
				<h1><?php echo __('Overtimes ('.$departmentname.') by units CFO Report for '.date('F')) ?></h1>
        <h4>
          <small>Directorate break down report</small>
        </h4>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->


	<div class="row">

		<div class="col-md-12">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading" style="padding:5px !important"><?php echo __(date('F').' - Totals'); ?>  <span style="float:right"> <?php echo $this->Html->link('Municipal summary', array('controller' => 'Overtimes', 'action' => 'index'), array('escape' => false)); ?></span>  <span style="float:right;margin:0 5px 0 5px"> | </span>  <span style="float:right"> <?php echo $this->Html->link('Directorates Summary', array('controller' => 'Overtimes', 'action' => 'directoratebreak'), array('escape' => false)); ?></span></div>
						<div class="panel-body">

              <?php  foreach ($departmentsections as $overtimeRequester):

      								foreach($overtimeRequester['Overtime'] as $reqeuesters) {
      									$total_hours += $reqeuesters['total_hours'];
      									$total_amoun += $reqeuesters['rate'];
      								}
                endforeach;
      				 ?>
							<table id='filtertable' class="table table-striped table-dark">
								<tr>
                </tr>
                <tr>
                  <th>Unit</th>
                  <th>Total Hours</th>
                  <th colspan="2">Amount Rands(R)</th>
                  <?php if(!$mm):?><th>Decision</th><?php endif;?>
                </tr>
                <?php foreach($departmentsections as $key=>$dept): ?>
									<tr>
										<td>
                      <?php echo $this->Html->link($dept[0], array('controller' => 'Overtimes', 'action' => 'directoratebreakdownsingleone', $key), array('escape' => false)); ?>
                    </td>
										<td>
                      <?php if($dept[4]) { echo $dept[4]; } else { echo h($dept[1]); } ?>
										</td>
										<td colspan="2">
                      <?php if($dept[5]) { echo $dept[5]; } else { echo h($dept[2]); } ?>
										</td>
                    <?php if(!$mm):?>
                    <td>
                      <?php if( ($dept[1] != 0 && $dept[3] == 4) || $dept[6] == 1 ):?>
                      <table>
  											<tr>
  												<td>Approve and send</td>
  												<td><input type="radio" name="escalate<?php echo $key ?>" id="escalate<?php echo $key ?>" onclick='escalate("<?php echo $key?>", "1", "5")'></td>
  											</tr>
  											<tr>
  												<td>Decline</td>
  												<td>
  													<input type="radio" name="escalate<?php echo $key ?>" id="escalate<?php echo $key ?>" onclick='escalate("<?php echo $key ?>", "2", "5")'>
  													<div id="decline<?php echo $key ?>" style="display: none">
  															<textarea name="declinecomment<?php echo $key ?>" id="declinecomment<?php echo $key ?>"></textarea>
                                <br />
                                <input type="button" id='myBtn' value="Save reason of decline"  onclick='escalate("<?php echo $key  ?>", "2", "5")'>
  													</div>
  												</td>
  											</tr>
  										</table>
                    <?php else:
                      if( $dept[3] == 6 && $dept[1]) { echo "Approved"; }
                      if( $dept[3] == 7 && $dept[1]) { echo "Declined"; }
                     endif;?>
                    </td>
                  <?php endif;?>
								</tr>
              <?php endforeach;?>
							</table>

						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->



	<br style="clear:both" />	<br style="clear:both" />
	<?php echo $this->Form->submit(__('Export to PDF >>'), array('class' => 'btn btn-default')); ?>
	<br style="clear:both" />	<br style="clear:both" />
  <?php echo $this->Html->link('<< Back to report home', array('controller' => 'Overtimes', 'action' => 'reports'), array('escape' => false)); ?>

	<br style="clear:both" />	<br style="clear:both" />
		</div> <!-- end col md 9 -->
	</div><!-- end row -->
  <br /><br />

</div><!-- end containing of content -->
