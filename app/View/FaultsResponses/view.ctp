<div class="faultsResponses view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Faults Response'); ?></h1>
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
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Faults Response'), array('action' => 'edit', $faultsResponse['FaultsResponse']['id']), array('escape' => false)); ?> </li>
		<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Faults Response'), array('action' => 'delete', $faultsResponse['FaultsResponse']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $faultsResponse['FaultsResponse']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Faults Responses'), array('action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Faults Response'), array('action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Faults'), array('controller' => 'faults', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Fault'), array('controller' => 'faults', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Users'), array('controller' => 'users', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New User'), array('controller' => 'users', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">			
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<tbody>
				<tr>
		<th><?php echo __('Id'); ?></th>
		<td>
			<?php echo h($faultsResponse['FaultsResponse']['id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Fault'); ?></th>
		<td>
			<?php echo $this->Html->link($faultsResponse['Fault']['name'], array('controller' => 'faults', 'action' => 'view', $faultsResponse['Fault']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('User'); ?></th>
		<td>
			<?php echo $this->Html->link($faultsResponse['User']['fname'], array('controller' => 'users', 'action' => 'view', $faultsResponse['User']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Comments'); ?></th>
		<td>
			<?php echo h($faultsResponse['FaultsResponse']['comments']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Assigned To'); ?></th>
		<td>
			<?php echo h($faultsResponse['FaultsResponse']['assigned_to']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Date Actioned'); ?></th>
		<td>
			<?php echo h($faultsResponse['FaultsResponse']['date_actioned']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Date Completed'); ?></th>
		<td>
			<?php echo h($faultsResponse['FaultsResponse']['date_completed']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Status'); ?></th>
		<td>
			<?php echo h($faultsResponse['FaultsResponse']['status']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Action Taken'); ?></th>
		<td>
			<?php echo h($faultsResponse['FaultsResponse']['action_taken']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Created'); ?></th>
		<td>
			<?php echo h($faultsResponse['FaultsResponse']['created']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Modified'); ?></th>
		<td>
			<?php echo h($faultsResponse['FaultsResponse']['modified']); ?>
			&nbsp;
		</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>

