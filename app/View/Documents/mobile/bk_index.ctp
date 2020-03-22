<div class="documents index">
    <div class="actions">
        <ul>
            <li style="display: none; font-weight: bold; list-style: none; margin-left: -50px"><?php echo $this->Html->link(__('Capture new Document'), array('action' => 'add')); ?></li>
        </ul>
    </div>
    <?php if($canapprove):?>
    <p class='btn btn-info'>Documents needing my attention<p/>
    <br style="clear: both" />
    <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="fidu-tables1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
        <thead>
        <tr>
            <th><?php echo 'Directory'; ?></th>
            <th><?php echo 'Document Owner'; ?></th>
            <th><?php echo 'Document Type'; ?></th>
            <th><?php echo 'Document priority'; ?></th>
            <th><?php echo 'Actual Document'; ?></th>
            <?php if ($ceo) :?>
            <th><?php echo 'Approval reason'; ?></th>
            <?php else:?>
            <th><?php echo 'Document Date'; ?></th>
            <?php endif;?>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($documentsApprove as $document): //print_r($document);die;?>
        <tr>
            <td>
                <?php echo $this->Html->link($document['departments']['name'], array('action' => 'departmentdocuments', $document['departments']['id'])); ?>
            </td>
            <td><?php echo h($document['documents']['fname'].' '.$document['documents']['sname']); ?>&nbsp;</td>
            <td><?php echo h($document['documents']['name']); ?>&nbsp;</td>
            <td><?php
           if ($document['documents']['priority'] == 'high')
           {
    	        echo "<b style='color:red'>High</b>";
                }
                else if ($document['documents']['priority'] == 'normal')
                {
                echo "<b style='color:red'>Normal</b>";
                }
                else if ($document['documents']['priority'] == 'low')
                {
                echo "<b style='color:orange'>Low</b>";
                } else {
                echo "<b style=''>Normal</b>";
                }
                ?>&nbsp;</td>
            <td>
                <?php $id =$document['documents']['id'];
                    if ($document['documents']['compiled_document'] == "No Document")
                    {
                        echo "<b>No Document uploaded</b>";
                }else {
                echo $this->Html->link($document['documents']['compiled_document'], array( 'action' => 'sendFile', $document['documents']['id']));
                }
                ?>
            </td>
            <?php if ($ceo) :?>
            <td>
                <?php
                      $tracker = ClassRegistry::init('DocumentsTracker');
                      $query = "select update_reason from documents_trackers where document_id = ".$document['documents']['id']." order by id desc limit 1";
                      $reason = $tracker->query($query);
                echo $reason[0]['documents_trackers']['update_reason'];
                ?>
            </td>
            <?php else:?>
            <td><?php echo h($document['documents']['document_date']); ?>&nbsp;</td>
            <?php endif;?>
            <td>
                <table>
                    <tr><?php $idd = "approved".$id;?>
                        <td><input type="checkbox" name="approved" id="<?php echo $idd ?>" onclick='SaveApproval("<?php echo $id ?>", "<?php echo $idd ?>")'>Approve</td>

                    </tr>
                    <tr>

                        <?php $id_declined_comment = "declinedComment".$id;?>
                        <td><hr /><textarea placeholder="Decline comment here" name="declinedComment<?php echo $id ?>" id="declinedComment<?php echo $id ?>"></textarea>
                            <input type="button" value="Decline with a comment" onclick='SaveDecline("<?php echo $id ?>", "<?php echo $id_declined_comment ?>")' ></td>
                    </tr>

                </table>

            </td>
            <td class="actions" style="display: none">
                <?php echo $this->Html->link(__('Take Action'), array('action' => 'decide', $document['documents']['id'])); ?> <span class="glyphicon glyphicon-folder-open"></span>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>


    <br /><p class='btn btn-info'>My Documents<p/>
    <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="fidu-tables" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
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
        <?php foreach ($documents as $document): //print_r($document);die;?>
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
                        echo "<b style='color:red'>Normal</b>";
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
    <?php endif?>
</div>

<script type="text/javascript">
    function openComment(what, id) {

        var id = "#"+id;
        var row = "#comment"+what;
        alert('Its coming now '+row);

        if ($(id).is(':checked')) {
           // document.getElementById(row).style.display = 'block';
        } else {
           // document.getElementById(row).style.display = 'none';
        }

    }

    $(document).ready(function() {
        $('#fidu-tables').DataTable();
    } );
    $(document).ready(function() {
        $('#fidu-tables1').DataTable();
    } );

    function SaveDecline(id, textCommentId) {

        var declined = "#declined"+id;
        var decliendTextareaId =  "#"+textCommentId;
        var actualComment = $(decliendTextareaId).val();
        var approval = "#approved"+id;

        $.ajax({
            //url: "/documentstracker.co.za/Documents/"+id,
            url: "<?php echo Router::url(['controller' => 'Documents', 'action' => 'declined', true]); ?>",
            type: 'POST',
            cache :false,
            data: {
                id: id,
                comment: actualComment,
            },
            success: function(data) {
                alert('Approval done and notifications sent to the owner and the secretaray');
                document.getElementById(declined).setAttribute('disabled', 'disabled');
                document.getElementById(approval).setAttribute('disabled', 'disabled');
            },
            error: function(data) {
                alert('There is a problem '+data);
            }
        });
    }

    function SaveApproval(id, checkbox_id) {

        var declined = "#declined"+id;
        var approval = "#checkbox_id"+id;

        $.ajax({
            url: "<?php echo Router::url(['controller' => 'Documents', 'action' => 'approved', true]); ?>",
            //url: "/documentstracker.co.za/Documents/approved/"+id,
            cache :false,
            type: 'POST',
            data: {
                id: id,
            },
            success: function(data) {
                alert('Approval done and notifications sent to the owner and the secretaray');
                document.getElementById(declined).setAttribute('disabled', 'disabled');
                document.getElementById(approval).setAttribute('disabled', 'disabled');
            },
            error: function(data) {
                alert('There is a problem '+data);
            }
        });
    }

</script>
