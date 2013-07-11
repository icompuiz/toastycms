function bindEvents() {

	var formChanged = false;
	$(".contentForm").change(function() {
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

	bindEvents();

});