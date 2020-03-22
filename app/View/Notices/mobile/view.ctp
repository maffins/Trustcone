
<div style="margin-left: -25px">
    <table cellpadding="0" cellspacing="0" class="table table-striped" style="background-color: #156F30; float: left">
        <thead>
        <tr style="background-color: #156F30">
            <td  colspan="" style="text-align: center; font-size: 17px"><b>COUNCIL NOTICE MEETING:<br /> <?php echo $Meeting['Meeting']['name']; ?></b>&nbsp;</td>
        </tr>

        <tr style="color: black;background-color: red">
            <td  colspan="" style="text-align: center; font-size: 17px"><b><?php echo __('NOTICE NAME'); ?></b>&nbsp;</td>
        </tr>
        <?php $counter++; ?>
        <tr>
            <th  style="text-align:left"><?php echo $this->Paginator->sort('document name'); ?></th>
        </tr>
        </thead>
        <?php  $noticecounter = 0; foreach ($Notice as $notic):

          if($notic['Notice']['document_name']): $noticecounter++;
          ?>

        <tr style="border: 1px solid #156F30">
            <td >
                <?php
                           echo $this->Html->link($notic['Notice']['document_name'], array( 'action' => 'sendFile', $notic['Notice']['id']), array('target' => '_blank'));
                ?>&nbsp;
                <br />
                <?php
                           echo $this->Html->link('Download', array( 'action' => 'sendFile', $notic['Notice']['id']), array('target' => '_blank'));
                ?>&nbsp;
            </td>
        </tr>
        <tr>
            <td><b><i><?php
                       echo $this->Html->link('Cant access/Download file?', array( 'action' => 'cantdownload', $notic['Notice']['id'],1));
                ?>&nbsp;</b></i>
            </td>
        </tr>
      <?php endif;?>
        <?php endforeach;
        if(!$noticecounter):
     ?>

       <tr style="">
           <td style="t"><b><?php echo __('There is currently no notices'); ?></b>&nbsp;</td>
       </tr>
       <?php endif?>



        <tr><td colspan="" style="background-color: #DEE1DD;color: #DEE1DD;border: 0"></td></tr>
        <tr><td colspan="" style="background-color: #DEE1DD;color: #DEE1DD;border: 0"></td></tr>
        <tr><td colspan="" style="background-color: #DEE1DD;color: #DEE1DD;border: 0"></td></tr>

        </tbody>
    </table>


</div><!-- end col md 9 -->

</div>
</div>
