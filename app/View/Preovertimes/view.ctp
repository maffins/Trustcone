<div class="preovertimes view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Preovertime'); ?></h1>
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
		</div>
	</div>

	<div class="row">

		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Actions'); ?></div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Preovertimes'), array('action' => 'index', $requester_id), array('escape' => false)); ?> </li>
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
			<?php echo h($preovertime['Preovertime']['id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('User'); ?></th>
		<td>
			<?php echo $this->Html->link($preovertime['User']['fname'], array('controller' => 'users', 'action' => 'view', $preovertime['User']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Overtime Requester Id'); ?></th>
		<td>
			<?php echo h($preovertime['Preovertime']['overtime_requester_id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Tracker'); ?></th>
		<td>
			<?php echo h($preovertime['Preovertime']['tracker']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Overtime Month'); ?></th>
		<td>
			<?php echo h($preovertime['Preovertime']['overtime_month']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Weekday'); ?></th>
		<td>
			<?php echo h($preovertime['Preovertime']['weekday']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Saturday'); ?></th>
		<td>
			<?php echo h($preovertime['Preovertime']['saturday']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Sunday'); ?></th>
		<td>
			<?php echo h($preovertime['Preovertime']['sunday']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Public Holiday'); ?></th>
		<td>
			<?php echo h($preovertime['Preovertime']['public_holiday']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Whatsdone'); ?></th>
		<td>
			<?php echo h($preovertime['Preovertime']['whatsdone']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Total Hours'); ?></th>
		<td>
			<?php echo h($preovertime['Preovertime']['total_hours']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Overal Hours'); ?></th>
		<td>
			<?php echo h($preovertime['Preovertime']['overal_hours']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Archived'); ?></th>
		<td>
			<?php echo h($preovertime['Preovertime']['archived']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Created'); ?></th>
		<td>
			<?php echo h($preovertime['Preovertime']['created']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Modified'); ?></th>
		<td>
			<?php echo h($preovertime['Preovertime']['modified']); ?>
			&nbsp;
		</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>
