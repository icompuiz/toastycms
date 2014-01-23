'use strict';

/* Controllers */
var DocumentTypeSelectionModalCtrl = ['$scope', '$modalInstance', '$http', function($scope, $modalInstance, $http) {

	$scope.items = [];
	$scope.selected = {
		item: $scope.items[0]
	};

	function onGetError(data) {

		console.log('Error');
	}

	function onGetSuccess(data) {

		$scope.items = data.document_types;

	}

	$scope.ok = function () {
		$modalInstance.close($scope.selected.item);
	};

	$scope.cancel = function () {
		$modalInstance.dismiss('cancel');
	};

	$http.get('/toasty_core/document_types/index.json').success(onGetSuccess).error(onGetError);

}];

var DocumentsCtrl = ['$scope', '$rootScope', '$location', '$routeParams', '$http', '$modal', 'flashService', function($scope, $rootScope, $location, $routeParams, $http, $modal, flashSvc) {

	


	function onGetError(data) {

		console.log('Error');
	}

	function onGetSuccess(data) {

		if (data.documents) {
			$scope.documents = data.documents;
		}

	}

	function createDocument () {
		$location.path("/documents/add");
	}

	$scope.createDocument = createDocument;

	$scope.documents = [];

	$scope.alerts = [];
	(function() {
		var alert = flashSvc.readAlert();
		while (alert) {
			$scope.alerts.push(alert);
			alert = flashSvc.readAlert();
		}
	})();
	$rootScope.$on('onNewAlert', function(e, alert) {
		flashSvc.readAlert();
		$scope.alerts.push(alert);
	});

	$scope.closeAlert = function(index) {
		$scope.alerts.splice(index, 1);
	}

	$http.get('/toasty_core/documents/index.json').success(onGetSuccess).error(onGetError);


}];


var DocumentEditCtrl = ['$scope', '$rootScope', '$location', '$routeParams', '$http', '$modal', 'flashService', function($scope, $rootScope, $location, $routeParams, $http, $modal, flashSvc) {
	
	$scope.document = {};
	$scope.vm = {};

	
		
	function onGetError(data) {

		flashSvc.addAlert("Error","danger");

	}

	function onGetSuccess(data) {

		if (data.document) {
			$scope.document = data.document;

			$scope.document.Document.published = parseInt($scope.document.Document.published);

			$scope.vm.documentPublished = data.document.Document.published;

			$scope.document.Document.home_page = parseInt($scope.document.Document.home_page);
		}

	}

	function onSaveSuccess(data, status) {

		if ($routeParams.documentId) {
			$scope.document = data.document;
			$scope.vm.documentPublished = data.document.Document.published;
			
			flashSvc.addAlert("The doument was saved successfully", "success");
		} else {
			var path = "/documents/edit/" + data.document.Document.id;
			flashSvc.addAlert("The doument was saved successfully", "success", function() {

				$location.path(path);
				
			});

		}

	}

	function onSaveError(data) {

		for(var error in data.errors) {

			var errors = data.errors[error];
			for(var error in errors) {

				flashSvc.addAlert(errors[error],"danger");

			}
			
		}

	}

	function onDeleteSuccess(data, status) {

		if (200 == status) {
			var path = "";
				
			path = "/documents";

			flashSvc.addAlert("The document was successfully deleted","success", function() {

				$location.path(path);

			});

		}

	}

	function onDeleteError(data) {

		flashSvc.addAlert(data.error,"danger");
	}

	function saveDocument() {

		if ($routeParams.documentId) {

			$http.put('/toasty_core/documents/edit/' + $routeParams.documentId + ".json", $scope.document).success(onSaveSuccess).error(onSaveError);

		} else {
			saveNewDocument();
		}

	}

	function saveNewDocument() {
		
		$http.post('/toasty_core/documents/add.json', $scope.document).success(onSaveSuccess).error(onSaveError);
	}

	function cancelChanges() {

		$location.path("/documents/");

	}

	function deleteDocument() {

		$http.delete('/toasty_core/documents/delete/' + $routeParams.documentId + ".json", $scope.document).success(onDeleteSuccess).error(onDeleteError);


	}

	function onDocumentTypeSelected(documentType) {

		$scope.document = {

			Document: {
				document_type_id: documentType.DocumentType.id
			},
			DocumentType: documentType

		};

	}

	function onDocumentTypeNotSelected() {

		flashSvc.addAlert("Please select a document type","danger", function() {

			$location.path("/documents");
		});


	}

	function createDocument() {

		// open modal to select for available document types
		var modalInstance = $modal.open({
	      templateUrl: '/templates/documents/modal/document_type',
	      controller: DocumentTypeSelectionModalCtrl,
	      resolve: {
	      }
	    });

	    modalInstance.result.then(onDocumentTypeSelected, onDocumentTypeNotSelected);
	    
	}

	$scope.alerts = [];
	(function() {
		var alert = flashSvc.readAlert();
		while (alert) {
			$scope.alerts.push(alert);
			alert = flashSvc.readAlert();
		}
	})();
	$rootScope.$on('onNewAlert', function(e, alert) {
		flashSvc.readAlert();
		$scope.alerts.push(alert);
	});

	$scope.closeAlert = function(index) {
		$scope.alerts.splice(index, 1);
	}

	$scope.saveDocument = saveDocument;
	$scope.saveNewDocument = saveNewDocument;
	$scope.cancelChanges = cancelChanges;
	$scope.deleteDocument = deleteDocument;


	$scope.isPublishedClass = "";
	$scope.isHomepageClass = "";
 	

    $scope.$watch('document.Document.home_page', function(newValue) {
    	if (newValue) {
    		$scope.isHomepageClass = "btn-primary";
    		$scope.isHomepageText= "Current Homepage";
    	} else {
    		$scope.isHomepageClass = "";
    		$scope.isHomepageText= "Set as homepage";

    	}
    });

    $scope.$watch('document.Document.published', function(newValue) {
    	if (newValue) {
    		$scope.isPublishedClass = "btn-primary";
    		$scope.isPublishedText = "Document Published";
    	} else {
    		$scope.isPublishedClass = "";
    		$scope.isPublishedText = "Publish this document";

    	}
    });

	if ($routeParams.documentId) {
		$http.get('/toasty_core/documents/view/' + $routeParams.documentId + '.json').success(onGetSuccess).error(onGetError);
	} else {
		createDocument();
	}


}];

angular.module('toastyCMS')
.controller('DocumentsCtrl', DocumentsCtrl)
.controller('DocumentEditCtrl', DocumentEditCtrl);
