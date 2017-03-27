$( document ).ready(function() {

    var fieldId = $("input[id$='_token']").attr("id");
    var pos = fieldId.indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);

    var langSelector = "#"+fieldToken+"language";
    var anotherLangSelector = "#"+fieldToken+"anotherLang";

    $(langSelector).change(function () {

        var langVal = $(this).data();

        if(langVal == 5) {
            $(anotherLangSelector).removeClass('hidden-field');
        }

        console.log(langVal);

    });

    // function getTypes() {
    //
    //     $.get("/admin/api/v1.0/equipment/type/"+workshopValue, function(data) {
    //
    //         if(data.length > 0) {
    //             $(typeSelector).removeClass('hidden-field');
    //
    //             var options = '';
    //
    //             var typeVal = $('#select2-chosen-3').html(),
    //                 inArray = false;
    //
    //             for(var i = 0; i< data.length;i++)
    //             {
    //                 if(data[i].name == typeVal) {
    //                     inArray = true;
    //                 }
    //
    //                 options += (option.replace('id', data[i].id).replace('name',data[i].name))
    //             }
    //
    //             if(!inArray){
    //                 $('#select2-chosen-3').html('');
    //             }
    //
    //             $(typeSelector).html(options);
    //
    //         }else{
    //             $(typeSelector).addClass('hidden-field');
    //             $(typeSelector).html('<option value=""></option>');
    //         }
    //     });
    // }


});