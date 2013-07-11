<div class="userPropertySkels view">
<h2><?php  echo __('User Property Skel'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($userPropertySkel['UserPropertySkel']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($userPropertySkel['UserPropertySkel']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userPropertySkel['Group']['name'], array('controller' => 'groups', 'action' => 'view', $userPropertySkel['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Input Format'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userPropertySkel['InputFormat']['name'], array('controller' => 'input_formats', 'action' => 'view', $userPropertySkel['InputFormat']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Output Format'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userPropertySkel['OutputFormat']['name'], array('controller' => 'output_formats', 'action' => 'view', $userPropertySkel['OutputFormat']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($userPropertySkel['UserPropertySkel']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($userPropertySkel['UserPropertySkel']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User Property Skel'), array('action' => 'edit', $userPropertySkel['UserPropertySkel']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User Property Skel'), array('action' => 'delete', $userPropertySkel['UserPropertySkel']['id']), null, __('Are you sure you want to delete # %s?', $userPropertySkel['UserPropertySkel']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List User Property Skels'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Property Skel'), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php echo __('Related User Properties'); ?></h3>
	<?php if (!empty($userPropertySkel['UserProperty'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Value'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('User Property Skel Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($userPropertySkel['UserProperty'] as $userProperty): ?>
		<tr>
			<td><?php echo $userProperty['id']; ?></td>
			<td><?php echo $userProperty['value']; ?></td>
			<td><?php echo $userProperty['user_id']; ?></td>
			<td><?php echo $userProperty['user_property_skel_id']; ?></td>
			<td><?php echo $userProperty['created']; ?></td>
			<td><?php echo $userProperty['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'user_properties', 'action' => 'view', $userProperty['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'user_properties', 'action' => 'edit', $userProperty['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'user_properties', 'action' => 'delete', $userProperty['id']), null, __('Are you sure you want to delete # %s?', $userProperty['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New User Property'), array('controller' => 'user_properties', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
