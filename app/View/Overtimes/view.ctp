<div class="overtimes view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Overtime'); ?></h1>
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
								<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Overtimes'), array('action' => 'index'), array('escape' => false)); ?> </li>
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
			<?php echo h($overtime['Overtime']['id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('User'); ?></th>
		<td>
			<?php echo $this->Html->link($overtime['User']['fname'], array('controller' => 'users', 'action' => 'view', $overtime['User']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Department'); ?></th>
		<td>
			<?php echo $this->Html->link($overtime['Department']['name'], array('controller' => 'departments', 'action' => 'view', $overtime['Department']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Tracker'); ?></th>
		<td>
			<?php echo h($overtime['Overtime']['tracker']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Overtime Date'); ?></th>
		<td>
			<?php echo h($overtime['Overtime']['overtime_date']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Start Time'); ?></th>
		<td>
			<?php echo h($overtime['Overtime']['start_time']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('End Time'); ?></th>
		<td>
			<?php echo h($overtime['Overtime']['end_time']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Pay Number'); ?></th>
		<td>
			<?php echo h($overtime['Overtime']['pay_number']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Whatsdone'); ?></th>
		<td>
			<?php echo h($overtime['Overtime']['whatsdone']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Created'); ?></th>
		<td>
			<?php echo h($overtime['Overtime']['created']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Modified'); ?></th>
		<td>
			<?php echo h($overtime['Overtime']['modified']); ?>
			&nbsp;
		</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>
