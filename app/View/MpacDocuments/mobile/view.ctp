<div class="maycoDocuments view">

	<div class="row">

		<div class="col-md-12">
			<table cellpadding="0" cellspacing="0" class="table table-striped" style="background-color: #; width: 1000px; margin: 0 auto">
				<thead>
				<tr style="background-color: #156F30">
					<td style="text-align: center; font-size: 20px"><b>MPAC SECTION 79 COMMITTEE: <?php echo $Meeting['Meeting']['name']; ?></b>&nbsp;</td>
				</tr>
				<tr style="color: black;background-color: #">
					<td style="text-align: center; font-size: 20px"><b><?php echo __('AGENDA'); ?></b>&nbsp;</td>
				</tr>
				<?php $counter++; ?>
				<tr>
					<th ><?php echo $this->Paginator->sort('document name'); ?></th>
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

					<td><?php
                                    echo $this->Html->link($agend['MeetingAgenda']['document_name'], array( 'action' => 'sendFile', $agend['MeetingAgenda']['id'],1), array('target' => '_blank'));
						?>&nbsp;
						<br />
						<?php
                                    echo $this->Html->link('Download', array( 'action' => 'sendFile', $agend['MeetingAgenda']['id'],1), array('target' => '_blank'));
						?>&nbsp;
					</td>
        </tr><tr>
					<td><b><i><?php
                                    echo $this->Html->link('I\'m unable to access/download a file?', array( 'action' => 'cantdownload', $agend['MeetingAgenda']['id'],1));
								?>&nbsp;</b></i>
					</td>

				</tr>

				<?php
                 endif;
                endforeach;

                 if(!$agendacounter):
?>

				<tr style="">
					<td style="t"><b><?php echo __('There is currently no agenda documents'); ?></b>&nbsp;</td>
				</tr>
				<?php endif?>
				<tr style="color: black;background-color: #">
				<td style="text-align: center; font-size: 20px; background-color: #156F30"><b><?php echo __('PREVIOUS MEETING MINUTES'); ?></b>&nbsp;</td>
				</tr>
				<?php $counter++; ?>
				<tr>
					<th ><?php echo $this->Paginator->sort('document name'); ?></th>
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
					<td><?php
                                    echo $this->Html->link($minutes['MeetingMinutes']['document_name'], array( 'action' => 'sendFile', $minutes['MeetingMinutes']['id'], 2), array('target' => '_blank'));
						?>
						<br/>
						<?php
                                    echo $this->Html->link('Download', array( 'action' => 'sendFile', $minutes['MeetingMinutes']['id'], 2), array('target' => '_blank'));
						?>&nbsp;</td>
          </tr><tr>
					<td><b><i><?php
                                    echo $this->Html->link('I\'m unable to access/download a file?', array( 'action' => 'cantdownload', $minutes['MeetingMinutes']['id'],2));
								?>&nbsp;</b></i>
					</td>
				</tr>

				<?php
                  endif;
                endforeach;

                if(!$minutescounter):
?>

				<tr style="">
				<td  style=""><b><?php echo __('There are currently no previous minutes documents'); ?></b>&nbsp;</td>
				</tr>
				<?php endif?>
				<tr style="color: black;background-color: #">
				<td  style="text-align: center; font-size: 20px; background-color: #156F30"><b><?php echo __('ITEMS'); ?></b>&nbsp;</td>
				</tr>
				<?php $counter++; ?>
				<tr>
					<th ><?php echo $this->Paginator->sort('document name'); ?></th>
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
					<td><?php
                                    echo $this->Html->link($item['MeetingItems']['document_name'], array( 'action' => 'sendFile', $item['MeetingItems']['id'], 3), array('target' => '_blank'));
						?>&nbsp;
						<br />
						<?php
                                    echo $this->Html->link('Download', array( 'action' => 'sendFile', $item['MeetingItems']['id'], 3), array('target' => '_blank'));
						?>&nbsp;</td>
          </tr><tr>
					<td><b><i><?php
                                    echo $this->Html->link('I\'m unable to access/download a file?', array( 'action' => 'cantdownload', $item['MeetingItems']['id'],3));
								?>&nbsp;</b></i>
					</td>
				</tr>

				<?php
                    endif;
                endforeach;

                if(!$meetingscounter):
