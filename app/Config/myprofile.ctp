<div class="users myprofile">

	<table class="table-striped">
		<tr>
			<td colspan="2">
				<h2><?php echo __('My profile'); ?></h2>
			</td>
		</tr>
		<tr><td style='font-weight:bold'><?php echo __('First Name'); ?></td>
			<td>
				<?php echo h($user['User']['fname']); ?>
				&nbsp;
			</td></tr>
		<tr><td style='font-weight:bold'><?php echo __('Surname'); ?></td>
			<td>
				<?php echo h($user['User']['sname']); ?>
				&nbsp;
			</td></tr>
		<tr><td style='font-weight:bold'><?php echo __('Username'); ?></td>
			<td>
				<?php echo h($user['User']['username']); ?>
				&nbsp;
			</td></tr>
		<tr><td style='font-weight:bold'><?php echo __('Department'); ?></td>
		<td>
			<?php echo $this->Html->link($user['Department']['name'], array('controller' => 'departments', 'action' => 'view', $user['Department']['id'])); ?>
			&nbsp;
		</td></tr>
		<tr><td style='font-weight:bold'><?php echo __('Role'); ?></td>
		<td>
			<?php echo $this->Html->link($user['UserType']['name'], array('controller' => 'user_types', 'action' => 'view', $user['UserType']['id'])); ?>
			&nbsp;
		</td></tr>  

		<tr><td style='font-weight:bold'><?php echo __('Email'); ?></td>
		<td>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</td></tr>
		<tr><td style='font-weight:bold'><?php echo __('Cellnumber'); ?></td>
		<td>
			<?php echo h($user['User']['cellnumber']); ?>
			&nbsp;
		</td></tr>
		<tr><td style='font-weight:bold'><?php echo __('Physical Address'); ?></td>
		<td>
			<?php echo h($user['User']['physical_address']); ?>
			&nbsp;
		</td></tr>  
		<tr><td style='font-weight:bold'><?php echo __('Postal Address'); ?></td>
		<td>
			<?php echo h($user['User']['postal_address']); ?>
			&nbsp;
		</td></tr> 
		<tr><td style='font-weight:bold'><?php echo __('Created'); ?></td>
		<td>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</td></tr>  
		<tr>
			<td colspan="2">
				<?php echo $this->Html->link('Update my details', "/Users/editprofile", ['class' => 'btn btn-default']) ?>
			</td>
		</tr>
	</table>
</div>

