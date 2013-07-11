<?php
$output = "";
foreach ($data as $data_item) {
    $dname = $data_item['name'];
    $dvalue = $data_item['value'];

    $dname = preg_replace("~(data\[)~", "", $dname);
	$dname = preg_replace("~(\[)~", "", $dname);
	$dname = preg_replace("~(\])~", ".", $dname);
	$dname = substr($dname, 0, strlen($dname) - 1);

    if (is_array($dvalue)) {
    	foreach ($dvalue as $key => $value) {
    		$output .= $this->Form->hidden($dname . ".$key", array('value' => $value));
    	}
    } else {
    		$output .= $this->Form->hidden($dname, array('value' => $dvalue));

    }
}

echo $output;

?>
