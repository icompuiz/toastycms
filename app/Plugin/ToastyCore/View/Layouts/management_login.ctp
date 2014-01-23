<?php

/*
 * This is the management section template
 */

/* here any initial configuration and variables will be set */
$description = 'Site Management';


$viewSiteLink = $this->Html->link("View Site", "/");
$brand = $this->Html->link($site_name, "/", array('class' => 'brand'));

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
        echo $this->Html->css('ToastyCore.management_login');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        ?>
    </head>
    <body>

        <header id="management-header">
            <div id="site-nav" class="navbar  navbar-inverse navbar-static-top">
                <div class="navbar-inner">
                    <?=$brand?>
                    
                    <ul class="nav pull-right">
                      <li><?=$viewSiteLink?></li>
                    </ul>
                </div>
            </div>
            
        </header>
        <section id="management-content" class="container">
            <div class="row">
                <div id="management-right" class="span5">
                <?php echo $this->fetch('management-flash'); ?>
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
    
    echo $this->Html->script('ToastyCore.jquery-1.9.1.min');
    echo $this->Html->script('ToastyCore.bootstrap.min');
    echo $this->Html->script('ToastyCore.underscore-min');
    echo $this->Html->script('ToastyCore.backbone');
    echo $this->Html->script('ToastyCore.handlebars');
   
    echo $this->fetch('script');
    
    ?>

</html>