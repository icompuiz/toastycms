<div class="contentTypePropertySkels form">
<?php echo $this->Form->create('ContentTypePropertySkel'); ?>
	<fieldset>
		<legend><?php echo __('Edit Content Type Property Skel'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('content_type_id');
		echo $this->Form->input('input_format_id');
		echo $this->Form->input('output_format_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ContentTypePropertySkel.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('ContentTypePropertySkel.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Content Type Property Skels'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Content Types'), array('controller' => 'content_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Type'), array('controller' => 'content_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Input Formats'), array('controller' => 'input_formats', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Input Format'), array('controller' => 'input_formats', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Output Formats'), array('controller' => 'output_formats', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Output Format'), array('controller' => 'output_formats', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Type Properties'), array('controller' => 'content_type_properties', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Type Property'), array('controller' => 'content_type_properties', 'action' => 'add')); ?> </li>
	</ul>
</div>
