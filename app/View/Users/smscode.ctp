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
                <p><b><?php echo __('Please enter the code that has been sent to your number'); ?>. </b></p>
            </td>
        </tr>
        <tr>
            <td class="col-lg-2 control-label left boldlabel">Code</td>
            <td><?php echo $this->Form->input('resetcode', array('label' => false)); ?></td>
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

</div>
