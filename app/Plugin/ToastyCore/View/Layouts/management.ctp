<?php

/*
 * This is the management section template
 */

/* here any initial configuration and variables will be set */
$description = 'Site Management';

$dashboardLink = $this->Html->link("Dashboard", array('controller' => 'dashboard', 'action' => 'index', 'management' => true));
$contentLink = $this->Html->link("Manage Content", array('controller' => 'contents', 'action' => 'index', 'management' => true));
$contentTypeLink = $this->Html->link("Content Types", array('controller' => 'content_types', 'action' => 'index', 'management' => true));
$contentTemplateLink = $this->Html->link("Content Templates", array('controller' => 'content_templates', 'action' => 'index', 'management' => true));
$accountsLink = $this->Html->link("Manage Accounts", array('controller' => 'accounts', 'action' => 'index', 'management' => true));
$loginLink = $this->Html->link("Login", array('controller' => 'users', 'action' => 'login', 'management' => true));
$logoutLink = $this->Html->link("Logout", array('controller' => 'users', 'action' => 'logout', 'management' => true));
$authLink = $loginLink;

$siteLink = $this->Html->link($site_name, "/", array('class' => 'brand', 'target' => '_blank'));

$settingsLink = $this->Html->link("Settings", array('controller' => 'settings', 'action' => 'index', 'management' => true));

if ( $sessionActive ) {
    $authLink = $logoutLink;

    $userLinkArray = array('controller' => 'users', 'action' => 'edit', $current_user['id'], 'management' => true);
    $meLink = $this->Html->link('My Profile', $userLinkArray);
    $userLink = $this->Html->link($current_user['username'], $userLinkArray);
}



?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $title_for_layout; ?> |
            <?php echo $site_name ?> |
            <?php echo $description ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('ToastyCore.bootstrap.min');
        echo $this->Html->css('ToastyCore.whhg');
        echo $this->Html->css('ToastyCore.management');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        ?>
    </head>
    <body>

        <header id="management-header">
            <div id="site-nav" class="navbar  navbar-inverse navbar-static-top">
                <div class="navbar-inner">
                    <?=$siteLink?>
                    <ul class="nav pull-right">
                        <?php if ( $sessionActive ) { ?>
                        
                        <li><?=$userLink?></li>

                        <?php } ?>

                        <li><?=$authLink?></li>
                    </ul>
                </div>
            </div>
            <nav id="management-nav" class="navbar navbar-static-top">
                <div class="navbar-inner">
                    <ul class="nav">
                        <li>
                            <?=$dashboardLink?>
                        </li>
                        <li class="divider-vertical"></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                Content
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><?=$contentLink?></li>
                            </ul>
                        </li>                        
                        <li class="divider-vertical"></li>
                        <li class="dropdown">
                            <a href="#"  class="dropdown-toggle" data-toggle="dropdown">
                                Site
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><?=$settingsLink?></li>
                                <li class="dropdown-submenu">
                                    <a href="#"  class="dropdown-toggle" data-toggle="dropdown">
                                        Accounts
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><?=$meLink?></li>
                                        <li><?=$accountsLink?></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="divider-vertical"></li>
                        <li><a href="#">Help</a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <section id="management-content" class="container">
            <?php echo $this->fetch('management-flash'); ?>
            <div class="row">
                <div id="management-left" class="span4">
                    <?php
                    echo $this->fetch('management-left');
                    ?>
                </div>
                <div id="management-right" class="span8">
                    <?php
                    echo $this->fetch('management-right');
                    ?>
                </div>
            </div>

        </section>
        <footer id="management-footer">

        </footer>

    </body>

    <?php
    echo $this->fetch('sidebar-list-templates');
    
    echo $this->Html->script('ToastyCore.jquery-1.9.1.min');
    echo $this->Html->script('ToastyCore.bootstrap.min');
    echo $this->Html->script('ToastyCore.underscore-min');
    echo $this->Html->script('ToastyCore.backbone');
    echo $this->Html->script('ToastyCore.handlebars');
    echo $this->Html->scriptBlock("
        
        var ToastyCore = {
            Model: {},
            View: {},
            Global: {
                siteBaseUrl:  '$siteBaseUrl',
                cmsRoot:  '$cmsRoot',
                coreRoot:  '$coreRoot',
                prefix:  '$prefix',
                coreUrl: '$siteBaseUrl$prefix/$coreRoot'
            }
        };
        
    ");
    echo $this->fetch('script');
    
    ?>

</html>