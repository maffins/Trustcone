<style>
    dt { width: 30%; padding: 5px}
    dd { clear: none; padding: 5px }

    .form-control {
        width: 250px;
    }

</style>
<div class="Review and decide">
    <?php echo $this->Form->create('DocumentRequest'); ?>
    <p class='btn btn-info'>Approve or Decline Document<p/>
    <table class="table-striped table-hover dataTable">
<tr>
    <td>Document priority</td>
    <td><?php
           if ($document['Document']['priority'] == 'high') {
    	    echo "<b style='color:red'>High</b>";
        } else if ($document['Document']['priority'] == 'normal') {
        echo "<b style='color:red'>Normal</b>";
        }else if ($document['Document']['priority'] == 'low') {
        echo "<b style='color:orange'>Low</b>";
        } else {
        echo "<b style=''>Normal</b>";
        }
        ?>&nbsp;</td>
    <td>
    </tr><tr>
        <td><?php echo __('Document owned by'); ?></td>
        <td>
            <?php echo $document['Document']['fname']." ".$document['Document']['sname']; ?>
            &nbsp;
        </td>
        </tr><tr>
        <td><?php echo __('Directory'); ?></td>
        <td>
            <?php echo $this->Html->link($document['Department']['name'], array('controller' => 'departments', 'action' => 'view', $document['Department']['id'])); ?>
            &nbsp;
        </td>
        </tr><tr>
        <td><?php echo __('Document type <br />(<small>Click on the name to view the attached document</small>)'); ?></td>
        <td>
            <?php
                if ($document['Document']['compiled_document'] == "No Document")
                {
                    echo "<b>No Document uploaded</b>";
                }else {
                    echo $this->Html->link($document['Document']['compiled_document'], array( 'action' => 'sendFile', $document['Document']['id']));
                }
            ?>
               &nbsp;
        </td>
        </tr><tr>
        <td><?php echo __('Date Compiled'); ?></td>
        <td>
            <?php echo h($document['Document']['created']); ?>
            &nbsp;
        </td>
        </tr>
        <tr>
            <td><?php echo __('Document Id'); ?></td>
            <td>
                <?php echo h($document['Document']['id']); ?>
                &nbsp;
            </td>
        </tr>
        <tr>
        <td valign="top">Reason for Decision</td>
        <td>
            <?php
                echo $this->Form->input('reason', array('label' => false, 'type' => 'textarea', 'required' => 'required', 'class' => 'form-control'));
                echo $this->Form->input('id', array('label' => false, 'type' => 'hidden', 'value' => $document['Document']['id']));
            ?>
        </td>
        </tr><tr>
        <td><?php echo $this->Form->submit('Decline Document', ['name' => 'submit2']); ?></td>
        <td><?php echo $this->Form->submit('Approve Document', ['name' => 'submit1']); ?> </td>
        </tr>
        <tr>
            <td colspan="2"><?php echo $this->Form->end(); ?></td>
        </tr>
    </table>
</div>

