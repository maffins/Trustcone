<style>
		.paginate_button {
				padding: 5px;
				background-color: yellow;
				font-weight: bold;
				margin: 3px;
				border: 1px solid black;
		}
		ul {
				list-style-type: none;
				margin: 0;
				padding: 0;
				overflow: hidden;
				background-color: #333333;
		}

		li {
				float: left;
		}

		li a {
				display: block;
				color: white !important;
				text-align: center;
				padding: 16px;
				text-decoration: none;
		}

		li a:hover {
				background-color: #111111;
		}
		h2 {
			width: 35%;
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
			if(!confirm("Are you sure you want to decline this request!")) {
				return false;
			}

		} else {
				document.getElementById(declinecomme).style.display = 'none';
				if(!confirm("Are you sure you want to approve this requests")) {
					return false;
				}
		}

		 $.ajax({
				 url: "<?php echo Router::url(['controller' => 'Overtimes', 'action' => 'escalate', true, tracker]); ?>",
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
						 alert('Approved and escalated');
					 } else {
						 alert('Declined and sent back to the requester');
					 }
					 window.location.reload();
				 },
				 error: function(data) { alert(object.toSource());return;
						 alert('There is a problem with savign the information '+data);
				 }
		 });

	}

	function EditAgain(overtime_id, overtime_requester_id) {
		if(!confirm("Are you sure you want to edit and send to manager again?")) {
			return false;
		}
		window.location.href = '/Overtimes/editagain/'+overtime_id+'/'+overtime_requester_id;
	}

	function escalateResend(overtime_id) {

				if(!confirm("Are you sure you want to resend this to manager!")) {
					return false;
				}

			 $.ajax({
					 url: "<?php echo Router::url(['controller' => 'Overtimes', 'action' => 'resendtomanager', true, tracker]); ?>",
					 cache :false,
					 type: 'POST',
					 data: {
							 id: overtime_id
					 },
					 success: function(data) {

						alert('Sent to manager successfully');
						 window.location.reload();
					 },
					 error: function(data) { alert(data);return;
							 alert('There was a problem with the resend to manager.'+data);
					 }
			 });

		}
