var init_modal = function(initial_counter) {

    $("#ups-modal").modal({show: false});

    $("#ups-modal").data('modal').count = initial_counter || 0;
    $("#ups-modal").data('modal').mode = null;
    $(".edit-ups").click(editups);
    $(".delete-ups").click(deleteups);

    $("#add-ups-btn").click(function(ev) {

        ev.preventDefault();

        $("#ups-modal").data('modal').mode = 'add';

        $("#ups-modal input").val("");

        $("#ups-modal").modal('show');

        $("#ups-modal").data('modal').count++;


    });

    $("#ups-modal .cancel").click(function() {

        $("#ups-modal").data('modal').count--;

        $("#ups-modal").data('modal').mode = null;


    });
    
    $('#ups_name').keydown(function (e){
        if(e.keyCode === 13){
            e.preventDefault();
            $("#ups-modal .save").click();
        }
    });

    $("#ups-modal .save").click(function() {

        var ups_name = $("#ups_name").val();
        var ups_input_format = $("#ups_input_format").val();
        var ups_output_format = $("#ups_output_format").val();
        var inputFormatText = $("#ups_input_format option[value=" + ups_input_format + "]").html();
        var outputFormatText = $("#ups_output_format option[value=" + ups_output_format + "]").html();

        var count = $("#ups-modal").data('modal').count;


        var mode = $("#ups-modal").data('modal').mode;

        if ('add' === mode) {
            var identifier = "ups_" + count;

            var nameField = $('<input>', {
                name: "data[UserPropertySkel][" + identifier + "][name]",
                type: "hidden",
                value: ups_name,
                class: identifier,
                field: "name"
            });
            var inputFormat = $('<input>', {
                name: "data[UserPropertySkel][" + identifier + "][input_format_id]",
                type: "hidden",
                value: ups_input_format,
                class: identifier,
                field: "input_format"
            });
            var outputFormat = $('<input>', {
                name: "data[UserPropertySkel][" + identifier + "][output_format_id]",
                type: "hidden",
                value: ups_output_format,
                class: identifier,
                field: "output_format"
            });

            $(".accountForm #ups-fields").append(nameField);
            $(".accountForm #ups-fields").append(inputFormat);
            $(".accountForm #ups-fields").append(outputFormat);

            var source = $("#ups-info-template").html();
            var template = Handlebars.compile(source);

            var context = {
                name: ups_name,
                input_format: inputFormatText,
                output_format: outputFormatText,
                id: identifier
            };

            var html = template(context);

            $("#ups-list").append(html);

            $(".edit-ups").click(editups);
            $(".delete-ups").click(deleteups);

        } else if ('edit' === mode) {

            var identifier = $("#ups-modal").data('modal').identifier;

            $("input[field=name]." + identifier).val(ups_name);
            $("input[field=input_format]." + identifier).val(ups_input_format);
            $("input[field=output_format]." + identifier).val(ups_output_format);

            $("#" + identifier + " .ups_name").html(ups_name);
            $("#" + identifier + " .ups_input_format").html(inputFormatText);
            $("#" + identifier + " .ups_output_format").html(outputFormatText);


        }

        $("#ups-modal").modal('hide');

    });

    function deleteups(ev) {
        
        var identifier = $(this).attr("ups");
        
        if (identifier.indexOf('old_') === 0) {
            var id = $("input[field=id]." + identifier).val();

             var deletedField = $('<input>', {
                name: "data[UserPropertySkel][deleted][" + identifier + "]",
                type: "hidden",
                value: id,
                class: "deleted"
            });
            $(".accountForm #ups-fields").append(deletedField);
        }

        var confirm = true;

        if (true === confirm) {

            $("#" + identifier + ", ." + identifier).remove();
            
            $(".accountForm").change();

        }



    }

    function editups(ev) {

        var identifier = $(this).attr("ups");

        var name = $("input[field=name]." + identifier).val();
        var inputFormat = $("input[field=input_format]." + identifier).val();
        var outputFormat = $("input[field=output_format]." + identifier).val();

        $("#ups_name").val(name);
        $("#ups_input_format").val(inputFormat);
        $("#ups_output_format").val(outputFormat);

        $("#ups-modal").data('modal').mode = 'edit';
        $("#ups-modal").data('modal').identifier = identifier;

        $("#ups-modal").modal('show');

    }


};