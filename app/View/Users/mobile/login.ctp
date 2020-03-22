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
    <table class="table">
      <tr>
       <td class="col-lg-2 control-label left boldlabel"><?php echo __('Username'); ?></td>
      </tr><tr>
       <td><?php echo $this->Form->input('username', array('label' => false)); ?></td>
      </tr>
      <tr>
       <td class="col-lg-2 control-label left boldlabel"><?php echo __('Password'); ?></td>
      </tr><tr>
       <td><?php echo $this->Form->input('password', array('label' => false));?></td>
      </tr>

      <tr>
        <td>
            <?php $this->Captcha->render(); ?>
        </td>
      </tr>
      <tr>
       <td>
         <?php
             $options = array(
                'label' => 'Login',
                'class' => 'btn-primary',
            );
          echo $this->Form->end($options);
       ?>
       </td>
      </tr>
        <tr>
            <td >If you have forgotten your password, <b><?php echo $this->Html->link(__('Click here'), array('controller' => 'users', 'action' => 'forgotpassword'), array('escape' => false)); ?></b> to reset.</td>
        </tr>
    </table>

</div>

<script>

    $(function(){
      // bind change event to select
      $('#dynamic_select').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = '/documentstracker.co.za/'+url+'/users/login'; // redirect
          }
          return false;
      });
    });


  $('.creload').on('click', function() {
      var mySrc = $(this).prev().attr('src');
      var glue = '?';
      if(mySrc.indexOf('?')!=-1)  {
          glue = '&';
      }
      $(this).prev().attr('src', mySrc + glue + new Date().getTime());
      return false;
  });

  window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#loaded';
        window.location.reload(true);
    }
  }
</script>