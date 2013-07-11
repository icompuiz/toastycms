<div class="contents view">
<h2><?php  echo __('Content'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($content['Content']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($content['Content']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($content['User']['id'], array('controller' => 'users', 'action' => 'view', $content['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parent Content'); ?></dt>
		<dd>
			<?php echo $this->Html->link($content['ParentContent']['name'], array('controller' => 'contents', 'action' => 'view', $content['ParentContent']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content Type'); ?></dt>
		<dd>
			<?php echo $this->Html->link($content['ContentType']['name'], array('controller' => 'content_types', 'action' => 'view', $content['ContentType']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($content['Content']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($content['Content']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Content'), array('action' => 'edit', $content['Content']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Content'), array('action' => 'delete', $content['Content']['id']), null, __('Are you sure you want to delete # %s?', $content['Content']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents'), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Content'), array('controller' => 'contents', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Types'), array('controller' => 'content_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Type'), array('controller' => 'content_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Type Properties'), array('controller' => 'content_type_properties', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Type Property'), array('controller' => 'content_type_properties', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Content Type Properties'); ?></h3>
	<?php if (!empty($content['ContentTypeProperties'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Content Type Property Skel Id'); ?></th>
		<th><?php echo __('Value'); ?></th>
		<th><?php echo __('Content Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($content['ContentTypeProperties'] as $contentTypeProperty): ?>
		<tr>
			<td><?php echo $contentTypeProperty['id']; ?></td>
			<td><?php echo $contentTypeProperty['content_type_property_skel_id']; ?></td>
			<td><?php echo $contentTypeProperty['value']; ?></td>
			<td><?php echo $contentTypeProperty['content_id']; ?></td>
			<td><?php echo $contentTypeProperty['created']; ?></td>
			<td><?php echo $contentTypeProperty['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'content_type_properties', 'action' => 'view', $contentTypeProperty['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'content_type_properties', 'action' => 'edit', $contentTypeProperty['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'content_type_properties', 'action' => 'delete', $contentTypeProperty['id']), null, __('Are you sure you want to delete # %s?', $contentTypeProperty['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Content Type Property'), array('controller' => 'content_type_properties', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
