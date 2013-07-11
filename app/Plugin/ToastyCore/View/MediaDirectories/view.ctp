<div class="mediaDirectories view">
<h2><?php  echo __('Media Directory'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($mediaDirectory['MediaDirectory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parent Media Directory'); ?></dt>
		<dd>
			<?php echo $this->Html->link($mediaDirectory['ParentMediaDirectory']['name'], array('controller' => 'media_directories', 'action' => 'view', $mediaDirectory['ParentMediaDirectory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($mediaDirectory['MediaDirectory']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('System Path'); ?></dt>
		<dd>
			<?php echo h($mediaDirectory['MediaDirectory']['system_path']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($mediaDirectory['MediaDirectory']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($mediaDirectory['MediaDirectory']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($mediaDirectory['MediaDirectory']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Media Directory'), array('action' => 'edit', $mediaDirectory['MediaDirectory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Media Directory'), array('action' => 'delete', $mediaDirectory['MediaDirectory']['id']), null, __('Are you sure you want to delete # %s?', $mediaDirectory['MediaDirectory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Media Directories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media Directory'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Media Directories'), array('controller' => 'media_directories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Media Directory'), array('controller' => 'media_directories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Media'), array('controller' => 'media', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Child Media'), array('controller' => 'media', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Media'); ?></h3>
	<?php if (!empty($mediaDirectory['ChildMedia'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Media Directory Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('System Path'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($mediaDirectory['ChildMedia'] as $childMedia): ?>
		<tr>
			<td><?php echo $childMedia['id']; ?></td>
			<td><?php echo $childMedia['media_directory_id']; ?></td>
			<td><?php echo $childMedia['name']; ?></td>
			<td><?php echo $childMedia['system_path']; ?></td>
			<td><?php echo $childMedia['type']; ?></td>
			<td><?php echo $childMedia['created']; ?></td>
			<td><?php echo $childMedia['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'media', 'action' => 'view', $childMedia['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'media', 'action' => 'edit', $childMedia['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'media', 'action' => 'delete', $childMedia['id']), null, __('Are you sure you want to delete # %s?', $childMedia['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Child Media'), array('controller' => 'media', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Media Directories'); ?></h3>
	<?php if (!empty($mediaDirectory['ChildMediaDirectory'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Media Directory Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('System Path'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($mediaDirectory['ChildMediaDirectory'] as $childMediaDirectory): ?>
		<tr>
			<td><?php echo $childMediaDirectory['id']; ?></td>
			<td><?php echo $childMediaDirectory['media_directory_id']; ?></td>
			<td><?php echo $childMediaDirectory['name']; ?></td>
			<td><?php echo $childMediaDirectory['system_path']; ?></td>
			<td><?php echo $childMediaDirectory['type']; ?></td>
			<td><?php echo $childMediaDirectory['created']; ?></td>
			<td><?php echo $childMediaDirectory['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'media_directories', 'action' => 'view', $childMediaDirectory['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'media_directories', 'action' => 'edit', $childMediaDirectory['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'media_directories', 'action' => 'delete', $childMediaDirectory['id']), null, __('Are you sure you want to delete # %s?', $childMediaDirectory['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Child Media Directory'), array('controller' => 'media_directories', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
