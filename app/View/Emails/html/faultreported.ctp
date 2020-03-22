<div class="counsilorDocuments form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Fault Reported'); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-12">
	<h2>Fault reported by : <?php echo $name?></h2>
    <p>
	 Below are the fault details:
	</p>
	</div><!-- end row -->

	<table>
		<tr>
			<td><b>Fault Name</b></td>
			<td><?php echo $faultdetails['Fault']['name'] ?></td>
		</tr>
		<tr>
			<td><b>Location</b></td>
			<td><?php echo $faultdetails['Fault']['area']?></td>
		</tr>
		<tr>
			<td><b>Ward Number</b></td>
			<td><?php echo $faultdetails['Fault']['wardnumber']?></td>
		</tr>
		<tr>
			<td><b>Street name</b></td>
			<td><?php echo $faultdetails['Fault']['address']?></td>
		</tr>
	</table>
</div>
