$( document ).ready(function() {

    //close left menu after page loaded
    $('body.sonata-bc').addClass('sidebar-collapse');

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

    //selectors for vendors
    var sparePartSelector = "#"+fieldToken+"sparePart";
    var newSparePartSelector = 'div#sonata-ba-field-container-'+fieldToken+'newSparePart';

    $(newSparePartSelector).hide();

    addSparePart();

    //add custom input for add vendor
    $(sparePartSelector).change(function () {

        //get vendor values
        var sparePartValue = $(this).select2('val');
        var itemRemove = "0";

        if($.inArray(itemRemove, sparePartValue) > -1) {

            $(newSparePartSelector).show();
            sparePartValue.splice($.inArray(itemRemove, sparePartValue), 1);

            $(this).select2('val', sparePartValue);
        }else{
            $(newSparePartSelector).hide();
        }

    });

    /**
     * This function is used to add custom options in new spare part field
     */
    function addSparePart() {
        var option = '<option value="id">name</option>';
        var options = '';
        // var optionLength = $(sparePartSelector+ ' option').length;
        options += (option.replace('id', 0).replace('name','Այլ պահեստամաս'));
        $(sparePartSelector).append(options);
    }


});