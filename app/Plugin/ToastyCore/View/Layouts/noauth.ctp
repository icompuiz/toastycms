<?php

/*
 * This is the management section template
 */

/* here any initial configuration and variables will be set */
$description = 'Site Management';
$site_name = "&lt;site name here&gt;";


$viewSiteLink = $this->Html->link("View Site", "/toasty_core/site");

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

        

    </body>



</html>