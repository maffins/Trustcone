<div class="users " style="margin:0 0 0 230px">
  <?php echo $this->Form->create('User', array('ation' => 'sections')); ?>
  <h4><?php echo __('Set Section for '.$user['User']['fname'].' '.$user['User']['sname'].' ('.$user['UserType']['name'].' )'); ?></h4>
  <table cellpadding="0" cellspacing="0" class="table-striped">
    <tr>
      <th><?php echo __('Sections'); ?></th>
  </tr>
    <tr>
    <?php echo $this->Form->input('id', array('value' => $user['User']['id'], 'type' => 'hidden')) ?>

    <tr>
      <td colspan="8">
        <small style="clear:both"><b>Secions</b></small><br style='clear:both' />

          <?php foreach ($AllSections as $value) {
                if($value['Section']['name'] != '- Select Section -'): 
                  ?>
                  <p style="width:120px; float:left;font-weight:bold"><?php echo $value['Section']['name']?>
                    <input type="checkbox" <?php if( in_array($value['Section']['id'], $user['User']['sections']) ) { echo 'checked'; }?> name="data[User][sections][]" style="margin:0 !important" value="<?php echo $value['Section']['id']?>" id="UserSections<?php echo $value['Section']['id']?>">
                  </p>
                <?php
               endif;
             }?>
      </td>
    </tr>
    <tr>
      <td colspan="8">
      <br style="clear:both" />
       <?php echo $this->Form->end(__('Set Sections')); ?>
      </td>
    </tr>
  </table>
  <br style="clear:both" />
  <br style="clear:both" />
</div>
