<?php

	$this->extend('Common/settings_base');

	$this->start('management-right');


?>

	<div id="settings-navigator" class="navigator content-navigator tabbable">

		<ul class="nav nav-tabs">
	        <li class="active"><a href="#settings-tab" data-toggle="tab">Settings</a></li>
	    </ul>

		<?php
		    echo $this->Form->create('ToastyCore.Setting', array(
		        'url' => array('controller' => 'settings', 'action' => 'add', 'management' => true),
		        'class' => "setting-form"
		    ));
	    ?>
	    <div class="tab-content">
	    	<div class="tab-pane well active" id="settings-tab">

	    		<div class="btn-toolbar">
	                <div class="btn-group">
	                    <a id="add-setting-btn" class="btn">Add Setting</a>
	                </div>
	            </div>

	            <hr>

	            <div class="row">

					<div class="span3 setting-name setting-header">
						Name
					</div>
					<div class="span3 setting-value setting-header">
						Value
					</div>
					<div class="span1 setting-actions setting-header">
						Actions
					</div>
					<div class="clearfix"></div>

				</div>
	            <hr>
	            <?php
		    		foreach ($settings as $setting) {

		    			$is_root = $setting['Setting']['type'] == 'root';
		    			?>

		    				<div class="row setting">

		    					<div class="span3 setting-name">
		    						<?=$setting['Setting']['name']?>
		    					</div>
		    					<div class="span3 setting-value">
		    						<?=$setting['Setting']['value']?>
		    					</div>

		    					<div class="btn-group span1 setting-actions">
								    <a setting-type="<?=$setting['Setting']['type']?>" setting="<?=$setting['Setting']['id']?>" class="btn edit-setting">Edit</a>
								    <?php if (!$is_root) { ?>
								    	<a setting="<?=$setting['Setting']['id']?>" class="btn delete-setting">&times;</a>
								    <?php } ?>
							    </div>
		    					<div class="clearfix"></div>

		    				</div>
	            			<hr>

		    			<?php

		    		}
	    		?>

	    	</div>
		</div>

		<div id="add-setting-modal" class="modal hide fade">
	        <div class="modal-header">
	            <a type="button" class="close cancel" data-dismiss="modal" aria-hidden="true">&times;</a>
	            <h3>Add Setting</h3>
	        </div>
	        <div class="modal-body">

	            <?php
	            echo $this->Form->input("Setting.name", array('id' => 'setting_name'));
	            echo $this->Form->input("Setting.value", array('id' => 'setting_value'));
	            ?>

	        </div>
	        <div class="modal-footer">
	            <a href="#" class="cancel btn" data-dismiss="modal">Cancel</a>
	            <a href="#" class="save btn btn-primary">Save Setting</a>
	        </div>
	    </div>
		<?php
	    	echo $this->Form->end();
	    ?>

		
	</div>

<?php

	$this->end();


$this->start('script');

echo $this->Html->script('ToastyCore.toastyCore');
echo $this->Html->script('ToastyCore.code_behind/setting');

echo $this->Html->scriptBlock("  
    init_modal();
");



$this->end();

$this->start('sidebar-list-templates');
?>

<script id="id-form-element-template" type="text/x-handlebars-template">
    <input id="ManagementSettingId" type="hidden" name="data[Setting][id]" value="{{id}}"/>
</script>

<script id="edit-url-template" type="text/x-handlebars-template">
    <?=Router::url(array('controller' => 'settings', 'action' => 'edit')) . DS . '{{id}}'?>
</script>

<script id="delete-url-template" type="text/x-handlebars-template">
    <?=Router::url(array('controller' => 'settings', 'action' => 'delete')) . DS . '{{id}}'?>
</script>

<?php
$this->end();
?>