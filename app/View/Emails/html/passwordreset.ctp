<div class="counsilorDocuments form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Password reset successfully'); ?></h1>
			</div>
		</div>
	</div>
		<div class="col-md-12">
<p>Your new login credentials are as follows:</p>
	  <table>
			 <tr>
				 <td><?php echo __('Username'); ?></td>
				 <td><?php echo $user['User']['username']?></td>
			 </tr>
			 <tr>
				 <td><?php echo __('Password'); ?></td>
				 <td><?php echo $password?></td>
			 </tr>
			 <tr>
				 <td colspan="2">
					 http://www.trustconetest.co.za
				 </td>
			 </tr>
	 </table>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
