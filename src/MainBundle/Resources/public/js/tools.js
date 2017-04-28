$( document ).ready(function() {

    //generate selectors for inputs
    var fieldId = $("input[id$='_token']").attr("id");
    var pos = fieldId.indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);

    //selectors for vendors
    var vendorSelector = "#"+fieldToken+"vendors";
    var newdVendorSelector = "#"+fieldToken+"newVendors";

    addVendorOptions();

    //add custom input for add vendor
    $(vendorSelector).change(function () {

        //get vendor values
        var vendorVal = $(this).select2('val');
        var itemRemove = "0";

        console.log(vendorVal);
        if($.inArray(itemRemove, vendorVal) > -1) {

            $(newdVendorSelector).removeClass('hidden-field');

            vendorVal.splice($.inArray(itemRemove, vendorVal), 1);

            $(this).select2('val', vendorVal);
        }else{
            $(newdVendorSelector).addClass('hidden-field');
        }

    });


    /**
     * This function is used to add custom options in vendor field
     */
    function addVendorOptions() {
        var option = '<option value="id">name</option>';
        var options = '';
        // var optionLength = $(vendorSelector+ ' option').length;
        options += (option.replace('id', 0).replace('name','Այլ մատակարար'));
        $(vendorSelector).append(options);
    }

});

