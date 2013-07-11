<?php
$this->extend('/Common/account_base');
$this->start('management-right');

$is_root = $this->Form->value("Group.type") === "root";
?>

<div id="account-controls" class="btn-toolbar pull-right controls">
    <?php if (!$is_root) { ?>
    <div class="btn-group">
        <button class="btn" id='account-save-button' disabled>Save</button>
        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Group.id'), 'management' => true), array('class' => 'btn'), __('Are you sure you want to delete this group? This action is irreversible.')); ?>
        <?php echo $this->Form->postLink(__('Cancel'), array('action' => 'index', 'cancel', 'management' => true), array('class' => 'btn'), __('Are you sure you want to cancel? Any changes will be lost.')); ?>
    </div>
    <?php } ?>
    <div class="btn-group">
        <?=$this->Html->link('Add User', array('controller' => 'users', 'action' => 'add', $this->Form->value('Group.id')), array('class' => 'btn'))?>
    </div>
</div> 

<div id="add-group-navigator" class="navigator group-navigator tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#group-settings-tab" data-toggle="tab">Group</a></li>
        <?php if (!$is_root) { ?>

        <li><a href="#user-properties-tab" data-toggle="tab">User Properties</a></li>

        <?php } ?>

    </ul>
    <?php
    echo $this->Form->create('ToastyCore.Group', array(
        'url' => array('controller' => 'groups', 'action' => 'edit', $this->Form->value("Group.id"), 'management' => true),
        'class' => "accountForm"
    ));
    ?>
    
	<div class="tab-content">

	    <div class="tab-pane active well" id="group-settings-tab">
	    	<hr>
	    	<div class="row">
                <div id="group-name" class="span5">
                        <div class="c-label">Name:</div>
                        <div class="c-value">
                            <?php
                            echo $this->Form->input('Group.name', array(
                                'label' => false,
                                'disabled' => $is_root,
                                'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                            ));
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
		</div>

        <?php if (!$is_root) { ?>
        <div class="tab-pane well" id="user-properties-tab">
            <div class="btn-toolbar">

                <div class="btn-group">
                    <button id="add-ups-btn" class="btn">Add Property</button>
                </div>
            </div>

            <hr>

            <ul id="ups-list">
                <?php
                $hidden_data = "";
                $counter = 0;

                foreach ($properties as $property) {
                    $identifier = "old_$counter";
                    ?>
                    <li id="<?= $identifier ?>">
                        <div class="span6">
                            <div class="ups-info pull-left span4">
                                <h4 class="ups_name"><?= $property['UserPropertySkel']['name'] ?></h4>
                                <p><span class="ups_input_format"><?= $property['InputFormat']['name'] ?></span>, <span class="ups_output_format"><?= $property['OutputFormat']['name'] ?></span></p>
                            </div>
                            <div class="pull-right span1">
                                <div class="btn-group">
                                    <a ups="<?= $identifier ?>" class="btn edit-ups">Edit</a>
                                    <a ups="<?= $identifier ?>" class="btn delete-ups">&times;</a>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                    </li>
                    <?php
                    $idOptions = array(
                        'value' => $property['UserPropertySkel']['id'],
                        'class' => $identifier,
                        'field' => 'id'
                    );
                    $nameOptions = array(
                        'value' => $property['UserPropertySkel']['name'],
                        'class' => $identifier,
                        'field' => 'name'
                    );
                    $inputFormatOptions = array(
                        'value' => $property['InputFormat']['id'],
                        'class' => $identifier,
                        'field' => 'input_format'
                    );
                    $outputFormatOptions = array(
                        'value' => $property['OutputFormat']['id'],
                        'class' => $identifier,
                        'field' => 'output_format'
                    );

                    $input = $this->Form->hidden('UserPropertySkel.' . $identifier . '.id', $idOptions);
                    $input .= $this->Form->hidden('UserPropertySkel.' . $identifier . '.name', $nameOptions);
                    $input .= $this->Form->hidden('UserPropertySkel.' . $identifier . '.input_format_id', $inputFormatOptions);
                    $input .= $this->Form->hidden('UserPropertySkel.' . $identifier . '.output_format_id', $outputFormatOptions);

                    $hidden_data .= $input;
                    $counter++;
                }
                ?>
            </ul>
        </div>

    	<div id="ups-modal" class="modal hide fade">
            <div class="modal-header">
                <a type="button" class="close cancel" data-dismiss="modal" aria-hidden="true">&times;</a>
                <h3>Add User Property</h3>
            </div>
            <div class="modal-body">

                <?php
                echo $this->Form->input("modal.name", array('id' => 'ups_name'));
                echo $this->Form->input("modal.input_format_id", array('id' => 'ups_input_format'));
                echo $this->Form->input("modal.output_format_id", array('id' => 'ups_output_format'));
                ?>

            </div>
            <div class="modal-footer">
                <a href="#" class="cancel btn" data-dismiss="modal">Cancel</a>
                <a href="#" class="save btn btn-primary">Save Property</a>
            </div>
        </div>
        <?php } ?>

        <div id="hidden-fields">
            <?php if (!$is_root) { ?>

            <div id="ups-fields"><?= $hidden_data ?></div>
            <?php
                }
                echo $this->Form->input('Group.id');
            ?>
        </div>
        
    	<?php echo $this->Form->end();?>
    </div>
</div>

<?php
$this->end();

$this->start('script');

echo $this->Html->script('ToastyCore.toastyCore');
echo $this->Html->script('ToastyCore.code_behind/group');

echo $this->Html->scriptBlock("
    $('#account-save-button').click(function() {
        $('.accountForm').submit();
    });
    
    $('.accountForm').change(function() {
        $('#account-save-button').removeAttr('disabled');
    });
    
    init_modal();
");



$this->end();

$this->start('sidebar-list-templates');

?>

<script id="ups-info-template" type="text/x-handlebars-template">
<li id="{{id}}">
    <div class="span6">
        <div class="ups-info pull-left span4">
            <h4 class="ups_name">{{name}}</h4>
            <p><span class="ups_input_format">{{input_format}}</span>, <span class="ups_output_format">{{output_format}}</span></p>
        </div>
        <div class="pull-right span1">
            <div class="btn-group">
                <a ups="{{id}}" class="btn edit-ups">Edit</a>
                <a ups="{{id}}" class="btn delete-ups">&times;</a>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <hr>
</li>
</script>

<?php
$this->end();
?>