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

    //selectors for invitors and newInvitors
    var invitorsSelector = '#'+fieldToken+'invitors';
    var addInvitorsSelector = 'div#sonata-ba-field-container-'+fieldToken+'newInvitors';

    addMemberOptions();

    //close left menu after page loaded
    $('body.sonata-bc').addClass('sidebar-collapse');

    //add change event on dynamically selected fields
    addAnotherValues(typeSelector, anotherTypeSelector);
    addAnotherValues(placeSelector, anotherPlaceSelector);
    addAnotherValues(subjectSelector, anotherSubjectSelector);
    addAnotherValues(chairPersonSelector, anotherChairPersonSelector);
    addAnotherValues(secretarySelector, anotherSecretarySelector);

    addAnotherValues(invitorsSelector, addInvitorsSelector);

    /**
     *
     * @param selector
     * @param anotherSelector
     */
    function addAnotherValues(selector, anotherSelector) {

        $(anotherSelector).hide();

        //add custom input for dynamically select fields
        $(selector).change(function () {

            var typeVal = $(this).select2('val');
            var itemRemove = "0";

            if($.inArray(itemRemove, typeVal) > -1) {

                $(anotherSelector).show();

                typeVal.splice($.inArray(itemRemove, typeVal), 1);

                $(this).select2('val', typeVal);
            } else {
                $(anotherSelector).hide();
            }
        });
    }

    /**
     * This function is used to add custom options in member field
     */
    function addMemberOptions() {

        var option = '<option value="id">name</option>';
        var options = '';
        // var optionLength = $(vendorSelector+ ' option').length;
        options += (option.replace('id', "0").replace('name', 'Այլ հրավիրվածներ'));
        $(invitorsSelector).prepend(options);
    }
});

