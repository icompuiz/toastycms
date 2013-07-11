<div class="media view">
<h2><?php  echo __('Media'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($media['Media']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Media Directory'); ?></dt>
		<dd>
			<?php echo $this->Html->link($media['MediaDirectory']['name'], array('controller' => 'media_directories', 'action' => 'view', $media['MediaDirectory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($media['Media']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('System Path'); ?></dt>
		<dd>
			<?php echo h($media['Media']['system_path']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($media['Media']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($media['Media']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($media['Media']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Media'), array('action' => 'edit', $media['Media']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Media'), array('action' => 'delete', $media['Media']['id']), null, __('Are you sure you want to delete # %s?', $media['Media']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Media'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Media Directories'), array('controller' => 'media_directories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media Directory'), array('controller' => 'media_directories', 'action' => 'add')); ?> </li>
	</ul>
</div>
