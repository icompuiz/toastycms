<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Router::resourceMap(array(
    array('controller' =>'contents' ,'action' => 'management_index', 'method' => 'GET', 'id' => false),
    array('controller' =>'contents' ,'action' => 'management_view', 'method' => 'GET', 'id' => true),
    array('controller' =>'contents' ,'action' => 'management_add', 'method' => 'POST', 'id' => false),
    array('controller' =>'contents' ,'action' => 'management_edit', 'method' => 'PUT', 'id' => true),
    array('controller' =>'contents' ,'action' => 'management_delete', 'method' => 'DELETE', 'id' => true),
    array('controller' =>'contents' ,'action' => 'management_update', 'method' => 'POST', 'id' => true),
    
    array('controller' =>'content_types' ,'action' => 'management_index', 'method' => 'GET', 'id' => false),
    array('controller' =>'content_types' ,'action' => 'management_view', 'method' => 'GET', 'id' => true),
    array('controller' =>'content_types' ,'action' => 'management_add', 'method' => 'POST', 'id' => false),
    array('controller' =>'content_types' ,'action' => 'management_edit', 'method' => 'PUT', 'id' => true),
    array('controller' =>'content_types' ,'action' => 'management_delete', 'method' => 'DELETE', 'id' => true),
    array('controller' =>'content_types' ,'action' => 'management_update', 'method' => 'POST', 'id' => true),
    
    array('controller' =>'content_type_property_skels' ,'action' => 'management_index', 'method' => 'GET', 'id' => false),
    array('controller' =>'content_type_property_skels' ,'action' => 'management_view', 'method' => 'GET', 'id' => true),
    array('controller' =>'content_type_property_skels' ,'action' => 'management_add', 'method' => 'POST', 'id' => false),
    array('controller' =>'content_type_property_skels' ,'action' => 'management_edit', 'method' => 'PUT', 'id' => true),
    array('controller' =>'content_type_property_skels' ,'action' => 'management_delete', 'method' => 'DELETE', 'id' => true),
    array('controller' =>'content_type_property_skels' ,'action' => 'management_update', 'method' => 'POST', 'id' => true),
    
    array('controller' =>'content_templates' ,'action' => 'management_index', 'method' => 'GET', 'id' => false),
    array('controller' =>'content_templates' ,'action' => 'management_view', 'method' => 'GET', 'id' => true),
    array('controller' =>'content_templates' ,'action' => 'management_add', 'method' => 'POST', 'id' => false),
    array('controller' =>'content_templates' ,'action' => 'management_edit', 'method' => 'PUT', 'id' => true),
    array('controller' =>'content_templates' ,'action' => 'management_delete', 'method' => 'DELETE', 'id' => true),
    array('controller' =>'content_templates' ,'action' => 'management_update', 'method' => 'POST', 'id' => true),

    array('controller' =>'groups' ,'action' => 'management_index', 'method' => 'GET', 'id' => false),
    array('controller' =>'groups' ,'action' => 'management_view', 'method' => 'GET', 'id' => true),
    array('controller' =>'groups' ,'action' => 'management_add', 'method' => 'POST', 'id' => false),
    array('controller' =>'groups' ,'action' => 'management_edit', 'method' => 'PUT', 'id' => true),
    array('controller' =>'groups' ,'action' => 'management_delete', 'method' => 'DELETE', 'id' => true),
    array('controller' =>'groups' ,'action' => 'management_update', 'method' => 'POST', 'id' => true),

    array('controller' =>'media_directories' ,'action' => 'management_index', 'method' => 'GET', 'id' => false),
    array('controller' =>'media_directories' ,'action' => 'management_view', 'method' => 'GET', 'id' => true),
    array('controller' =>'media_directories' ,'action' => 'management_add', 'method' => 'POST', 'id' => false),
    array('controller' =>'media_directories' ,'action' => 'management_edit', 'method' => 'PUT', 'id' => true),
    array('controller' =>'media_directories' ,'action' => 'management_delete', 'method' => 'DELETE', 'id' => true),
    array('controller' =>'media_directories' ,'action' => 'management_update', 'method' => 'POST', 'id' => true),

    array('controller' =>'stylesheets' ,'action' => 'management_index', 'method' => 'GET', 'id' => false),
    array('controller' =>'stylesheets' ,'action' => 'management_view', 'method' => 'GET', 'id' => true),
    array('controller' =>'stylesheets' ,'action' => 'management_add', 'method' => 'POST', 'id' => false),
    array('controller' =>'stylesheets' ,'action' => 'management_edit', 'method' => 'PUT', 'id' => true),
    array('controller' =>'stylesheets' ,'action' => 'management_delete', 'method' => 'DELETE', 'id' => true),
    array('controller' =>'stylesheets' ,'action' => 'management_update', 'method' => 'POST', 'id' => true),

    array('controller' =>'javascripts' ,'action' => 'management_index', 'method' => 'GET', 'id' => false),
    array('controller' =>'javascripts' ,'action' => 'management_view', 'method' => 'GET', 'id' => true),
    array('controller' =>'javascripts' ,'action' => 'management_add', 'method' => 'POST', 'id' => false),
    array('controller' =>'javascripts' ,'action' => 'management_edit', 'method' => 'PUT', 'id' => true),
    array('controller' =>'javascripts' ,'action' => 'management_delete', 'method' => 'DELETE', 'id' => true),
    array('controller' =>'javascripts' ,'action' => 'management_update', 'method' => 'POST', 'id' => true),

    array('controller' =>'snippets' ,'action' => 'management_index', 'method' => 'GET', 'id' => false),
    array('controller' =>'snippets' ,'action' => 'management_view', 'method' => 'GET', 'id' => true),
));

Router::mapResources('contents');
Router::mapResources('content_types');
Router::mapResources('content_type_property_skels');
Router::mapResources('content_templates');
Router::parseExtensions();

Router::connect(
    "/", 
    array("controller" => "contents", "action" => "home", "plugin" => "toasty_core", "management" => false)
);

Router::connect(
    "/management", 
    array("controller" => "dashboard", "action" => "index", "plugin" => "toasty_core", "management" => true)
);

Router::connect(
    "/management/contents", 
    array("controller" => "contents", "action" => "index", "plugin" => "toasty_core", "management" => true)
);

Router::connect(
    "/management/accounts", 
    array("controller" => "accounts", "action" => "index", "plugin" => "toasty_core", "management" => true)
);
Router::connect(
    "/management/users/:action/*", 
    array("controller" => "users", "plugin" => "toasty_core", "management" => true)
);

Router::connect(
    "/management/login", 
    array("controller" => "users", 'action' => 'login', "plugin" => "toasty_core", "management" => true)
);

Router::connect(
    "/management/logout", 
    array("controller" => "users", 'action' => 'logout', "plugin" => "toasty_core", "management" => true)
);
// Router::connect(
//     '/content/*',
//     array('controller' => 'contents', 'action' => 'view', 'plugin' => 'toasty_core')
// );

Router::connect(
    '/content/**',
    array('controller' => 'contents', 'action' => 'view', 'plugin' => 'toasty_core')
);

Router::connect(
    '/templates/**',
    array('controller' => 'main', 'action' => 'templates', 'plugin' => 'toasty_core')
)

?>
