<div class="contentTypes index">
	<h2><?php echo __('Content Types'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('content_template_id'); ?></th>
			<th><?php echo $this->Paginator->sort('parent_content_type_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($contentTypes as $contentType): ?>
	<tr>
		<td><?php echo h($contentType['ContentType']['id']); ?>&nbsp;</td>
		<td><?php echo h($contentType['ContentType']['name']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($contentType['ContentTemplate']['name'], array('controller' => 'content_templates', 'action' => 'view', $contentType['ContentTemplate']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($contentType['ParentContentType']['name'], array('controller' => 'content_types', 'action' => 'view', $contentType['ParentContentType']['id'])); ?>
		</td>
		<td><?php echo h($contentType['ContentType']['created']); ?>&nbsp;</td>
		<td><?php echo h($contentType['ContentType']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $contentType['ContentType']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $contentType['ContentType']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $contentType['ContentType']['id']), null, __('Are you sure you want to delete # %s?', $contentType['ContentType']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Content Type'), array('action' => 'add')); ?></li>
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