</script>
<div class="overtimes index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Overtime Captured by: '.$overtimeRequester['User']['fname'].' '.$overtimeRequester['User']['sname']); ?></h1>
					<h4>
						<?php if($approver == 1):?>
							Managers view
						<?php endif;?>
						<?php if($approver == 2):?>
							Director view
						<?php endif;?>
						<?php if($approver == 3):?>
							Salaries view
						<?php endif;?>
						<?php if($approver == 4):?>
							CFO view
						<?php endif;?>
					</h4>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->

	<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Back to Requesters'), array('action' => 'index'), array('escape' => false)); ?></li>

	<div class="row">
   <?php if(!$approver && !$tracker):?>
			<div class="col-md-3">
				<div class="actions">
					<div class="panel panel-default">
						<div class="panel-heading"><?php echo __('Actions'); ?></div>
							<div class="panel-body">
								<ul class="nav nav-pills nav-stacked">
									<?php if(!$tracker):
										if(!$overtimes[0]['Overtime']['id']) {
											$naming = 'New Overtime';
										} else {
											$naming = 'Add more days';
										}

										?>
										<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__($naming), array('action' => 'add', $overtimeRequester_id, $tracker), array('escape' => false)); ?></li>
								 	<?php endif;?>
								</ul>
							</div><!-- end body -->
					</div><!-- end panel -->
				</div><!-- end actions -->
		 <?php endif;?>
		</div><!-- end col md 3 -->

 <?php if(!$approver):?>
		<div class="col-md-9">
 <?php else: ?>
	  <div class="col-md-12">
 <?php endif;?>
			<table cellpadding="0" cellspacing="0" class="table table-striped" style="margin: 0 auto" id="fidu-tables-s">
				<thead>
					<tr>
						<th ><?php echo __('id'); ?></th>
						<th ><?php echo __('Employee Name'); ?></th>
						<th ><?php echo __('Pay Number'); ?></th>
						<th ><?php echo __('Pre Approved Action'); ?></th>
						<th ><?php echo __('Level'); ?></th>
						<th ><?php echo __('Period'); ?></th>
						<th ><?php echo __('Overtime Date'); ?></th>
						<th ><?php echo __('start_time'); ?></th>
						<th ><?php echo __('end_time'); ?></th>
						<th style='background:yellowgreen' ><?php echo __('Pre Approved hours'); ?></th>
						<th ><?php echo __('Claimed hours'); ?></th>
						<?php if($approver == 4):?>
							<th ><?php echo __('Rate'); ?></th>
							<th ><?php echo __('Total(R)'); ?></th>
						<?php endif;?>
						<th ><?php echo __('Work done'); ?></th>
						<th ><?php echo __('Motivation'); ?></th>
						<th <?php if(!$approver):?>style="display:none" <?php endif;?> ><?php echo __('Decision'); ?></th>
						<?php if(!$approver == 4):?>
							<th style="display:none" ><?php echo __('Reason for Approval/Decline'); ?></th>
						<?php endif;?>
						<th ><?php echo __('Reason'); ?></th>
						<th ><?php echo __('Status'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($overtimes as $overtime):?>
					<tr <?php if($overtime['Overtime']['linked_to'] != 0) { ?> style=""<?php } ?> >
						<td ><?php echo h($overtime['Overtime']['id']); ?>&nbsp;</td>
						<td>
						<?php echo $this->Html->link($overtime['OvertimeRequester']['first_name'].' '.$overtime['OvertimeRequester']['last_name'], array('controller' => 'users', 'action' => 'view', $overtime['OvertimeRequester']['id'])); ?>
						<?php if( ($overtime['Overtime']['linked_to'] != 0) && ($overtime['Overtime']['tracker'] == 0) ) { ?>
							<input type="button" value="Resend to manager"  onclick='escalateResend("<?php echo $overtime['Overtime']['id']  ?>")'>

						<?php } else {
							if($overtime['Overtime']['linked_to'] != 0) {
								echo $this->Html->link('<br /><br /><b>Click here for original request</b>', array('action' => 'view', $overtime['Overtime']['linked_to']), array('escape' => false));
							}
						} ?>
					</td>
					<td ><?php echo h($overtime['OvertimeRequester']['salary_number']); ?>&nbsp;</td>
					<td>
						<?php echo $overtime['Preovertime']['whatsdone'];?>
					</td>
		<td >
			<?php
			  if($overtime['Overtime']['tracker'] == 10) {
					echo 'Declined by manager';
				}
			  if($overtime['Overtime']['tracker'] == 6) {
					echo 'Declined by CFO';
				}
			  if($overtime['Overtime']['tracker'] == 5) {
					echo 'Approved by CFO';
				}
			  if($overtime['Overtime']['tracker'] == 11) {
					echo 'Declined by director';
				}
				if($overtime['Overtime']['tracker'] == 100) {
					echo "<b style='color:red'>Edited</b> <br />";
			  }
				if($overtime['Overtime']['tracker'] == 0) {
					echo "<b>Initial Stage</b> <br />";
			  }
				if($overtime['Overtime']['tracker'] == 1) {
					echo "<b>Management</b> <br />";
			  }
				if($overtime['Overtime']['tracker'] == 2) {
					echo "<b>Director </b> <br />";
			  }
				if($overtime['Overtime']['tracker'] == 3) {
					echo "<b>Salaries View </b> <br />";
			  }
				if($overtime['Overtime']['tracker'] == 4) {
					echo "<b>Waiting to be sent to CFO </b> <br />";
			  }
				if($overtime['Overtime']['tracker'] == 5) {
					echo "<b>CFO </b> <br />";
			  }
				echo $overtime['Department']['name'];
			?>&nbsp;
	 </td>
						<td ><?php echo h($period[$overtime['Overtime']['period']]); ?>&nbsp;</td>
				 		<td ><?php echo h($overtime['Overtime']['overtime_date']); ?>&nbsp;</td>
						<td ><?php echo h($overtime['Overtime']['start_time']); ?>&nbsp;</td>
						<td ><?php echo h($overtime['Overtime']['end_time']); ?>&nbsp;</td>
						<td style='background:yellowgreen'><?php

							if($overtime['Overtime']['period'] == 1) {
								 echo $overtime['Preovertime']['weekday'];
							}
							if($overtime['Overtime']['period'] == 2) {
								 echo $overtime['Preovertime']['saturday'];
							}
							if($overtime['Overtime']['period'] == 3) {
								 echo $overtime['Preovertime']['sunday'];
							}
							if($overtime['Overtime']['period'] == 4) {
								 echo $overtime['Preovertime']['public_holiday'];
							}
					 ?>&nbsp;</td>
						<td ><?php echo h($overtime['Overtime']['total_hours']); ?>&nbsp;</td>
						<?php if($approver == 4):?>
							<td ><?php echo h($overtime['Overtime']['rate']); ?></td>
							<td >R<?php echo h($overtime['Overtime']['rate']); ?></td>
						<?php endif;?>
						<td ><?php echo h($overtime['Overtime']['whatsdone']); ?>&nbsp;</td>
						<td ><?php echo h($overtime['Overtime']['motivation']); ?>&nbsp;</td>
						<td <?php if(!$approver):?>style="display:none" <?php endif;?>>
						<?php

							if(($overtime['Overtime']['tracker'] == 1 && $approver) || ($overtime['Overtime']['tracker'] == 2 && $approver) || ($overtime['Overtime']['tracker'] == 4 && $approver)){
								if( ($overtime['Overtime']['tracker'] == 3) || ($overtime['Overtime']['tracker'] == 1 && $approver) || ($overtime['Overtime']['tracker'] == 2 && $approver) ):
						?>
									<table>
										<tr>
											<td>Approve and send</td>
											<td><input type="radio" name="escalate<?php echo $overtime['Overtime']['id'] ?>" id="escalate<?php echo $overtime['Overtime']['id'] ?>" onclick='escalate("<?php echo $overtime['Overtime']['id']?>", "1", "<?php echo $overtime['Overtime']['tracker']?>")'></td>
										</tr>
										<tr>
											<td>Decline</td>
											<td>
												<input type="radio" name="escalate<?php echo $overtime['Overtime']['id'] ?>" id="escalate<?php echo $overtime['Overtime']['id'] ?>" onclick='escalate("<?php echo $overtime['Overtime']['id'] ?>", "2", "<?php echo $overtime['Overtime']['tracker']?>")'>
												<div id="decline<?php echo $overtime['Overtime']['id'] ?>" style="display: none">
				                    <textarea name="declinecomment<?php echo $overtime['Overtime']['id'] ?>" id="declinecomment<?php echo $overtime['Overtime']['id'] ?>"></textarea>
				                    <input type="button" value="Save reason of decline"  onclick='escalate("<?php echo $overtime['Overtime']['id']  ?>", "2", "<?php echo $overtime['Overtime']['tracker']?>")'>
				                </div>
											</td>
										</tr>
									</table>

									<?php
								endif;
								} else if($overtime['Overtime']['tracker'] == 5 || $overtime['Overtime']['tracker'] == 11 || $overtime['Overtime']['tracker'] == 6 || $overtime['Overtime']['tracker'] == 12 || $overtime['Overtime']['tracker'] == 10) {
										if ( $overtime['Overtime']['tracker'] == 5) {
											echo 'Final approval granted by CFO';
										} else {
											echo 'Declined by CFO';
										}

										if ( $overtime['Overtime']['tracker'] != 5 && $overtime['Overtime']['tracker'] != 6 ) {
									?>
										<br /><input type="button" value="Processed" onclick="archive('<?php echo $overtime['Overtime']['id']?>')">
									<?php
								 }
								}
						?>&nbsp;

						<?php
						if ( $overtime['Overtime']['tracker'] != 5 && $overtime['Overtime']['tracker'] != 6 && $overtime['Overtime']['tracker'] != 1  && $overtime['Overtime']['tracker'] != 2 ) {
							if($approver == 3 && $overtime['Overtime']['tracker'] == 3):?>
								<input type="text" id='rate<?php echo $overtime['Overtime']['id']?>' value="<?php echo $overtime['Overtime']['rate'] ?>" /> <br /><input type="button" id='button<?php echo $overtime['Overtime']['id']?>' value="Total amount(R)" onclick="saveRate('<?php echo $overtime['Overtime']['id']?>', 'rate<?php echo $overtime['Overtime']['id']?>', 'button<?php echo $overtime['Overtime']['id']?>')" />
							<?php
						else:
							echo $overtime['Overtime']['rate'];
						  endif;
						}
							?>
					</td>
					<?php if(!$approver == 4):?>
						<td  >
										<?php
											foreach($overtime['OvertimeReason'] as $docTracker) {
												echo h($docTracker['reason']).'<br />---------------<br/>';
											}
										 ?>
							</td>
					<?php endif;?>
						<td style="" ><?php
						if($overtime['Overtime']['tracker'] == 10 || $overtime['Overtime']['tracker'] == 11 || $overtime['Overtime']['tracker'] == 6 ) {
							if($overtime['Overtime']['enable_resend'] == 1):
							?>
							<input type="button" id='button<?php echo $overtime['Overtime']['id']?>' value="Edit and send back to Manager" onclick="EditAgain('<?php echo $overtime['Overtime']['id']?>', '<?php echo $overtime['Overtime']['overtime_requester_id']?>')" />
							<?php
						endif;
						} else {
							if($overtime['Overtime']['tracker'] == 2) {
								echo "Approved by Manager";
							}
							if($overtime['Overtime']['tracker'] == 3) {
								echo "Approved by Director";
							}
						}

						 ?>&nbsp;</td> <td></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<br style="clear:both" />
			<br style="clear:both" />
			<div class="form-group">
				<?php
					if($overtime['Overtime']['tracker'] == 0 && $overtime['Overtime']['tracker'] != ''){
						echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>Send Overtime to Manager', array('action' => 'sendovertime', $overtimeRequester['OvertimeRequester']['id']), array('escape' => false));
					}
				?>
				<?php
				if ( $overtime['Overtime']['tracker'] != 5 && $overtime['Overtime']['tracker'] != 6 ) {
					if($approver == 3):?>
						 <input style="display:none" type="button" id='button<?php echo $overtimeRequester['OvertimeRequester']['id']?>' value="Send to CFO" onclick="submittoCFO('<?php echo $overtimeRequester['OvertimeRequester']['id']?>')" />
					<?php endif;
				}
					?>
			</div>
			<br style="clear:both" />
		</div> <!-- end col md 9 -->
	</div><!-- end row -->


</div><!-- end containing of content -->

<script>

    $(document).ready(function() {
        $('#fidu-tables').DataTable();
    } );


function submittoCFO(Overtimerequester_id) {

	$.ajax({
			url: "<?php echo Router::url(['controller' => 'Overtimes', 'action' => 'sendtocfo', true]); ?>",
			cache :false,
			type: 'POST',
			data: {
					id: Overtimerequester_id
			},
			success: function(data) {
					alert('Sent to CFO succesfully');
					window.location.reload();
			},
			error: function(data) {
					alert('There is a problem sending to CFO '+data);
			}
	});
}

function saveRate(Overtimeid, FieldIid, buttonId) {
	var Rate = $('#'+FieldIid).val();
	$.ajax({
			url: "<?php echo Router::url(['controller' => 'Overtimes', 'action' => 'saverate', true]); ?>",
			cache :false,
			type: 'POST',
			data: {
					id: Overtimeid,
					rate: Rate
			},
			success: function(data) {
					$('#'+FieldIid).prop('disabled', true);
					$('#'+buttonId).prop('disabled', true);
					alert('Rate succesfully saved');
			},
			error: function(data) {
					alert('There is a problem in archiving your document for final time '+data);
			}
	});

}

function archive(id) {

    $.ajax({
        url: "<?php echo Router::url(['controller' => 'Overtimes', 'action' => 'finalclose', true]); ?>",
        cache :false,
        type: 'POST',
        data: {
            id: id
        },
        success: function(data) {
            alert('Document succesfully archived');
						window.location.reload();
        },
        error: function(data) {
            alert('There is a problem in archiving your document for final time '+data);
        }
    });
}

function approveSave(id, checkboxID, tafuraID, checkboxDeclinedID) {
    if (document.getElementById(checkboxID).checked) {

        $.ajax({
            url: "<?php echo Router::url(['controller' => 'Overtimes', 'action' => 'approved', true]); ?>",
            cache :false,
            type: 'POST',
            data: {
                id: id,
            },
            success: function(data) {
                alert('Approval done and notifications sent to the owner and the secretaray');
                document.getElementById(checkboxID).setAttribute('disabled', 'disabled');
                document.getElementById(checkboxDeclinedID).setAttribute('disabled', 'disabled');
                document.getElementById(tafuraID).style.backgroundColor = 'green';
            },
            error: function(data) {
                alert('There is a problem approve save  '+data);
            }
        });
    }
}

</script>
