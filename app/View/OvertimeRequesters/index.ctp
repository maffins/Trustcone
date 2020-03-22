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
		h2 {
			width: 35%;
		}
</style>
<div class="overtimeRequesters index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Overtime Requesters List'); ?></h1>
				<h4>
					<?php if($approver == 1):?>
						Managers view
					<?php endif;?>
					<?php if($approver == 2):?>
						Director view
					<?php endif;?>
					<?php if($approver == 3):?>
							Salaries Directorate view
					<?php endif;?>
					<?php if($approver == 4):?>
						 CFO View
					<?php endif;?>
				</h4>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->

	<div class="row">
<?php if(!$approver) { ?>
		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo __('Actions'); ?></div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('New Overtime Requester'), array('action' => 'add', $overtimeRequester['OvertimeRequester']['id']), array('escape' => false)); ?></li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->
<?php }  ?>
<?php if(!$approver) { ?>
		<div class="col-md-9">
<?php } else { ?>
		<div class="col-md-12">
<?php } ?>
			<table cellpadding="0" cellspacing="0" class="table table-striped" style="margin: 0 auto" id="fidu-tables">
				<thead>
					<tr>
						<th ><?php echo $this->Paginator->sort('Captured by'); ?></th>
						<th ><?php echo $this->Paginator->sort('Name'); ?></th>
						<th ><?php echo $this->Paginator->sort('cellnumber'); ?></th>
						<th ><?php echo $this->Paginator->sort('Salary Number'); ?></th>
						<th ><?php echo $this->Paginator->sort('Directorate'); ?></th>
						<th ><?php echo $this->Paginator->sort('Unit'); ?></th>
						<th ><?php echo $this->Paginator->sort('town'); ?></th>
						<th ><?php echo $this->Paginator->sort('email'); ?></th>
						<th ><?php echo $this->Paginator->sort('created'); ?></th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($overtimeRequesters as $overtimeRequester): ?>
					<tr>
						<td>
							<?php echo $this->Html->link($overtimeRequester['User']['fname'].' '.$overtimeRequester['User']['sname'], array('controller' => 'users', 'action' => 'view', $overtimeRequester['User']['id'])); ?>
						</td>
						<td >
							<?php echo $this->Html->link($overtimeRequester['OvertimeRequester']['first_name'].' '.$overtimeRequester['OvertimeRequester']['last_name'], array('controller' => 'Preovertimes', 'action' => 'index', $overtimeRequester['OvertimeRequester']['id'], $approver)); ?>
						</td>
						<td ><?php echo h($overtimeRequester['OvertimeRequester']['cellnumber']); ?>&nbsp;</td>
						<td ><?php echo h($overtimeRequester['OvertimeRequester']['salary_number']); ?>&nbsp;</td>
						<td>
							<?php echo $this->Html->link($overtimeRequester['Department']['name'], array('controller' => 'departments', 'action' => 'view', $overtimeRequester['Department']['id'])); ?>
						</td>
						<td>
							<?php echo $department_sections[$overtimeRequester['OvertimeRequester']['department_section_id']]; ?>
						</td>
						<td ><?php echo h($overtimeRequester['OvertimeRequester']['town']); ?>&nbsp;</td>
						<td ><?php echo h($overtimeRequester['OvertimeRequester']['email']); ?>&nbsp;</td>
						<td ><?php echo h($overtimeRequester['OvertimeRequester']['created']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $overtimeRequester['OvertimeRequester']['id']), array('escape' => false)); ?>
							<?php if($approver == 0) { ?>
								<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $overtimeRequester['OvertimeRequester']['id']), array('escape' => false)); ?>
								<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $overtimeRequester['OvertimeRequester']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $overtimeRequester['OvertimeRequester']['id'])); ?>
							<?php } ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

			<p>
				<small><?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?></small>
			</p>

			<?php
			$params = $this->Paginator->params();
			if ($params['pageCount'] > 1) {
			?>
			<ul class="pagination pagination-sm">
				<?php
					echo $this->Paginator->prev('&larr; Previous', array('class' => 'prev','tag' => 'li','escape' => false), '<a onclick="return false;">&larr; Previous</a>', array('class' => 'prev disabled','tag' => 'li','escape' => false));
					echo $this->Paginator->numbers(array('separator' => '','tag' => 'li','currentClass' => 'active','currentTag' => 'a'));
					echo $this->Paginator->next('Next &rarr;', array('class' => 'next','tag' => 'li','escape' => false), '<a onclick="return false;">Next &rarr;</a>', array('class' => 'next disabled','tag' => 'li','escape' => false));
				?>
			</ul>
			<?php } ?>

		</div> <!-- end col md 9 -->
	</div><!-- end row -->


</div><!-- end containing of content -->
<script>
    $(document).ready(function() {
        $('#fidu-tables').DataTable();
    } );
</script>
