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
      }
		} else {
      if(!confirm("Are you sure you want to approve all the overtime requests")) {
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
				<h1><?php echo __('Overtimes MM Report for '.date('F')) ?></h1>
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

              <?php  foreach ($overtimeRequesters as $overtimeRequester):

      								foreach($overtimeRequester['Overtime'] as $reqeuesters) {
      									$total_hours += $reqeuesters['total_hours'];
      									$total_amoun += $reqeuesters['rate'];
      								}
                endforeach;
      				 ?>
							<table id='filtertable' class="table table-striped table-dark">

                <tr>
                  <th>Whole Municipality</th>
                  <th>Hours</th>
                  <th>Total Amount(R)</th>
                </tr>
									<tr>
										<td>
                      <?php echo $this->Html->link('Total hours', array('controller' => 'Overtimes', 'action' => 'directoratebreak'), array('escape' => false)); ?>
                    </td>
										<td>
                      <?php echo h($total_hours); ?>
										</td>
										<td>
                      <?php echo h($total_amoun); ?>
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