?>
				<tr style="">
					<td  style=""><b>There are no Items documents</b>&nbsp;</td>
				</tr>
				<?php endif;?>
				<tr style="color: black;background-color: #">
				<td  style="text-align: center; font-size: 20px; background-color: #156F30"><b><?php echo __('ANNEXURES'); ?></b>&nbsp;</td>
				</tr>
				<?php $counter++; ?>
				<tr>
					<th ><?php echo $this->Paginator->sort('document name'); ?></th>
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
					<td><?php
                                    echo $this->Html->link($attachment['MeetingAttachments']['document_name'], array( 'action' => 'sendFile', $attachment['MeetingAttachments']['id'], 4), array('target' => '_blank'));
						?>
						<br />
						<?php
                                    echo $this->Html->link('Download', array( 'action' => 'sendFile', $attachment['MeetingAttachments']['id'], 4), array('target' => '_blank'));
						?>&nbsp;</td>
          </tr><tr>
					<td>
						<b><i>
								<?php
                                    echo $this->Html->link('I\'m unable to access/download a file?', array( 'action' => 'cantdownload', $attachment['MeetingAttachments']['id'],4));
								?>&nbsp;</i></b>
					</td>
				</tr>

				<?php
                  endif;

                endforeach;

                    if($meetingattachmentcounter == 0):
                ?>
				<tr><td style=""><b><?php echo __('There are no annexure documents at the moment'); ?></b>></td></tr>
				<?php endif;?>


				<tr style="color: black;background-color: #">
				<td  style="text-align: center; font-size: 20px; background-color: #156F30"><b><?php echo __('SEPARATE COVERS'); ?></b>&nbsp;</td>
				</tr>
				<?php $counter++; ?>
				<tr>
					<th ><?php echo $this->Paginator->sort('document name'); ?></th>
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
					<td><?php
                                    echo $this->Html->link($sptr['MeetingSeparatecovers']['document_name'], array( 'action' => 'sendFile', $sptr['MeetingSeparatecovers']['id'],5), array('target' => '_blank'));
						?>
						<br />
						<?php
                                    echo $this->Html->link('Download', array( 'action' => 'sendFile', $sptr['MeetingSeparatecovers']['id'],5), array('target' => '_blank'));
						?>&nbsp;</td>
          </tr><tr>
					<td>
						<b><i>
								<?php
                                    echo $this->Html->link('I\'m unable to access/download a file?', array( 'action' => 'cantdownload', $sptr['MeetingSeparatecovers']['id'],5));
								?>&nbsp;</i></b>
					</td>
				</tr>

				<?php
                  endif;

                endforeach;

                    if($meetingaseparatecoverscounter == 0):
                ?>
				<tr><td style=""><b><?php echo __('There are no separate covers documents at the moment'); ?></b>></td></tr>
				<?php endif;?>
					<tr style="color: black;background-color: #156F30">
							<td  colspan="" style="text-align: center; font-size: 17px"><b><?php echo __('ADDENDUM'); ?></b>&nbsp;</td>
					</tr>
					<?php $counter++; ?>
					<tr>
							<th  style="text-align:left"><?php echo $this->Paginator->sort('document name'); ?></th>
					</tr>
					</thead>
					<?php $noticecounter = 0; foreach ($Addendums as $addendum):

								if($addendum['MeetingAddendum']['document_name']): $noticecounter = 1;
						?>

					<tr style="border: 1px solid #156F30">
							<td >
									<?php
														echo $this->Html->link($addendum['MeetingAddendum']['document_name'], array( 'action' => 'sendFile', 'controller' => 'CorporateServicesDocuments', $addendum['MeetingAddendum']['id'],8), array('target' => '_blank'));
									?>&nbsp;
									<br />
									<?php
														echo $this->Html->link('Download', array( 'action' => 'sendFile', 'controller' => 'CorporateServicesDocuments', $addendum['MeetingAddendum']['id'],8), array('target' => '_blank'));
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

				<tr><td style="background-color: #DEE1DD;color: #DEE1DD;border: 0"></td></tr>

				</tbody>
			</table>


		</div><!-- end col md 9 -->

	</div>
</div>