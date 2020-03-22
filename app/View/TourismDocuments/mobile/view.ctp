
<div class="col-md-5">
    <table cellpadding="0" cellspacing="0" class="table table-striped" style="background-color: #156F30; margin: 0 auto">
        <thead>
        <tr style="background-color: #156F30">
            <td nowrap colspan="" style="text-align: center; font-size: 17px"><b>TOURISM, ENVIRONMENT AFFAIRS AND AGRICULTURE SECTION 80 COMMITTEE:<br /> <?php echo $Meeting['Meeting']['name']; ?></b>&nbsp;</td>
        </tr>
        <tr style="color: black;background-color: #156F30">
            <td nowrap colspan="" style="text-align: center; font-size: 17px"><b><?php echo __('AGENDA'); ?></b>&nbsp;</td>
        </tr>
        <?php $counter++; ?>
        <tr>
            <th nowrap style="text-align:left"><?php echo $this->Paginator->sort('document name'); ?></th>
        </tr>
        </thead>
        <?php foreach ($Meeting['MeetingAgenda'] as $agenda):?>

        <tr style="border: 1px solid #156F30">
            <td nowrap><?php
                           echo $this->Html->link($agenda['document_name'], array( 'action' => 'sendFile', $agenda['id'],1), array('target' => '_blank'));
                ?>&nbsp;
                <br />
                <?php
                           echo $this->Html->link('Download', array( 'action' => 'sendFile', $agenda['id'],1), array('target' => '_blank'));
                ?>&nbsp;</td>
        </tr>
        <tr>
            <td><b><i><?php
                       echo $this->Html->link('Cant access/Download file?', array( 'action' => 'cantdownload', $agenda['id'],1));
                ?>&nbsp;</b></i>
            </td>
        </tr>
        <?php endforeach; ?>

        <tr style="">
            <td nowrap colspan="" style="text-align: left; font-size: 17px"><b><?php echo __('PREVIOUS MEETING MINUTES'); ?></b>&nbsp;</td>
        </tr>
        <?php $counter++; ?>
        <tr>
            <th nowrap><?php echo $this->Paginator->sort('document name'); ?></th>
        </tr>
        </thead>

        <?php foreach ($Meeting['MeetingMinute'] as $minutes):?>

        <tr style="border: 1px solid #156F30">
            <td nowrap><?php
                             echo $this->Html->link($minutes['document_name'], array( 'action' => 'sendFile', $minutes['id'], 2), array('target' => '_blank'));
                ?>
                <br />
                <?php
                             echo $this->Html->link('Download', array( 'action' => 'sendFile', $minutes['id'], 2), array('target' => '_blank'));
                ?>&nbsp;</td>
        </tr>
        <tr>
            <td><b><i><?php
                      echo $this->Html->link('Cant access/Download file?', array( 'action' => 'cantdownload', $minutes['id'],2));
                ?>&nbsp;</b></i>
            </td>
        </tr>
        <?php endforeach; ?>

        <tr style="color: black;background-color: #156F30">
            <td nowrap colspan="" style="text-align: left; font-size: 17px"><b><?php echo __('ITEMS'); ?></b>&nbsp;</td>
        </tr>
        <?php $counter++; ?>
        <tr>
            <th nowrap><?php echo $this->Paginator->sort('document name'); ?></th>
        </tr>
        </thead>
        <?php foreach ($Meeting['MeetingItem'] as $item):?>

        <tr style="border: 1px solid #156F30">
            <td nowrap><?php
                                    echo $this->Html->link($item['document_name'], array( 'action' => 'sendFile', $item['id'], 3), array('target' => '_blank'));
                ?>&nbsp;
                <br />
                <?php
                                    echo $this->Html->link('Download', array( 'action' => 'sendFile', $item['id'], 3), array('target' => '_blank'));
                ?>&nbsp;</td>
        </tr>
        <tr>
            <td><b><i><?php
                      echo $this->Html->link('Cant access/Download file?', array( 'action' => 'cantdownload', $item['id'],3));
                ?>&nbsp;</b></i>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr style="color: black;background-color: #156F30">
            <td nowrap colspan="" style="text-align: left; font-size: 17px"><b><?php echo __('ANNEXURES'); ?></b>&nbsp;</td>
        </tr>
        <?php $counter++; ?>
        <tr>
            <th nowrap><?php echo $this->Paginator->sort('document name'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($Meeting['MeetingAttachment'] as $attachment):?>

        <tr style="border: 1px solid #156F30">
            <td nowrap><?php
                                    echo $this->Html->link($attachment['document_name'], array( 'action' => 'sendFile', $attachment['id'], 4), array('target' => '_blank'));
                ?>
                <br />
                <?php
                                    echo $this->Html->link('Download', array( 'action' => 'sendFile', $attachment['id'], 4), array('target' => '_blank'));
                ?>&nbsp;</td>
        </tr>
        <tr>
            <td><b><i><?php
                      echo $this->Html->link('Cant access/Download file?', array( 'action' => 'cantdownload', $attachment['id'],4));
                ?>&nbsp;</b></i>
            </td>
        </tr>
        <?php endforeach; ?>


        <tr style="color: black;background-color: #156F30">
            <td  colspan="" style="text-align: left; font-size: 17px"><b><?php echo __('SEPARATE COVERS'); ?></b>&nbsp;</td>
        </tr>
        <?php $counter++; ?>
        <tr>
            <th ><?php echo $this->Paginator->sort('document name'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($MeetingSeparatecovers as $separatecvrs): ?>

        <tr style="border: 1px solid #156F30">
            <td ><?php
                                    echo $this->Html->link($separatecvrs['MeetingSeparatecovers']['document_name'], array( 'action' => 'sendFile', $separatecvrs['MeetingSeparatecovers']['id'], 4), array('target' => '_blank'));
                ?>
                <br />
                <?php
                                    echo $this->Html->link('Download', array( 'action' => 'sendFile', $separatecvrs['MeetingSeparatecovers']['id'], 4), array('target' => '_blank'));
                ?>&nbsp;</td>
        </tr>
        <tr>
            <td><b><i><?php
                      echo $this->Html->link('Cant access/Download file?', array( 'action' => 'cantdownload', $separatecvrs['MeetingSeparatecovers']['id'],4));
                        ?>&nbsp;</b></i>
            </td>
        </tr>
        <?php endforeach; ?>

        <tr><td colspan="" style="background-color: #DEE1DD;color: #DEE1DD;border: 0"></td></tr>
        <tr><td colspan="" style="background-color: #DEE1DD;color: #DEE1DD;border: 0"></td></tr>
        <tr><td colspan="" style="background-color: #DEE1DD;color: #DEE1DD;border: 0"></td></tr>

        </tbody>
    </table>


</div><!-- end col md 9 -->

</div>
</div>