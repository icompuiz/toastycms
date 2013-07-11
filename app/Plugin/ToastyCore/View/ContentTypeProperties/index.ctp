<div class="contentTypeProperties index">
	<h2><?php echo __('Content Type Properties'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('content_type_property_skel_id'); ?></th>
			<th><?php echo $this->Paginator->sort('value'); ?></th>
			<th><?php echo $this->Paginator->sort('content_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($contentTypeProperties as $contentTypeProperty): ?>
	<tr>
		<td><?php echo h($contentTypeProperty['ContentTypeProperty']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($contentTypeProperty['ContentTypePropertySkel']['name'], array('controller' => 'content_type_property_skels', 'action' => 'view', $contentTypeProperty['ContentTypePropertySkel']['id'])); ?>
		</td>
		<td><?php echo h($contentTypeProperty['ContentTypeProperty']['value']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($contentTypeProperty['Content']['name'], array('controller' => 'contents', 'action' => 'view', $contentTypeProperty['Content']['id'])); ?>
		</td>
		<td><?php echo h($contentTypeProperty['ContentTypeProperty']['created']); ?>&nbsp;</td>
		<td><?php echo h($contentTypeProperty['ContentTypeProperty']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $contentTypeProperty['ContentTypeProperty']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $contentTypeProperty['ContentTypeProperty']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $contentTypeProperty['ContentTypeProperty']['id']), null, __('Are you sure you want to delete # %s?', $contentTypeProperty['ContentTypeProperty']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Content Type Property'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Content Type Property Skels'), array('controller' => 'content_type_property_skels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Type Property Skel'), array('controller' => 'content_type_property_skels', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents'), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content'), array('controller' => 'contents', 'action' => 'add')); ?> </li>
	</ul>
</div>
