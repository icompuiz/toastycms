<?php

/*
 * This is the management section template
 */

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            Page Not Found |
            <?php echo $site_name ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('ToastyCore.bootstrap.min');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        ?>
    </head>
    <body>

        <?php
        echo $this->fetch('body');
        ?>
              
    </body>

    <?php
    
    echo $this->Html->script('ToastyCore.jquery-1.9.1.min');
    echo $this->Html->script('ToastyCore.bootstrap.min');
   
    echo $this->fetch('script');
    
    ?>

</html>