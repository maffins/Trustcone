<div class="maycoDocuments view">

	<?php $logged_user = AuthComponent::user(); ?>

	<div class="row">

		<div class="col-md-12">
			<table cellpadding="0" cellspacing="0" class="table table-striped" style="background-color: #; width: 1000px; margin: 0 auto">
				<thead>
				<tr style="background-color: #156F30">
					<td colspan="5" style="text-align: center; font-size: 20px"><b>CORPORATE SERVICES SECTION 80 COMMITEE MEETING: <?php echo $Meeting['Meeting']['name']; ?></b>&nbsp;</td>
				</tr>
				<tr style="color: black;background-color: #">
					<td colspan="5" style="text-align: center; font-size: 20px"><b><?php echo __('AGENDA'); ?></b>&nbsp;</td>
				</tr>
				<?php $counter++; ?>
				<tr>
					<th><?php echo $this->Paginator->sort('Uploaded by'); ?></th>
					<th colspan="2"><?php echo $this->Paginator->sort('document name'); ?></th>
					<th><?php echo $this->Paginator->sort('created on'); ?></th>
					<td class="actions" <?php if($logged_user['id'] == 51 || $logged_user['id'] == 1 || $logged_user['id'] == 245) :?> style ="display:block" <?php else:?> style ="display:none" <?php endif;?> >
				</tr>
				</thead>
				<tbody>
				<?php
                $agendacounter = 0;
                foreach ($Agenda as $agend):

                 if($agend['MeetingAgenda']['document_name']):
                  $agendacounter = 1;
?>

				<tr style="border: 1px solid #">
					<td>
						<?php echo $Meeting['User']['fname']." ".$Meeting['User']['sname'] ?>
					</td>
					<td><?php
                                    echo $this->Html->link($agend['MeetingAgenda']['document_name'], array( 'action' => 'sendFile', $agend['MeetingAgenda']['id'],1), array('target' => '_blank'));
						?>&nbsp;
					</td>
					<td><b><i><?php
                                    echo $this->Html->link('I\'m unable to access/download a file?', array( 'action' => 'cantdownload', $agend['MeetingAgenda']['id'],1));
								?>&nbsp;</b></i>
					</td>
					<td><?php echo substr($agenda['MeetingAgenda']['created'], 0, 10); ?>&nbsp;</td>
					<td class="actions" <?php if($logged_user['id'] == 51 || $logged_user['id'] == 1 || $logged_user['id'] == 245) :?> style ="display:block" <?php else:?> style ="display:none" <?php endif;?> >
					<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $agend['MeetingAgenda']['id']), array('escape' => false)); ?>
					<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $agend['MeetingAgenda']['id']), array('escape' => false)); ?>
					<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $agend['MeetingAgenda']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $agend['MeetingAgenda']['id'])); ?>
					</td>
				</tr>

				<?php
                 endif;
                endforeach;

                 if(!$agendacounter):
?>

				<tr style="">
					<td colspan="5" style="t"><b><?php echo __('There is currently no agenda documents'); ?></b>&nbsp;</td>
				</tr>
				<?php endif?>
				<tr style="color: black;background-color: #">
				<td colspan="5" style="text-align: center; font-size: 20px; background-color: #156F30"><b><?php echo __('PREVIOUS MEETING MINUTES'); ?></b>&nbsp;</td>
				</tr>
				<?php $counter++; ?>
				<tr>
					<th><?php echo $this->Paginator->sort('Uploaded by'); ?></th>
					<th colspan="2"><?php echo $this->Paginator->sort('document name'); ?></th>
					<th><?php echo $this->Paginator->sort('created on'); ?></th>
					<td class="actions" <?php if($logged_user['id'] == 51 || $logged_user['id'] == 1 || $logged_user['id'] == 245) :?> style ="display:block" <?php else:?> style ="display:none" <?php endif;?> >
				</tr>
				</thead>
				<tbody>
				<?php
                $minutescounter = 0;
                foreach ($previousminutes as $minutes):

                if($minutes['MeetingMinutes']['document_name']):
                $minutescounter = 1;
