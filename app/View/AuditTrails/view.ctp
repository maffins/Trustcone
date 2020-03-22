<div class="auditTrails view">
<h2><?php echo __('Audit Trail'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($auditTrail['AuditTrail']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Event Description'); ?></dt>
		<dd>
			<?php echo h($auditTrail['AuditTrail']['event_description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contents'); ?></dt>
		<dd>
			<?php echo h($auditTrail['AuditTrail']['contents']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($auditTrail['AuditTrail']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

