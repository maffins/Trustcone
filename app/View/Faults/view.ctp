<div class="faults view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h3><?php echo __('Fault'); ?></h3>
			</div>
		</div>
	</div>
<style>
    .bhatoni {
        font: bold 11px Arial;
        text-decoration: none;
        background-color: #EEEEEE;
        color: #333333;
        padding: 6px 6px 6px 6px;
        border-top: 1px solid #CCCCCC;
        border-right: 1px solid #333333;
        border-bottom: 1px solid #333333;
        border-left: 1px solid #CCCCCC;
    }
</style>
	<div class="row">

		<div class="col-md-12">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<tbody>
				<?php if($user_type_id == 16):?>
					<tr>
						<th ><?php echo __('Assinged'); ?></th>
						<td style="background-color: #CCCCCC">
							<?php
								if($fault['Fault']['assigned_to'])
								{
									echo $fault['Fault']['assigned_to'];
								} else {
									echo $this->Html->link('Assign', array('action' => 'assign', 'controller' => 'Faults', $fault['Fault']['id']), array('escape' => false));
								}
							?>
						</td>
					</tr>
				<?php endif;?>

<tr>
		<th width="50%" nowrap=""><?php echo __('Fault reported by:'); ?></th>
		<td>
			<?php echo $this->Html->link($fault['User']['fname']." ".$fault['User']['sname'], array('controller' => 'users', 'action' => 'view', $fault['User']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
	<th><?php echo __('Fault Number'); ?></th>
	<td>
		<?php echo h($fault['Fault']['id']); ?>
		&nbsp;
	</td>
</tr>
<tr>
	<th><?php echo __('Fault Name'); ?></th>
	<td>
		<?php echo h($fault['Fault']['name']); ?>
		&nbsp;
	</td>
</tr>
<tr>
		<th><?php echo __('Town / Township / Ward number / Location'); ?></th>
		<td>
			<?php echo h($fault['Fault']['area']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Street Name'); ?></th>
		<td>
			<?php echo h($fault['Fault']['address']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Date fault reported'); ?></th>
		<td>
			<?php echo h($fault['Fault']['created']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Status'); ?></th>
		<td>
			<?php
				if($fault['Fault']['status'] == 0){
					echo "Submited to the office of the speaker";
				}
			?>
		</td>
</tr>
<tr>
	<th><?php echo __('Date added'); ?></th>
	<td>
		<?php echo h($fault['Fault']['created']); ?>
		&nbsp;
	</td>
</tr>
<?php if($user_type_id == 16):?>
	<tr>
		<th ><?php echo __('Comments'); ?></th>
		<td style="background-color: #CCCCCC">
			<?php echo $this->Html->link('Add Comment', array('action' => 'add', 'controller' => 'FaultsComments', $fault['Fault']['id']), array('escape' => false, 'class' => 'bhatoni')); ?>
		</td>
	</tr>
	<tr>
		<th ><?php echo __('My Comments'); ?></th>
		<th ><?php echo __('Comment Response'); ?></th>
	</tr>
	<?php foreach($FaultsComment as $faultcommnet):?>
	<tr>
		<th ><?php echo $faultcommnet['FaultsComment']['comment']; ?></th>
		<td>
			<?php
			if($user_type_id == 9){
				if(!$faultcommnet['FaultsComment']['comment_response'])
				{
					echo $this->Html->link('Add Comment Response', array('action' => 'addresponse', 'controller' => 'FaultsComments', $fault['Fault']['id']), array('escape' => false));
				} else {
					echo $faultcommnet['FaultsComment']['comment_response'];
				}
			}else{
				if(!$faultcommnet['FaultsComment']['comment_response'])
				{
					echo "No Response Yet";
				} else {
					echo $faultcommnet['FaultsComment']['comment_response'];
				}
			} ?>
		</td>
	</tr>
	<?php endforeach;?>
<?php endif;?>

	<?php if($user_type_id == 16):?>
		<tr>
			<th colspan="2"></th>
		</tr>
		<tr <?php if(substr($fault['Fault']['completed_date'],0,1) == 2){ echo "style='background-color:green'"; }?> >
			<th <?php if(substr($fault['Fault']['completed_date'],0,1) == 2){ echo "style='background-color:green'"; }?> colspan="2">
				<?php if(substr($fault['Fault']['completed_date'],0,1) == 2):?>
					<b>Completed on <?php echo $fault['Fault']['completed_date']?></b>
				<?php else:?>
					<?php echo $this->Form->postLink(__('Mark as completed'), array('action' => 'completed', $fault['Fault']['id']), array('confirm' => __('Are you sure the fault is now completed # %s?', $fault['Fault']['id']))); ?>
				<?php endif?>
			</th>
		</tr>
	<?php endif; ?>
		</tbody>
	</table>

		</div><!-- end col md 9 -->

	</div>
</div>

