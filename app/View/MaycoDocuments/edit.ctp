<div class="counsilorDocuments form">
<style>
    .form-control {
        width:50% !important;
    }
</style>
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Edit Mayco Meeting Documents'); ?></h1>
			</div>
		</div>
	</div>
	<?php //echo $maindid." <<<<<<<<<<<";?>
	<div class="col-md-7">
		<?php echo $this->Form->create('MaycoDocument', array('role' => 'form', 'enctype' => 'multipart/form-data')); ?>

		<div class="form-group" style="display: none;">
			<?php echo $this->Form->input('user_id', array('class' => 'form-control', 'placeholder' => 'User Id'));?>
			<?php echo $this->Form->input('maindid', array('class' => 'form-control', 'placeholder' => 'Meeting Id', 'value' => $maindid));?>
		</div>

		<h2><?php echo __('Meeting name'); ?></h2>

		<div class="form-group">
			<?php echo $this->Form->input('meeting', array('class' => 'form-control', value=> $meetings[0]['Meeting']['name'], 'placeholder' => 'Meeting name', 'type' => 'text'));?>
		</div>
		<br />

		<h2><?php echo __('Agenda'); ?></h2>
		<br />
		<div class="form-group">
			<?php echo $this->Form->input('agenda.', array('class' => 'form-control', 'label'=>'Agenda Documents', 'placeholder' => 'Documents to upload',  'type' => 'file', 'multiple' => 'multiple'));?>
		</div>
		<br />

		<h2><?php echo __('Previous meeting minutes'); ?></h2>

		<div class="form-group">
			<?php echo $this->Form->input('minutes.', array('class' => 'form-control', 'label'=>'Previous minutes', 'placeholder' => 'Documents to upload',  'type' => 'file', 'multiple' => 'multiple'));?>
		</div>
		<br />

		<h2><?php echo __('Items'); ?></h2>

		<div class="form-group">
			<?php echo $this->Form->input('items.', array('class' => 'form-control', 'label'=>'Items', 'placeholder' => 'Items',  'type' => 'file', 'multiple' => 'multiple'));?>
		</div><br />

		<h3>Attachments</h3>

		<div class="form-group">
			<?php echo $this->Form->input('attachments.', array('class' => 'form-control', 'label'=>'Attachments', 'placeholder' => 'Attachments',  'type' => 'file', 'multiple' => 'multiple'));?>
		</div>

		<br /><br />
		<div class="form-group">
			<?php echo $this->Form->submit(__('Upload All Documents'), array('class' => 'btn btn-default')); ?>
		</div>

		<?php echo $this->Form->end() ?>

	</div><!-- end col md 6 -->
    <div class="col-md-5" style="text-align: left; padding: 35px 0 0 20px">
        <small>Here you can change the meeting name, and upload new documents to replace those already uploaded, <br />
         The list below shows whats been uploaded already so you can either leave like that if you not removing it, or simply capture new documents on the right to add to the already existing documents.
        </small>
<br />
<br />
        <table>
            <tr style="color: black;background-color: #fff862"">
            <td nowrap colspan="2" style="text-align: center; font-size: 20px"><b>Agenda Documents</b>&nbsp;</td>
            </tr>
            <?php $counter++; ?>

            <tbody>
            <?php foreach ($meetings[0]['MeetingAgenda'] as $agenda):?>

            <tr style="border: 1px solid #fff862">

                <td nowrap><?php
                          echo $this->Html->link($agenda['document_name'], array( 'action' => 'sendFile', $agenda['id'],1), array('target' => '_blank'));
                    ?>&nbsp;</td>
                <td class="actions" >
                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('controller' => 'MeetingAgendas', 'action' => 'delete', $agenda['id'],$maindid), array('escape' => false), __('Are you sure you want to delete # %s?', $agenda['id'])); ?>
                </td>
            </tr>

            <?php endforeach; ?>


            <tr style="color: black;background-color: #fff862"">
            <td nowrap colspan="2" style="text-align: center; font-size: 20px"><b><?php echo __('PREVIOUS MEETING MINUTES'); ?></b>&nbsp;</td>
            </tr>
            <?php $counter++; ?>
<?php //print_r($meetings[0]['MeetingMinute']);?>
            <tbody>
            <?php foreach ($meetings[0]['MeetingMinute'] as $agenda):?>

            <tr style="border: 1px solid #fff862">

                <td nowrap><?php
                                            echo $this->Html->link($agenda['document_name'], array( 'action' => 'sendFile', $agenda['id'],1), array('target' => '_blank'));
                    ?>&nbsp;</td>
                <td class="actions" >
                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('controller' => 'MeetingMinutes', 'action' => 'delete', $agenda['id'],$maindid), array('escape' => false), __('Are you sure you want to delete # %s?', $agenda['id'])); ?>
                </td>
            </tr>

            <?php endforeach; ?>
            <tr style="color: black;background-color: #fff862"">
            <td nowrap colspan="2" style="text-align: center; font-size: 20px"><b><?php echo __('ITEMS'); ?></b>&nbsp;</td>
            </tr>
            <?php $counter++; ?>

            <tbody>
            <?php foreach ($meetings[0]['MeetingItem'] as $agenda):?>

            <tr style="border: 1px solid #fff862">

                <td nowrap><?php
                                            echo $this->Html->link($agenda['document_name'], array( 'action' => 'sendFile', $agenda['id'],1), array('target' => '_blank'));
                    ?>&nbsp;</td>
                <td class="actions" >
                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('controller' => 'MeetingItems', 'action' => 'delete', $agenda['id'],$maindid), array('escape' => false), __('Are you sure you want to delete # %s?', $agenda['id'])); ?>
                </td>
            </tr>

            <?php endforeach; ?>
            </tbody>
            <tr style="color: black;background-color: #fff862"">
            <td nowrap colspan="2" style="text-align: center; font-size: 20px"><b>Attachments</b>&nbsp;</td>
            </tr>
            <?php $counter++; ?>

            <tbody>
            <?php foreach ($meetings[0]['MeetingAttachment'] as $agenda):?>

            <tr style="border: 1px solid #fff862">

                <td nowrap><?php
                         echo $this->Html->link($agenda['document_name'], array( 'action' => 'sendFile', $agenda['id'],1), array('target' => '_blank'));
                    ?>&nbsp;</td>
                <td class="actions" >
                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('controller' => 'MeetingAttachments', 'action' => 'delete', $agenda['id'],$maindid ), array('escape' => false), __('Are you sure you want to delete # %s?', $agenda['id'])); ?>
                </td>
            </tr>

            <?php endforeach; ?>
            </tbody>
        </table>

    </div><!-- end col md 4 -->
</div><!-- end row -->
</div>


<div id="myModal" class="modal hide">
    <div class="modal-header">
        <a href="#" data-dismiss="modal" aria-hidden="true" class="close">×</a>
        <h3>Remove a document </h3>
    </div>
    <div class="modal-body">
        <p>You are about to remove the document from this meeting.</p>
        <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
        <a href="#" id="btnYes" class="btn danger">Yes</a>
        <a href="#" data-dismiss="modal" aria-hidden="true" class="btn secondary">No</a>
    </div>
</div>

<script>

    $('#myModal').on('show', function() {
    var id = $(this).data('id'),
    removeBtn = $(this).find('.danger');
    })

    $('.confirm-delete').on('click', function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    $('#myModal').data('id', id).modal('show');
    });

    $('#btnYes').click(function() {
    // handle deletion here
    var id = $('#myModal').data('id');
    $('[data-id='+id+']').remove();
    $('#myModal').modal('hide');
    });

</script>
