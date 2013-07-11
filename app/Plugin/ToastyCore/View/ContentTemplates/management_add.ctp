<?php
$this->extend('/Common/content_base');
$this->start('management-right');
?>

<div id="content-template-controls" class="btn-toolbar pull-right controls">
    <div class="btn-group">
        <button class="btn" id='content-template-save-button' disabled>Save</button>
        <?php echo $this->Form->postLink(__('Cancel'), array('action' => 'index', 'cancel', 'management' => true), array('class' => 'btn'), __('Are you sure you want to cancel? Any changes will be lost.')); ?>
    </div>
</div>


<div id="add-content-template-navigator" class="navigator content-navigator tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#content-template-settings-tab" data-toggle="tab">Content Template</a></li>
    </ul>
    <?php
    echo $this->Form->create('ToastyCore.ContentTemplate', array(
        'url' => array('controller' => 'content_templates', 'action' => 'add', 'management' => true),
        'class' => "contentTemplateForm"
    ));
    ?>
    <div class="tab-content">
        <div class="tab-pane active well" id="content-template-settings-tab">
            <hr>
            <ul>
                <li>
                    <div class="input">
                        <?php
                        echo $this->Form->input('ContentTemplate.name', array(
                            'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                        ));
                        echo $this->Form->input('ContentTemplate.parent_content_template_id', array(
                            'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                        ));

                        $value = $this->Form->value('ContentTemplate.content');
                        $name = "Content";
                        $data = array();
                        $input = $this->element(
                                "Formats/code_input", array(
                            'name' => "ContentTemplate.content",
                            'value' => $value,
                            'label' => $name,
                            'data' => $data,
                            'type' => 'application/x-httpd-php'
                                )
                        );

                        echo $input;
                        ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>

</div>


<?php
$this->end();

$this->start('script');

echo $this->Html->script('ToastyCore.toastyCore');


echo $this->Html->scriptBlock("
    $('#content-template-save-button').click(function() {
        $('.contentTemplateForm').submit();
    });
    
    $('.contentTemplateForm').change(function() {
        $('#content-template-save-button').removeAttr('disabled');
    });

    var origninalValue = editor.getValue();

    editor.on('change', function(instance, changeObject) {

        if (instance.getValue() === origninalValue) {
            $('#content-template-save-button').attr('disabled', 'disabled');
        } else {
            $('.contentTemplateForm').change();
        }

    });

    var map = {
        \"Shift-Ctrl-S\": function(cm) {
            $('#content-template-save-button').click();
        }
    };

    editor.addKeyMap(map);
");

$this->end();
?>