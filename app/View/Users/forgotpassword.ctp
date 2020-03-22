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
      <a href="#" onclick="goBack()"><span class="glyphicon glyphicon-step-backward"></span><?php echo __('BACK')?></a>
    <table class="table">
        <tr>
            <td colspan="2">
                <p><b><?php echo __('Please enter the email address that was captured in the system.') ?></b></p>
            </td>
        </tr>
        <tr>
            <td class="col-lg-2 control-label left boldlabel"><?php echo __('Email Address') ?></td>
            <td><?php echo $this->Form->input('email', array('label' => false)); ?></td>
        </tr>
        <tr>
            <td colspan="2">
                <?php
             $options = array(
                'label' => __('Next >>'),
                'class' => 'btn-primary',
                );
                echo $this->Form->end($options);
                ?>
            </td>
        </tr>
    </table>

</div>
<script>
function goBack() {
    window.history.back();
}
</script>
