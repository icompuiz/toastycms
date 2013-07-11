<div class="outputFormats form">
<?php echo $this->Form->create('OutputFormat'); ?>
	<fieldset>
		<legend><?php echo __('Edit Output Format'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('system_path');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('OutputFormat.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('OutputFormat.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Output Formats'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Content Type Property Skels'), array('controller' => 'content_type_property_skels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Type Property Skel'), array('controller' => 'content_type_property_skels', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Property Skels'), array('controller' => 'user_property_skels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Property Skel'), array('controller' => 'user_property_skels', 'action' => 'add')); ?> </li>
	</ul>
</div>
