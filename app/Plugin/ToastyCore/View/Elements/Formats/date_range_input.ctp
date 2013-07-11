<div class="input date-input row">
<?php
	
	$start_time = $start_day = $end_time = $end_day = "";


	if (is_array($value)) {
		$start_day = isset($value['start_day']) ? $value['start_day'] : null;
		$start_time = isset($value['start_time']) ? $value['start_time'] : null;
		$end_day = isset($value['end_day']) ? $value['end_day'] : null;
		$end_time = isset($value['end_time']) ? $value['end_time'] : null;
	}

	$fh_name = preg_replace("~(data\[)~", "", $name);
	$fh_name = preg_replace("~(\[)~", "", $fh_name);
	$fh_name = preg_replace("~(\])~", ".", $fh_name);
	$fh_name = substr($fh_name, 0, strlen($fh_name) - 1);


	// debug($fh_name);

?>
<div class="span3">
<?php
	echo $this->Form->label($fh_name, $label);
?>
</div>
<div class="clearfix"></div>
<div class="span3">
<?php	
	$start_day_label = $fh_name . ".start_day";
	echo $this->Form->label($start_day_label);
	echo $this->Form->date($start_day_label, array('value' => $start_day));
?>

<?php
	$start_time_label = $fh_name . ".start_time";
	echo $this->Form->label($start_time_label);
	echo $this->Form->time($start_time_label, array('value' => $start_time));
?>
</div>
<div class="span3">
<?php
	$end_day_label = $fh_name . ".end_day";
	echo $this->Form->label($end_day_label);
	echo $this->Form->date($end_day_label, array('value' => $end_day));
?>
<?php
	$end_time_label = $fh_name . ".end_time";
	echo $this->Form->label($end_time_label);
	echo $this->Form->time($end_time_label, array('value' => $end_time));
?>
</div>

<?php
	echo $this->Form->error($fh_name, null, array('wrap' => 'div', 'class' => 'alert alert-error'));
    
    if (!empty($data)) {

        echo $this->element('Formats/common/content_property_data', array('data' => $data));
        
    }

?>
</div>