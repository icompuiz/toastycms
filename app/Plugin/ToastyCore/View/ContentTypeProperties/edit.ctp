<div class="contentTypeProperties form">
<?php echo $this->Form->create('ContentTypeProperty'); ?>
	<fieldset>
		<legend><?php echo __('Edit Content Type Property'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('content_type_property_skel_id');
		echo $this->Form->input('value');
		echo $this->Form->input('content_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ContentTypeProperty.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('ContentTypeProperty.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Content Type Properties'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Content Type Property Skels'), array('controller' => 'content_type_property_skels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Type Property Skel'), array('controller' => 'content_type_property_skels', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents'), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content'), array('controller' => 'contents', 'action' => 'add')); ?> </li>
	</ul>
</div>
