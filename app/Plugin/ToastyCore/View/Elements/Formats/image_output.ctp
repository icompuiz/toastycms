<?php 

	$src = $property['value'];
	$src = str_replace("img/", "", $src);

	$alt = Inflector::humanize($skel['name']);

	$img_id = 'ctp_' . $property['id'];

	echo $this->Html->image($src, array('alt' => $alt, 'id' => $img_id, 'class' => 'ctp_img'));
?>
