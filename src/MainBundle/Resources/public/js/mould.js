$( document ).ready(function() {

    var fieldId = $("input[id$='_token']").attr("id");

    if(fieldId) {
        var pos = $("input[id$='_token']").attr("id").indexOf("_token");
        var fieldToken = fieldId.slice(0, pos);
        var productSelector = "#"+fieldToken+"product";
        var mouldTypeSelector = "#"+fieldToken+"mouldType";
        var mouldTypeCount = $(mouldTypeSelector).val();
        var productCount = $(productSelector).val();

        if(productCount) {
            productCount = productCount.length;
        }else{
            productCount = 0;
        }
    }
    else{
        return;
    }

    $(mouldTypeSelector).change(function () {

        mouldTypeCount = $(this).val();
        checkDisable(mouldTypeCount, productCount);
    });

    $(productSelector).change(function () {

        if($(this).val()) {
            productCount = $(this).val().length;
        }
        checkDisable(mouldTypeCount, productCount);
    });

    function checkDisable(mouldTypeCount,productCount ) {

        $("#error_product").hide();

        if (productCount >= mouldTypeCount) {
            $(productSelector).attr ('disabled', 'disabled');
        } else {
            $(productSelector).removeAttr ('disabled');
        }

        if(productCount && productCount > mouldTypeCount && mouldTypeCount>0) {

            $(mouldTypeSelector).val(productCount);
            $(productSelector).parent().after(
                "<div class='validation' id='error_product' style='color:red;margin-bottom: 20px;'>" +
                "Product items more then mould type count" +
                "</div>"
            );
        }
    }

    $(document).submit(function() {
        $(productSelector).prop('disabled', false);
    });

});