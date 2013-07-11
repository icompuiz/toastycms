<div class="outputFormats view">
<h2><?php  echo __('Output Format'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($outputFormat['OutputFormat']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($outputFormat['OutputFormat']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('System Path'); ?></dt>
		<dd>
			<?php echo h($outputFormat['OutputFormat']['system_path']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($outputFormat['OutputFormat']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($outputFormat['OutputFormat']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Output Format'), array('action' => 'edit', $outputFormat['OutputFormat']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Output Format'), array('action' => 'delete', $outputFormat['OutputFormat']['id']), null, __('Are you sure you want to delete # %s?', $outputFormat['OutputFormat']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Output Formats'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Output Format'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Type Property Skels'), array('controller' => 'content_type_property_skels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Type Property Skel'), array('controller' => 'content_type_property_skels', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Property Skels'), array('controller' => 'user_property_skels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Property Skel'), array('controller' => 'user_property_skels', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Content Type Property Skels'); ?></h3>
	<?php if (!empty($outputFormat['ContentTypePropertySkel'])): ?>
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
		foreach ($outputFormat['ContentTypePropertySkel'] as $contentTypePropertySkel): ?>
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
	<h3><?php echo __('Related User Property Skels'); ?></h3>
	<?php if (!empty($outputFormat['UserPropertySkel'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Input Format Id'); ?></th>
		<th><?php echo __('Output Format Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($outputFormat['UserPropertySkel'] as $userPropertySkel): ?>
		<tr>
			<td><?php echo $userPropertySkel['id']; ?></td>
			<td><?php echo $userPropertySkel['name']; ?></td>
			<td><?php echo $userPropertySkel['group_id']; ?></td>
			<td><?php echo $userPropertySkel['input_format_id']; ?></td>
			<td><?php echo $userPropertySkel['output_format_id']; ?></td>
			<td><?php echo $userPropertySkel['created']; ?></td>
			<td><?php echo $userPropertySkel['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'user_property_skels', 'action' => 'view', $userPropertySkel['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'user_property_skels', 'action' => 'edit', $userPropertySkel['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'user_property_skels', 'action' => 'delete', $userPropertySkel['id']), null, __('Are you sure you want to delete # %s?', $userPropertySkel['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New User Property Skel'), array('controller' => 'user_property_skels', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
