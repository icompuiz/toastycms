<?php
$this->extend('/Common/content_base');
$this->start('management-right');
?>
<div id="media-controls" class="btn-toolbar pull-right controls">
    <div class="btn-group">
        <button class="btn" id='media-save-button' disabled>Save</button>
        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Media.id'), 'management' => true), array('class' => 'btn'), __('Are you sure you want to delete %s?', $this->Form->value('Media.name'))); ?>
        <?php echo $this->Form->postLink(__('Cancel'), array('action' => 'index', 'cancel', 'management' => true), array('class' => 'btn'), __('Are you sure you want to cancel? Any changes will be lost.')); ?>
    </div>
    <div class="btn-group">
        <?php echo $this->Html->link(__('Add Directory'), array('action' => 'add', $this->Form->value('Media.media_directory_id'), 'management' => true),array('class' => 'btn'));?>
        <?php echo $this->Html->link(__('Add Media'), array('controller' => 'media', 'action' => 'add', $this->Form->value('Media.media_directory_id'), 'management' => true),array('class' => 'btn'));?>
    </div>
</div>
<div id="add-media-navigator" class="navigator media-navigator tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#settings-tab" data-toggle="tab">Media</a></li>
    </ul>
    <?php
    echo $this->Form->create('ToastyCore.Media', array(
        'type' => 'file',
        'url' => array('controller' => 'media', 'action' => 'edit', $this->Form->value('Media.id'), 'management' => true),
        'class' => 'mediaForm'
    ));
    ?>

    <div class="tab-content">

        <div class="tab-pane well active" id="settings-tab">

        	<div class="row">
                       
                       
                <div id="media-name" class="span5">
                    <div class="c-label">Name:</div>
                    <div class="c-value">
                        <?php
                        echo $this->Form->input('Media.name', array(
                            'label' => false,
                            'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                        ));
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>

             <div class="row">
                       
                       
                <div id="media-name" class="span5">
                    <div class="c-label">Directory:</div>
                    <div class="c-value">
                        <?php
                        	echo $this->Form->input('Media.media_directory_id', array(
                            'label' => false,
                            'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                        ));
                        
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>

            <div class="row">
                       
                       
                <div id="media-type" class="span5">
                    <div class="c-label">Type:</div>
                    <div class="c-value">
                        <?php
                            echo $this->Form->value('Media.type');
                        
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>

            <div class="row">
                       
                       
                <div id="media-name" class="span6">
                    <div class="c-label">File:</div>
                    <div class="c-value">
                        <?php
                        $value = $this->Form->value('Media.previous_value');
                        $name = "Upload File";
                        $data = array(
                        	array(
                        		'name' => 'data[Media][previous_value]',
                        		'value' => $value
                    		)
                    	);
                        $input = $this->element(
                                "Formats/file_input", array(
                            'name' => "Media.system_path",
                            'value' => $value,
                            'label' => $name,
                            'data' => $data
                                )
                        );

                        echo $input;
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>

        </div>

    </div>

    <div id="hiddenValues">
    	<?php
            echo $this->Form->hidden("Media.id");
    		echo $this->Form->hidden("Media.type");
    	?>
    </div>
    <?php
    	echo $this->Form->end();
    ?>
</div>
<?php
$this->end();

$this->start('script');
echo $this->Html->scriptBlock("
    $('#media-save-button').click(function() {
        $('.mediaForm').submit();
    });
    
    $('.mediaForm').change(function() {
        $('#media-save-button').removeAttr('disabled');
    });
");
$this->end();
?>