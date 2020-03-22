<div class="users index">
	<h2><?php echo __('Suppressed users'); ?></h2>
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
    <p style="font-weight: bold"><?php echo $this->Html->link(__('Add suppressed users'), array('action' => 'suppressusers')); ?></p>

	<table cellpadding="0" cellspacing="0" class="table-striped table" id="fidu-tables" >
	<thead>
	<tr>
			<th><?php echo __('Name'); ?></th>
			<th><?php echo __('Email'); ?></th>
			<th><?php echo __('Cellnumber'); ?></th>
			<th><?php echo __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['fname']).' '.h($user['User']['sname']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['cellnumber']); ?>&nbsp;</td>
		<td class="actions" style="width: 150px">
			<?php echo $this->Html->link(__('Remove suppression'), array('action' => 'removesuppression', $user['User']['id'])); ?> <span class="glyphicon glyphicon-folder-open"></span>
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
