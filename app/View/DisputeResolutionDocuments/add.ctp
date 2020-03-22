<div class="row">

	<div class="col-md-3">
		<div class="actions">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo __('Actions'); ?></div>
				<div class="panel-body">
					<ul class="nav nav-pills nav-stacked">
						<li style="display: none"><a href="/users/logout">Click here to Logout</a></li>
						<?php if(AuthComponent::user()['user_type_id'] != 15 && AuthComponent::user()):?>
						<?php  if (AuthComponent::user()['user_type_id'] != 9) : ?>
						<?php if (AuthComponent::user()['user_type_id'] == 2 || AuthComponent::user()['user_type_id'] == 3 || AuthComponent::user()['user_type_id'] == 11 || AuthComponent::user()['user_type_id'] == 10 ):?>
						<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Urgent Documents'), array('controller' => 'documents', 'action' => 'urguent'), array('escape' => false)); ?> </li>
						<?php endif?>
						<?php if (AuthComponent::user()['user_type_id'] == 6 ):?>
						<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Reports'), array('controller' => 'pages', 'action' => 'report'), array('escape' => false)); ?> </li>
						<?php endif?>
						<?php if (AuthComponent::user()['user_type_id'] == 6 ):?>
						<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Settings'), array('controller' => 'pages', 'action' => 'settings'), array('escape' => false)); ?> </li>
						<?php endif?>
						<?php if (AuthComponent::user()['user_type_id'] != 6 && AuthComponent::user()['user_type_id'] != 15 && AuthComponent::user()['user_type_id'] != 27):?>
						<li style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Official Documents'), array('controller' => 'documents', 'action' => 'index'), array('escape' => false)); ?></li>
						<?php endif?>
						<?php if (AuthComponent::user()['user_type_id'] == 1 || AuthComponent::user()['user_type_id'] == 8 || AuthComponent::user()['user_type_id'] == 7 || AuthComponent::user()['user_type_id'] == 12 || AuthComponent::user()['user_type_id'] == 13 ):?>
						<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Capture Document'), array('controller' => 'documents', 'action' => 'add'), array('escape' => false)); ?> </li>
						<?php endif?>
						<li style="display:none "><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Users'), array('controller' => 'users', 'action' => 'index'), array('escape' => false)); ?></li>
						<?php
                     $userSession = AuthComponent::user();
                      if ($userSession['user_type_id'] == 3 || $userSession['user_type_id'] == 2 || $userSession['user_type_id'] == 11 || $userSession['user_type_id'] == 10):
                ?>

						<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('View Documents by directorates'), array('controller' => 'departments', 'action' => 'index'), array('escape' => false)); ?> </li>
						<?php if (AuthComponent::user()['user_type_id'] == 6 ):?>
						<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Reports'), array('controller' => 'pages', 'action' => 'report'), array('escape' => false)); ?> </li>
						<li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Settings'), array('controller' => 'pages', 'action' => 'settings'), array('escape' => false)); ?> </li>
						<?php endif?>
						<?php
                 endif;

                     if ($userSession['user_type_id'] == 3 || $userSession['user_type_id'] == 2 ):
                ?>
						<li style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Council Documents'), array('controller' => 'CounsilorDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
						<li style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('MAYCO Documents'), array('controller' => 'MaycoDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
						<?php endif ; ?>
						<?php endif ; ?> <!-- /#sidebar-wrapper -->
						<?php endif; ?>
						<?php if (AuthComponent::user()['user_type_id'] == 15):?>
						<li  style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Council Documents'), array('controller' => 'CounsilorDocuments', 'action' => 'index'), array('escape' => false)); ?></li>

						<li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Capture Documents'), array('controller' => 'CounsilorDocuments', 'action' => 'add'), array('escape' => false)); ?></li>

						<?php endif?>

						<?php if (AuthComponent::user()['user_type_id'] == 9):?>
						<li style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Council Documents'), array('controller' => 'CounsilorDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
						<?php endif?>

						<?php if($logged_user['id'] == 51 || $logged_user['id'] == 245):?>
						<li style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('MAYCO Documents'), array('controller' => 'MaycoDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
						<?php endif?>

						<?php if($logged_user['id'] == 153):?>
						<li  style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Fault list'), array('controller' => 'Faults', 'action' => 'index'), array('escape' => false)); ?></li>
						<?php endif?>

						<?php if($userSession['user_type_id'] == 27):?>
						<li style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('MAYCO Documents'), array('controller' => 'MaycoDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
						<?php endif?>
					</ul>

				</div><!-- end body -->
			</div><!-- end panel -->
		</div><!-- end actions -->
	</div><!-- end col md 3 -->


	<div class="col-md-9">

<div class="form-vertical" style="margin-top: -10px;">
    <style>
        .btn-info {
            width: 60%;
            text-align: left;
        }
        .form-control {
            width: 40%;
        }
        label {
            width: 20%;
            float: left;
        }
    </style>
			<?php echo $this->Flash->render(); ?>

<?php echo $this->Form->create('Document', ['enctype' => 'multipart/form-data']); ?>
	<fieldset>
		<legend><?php echo __('Add Document for signing'); ?></legend>
	<?php
	    echo "<p class='btn btn-info'>Department<p/>";
		echo $this->Form->input('department_id', ['label' => __('Document from which Directories'), 'class' => 'form-control']);
		echo "<br style='clear:both' />";
		echo "<br /><p class='btn btn-info'>Contact Details<p/>";
        echo "<br style='clear:both' />";
		echo $this->Form->input('fname', array('label' => __('First Name'), 'class' => 'form-control'));
        echo "<br style='clear:both' />";
		echo $this->Form->input('sname', array('label' => __('Van'), 'class' => 'form-control'));
        echo "<br style='clear:both' />";
		echo $this->Form->input('email', ['required' => 'required', 'class' => 'form-control']);
        echo "<br style='clear:both' />";
		echo $this->Form->input('cellnumber', ['required' => 'required', 'class' => 'form-control']);
        echo "<br style='clear:both' />";
		echo "<br /><p class='btn btn-info'>Document Details<p/>";
        echo "<br style='clear:both' />";
		echo $this->Form->input('name', array('label' => 'Document type', 'class' => 'form-control'));
        echo "<br style='clear:both' />";
        $options = ['' => '- Select -', 'high' => 'Urgent', 'normal' => 'Normal', 'low' => 'Low'];
		echo $this->Form->input('priority', array('label' => 'Document urgency', 'type' => 'select', 'options' => $options, 'class' => 'form-control'));
        echo "<br style='clear:both' />";
        echo "<br /><p class='btn btn-info'>Upload the document *</p>";
        echo "<br style='clear:both' />";echo "<br style='clear:both' />";
		echo $this->Form->input('compiled_document.', array('label' => 'Upload here', 'type' => 'file', 'multiple' => 'multiple', 'required' => 'required', 'class' => 'form-control'));
        echo "<br style='clear:both' />";
		echo $this->Form->input('document_date', array('label' => 'Document Date <br />(<small>YYYY-mm-dd</small>)', 'class' => 'form-control datepicker', 'type' => 'text'));

	?>
	</fieldset>
	<br />
<?php echo $this->Form->end(__('Send Document'), ['class' => 'btn btn-default']); ?>
	<br />
	<br />
	<br />
</div>

	</div>
<script>
    // When the document is ready
    $(document).ready(function () {
        $('#DocumentDocumentDate').datepicker({
            format: "yyyy-mm-dd"
        });

    });
</script>
