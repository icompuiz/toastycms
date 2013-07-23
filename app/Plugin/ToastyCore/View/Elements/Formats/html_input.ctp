<div class="input html-input">
 
<?php

	$fh_name = preg_replace("~(data\[)~", "", $name);
	$fh_name = preg_replace("~(\[)~", "", $fh_name);
	$fh_name = preg_replace("~(\])~", ".", $fh_name);
	$fh_name = substr($fh_name, 0, strlen($fh_name) - 1);
	$identifier = str_replace(".", "", $fh_name);


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

App::uses('Stylesheet', 'ToastyCore.Model');
$model = new Stylesheet();

$tmp = $model->find('list', array('conditions' => array('Stylesheet.editor_enabled' => true),'fields' => array('Stylesheet.system_path')));
$stylesheets = array();
$basePath = Router::url("/css/");
foreach ($tmp as $stylesheet) {
	$stylesheets[] = "'$basePath$stylesheet'";
}
$stylesheets = join(",", $stylesheets);

$this->start("script");

	echo $this->Html->script('ToastyCore.ckeditor/ckeditor');
	echo $this->Html->scriptBlock("
		CKEDITOR.config.allowedContent = true;
		CKEDITOR.config.extraPlugins = 'stylesheetparser';
		CKEDITOR.config.contentsCss = [$stylesheets]; 
		CKEDITOR.replace( '$name' );
	");

$this->end();
?>

