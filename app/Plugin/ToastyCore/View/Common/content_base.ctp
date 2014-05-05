<?php
$this->start('management-flash');
echo $this->Session->flash('flash', array('element' => 'ToastyCore.content_error'));
$this->end();

$ctype_edit_url = Router::url(array('controller' => 'content_types', 'action' => 'edit', 'management' => true));
$ctype_add_url = Router::url(array('controller' => 'content_types', 'action' => 'add', 'management' => true));
$ctempl_edit_url = Router::url(array('controller' => 'content_templates', 'action' => 'edit', 'management' => true));
$ctempl_add_url = Router::url(array('controller' => 'content_templates', 'action' => 'add', 'management' => true));
$content_edit_url = Router::url(array('controller' => 'contents', 'action' => 'edit', 'management' => true));
$content_add_url = Router::url(array('controller' => 'content_types', 'action' => 'select', 'management' => true));

$media_edit_url = Router::url(array('controller' => 'media', 'action' => 'edit', 'management' => true));
$media_add_url = Router::url(array('controller' => 'media', 'action' => 'add', 'management' => true));

$medir_edit_url = Router::url(array('controller' => 'media_directories', 'action' => 'edit', 'management' => true));
$medir_add_url = Router::url(array('controller' => 'media_directories', 'action' => 'add', 'management' => true));

$stylesheet_edit_url = Router::url(array('controller' => 'stylesheets', 'action' => 'edit', 'management' => true));
$stylesheet_add_url = Router::url(array('controller' => 'stylesheets', 'action' => 'add', 'management' => true));

$javascript_edit_url = Router::url(array('controller' => 'javascripts', 'action' => 'edit', 'management' => true));
$javascript_add_url = Router::url(array('controller' => 'javascripts', 'action' => 'add', 'management' => true));

$snippet_edit_url = Router::url(array('controller' => 'snippets', 'action' => 'edit', 'management' => true));
$snippet_add_url = Router::url(array('controller' => 'snippets', 'action' => 'add', 'management' => true));

$ctype_delete_link = $this->Form->postLink(__('Delete'), array('controller' => 'content_types', 'action' => 'delete', 'management' => true), null, __('Are you sure you want to delete? This action is irreversable.'));
$ctempl_delete_link = $this->Form->postLink(__('Delete'), array('controller' => 'content_templates', 'action' => 'delete', 'management' => true), null, __('Are you sure you want to delete? This action is irreversable.'));
$content_delete_link = $this->Form->postLink(__('Delete'), array('controller' => 'contents', 'action' => 'delete', 'management' => true), null, __('Are you sure you want to delete? This action is irreversable.'));
$this->start('management-left');
?>

<div id="content-navigator" class="navigator tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a id="content_tab_tab" href="#content_tab" data-toggle="tab">Content</a></li>
        <li><a href="#elements_tab" id="elements_tab_tab" data-toggle="tab">Settings</a></li>
        <li><a href="#files_tab" id="files_tab_tab" data-toggle="tab">Files</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active well" id="content_tab">
            <hr>
            <div class="sidebar-header">
                <div class="btn-group pull-right">
                    <a  href="<?= $content_add_url ?>" class="btn sidebar-add-control"><i class="icon-plus"></i></a>
                </div>
                <p class="muted">
                    Site Content
                </p>
            </div>
            <div id="content-list" class="tlist">

            </div>

            <hr>
            
        </div>
        <div class="tab-pane well" id="elements_tab">
            <hr>

            <div class="sidebar-header">
                <div class="btn-group pull-right">
                    <a  href="<?= $ctype_add_url ?>" class="btn sidebar-add-control"><i class="icon-plus"></i></a>
                </div>
                <p class="muted">
                    Content Types
                </p>

            </div>


            <div id="content-type-list" class="tlist">
            </div>

            <hr>

            <div class="sidebar-header">
                <div class="btn-group pull-right">
                    <a  href="<?= $ctempl_add_url ?>" class="btn sidebar-add-control"><i class="icon-plus"></i></a>
                </div>
                <p class="muted">
                    Content Templates
                </p>
            </div>


            <div id="content-template-list" class="tlist"></div>

            <hr>

        </div>
        <div class="tab-pane well" id="files_tab">

            <hr>

            <div class="sidebar-header">
                
                <p class="muted">
                    Stylesheets
                </p>

            </div>

            <div id="stylesheet-list" class="tlist">
            </div>

            <hr>

            <div class="sidebar-header">
                
                <p class="muted">
                    Javascripts
                </p>

            </div>

            <div id="javascript-list" class="tlist">
            </div>

            <hr>

            <div class="sidebar-header">
                
                <p class="muted">
                    PHP Snippets
                </p>

            </div>

            <div id="snippet-list" class="tlist">
            </div>

            <hr>

            <div class="sidebar-header">
                
                <p class="muted">
                    Media & Directories
                </p>

            </div>


            <div id="media-list" class="tlist">
            </div>

        </div>

    </div>
