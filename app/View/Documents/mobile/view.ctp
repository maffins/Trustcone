<div class="row">



    <div class="col-md-12">

        <div class="form-vertical" style="margin-top: -10px;">
<div class="documents view">

	<br /><p class='btn btn-info'>Document view<p/>
	<table>
        <tr style="display: none">
		<td><?php echo __('Compiled by'); ?></td>
		<td>
			<?php echo $this->Html->link($document['User']['fname'], array('controller' => 'users', 'action' => 'view', $document['User']['id'])); ?>
			&nbsp;
		</td>
        </tr><tr>
		<td><?php echo __('Document type (Click to download)'); ?></td>
		<td>
			<?php echo $this->Html->link($document['Document']['name'], array( 'action' => 'sendFile', $document['Document']['id'])); ?>
			&nbsp;
		</td></tr><tr>
		<td><?php echo __('Department'); ?></td>
		<td>
			<?php echo $this->Html->link($document['Department']['name'], array('controller' => 'departments', 'action' => 'view', $document['Department']['id'])); ?>
			&nbsp;
		</td></tr><tr>
		<td><?php echo __('Date Compiled'); ?></td>
		<td>
			<?php echo h($document['Document']['created']); ?>
			&nbsp;
		</td></tr><tr>
		<td><?php echo __('Document Id'); ?></td>
		<td>
			<?php echo h($document['Document']['id']); ?>
			&nbsp;
		</td></tr>
	</table>
</div>

</div>
