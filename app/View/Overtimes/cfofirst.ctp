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
function escalatecfo(decision) {

		var comment = '';
		var declinecomme = "decline1"; //close the comment box if for some reason the person decides to approve

		if(decision == 2) {
			//Now check if we have a comment already
			var commentboxid = "declinecomment1";
			var comment = document.getElementById(commentboxid).value;
			if(!comment){
				//now open the box to enter the comment
				document.getElementById(declinecomme).style.display = 'block';
				return false;
			}
      if(!confirm("Are you sure you want to decline all the overtime requests")) {
        return false;
        document.getElementById("decline1'").checked = false;
      }
      document.getElementById("myBtn").disabled = true;
		} else {
      if(!confirm("Are you sure you want to approve all the overtime requests")) {
        document.getElementById("escalatecfo1'").checked = false;
        return false;
      }
				document.getElementById(declinecomme).style.display = 'none';
		}

		 $.ajax({
				 url: "<?php echo Router::url(['controller' => 'Overtimes', 'action' => 'escalatecfo', true]); ?>",
				 cache :false,
				 type: 'POST',
				 data: {
						 id: 1,
						 decision: decision,
						 comment: comment,
				 },
				 success: function(data) {
					 if(decision == 1)
					 {
						 alert('Approved and finalized ');
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
				<h1><?php echo __('Overtimes CFO Report for '.date('F')) ?></h1>
        <h4>
          <small>All departments included</small>
        </h4>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->


	<div class="row">

		<div class="col-md-12">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading" style="padding:5px !important"><?php echo __(date('F').' - Totals'); ?></div>
						<div class="panel-body">

              <?php $come_to_zero = 0; foreach ($overtimeRequesters as $overtimeRequester):

      								foreach($overtimeRequester['Overtime'] as $reqeuesters) {
      									$total_hours += $reqeuesters['total_hours'];
      									$total_amoun += $reqeuesters['rate'];
                        if($reqeuesters['tracker'] == 7) {
                          $approved = 1;
                        }
                        if($reqeuesters['tracker'] == 6) {
                          $approved = 2;
                          $total_hours2 += $reqeuesters['total_hours'];
                          $total_amoun2 += $reqeuesters['rate'];
                        }
                        if($reqeuesters['tracker'] == 4) {
                          $approved = 0;
                          $come_to_zero = 1;
                          $total_hours1 += $reqeuesters['total_hours'];
                          $total_amoun1 += $reqeuesters['rate'];
                        }
      								}
                endforeach;
      				 ?>
							<table id='filtertable' class="table table-striped table-dark">

                <tr>
                  <th>Whole Municipality</th>
                  <th>Hours</th>
                  <th colspan="2">Total Amount(R)</th>
                  <th>Decision</th>
                </tr>
									<tr>
										<td>
                      <?php echo $this->Html->link('Total hours', array('controller' => 'Overtimes', 'action' => 'directoratebreak'), array('escape' => false)); ?>
                    </td>
										<td>
                      <?php if($come_to_zero == 1) { echo $total_hours1; } else {
                        if($approved == 2) {echo h($total_hours2); } else { echo h($total_hours); }
                         }  ?>
										</td>
										<td>Total Amount</td>
										<td>
                      <?php if($come_to_zero == 1) { echo $total_amoun1; } else {
                        if($approved == 2) {echo h($total_amoun2); } else { echo h($total_amoun); }
                         } ?>
										</td>
                    <td>
                    <?php
                    if($approved == 0 || $come_to_zero == 1):
                      if($total_amoun != 0):?>
                      <table>
                        <?php if($total_amoun > 2600000):?>
                          <tr>
                            <td colspan="2">
                              <b style="color:red">The total amount of R<?php echo $total_amoun;?> <br />is above the R2 600 000 limit and <br />therefore cannot be approved</b>
                            </td>
                          </tr>
                        <?php else:?>
  											<tr>
  												<td>Approve and finalize</td>
  												<td><input type="radio" name="escalatecfo1" id="escalatecfo1" onclick='escalatecfo("1")'></td>
  											</tr>
                      <?php endif;?>
  											<tr>
  												<td>Decline</td>
  												<td>
  													<input type="radio" name="escalatecfo1" id="escalatecfo2" onclick='escalatecfo("2")'>
  													<div id="decline1" style="display: none">
  															<textarea name="declinecomment1" id="declinecomment1"></textarea>
                                <br />
                                <input type="button" id='myBtn' value="Save reason of decline"  onclick='escalatecfo("2")'>
  													</div>
  												</td>
  											</tr>
  										</table>
                    <?php else:
                    endif;
                  else:
                      if($approved == 1) { echo "Declined"; }
                      if($approved == 2) { echo "Approved"; }
                    endif;
                    ?>

                    </td>
								</tr>

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
