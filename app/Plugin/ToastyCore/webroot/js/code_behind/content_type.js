var init_modal = function(initial_counter) {

    $("#ctps-modal").modal({show: false});

    $("#ctps-modal").data('modal').count = initial_counter || 0;
    $("#ctps-modal").data('modal').mode = null;
    $(".edit-ctps").click(editCtps);
    $(".delete-ctps").click(deleteCtps);

    $("#add-ctps-btn").click(function(ev) {

        ev.preventDefault();

        $("#ctps-modal").data('modal').mode = 'add';

        $("#ctps-modal input").val("");

        $("#ctps-modal").modal('show');

        $("#ctps-modal").data('modal').count++;


    });

    $("#ctps-modal .cancel").click(function() {

        $("#ctps-modal").data('modal').count--;

        $("#ctps-modal").data('modal').mode = null;


    });
    
    $('#ctps_name').keydown(function (e){
        if(e.keyCode === 13){
            e.preventDefault();
            $("#ctps-modal .save").click();
        }
    });

    $("#ctps-modal .save").click(function() {

        var ctps_name = $("#ctps_name").val();
        var ctps_input_format = $("#ctps_input_format").val();
        var ctps_output_format = $("#ctps_output_format").val();
        var inputFormatText = $("#ctps_input_format option[value=" + ctps_input_format + "]").html();
        var outputFormatText = $("#ctps_output_format option[value=" + ctps_output_format + "]").html();

        var count = $("#ctps-modal").data('modal').count;


        var mode = $("#ctps-modal").data('modal').mode;

        if ('add' === mode) {
            var identifier = "ctps_" + count;

            var nameField = $('<input>', {
                name: "data[ContentTypePropertySkel][" + identifier + "][name]",
                type: "hidden",
                value: ctps_name,
                class: identifier,
                field: "name"
            });
            var inputFormat = $('<input>', {
                name: "data[ContentTypePropertySkel][" + identifier + "][input_format_id]",
                type: "hidden",
                value: ctps_input_format,
                class: identifier,
                field: "input_format"
            });
            var outputFormat = $('<input>', {
                name: "data[ContentTypePropertySkel][" + identifier + "][output_format_id]",
                type: "hidden",
                value: ctps_output_format,
                class: identifier,
                field: "output_format"
            });

            $(".contentTypeForm #ctps-fields").append(nameField);
            $(".contentTypeForm #ctps-fields").append(inputFormat);
            $(".contentTypeForm #ctps-fields").append(outputFormat);

            var source = $("#ctps-info-template").html();
            var template = Handlebars.compile(source);

            var context = {
                name: ctps_name,
                input_format: inputFormatText,
                output_format: outputFormatText,
                id: identifier
            };

            var html = template(context);

            $("#ctps-list").append(html);

            $(".edit-ctps").click(editCtps);
            $(".delete-ctps").click(deleteCtps);

        } else if ('edit' === mode) {

            var identifier = $("#ctps-modal").data('modal').identifier;

            $("input[field=name]." + identifier).val(ctps_name);
            $("input[field=input_format]." + identifier).val(ctps_input_format);
            $("input[field=output_format]." + identifier).val(ctps_output_format);

            $("#" + identifier + " .ctps_name").html(ctps_name);
            $("#" + identifier + " .ctps_input_format").html(inputFormatText);
            $("#" + identifier + " .ctps_output_format").html(outputFormatText);


        }

        $("#ctps-modal").modal('hide');

    });

    function deleteCtps(ev) {
        
        var identifier = $(this).attr("ctps");
        
        if (identifier.indexOf('old_') === 0) {
            var id = $("input[field=id]." + identifier).val();

             var deletedField = $('<input>', {
                name: "data[ContentTypePropertySkel][deleted][" + identifier + "]",
                type: "hidden",
                value: id,
                class: "deleted"
            });
            $(".contentTypeForm #ctps-fields").append(deletedField);
        }

        var confirm = true;

        if (true === confirm) {

            $("#" + identifier + ", ." + identifier).remove();
            
            $(".contentTypeForm").change();

        }



    }

    function editCtps(ev) {

        var identifier = $(this).attr("ctps");

        var name = $("input[field=name]." + identifier).val();
        var inputFormat = $("input[field=input_format]." + identifier).val();
        var outputFormat = $("input[field=output_format]." + identifier).val();

        $("#ctps_name").val(name);
        $("#ctps_input_format").val(inputFormat);
        $("#ctps_output_format").val(outputFormat);

        $("#ctps-modal").data('modal').mode = 'edit';
        $("#ctps-modal").data('modal').identifier = identifier;

        $("#ctps-modal").modal('show');

    }


};