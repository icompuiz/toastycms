<!doctype html>
<html lang="en" class="no-js">
<head>
  <meta charset="utf-8">
  <title><?php echo $site_name?></title>
  <?php
    echo $this->Html->css(array(
        'http://fonts.googleapis.com/css?family=Bree+Serif',
        'http://fonts.googleapis.com/css?family=Open+Sans',
        'http://fonts.googleapis.com/css?family=Crete+Round',
        '//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css',
        'ToastyCore.cms/components/bootstrap-switch/bootstrap-switch.min',

        'ToastyCore.cms/main',
        'ToastyCore.cms/icons'
      )
    );
    echo $this->fetch('styles');
  ?>
</head>
<body ng-app="toastyCMS" class="dark-theme">
  <div  class="site-wrapper">

  <nav class="nav navbar navbar-top navbar-inverse main-nav" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#cmsNavBar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand toasty-brand" href="#"><?php echo $site_name?></a>
    </div>
    <div class="collapse navbar-collapse pull-right" id="cmsNavBar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Dashboard</a></li>
        <li><a href="#/settings/accounts/me">Account</a></li>
        <li><a href="#/settings">Settings</a></li>
        <li><a href="/management/logout">Logout</a></li>
      </ul>
    </div>

  </nav>
  <div   ng-view>
  </div>

  <?php
    echo $this->Html->script(
      array(
        'ToastyCore.cms/lib/angular/angular.min',
        'ToastyCore.cms/lib/angular/angular-route.min',
        'ToastyCore.cms/lib/ui-bootstrap/ui-bootstrap-0.9.0.min',
        'ToastyCore.cms/lib/ui-bootstrap/ui-bootstrap-tpls-0.9.0.min',
        '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js',
        '//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js',
        'ToastyCore.cms/lib/components/bootstrap-switch/bootstrap-switch.min',
        'ToastyCore.cms/lib/components/bootstrap-switch/module',
        'ToastyCore.cms/lib/components/bootstrap-switch/bsSwitch',
        'ToastyCore.cms/app',
        'ToastyCore.cms/services/flash',
        'ToastyCore.cms/services/model',
        'ToastyCore.cms/controllers/dashboard',
        'ToastyCore.cms/controllers/documents',
        'ToastyCore.cms/controllers/document_types',
        )
    );
    echo $this->fetch('scripts');
  ?>
</body>
</html>