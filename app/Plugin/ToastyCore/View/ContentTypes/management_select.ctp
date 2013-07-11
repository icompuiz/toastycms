<?php

function tag($tag, $contents, $html_attributes) {


    $attributes = "";

    foreach ($html_attributes as $html_attribute => $value) {

        $attributes .= sprintf(' %s="%s"', $html_attribute, $value);
    }

    $output = sprintf("<%s%s>%s</%s>", $tag, $attributes, $contents, $tag);

    return $output;
}

$list_items = "";
foreach ($contentTypes as $ct) {

    $url = Router::url(array('controller' => 'contents', 'action' => 'add', $ct['ContentType']['id']));

    $link_attr = array("href" => $url);
    if (isset($content_parent_id)) {
        $link_attr["href"] = $url . DS . $content_parent_id;
    } 

    $caption_attr = array(
        "class" => "caption"
    );
    $li_attr = array(
        "class" => "thumbnail"
    );
    
    $caption = tag("div",  tag('p', tag('a',  tag("h4", $ct['ContentType']['name']), $link_attr)), $caption_attr);
    
    $list_items .= tag('li', tag('div', $caption), $li_attr);
    
}

$this->extend('/Common/content_base');
$this->start('management-right');
?>

<div id="select-content-type-navigator" class="navigator content-navigator tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#select-content-type-tab" data-toggle="tab">Select Content Type</a></li>
    </ul>
    <div class="tab-content">

        <div class="tab-pane active well" id="select-content-type-tab">
            <h3>Available Content Types</h3>
            <ul class="thumbnails">
                <?= $list_items ?>
            </ul>
        </div>


    </div>
</div>


<?php
$this->end();