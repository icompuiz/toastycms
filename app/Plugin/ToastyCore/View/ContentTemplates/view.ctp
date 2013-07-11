<div class="contentTemplates view">
<h2><?php  echo __('Content Template'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($contentTemplate['ContentTemplate']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parent Content Template'); ?></dt>
		<dd>
			<?php echo $this->Html->link($contentTemplate['ParentContentTemplate']['name'], array('controller' => 'content_templates', 'action' => 'view', $contentTemplate['ParentContentTemplate']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($contentTemplate['ContentTemplate']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('System Path'); ?></dt>
		<dd>
			<?php echo h($contentTemplate['ContentTemplate']['system_path']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($contentTemplate['ContentTemplate']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($contentTemplate['ContentTemplate']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Content Template'), array('action' => 'edit', $contentTemplate['ContentTemplate']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Content Template'), array('action' => 'delete', $contentTemplate['ContentTemplate']['id']), null, __('Are you sure you want to delete # %s?', $contentTemplate['ContentTemplate']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Templates'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Template'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Templates'), array('controller' => 'content_templates', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Content Template'), array('controller' => 'content_templates', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Types'), array('controller' => 'content_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Type'), array('controller' => 'content_types', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Content Types'); ?></h3>
	<?php if (!empty($contentTemplate['ContentType'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Content Template Id'); ?></th>
		<th><?php echo __('Parent Content Type Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($contentTemplate['ContentType'] as $contentType): ?>
		<tr>
			<td><?php echo $contentType['id']; ?></td>
			<td><?php echo $contentType['name']; ?></td>
			<td><?php echo $contentType['content_template_id']; ?></td>
			<td><?php echo $contentType['parent_content_type_id']; ?></td>
			<td><?php echo $contentType['created']; ?></td>
			<td><?php echo $contentType['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'content_types', 'action' => 'view', $contentType['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'content_types', 'action' => 'edit', $contentType['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'content_types', 'action' => 'delete', $contentType['id']), null, __('Are you sure you want to delete # %s?', $contentType['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Content Type'), array('controller' => 'content_types', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
