function bindEvents() {

	$(".change-password").click(function(e) {
		
		e.preventDefault();

		var pflag = $("#password_flag");

		var current_value = pflag.val();
		var newValue = '1' === current_value? '0' : '1';
		pflag.val(newValue);

		if ('1' === newValue) {
			$("#user-password_confirmation").fadeIn();
			$("#UserPassword").removeAttr("disabled");
		} else {
			$("#UserPasswordConfirmation").val('');
			$("#UserPassword").attr("disabled", "disabled");
			$("#user-password_confirmation").fadeOut();
			
		}

		console.log(pflag.val());
	});
	
	var formChanged = false;
	$(".userForm").change(function() {
		formChanged = true;
	});
	$(".link").click(function(e) {

		if (formChanged) {
			e.preventDefault();
			var href = $(this).attr("href");
			var message = "Changes have not been saved, are you sure you want to leave this page?";
			var ok = confirm(message);
			if (ok) {
				window.location = href;
			}
		}

	});
}



$(document).ready(function() {

	var val = $("#UserPassword").val();

	if ( '' !== val) {

		$("#password_flag").val('1');
		$("#UserPassword").removeAttr("disabled");
		$("#user-password_confirmation").fadeIn();


	}

	bindEvents();



});