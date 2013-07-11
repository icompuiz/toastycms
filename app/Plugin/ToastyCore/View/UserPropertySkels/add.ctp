<div class="userPropertySkels form">
<?php echo $this->Form->create('UserPropertySkel'); ?>
	<fieldset>
		<legend><?php echo __('Add User Property Skel'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('group_id');
		echo $this->Form->input('input_format_id');
		echo $this->Form->input('output_format_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List User Property Skels'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Input Formats'), array('controller' => 'input_formats', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Input Format'), array('controller' => 'input_formats', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Output Formats'), array('controller' => 'output_formats', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Output Format'), array('controller' => 'output_formats', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Properties'), array('controller' => 'user_properties', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Property'), array('controller' => 'user_properties', 'action' => 'add')); ?> </li>
	</ul>
</div>
