var flash = function($http, $rootScope) {

	function Alert(message, type) {

		message = message || "Success";
		type = type || "success";

		var alert = {};
		alert.message = message;
		alert.type = type;

		return alert;

	}
	function FlashService() {

		var me = this;
		me.alerts = [];

		this.Alert = Alert;
		this.addAlert = function(msg, sev, redirectFunction) {
			this.addFlashMessage(Alert(msg, sev), redirectFunction);
		}

		this.addFlashMessage = function(alert, redirectFunction) {
			me.alerts.push(alert);
			if (!redirectFunction) {
				$rootScope.$emit('onNewAlert', alert);
			} else {
				redirectFunction();
			}
		};

		this.readAlert = function() {

			return me.alerts.pop();

		}

	}
	var flashInstance = new FlashService();
	return flashInstance;

};


angular.module('toastyCMS').factory('flash', ['$http', '$rootScope', flash]);