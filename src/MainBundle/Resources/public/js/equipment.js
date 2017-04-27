$( document ).ready(function() {

    var fieldId = $("input[id$='_token']").attr("id");
    var pos = fieldId.indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);
    var typeSelector = "#"+fieldToken+"type";
    var workshopSelector = "#"+fieldToken+"workshop";
    var workshopValue = $(workshopSelector).val();

    var divSelect = 'div#sonata-ba-field-container-'+fieldToken+'type';

    $(divSelect).hide();

    getTypes();

    var option = '<option value="id">name</option>';

    $(workshopSelector).change(function () {
        workshopValue = $(this).val();
        $(typeSelector).val(null);
        getTypes();
    });

    function getTypes() {

        $.get("/admin/api/v1.0/equipment/type/"+workshopValue, function(data) {

            if(data.length > 0) {
                $(divSelect).show();

                var options = '';

                var typeVal = $('#select2-chosen-3').html(),
                    inArray = false;

                for(var i = 0; i< data.length;i++)
                {
                    if(data[i].name === typeVal) {
                        inArray = true;
                    }

                    options += (option.replace('id', data[i].id).replace('name',data[i].name))
                }

                if(!inArray){
                    $('#select2-chosen-3').html('');
                }

                $(typeSelector).html(options);

            }else{
                $(divSelect).hide();
                $(typeSelector).html('<option value=""></option>');
            }
        });
    }

});