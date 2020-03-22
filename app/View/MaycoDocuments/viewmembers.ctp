<div class="users index">
	<h2><?php echo __('ALL MEMBERS OF THE MAYCO MEETING DOCUMENTS'); ?></h2>
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
    </style>
	<br />

    <p style="font-weight: bold"><?php echo $this->Html->link(__('Add More Members'), array('controller' => 'Users', 'action' => 'index')); ?></p>

	<table cellpadding="0" cellspacing="0" class="table-striped table" id="fidu-tables" >
	<thead>
	<tr>
			<th><?php echo __('Name'); ?></th>
			<th><?php echo __('Email'); ?></th>
			<th><?php echo __('Cellnumber'); ?></th>
			<th><?php echo __('Role'); ?></th>
			<th class="actions"><?php echo __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($allusers as $user): ?>
	<tr>
		<td><?php echo h($user['User']['fname']).' '.h($user['User']['sname']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['cellnumber']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($user['UserType']['name'], array('controller' => 'user_types', 'action' => 'view', $user['UserType']['id'])); ?>
		</td>

		<td class="actions" style="width: 150px">
			<?php echo $this->Html->link(__('View'), array('controller' => 'Users', 'action' => 'view', $user['User']['id'])); ?> <span class="glyphicon glyphicon-folder-open"></span>
			<?php echo $this->Html->link(__('Edit'), array('controller' => 'Users', 'action' => 'editprofile', $user['User']['id'])); ?> <span class="glyphicon glyphicon-edit"></span>
			<?php echo $this->Html->link(__('Set permissions'), array('controller' => 'Users', 'action' => 'permision', $user['User']['id'],1)); ?> <span class="glyphicon glyphicon-edit"></span>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<br style="clear: both" />

</div>

<script>
    $(document).ready(function() {
        $('#fidu-tables').DataTable();
    } );
</script>