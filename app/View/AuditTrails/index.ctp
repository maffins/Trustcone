<div class="auditTrails index">
	<h2><?php echo __('Audit Trails'); ?></h2>

	<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="fidu-tables" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
		<thead>
			<tr>
					<th><?php echo 'id'; ?></th>
					<th><?php echo 'Event Description'; ?></th>
					<th><?php echo 'Contents'; ?></th>
					<th><?php echo 'Date'; ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($auditTrails as $auditTrail): ?>
				<tr>
					<td><?php echo h($auditTrail['AuditTrail']['id']); ?>&nbsp;</td>
					<td><?php echo h($auditTrail['AuditTrail']['event_description']); ?>&nbsp;</td>
					<td><?php echo h($auditTrail['AuditTrail']['contents']); ?>&nbsp;</td>
					<td><?php echo h($auditTrail['AuditTrail']['created']); ?>&nbsp;</td>
					<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $auditTrail['AuditTrail']['id'])); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

</div>

<script>
	$(document).ready(function() {
		$('#fidu-tables').DataTable();
	} );
</script>