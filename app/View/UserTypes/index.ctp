<div class="userTypes index">
	<h2><?php echo __('User Types'); ?></h2>
	<br />
	<table cellpadding="0" cellspacing="0" class="table-striped table" id="fidu-tables" >
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($userTypes as $userType): ?>
	<tr>
		<td><?php echo h($userType['UserType']['id']); ?>&nbsp;</td>
		<td><?php echo h($userType['UserType']['name']); ?>&nbsp;</td>
		<td><?php echo h($userType['UserType']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $userType['UserType']['id'])); ?> <span class="glyphicon glyphicon-folder-open"></span>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $userType['UserType']['id'])); ?> <span class="glyphicon glyphicon-edit"></span>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New User Type'), array('action' => 'add')); ?></li>
	</ul>
</div>

<script>
    $(document).ready(function() {
        $('#fidu-tables').DataTable();
    } );
</script>