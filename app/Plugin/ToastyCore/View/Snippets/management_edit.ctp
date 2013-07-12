<?php
	$this->extend('Common/content_base');
	$this->start('management-right');
?>


<div id="media-controls" class="btn-toolbar pull-right controls">
    <div class="btn-group">
        <button class="btn" id='media-save-button' disabled>Save</button>
        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Snippet.id'), 'management' => true), array('class' => 'btn'), __('Are you sure you want to delete %s?', $this->Form->value('Snippet.name'))); ?>

        <?php echo $this->Form->postLink(__('Cancel'), array('action' => 'index', 'cancel', 'management' => true), array('class' => 'btn'), __('Are you sure you want to cancel? Any changes will be lost.')); ?>
    </div>
</div>

<div id="edit-media-navigator" class="navigator media-navigator tabbable">

	<ul class="nav nav-tabs">
        <li class="active"><a href="#settings-tab" data-toggle="tab">Snippet</a></li>
    </ul>

    <?php
    echo $this->Form->create('ToastyCore.Snippet', array(
        'type' => 'file',
        'url' => array('controller' => 'snippets', 'action' => 'edit', $this->Form->value('Snippet.id'), 'management' => true),
        'class' => 'mediaForm'
    ));
    echo $this->Form->input('Snippet.id');
    echo $this->Form->hidden('Snippet.previous_path');
    ?>



	<div class="tab-content">

		<div class="tab-pane well active" id="settings-tab">

			<div class="row">
                       
                       
                <div id="snippet-name" class="span5">
                    
                    <div class="c-label">Name:</div>
                    <div class="c-value">
                        <?php
                        echo $this->Form->input('Snippet.name', array(
                            'label' => false,
                            'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                        ));
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>

            <div class="row">
                       
                       
                <div id="snippet-name" class="span7">
			
                    <div class="">

					<?php

						$value = $this->Form->value('Snippet.content');
	                    $name = "Content";
	                    $data = array();
	                    $input = $this->element(
	                        "Formats/code_input", array(
			                    'name' => "Snippet.content",
			                    'value' => $value,
			                    'label' => $name,
			                    'data' => $data,
                            	'type' => 'application/x-httpd-php'

	                        )
	                    );

	                    echo $input;

	                ?>

					</div>
				</div>
                <div class="clearfix"></div>

			</div>


	</div>

    <?php
    	$this->Form->end();
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

		var origninalValue = editor.getValue();

	    editor.on('change', function(instance, changeObject) {

	        if (instance.getValue() === origninalValue) {
	            $('#media-save-button').attr('disabled', 'disabled');
	        } else {
	            $('.mediaForm').change();
	        }

	    });

	    var map = {
	        \"Shift-Ctrl-S\": function(cm) {
	            $('#media-save-button').click();
	        }
	    };

	    editor.addKeyMap(map);
	");
	$this->end();
?>