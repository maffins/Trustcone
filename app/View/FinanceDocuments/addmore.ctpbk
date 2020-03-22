			<div class="MaycoDocument form">

				<div class="row">
					<div class="col-md-12">
						<div class="page-header">
                            <h3><?php echo __('Add more documents to: '.$Meeting[0]['Meeting']['name']); ?></h3>
						</div>
					</div>
				</div>

                <div class="col-md-9">
					<?php echo $this->Form->create('FinanceDocument', array('role' => 'form', 'enctype' => 'multipart/form-data')); ?>

					<div class="form-group" style="display: none;">
						<?php echo $this->Form->input('meeting_id', array('class' => 'form-control', 'type' => 'text', 'value' => $meeting_id));?>
					</div>

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

					<h2><?php echo __('Annexures'); ?></h2>

					<div class="form-group">
						<?php echo $this->Form->input('attachments.', array('class' => 'form-control', 'label'=>'Attachments', 'placeholder' => 'Attachments',  'type' => 'file', 'multiple' => 'multiple'));?>
					</div><br />

						<h2><?php echo __('Separate Covers'); ?></h2>

						<div class="form-group">
							<?php echo $this->Form->input('separatecovers.', array('class' => 'form-control', 'label'=>'Separate Covers', 'placeholder' => 'Separate Covers',  'type' => 'file', 'multiple' => 'multiple'));?>
						</div><br />

					<br />

					<h2><?php echo __('Addendum'); ?></h2>
					<br />
					<div class="form-group">
						<?php echo $this->Form->input('addendum.', array('class' => 'form-control', 'label'=>'Addendum items', 'placeholder' => 'Addendums to upload',  'type' => 'file', 'multiple' => 'multiple'));?>
					</div>

					<br /><br />
					<div class="form-group">
						<?php echo $this->Form->submit(__('Upload All Documents'), array('class' => 'btn btn-default')); ?>
					</div>

					<?php echo $this->Form->end() ?>

				</div><!-- end col md 12 -->
			</div><!-- end row -->
		</div>
