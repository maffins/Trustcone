<div class="users form">
    <?php echo $this->Flash->render('auth'); ?>
    <?php echo $this->Form->create('User', array(
    'class' => 'form-horizontal',
    'role' => 'form',
    'inputdefaults' => array(
    'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
    'div' => array('class' => 'form-group'),
    'class' => array('form-control'),
    'label' => array('class' => 'col-lg-2 control-label'),
    'between' => '<div class="col-lg-3">',
        'after' => '</div>',
    'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline')),
    ))); ?>
    <?php echo $this->Form->create('User'); ?>
    <table class="table">
        <tr>
            <td colspan="2">
                <p><b>Please enter the new password (at least 8 characters and use a combination of uppercase and lower case letters ).</b></p>
            </td>
        </tr>
        <tr>
            <td class="col-lg-2 control-label left boldlabel">Password </td>
            <td><?php echo $this->Form->input('password', array('label' => false)); ?></td>
        </tr>
        <tr>
            <td class="col-lg-2 control-label left boldlabel">Confirm <?php echo __('Password'); ?></td>
            <td><?php echo $this->Form->input('password1', array('label' => false, 'type' => 'password')); ?></td>
        </tr>
        <?php echo $this->Form->input('user_id', array('value' => $user_id, 'type' => 'hidden')); ?>
        <tr>
            <td colspan="2">
                <?php
             $options = array(
                'label' => 'Next >>',
                'class' => 'btn-primary',
                );
                echo $this->Form->end($options);
                ?>
            </td>
        </tr>
    </table>

    <script type="application/javascript">
        $('#password1').blur(function() {
            if ($('#password').attr('value') == $('#password1').attr('value')) {
                alert('Please ensure that value 1 is the same as value 2');
                return false;
            } else { return true; }
        });
    </script>

</div>