<div class="contentTemplates index">
	<h2><?php echo __('Content Templates'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('parent_content_template_id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('system_path'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($contentTemplates as $contentTemplate): ?>
	<tr>
		<td><?php echo h($contentTemplate['ContentTemplate']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($contentTemplate['ParentContentTemplate']['name'], array('controller' => 'content_templates', 'action' => 'view', $contentTemplate['ParentContentTemplate']['id'])); ?>
		</td>
		<td><?php echo h($contentTemplate['ContentTemplate']['name']); ?>&nbsp;</td>
		<td><?php echo h($contentTemplate['ContentTemplate']['system_path']); ?>&nbsp;</td>
		<td><?php echo h($contentTemplate['ContentTemplate']['created']); ?>&nbsp;</td>
		<td><?php echo h($contentTemplate['ContentTemplate']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $contentTemplate['ContentTemplate']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $contentTemplate['ContentTemplate']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $contentTemplate['ContentTemplate']['id']), null, __('Are you sure you want to delete # %s?', $contentTemplate['ContentTemplate']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Content Template'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Content Templates'), array('controller' => 'content_templates', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Content Template'), array('controller' => 'content_templates', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Types'), array('controller' => 'content_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Type'), array('controller' => 'content_types', 'action' => 'add')); ?> </li>
	</ul>
</div>
