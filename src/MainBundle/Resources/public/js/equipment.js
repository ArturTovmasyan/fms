$( document ).ready(function() {

    const rubber = 0;
    const gland = 1;
    const other = 2;

    var fieldId = $("input[id$='_token']").attr("id");

    var pos = fieldId.indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);

    // var divToken = 'sonata-ba-field-container-';
    // var divType1 =  divToken+fieldToken+'type1';
    // var divType2 =  divToken+fieldToken+'type2';

    var type1 = "#"+fieldToken+"type1";
    var type2 = "#"+fieldToken+"type2";

    var workshopSelector = "#"+fieldToken+"workshop";
    var workshopValue = $(workshopSelector).val();

    selectType(workshopValue);

    $(workshopSelector).change(function () {
        workshopValue = $(this).val();
        selectType(workshopValue);
    });

    function selectType(workshopValue) {

        if(workshopValue == rubber) {
            $(type2).addClass("hidden-field");
            $(type2).val(null);
            $(type1).removeClass("hidden-field");
        }

        if(workshopValue == gland) {
            $(type1).addClass("hidden-field");
            $(type1).val(null);
            $(type2).removeClass("hidden-field");
        }

        if(workshopValue != rubber && workshopValue != gland) {
            $(type1).addClass("hidden-field");
            $(type1).val(null);
            $(type2).addClass("hidden-field");
            $(type2).val(null);
        }
    }
});