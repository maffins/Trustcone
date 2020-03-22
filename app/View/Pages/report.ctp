<h3 class='btn btn-info'>Reports</h3>
<br />
<br />
<p>The following reports are available in the system</p>
<style>
    a {
        background-image:none;
        border:1px solid transparent;
        border-radius:4px;
        cursor:pointer;
        display:inline-block;
        font-size:14px;
        font-weight:normal;
        line-height:1.42857;
        margin-bottom:0;
        padding:6px 12px;
        text-align:center;
        touch-action:manipulation;
        vertical-align:middle;
        white-space:nowrap;
    }
</style>
<table class="table-stripped table">
    <tr>
        <td>
            <?php echo $this->Html->link(__('CEO Report'), array('controller' => 'Documents', 'action' => 'actingreports')); ?>
        </td>
        <td>
            <?php echo $this->Html->link(__('Audit Trail'), array('controller' => 'auditTrails', 'action' => 'index')); ?>
        </td>
        <td>
            <?php echo $this->Html->link(__('Documents'), array('controller' => 'Documents', 'action' => 'reports')); ?>
        </td>
    </tr>
</table>