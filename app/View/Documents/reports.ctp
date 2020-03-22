<div>

    <p class='btn btn-info'>Documents report<p/>
    <?php echo $this->Form->create('documents', ['enctype' => 'multipart/form-data']); ?>
    <table cellpadding="0" cellspacing="0" class="table table-striped" id="fidu-tables1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;display: none">
        <?php
            $options = [ 0 => '-- Select --', 2 => 'Managers', 3 => 'Budget', 4 => 'CFO', 5 => 'CEO'];
            $priorities = ['' => '- Select -', 'high' => 'Hight', 'low' => 'Low'];
        ?>
        <tr>
            <td><?php echo $this->Form->input('startdate', array('label' => 'Start Date', 'class' => 'date'));?></td>
            <td><?php echo $this->Form->input('enddate', array('label' => 'End Date', 'class' => 'date'));?></td>
            <td><?php echo $this->Form->input('approver', array('label' => 'Signed by', 'type' => 'select', 'options' => $options));?></td>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('status', array('label' => 'Status', 'type' => 'select', 'options' => $options));?></td>
            <td><?php echo $this->Form->input('priority', array('label' => 'Priority', 'type' => 'select', 'options' => $priorities));?></td>
            <td><?php echo $this->Form->input('departments', array('label' => 'Directorate', 'type' => 'select', 'options' => $departments));?></td>
            <td><?php echo $this->Form->end(__('Filter >>')); ?></td>
        </tr>
    </table>

    <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="fidu-tables" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
    <thead>
        <tr>
            <th><?php echo 'Document Type'; ?></th>
            <th><?php echo 'Document Owner'; ?></th>
            <th><?php echo 'Owner Email'; ?></th>
            <th><?php echo 'Derectorate'; ?></th>
            <th><?php echo 'Status'; ?></th>
            <th><?php echo 'Priority'; ?></th>
            <th><?php echo 'Date Compiled'; ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($documents as $document): //print_r($document);die; ?>
        <tr>
            <td><?php echo h($document['documents']['name']); ?>&nbsp;</td>
            <td><?php echo h($document['documents']['fname']." ".$document['documents']['sname']); ?>&nbsp;</td>
            <td><?php echo h($document['documents']['email']); ?>&nbsp;</td>
            <td>
                <?php echo $this->Html->link($document['departments']['name'], array('action' => 'departmentdocuments', $document['departments']['id'])); ?>
            </td>
            <td>
             <?php
                   if ($document['documents']['tracker'] == 2) {
                    echo "With CFO";
                   }
                   if ($document['documents']['tracker'] == 3) {
                    echo "With CEO/Municipal manager";
                   }
                   if ($document['documents']['tracker'] == 7) {
                    echo "With CFO Office ";
                    if ($document['documents']['decision'] == 1) {
                        echo "<b>(Approved by CFO)</b>";
                    } else {
                    echo "<b>(Declined by CFO)</b>";
                    }
                    }
                    if ($document['documents']['tracker'] == 8) {
                    echo "With CEO Office";
                    if ($document['documents']['decision'] == 1) {
                    echo "<b>(Approved by CEO/MM)</b>";
                    } else {
                    echo "<b>(Declined by CEO/MM)</b>";
                    }
                    }
                    if ($document['documents']['tracker'] == 10) {
                    echo "Declined";
                    }
                    if ($document['documents']['tracker'] == 6) {
                    echo "Approved by CEO";
                    }
             ?>
    	    </td>
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
                }
                else
                {
                echo "<b style=''>Normal</b>";
                }
                ?>
            </td>
            <td><?php echo h($document['documents']['created']); ?>&nbsp;</td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
<script type="text/javascript">


    $(document).ready(function () {
        $('.date').datepicker({
            format: "yyyy-mm-dd"
        });

    });
</script>

<script>
    $(document).ready(function() {
        $('#fidu-tables').DataTable();
    } );
</script>
