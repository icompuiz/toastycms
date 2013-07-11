<?php
$this->extend('/Common/account_base');
$this->start('management-right');

$is_root = $this->Form->value("User.type") === "root";

?>
<div id="account-controls" class="btn-toolbar pull-right">
    <div class="btn-group">
        <button class="btn" id='user-save-button' disabled>Save</button>
        <?php 
            if (!$is_root) { 
                echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id'), 'management' => true), array('class' => 'btn'), __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); 
            }
        ?>
        <?php echo $this->Form->postLink(__('Cancel'), array('action' => 'index', 'cancel', 'management' => true), array('class' => 'btn'), __('Are you sure you want to cancel? Any changes will be lost.')); ?>
    </div>
</div>


<div id="edit-user-navigator" class="navigator user-navigator tabbable"> 
	<ul class="nav nav-tabs">
        <li class="active"><a href="#settings-tab" data-toggle="tab">User</a></li>

        <?php if (!$is_root) { ?>

        <li><a href="#properties-tab" data-toggle="tab">Properties</a></li>

        <?php } ?>
        
    </ul>
	<?php
		echo $this->Form->create('ToastyCore.User', array(
		    'type' => 'file',
		    'class' => 'userForm',
		    'url' => array('controller' => 'users', 'action' => 'edit', $this->Form->value('User.id'), 'management' => true)
		));
	?>
    <div class="tab-content">
    	<div class="tab-pane active well" id="settings-tab">
            <div class="row">
                       
                       
                <div id="user-username" class="span5">
                    <div class="c-label">Username:</div>
                    <div class="c-value">
                        <?php
                            echo $this->Form->input('User.username', array(
                                'label' => false,
                                'disabled' => $is_root,
                                'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                            ));
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                       
                       
                <div id="user-email" class="span5">
                    <div class="c-label">Email:</div>
                    <div class="c-value">
                        <?php
                            echo $this->Form->input('User.email', array(
                                'label' => false,
                                'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                            ));
                        ?>
                    </div>
                </div>
            </div>


			<div class="row">
			           
			           
			    <div id="user-password" class="span5">
			        <div class="c-label">Password:</div>
			        <div class="c-value">
			            <?php
			                echo $this->Form->input('User.password', array(
			                    'label' => false,
			                    'disabled' => true,
			                    'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
			                ));
			            ?>
			            <a class="change-password" href="#">
			                Change Password
			            </a>
			        </div>
			    </div>


			</div>

            <div class="row">
                       
                       
                <div id="user-password_confirmation" class="span5 hide">
                    <div class="c-label">Confirmation:</div>
                    <div class="c-value">
                        <?php
                            echo $this->Form->input('User.password_confirmation', array(
                                'type' => 'password',
                                'label' => false,
                                'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                            ));
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                       
                       
                <div id="user-group" class="span5">
                    <div class="c-label">Group:</div>
                    <div class="c-value">
                        <?php
                            $group_name =  $this->Form->value('Group.name');
                            $group_id = $this->Form->value("Group.id");
                            echo $this->Html->link($group_name, array('controller' => 'groups', 'action' => 'edit', $group_id), array('class' => 'link'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!$is_root) { ?>

        <div class="tab-pane well" id="properties-tab">
        	<?php
            $properties = $this->Form->value('UserProperties');
            $elements = "";
            if (null !== $properties) {
                $counter = 0;
             $user_id = $this->Form->value('User.id');

                foreach ($properties as $property) {
                	$data = array();

                            if (!isset($property['UserProperty'])) {
                                $id = "";
                                $value = '';
                            } else {
                                $id = $property['UserProperty']['id'];
                                $value = $property['UserProperty']['value'];
                            }

                            $data = array(
                                array(
                                    'name' => "data[User][UserProperties][$counter][user_property_skel_id]",
                                    'value' => $property['UserPropertySkel']['id']
                                ),
                                array(
                                    'name' => "data[User][UserProperties][$counter][user_id]",
                                    'value' => $user_id
                                ),
                                array(
                                    'name' => "data[User][UserProperties][$counter][id]",
                                    'value' => $id
                                ),
                                array(
                                    'name' => "data[User][UserProperties][$counter][previous_value]",
                                    'value' => $value
                                )
                            );

                            $name = $property['UserPropertySkel']['name'];
                            $inputFormat = $property['InputFormat'];
                            $system_path = $inputFormat['system_path'];

                            $input = $this->element(
                                "Formats/$system_path", array(
	                                'name' => "data[User][UserProperties][$counter][value]",
	                                'value' => $value,
	                                'label' => $name,
	                                'data' => $data
                                )
                            );
                    $element = '<div class="row property-row user-property-row">
                        <div class="span6">
                            {{input}}
                        </div>
                    </div>';

                    $elements .= str_replace('{{input}}', $input, $element);

                    $counter++;
                }
            }

            echo $elements;
            ?>
        </div>

        <?php } ?>
	</div>

	<div class="hidden-fields">
		<?php
			echo $this->Form->hidden('User.id');
        	echo $this->Form->hidden('User.group_id');
    	?>
        <input type="hidden" name="password_flag" id="password_flag" value="0" />
    </div>
	<?php
		echo $this->Form->end();
	?>
</div>

<?php
$this->end();
$this->start('script');

echo $this->Html->script("ToastyCore.code_behind/user");

echo $this->Html->scriptBlock("
    $('#user-save-button').click(function() {
        $('.userForm').submit();
    });
    
    $('.userForm').change(function() {
        $('#user-save-button').removeAttr('disabled');
    });

    if (typeof CKEDITOR != 'undefined') {
        $.each(CKEDITOR.instances, function(id, instance) { 
            instance.on('blur', function() {
                $('.userForm').change();
            });
        });
    }
    
    
");
$this->end();
?>