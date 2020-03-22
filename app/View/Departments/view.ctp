<div class="departments view">
	<p class='btn btn-info'>Directorates view<p/>

	<table class="table-stripped">
<tr>
		<td><?php echo __('Name'); ?></td>
		<td>
			<?php echo h($department['Department']['name']); ?>
			&nbsp;
		</td>
        </tr><tr>
		<td><?php echo __('Created'); ?></td>
		<td>
			<?php echo h($department['Department']['created']); ?>
			&nbsp;
		</td>
        </tr><tr>
		<td><?php echo __('Modified'); ?></td>
		<td>
			<?php echo h($department['Department']['modified']); ?>
			&nbsp;
		</td>
        </tr><tr>
	</table>
</div>
