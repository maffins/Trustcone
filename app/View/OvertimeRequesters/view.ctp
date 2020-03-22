<div class="overtimeRequesters view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Overtime Requester'); ?></h1>
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Actions'); ?></div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Overtime Requester'), array('action' => 'edit', $overtimeRequester['OvertimeRequester']['id']), array('escape' => false)); ?> </li>
		<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Overtime Requester'), array('action' => 'delete', $overtimeRequester['OvertimeRequester']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $overtimeRequester['OvertimeRequester']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Overtime Requesters'), array('action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Overtime Requester'), array('action' => 'add'), array('escape' => false)); ?> </li>
								</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<tbody>
<tr>
		<th><?php echo __('Created by'); ?></th>
		<td>
			<?php echo $this->Html->link($overtimeRequester['User']['fname'].' '.$overtimeRequester['User']['sname'], array('controller' => 'users', 'action' => 'view', $overtimeRequester['User']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Directorate'); ?></th>
		<td>
			<?php echo $this->Html->link($overtimeRequester['Department']['name'], array('controller' => 'departments', 'action' => 'view', $overtimeRequester['Department']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Unit'); ?></th>
		<td>
			<?php echo h($overtimeRequester['OvertimeRequester']['section']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Town'); ?></th>
		<td>
			<?php echo h($overtimeRequester['OvertimeRequester']['town']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Email'); ?></th>
		<td>
			<?php echo h($overtimeRequester['OvertimeRequester']['email']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('First Name'); ?></th>
		<td>
			<?php echo h($overtimeRequester['OvertimeRequester']['first_name']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Last Name'); ?></th>
		<td>
			<?php echo h($overtimeRequester['OvertimeRequester']['last_name']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Cellnumber'); ?></th>
		<td>
			<?php echo h($overtimeRequester['OvertimeRequester']['cellnumber']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Created'); ?></th>
		<td>
			<?php echo h($overtimeRequester['OvertimeRequester']['created']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Modified'); ?></th>
		<td>
			<?php echo h($overtimeRequester['OvertimeRequester']['modified']); ?>
			&nbsp;
		</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>
