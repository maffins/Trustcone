<div class="overtimes view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Overtime pre approval for: '.$overtimeRequesters['OvertimeRequester']['first_name'].' '.$overtimeRequesters['OvertimeRequester']['last_name']); ?></h1>
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
								<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Overtimes'), array('action' => 'index'), array('escape' => false)); ?> </li>
								</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<tbody>

<tr>
		<th><?php echo __('Captured by'); ?></th>
		<td>
			<?php echo $this->Html->link($overtimeRequesters['User']['fname'].' '.$overtimeRequesters['User']['sname'], array('controller' => 'users', 'action' => 'view', $overtimeRequesters['User']['id'])); ?>
			&nbsp;
		</td>
</tr>

<tr>
	<th><?php echo __('Requester name'); ?></th>
	<td>
	<?php echo $this->Html->link($overtimeRequesters['OvertimeRequester']['first_name'].' '.$overtimeRequesters['OvertimeRequester']['last_name'], array('controller' => 'Overtimes', 'action' => 'overtimeitems', $overtimeRequesters['OvertimeRequester']['id'], $overtimeRequesters['Overtime']['tracker']));  ?>
	&nbsp;
	</td>
</tr>
<tr>
		<th><?php echo __('Directorate'); ?></th>
		<td>
			<?php echo $this->Html->link($overtimeRequesters['Department']['name'], array('controller' => 'departments', 'action' => 'view', $overtimeRequesters['Department']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Salary number'); ?></th>
		<td>
			<?php echo h($overtimeRequesters['OvertimeRequester']['salary_number']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Town'); ?></th>
		<td>
			<?php echo h($overtimeRequesters['OvertimeRequester']['town']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('cellnumber'); ?></th>
		<td>
			<?php echo h($overtimeRequesters['OvertimeRequester']['cellnumber']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Email'); ?></th>
		<td>
			<?php echo h($overtimeRequesters['OvertimeRequester']['email']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Unit'); ?></th>
		<td>
			<?php echo h($department_sections[$overtimeRequesters['OvertimeRequester']['department_section_id']]); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Created'); ?></th>
		<td>
			<?php echo h($overtimeRequesters['OvertimeRequester']['created']); ?>
			&nbsp;
		</td>
</tr>
<tr>
	<td colspan="2">
		<h6>Items</h6>

		<div class="col-md-12">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
						<th ><?php echo __('Month'); ?></th>
						<th ><?php echo __('Weekday'); ?></th>
						<th ><?php echo __('Saturday'); ?></th>
						<th ><?php echo __('Sunday'); ?></th>
						<th ><?php echo __('Public holiday'); ?></th>
						<th ><?php echo __('Reason'); ?></th>
						<th ><?php echo __('Total hours'); ?></th>
						<th ><?php echo __('Decision'); ?></th>
						<th ><?php echo __('created'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($overtimeRequesters['Preovertime'] as $preovertime): ?>
					<tr>
							<td ><?php echo h($months[$preovertime['overtime_month']].' '.$preovertime['overtime_year']); ?>&nbsp;</td>
						<td ><?php echo $preovertime['weekday'] ?>&nbsp;</td>
						<td ><?php echo $preovertime['saturday'] ?>&nbsp;</td>
						<td ><?php echo $preovertime['sunday'] ?>&nbsp;</td>
						<td ><?php echo $preovertime['public_holiday'] ?>&nbsp;</td>
						<td ><?php echo h($preovertime['whatsdone']); ?>&nbsp;</td>
						<td ><?php echo h($preovertime['total_hours']); ?>&nbsp;</td>
						<td >
						<?php

							if(($preovertime['tracker'] == 1 && $approver) || ($preovertime['tracker'] == 2 && $approver)) {

								if($approver == 1) {
									if($preovertime['tracker'] == 1) { //means nothign has been done yet so make a decision
									?>
										<table>
											<tr>
												<td>Approve and send</td>
												<td><input type="radio" name="escalate<?php echo $preovertime['id'] ?>" id="escalate<?php echo $preovertime['id'] ?>" onclick='escalate("<?php echo $preovertime['id']?>", "1", "<?php echo $preovertime['tracker']?>")'></td>
											</tr>
											<tr>
												<td>Decline</td>
												<td>
													<input type="radio" name="escalate<?php echo $preovertime['id'] ?>" id="escalate<?php echo $preovertime['id'] ?>" onclick='escalate("<?php echo $preovertime['id'] ?>", "2", "<?php echo $preovertime['tracker']?>")'>
													<div id="decline<?php echo $preovertime['id'] ?>" style="display: none">
															<textarea name="declinecomment<?php echo $preovertime['id'] ?>" id="declinecomment<?php echo $preovertime['id'] ?>"></textarea>
															<input type="button" value="Save reason of decline"  onclick='escalate("<?php echo $preovertime['id']  ?>", "2", "<?php echo $preovertime['tracker']?>")'>
													</div>
												</td>
											</tr>
										</table>
							 <?php } else {
									if($preovertime['tracker'] == 2) {
								?>
									Approved and sent to Director
							<?php } else {
								?>
									Declined by manager
								<?php
									}
								}
							}

							if($approver == 2) {
								if($preovertime['tracker'] == 2) { //means nothign has been done yet so make a decision
								?>
									<table>
										<tr>
											<td>Approve and send</td>
											<td><input type="radio" name="escalate<?php echo $preovertime['id'] ?>" id="escalate<?php echo $preovertime['id'] ?>" onclick='escalate("<?php echo $preovertime['id']?>", "1", "<?php echo $preovertime['tracker']?>")'></td>
										</tr>
										<tr>
											<td>Decline</td>
											<td>
												<input type="radio" name="escalate<?php echo $preovertime['id'] ?>" id="escalate<?php echo $preovertime['id'] ?>" onclick='escalate("<?php echo $preovertime['id'] ?>", "2", "<?php echo $preovertime['tracker']?>")'>
												<div id="decline<?php echo $preovertime['id'] ?>" style="display: none">
														<textarea name="declinecomment<?php echo $preovertime['id'] ?>" id="declinecomment<?php echo $preovertime['id'] ?>"></textarea>
														<input type="button" value="Save reason of decline"  onclick='escalate("<?php echo $preovertime['id']  ?>", "2", "<?php echo $preovertime['tracker']?>")'>
												</div>
											</td>
										</tr>
									</table>
						 <?php } else {
								if($preovertime['tracker'] == 3) {
							?>
								Approved
						<?php } else {
							?>
								Declined by director
							<?php
								}
							}
						}?>
									<?php
								} else if($preovertime['tracker'] == 3 || $preovertime['tracker'] == 11 || $preovertime['tracker'] == 10) {
										if ( $preovertime['tracker'] == 3) {
											echo 'Pre-Overtime approved by Director';
										} else if ( $preovertime['tracker'] == 10) {
											echo 'Declined by manager';
										} else if ( $preovertime['tracker'] == 11) {
											echo 'Declined by director';
										}
										if(!$approver) {

									}
								}
						?>&nbsp;
					</td>
						<td ><?php echo h(substr($preovertime['created'], 0, 10)); ?>&nbsp;</td>

					</tr>
				<?php endforeach; ?>
				</tbody>
				<tfoot>

				</tfoot>
			</table>





	</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>
