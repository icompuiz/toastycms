<div class="input text-input">
 
<?=$this->Form->error($name)?> 
<?=$this->Form->label($name, $label)?>
<textarea name="<?=$name?>"><?=$value?></textarea>

<?php
    
    if (!empty($data)) {
        echo $this->element('Formats/common/content_property_data', array('data' => $data));
    }

?>

</div>

