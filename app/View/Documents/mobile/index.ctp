<style>
    th {
        background-color: #156F30 !important;
    }
</style>
<?php if($councillor != 1) { ?>
<div class="documents index">
    <div class="row">



        <div class="col-md-9">

    <?php if($canapprove):?>
	<p class='btn btn-info'>Official Documents<p/>
    <br style="clear: both" />
	<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="fidu-tables1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
	<thead>
        <tr>
            <th><?php echo 'Document priority'; ?></th>
            <th width="60px"><?php echo 'Actual Document'; ?></th>
            <th>
                <?php
                  if ($ceo) {
                    echo 'Approval reason';
                  } else {
                    echo 'Document Date';
                  }
                ?>
            </th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>

    <?php foreach ($documentsApprove as $document): ?>

        <tr id="tafurarow<?php echo $document['documents']['id'];?>">
            <td>
                <?php
                   if ($document['documents']['priority'] == 'high')
                   {
                        echo "<b style='color:red'>High</b>";
                   }
                   else if ($document['documents']['priority'] == 'normal')
                   {
                        echo "<b style='color:black'>Normal</b>";
                   }
                   else if ($document['documents']['priority'] == 'low')
                   {
                        echo "<b style='color:orange'>Low</b>";
                   } else {
                        echo "<b style=''>Normal</b>";
                }
                ?>
            </td>
            <td>
                <?php
                   $id = $document['documents']['id'];

                    if ($document['documents']['compiled_document'] == "No Document")
                    {
                        echo "<b>No Document uploaded</b>";
                    }else {
                        echo "<b>Download: </b><br />".$this->Html->link($document['documents']['compiled_document'], array( 'action' => 'sendFile', $document['documents']['id']), array('target' => '_blank'));
                    }

                 if ($ceo || $cfo) {
                 ?>
                    <br />..................<br />
                    <input type="button" value="Ask Secretary to bring original copy" onclick="bringHardCopy('<?php echo $id?>')">
                <?php
                  }
                ?>
            </td>
             <td>
                 <?php
                 if ($ceo) {
                      $tracker = ClassRegistry::init('DocumentsTracker');
                      $query = "select update_reason from documents_trackers where document_id = ".$document['documents']['id']." order by id desc limit 1";
                      $reason = $tracker->query($query);
                      echo $reason[0]['documents_trackers']['update_reason'];
                  }else{
                    echo h($document['documents']['document_date']);
                  }
                  ?>
             </td>
            <td>
                <?php
$taridza = 0;
                if ($user_type_id == 7 || $user_type_id == 13):

                     $idd_escalte = "escalate".$id;
                     $idd_finalize = "finalized".$id;

                     if ($document['documents']['decision'] == 1) : $taridza = 1; ?>

                          Escalate to CEO <input type="checkbox" name="escalate<?php echo $id ?>" id="escalate<?php echo $id ?>" onclick='escalate("<?php echo $id ?>", "<?php echo $idd_escalte ?>")'>
                          <br />....<br />

                          Finalized <input type="checkbox" name="finalized<?php echo $id ?>" id="finalized<?php echo $id ?>" onclick='openFinalizeComment("finalized<?php echo $id ?>", "finalizediv<?php echo $id ?>")'>

                          <div id="finalizediv<?php echo $id ?>" style="display: none">
                              <textarea name="finalizecomment<?php echo $id ?>" id="finalizecomment<?php echo $id ?>"></textarea>
                              <input type="button" value="Close the document"  onclick='finalized("<?php echo $id ?>", "<?php echo $idd_escalte ?>", "<?php echo $idd_finalize ?>", "finalizecomment<?php echo $id ?>")'>
                          </div>
             </td>
                    <?php
                        else:
                            $taridza = 1;
                         if( $document['documents']['tracker'] != 2):
                          $taridza = 1;
                    ?>
                            <b style="color: red">Declined</b> : <?php echo $document['documents']['reason']; ?>
                            <br />........<br/>
                            <?php $idd_remove = "remove".$id; ?>
                            Finalized <input type="checkbox" name="finalized<?php echo $id ?>" id="finalized<?php echo $id ?>" onclick='openFinalizeComment("finalized<?php echo $id ?>", "finalizediv<?php echo $id ?>")'>

                            <div id="finalizediv<?php echo $id ?>" style="display: none">
                                <textarea name="finalizecomment<?php echo $id ?>" id="finalizecomment<?php echo $id ?>"></textarea>
                                <input type="button" value="Close the document"  onclick='finalized("<?php echo $id ?>", "<?php echo $idd_escalte ?>", "<?php echo $idd_finalize ?>", "finalizecomment<?php echo $id ?>")'>
                            </div>
                             <!-- Remove <input type="checkbox" name="remove<?php echo $id ?>" id="remove<?php echo $id ?>" onclick='removeFromList("<?php echo $id ?>", "<?php echo $idd_remove ?>")' /> -->
                            <br />........<br/>
                            <?php echo $this->Html->link(__('Edit'), array('action' => 'editCFO', $document['documents']['id'])); ?>
                        <?php endif; ?>

                    <?php endif; //end condition equal to 7 ?>

                <?php else:
                 $taridza = 1;
                    if ($user_type_id == 8 || $user_type_id == 12) :

                        if ($document['documents']['decision'] == 4) :

                             if( $document['documents']['tracker'] != 3):  $taridza = 1;
                     ?>
                                <b style="color: red">Declined</b> : <?php echo $document['documents']['reason']; ?>
                                <br />........<br/>

                                <?php $idd_remove = "remove".$id; ?>
                                <?php $idd_finalize = "finalized".$id; ?>
                                <? $idd_escalte = "escalate".$id; ?>
                                Finalized <input type="checkbox" name="finalized<?php echo $id ?>" id="finalized<?php echo $id ?>" onclick='openFinalizeComment("finalized<?php echo $id ?>", "finalizediv<?php echo $id ?>")'>
                                <div id="finalizediv<?php echo $id ?>" style="display: none">
                                    <textarea name="finalizecomment<?php echo $id ?>" id="finalizecomment<?php echo $id ?>"></textarea>
                                    <input type="button" value="Close the document"  onclick='finalized("<?php echo $id ?>", "<?php echo $idd_escalte ?>", "<?php echo $idd_finalize ?>", "finalizecomment<?php echo $id ?>")'>
                                </div>
                                <br />........<br/>
                                <?php echo $this->Html->link(__('Edit'), array('action' => 'editCFO', $document['documents']['id'])); ?>
                           <?php endif;?>

                        <?php else:

                            if( $document['documents']['tracker'] != 3):  $taridza = 1;
                        ?>

                            <b style="color: green">Approved</b>
                            <?php $idd_closeapp = "close_app".$id; ?>
                            <br />........<br/>
                            <?php $idd_remove = "remove".$id; ?>
                            <?php $idd_finalize = "finalized".$id; ?>
                            <? $idd_escalte = "escalate".$id; ?>
                            Finalized <input type="checkbox" name="finalized<?php echo $id ?>" id="finalized<?php echo $id ?>" onclick='openFinalizeComment("finalized<?php echo $id ?>", "finalizediv<?php echo $id ?>")'>
                            <div id="finalizediv<?php echo $id ?>" style="display: none">
                                <textarea name="finalizecomment<?php echo $id ?>" id="finalizecomment<?php echo $id ?>"></textarea>
                                <input type="button" value="Close the document"  onclick='finalized("<?php echo $id ?>", "<?php echo $idd_escalte ?>", "<?php echo $idd_finalize ?>", "finalizecomment<?php echo $id ?>")'>
                            </div>
                        <?php endif; ?>
                     <?php endif; ?>
                    <?php
                        else:
 $taridza = 1;
                       if ( $document['documents']['tracker'] != 7 && $document['documents']['tracker'] != 8 && $document['documents']['tracker'] != 13 && $document['documents']['tracker'] != 12 ) :  $taridza = 1;
                    ?>
                        <table>
                            <?php $tafura_id = "tafurarow".$document['documents']['id']; ?>
                            <tbody>
                            <tr>
                                <td>Approved</td>
                                <?php
                                            $idd = "approved".$id;
                                            $idDe ="declined".$id;
                                        ?>
                                <td><input type="checkbox" name="approved<?php echo $id ?>" id="approved<?php echo $id ?>" onclick='approveSave("<?php echo $id ?>", "<?php echo $idd ?>", "<?php echo $tafura_id?>", "<?php echo $idDe; ?>")'></td>
                            </tr>
                            <tr>
                                <td>Declined</td>
                                <?php $idd = "declined".$id; $idd_app = "approved".$id;?>
                                <?php $idd_com = "comment".$id; ?>
                                <td><input type="checkbox" name="declined<?php echo $id ?>" id="declined<?php echo $id ?>" onclick='openComment("<?php echo $id ?>", "<?php echo $idd ?>", "<?php echo $idd_com ?>", "<?php echo $tafura_id?>")'></td>
                          <script>
                              var idwhat_apuru ="approved<?php echo $id ?>";
                              var idwhat ="declined<?php echo $id ?>";
                              if (document.getElementById(idwhat))
                              {
                                  document.getElementById(idwhat).removeAttribute("disabled");
                              }
                              if (document.getElementById(idwhat_apuru))
                              {
                                  document.getElementById(idwhat_apuru).removeAttribute("disabled");
                              }
                          </script>
                            </tr>
                            <tr id="comment<?php echo $id ?>" style="display: none">
                                <td>Comment</td>
                                <?php $comment = "actualcommentID".$id?>
                                <?php $buttonId = "button".$id?>
                                <td><textarea id="actualcommentID<?php echo $id ?>"></textarea><input type="button"  id="button<?php echo $id ?>" value="Submit" onclick='declineSave("<?php echo $id ?>", "<?php echo $idd ?>", "<?php echo $tafura_id?>", "<?php echo $idDe; ?>", "<?php echo $comment?>", "<?php echo $idd_app?>", "<?php echo $buttonId?>")'></td>
                            </tr>
                            </tbody>
                        </table>

                  <?php else: ?>
                        With secretary
                  <?php endif; ?>
                <?php endif; ?>
            <?php endif;

             if( $taridza == 10000 ) :
            ?>
            <?php echo $this->Html->link(__('View'), array('action' => 'view', $document['Document']['id'])); ?> <span class="glyphicon glyphicon-folder-open"></span>
            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $document['Document']['id'])); ?> <span class="glyphicon glyphicon-edit"></span>
            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $document['Document']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $document['Document']['id']))); ?>

            <?php endif; ?>
            </td>

        </tr>

        <?php endforeach; ?>

        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#fidu-tables1').DataTable();
        } );
    </script>
        </div>
    <?php else: ?>


            <p class='btn btn-info'>My Documents<p/>
    <table cellpadding="0" width="700px" cellspacing="0" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="fidu-tables" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
	<thead>
	<tr>
		<th><?php echo 'Document no'; ?></th>
        <th><?php echo 'Document Type'; ?></th>
        <th><?php echo 'Document directorate/dept'; ?></th>
        <th><?php echo 'Document priority'; ?></th>
        <th><?php echo 'Document Owner'; ?></th>
      	<th><?php echo 'Status'; ?></th>
		<th><?php echo 'Date Compiled'; ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($documents as $document): ?>
	<tr>
        <td><?php echo h($document['Document']['id']); ?>&nbsp;</td>
        <td><?php echo h($document['Document']['name']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($document['Department']['name'], array('action' => 'departmentdocuments', $document['Department']['id'])); ?>
		</td>

        <td>
            <?php
               if ($document['Document']['priority'] == 'high')
               {
                    echo "<b style='color:red'>High</b>";
                }
              else if ($document['Document']['priority'] == 'normal')
               {
                echo "<b style='color:black'>Normal</b>";
                }
                else if ($document['Document']['priority'] == 'low')
               {
                    echo "<b style='color:orange'>Low</b>";
                }
                else
               {
                 echo "<b style=''>Normal</b>";
                }
           ?>
        </td>
        <td><?php echo h($document['Document']['fname'].' '.$document['Document']['sname']); ?>&nbsp;</td>
    	<td>
            <?php
               if ($document['Document']['tracker'] == 2) {
                echo "With CFO";
               }
               if ($document['Document']['tracker'] == 3) {
                echo "With CEO/Municipal manager";
               }
               if ($document['Document']['tracker'] == 7 || $document['Document']['tracker'] == 13) {
                echo "With CFO Office ";
                if ($document['Document']['decision'] == 1) {
                    echo "<b>(Approved by CFO)</b>";
                 } else {
                    echo "<b>(Declined by CFO)</b>";
                 }
               }
               if ($document['Document']['tracker'] == 8 || $document['Document']['tracker'] == 12) {
                echo "With CEO Office";
                   if ($document['Document']['decision'] == 1) {
                        echo "<b>(Approved by CEO/MM)</b>";
                     } else {
                        echo "<b>(Declined by CEO/MM)</b>";
                     }
               }
               if ($document['Document']['tracker'] == 10) {
                echo "Declined";
               }
               if ($document['Document']['tracker'] == 6) {
                echo "Approved by CEO";
               }
    	   ?>
        </td>
		<td><?php echo h($document['Document']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $document['Document']['id'])); ?> <span class="glyphicon glyphicon-folder-open"></span>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $document['Document']['id'])); ?> <span class="glyphicon glyphicon-edit"></span>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $document['Document']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $document['Document']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>

        </div>

    <script>
        $(document).ready(function() {
            $('#fidu-tables').DataTable({
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    {"width": "60px"},
                    null,
                    null
                ]
            });
        } );
    </script>
    <?php endif?>
