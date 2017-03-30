$( document ).ready(function() {

    //generate selectors for inputs
    var fieldId = $("input[id$='_token']").attr("id");
    var pos = fieldId.indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);

    //selectors for languages
    var langSelector = "#"+fieldToken+"language";
    var anotherLangSelector = "#"+fieldToken+"anotherLang";

    //selectors for comp. educations
    var compSelector = "#"+fieldToken+"compKnowledge";
    var anotherCompSelector = "#"+fieldToken+"anotherCompEducation";

    //selectors for requirements
    var requirementSelector = "#"+fieldToken+"requirement";
    var anotherRequirement = "#"+fieldToken+"anotherRequirement";

    //selectors for divisions
    var divisionSelector = "#"+fieldToken+"division";
    var divisionIdSelector = "#"+fieldToken+"divisionId";

    //selectors for posts
    var postSelector = "#"+fieldToken+"post";
    var postIdSelector = "#"+fieldToken+"postId";

    var instructorSelector = "#"+fieldToken+"instructions";

    if(divisionIdSelector) {
        //selectors for get division id in post admin class
        var divisionClass = $(divisionIdSelector).attr('class') ? $(divisionIdSelector).attr('class').split(' ')[0] : null;
        var divisionId = divisionClass;
    }

    if(postIdSelector) {
        //selectors for get post id in peronnel admin class
        var postClass = $(postIdSelector).attr('class')?$(postIdSelector).attr('class').split(' ')[0]:null;
        var postId = postClass;
    }

    //automatically sets
    setDivisionInPost();
    setPostInPersonnel();
    setInstructionInPost();

    //add custom input for language selects
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

    //add custom input for comp. education selects
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

    //add custom input for requirements selects
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


    /**
     * This function is used to select division by id in post
     */
    function setDivisionInPost() {

        if(divisionId) {

            var divisionVal = $(divisionSelector).select2('val');

            divisionVal.push(divisionId);
            $(divisionSelector).select2('val', divisionVal);
        }
    }

    /**
     * This function is used to select instruction by id in post
     */
    function setInstructionInPost() {

        if(divisionId) {

            var instructVal = $(instructorSelector).select2('val');

            instructVal.push(divisionId);
            $(instructorSelector).select2('val', instructVal);
        }
    }

    /**
     * This function is used to select post by id in personnel
     */
    function setPostInPersonnel() {

        if(postId) {
            $(postSelector).select2('val', postId);
        }
    }
});

