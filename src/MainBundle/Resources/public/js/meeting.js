$( document ).ready(function() {

    //generate selectors for inputs
    var fieldId = $("input[id$='_token']").attr("id");
    var pos = fieldId.indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);

    //selectors for type
    var typeSelector = "#"+fieldToken+"type";
    var anotherTypeSelector = "#"+fieldToken+"anotherType";

    //selectors for place
    var placeSelector = "#"+fieldToken+"place";
    var anotherPlaceSelector = "#"+fieldToken+"anotherPlace";

    //selectors for subject
    var subjectSelector = "#"+fieldToken+"subject";
    var anotherSubjectSelector = "#"+fieldToken+"anotherSubject";

    //selectors for subject
    var chairPersonSelector = "#"+fieldToken+"chairPerson";
    var anotherChairPersonSelector = "#"+fieldToken+"anotherChairPerson";

    //selectors for subject
    var secretarySelector = "#"+fieldToken+"secretary";
    var anotherSecretarySelector = "#"+fieldToken+"anotherSecretary";

    //close left menu after page loaded
    $('body.sonata-bc').addClass('sidebar-collapse');

    //add change event on dynamically selected fieldds
    addAnotherValues(typeSelector, anotherTypeSelector);
    addAnotherValues(placeSelector, anotherPlaceSelector);
    addAnotherValues(subjectSelector, anotherSubjectSelector);
    addAnotherValues(chairPersonSelector, anotherChairPersonSelector);
    addAnotherValues(secretarySelector, anotherSecretarySelector);

    /**
     *
     * @param selector
     * @param anotherSelector
     */
    function addAnotherValues(selector, anotherSelector) {

        //add custom input for dynamically select fields
        $(selector).change(function () {

            var typeVal = $(this).select2('val');
            var itemRemove = "0";

            if($.inArray(itemRemove, typeVal) > -1) {

                $(anotherSelector).removeClass('hidden-field');

                typeVal.splice($.inArray(itemRemove, typeVal), 1);

                $(this).select2('val', typeVal);
            } else{
                $(anotherSelector).addClass('hidden-field');
            }
        });
    }
});

