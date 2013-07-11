<div class="mediaDirectories index">
	<h2><?php echo __('Media Directories'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('media_directory_id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('system_path'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($mediaDirectories as $mediaDirectory): ?>
	<tr>
		<td><?php echo h($mediaDirectory['MediaDirectory']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($mediaDirectory['ParentMediaDirectory']['name'], array('controller' => 'media_directories', 'action' => 'view', $mediaDirectory['ParentMediaDirectory']['id'])); ?>
		</td>
		<td><?php echo h($mediaDirectory['MediaDirectory']['name']); ?>&nbsp;</td>
		<td><?php echo h($mediaDirectory['MediaDirectory']['system_path']); ?>&nbsp;</td>
		<td><?php echo h($mediaDirectory['MediaDirectory']['type']); ?>&nbsp;</td>
		<td><?php echo h($mediaDirectory['MediaDirectory']['created']); ?>&nbsp;</td>
		<td><?php echo h($mediaDirectory['MediaDirectory']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $mediaDirectory['MediaDirectory']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $mediaDirectory['MediaDirectory']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $mediaDirectory['MediaDirectory']['id']), null, __('Are you sure you want to delete # %s?', $mediaDirectory['MediaDirectory']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Media Directory'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Media Directories'), array('controller' => 'media_directories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Media Directory'), array('controller' => 'media_directories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Media'), array('controller' => 'media', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Child Media'), array('controller' => 'media', 'action' => 'add')); ?> </li>
	</ul>
</div>
