<?php
$this->extend('/Common/account_base');
$this->start('management-right');
?>

<div id="account-controls" class="btn-toolbar pull-right controls">
    <div class="btn-group">
        <button class="btn" id='account-save-button' disabled>Save</button>
        <?php echo $this->Form->postLink(__('Cancel'), array('action' => 'index', 'cancel', 'management' => true), array('class' => 'btn'), __('Are you sure you want to cancel? Any changes will be lost.')); ?>
    </div>
</div> 

<div id="add-group-navigator" class="navigator group-navigator tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#group-settings-tab" data-toggle="tab">Group</a></li>
        <li><a href="#user-properties-tab" data-toggle="tab">User Properties</a></li>
    </ul>
    <?php
    echo $this->Form->create('ToastyCore.Group', array(
        'url' => array('controller' => 'groups', 'action' => 'add', 'management' => true),
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
                                'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                            ));
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
		</div>

		<div class="tab-pane well" id="user-properties-tab">
            <div class="btn-toolbar">

                <div class="btn-group">
                    <button id="add-ups-btn" class="btn">Add Property</button>
                </div>
            </div>

            <hr>

            <ul id="ups-list">

            </ul>
        </div>



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
    <div id="hidden-fields">
        <div id="ups-fields"></div>
    </div>

	<?php $this->Form->end();?>
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