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
<div class="overtimes index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Overtimes') ?></h1>
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

	  <div class="col-md-12">
 		<table cellpadding="0" cellspacing="0" class="table table-striped" style="margin: 0 auto" id="fidu-tables-s">
				<thead>
					<tr>
						<th ><?php echo __('Employee Name'); ?></th>
						<th ><?php echo __('Pay Number'); ?></th>
						<th ><?php echo __('Directorate'); ?></th>
						<th ><?php echo __('Unit'); ?></th>
						<th ><?php echo __('Period'); ?></th>
						<th ><?php echo __('Overtime Date'); ?></th>
						<th style='background:yellowgreen' ><?php echo __('Pre Approved hours'); ?></th>
						<th ><?php echo __('Claimed hours'); ?></th>
						<th ><?php echo __('Save Amounts (R)'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($overtimes as $overtime): //print_r($overtime);die;?>
					<tr <?php if($overtime['Overtime']['linked_to'] != 0) { ?> style=""<?php } ?> >
						<td>
						<?php echo $this->Html->link($overtime['OvertimeRequester']['first_name'].' '.$overtime['OvertimeRequester']['last_name'], array('controller' => 'users', 'action' => 'view', $overtime['OvertimeRequester']['id'])); ?>

					</td>
					<td ><?php echo h($overtime['OvertimeRequester']['salary_number']); ?>&nbsp;</td>
					<td><?php echo $departments[$overtime['OvertimeRequester']['department_id']];?></td>
					<td><?php echo $units[$overtime['OvertimeRequester']['department_section_id']];?></td>
						<td ><?php echo h($period[$overtime['Overtime']['period']]); ?>&nbsp;</td>
				 		<td ><?php echo h($overtime['Overtime']['overtime_date']); ?>&nbsp;</td>
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
						<td ><?php echo h($summed[$overtime['OvertimeRequester']['salary_number']+$overtime['Overtime']['id']]); ?>&nbsp;</td>
						<td>
							<input type="text" <?php if( $overtime['Overtime']['rate'] != 0 ) { echo "style='background-color:yellow'"; }?> id='rate<?php echo $overtime['Overtime']['id']?>' value="<?php echo $overtime['Overtime']['rate'] ?>" />
							<input type="button" style="margin: 5px 5px 5px 0" id='button<?php echo $overtime['Overtime']['id']?>' value="Save amount" onclick="saveRate('<?php echo $overtime['Overtime']['id']?>', 'rate<?php echo $overtime['Overtime']['id']?>', 'button<?php echo $overtime['Overtime']['id']?>')" />
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<br style="clear:both" />
			<br style="clear:both" />
			<div class="form-group">
				<input type="button" id='button<?php echo $overtimeRequester['OvertimeRequester']['id']?>' value="Send to CFO" onclick="submittoCFO()" />

			</div>
			<br style="clear:both" />
		</div> <!-- end col md 9 -->
	</div><!-- end row -->


</div><!-- end containing of content -->

<script>

    $(document).ready(function() {
        $('#fidu-tables').DataTable();
    } );


function submittoCFO() {

	//have to now check if any of he fieds are zero if zero then do not processed
	is_zero = 0;

	$('input[type="text"]').each(function () {
	    if ($.trim($(this).val()) != 0) {
				$('input[type="text"]').css(
		                  {
		                      "border": "1px solid black",
		                      "background": "yellow"
		                  });
	    } else { alert($(this).val());
				$('input[type="text"]').css(
											{
													"border": "1px solid red !important",
													"background": "#FFCECE !important"
											});
							 is_zero = 1;
			}


	})

	if(is_zero == 1) {
		alert('Some overtime amounts have not yet been captured, the overtime amount is zero and as a result this cannot be sent to the CFO.');
		return false;
	}



	if(!confirm("You are about to send to CFO, are you sure all the amounts have been entered and save accordingly?")) {
		return false;
	}

	$.ajax({
			url: "<?php echo Router::url(['controller' => 'Overtimes', 'action' => 'sendtocfo', true]); ?>",
			cache :false,
			type: 'POST',
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
	if(Rate == 0 || Rate == '') {
		alert('You did not enter the amount');
		return false;
	}
	if(isNaN(Rate)){
		alert('The amount entered '+Rate+' is not a number');
		return false;
	}

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
					window.location.reload();
			},
			error: function(data) {
					alert('There is a problem in archiving your document for final time '+data);
			}
	});

}

</script>
