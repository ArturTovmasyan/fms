$( document ).ready(function() {

    const rubber = 1;
    const ferum = 2;

    var fieldId = $("input[id$='_token']").attr("id");

    var pos = fieldId.indexOf("_token");

    var fieldToken = fieldId.slice(0, pos);

    var typeSelector = "#"+fieldToken+"type";

    var workshopSelector = "#"+fieldToken+"workshop";

    var workshopValue = $(workshopSelector).val();

    if (workshopValue == rubber || workshopValue == ferum) {
        getTypes();
    }

    var option = '<option value="id">name</option>';

    $(workshopSelector).change(function () {
        workshopValue = $(this).val();
        getTypes();
    });


    function getTypes() {

        $.get("/admin/api/v1.0/equipment/type/"+workshopValue, function(data) {

            if(data.length > 0) {
                $('#select2-chosen-3').html('');
                $(typeSelector).removeClass('hidden-field');

                var options = '';

                for(var i = 0; i< data.length;i++)
                {
                    options += (option.replace('id', data[i].id).replace('name',data[i].name))
                }

                $(typeSelector).html(options);

            }else{
                $(typeSelector).addClass('hidden-field');
                $(typeSelector).html('<option value=""></option>');
            }
        });
    }
});