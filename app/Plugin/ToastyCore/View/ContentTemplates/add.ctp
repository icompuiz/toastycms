<div class="contentTemplates form">
<?php echo $this->Form->create('ContentTemplate'); ?>
	<fieldset>
		<legend><?php echo __('Add Content Template'); ?></legend>
	<?php
		echo $this->Form->input('parent_content_template_id');
		echo $this->Form->input('name');
		echo $this->Form->input('system_path');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Content Templates'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Content Templates'), array('controller' => 'content_templates', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Content Template'), array('controller' => 'content_templates', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Types'), array('controller' => 'content_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Type'), array('controller' => 'content_types', 'action' => 'add')); ?> </li>
	</ul>
</div>
