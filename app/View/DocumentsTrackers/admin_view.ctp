<div class="documentsTrackers view">
<h2><?php echo __('Documents Tracker'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($documentsTracker['DocumentsTracker']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Document'); ?></dt>
		<dd>
			<?php echo $this->Html->link($documentsTracker['Document']['name'], array('controller' => 'documents', 'action' => 'view', $documentsTracker['Document']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo $this->Html->link($documentsTracker['Status']['name'], array('controller' => 'statuses', 'action' => 'view', $documentsTracker['Status']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Level'); ?></dt>
		<dd>
			<?php echo $this->Html->link($documentsTracker['Level']['name'], array('controller' => 'levels', 'action' => 'view', $documentsTracker['Level']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Updated By'); ?></dt>
		<dd>
			<?php echo h($documentsTracker['DocumentsTracker']['updated_by']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Brought By'); ?></dt>
		<dd>
			<?php echo h($documentsTracker['DocumentsTracker']['brought_by']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Brought'); ?></dt>
		<dd>
			<?php echo h($documentsTracker['DocumentsTracker']['date_brought']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Updated'); ?></dt>
		<dd>
			<?php echo h($documentsTracker['DocumentsTracker']['date_updated']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Documents Tracker'), array('action' => 'edit', $documentsTracker['DocumentsTracker']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Documents Tracker'), array('action' => 'delete', $documentsTracker['DocumentsTracker']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $documentsTracker['DocumentsTracker']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Documents Trackers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Documents Tracker'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Documents'), array('controller' => 'documents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Document'), array('controller' => 'documents', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Statuses'), array('controller' => 'statuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Status'), array('controller' => 'statuses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Levels'), array('controller' => 'levels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Level'), array('controller' => 'levels', 'action' => 'add')); ?> </li>
	</ul>
</div>
