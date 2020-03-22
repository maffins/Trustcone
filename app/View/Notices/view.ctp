<div class="maycoDocuments view">

    <div class="row">

        <?php $logged_user = AuthComponent::user(); ?>

        <div class="col-md-12">
            <table cellpadding="0" cellspacing="0" class="table table-striped" style="background-color: #; width: 1000px; margin: 0 auto">
                <thead>
                <tr style="background-color: #156F30">
                    <td colspan="5" style="text-align: center; font-size: 20px"><b>COUNCIL NOTICE MEETING: <?php echo $Meeting['Meeting']['name']; ?></b>&nbsp;</td>
                </tr>

                <?php $counter++; ?>
                <tr>
                    <th><?php echo $this->Paginator->sort('Uploaded by'); ?></th>
                    <th colspan="2"><?php echo $this->Paginator->sort('document name'); ?></th>
                    <th><?php echo $this->Paginator->sort('created on'); ?></th>
                    <th class="actions" <?php if($logged_user['id'] == 51 || $logged_user['id'] == 1) :?> style ="display:block" <?php else:?> style ="display:none" <?php endif;?> ></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $noticecounter = 0;
                foreach ($Notice as $notic):

                 if($notic['Notice']['document_name']):
                  $noticecounter = 1;
              ?>

                <tr style="border: 1px solid #">
                    <td>
                        <?php echo $Meeting['User']['fname']." ".$Meeting['User']['sname'] ?>
                    </td>
                    <td><?php
                                    echo $this->Html->link($notic['Notice']['document_name'], array( 'action' => 'sendFile', $notic['Notice']['id']), array('target' => '_blank'));
                        ?>
                        <br />
                        <?php
                                    echo $this->Html->link('Download', array( 'action' => 'sendFile', $notic['Notice']['id']), array('target' => '_blank'));
                        ?>
                    </td>
                    <td><b><i><?php
                                    echo $this->Html->link('I\'m unable to access/download a file?', array( 'action' => 'cantdownload', $notic['Notice']['id']));
                                ?>&nbsp;</b></i>
                    </td>
                    <td><?php echo substr($notic['Notice']['created'], 0, 10); ?>&nbsp;</td>
                    <td class="actions" <?php if($logged_user['id'] == 51 || $logged_user['id'] == 1) :?> style ="display:block" <?php else:?> style ="display:none" <?php endif;?> >
                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $notic['Notice']['id']), array('escape' => false)); ?>
                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $notic['Notice']['id']), array('escape' => false)); ?>
                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $notic['Notice']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $notic['Notice']['id'])); ?>
                    </td>
                </tr>

                <?php
                 endif;
                endforeach;

                 if(!$noticecounter):
              ?>

                <tr style="">
                    <td colspan="5" style="t"><b><?php echo __('There is currently no notices'); ?></b>&nbsp;</td>
                </tr>
                <?php endif?>

                <tr><td colspan="5" style="background-color: #DEE1DD;color: #DEE1DD;border: 0"></td></tr>
                <tr><td colspan="5" style="background-color: #DEE1DD;color: #DEE1DD;border: 0"></td></tr>
                <tr><td colspan="5" style="background-color: #DEE1DD;color: #DEE1DD;border: 0"></td></tr>

                </tbody>
            </table>


        </div><!-- end col md 9 -->

    </div>
</div>
