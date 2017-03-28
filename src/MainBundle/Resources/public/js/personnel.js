$( document ).ready(function() {

    var fieldId = $("input[id$='_token']").attr("id");
    var pos = fieldId.indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);

    var langSelector = "#"+fieldToken+"language";
    var anotherLangSelector = "#"+fieldToken+"anotherLang";

    var compSelector = "#"+fieldToken+"compKnowledge";
    var anotherCompSelector = "#"+fieldToken+"anotherCompEducation";

    var requirementSelector = "#"+fieldToken+"requirement";
    var anotherRequirement = "#"+fieldToken+"anotherRequirement";

    $(langSelector).change(function () {

        var langVal = $(this).select2('val');
        var itemRemove = "0";

        if($.inArray(itemRemove, langVal) > -1) {

            $(anotherLangSelector).removeClass('hidden-field');

            langVal.splice($.inArray(itemRemove, langVal), 1);

            $(this).select2('val', langVal);
        }else{
            $(anotherLangSelector).addClass('hidden-field');
        }
    });

    $(compSelector).change(function () {

        var compVal = $(this).select2('val');
        var itemRemove = "0";

        if($.inArray(itemRemove, compVal) > -1) {

            $(anotherCompSelector).removeClass('hidden-field');

            compVal.splice($.inArray(itemRemove, compVal), 1);

            $(this).select2('val', compVal);
        }else{
            $(anotherCompSelector).addClass('hidden-field');
        }
    });

    $(requirementSelector).change(function () {

        var compVal = $(this).select2('val');
        var itemRemove = "0";

        if($.inArray(itemRemove, compVal) > -1) {

            $(anotherRequirement).removeClass('hidden-field');

            compVal.splice($.inArray(itemRemove, compVal), 1);

            $(this).select2('val', compVal);
        }else{
            $(anotherRequirement).addClass('hidden-field');
        }
    });

});

