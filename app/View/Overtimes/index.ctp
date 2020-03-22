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

<script>

function submittoCFO() {
	//redirect to the page that lists all the overtimes irregardlees of the department.
	$(location).attr("href", '/Overtimes/salaryitems');
}
</script>

<div class="overtimeRequesters index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Overtime Requesters (Pre - approved already))'); ?></h1>
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
			<?php if($approver == 0):?>
				First Stage
			<?php endif;?>
				</h4>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->

	<div class="row">

		<div class="col-md-12">
<?php if($approver == 3):?>
		 <input type="button" id='buttonup' value="Summay and send to CFO" onclick="submittoCFO()" />
<?php endif;?>
<br /><br />
			<table cellpadding="0" cellspacing="0" class="table table-striped" style="margin: 0 auto" id="fidu-tables">
				<thead>
					<tr>
						<th ><?php echo $this->Paginator->sort('Captured by'); ?></th>
						<th ><?php echo $this->Paginator->sort('Name'); ?></th>
						<th ><?php echo $this->Paginator->sort('cellnumber'); ?></th>
						<th ><?php echo $this->Paginator->sort('Salary Number'); ?></th>
						<th ><?php echo $this->Paginator->sort('Directorate'); ?></th>
						<th ><?php echo $this->Paginator->sort('section'); ?></th>
						<th ><?php echo $this->Paginator->sort('town'); ?></th>
						<th ><?php echo $this->Paginator->sort('email'); ?></th>
						<th ><?php echo $this->Paginator->sort('Month approved'); ?></th>
						<th ><?php echo $this->Paginator->sort('Pre-approved review'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($overtimeRequesters as $overtimeRequester): ?>
					<tr>
						<td>
							<?php echo $this->Html->link($overtimeRequester['User']['fname'].' '.$overtimeRequester['User']['sname'], array('controller' => 'users', 'action' => 'view', $overtimeRequester['User']['id'])); ?>
						</td>
						<td >
							<?php echo $this->Html->link($overtimeRequester['OvertimeRequester']['first_name'].' '.$overtimeRequester['OvertimeRequester']['last_name'], array('controller' => 'Overtimes', 'action' => 'overtimeitems', $overtimeRequester['OvertimeRequester']['id'], $overtimeRequester['Overtime'][0]['tracker'])); ?>
						</td>
						<td ><?php echo h($overtimeRequester['OvertimeRequester']['cellnumber']); ?>&nbsp;</td>
						<td ><?php echo h($overtimeRequester['OvertimeRequester']['salary_number']); ?>&nbsp;</td>
						<td>
							<?php echo $this->Html->link($overtimeRequester['Department']['name'], array('controller' => 'departments', 'action' => 'view', $overtimeRequester['Department']['id'])); ?>
						</td>
						<td ><?php echo h($department_sections[$overtimeRequester['OvertimeRequester']['department_section_id']]); ?>&nbsp;</td>
						<td ><?php echo h($overtimeRequester['OvertimeRequester']['town']); ?>&nbsp;</td>
						<td ><?php echo h($overtimeRequester['OvertimeRequester']['email']); ?>&nbsp;</td>
						<td ><?php echo h($months[$overtimeRequester['Preovertime'][0]['overtime_month']]); ?>&nbsp;</td>
						<td>
							<?php echo $this->Html->link('Review', array('controller' => 'Overtimes', 'action' => 'overtimereview', $overtimeRequester['OvertimeRequester']['id'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
<br style="clear:both" />
<br style="clear:both" />

		</div> <!-- end col md 9 -->
	</div><!-- end row -->


</div><!-- end containing of content -->
<script>
    $(document).ready(function() {
        $('#fidu-tables').DataTable();
    } );
</script>
