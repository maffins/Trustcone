<h3 class='btn btn-info'>Settings</h3>

<p>The following reports are available in the system</p>

<table class="table-stripped table">
    <tr>
        <td>
            <?php echo $this->Html->link(__('User Types'), array('controller' => 'user_types', 'action' => 'index')); ?>
        </td>
        <td>
            <?php echo $this->Html->link(__('Manage Statuses'), array('controller' => 'statuses', 'action' => 'index')); ?>
        </td>
    </tr>

</table>