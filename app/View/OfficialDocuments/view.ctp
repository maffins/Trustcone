<div class="officialDocuments view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Official Document'); ?></h1>
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
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Official Document'), array('action' => 'edit', $officialDocument['OfficialDocument']['id']), array('escape' => false)); ?> </li>
		<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Official Document'), array('action' => 'delete', $officialDocument['OfficialDocument']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $officialDocument['OfficialDocument']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Official Documents'), array('action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Official Document'), array('action' => 'add'), array('escape' => false)); ?> </li>
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
			<?php echo h($officialDocument['OfficialDocument']['id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Type'); ?></th>
		<td>
			<?php echo h($officialDocument['OfficialDocument']['type']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Idcounter'); ?></th>
		<td>
			<?php echo h($officialDocument['OfficialDocument']['idcounter']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Doc Name'); ?></th>
		<td>
			<?php echo h($officialDocument['OfficialDocument']['doc_name']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Compiled Name'); ?></th>
		<td>
			<?php echo h($officialDocument['OfficialDocument']['compiled_name']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Tracker'); ?></th>
		<td>
			<?php echo h($officialDocument['OfficialDocument']['tracker']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Priority'); ?></th>
		<td>
			<?php echo h($officialDocument['OfficialDocument']['priority']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Decision'); ?></th>
		<td>
			<?php echo h($officialDocument['OfficialDocument']['decision']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Reason'); ?></th>
		<td>
			<?php echo h($officialDocument['OfficialDocument']['reason']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('User'); ?></th>
		<td>
			<?php echo $this->Html->link($officialDocument['User']['fname'], array('controller' => 'users', 'action' => 'view', $officialDocument['User']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Created'); ?></th>
		<td>
			<?php echo h($officialDocument['OfficialDocument']['created']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Modified'); ?></th>
		<td>
			<?php echo h($officialDocument['OfficialDocument']['modified']); ?>
			&nbsp;
		</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>

