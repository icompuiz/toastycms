<div class="input image-input">
<?php

	$fh_name = preg_replace("~(data\[)~", "", $name);
	$fh_name = preg_replace("~(\[)~", "", $fh_name);
	$fh_name = preg_replace("~(\])~", ".", $fh_name);
	$fh_name = substr($fh_name, 0, strlen($fh_name));
	$identifier = str_replace(".", "", $fh_name);


	// debug($fh_name);

	echo $this->Form->label($fh_name, $label);
	echo $this->Form->file($fh_name);
	echo $this->Form->error($fh_name, null, array('wrap' => 'div', 'class' => 'alert alert-error'));

    if(!empty($value)) {
        $value = preg_replace("/^img\//", "", $value);
        $value = DS. $value;
        echo $this->Html->link('Download Current File', $value, array('class' => 'ctp-img', 'target' => 'blank'));
    }
    
    if (!empty($data)) {
        echo $this->element('Formats/common/content_property_data', array('data' => $data));
    }

?>
</div>