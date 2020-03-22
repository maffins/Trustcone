<div class="counsilorDocuments form">
<?php
		$departments[1] = "Corporate Support Services";
		$departments[2] = "Local Economic Development";
		$departments[3] = "Finance";
		$departments[4] = "Office of the Municipal Manager";
		$departments[5] = "Community Services";
		$departments[6] = "Infrastructure";
		$departments[7] = "Strategic Support Services";
		$departments[8] = "Office of the Mayor";
		$departments[9] = "Office of the Speaker";
		$departments[10] = "Office of the Chief whip";
		$departments[11] = "CFO";
		$departments[12] = "CEO";

		$userType[1] = "Compiler";
		$userType[2] = "CFO";
		$userType[3] = "CEO/Municipal Manager";
		$userType[6] = "Admin";
		$userType[7] = "CFO Secretary";
		$userType[8] = "CEO Secretary";
		$userType[9] = "Councillor";
		$userType[10] = "Temporary CEO";
		$userType[11] = "Temporary CFO";
		$userType[12] = "Temporary CEO Secretary";
		$userType[13] = "Temporary CFO Secretary";
		$userType[14] = "Both CEO and CFO Secretary";
		$userType[15] = "Uploader";
		$userType[16] = "Manager in the municipal managers office";
		$userType[17] = "Chief of staff";
		$userType[18] = "Personal assistant to executive mayor";
		$userType[19] = "Personal Assistant to the Speaker";
		$userType[20] = "Personal Assistant to the Chief Whip";
		$userType[21] = "MMC Support Officer";
		$userType[22] = "secretary of Strategic Support Services";
		$userType[23] = "Secretary of Strategic Support Services";
		$userType[24] = "Secretary of Corporate Support Services";
		$userType[25] = "Council Support Officer";
		$userType[26] = "Secretaries";
		$userType[27] = "Mayco members";
		$userType[28] = "Legal Adviser in the Office of Executive Mayor";
		$userType[29] = "Exco";
		$userType[30] = "Scribers";
		$userType[31] = "Manager";
		$userType[32] = "Senior manager";
		$userType[33] = "Acting senior manager";
		$userType[34] = "Acting manager";
		$userType[35] = "Official";
		$userType[36] = "Senior chief training ";
		$userType[37] = "Senior security ";
		$userType[38] = "Senior chief traffic ";
		$userType[39] = "Senior superintendent traffic ";
		$userType[40] = "Acting Executive Director";
		$userType[41] = "Senior Chief Admin";
		$userType[42] = "Acting Senior Chief Admin";
		$userType[43] = "Waste Management ";
		$userType[44] = "Senior admin housing";
		$userType[45] = "Public Participation Officer";
		$userType[46] = "Executive Director";
		$userType[47] = "Speaker";
		$userType[48] = "Council Whip";
		$userType[49] = "Executive Mayor";
		$userType[50] = "MMC";
		$userType[51] = "Secretary to MMC";
	?>

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Greetings to you'); ?></h1>
			</div>
		</div>
	</div>
		<div class="col-md-12">
		 <p>
			 User <?php echo $Fname.' '.$Sname?> updated his/her password
			 <table>
					 <tr>
						 <td><?php echo __('Username'); ?></td>
						 <td><?php echo $Username?></td>
					 </tr>
						 <tr>
							 <td><?php echo __('Password'); ?></td>
							 <td><?php if($Password) { echo $Password; } else { echo 'Not Changed'; }?></td>
						 </tr>
							 <tr>
								 <td>Department</td>
								 <td><?php echo $departments[$alldata['User']['department_id']]?></td>
							 </tr>
								 <tr>
									 <td>Role</td>
									 <td><?php echo $userType[$alldata['User']['user_type_id']]?></td>
								 </tr>
									 <tr>
										 <td>Email</td>
										 <td><?php echo $alldata['User']['email']?></td>
									 </tr>
										 <tr>
											 <td>Cellnumber</td>
											 <td><?php echo $alldata['User']['cellnumber']?></td>
										 </tr>

			 </table>
     </p>
		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
