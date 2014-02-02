'use strict';

/* Controllers */
var ConfirmationModalCtrl = ['$scope', '$modalInstance', '$http', 'model',
    function($scope, $modalInstance, $http, model) {

        $scope.ok = function() {
            $modalInstance.close();
        };

        $scope.cancel = function() {
            $modalInstance.dismiss('cancel');
        };


    }
];

var DocumentTypeSelectionModalCtrl = ['$scope', '$modalInstance', '$http', 'model', 'currentDocumentType',
    function($scope, $modalInstance, $http, model, currentDocumentType) {

        $scope.items = [];
        $scope.currentDocumentType = currentDocumentType;
        $scope.selected = {
            item: $scope.items[0]
        };

        function onGetError(data) {

            console.log('Error');
        }

        function onGetSuccess(data) {

            $scope.items = data.document_types;

        }

        $scope.ok = function() {
            $modalInstance.close($scope.selected.item);
        };

        $scope.cancel = function() {
            $modalInstance.dismiss('cancel');
        };

        $http.get('/toasty_core/document_types/index.json').success(onGetSuccess).error(onGetError);

    }
];

var DocumentSelectionModalCtrl = ['$scope', '$modalInstance', '$http', 'model', 'currentDocument',
    function($scope, $modalInstance, $http, model, currentDocument) {

        $scope.items = [];
        $scope.currentDocument = currentDocument;
        $scope.selected = {
            item: currentDocument.parent
        };

        function onGetError(data) {

            console.log('Error');
        }

        function onGetSuccess(data) {

            $scope.document = data.document;
            $scope.selected.item = data.document;

        }

        function onGetIndexSuccess(data) {
            $scope.document = {
                children: data.documents
            };
            $scope.selected.item = data.documents[0];
        }

        $scope.ok = function() {
            $modalInstance.close($scope.selected.item);
        };

        $scope.cancel = function() {
            $modalInstance.dismiss('cancel');
        };

        function changeDocument(documentId) {

            if (documentId) {

                $http.get('/toasty_core/documents/view/' + documentId + '.json').success(onGetSuccess).error(onGetError);
            } else {
                
                $http.get('/toasty_core/documents/index.json').success(onGetIndexSuccess).error(onGetError);
            }

        }

        function selectNone(i) {
            $scope.selected.item = $scope.document;
        }

        $scope.changeDocument = changeDocument;
        $scope.selectNone = selectNone;

        if (currentDocument.parent) {

            changeDocument(currentDocument.parent.Document.id);
        } else {
            changeDocument();
        }



    }
];

var DocumentsCtrl = ['$scope', '$rootScope', '$location', '$routeParams', '$http', '$modal', 'flash', 'model',
    function($scope, $rootScope, $location, $routeParams, $http, $modal, flash, model) {

        function onGetError(data) {

            console.log('Error');
        }

        function onGetSuccess(data) {

            if (data.documents) {
                $scope.documents = data.documents;
            }

        }

        function createDocument() {
            $location.path("/documents/add");
        }

        $scope.createDocument = createDocument;

        $scope.documents = [];

        $scope.alerts = [];
        (function() {
            var alert = flash.readAlert();
            while (alert) {
                $scope.alerts.push(alert);
                alert = flash.readAlert();
            }
        })();
        $rootScope.$on('onNewAlert', function(e, alert) {
            flash.readAlert();
            $scope.alerts.push(alert);
        });

        $scope.closeAlert = function(index) {
            $scope.alerts.splice(index, 1);
        }

        $http.get('/toasty_core/documents/index.json').success(onGetSuccess).error(onGetError);

    }
];