?>

				<tr style="border: 1px solid #">
					<td>
						<?php echo $Meeting['User']['fname']." ".$Meeting['User']['sname'] ?>
					</td>
					<td><?php
                                    echo $this->Html->link($minutes['MeetingMinutes']['document_name'], array( 'action' => 'sendFile', $minutes['MeetingMinutes']['id'], 2), array('target' => '_blank'));
						?>&nbsp;</td>
					<td><b><i><?php
                                    echo $this->Html->link('I\'m unable to access/download a file?', array( 'action' => 'cantdownload', $minutes['MeetingMinutes']['id'],2));
								?>&nbsp;</b></i>
					</td>
					<td><?php echo substr($minutes['MeetingMinutes']['created'], 0, 10); ?>&nbsp;</td>
					<td class="actions" <?php if($logged_user['id'] == 51 || $logged_user['id'] == 1 || $logged_user['id'] == 245) :?> style ="display:block" <?php else:?> style ="display:none" <?php endif;?> >
					<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $minutes['MeetingMinutes']['id']), array('escape' => false)); ?>
					<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $minutes['MeetingMinutes']['id']), array('escape' => false)); ?>
					<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $minutes['MeetingMinutes']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $minutes['MeetingMinutes']['id'])); ?>
					</td>
				</tr>

				<?php
                  endif;
                endforeach;

                if(!$minutescounter):
?>

				<tr style="">
				<td colspan="6" style=""><b><?php echo __('There are currently no previous minutes documents'); ?></b>&nbsp;</td>
				</tr>
				<?php endif?>
				<tr style="color: black;background-color: #">
				<td colspan="6" style="text-align: center; font-size: 20px; background-color: #156F30"><b><?php echo __('ITEMS'); ?></b>&nbsp;</td>
				</tr>
				<?php $counter++; ?>
				<tr>
					<th><?php echo $this->Paginator->sort('Uploaded by'); ?></th>
					<th colspan="2"><?php echo $this->Paginator->sort('document name'); ?></th>
					<th><?php echo $this->Paginator->sort('created on'); ?></th>
					<th class="actions" <?php if($logged_user['id'] == 51 || $logged_user['id'] == 1 || $logged_user['id'] == 245) :?> style ="display:block" <?php else:?> style ="display:none" <?php endif;?> ></th>
				</tr>
				</thead>
				<tbody>
				<?php
                   $meetingscounter = 0;
                  foreach ($Meetingitems as $item):

                  if($item['MeetingItems']['document_name']):
                  $meetingscounter = 1;
?>

				<tr style="border: 1px solid #">
					<td>
						<?php echo $Meeting['User']['fname']." ".$Meeting['User']['sname'] ?>
					</td>
					<td><?php
                                    echo $this->Html->link($item['MeetingItems']['document_name'], array( 'action' => 'sendFile', $item['MeetingItems']['id'], 3), array('target' => '_blank'));
						?>&nbsp;</td>
					<td><b><i><?php
                                    echo $this->Html->link('I\'m unable to access/download a file?', array( 'action' => 'cantdownload', $item['MeetingItems']['id'],3));
								?>&nbsp;</b></i>
					</td>
					<td><?php echo substr($item['MeetingItems']['created'], 0, 10); ?>&nbsp;</td>
					<td class="actions" <?php if($logged_user['id'] == 51 || $logged_user['id'] == 1 || $logged_user['id'] == 245) :?> style ="display:block" <?php else:?> style ="display:none" <?php endif;?> >
					<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $item['MeetingItems']['id']), array('escape' => false)); ?>
					<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $item['MeetingItems']['id']), array('escape' => false)); ?>
					<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $item['MeetingItems']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $item['MeetingItems']['id'])); ?>
					</td>
				</tr>

				<?php
                    endif;
                endforeach;

                if(!$meetingscounter):
