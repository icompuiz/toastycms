<?php
	$this->start('management-flash');
	echo $this->Session->flash('flash', array('element' => 'ToastyCore.content_error'));
    echo $this->Form->error('Setting.name', null, array('wrap' => 'div', 'class' => 'alert'));
	$this->end();
	$this->start('management-left');
	$accountsLink = $this->Html->link("Accounts", array('controller' => 'accounts', 'action' => 'index', 'management' => true));

?>
	<ul class="nav nav-pills nav-stacked">
	  <li class="active">
	    <a href="#">Settings</a>
	  </li>
	  <li><?=$accountsLink?></li>
	  <li class="disabled"><a href="#">Permissions (coming soon)</a></li>
	</ul>
<?php
	$this->end();
?>