var DocumentEditCtrl = ['$scope', '$rootScope', '$location', '$routeParams', '$http', '$modal', 'flash', 'model',
    function($scope, $rootScope, $location, $routeParams, $http, $modal, flash, model) {

        $scope.document = {};
        $scope.vm = {};



        function onGetError(data) {

            flash.addAlert("Error", "danger");

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

                flash.addAlert("The doument was saved successfully", "success");
            } else {
                var path = "/documents/edit/" + data.document.Document.id;
                flash.addAlert("The doument was saved successfully", "success", function() {

                    $location.path(path);

                });

            }

        }

        function onSaveError(data) {

            for (var error in data.errors) {

                var errors = data.errors[error];
                for (var error in errors) {

                    flash.addAlert(errors[error], "danger");

                }

            }

        }

        function onDeleteSuccess(data, status) {

            if (200 == status) {
                var path = "";

                path = "/documents";

                flash.addAlert("The document was successfully deleted", "success", function() {

                    $location.path(path);

                });

            }

        }

        function onDeleteError(data) {

            flash.addAlert(data.error, "danger");
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

        function formDirty() {
            return $scope.cmsForm.documentName.$dirty ||
                $scope.cmsForm.documentAlias.$dirty ||
                $scope.cmsForm.documentPublished.$dirty ||
                $scope.cmsForm.documentIsHomepage.$dirty;
        }

        function cancelChanges() {

            function callback() {

                $location.path("/documents/");
            }
            if (formDirty()) {
                confirmCancel(callback)
            } else {
                callback();
            }


        }

        function confirmDelete(onOkay, onCancel) {

            var modalInstance = $modal.open({
                templateUrl: '/templates/documents/modal/confirm_delete',
                controller: ConfirmationModalCtrl,
                resolve: {

                }
            });

            modalInstance.result.then(onOkay, onCancel);

        }

        function confirmCancel(onOkay, onCancel) {

            var modalInstance = $modal.open({
                templateUrl: '/templates/documents/modal/confirm_cancel',
                controller: ConfirmationModalCtrl,
                resolve: {}
            });

            modalInstance.result.then(onOkay, onCancel);

        }

        function deleteDocument() {

            function callback() {

                $http.delete('/toasty_core/documents/delete/' + $routeParams.documentId + ".json", $scope.document).success(onDeleteSuccess).error(onDeleteError);

            }

            confirmDelete(callback)



        }

        function onGetParentSuccess(data) {

            var parentDocument = data.document;
            console.log(parentDocument);

            if (!$scope.document.Document) {
                $scope.document.Document = {};
            }

            $scope.document.parent = parentDocument;
            $scope.document.Document.parent_id = parentDocument.Document.id;
            $scope.document.Document.document_type_id = parentDocument.Document.document_type_id;
            $scope.document.DocumentType = parentDocument.DocumentType;

        }

        function onGetParentError(error, status) {

            flash.addAlert('There was an error retrieving the parent document. Error: ' + status, 'danger');

            getDocumentType();

        }

        function getDocument(id, success, error) {

            $http.get('/toasty_core/documents/view/' + id + '.json').success(success).error(error);
        }

        function onDocumentTypeSelected(documentType) {

            setDocumentType(documentType);

            function setDocumentType(documentType) {

                if (!$scope.document.Document) {
                    $scope.document.Document = {};
                }

                $scope.document.Document.document_type_id = documentType.DocumentType.id;
                $scope.document.DocumentType = documentType;

            }


        }

        function onDocumentParentSelected(documentParent) {

            setDocumentParent(documentParent);

            function setDocumentParent(documentParent) {

                if (!$scope.document.Document) {
                    $scope.document.Document = {};
                }

                $scope.document.Document.parent_id = documentParent.Document.id;
                $scope.document.parent = documentParent;

            }

        }

        function onDocumentParentNotSelected() {

        }

        function onDocumentTypeNotSelected() {

            flash.addAlert("Please select a document type", "danger", function() {

                $location.path("/documents");
            });


        }

        function getDocumentType(dontRedirect) {

            var modalInstance = $modal.open({
                templateUrl: '/templates/documents/modal/document_type',
                controller: DocumentTypeSelectionModalCtrl,
                resolve: {
                    currentDocumentType: function() {
                        return $scope.document.DocumentType;
                    }
                }
            });
            modalInstance.result.then(onDocumentTypeSelected, dontRedirect || onDocumentTypeNotSelected);

        }

        function getDocumentParent() {
            var modalInstance = $modal.open({
                templateUrl: '/templates/documents/modal/document',
                controller: DocumentSelectionModalCtrl,
                resolve: {
                    currentDocument: function() {
                        return $scope.document;
                    }
                }
            });
            modalInstance.result.then(onDocumentParentSelected);
        }

        function createDocument() {

            // open modal to select for available document types

            if ($routeParams.parentId) {

                getDocument($routeParams.parentId, onGetParentSuccess, onGetParentError);

            } else {

                getDocumentType();


            }

        }

        $scope.alerts = [];
        (function() {
            var alert = flash.readAlert();
            while (alert) {
                $scope.alerts.push(alert);
                alert = flash.readAlert();
            }
        })();
        $rootScope.$on('onNewAlert', function(e, alert) {
            flash.readAlert();
            $scope.alerts.push(alert);
        });

        $scope.closeAlert = function(index) {
            $scope.alerts.splice(index, 1);
        }

        $scope.saveDocument = saveDocument;
        $scope.saveNewDocument = saveNewDocument;
        $scope.cancelChanges = cancelChanges;
        $scope.deleteDocument = deleteDocument;
        $scope.getDocumentType = getDocumentType;
        $scope.getDocumentParent = getDocumentParent;


        $scope.isPublishedClass = "";
        $scope.isHomepageClass = "";


        $scope.$watch('document.Document.home_page', function(newValue) {
            if (newValue) {
                $scope.isHomepageClass = "btn-primary";
                $scope.isHomepageText = "Current Homepage";
            } else {
                $scope.isHomepageClass = "";
                $scope.isHomepageText = "Set as homepage";

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


    }
];

angular.module('toastyCMS')
    .controller('DocumentsCtrl', DocumentsCtrl)
    .controller('DocumentEditCtrl', DocumentEditCtrl)
    .controller('ConfirmationModalCtrl', ConfirmationModalCtrl)
    .controller('DocumentTypeSelectionModalCtrl', DocumentTypeSelectionModalCtrl)
    .controller('DocumentSelectionModalCtrl', DocumentSelectionModalCtrl);