</div>

<?php
$this->end();

$this->start('script');

echo $this->Html->script('ToastyCore.toastyCore');

echo $this->Html->script('ToastyCore.sidebar/navigator_state');
echo $this->Html->script('ToastyCore.sidebar/navigator');
echo $this->Html->script('ToastyCore.sidebar/list_item_state');
echo $this->Html->script('ToastyCore.sidebar/content_navigator');



echo $this->Html->scriptBlock("
    var contents = new ToastyCore.Model.ContentCollection();
    var contentList = new ToastyCore.View.ContentList({
        el: $('#content-list'),
        model: contents
    });
    var contentTypes = new ToastyCore.Model.ContentTypeCollection();
    var contentTypeList = new ToastyCore.View.ContentTypeList({
       el: $('#content-type-list'),
       model: contentTypes
    });
    var contentTemplates = new ToastyCore.Model.ContentTemplateCollection();
    var contentTemplateList = new ToastyCore.View.ContentTemplateList({
       el: $('#content-template-list'),
       model: contentTemplates
    });

    var media = new ToastyCore.Model.MediaCollection();
    var mediaList = new ToastyCore.View.MediaList({
       el: $('#media-list'),
       model: media
    });

    var stylesheet_collection = new ToastyCore.Model.StylesheetCollection();
    var stylesheet_list = new ToastyCore.View.StylesheetList({
       el: $('#stylesheet-list'),
       model: stylesheet_collection
    });

    var javascript_collection = new ToastyCore.Model.JavascriptCollection();
    var javascript_list = new ToastyCore.View.JavascriptList({
       el: $('#javascript-list'),
       model: javascript_collection
    });

    var snippet_collection = new ToastyCore.Model.SnippetCollection();
    var snippet_list = new ToastyCore.View.SnippetList({
       el: $('#snippet-list'),
       model: snippet_collection
    });

    snippet_collection.fetch();
    javascript_collection.fetch();
    stylesheet_collection.fetch();
    media.fetch();
    contents.fetch();
    contentTypes.fetch();
    contentTemplates.fetch();
");

$this->end();


$this->start('sidebar-list-templates');
?>
<script type="text/template" id="content-list-template">
    <ul class="content-list">
    </ul>
</script>

<script type="text/template" id="root-content-list-item-template">
    <div class="list-item-content">

    <i class="icon-chevron-right collapsed"></i>
    <i class="icon-chevron-down expanded"></i>
    <i class="icon-webpage"></i>

    <a href="<?= $content_edit_url ?>/<%=id%>"><%=innerHtml%></a>
    </div>
</script> 

<script type="text/template" id="content-list-item-template">
    <div class="list-item-content">

    <i class="icon-chevron-right collapsed"></i>
    <i class="icon-chevron-down expanded"></i>
    <i class="icon-webpage"></i>

    <a href="<?= $content_edit_url ?>/<%=id%>"><%=innerHtml%></a>
    <div class="btn-group pull-right  list-item-actions">
    <a class="btn dropdown-toggle navigator-dropdown-toggle" data-toggle="dropdown"><i class="icon-dropmenu"></i></a>
    <ul class="dropdown-menu">
    <li><a href="<?= $content_add_url ?>/<%=id%>">Add Content Here</a></li>
    <li><a href="<?= $content_edit_url ?>/<%=id%>">Edit Content</a></li>
    <!--<li><?= $content_delete_link ?></li>-->

    </ul>
    </div>
    </div>
</script> 
<script type="text/template" id="content-type-list-template">
    <ul class="content-type-list">
    </ul>
</script>

<script type="text/template" id="content-type-list-item-template">

    <div class="list-item-content">
    <i class="icon-chevron-right collapsed"></i>
    <i class="icon-chevron-down expanded"></i>
    <i class="icon-mimetype"></i>


    <a href="<?= $ctype_edit_url ?>/<%=id%>"><%=innerHtml%></a>
    <div class="btn-group pull-right list-item-actions">
    <a class="btn dropdown-toggle navigator-dropdown-toggle" data-toggle="dropdown"><i class="icon-dropmenu"></i></a>
    <ul class="dropdown-menu">
    <li><a href="<?= $ctype_add_url ?>/<%=id%>">Add Type Here</a></li>
    <li><a href="<?= $ctype_edit_url ?>/<%=id%>">Edit Type</a></li>
    <!--<li><?= $ctype_delete_link ?></li>-->
    </ul>
    </div>
    </div>
</script> 
<script type="text/template" id="content-template-list-template">
    <ul class="content-template-list">
    </ul>
</script>

<script type="text/template" id="content-template-list-item-template">
    <div class="list-item-content">

    <i class="icon-chevron-right collapsed"></i>
    <i class="icon-chevron-down expanded"></i>
    <i class="icon-document"></i>
    
    <a href="<?= $ctempl_edit_url ?>/<%=id%>"><%=innerHtml%></a>
    <div class="btn-group pull-right list-item-actions">
    <a class="btn dropdown-toggle navigator-dropdown-toggle" data-toggle="dropdown"><i class="icon-dropmenu"></i></a>
    <ul class="dropdown-menu">
    <li><a href="<?= $ctempl_add_url ?>/<%=id%>">Add Template Here</a></li>
    <li><a href="<?= $ctempl_edit_url ?>/<%=id%>">Edit Template</a></li>
    <!--<li><?= $ctempl_delete_link ?></li>-->

    </ul>
    </div>
    </div>

</script> 

<script type="text/template" id="media-list-template">
    <ul class="media-list">
    </ul>
</script>

<script type="text/template" id="media-list-item-template">
    <div class="list-item-content">

    <i class="icon-file"></i>
    
    <a href="<?= $media_edit_url ?>/<%=id%>"><%=innerHtml%></a>
    <div class="btn-group pull-right list-item-actions">
    <a class="btn dropdown-toggle navigator-dropdown-toggle" data-toggle="dropdown"><i class="icon-dropmenu"></i></a>
    <ul class="dropdown-menu">
    
        <li><a href="<?= $media_edit_url ?>/<%=id%>">Edit Media</a></li>

    </ul>
    </div>
    </div>

</script> 

<script type="text/template" id="media-directory-list-item-template">
    <div class="list-item-content">

    <i class="icon-chevron-right collapsed"></i>
    <i class="icon-chevron-down expanded"></i>
    
    <a href="<?= $medir_edit_url ?>/<%=id%>"><%=innerHtml%></a>
    <div class="btn-group pull-right list-item-actions">
    <a class="btn dropdown-toggle navigator-dropdown-toggle" data-toggle="dropdown"><i class="icon-dropmenu"></i></a>
    <ul class="dropdown-menu">
    <li><a href="<?= $medir_add_url ?>/<%=id%>">Add Directory Here</a></li>
    <li><a href="<?= $media_add_url ?>/<%=id%>">Add Media Here</a></li>
    <li><a href="<?= $medir_edit_url ?>/<%=id%>">Edit Directory</a></li>
    <!--<li><?= $ctempl_delete_link ?></li>-->

    </ul>
    </div>
    </div>

</script> 

<script type="text/template" id="root-media-directory-list-item-template">
    <div class="list-item-content">

    <i class="icon-chevron-right collapsed"></i>
    <i class="icon-chevron-down expanded"></i>
    
    <a><%=innerHtml%></a>
    <div class="btn-group pull-right">
        <a  href="<?= $medir_add_url ?>" class="btn sidebar-add-control"><i class="icon-createfolder"></i></a>
        <a  href="<?= $media_add_url ?>" class="btn sidebar-add-control"><i class="icon-createfile"></i></a>
    </div>
    </div>

</script>

<script type="text/template" id="stylesheet-list-template">
    <ul class="stylesheet-list">
    </ul>
</script>

<script type="text/template" id="stylesheet-list-item-template">
    <div class="list-item-content">

    <i class="icon-file"></i>
    
    <a href="<?= $stylesheet_edit_url ?>/<%=id%>"><%=innerHtml%></a>
    <div class="btn-group pull-right list-item-actions">
    <a class="btn dropdown-toggle navigator-dropdown-toggle" data-toggle="dropdown"><i class="icon-dropmenu"></i></a>
    <ul class="dropdown-menu">
    
        <li><a href="<?= $stylesheet_edit_url ?>/<%=id%>">Edit Stylesheet</a></li>

    </ul>
    </div>
    </div>

</script> 

<script type="text/template" id="root-stylesheet-list-item-template">
    <div class="list-item-content">

    <i class="icon-chevron-right collapsed"></i>
    <i class="icon-chevron-down expanded"></i>
    
    <a><%=innerHtml%></a>
    <div class="btn-group pull-right">
        <a  href="<?= $stylesheet_add_url ?>" class="btn sidebar-add-control"><i class="icon-plus"></i></a>
    </div>
    </div>

</script>

<script type="text/template" id="javascript-list-template">
    <ul class="javascript-list">
    </ul>
</script>

<script type="text/template" id="javascript-list-item-template">
    <div class="list-item-content">

    <i class="icon-file"></i>
    
    <a href="<?= $javascript_edit_url ?>/<%=id%>"><%=innerHtml%></a>
    <div class="btn-group pull-right list-item-actions">
    <a class="btn dropdown-toggle navigator-dropdown-toggle" data-toggle="dropdown"><i class="icon-dropmenu"></i></a>
    <ul class="dropdown-menu">
    
        <li><a href="<?= $javascript_edit_url ?>/<%=id%>">Edit script</a></li>

    </ul>
    </div>
    </div>

</script> 

<script type="text/template" id="root-javascript-list-item-template">
    <div class="list-item-content">

    <i class="icon-chevron-right collapsed"></i>
    <i class="icon-chevron-down expanded"></i>
    
    <a><%=innerHtml%></a>
    <div class="btn-group pull-right">
        <a  href="<?= $javascript_add_url ?>" class="btn sidebar-add-control"><i class="icon-plus"></i></a>
    </div>
    </div>

</script>

<script type="text/template" id="snippet-list-template">
    <ul class="snippet-list">
    </ul>
</script>

<script type="text/template" id="snippet-list-item-template">
    <div class="list-item-content">

    <i class="icon-file"></i>
    
    <a href="<?= $snippet_edit_url ?>/<%=id%>"><%=innerHtml%></a>
    <div class="btn-group pull-right list-item-actions">
    <a class="btn dropdown-toggle navigator-dropdown-toggle" data-toggle="dropdown"><i class="icon-dropmenu"></i></a>
    <ul class="dropdown-menu">
    
        <li><a href="<?= $snippet_edit_url ?>/<%=id%>">Edit script</a></li>

    </ul>
    </div>
    </div>

</script> 

<script type="text/template" id="root-snippet-list-item-template">
    <div class="list-item-content">

    <i class="icon-chevron-right collapsed"></i>
    <i class="icon-chevron-down expanded"></i>
    
    <a><%=innerHtml%></a>
    <div class="btn-group pull-right">
        <a  href="<?= $snippet_add_url ?>" class="btn sidebar-add-control"><i class="icon-plus"></i></a>
    </div>
    </div>

</script>

<?php
$this->end();
?>