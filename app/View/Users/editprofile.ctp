<div class="users form  form-group">
    <?php echo $this->Form->create('User', ['type' => 'post']); ?>
    <fieldset>
        <p class='btn btn-info'>Edit My Profile<p/>
        <?php
		echo $this->Form->input('id');
		echo $this->Form->input('department_id');
        echo "<br style='clear:both' />";
        echo $this->Form->input('user_type_id');
        echo "<br style='clear:both' />";
        echo $this->Form->input('fname', array('label' => __('First Name')));
        echo "<br style='clear:both' />";
        echo $this->Form->input('sname', array('label' => __('Van')));
        echo "<br style='clear:both' />";
        echo $this->Form->input('approver', array('label' => 'Can approve', 'type' => 'select', 'options' => [ 1 => 'Yes', 2 => 'No']));
        echo "<br style='clear:both' />";
        echo $this->Form->input('username', array('label' => 'Username'));
        echo "<br style='clear:both' />";
        echo $this->Form->input('password', array('label' => 'Password', 'value' => ''));
        echo "<br style='clear:both' />";
        echo $this->Form->input('email', ['required' => 'required']);
        echo "<br style='clear:both' />";
        echo $this->Form->input('cellnumber', ['required' => 'required']);
        echo "<br style='clear:both' />";
        echo $this->Form->input('telephone');
        ?>
    </fieldset>

    <?php echo $this->Form->end(__('Save Changes')); ?>
</div>

<style>
    .btn-info {
        width: 60%;
        text-align: left;
    }
    .form-control {
        width: 40%;
    }
    label {
        width: 20%;
        float: left;
    }
</style>
