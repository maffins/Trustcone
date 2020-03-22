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
<div class="officialDocuments index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Official Documents Archives'); ?></h1>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->

	<?php
		$logged_user = AuthComponent::user();
	  $permissions = unserialize($logged_user['permissions']);
	?>

	<div class="row">
	 <div class="col-md-12" style="">

			<table cellpadding="0" cellspacing="0" class="table table-striped" style="margin: 0 auto" id="fidu-tables">
				<thead>
					<tr>
						<th ><?php echo __('id'); ?></th>
						<th ><?php echo __('Committee'); ?></th>
						<th><?php echo __('Document name'); ?></th>
						<th ><?php echo __('Decision'); ?></th>
						<th ><?php echo __('Level'); ?></th>
						<th ><?php echo __('reason'); ?></th>
						<th ><?php echo __('Uploaded by'); ?></th>
						<th ><?php echo __('Date uploaded'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($officialDocuments as $officialDocument): ?>
					<tr>
						<td ><?php echo h($officialDocument['OfficialDocument']['idcounter']); ?>&nbsp;</td>
						<td ><?php echo h($alldata[$officialDocument['OfficialDocument']['type']]); ?>&nbsp;</td>
						<td ><?php
								foreach($officialDocument['ActualOfficialDocumet'] as $actualdoc)
								{
									echo $this->Html->link($actualdoc['doc_name'], array('action' => 'sendfile', $actualdoc['id']), array('escape' => false, 'title' => 'Send to Manager'))."<br />-------<br />";
								}
						 ?>
					 </td>
						<td >
							<?php
								if($officialDocument['OfficialDocument']['tracker'] == 7) {
									 echo "Approved";
								} else {
									echo 'Declined';
								}
								?>
						</td>
						<td >
							<?php
										if($officialDocument['OfficialDocument']['tracker'] == 7) {
									echo 'Approved by Municipal Manager';
								}
								if($officialDocument['OfficialDocument']['tracker'] == 14) {
									echo 'Declined Municipal Manager';
								}

							?>&nbsp;
						</td>
						<td ><?php
							foreach($officialDocument['DocumentsTracker'] as $docTracker) {
								echo h($docTracker['update_reason']).'<br />---------------<br/>';
							}
						 ?>&nbsp;</td>
								<td>
			<?php echo $this->Html->link($officialDocument['User']['fname']." ".$officialDocument['User']['sname'], array('controller' => 'users', 'action' => 'view', $officialDocument['User']['id'])); ?>
		</td>
						<td ><?php echo h(substr($officialDocument['OfficialDocument']['created'],0,10)); ?>&nbsp;</td>

						</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div> <!-- end col md 9 -->
	</div><!-- end row -->


</div><!-- end containing of content -->

<script>

    $(document).ready(function() {
        $('#fidu-tables').DataTable();
    } );

function escalate(id, decision) {

		var comment = '';
		var declinecomme = "decline"+id; //close the comment box if for some reason the person decides to approve
		//Check if its declined then open the comment box if its empty
		if(decision == 2) {
			//Now check if we have a comment already
			var commentboxid = "declinecomment"+id;
			var comment = document.getElementById(commentboxid).value;
			if(!comment){
				//now open the box to enter the comment
				document.getElementById(declinecomme).style.display = 'block';
				return false;
			}
		} else {
				document.getElementById(declinecomme).style.display = 'none';
		}

		 $.ajax({
				 url: "<?php echo Router::url(['controller' => 'OfficialDocuments', 'action' => 'escalate', true]); ?>",
				 cache :false,
				 type: 'POST',
				 data: {
						 id: id,
						 decision: decision,
						 comment: comment,
				 },
				 success: function(data) {
					 if(decision == 1)
					 {
						 alert('Approved and sent to finance ');
					 } else {
						 alert('Declined and sent back to the requester');
					 }
					 window.location.reload();
				 },
				 error: function(data) { alert(data);return;
						 alert('There is a problem with savign the information '+data);
				 }
		 });

	}

function archive(id) {

    $.ajax({
        url: "<?php echo Router::url(['controller' => 'OfficialDocuments', 'action' => 'finalclose', true]); ?>",
        cache :false,
        type: 'POST',
        data: {
            id: id
        },
        success: function(data) {
            alert('Document succesfully archived');
						window.location.reload();
        },
        error: function(data) {
            alert('There is a problem in archiving your document for final time '+data);
        }
    });
}

function bringHardCopy(id) {

    $.ajax({
        url: "<?php echo Router::url(['controller' => 'OfficialDocuments', 'action' => 'bringhardcopy', true]); ?>",
        cache :false,
        type: 'POST',
        data: {
            id: id,
        },
        success: function(data) {
            alert('A notification has been sent to the documents uploader');
        },
        error: function(data) {
            alert('There is a problem in asking for hard copy '+data);
        }
    });
}

function approveSave(id, checkboxID, tafuraID, checkboxDeclinedID) {
    if (document.getElementById(checkboxID).checked) {

        $.ajax({
            url: "<?php echo Router::url(['controller' => 'Documents', 'action' => 'approved', true]); ?>",
            cache :false,
            type: 'POST',
            data: {
                id: id,
            },
            success: function(data) {
                alert('Approval done and notifications sent to the owner and the secretaray');
                document.getElementById(checkboxID).setAttribute('disabled', 'disabled');
                document.getElementById(checkboxDeclinedID).setAttribute('disabled', 'disabled');
                document.getElementById(tafuraID).style.backgroundColor = 'green';
            },
            error: function(data) {
                alert('There is a problem approve save  '+data);
            }
        });
    }
}

</script>
