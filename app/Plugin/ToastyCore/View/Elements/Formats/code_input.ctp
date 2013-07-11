<div class="input text-input">
 

<?php

	$fh_name = preg_replace("~(data\[)~", "", $name);
	$fh_name = preg_replace("~(\[)~", "", $fh_name);

	$fh_name = preg_replace("~(\])~", ".", $fh_name);
	// $fh_name = substr($fh_name, 0, strlen($fh_name) - 1);
	$identifier = str_replace(".", "_", $fh_name);
	$identifier = Inflector::underscore($identifier);
	$identifier = Inflector::camelize($identifier);

	// debug($fh_name);

	echo $this->Form->label($fh_name, $label);
	echo $this->Form->textarea($fh_name, array('value' => $value));
	echo $this->Form->error($fh_name, null, array('wrap' => 'div', 'class' => 'alert alert-error'));
    

    
    if (!empty($data)) {
        echo $this->element('Formats/common/content_property_data', array('data' => $data));
    }

?>

</div>

<?php

$this->start('css');

echo $this->Html->css('ToastyCore.codemirror/lib/codemirror');


$this->end();

$this->start('script');
echo $this->Html->script('ToastyCore.codemirror/lib/codemirror');
echo $this->Html->script('ToastyCore.codemirror/addon/edit/matchbrackets');
echo $this->Html->script('ToastyCore.codemirror/mode/htmlmixed/htmlmixed');
echo $this->Html->script('ToastyCore.codemirror/mode/xml/xml');
echo $this->Html->script('ToastyCore.codemirror/mode/javascript/javascript');
echo $this->Html->script('ToastyCore.codemirror/mode/css/css');
echo $this->Html->script('ToastyCore.codemirror/mode/clike/clike');
echo $this->Html->script('ToastyCore.codemirror/mode/php/php');

echo $this->Html->scriptBlock("

	var textarea = document.getElementById('$identifier');

    var cmOptions = {
        lineNumbers: true,
        matchBrackets: true,
        mode: '$type',
        indentUnit: 4,
        indentWithTabs: true,
        enterMode: 'keep',
        tabMode: 'shift'
      };

    var editor = CodeMirror.fromTextArea (textarea, cmOptions);

");
$this->end();

?>