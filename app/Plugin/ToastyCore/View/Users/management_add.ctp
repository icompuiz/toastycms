<?php
$this->extend('/Common/account_base');
$this->start('management-right');
?>
<div id="account-controls" class="btn-toolbar pull-right controls">
    <div class="btn-group">
        <button class="btn" id='user-save-button' disabled>Save</button>
        <?php echo $this->Form->postLink(__('Cancel'), array('action' => 'index', 'cancel', 'management' => true), array('class' => 'btn'), __('Are you sure you want to cancel? Any changes will be lost.')); ?>
    </div>
</div>

<div id="add-user-navigator" class="navigator user-navigator tabbable"> 
	<ul class="nav nav-tabs">
        <li class="active"><a href="#settings-tab" data-toggle="tab">User</a></li>
        <li><a href="#properties-tab" data-toggle="tab">Properties</a></li>
    </ul>
	<?php
		echo $this->Form->create('ToastyCore.User', array(
		    'type' => 'file',
            'class' => 'userForm',
		    'url' => array('controller' => 'users', 'action' => 'add', $this->Form->value('Group.id'), 'management' => true)
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
                                'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert'))
                            ));
                        ?>
                    </div>
                </div>


            </div>

            <div class="row">
                       
                       
                <div id="user-password_confirmation" class="span5">
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

        <div class="tab-pane well" id="properties-tab">

        	<?php
            $properties = $this->Form->value('UserProperties');

            $elements = "";
            if (null !== $properties) {
                $counter = 0;
                foreach ($properties as $property) {
      

                    $id = "";
                    $value = "";

                    $data = array(
                        array(
                            'name' => "data[User][UserProperties][$counter][user_property_skel_id]",
                            'value' => $property['UserPropertySkel']['id']
                        )
                    );

                    $name = $property['UserPropertySkel']['name'];
                    $inputFormat = $property['InputFormat'];
                    $system_path = $inputFormat['system_path'];

                    $input = $this->element(
                        "Formats/$system_path", 
                        array(
                            'name' => "data[User][UserProperties][$counter][value]",
                            'value' => $value,
                            'label' => $name,
                            'data' => $data
                        )
                    );

                    $element = '<div class="row property-row user-property-row">
                        <div class="span6">
                            {{value}}
                        </div>
                    </div><hr>';

                    $elements .= str_replace('{{value}}', $input, $element);

                    $counter++;

                            
                }
            }

            echo $elements;
            
            ?>



		</div>

	</div>
    <div class="hidden-fields">
        <?php
            echo $this->Form->hidden('User.group_id');
        ?>
        <input type="hidden" name="password_flag" id="password_flag" value="1" />
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
    
    
    
");
$this->end();
?>