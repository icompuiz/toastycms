<?php
$this->extend('/Common/content_base');
$this->start('management-right');
?>
<div id="media-directory-controls" class="btn-toolbar pull-right controls">
    <div class="btn-group">
        <button class="btn" id='media-directory-save-button' disabled>Save</button>
        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('MediaDirectory.id'), 'management' => true), array('class' => 'btn'), __('Are you sure you want to delete %s and all its decendants?', $this->Form->value('MediaDirectory.name'))); ?>
        <?php echo $this->Form->postLink(__('Cancel'), array('action' => 'index', 'cancel', 'management' => true), array('class' => 'btn'), __('Are you sure you want to cancel? Any changes will be lost.')); ?>
    </div>
    <div class="btn-group">
        <?php echo $this->Html->link(__('Add Directory'), array('action' => 'add', $this->Form->value('MediaDirectory.id'), 'management' => true),array('class' => 'btn'));?>
        <?php echo $this->Html->link(__('Add Media'), array('controller' => 'media', 'action' => 'add', $this->Form->value('MediaDirectory.id'), 'management' => true),array('class' => 'btn'));?>
    </div>
</div>
<div id="add-media-directory-navigator" class="navigator media-directory-navigator tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#settings-tab" data-toggle="tab">Media Directory</a></li>
    </ul>
    <?php
    echo $this->Form->create('ToastyCore.Media', array(
        'type' => 'file',
        'url' => array('controller' => 'media_directories', 'action' => 'edit', $this->Form->value('MediaDirectory.id'), 'management' => true),
        'class' => 'mediaDirectoryForm'
    ));
    ?>

    <div id="hiddenValues">
    	<?php
    		echo $this->Form->input("MediaDirectory.id");
    		echo $this->Form->hidden("MediaDirectory.previous_value");
    	?>
    </div>

    <div class="tab-content">

        <div class="tab-pane well active" id="settings-tab">

        	<div class="row">
                       
                       
                <div id="media-directory-name" class="span5">
                    <div class="c-label">Name:</div>
                    <div class="c-value">
                        <?php
                        echo $this->Form->input('MediaDirectory.name', array(
                            'label' => false,
                            'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                        ));
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>

            <div class="row">
                       
                       
                <div id="media-directory-name" class="span5">
                    <div class="c-label">Parent Directory:</div>
                    <div class="c-value">
                        <?php
                        	echo $this->Form->input('MediaDirectory.parent_media_directory_id', array(
                            'label' => false,
                            'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                        ));
                        
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>

            <div class="row">
                       
                       
                <div id="media-directory-name" class="span5">
                    <div class="c-label">System Path:</div>
                    <div class="c-value">
                        <?php
                        	echo $this->Form->value('MediaDirectory.system_path');
                        
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>

             

    </div>
    <?php
    	echo $this->Form->end();
    ?>
</div>
<?php
$this->end();

$this->start('script');
echo $this->Html->scriptBlock("
    $('#media-directory-save-button').click(function() {
        $('.mediaDirectoryForm').submit();
    });
    
    $('.mediaDirectoryForm').change(function() {
        $('#media-directory-save-button').removeAttr('disabled');
    });
");
$this->end();
?>