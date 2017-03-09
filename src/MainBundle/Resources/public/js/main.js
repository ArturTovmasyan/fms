$( document ).ready(function() {
    var fieldId = $("input[id$='_token']").attr("id");
    var pos = $("input[id$='_token']").attr("id").indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);

    var productSelector = "#"+fieldToken+"product";

    var mouldTypeSelector = "#"+fieldToken+"mouldType";

    var mouldTypeCount = 1;

    var itemCount = 0;

    $(mouldTypeSelector).change(function () {

        mouldTypeCount = $(this).val();

        checkDisable(mouldTypeCount, itemCount);
    });

    $(productSelector).change(function () {

        if($(this).val()) {
            itemCount = $(this).val().length;
        }

        checkDisable(mouldTypeCount, itemCount);
    });

    function checkDisable(mouldTypeCount,itemCount ) {

        if (itemCount >= mouldTypeCount) {
            $(productSelector).attr ('disabled', 'disabled');
        } else {
            $(productSelector).removeAttr ('disabled');
        }
    }
});