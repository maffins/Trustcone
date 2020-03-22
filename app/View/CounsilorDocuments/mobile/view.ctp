
<div style="margin-left: -25px">
    <table cellpadding="0" cellspacing="0" class="table table-striped" style="background-color: #156F30; float: left">
        <thead>
        <tr style="background-color: #156F30">
            <td  colspan="" style="text-align: center; font-size: 17px"><b>COUNCIL MEETING:<br /> <?php echo $Meeting['Meeting']['name']; ?></b>&nbsp;</td>
        </tr>

        <tr style="color: black;background-color: red">
            <td  colspan="" style="text-align: center; font-size: 17px"><b><?php echo __('NOTICE'); ?></b>&nbsp;</td>
        </tr>
        <?php $counter++; ?>
        <tr>
            <th  style="text-align:left"><?php echo $this->Paginator->sort('document name'); ?></th>
        </tr>
        </thead>
        <?php  $noticecounter = 0; foreach ($Notice as $notic):

          if($notic['MeetingNotice']['document_name']): $noticecounter++;
          ?>

        <tr style="border: 1px solid #156F30">
            <td >
                <?php
                           echo $this->Html->link($notic['MeetingNotice']['document_name'], array( 'action' => 'sendFile', $notic['MeetingNotice']['id'],7), array('target' => '_blank'));
                ?>&nbsp;
                <br />
                <?php
                           echo $this->Html->link('Download', array( 'action' => 'sendFile', $notic['MeetingNotice']['id'],7), array('target' => '_blank'));
                ?>&nbsp;
            </td>
        </tr>
        <tr>
            <td><b><i><?php
                       echo $this->Html->link('Cant access/Download file?', array( 'action' => 'cantdownload', $notic['MeetingNotice']['id'],1));
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


        <tr style="color: black;background-color: #156F30">
            <td  colspan="" style="text-align: center; font-size: 17px"><b><?php echo __('AGENDA'); ?></b>&nbsp;</td>
        </tr>
        <?php $counter++; ?>
        <tr>
            <th  style="text-align:left"><?php echo $this->Paginator->sort('document name'); ?></th>
        </tr>
        </thead>
        <?php  foreach ($Meeting['MeetingAgenda'] as $agenda): if($agenda['document_name']): ?>

        <tr style="border: 1px solid #156F30">
            <td >
                <?php
                           echo $this->Html->link($agenda['document_name'], array( 'action' => 'sendFile', $agenda['id'],1), array('target' => '_blank'));
                ?>&nbsp;
                <br />
                <?php
                           echo $this->Html->link('Download', array( 'action' => 'sendFile', $agenda['id'],1), array('target' => '_blank'));
                ?>&nbsp;
            </td>
        </tr>
        <tr>
            <td><b><i><?php
                       echo $this->Html->link('Cant access/Download file?', array( 'action' => 'cantdownload', $agenda['id'],1));
                ?>&nbsp;</b></i>
            </td>
        </tr>
      <?php endif; endforeach; ?>

        <tr style="">
            <td  colspan="" style="text-align: left; font-size: 17px"><b><?php echo __('PREVIOUS MEETING MINUTES'); ?></b>&nbsp;</td>
        </tr>
        <?php $counter++; ?>
        <tr>
            <th ><?php echo $this->Paginator->sort('document name'); ?></th>
        </tr>
        </thead>

        <?php foreach ($Meeting['MeetingMinute'] as $minutes): if($minutes['document_name']): ?>

        <tr style="border: 1px solid #156F30">
            <td ><?php
                             echo $this->Html->link($minutes['document_name'], array( 'action' => 'sendFile', $minutes['id'], 2), array('target' => '_blank'));
                ?>&nbsp;
                <br />
                <?php
                             echo $this->Html->link('Download', array( 'action' => 'sendFile', $minutes['id'], 2), array('target' => '_blank'));
                ?>&nbsp;
            </td>
        </tr>
        <tr>
            <td><b><i><?php
                      echo $this->Html->link('Cant access/Download file?', array( 'action' => 'cantdownload', $minutes['id'],2));
                ?>&nbsp;</b></i>
            </td>
        </tr>
        <?php endif; endforeach; ?>

        <tr style="color: black;background-color: #156F30">
            <td  colspan="" style="text-align: left; font-size: 17px"><b><?php echo __('ITEMS'); ?></b>&nbsp;</td>
        </tr>
        <?php $counter++; ?>
        <tr>
            <th ><?php echo $this->Paginator->sort('document name'); ?></th>
        </tr>
        </thead>
        <?php foreach ($Meeting['MeetingItem'] as $item): if($item['document_name']):?>

        <tr style="border: 1px solid #156F30">
            <td ><?php
                                    echo $this->Html->link($item['document_name'], array( 'action' => 'sendFile', $item['id'], 3), array('target' => '_blank'));
                ?>&nbsp;
                <br />
                <?php
                                    echo $this->Html->link('Download', array( 'action' => 'sendFile', $item['id'], 3), array('target' => '_blank'));
                ?>&nbsp;
            </td>
        </tr>
        <tr>
            <td><b><i><?php
                      echo $this->Html->link('Cant access/Download file?', array( 'action' => 'cantdownload', $item['id'],3));
                ?>&nbsp;</b></i>
            </td>
        </tr>
      <?php endif; endforeach; ?>
        <tr style="color: black;background-color: #156F30">
            <td  colspan="" style="text-align: left; font-size: 17px"><b><?php echo __('ANNEXURES'); ?></b>&nbsp;</td>
        </tr>
        <?php $counter++; ?>
        <tr>
            <th ><?php echo $this->Paginator->sort('document name'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($Meeting['MeetingAttachment'] as $attachment): if($attachment['document_name']):?>

        <tr style="border: 1px solid #156F30">
            <td ><?php
                       echo $this->Html->link($attachment['document_name'], array( 'action' => 'sendFile', $attachment['id'], 4), array('target' => '_blank'));
                ?>&nbsp;
                <br />
                <?php
                       echo $this->Html->link('Document', array( 'action' => 'sendFile', $attachment['id'], 4), array('target' => '_blank'));
                ?>&nbsp;
            </td>
        </tr>
        <tr>
            <td><b><i><?php
                      echo $this->Html->link('Cant access/Download file?', array( 'action' => 'cantdownload', $attachment['id'],4));
                        ?>&nbsp;</b></i>
            </td>
        </tr>
      <?php endif; endforeach; ?>



        <tr style="color: black;background-color: #156F30">
            <td  colspan="" style="text-align: left; font-size: 17px"><b><?php echo __('SEPARATE COVERS'); ?></b>&nbsp;</td>
        </tr>
        <?php $counter++; ?>
        <tr>
            <th ><?php echo $this->Paginator->sort('document name'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($MeetingSeparatecovers as $separatecvrs): if($separatecvrs['MeetingSeparatecovers']['document_name']): ?>

        <tr style="border: 1px solid #156F30">
            <td ><?php
                    echo $this->Html->link($separatecvrs['MeetingSeparatecovers']['document_name'], array( 'action' => 'sendFile', $separatecvrs['MeetingSeparatecovers']['id'], 5), array('target' => '_blank'));
                ?>&nbsp;
                <br />
                <?php
                     echo $this->Html->link('Download', array( 'action' => 'sendFile', $separatecvrs['MeetingSeparatecovers']['id'], 5), array('target' => '_blank'));
                ?>&nbsp;
            </td>
        </tr>
        <tr>
            <td><b><i><?php
                      echo $this->Html->link('Cant access/Download file?', array( 'action' => 'cantdownload', $separatecvrs['MeetingSeparatecovers']['id'], 5));
                        ?>&nbsp;</b></i>
            </td>
        </tr>
      <?php endif; endforeach; ?>
          <tr style="color: black;background-color: #156F30">
              <td  colspan="" style="text-align: center; font-size: 17px"><b><?php echo __('ADDENDUM'); ?></b>&nbsp;</td>
          </tr>
          <?php $counter++; ?>
          <tr>
              <th  style="text-align:left"><?php echo $this->Paginator->sort('document name'); ?></th>
          </tr>
          </thead>
          <?php $noticecounter = 0; foreach ($Addendums as $addendum):

                if($addendum['MeetingAddendum']['document_name'] && $addendum['MeetingAddendum']['document_name'] != 'No Document' ): $noticecounter = 1;
            ?>

          <tr style="border: 1px solid #156F30">
              <td >
                  <?php
                             echo $this->Html->link($addendum['MeetingAddendum']['document_name'], array( 'action' => 'sendFile', $addendum['MeetingAddendum']['id'],8), array('target' => '_blank'));
                  ?>&nbsp;
                  <br />
                  <?php
                             echo $this->Html->link('Download', array( 'action' => 'sendFile', $addendum['MeetingAddendum']['id'],8), array('target' => '_blank'));
                  ?>&nbsp;
              </td>
          </tr>
          <tr>
              <td><b><i><?php
                         echo $this->Html->link('Cant access/Download file?', array( 'action' => 'cantdownload', 'controller' => 'CorporateServicesDocuments', $addendum['MeetingAddendum']['id'],8));
                  ?>&nbsp;</b></i>
              </td>
          </tr>
        <?php endif; endforeach;
        if(!$noticecounter):
        ?>

        <tr style="">
           <td style="t"><b><?php echo __('There is currently no addendum'); ?></b>&nbsp;</td>
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
