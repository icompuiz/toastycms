<div class="media form">
<?php echo $this->Form->create('Media'); ?>
	<fieldset>
		<legend><?php echo __('Edit Media'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('media_directory_id');
		echo $this->Form->input('name');
		echo $this->Form->input('system_path');
		echo $this->Form->input('type');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Media.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Media.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Media'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Media Directories'), array('controller' => 'media_directories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media Directory'), array('controller' => 'media_directories', 'action' => 'add')); ?> </li>
	</ul>
</div>
