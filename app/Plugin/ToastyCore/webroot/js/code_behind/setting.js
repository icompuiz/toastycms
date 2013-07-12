var init_modal = function() {

    $("#add-setting-modal").modal({show: false});
    $("#add-setting-modal").data('modal').mode = null;
    $(".edit-setting").click(editSetting);
    $(".delete-setting").click(deleteSetting);

    $("#add-setting-btn").click(function(ev) {

    	$("#ManagementSettingId").remove();

        ev.preventDefault();

    	$("#add-setting-modal").data('modal').mode = 'add';

        $("#add-setting-modal input").val("");

    	$("#setting_name").removeAttr('disabled');

        $("#add-setting-modal").modal('show');



    });

    $('#setting_name, #setting_value').keydown(function (e){
        if(e.keyCode === 13){
            e.preventDefault();
            $("#add-setting-modal .save").click();
        }
    });

    $("#add-setting-modal .save").click(function() {


		var settingForm = $(".setting-form");

    	var editUrl = $("#edit-url-template").html(),
    		addUrl = settingForm.attr('action'),
    		deleteUrl = $("#delete-url-template").html()
    		actionUrl = addUrl;


		var identifier = $("#ManagementSettingId").val();

		if (undefined !== identifier) {
		
			var mode = $("#add-setting-modal").data('modal').mode;
	
			switch (mode) {
				case "edit":
					actionUrl = editUrl;
				break;
				case "delete":
					actionUrl = deleteUrl;
				break;
			}
	
			var source = actionUrl;
	        var template = Handlebars.compile(source);
	
	        var context = {
	            id: identifier
	        };
	
	        var newUrl = template(context).trim();

	        actionUrl = newUrl;
	
	
			settingForm.attr('action', actionUrl);
		}

    	settingForm.submit();

    });

    function deleteSetting(ev) {

    	$("#ManagementSettingId").remove();

        var identifier = $(this).attr("setting");

        var source = $("#id-form-element-template").html();
        var template = Handlebars.compile(source);

        var context = {
            id: identifier
        };

        var html = template(context).trim();

        var idElement = $(html);

        $("#add-setting-modal").append(idElement);

        $("#add-setting-modal").data('modal').mode = 'delete';

        var okay = confirm("Are you sure you want to delete this setting? This action is irreversable");

        if (okay) {
        	$("#add-setting-modal .save").trigger('click');
        }




    }

    function editSetting(ev) {

        var identifier = $(this).attr("setting");
        var type = $(this).attr("setting-type");

        var name = $(this).parent().parent().find(".setting-name").html().trim()
        var value = $(this).parent().parent().find(".setting-value").html().trim()

        
        $("#setting_name").val(name);

        $("#setting_name").removeAttr('disabled');
        if (type == 'root') {
        	$("#setting_name").attr('disabled', true);
        }

        $("#setting_value").val(value);

        $("#add-setting-modal").data('modal').mode = 'edit';

        $("#add-setting-modal").data('modal').identifier = identifier;

         var source = $("#id-form-element-template").html();
        var template = Handlebars.compile(source);

        var context = {
            id: identifier
        };

        var html = template(context).trim();

        var idElement = $(html);

        $("#add-setting-modal").append(idElement);
        $("#add-setting-modal").modal('show');

    }


}