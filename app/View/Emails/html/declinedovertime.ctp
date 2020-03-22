<table border="1" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td>
            <h2><?php echo __('Matjhabeng Local Municipality Document Management System'); ?></h2>
        </td>
    </tr>
    <?if ($what != 1):?>
      <h2>Your overtime request was declined</h2>
    <?php elseif($what == 2):?>
        <h2>Overtime request approved</h2>
  <?php endif;?>
    <tr>
        <td style="padding: 20px 0 30px 0;">
            <p><p><?php echo $message ?></p></p>
        </td>
    </tr>
    <tr>
        <td style="text-align: center">
            <?php echo __('@DTA 2018'); ?>
        </td>
    </tr>
</table>
