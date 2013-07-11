<?php
$this->extend('/Common/content_base');
$this->start('management-right');
?>

<div id="content-type-controls" class="btn-toolbar pull-right controls">
    <div class="btn-group">
        <button class="btn" id='content-type-save-button' disabled>Save</button>
        <?php echo $this->Form->postLink(__('Cancel'), array('action' => 'index', 'cancel', 'management' => true), array('class' => 'btn'), __('Are you sure you want to cancel? Any changes will be lost.')); ?>
    </div>
</div>


<div id="add-content-type-navigator" class="navigator content-navigator tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#content-type-settings-tab" data-toggle="tab">Content Type</a></li>
        <li ><a href="#content-type-properties-tab" data-toggle="tab">Properties</a></li>
    </ul>
    <?php
    echo $this->Form->create('ToastyCore.ContentType', array(
        'url' => array('controller' => 'content_types', 'action' => 'add', 'management' => true),
        'class' => "contentTypeForm"
    ));
    ?>
    <div class="tab-content">

        <div class="tab-pane active well" id="content-type-settings-tab">
            <hr>

            <div class="row">
                       
                       
                    <div id="content-type-name" class="span5">
                        <div class="c-label">Name:</div>
                        <div class="c-value">
                            <?php
                            echo $this->Form->input('ContentType.name', array(
                                'label' => false,
                                'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                            ));
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            <div class="row">
                <div id="content-type-template" class="span5">
                        <div class="c-label">Content Template:</div>
                        <div class="c-value">
                            <?php
                            echo $this->Form->input('content_template_id', array(
                                'label' => false,
                                'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                            ));
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="row">
                <div id="parent-content-id" class="span5">
                        <div class="c-label">Parent Content Type:</div>
                        <div class="c-value">
                            <?php
                            echo $this->Form->input('parent_content_type_id', array(
                                'label' => false,
                                'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                            ));
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

    

        </div>
        <div class="tab-pane well" id="content-type-properties-tab">
            <div class="btn-toolbar">

                <div class="btn-group">
                    <button id="add-ctps-btn" class="btn">Add Property</button>
                </div>
            </div>

            <hr>

            <ul id="ctps-list">

            </ul>
        </div>
        <div class="tab-pane well" id="content-type-template-tab">
            <hr>


        </div>


    </div>

    <div id="ctps-modal" class="modal hide fade">
        <div class="modal-header">
            <a type="button" class="close cancel" data-dismiss="modal" aria-hidden="true">&times;</a>
            <h3>Add Content Type Property</h3>
        </div>
        <div class="modal-body">

            <?php
            echo $this->Form->input("modal.name", array('id' => 'ctps_name'));
            echo $this->Form->input("modal.input_format_id", array('id' => 'ctps_input_format'));
            echo $this->Form->input("modal.output_format_id", array('id' => 'ctps_output_format'));
            ?>

        </div>
        <div class="modal-footer">
            <a href="#" class="cancel btn" data-dismiss="modal">Cancel</a>
            <a href="#" class="save btn btn-primary">Save Property</a>
        </div>
    </div>

    <div id="ctps-fields"></div>
    <?php echo $this->Form->end(); ?>

</div>


<?php
$this->end();

$this->start('script');

echo $this->Html->script('ToastyCore.toastyCore');
echo $this->Html->script('ToastyCore.code_behind/content_type');

echo $this->Html->scriptBlock("
    $('#content-type-save-button').click(function() {
        $('.contentTypeForm').submit();
    });
    
    $('.contentTypeForm').change(function() {
        $('#content-type-save-button').removeAttr('disabled');
    });
    
    init_modal();
");



$this->end();

$this->start('sidebar-list-templates');
?>

<script id="ctps-info-template" type="text/x-handlebars-template">
<li id="{{id}}">
    <div class="span6">
        <div class="ctps-info pull-left span4">
            <h4 class="ctps_name">{{name}}</h4>
            <p><span class="ctps_input_format">{{input_format}}</span>, <span class="ctps_output_format">{{output_format}}</span></p>
        </div>
        <div class="pull-right span1">
            <div class="btn-group">
                <a ctps="{{id}}" class="btn edit-ctps">Edit</a>
                <a ctps="{{id}}" class="btn delete-ctps">&times;</a>
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