<?php
	$this->start('management-flash');
		echo $this->Session->flash('flash', array('element' => 'ToastyCore.login_flash'));
		echo $this->Session->flash('auth', array('element' => 'ToastyCore.login_flash'));
	$this->end();
	$this->start("management-right")
?>
<div class="users form">
<?php echo $this->Form->create('ToastyCore.User'); ?>
    <fieldset>
        <legend><?php echo __('Please enter your username and password'); ?></legend>
        <?php echo $this->Form->input('username');
        echo $this->Form->input('password');
    ?>
    </fieldset>
	<div class="input submit">
		<?php
			echo $this->Html->link(__('Login'), "#", array('class' => 'btn submitLogin pull-right'));
		?>
	</div>

<?php 

	echo $this->Form->end(); 
	
?>
</div>

<?php
$this->end();

$this->start('script');

echo $this->Html->scriptBlock('

	$(".submitLogin").click(function() {
		$("#UserManagementLoginForm").submit();
	});

	$("#UserManagementLoginForm input").keyup(function(e) {

		if (e.keyCode === 13) {
			$("#UserManagementLoginForm").submit();

		}

	});

');

$this->end();

?>