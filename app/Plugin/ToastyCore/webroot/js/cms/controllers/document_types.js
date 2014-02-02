function makeid(len) {
    len = len || 5;
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < len; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

var DocumentTypesCtrl = ['$scope', '$rootScope', '$location', '$routeParams', '$http', '$modal', 'flash', 'model',
    function($scope, $rootScope, $location, $routeParams, $http, $modal, flash, model) {

        function onGetError(data) {

            console.log('Error');
        }

        function onGetSuccess(data) {

            if (data.document_types) {
                $scope.document_types = data.document_types;
            }

        }

        $scope.document_types = [];

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

        $http.get('/toasty_core/document_types/index.json').success(onGetSuccess).error(onGetError);

    }
];

var DocumentTypeEditCtrl = ['$scope', '$rootScope', '$location', '$routeParams', '$http', '$modal', 'flash', 'model',
    function($scope, $rootScope, $location, $routeParams, $http, $modal, flash, model) {

        function onGetError(data) {

            flash.addAlert("Error", "danger");

        }

        function onGetSuccess(data) {

            if (data.document_type) {

                $scope.documentType = data.document_type;

            }

        }

        function onSaveSuccess(data, status) {

            if ($routeParams.documentTypeId) {
                $scope.documentType = data.document_type;

                flash.addAlert("The type was saved successfully", "success");
            } else {
                var path = "/document_types/edit/" + data.document_type.DocumentType.id;
                flash.addAlert("The type was saved successfully", "success", function() {

                    $location.path(path);

                });

            }

        }

        function onSaveError(data, status) {


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

                path = "/document_types";

                flash.addAlert("The type was successfully deleted", "success", function() {

                    $location.path(path);

                });

            }

        }

        function onDeleteError(data, status) {

            flash.addAlert(data.error, "danger");


        }

        function removeProperty(index) {

            var property = $scope.documentType.DocumentTypeProperty[index];

            $scope.documentType.DocumentTypeProperty.splice(index, 1);

            if (property.id) {

                if (!$scope.documentType.deletedProperties) {
                    $scope.documentType.deletedProperties = [];
                }

                $scope.documentType.deletedProperties.push(property);

            }



        }

        function addProperty() {

            // open define property modal

            if (!$scope.documentType.DocumentTypeProperty) {
                $scope.documentType.DocumentTypeProperty = [];
            }

            $scope.documentType.DocumentTypeProperty.push({
                name: "Property " + makeid(5),
                input_format_id: 0,
                document_type_id: $routeParams.documentTypeId
            });

        }

        function saveType() {

            if ($routeParams.documentTypeId) {

                $http.put('/toasty_core/document_types/edit/' + $routeParams.documentTypeId + ".json", $scope.documentType).success(onSaveSuccess).error(onSaveError);

            } else {

                saveNewDocumentType();

            }

        }

        function saveNewDocumentType() {

            $http.post('/toasty_core/document_types/add.json', $scope.documentType).success(onSaveSuccess).error(onSaveError);

        }

        function formDirty() {
            return $scope.cmsForm.$dirty; // <-- hidden field
        }


        function confirmCancel(onOkay, onCancel) {

            var modalInstance = $modal.open({
                templateUrl: '/templates/documents/modal/confirm_cancel',
                controller: ConfirmationModalCtrl,
                resolve: {}
            });

            modalInstance.result.then(onOkay, onCancel);

        }

        function cancelChanges() {

            function callback() {

                $location.path("/document_types/");
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
                resolve: {}
            });

            modalInstance.result.then(onOkay, onCancel);

        }

        function deleteType() {

            // confirm, delete, and redirect
            function callback() {

                $http.delete('/toasty_core/document_types/delete/' + $routeParams.documentTypeId + ".json", $scope.documentType).success(onDeleteSuccess).error(onDeleteError);

            }

            confirmDelete(callback);

        }

        $scope.addProperty = addProperty;
        $scope.saveType = saveType;
        $scope.cancelChanges = cancelChanges;
        $scope.deleteType = deleteType;
        $scope.removeProperty = removeProperty;

        $scope.vm = {
            properties: {
                inputFormats: [{
                    id: 1,
                    name: 'string'
                }, {
                    id: 2,
                    name: 'number'
                }, {
                    id: 3,
                    name: 'richtext'
                }, {
                    id: 4,
                    name: 'plaintext'
                }, {
                    id: 5,
                    name: 'image'
                }, {
                    id: 6,
                    name: 'file'
                }],
                outputFormats: [{
                    id: 1,
                    name: 'string'
                }, {
                    id: 2,
                    name: 'number'
                }, {
                    id: 3,
                    name: 'richtext'
                }, {
                    id: 4,
                    name: 'plaintext'
                }, {
                    id: 5,
                    name: 'image'
                }, {
                    id: 6,
                    name: 'file'
                }]
            }
        };


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


        if ($routeParams.documentTypeId) {
            $http.get('/toasty_core/document_types/view/' + $routeParams.documentTypeId + '.json').success(onGetSuccess).error(onGetError);
        } else {
            createType();
        }
    }
];

angular.module('toastyCMS')
    .controller('DocumentTypesCtrl', DocumentTypesCtrl)
    .controller('DocumentTypeEditCtrl', DocumentTypeEditCtrl);

angular.module('toastyCMS').filter('alphanumeric', function() {
    return function(text) {
        return text.replace(/\W/g, '_');
    }
});
