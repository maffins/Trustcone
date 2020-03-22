<div class="users index">
	<h2><?php echo __('Users Usage'); ?></h2>
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

		<form>
       <input type="button" value="Print This page" onclick="window.print()" />
    </form>
	<table cellpadding="0" cellspacing="0" class="table-striped table" id="fidu-tabless" >
	<thead>
	<tr>
			<th><?php echo __('Name'); ?></th>
			<th><?php echo __('Email'); ?></th>
			<th><?php echo __('Roles'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($users as $user): if($user['User']['email'] != "maffins@gmail.com"): ?>
	<tr>
		<td><?php echo h($user['User']['fname']).' '.h($user['User']['sname']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
		<td>
			<?php
				foreach(unserialize($user['User']['permissions']) as $value)  {
					echo $roles[$value].", ";
				}
			?>
		</td>

	</tr>
<?php endif; endforeach; ?>
	</tbody>
	</table>
	<br style="clear: both" />

</div>
<div class="actions" style="display:none">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Export to CSV'), array('action' => 'exporttocsv')); ?></li>
	</ul>
</div>
<script>
    $(document).ready(function() {
        $('#fidu-tables').DataTable();
    } );
</script>