?>
				<tr style="">
					<td colspan="6" style=""><b>There are no Items documents</b>&nbsp;</td>
				</tr>
				<?php endif;?>
				<tr style="color: black;background-color: #">
				<td colspan="6" style="text-align: center; font-size: 20px; background-color: #156F30"><b><?php echo __('ANNEXURES'); ?></b>&nbsp;</td>
				</tr>
				<?php $counter++; ?>
				<tr>
					<th><?php echo $this->Paginator->sort('Uploaded by'); ?></th>
					<th colspan="2"><?php echo $this->Paginator->sort('document name'); ?></th>
					<th><?php echo $this->Paginator->sort('created on'); ?></th>
					<th class="actions" <?php if($logged_user['id'] == 51 || $logged_user['id'] == 1 || $logged_user['id'] == 245) :?> style ="display:block" <?php else:?> style ="display:none" <?php endif;?> ></th>
				</tr>
				</thead>
				<tbody>
				<?php
                    $meetingattachmentcounter = 0;

                    foreach ($MeetingAttachments as $attachment):

                    if($attachment['MeetingAttachments']['document_name']):
                      $meetingattachmentcounter = 1;
                  ?>

				<tr style="border: 1px solid #fff862">
					<td>
						<?php echo $Meeting['User']['fname']." ".$Meeting['User']['sname'] ?>
					</td>
					<td><?php
                                    echo $this->Html->link($attachment['MeetingAttachments']['document_name'], array( 'action' => 'sendFile', $attachment['MeetingAttachments']['id'], 4), array('target' => '_blank'));
						?>&nbsp;</td>
					<td>
						<b><i>
								<?php
                                    echo $this->Html->link('I\'m unable to access/download a file?', array( 'action' => 'cantdownload', $attachment['MeetingAttachments']['id'],4));
								?>&nbsp;</i></b>
					</td>
					<td><?php echo substr($attachment['MeetingAttachments']['created'], 0, 10); ?>&nbsp;</td>
					<td class="actions" <?php if($logged_user['id'] == 51 || $logged_user['id'] == 1 || $logged_user['id'] == 245) :?> style ="display:block" <?php else:?> style ="display:none" <?php endif;?> >
					<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $attachment['MeetingAttachments']['id']), array('escape' => false)); ?>
					<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $attachment['MeetingAttachments']['id']), array('escape' => false)); ?>
					<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $attachment['MeetingAttachments']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $attachment['MeetingAttachments']['id'])); ?>
					</td>
				</tr>

				<?php
                  endif;

                endforeach;

                    if($meetingattachmentcounter == 0):
                ?>
				<tr><td colspan="5" style=""><b><?php echo __('There are no annexure documents at the moment'); ?></b>></td></tr>
				<?php endif;?>


				<tr style="color: black;background-color: #">
				<td colspan="6" style="text-align: center; font-size: 20px; background-color: #156F30"><b><?php echo __('SEPARATE COVERS'); ?></b>&nbsp;</td>
				</tr>
				<?php $counter++; ?>
				<tr>
					<th><?php echo $this->Paginator->sort('Uploaded by'); ?></th>
					<th colspan="2"><?php echo $this->Paginator->sort('document name'); ?></th>
					<th><?php echo $this->Paginator->sort('created on'); ?></th>
					<th class="actions" <?php if($logged_user['id'] == 51 || $logged_user['id'] == 1 || $logged_user['id'] == 245) :?> style ="display:block" <?php else:?> style ="display:none" <?php endif;?> ></th>
				</tr>
				</thead>
				<tbody>
				<?php
                    $meetingaseparatecoverscounter = 0;

                    foreach ($MeetingSeparatecovers as $sptr):

                    if($sptr['MeetingSeparatecovers']['document_name']):
                      $meetingaseparatecoverscounter = 1;
                  ?>

				<tr style="border: 1px solid #fff862">
					<td>
						<?php echo $Meeting['User']['fname']." ".$Meeting['User']['sname'] ?>
					</td>
					<td><?php
                                    echo $this->Html->link($sptr['MeetingSeparatecovers']['document_name'], array( 'action' => 'sendFile', $sptr['MeetingSeparatecovers']['id'],5), array('target' => '_blank'));
						?>&nbsp;</td>
					<td>
						<b><i>
								<?php
                                    echo $this->Html->link('I\'m unable to access/download a file?', array( 'action' => 'cantdownload', $sptr['MeetingSeparatecovers']['id'],5));
								?>&nbsp;</i></b>
					</td>
					<td><?php echo substr($sptr['MeetingSeparatecovers']['created'], 0, 10); ?>&nbsp;</td>
					<td class="actions" <?php if($logged_user['id'] == 51 || $logged_user['id'] == 1 || $logged_user['id'] == 245) :?> style ="display:block" <?php else:?> style ="display:none" <?php endif;?> >
					<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $sptr['MeetingSeparatecovers']['id']), array('escape' => false)); ?>
					<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $sptr['MeetingSeparatecovers']['id']), array('escape' => false)); ?>
					<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $sptr['MeetingSeparatecovers']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $sptr['MeetingSeparatecovers']['id'])); ?>
					</td>
				</tr>

				<?php
                  endif;

                endforeach;

                    if($meetingaseparatecoverscounter == 0):
                ?>
				<tr><td colspan="5" style=""><b><?php echo __('There are no separate covers documents at the moment'); ?></b>></td></tr>
				<?php endif;?>

            <tr style="color: black;background-color: #156F30">
                <td colspan="5" style="text-align: center; font-size: 20px"><b><?php echo __('ADDENDUMS'); ?></b>&nbsp;</td>
            </tr>
            <?php $counter++; ?>
            <tr>
                <th><?php echo $this->Paginator->sort('Uploaded by'); ?></th>
                <th colspan="2"><?php echo $this->Paginator->sort('document name'); ?></th>
                <th><?php echo $this->Paginator->sort('created on'); ?></th>
                <th class="actions" <?php if($logged_user['id'] == 51 || $logged_user['id'] == 1 || $logged_user['id'] == 245) :?> style ="display:block" <?php else:?> style ="display:none" <?php endif;?> ></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $addendumcounter = 0;
            foreach ($Addendums as $adend):

             if($adend['MeetingAddendum']['document_name']):
              $addendumcounter = 1;
