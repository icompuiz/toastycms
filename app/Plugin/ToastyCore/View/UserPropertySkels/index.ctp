<div class="userPropertySkels index">
	<h2><?php echo __('User Property Skels'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('group_id'); ?></th>
			<th><?php echo $this->Paginator->sort('input_format_id'); ?></th>
			<th><?php echo $this->Paginator->sort('output_format_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($userPropertySkels as $userPropertySkel): ?>
	<tr>
		<td><?php echo h($userPropertySkel['UserPropertySkel']['id']); ?>&nbsp;</td>
		<td><?php echo h($userPropertySkel['UserPropertySkel']['name']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($userPropertySkel['Group']['name'], array('controller' => 'groups', 'action' => 'view', $userPropertySkel['Group']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($userPropertySkel['InputFormat']['name'], array('controller' => 'input_formats', 'action' => 'view', $userPropertySkel['InputFormat']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($userPropertySkel['OutputFormat']['name'], array('controller' => 'output_formats', 'action' => 'view', $userPropertySkel['OutputFormat']['id'])); ?>
		</td>
		<td><?php echo h($userPropertySkel['UserPropertySkel']['created']); ?>&nbsp;</td>
		<td><?php echo h($userPropertySkel['UserPropertySkel']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $userPropertySkel['UserPropertySkel']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $userPropertySkel['UserPropertySkel']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $userPropertySkel['UserPropertySkel']['id']), null, __('Are you sure you want to delete # %s?', $userPropertySkel['UserPropertySkel']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New User Property Skel'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Input Formats'), array('controller' => 'input_formats', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Input Format'), array('controller' => 'input_formats', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Output Formats'), array('controller' => 'output_formats', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Output Format'), array('controller' => 'output_formats', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Properties'), array('controller' => 'user_properties', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Property'), array('controller' => 'user_properties', 'action' => 'add')); ?> </li>
	</ul>
</div>
