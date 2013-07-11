<?php
$this->extend('/Common/content_base');
$this->start('management-right');
?>
<div id="content-controls" class="btn-toolbar pull-right">
    <div class="btn-group">
        <button class="btn" id='content-save-button' disabled>Save</button>
        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Content.id'), 'management' => true), array('class' => 'btn'), __("Are you sure you want to delete '%s'?", $this->Form->value('Content.name'))); ?>
        <?php echo $this->Form->postLink(__('Cancel'), array('action' => 'index', 'cancel', 'management' => true), array('class' => 'btn'), __('Are you sure you want to cancel? Any changes will be lost.')); ?>
    </div>
    <div class="btn-group">
    <?php
        echo $this->Html->link("Preview", array("action" => 'view', $this->Form->value("Content.id")), array('class' => 'btn', 'target' => 'blank'));

        $disabled = $this->Form->value('Content.published') ? "": " disabled";

        echo $this->Html->link("Live", "/content/$content_path", array('class' => "btn $disabled", 'target' => 'blank'));
    ?>
    </div>
</div>

<div id="edit-content-navigator" class="navigator content-navigator tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#settings-tab" data-toggle="tab">Content</a></li>
        <li ><a href="#properties-tab" data-toggle="tab">Properties</a></li>
    </ul>
    <?php
    echo $this->Form->create('ToastyCore.Content', array(
        'type' => 'file',
        'url' => array('controller' => 'contents', 'action' => 'edit', $this->Form->value('Content.id'), 'management' => true),
        'class' => 'contentForm'
    ));
    ?>
    <div class="tab-content">

        <div class="tab-pane  well" id="properties-tab">

            <?php
            $properties = $this->Form->value('ContentTypeProperties');
            $elements = "";

            $content_id = $this->Form->value('Content.id');
            if (null !== $properties) {
                $counter = 0;
                foreach ($properties as $property) {
                    
                    
                    
                            $data = array();

                            if (!isset($property['ContentTypeProperty'])) {
                                $id = "";
                                $value = '';
                            } else {
                                $id = $property['ContentTypeProperty']['id'];
                                $value = $property['ContentTypeProperty']['value'];
                            }




                            $data = array(
                                array(
                                    'name' => "data[Content][ContentTypeProperties][$counter][content_type_property_skel_id]",
                                    'value' => $property['ContentTypePropertySkel']['id']
                                ),
                                array(
                                    'name' => "data[Content][ContentTypeProperties][$counter][id]",
                                    'value' => $id
                                ),
                                array(
                                    'name' => "data[Content][ContentTypeProperties][$counter][content_id]",
                                    'value' => $content_id
                                ),
                                array(
                                    'name' => "data[Content][ContentTypeProperties][$counter][previous_value]",
                                    'value' => $value
                                )
                            );

                            $name = $property['ContentTypePropertySkel']['name'];
                            $inputFormat = $property['InputFormat'];
                            $system_path = $inputFormat['system_path'];

                            $input = $this->element(
                                    "Formats/$system_path", array(
                                'identifier' => "ct-$id",
                                'name' => "data[Content][ContentTypeProperties][$counter][value]",
                                'value' => $value,
                                'label' => $name,
                                'data' => $data
                                    )
                            );

                            $divider = '<hr>';
                            $element = "<li>$input$divider</li>";

                            $elements .= $element;

                            $counter++;
                                                      
                }
            }
            
            echo "<ul class=\"content-type-properties-list\">$elements</ul>";


            ?>




        </div>
        <div class="active tab-pane well" id="settings-tab">
            <div id="content-settings">

                <?php
                echo $this->Form->input('id');
                echo $this->Form->hidden('Content.user_id');
                echo $this->Form->hidden('Content.content_type_id');
                echo $this->Form->hidden('Content.parent_content_id');
                ?>

                <div class="row">
                    <div id="content-name" class="span4">
                        <div class="c-label">Name:</div>
                        <div class="c-value">
                            <?php
                            echo $this->Form->input('Content.name', array(
                                'label' => false,
                                'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                            ));
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="row">
                       
                       
                       <div id="content-alias" class="span5">
                        <div class="c-label">Alias:</div>
                        <div class="c-value">
                            <?php
                            echo $this->Form->input('Content.alias', array(
                                'label' => false,
                                'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                            ));
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="row">
                       
                       
                        <div id="content-published" class="span5">
                            <div class="c-label">Published:</div>
                                <div class="c-value">
                                    <?php
                                    echo $this->Form->input('Content.published', array(
                                        'label' => false,
                                        'error' => false
                                    ));

                                    ?>
                                </div>
                                <div class="c-value">
                                    <?php
                                        echo $this->Form->error('Content.published', null, array('wrap' => 'div', 'class' => 'alert'));
                                    ?>
                                </div>
                                </div>
                             <div class="clearfix"></div>
                        </div>
                    </div>

                <div class="row">
                       
                       
                        <div id="content-home_page" class="span5">
                            <div class="c-label">Home Page:</div>
                                <div class="c-value">
                                    <?php
                                    echo $this->Form->input('Content.home_page', array(
                                        'label' => false,
                                        'error' => false
                                    ));

                                    ?>
                                </div>
                                <div class="c-value">
                                    <?php
                                        echo $this->Form->error('Content.home_page', null, array('wrap' => 'div', 'class' => 'alert'));
                                    ?>
                                </div>
                             <div class="clearfix"></div>
                        </div>
                    </div>


                <div class="row">
                    <div id="content-id" class="span4">
                        <div class="c-label">ID:</div>
                        <div class="c-value"><?= $this->Form->value('Content.id') ?></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="row">
                    <div id="content-type" class="span4">
                        <div class="c-label">Content Type:</div>
                        <div class="c-value">
                        <?php
                            $content_type_name =  $this->Form->value('ContentType.name');
                            $content_type_id = $this->Form->value("ContentType.id");
                            echo $this->Html->link($content_type_name, array('controller' => 'content_types', 'action' => 'edit', $content_type_id), array('class' => 'link'));
                        ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                
                <div class="row">
                    <div id="parent-content" class="span4">
                        <div class="c-label">Parent Content:</div>
                        <div class="c-value"><?= $this->Form->input('parent_content_id', array('label' => false)) ?></div>
                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <?php echo $this->Form->end(); ?>
</div>

<?php
$this->end();

$this->start('script');
echo $this->Html->script("ToastyCore.code_behind/content");

echo $this->Html->scriptBlock("
    $('#content-save-button').click(function() {
        $('#ContentManagementEditForm').submit();
    });
    
    $('#ContentManagementEditForm').change(function() {
        $('#content-save-button').removeAttr('disabled');
    });

    if (typeof CKEDITOR != 'undefined') {
        $.each(CKEDITOR.instances, function(id, instance) { 
            instance.on('blur', function() {
                $('#ContentManagementEditForm').change();
            });
        });
    }
    
");
$this->end();
?>