?>

            <tr style="border: 1px solid #">
                <td>
                    <?php echo $Meeting['User']['fname']." ".$Meeting['User']['sname'] ?>
                </td>
                <td><?php
                                echo $this->Html->link($adend['MeetingAddendum']['document_name'], array( 'action' => 'sendFile', $adend['MeetingAddendum']['id'],8), array('target' => '_blank'));
                    ?>
                    <br />
                    <?php
                                echo $this->Html->link('Download', array( 'action' => 'sendFile', $adend['MeetingAddendum']['id'],8), array('target' => '_blank'));
                    ?>
                </td>
                <td><b><i><?php
                                echo $this->Html->link('I\'m unable to access/download a file?', array( 'action' => 'cantdownload', $adend['MeetingAddendum']['id'],8));
                            ?>&nbsp;</b></i>
                </td>
                <td><?php echo substr($adend['MeetingAddendum']['created'], 0, 10); ?>&nbsp;</td>
                <td class="actions" <?php if($logged_user['id'] == 51 || $logged_user['id'] == 1 || $logged_user['id'] == 245) :?> style ="display:block" <?php else:?> style ="display:none" <?php endif;?> >
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $adend['MeetingAddendum']['id']), array('escape' => false)); ?>
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $adend['MeetingAddendum']['id']), array('escape' => false)); ?>
                <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $adend['MeetingAddendum']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $adend['MeetingAddendum']['id'])); ?>
                </td>
            </tr>

            <?php
             endif;
            endforeach;

             if(!$addendumcounter):
?>

            <tr style="">
                <td colspan="5" style="t"><b><?php echo __('There is currently no addendum documents'); ?></b>&nbsp;</td>
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
