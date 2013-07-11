<div class="contentTypePropertySkels index">
	<h2><?php echo __('Content Type Property Skels'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('content_type_id'); ?></th>
			<th><?php echo $this->Paginator->sort('input_format_id'); ?></th>
			<th><?php echo $this->Paginator->sort('output_format_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($contentTypePropertySkels as $contentTypePropertySkel): ?>
	<tr>
		<td><?php echo h($contentTypePropertySkel['ContentTypePropertySkel']['id']); ?>&nbsp;</td>
		<td><?php echo h($contentTypePropertySkel['ContentTypePropertySkel']['name']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($contentTypePropertySkel['ContentType']['name'], array('controller' => 'content_types', 'action' => 'view', $contentTypePropertySkel['ContentType']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($contentTypePropertySkel['InputFormat']['name'], array('controller' => 'input_formats', 'action' => 'view', $contentTypePropertySkel['InputFormat']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($contentTypePropertySkel['OutputFormat']['name'], array('controller' => 'output_formats', 'action' => 'view', $contentTypePropertySkel['OutputFormat']['id'])); ?>
		</td>
		<td><?php echo h($contentTypePropertySkel['ContentTypePropertySkel']['created']); ?>&nbsp;</td>
		<td><?php echo h($contentTypePropertySkel['ContentTypePropertySkel']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $contentTypePropertySkel['ContentTypePropertySkel']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $contentTypePropertySkel['ContentTypePropertySkel']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $contentTypePropertySkel['ContentTypePropertySkel']['id']), null, __('Are you sure you want to delete # %s?', $contentTypePropertySkel['ContentTypePropertySkel']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Content Type Property Skel'), array('action' => 'add')); ?></li>
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
