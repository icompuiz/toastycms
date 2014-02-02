'use strict';

// Declare app level module which depends on filters, and services
angular.module('toastyCMS', [
  'ngRoute',
  'ui.bootstrap',
  'frapontillo.bootstrap-switch'
]).
config(['$routeProvider', function($routeProvider) {

  $routeProvider

  .when(
  	'/', 
  	{
	  	templateUrl: '/templates/dashboard', 
	  	controller: 'DashboardCtrl'
  	}
  )


  .when(
  	'/documents/add/:parentId?', 
  	{
	  	templateUrl: '/templates/documents/add', 
	  	controller: 'DocumentEditCtrl'
  	}
  )

  .when(
  	'/documents/edit/:documentId', 
  	{
	  	templateUrl: '/templates/documents/edit', 
	  	controller: 'DocumentEditCtrl'
  	}
  )
  
  .when(
  	'/documents', 
  	{
	  	templateUrl: '/templates/documents/index', 
	  	controller: 'DocumentsCtrl'
  	}
  )

  .when(
  	'/document_templates', 
  	{
	  	templateUrl: '/templates/document_templates/index', 
	  	controller: 'DocumentTemplatesCtrl'
  	}
  )

  .when(
  	'/document_templates/edit/:documentTemplateId', 
  	{
	  	templateUrl: '/templates/document_templates/edit', 
	  	controller: 'DocumentTemplatesCtrl'
  	}
  )

  .when(
  	'/document_types', 
  	{
	  	templateUrl: '/templates/document_types/index', 
	  	controller: 'DocumentTypesCtrl'
  	}
  )

  .when(
  	'/document_types/edit/:documentTypeId', 
  	{
	  	templateUrl: '/templates/document_types/edit', 
	  	controller: 'DocumentTypeEditCtrl'
  	})
  ;

}]);