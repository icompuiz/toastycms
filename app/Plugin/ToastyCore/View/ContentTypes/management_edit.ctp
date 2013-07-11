<?php

function tag($tag, $contents, $html_attributes) {


    $attributes = "";

    foreach ($html_attributes as $html_attribute => $value) {

        $attributes .= sprintf(' %s="%s"', $html_attribute, $value);
    }

    $output = sprintf("<%s%s>%s</%s>", $tag, $attributes, $contents, $tag);

    return $output;
}

$this->extend('/Common/content_base');
$this->start('management-right');
?>

<div id="content-type-controls" class="btn-toolbar pull-right controls">
    <div class="btn-group">
        <button class="btn" id='content-type-save-button' disabled>Save</button>
        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ContentType.id'), 'management' => true), array('class' => 'btn'), __('Are you sure you want to delete? This action is irreversable.')); ?>
        <?php echo $this->Form->postLink(__('Cancel'), array('action' => 'index', 'cancel', 'management' => true), array('class' => 'btn'), __('Are you sure you want to cancel? Any changes will be lost.')); ?>
    </div>
    <div class="btn-group">
        <?=$this->Html->link('Add Content', array('controller' => 'contents', 'action' => 'add', $this->Form->value('ContentType.id')), array('class' => 'btn'))?>
    </div>
</div>


<div id="edit-content-type-navigator" class="navigator content-navigator tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#content-type-settings-tab" data-toggle="tab">Content Type</a></li>
        <li ><a href="#content-type-properties-tab" data-toggle="tab">Properties</a></li>
    </ul>
    <?php
    echo $this->Form->create('ToastyCore.ContentType', array(
        'url' => array('controller' => 'content_types', 'action' => 'edit', $this->Form->value('ContentType.id'), 'management' => true),
        'class' => "contentTypeForm"
    ));
    ?>
    <div class="tab-content">

        <div class="tab-pane active well" id="content-type-settings-tab">
            <hr>

            <ul>

                <li>
                    <div class="input">
                        <?php
                        echo $this->Form->input('ContentType.name', array(
                            'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                        ));
                        echo $this->Form->input('content_template_id', array(
                            'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                        ));
                        echo $this->Form->input('parent_content_type_id', array(
                            'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                        ));
                        ?>
                    </div>
                </li>



            </ul>

        </div>
        <div class="tab-pane well" id="content-type-properties-tab">
            <div class="btn-toolbar">

                <div class="btn-group">
                    <button id="add-ctps-btn" class="btn">Add Property</button>
                </div>
            </div>

            <hr>

            <ul id="ctps-list">

                <?php
                $hidden_data = "";
                $counter = 0;
                foreach ($properties as $property) {
                    $identifier = "old_$counter";
                    ?>
                    <li id="<?= $identifier ?>">
                        <div class="span6">
                            <div class="ctps-info pull-left span4">
                                <h4 class="ctps_name"><?= $property['ContentTypePropertySkel']['name'] ?></h4>
                                <p><span class="ctps_input_format"><?= $property['InputFormat']['name'] ?></span>, <span class="ctps_output_format"><?= $property['OutputFormat']['name'] ?></span></p>
                            </div>
                            <div class="pull-right span1">
                                <div class="btn-group">
                                    <a ctps="<?= $identifier ?>" class="btn edit-ctps">Edit</a>
                                    <a ctps="<?= $identifier ?>" class="btn delete-ctps">&times;</a>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                    </li>
                    <?php
                    $idOptions = array(
                        'value' => $property['ContentTypePropertySkel']['id'],
                        'class' => $identifier,
                        'field' => 'id'
                    );
                    $nameOptions = array(
                        'value' => $property['ContentTypePropertySkel']['name'],
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

                    $input = $this->Form->hidden('ContentTypePropertySkel.' . $identifier . '.id', $idOptions);
                    $input .= $this->Form->hidden('ContentTypePropertySkel.' . $identifier . '.name', $nameOptions);
                    $input .= $this->Form->hidden('ContentTypePropertySkel.' . $identifier . '.input_format_id', $inputFormatOptions);
                    $input .= $this->Form->hidden('ContentTypePropertySkel.' . $identifier . '.output_format_id', $outputFormatOptions);

                    $hidden_data .= $input;
                    $counter++;
                }
                ?>

            </ul>
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

    <div id="hidden-fields">
        <div id="ctps-fields"><?= $hidden_data ?></div>
        <?php  
            echo $this->Form->input('ContentType.id');
        ?>

    </div>
    <?php echo $this->Form->end(); ?>

</div>


<?php
$this->end();

$this->start('script');

echo $this->Html->script('ToastyCore.toastyCore');
echo $this->Html->script('ToastyCore.code_behind/content_type');

echo $this->Html->scriptBlock("
    $('#content-type-save-button').click(function() {
        $('#ContentTypeManagementEditForm').submit();
    });
    
    $('#ContentTypeManagementEditForm').change(function() {
        $('#content-type-save-button').removeAttr('disabled');
    });
    
    init_modal($counter);
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