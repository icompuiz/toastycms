<div class="userProperties index">
	<h2><?php echo __('User Properties'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('value'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_property_skel_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($userProperties as $userProperty): ?>
	<tr>
		<td><?php echo h($userProperty['UserProperty']['id']); ?>&nbsp;</td>
		<td><?php echo h($userProperty['UserProperty']['value']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($userProperty['User']['id'], array('controller' => 'users', 'action' => 'view', $userProperty['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($userProperty['UserPropertySkel']['name'], array('controller' => 'user_property_skels', 'action' => 'view', $userProperty['UserPropertySkel']['id'])); ?>
		</td>
		<td><?php echo h($userProperty['UserProperty']['created']); ?>&nbsp;</td>
		<td><?php echo h($userProperty['UserProperty']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $userProperty['UserProperty']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $userProperty['UserProperty']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $userProperty['UserProperty']['id']), null, __('Are you sure you want to delete # %s?', $userProperty['UserProperty']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New User Property'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Property Skels'), array('controller' => 'user_property_skels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Property Skel'), array('controller' => 'user_property_skels', 'action' => 'add')); ?> </li>
	</ul>
</div>
