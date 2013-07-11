<div class="mediaDirectories form">
<?php echo $this->Form->create('MediaDirectory'); ?>
	<fieldset>
		<legend><?php echo __('Add Media Directory'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Media Directories'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Media Directories'), array('controller' => 'media_directories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Media Directory'), array('controller' => 'media_directories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Media'), array('controller' => 'media', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Child Media'), array('controller' => 'media', 'action' => 'add')); ?> </li>
	</ul>
</div>
