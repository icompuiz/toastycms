<div class="contentTypeProperties view">
<h2><?php  echo __('Content Type Property'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($contentTypeProperty['ContentTypeProperty']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content Type Property Skel'); ?></dt>
		<dd>
			<?php echo $this->Html->link($contentTypeProperty['ContentTypePropertySkel']['name'], array('controller' => 'content_type_property_skels', 'action' => 'view', $contentTypeProperty['ContentTypePropertySkel']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Value'); ?></dt>
		<dd>
			<?php echo h($contentTypeProperty['ContentTypeProperty']['value']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content'); ?></dt>
		<dd>
			<?php echo $this->Html->link($contentTypeProperty['Content']['name'], array('controller' => 'contents', 'action' => 'view', $contentTypeProperty['Content']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($contentTypeProperty['ContentTypeProperty']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($contentTypeProperty['ContentTypeProperty']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Content Type Property'), array('action' => 'edit', $contentTypeProperty['ContentTypeProperty']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Content Type Property'), array('action' => 'delete', $contentTypeProperty['ContentTypeProperty']['id']), null, __('Are you sure you want to delete # %s?', $contentTypeProperty['ContentTypeProperty']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Type Properties'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Type Property'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Type Property Skels'), array('controller' => 'content_type_property_skels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Type Property Skel'), array('controller' => 'content_type_property_skels', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents'), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content'), array('controller' => 'contents', 'action' => 'add')); ?> </li>
	</ul>
</div>