</div>

<script>

    function finalClose(what, id, checkboxID) {

        $.ajax({
            url: "<?php echo Router::url(['controller' => 'Documents', 'action' => 'finalclose', true]); ?>",
            cache :false,
            type: 'POST',
            data: {
                id: id,
                what: what,
            },
            success: function(data) {
                alert('A notification has been sent to the owner of the document');
                document.getElementById(checkboxID).setAttribute('disabled', 'disabled');
            },
            error: function(data) {
                alert('There is a problem in closing document for final time '+data);
            }
        });
    }

    function bringHardCopy(id) {

        $.ajax({
            url: "<?php echo Router::url(['controller' => 'Documents', 'action' => 'bringhardcopy', true]); ?>",
            cache :false,
            type: 'POST',
            data: {
                id: id,
            },
            success: function(data) {
                alert('A notification has been sent to your secretary to bring the hard copy of the document');
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

    function finalized(id, escalateID, finalizeID, finalizeComment) {
        if (document.getElementById(finalizeID).checked) {

            var comment = document.getElementById(finalizeComment).value;
            if (comment == "")
            {
                alert('Please enter a reason for finalization');
                return false;
            }
            $.ajax({
                url: "<?php echo Router::url(['controller' => 'Documents', 'action' => 'finalized', true]); ?>",
                cache :false,
                type: 'POST',
                data: {
                    id: id,
                    comment: comment,
                },
                success: function(data) {
                    alert('Approval done and notifications sent to the owner');
                    if (document.getElementById(escalateID))
                    {
                        document.getElementById(escalateID).setAttribute('disabled', 'disabled');
                    }
                    document.getElementById(finalizeID).setAttribute('disabled', 'disabled');
                },
                error: function(data) {
                    alert('There is a problem in finalizing the document '+data);
                }
            });
        }
    }

 function escalate(id, checkbox_escalte) {
        if (document.getElementById(checkbox_escalte).checked) {

            $.ajax({
                url: "<?php echo Router::url(['controller' => 'Documents', 'action' => 'escalate', true]); ?>",
                cache :false,
                type: 'POST',
                data: {
                    id: id,
                },
                success: function(data) {
                    alert('Escalated succesfully');
                    document.getElementById(checkbox_escalte).setAttribute('disabled', 'disabled');
                },
                error: function(data) {
                    alert('There is a problem in escalation '+data);
                }
            });
        }
    }

 function removeFromList(id, checkbox_escalte) {
        if (document.getElementById(checkbox_escalte).checked) {

            $.ajax({
                url: "<?php echo Router::url(['controller' => 'Documents', 'action' => 'remove', true]); ?>",
                cache :false,
                type: 'POST',
                data: {
                    id: id,
                },
                success: function(data) {
                    alert('Removed succesfully');
                    document.getElementById(checkbox_escalte).setAttribute('disabled', 'disabled');
                },
                error: function(data) {
                    alert('There is a problem in removing from list '+data);
                }
            });
        }
    }

    function declineSave(id, checkboxID, tafuraID, checkboxDeclinedID, commentID, app_id, button_id) {
       // alert(checkboxDeclinedID+' the checkbox declined id');
        if (document.getElementById(checkboxDeclinedID).checked) {

            var comment  = document.getElementById(commentID).value;

            if (comment == "") {
                alert('Please enter the reason for declinign this document');
                return false;
            }

            $.ajax({
                url: "<?php echo Router::url(['controller' => 'Documents', 'action' => 'declined', true]); ?>",
                cache :false,
                type: 'POST',
                data: {
                    id: id,
                    comment: comment
                },
                success: function(data) {
                    alert('Decline done and notifications sent to the owner and the secretaray');
                    document.getElementById(checkboxID).setAttribute('disabled', 'disabled');
                    document.getElementById(checkboxDeclinedID).setAttribute('disabled', 'disabled');
                    document.getElementById(app_id).setAttribute('disabled', 'disabled');
                    //document.getElementById(button_id).setAttribute('disabled', 'disabled');
                    document.getElementById(tafuraID).style.backgroundColor = '#3F0D02';
                },
                error: function(data) {
                    alert('There is a problem in saving the decline '+data+' >> '+data.toSource());
                }
            });
        }
    }

    function openFinalizeComment( id, id_com) {

        if (document.getElementById(id).checked) {
            document.getElementById(id_com).style.display = 'block';
        } else {
            document.getElementById(id_com).style.display = 'none';
        }
    }

    function openComment(what, id, id_com) {

        if (document.getElementById(id).checked) {
            document.getElementById(id_com).style.display = 'block';
        } else {
            document.getElementById(id_com).style.display = 'none';
        }
        var idwhat = "button"+what;
        //alert(idwhat+' asfasdfas');
        if (document.getElementById(idwhat))
        {
            document.getElementById(idwhat).removeAttribute("disabled");
        }

    }
</script>

<?php
} else {
?>
<h2>Upload Documents from meetings</h2>
<p>
    To start using the system please <a href="http://trustconetest.co.za/document_manager/documents/">click here</a>
</p>

<?php } ?>