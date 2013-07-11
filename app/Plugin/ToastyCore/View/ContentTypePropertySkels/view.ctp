<div class="contentTypePropertySkels view">
<h2><?php  echo __('Content Type Property Skel'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($contentTypePropertySkel['ContentTypePropertySkel']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($contentTypePropertySkel['ContentTypePropertySkel']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content Type'); ?></dt>
		<dd>
			<?php echo $this->Html->link($contentTypePropertySkel['ContentType']['name'], array('controller' => 'content_types', 'action' => 'view', $contentTypePropertySkel['ContentType']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Input Format'); ?></dt>
		<dd>
			<?php echo $this->Html->link($contentTypePropertySkel['InputFormat']['name'], array('controller' => 'input_formats', 'action' => 'view', $contentTypePropertySkel['InputFormat']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Output Format'); ?></dt>
		<dd>
			<?php echo $this->Html->link($contentTypePropertySkel['OutputFormat']['name'], array('controller' => 'output_formats', 'action' => 'view', $contentTypePropertySkel['OutputFormat']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($contentTypePropertySkel['ContentTypePropertySkel']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($contentTypePropertySkel['ContentTypePropertySkel']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Content Type Property Skel'), array('action' => 'edit', $contentTypePropertySkel['ContentTypePropertySkel']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Content Type Property Skel'), array('action' => 'delete', $contentTypePropertySkel['ContentTypePropertySkel']['id']), null, __('Are you sure you want to delete # %s?', $contentTypePropertySkel['ContentTypePropertySkel']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Type Property Skels'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Type Property Skel'), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php echo __('Related Content Type Properties'); ?></h3>
	<?php if (!empty($contentTypePropertySkel['ContentTypeProperty'])): ?>
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
		foreach ($contentTypePropertySkel['ContentTypeProperty'] as $contentTypeProperty): ?>
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
