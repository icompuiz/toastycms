<?php
$this->start('management-flash');
echo $this->Session->flash('flash', array('element' => 'ToastyCore.content_error'));
$this->end();

$this->start('management-left');

$group_edit_url = Router::url(array('controller' => 'groups', 'action' => 'edit', 'management' => true));
$group_add_url = Router::url(array('controller' => 'groups', 'action' => 'add', 'management' => true));
$user_edit_url = Router::url(array('controller' => 'users', 'action' => 'edit', 'management' => true));
$user_add_url = Router::url(array('controller' => 'users', 'action' => 'add', 'management' => true));



$settings_link = $this->Html->link("Settings", 
    array('controller' => 'settings', 'action' => 'index', 'management' => true)
);


?>
<ul class="nav nav-pills nav-stacked" id="settingsReturn">
  <li class="">
    <?=$settings_link?>
  </li>
</ul>
<div class="clearfix"></div>
<div id="account-navigator" class="navigator tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a id="content_tab_tab" href="#accounts_tab" data-toggle="tab">Accounts</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active well" id="accounts_tab">
            <hr>
            <div class="sidebar-header">
                <div class="btn-group pull-right">
                    <a  href="<?= $group_add_url ?>" title="Add a new group" class="btn sidebar-add-control"><i class="icon-plus"></i></a>
                </div>
                <p class="muted">
                    Groups
                </p>

            </div>

            <div id="group-list" class="tlist">
            </div>

            <hr>
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
echo $this->Html->script('ToastyCore.sidebar/account_navigator');

echo $this->Html->scriptBlock("
    var groups = new ToastyCore.Model.GroupCollection();
    var groupList = new ToastyCore.View.GroupList({
        el: $('#group-list'),
        model: groups
    });
    groups.fetch();
");

$this->end();

$this->start('sidebar-list-templates');
?>
<script type="text/template" id="group-list-template">
    <ul class="group-list">
    </ul>
</script>

<script type="text/template" id="group-list-item-template">
    <div class="list-item-content">

    <i class="icon-chevron-right collapsed"></i>
    <i class="icon-chevron-down expanded"></i>
    <i class="icon-groups-friends"></i>

    <a href="<?= $group_edit_url ?>/<%=id%>"><%=innerHtml%></a>
    <div class="btn-group pull-right  list-item-actions">
    <a class="btn dropdown-toggle navigator-dropdown-toggle" data-toggle="dropdown"><i class="icon-dropmenu"></i></a>
    <ul class="dropdown-menu">
    <li><a href="<?= $user_add_url ?>/<%=id%>">Add User</a></li>
    <li><a href="<?= $group_edit_url ?>/<%=id%>">Edit Group</a></li>

    </ul>
    </div>
    </div>
</script>

<script type="text/template" id="user-list-template">
    <ul class="user-list">
    </ul>
</script>

<script type="text/template" id="user-list-item-template">
    <div class="list-item-content no-collapse">
    <i class="icon-user"></i>

    <a href="<?= $user_edit_url ?>/<%=id%>"><%=innerHtml%></a>
    <div class="btn-group pull-right  list-item-actions">
    <a class="btn dropdown-toggle navigator-dropdown-toggle" data-toggle="dropdown"><i class="icon-dropmenu"></i></a>
    <ul class="dropdown-menu">
    <li><a href="<?= $user_edit_url ?>/<%=id%>">Edit User</a></li>
    <!--<li><?= $user_delete_link ?></li>-->

    </ul>
    </div>
    </div>
</script> 

<?php

$this->end();

?>