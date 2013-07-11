<?php
$this->extend('/Common/content_base');
$this->start('management-right');
?>
<div id="content-controls" class="btn-toolbar pull-right controls">
    <div class="btn-group">
        <button class="btn" id='content-save-button' disabled>Save</button>
        <?php echo $this->Form->postLink(__('Cancel'), array('action' => 'index', 'cancel', 'management' => true), array('class' => 'btn'), __('Are you sure you want to cancel? Any changes will be lost.')); ?>
    </div>
</div>

<div id="add-content-navigator" class="navigator content-navigator tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#settings-tab" data-toggle="tab">Content</a></li>
        <li><a href="#properties-tab" data-toggle="tab">Properties</a></li>
    </ul>
    <?php
    echo $this->Form->create('ToastyCore.Content', array(
        'type' => 'file',
        'url' => array('controller' => 'contents', 'action' => 'add', $this->Form->value('ContentType.id'), 'management' => true)
    ));
    ?>
    <div class="tab-content">

        <div class="tab-pane well" id="properties-tab">

            <?php
            $properties = $this->Form->value('ContentTypeProperties');
            $elements = "";
            if (null !== $properties) {
                $counter = 0;
                foreach ($properties as $property) {
                    ?>
                    <div class="row content-property-row">
                        <div class="span6">
                            <?php
                            $id = "";
                            $value = '';


                            $data = array(
                                array(
                                    'name' => "data[Content][ContentTypeProperties][$counter][content_type_property_skel_id]",
                                    'value' => $property['ContentTypePropertySkel']['id']
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
                            ?>
                        </div>
                    </div>
                    <?php
                }
            }

            echo "<ul class=\"content-type-properties-list\">$elements</ul>";
            ?>

        </div>
        <div class="tab-pane active well" id="settings-tab">
            <div id="content-settings">

                <?php
                     echo $this->Form->hidden('Content.user_id');

                    echo $this->Form->hidden('Content.content_type_id');

                ?>
                

                   <div class="row">
                       
                       
                       <div id="content-name" class="span5">
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
                        <div id="content-type" class="span5">
                            <div class="c-label">Content Type:</div>
                            <div class="c-value"><?= $this->Form->value('ContentType.name') ?></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div id="parent-content" class="input span5">
                            <div class="c-label">Parent Content:</div>
                            <div class="c-value"><?= $this->Form->input('Content.parent_content_id', array(
                                'label' => false,
                                'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                            )) ?></div>
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
echo $this->Html->scriptBlock("
    $('#content-save-button').click(function() {
        $('#ContentManagementAddForm').submit();
    });
    
    $('#ContentManagementAddForm').change(function() {
        $('#content-save-button').removeAttr('disabled');
    });
    
    
    
");
$this->end();
?>