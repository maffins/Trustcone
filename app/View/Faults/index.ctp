<div class="faults index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<?php if($user_type_id == 16):?>
                <h3><?php echo __('Faults that have been reported'); ?></h3>
				<?php else:?>
					<h3><?php echo __('Faults i have reported'); ?></h3>
				<?php endif;?>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->

	<?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Capture Fault'), array('controller' => 'Faults', 'action' => 'add'), array('escape' => false)); ?>


	<div class="row">

		<table>
			<tr>
				<td><b>Search fault by number</b></td>
				<td><input id="faultbynumber" name="faultbynumber" /></td>
				<td><input type="button" onclick="searchFault()" value="Search >>"></td>
			</tr>
		</table>

		<div class="col-md-12">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
						<th nowrap><?php echo $this->Paginator->sort('Fault Number'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('Fault Name'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('Location'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('Ward number'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('Street Name'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('Date Reported'); ?></th>
						<th nowrap><?php echo $this->Paginator->sort('status'); ?></th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($faults as $fault): ?>
					<tr <?php if(substr($fault['Fault']['completed_date'],0,1) == 2){ echo "style='background-color:green'"; }?> >
                <td nowrap>
                    <?php echo $this->Html->link($fault['Fault']['id'], array('action' => 'view', $fault['Fault']['id']), array('escape' => false)); ?>
                </td>
						<td nowrap><?php echo h($fault['Fault']['name']); ?>&nbsp;</td>
						<td nowrap><?php echo h($fault['Fault']['area']); ?>&nbsp;</td>
						<td nowrap><?php echo h($fault['Fault']['wardnumber']); ?>&nbsp;</td>
						<td nowrap><?php echo h($fault['Fault']['address']); ?>&nbsp;</td>
						<td nowrap><?php echo h($fault['Fault']['created']); ?>&nbsp;</td>
						<td nowrap>
							<?php
								if($fault['Fault']['status'] == 0){
									echo "Submited to the office of the speaker";
								}
								if($fault['Fault']['status'] == 7){
									echo "<b>Completed on ".$fault['Fault']['completed_date']."</b>";
								}
							?>&nbsp;
						</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $fault['Fault']['id']), array('escape' => false)); ?>
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $fault['Fault']['id']), array('escape' => false)); ?>
							<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $fault['Fault']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $fault['Fault']['id'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

			<p>
				<small><?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?></small>
			</p>

			<?php
			$params = $this->Paginator->params();
			if ($params['pageCount'] > 1) {
			?>
			<ul class="pagination pagination-sm">
				<?php
					echo $this->Paginator->prev('&larr; Previous', array('class' => 'prev','tag' => 'li','escape' => false), '<a onclick="return false;">&larr; Previous</a>', array('class' => 'prev disabled','tag' => 'li','escape' => false));
					echo $this->Paginator->numbers(array('separator' => '','tag' => 'li','currentClass' => 'active','currentTag' => 'a'));
					echo $this->Paginator->next('Next &rarr;', array('class' => 'next','tag' => 'li','escape' => false), '<a onclick="return false;">Next &rarr;</a>', array('class' => 'next disabled','tag' => 'li','escape' => false));
				?>
			</ul>
			<?php } ?>

		</div> <!-- end col md 9 -->
	</div><!-- end row -->


</div><!-- end containing of content -->
<script>
	function searchFault()
	{
	    value = $('#faultbynumber').val();
	    if(value == "")
        {
            alert('Please enter the fault number');
            $('#faultbynumber').focus();
        } else {
            $(location).attr('href', '/lejweleputswa.co.za/Faults/view/'+value);
        }

	}
</script>