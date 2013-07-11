<div class="contentTypes view">
<h2><?php  echo __('Content Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($contentType['ContentType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($contentType['ContentType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content Template'); ?></dt>
		<dd>
			<?php echo $this->Html->link($contentType['ContentTemplate']['name'], array('controller' => 'content_templates', 'action' => 'view', $contentType['ContentTemplate']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parent Content Type'); ?></dt>
		<dd>
			<?php echo $this->Html->link($contentType['ParentContentType']['name'], array('controller' => 'content_types', 'action' => 'view', $contentType['ParentContentType']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($contentType['ContentType']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($contentType['ContentType']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Content Type'), array('action' => 'edit', $contentType['ContentType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Content Type'), array('action' => 'delete', $contentType['ContentType']['id']), null, __('Are you sure you want to delete # %s?', $contentType['ContentType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Type'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Templates'), array('controller' => 'content_templates', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Template'), array('controller' => 'content_templates', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Types'), array('controller' => 'content_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Content Type'), array('controller' => 'content_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Type Property Skels'), array('controller' => 'content_type_property_skels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Type Property Skel'), array('controller' => 'content_type_property_skels', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents'), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content'), array('controller' => 'contents', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Content Type Property Skels'); ?></h3>
	<?php if (!empty($contentType['ContentTypePropertySkel'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Content Type Id'); ?></th>
		<th><?php echo __('Input Format Id'); ?></th>
		<th><?php echo __('Output Format Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($contentType['ContentTypePropertySkel'] as $contentTypePropertySkel): ?>
		<tr>
			<td><?php echo $contentTypePropertySkel['id']; ?></td>
			<td><?php echo $contentTypePropertySkel['name']; ?></td>
			<td><?php echo $contentTypePropertySkel['content_type_id']; ?></td>
			<td><?php echo $contentTypePropertySkel['input_format_id']; ?></td>
			<td><?php echo $contentTypePropertySkel['output_format_id']; ?></td>
			<td><?php echo $contentTypePropertySkel['created']; ?></td>
			<td><?php echo $contentTypePropertySkel['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'content_type_property_skels', 'action' => 'view', $contentTypePropertySkel['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'content_type_property_skels', 'action' => 'edit', $contentTypePropertySkel['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'content_type_property_skels', 'action' => 'delete', $contentTypePropertySkel['id']), null, __('Are you sure you want to delete # %s?', $contentTypePropertySkel['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Content Type Property Skel'), array('controller' => 'content_type_property_skels', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Contents'); ?></h3>
	<?php if (!empty($contentType['Content'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Parent Content Id'); ?></th>
		<th><?php echo __('Content Type Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($contentType['Content'] as $content): ?>
		<tr>
			<td><?php echo $content['id']; ?></td>
			<td><?php echo $content['name']; ?></td>
			<td><?php echo $content['user_id']; ?></td>
			<td><?php echo $content['parent_content_id']; ?></td>
			<td><?php echo $content['content_type_id']; ?></td>
			<td><?php echo $content['created']; ?></td>
			<td><?php echo $content['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'contents', 'action' => 'view', $content['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'contents', 'action' => 'edit', $content['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'contents', 'action' => 'delete', $content['id']), null, __('Are you sure you want to delete # %s?', $content['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Content'), array('controller' => 'contents', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
