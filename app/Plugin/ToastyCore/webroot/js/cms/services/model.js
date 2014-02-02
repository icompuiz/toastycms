function Documents($http, $rootScope) {

    return {
        get: function(id, data, success, error) {

        	$http.get('' + id + '.json', data).success(success).error(error);

        },
        post: function(id, data, success, error) {

        	$http.post('' + id + '.json', data).success(success).error(error);

        },
        put: function(id, data, success, error) {

        	$http.put('' + id + '.json', data).success(success).error(error);

        },
        delete: function(id, data, success, error) {

        	$http.delete('' + id + '.json', data).success(success).error(error);

        }
    };

}

function DocumentTypes($http, $rootScope) {

    return {
        get: function(id, data, success, error) {

        	$http.get('' + id + '.json', data).success(success).error(error);

        },
        post: function(id, data, success, error) {

        	$http.post('' + id + '.json', data).success(success).error(error);

        },
        put: function(id, data, success, error) {

        	$http.put('' + id + '.json', data).success(success).error(error);

        },
        delete: function(id, data, success, error) {

        	$http.delete('' + id + '.json', data).success(success).error(error);

        }
    };

}

function DocumentTemplates($http, $rootScope) {

    return {
        get: function(id, data, success, error) {

        	$http.get('' + id + '.json', data).success(success).error(error);

        },
        post: function(id, data, success, error) {

        	$http.post('' + id + '.json', data).success(success).error(error);

        },
        put: function(id, data, success, error) {

        	$http.put('' + id + '.json', data).success(success).error(error);

        },
        delete: function(id, data, success, error) {

        	$http.delete('' + id + '.json', data).success(success).error(error);

        }
    };

}

function Model($http, $rootScope) {

    return {
        documents: Documents($http, $rootScope),
        documentTypes: DocumentTypes($http, $rootScope),
        documentTemplates: DocumentTemplates($http, $rootScope)
    };

}

angular.module('toastyCMS')
    .factory('model', ['$http', '$rootScope', Model])
    .factory('documents', ['$http', '$rootScope', Documents])
    .factory('documentTypes', ['$http', '$rootScope', DocumentTypes])
    .factory('documentTemplates', ['$http', '$rootScope', DocumentTemplates]);
