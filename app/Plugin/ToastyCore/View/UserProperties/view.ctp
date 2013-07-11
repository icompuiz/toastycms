<div class="userProperties view">
<h2><?php  echo __('User Property'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($userProperty['UserProperty']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Value'); ?></dt>
		<dd>
			<?php echo h($userProperty['UserProperty']['value']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userProperty['User']['id'], array('controller' => 'users', 'action' => 'view', $userProperty['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Property Skel'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userProperty['UserPropertySkel']['name'], array('controller' => 'user_property_skels', 'action' => 'view', $userProperty['UserPropertySkel']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($userProperty['UserProperty']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($userProperty['UserProperty']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User Property'), array('action' => 'edit', $userProperty['UserProperty']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User Property'), array('action' => 'delete', $userProperty['UserProperty']['id']), null, __('Are you sure you want to delete # %s?', $userProperty['UserProperty']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List User Properties'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Property'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Property Skels'), array('controller' => 'user_property_skels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Property Skel'), array('controller' => 'user_property_skels', 'action' => 'add')); ?> </li>
	</ul>
</div>
