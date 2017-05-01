$( document ).ready(function() {

    //get data in forms
    var fieldId = $("input[id$='_token']").attr("id");
    var pos = fieldId.indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);
    var codeSelector = '#'+fieldToken + 'operationCode';
    var codeVal = $(codeSelector).val();
    // var depSelector = '#'+fieldToken + 'dependency';

    if(codeVal) {
        generateDependency(codeVal);
    }

    //close left menu after page loaded
    $('body.sonata-bc').addClass('sidebar-collapse');

    $('body').on('change', 'select', function(e) {

        var number = e.target.id;
        var splitId = number.split('_');

        var fieldToken = splitId[0];
        var selector = splitId[1];

        var selectedFieldValue = $(this).val();

        //check if profession is changed
        if(selector === 'profession') {

            var professionId = selectedFieldValue;
            var categorySelector = '#'+fieldToken + '_professionCategory';

            //IMPORTANT` REMOVE CATEGORY SELECT FIELD VALUE AFTER AJAX CALL
            $(categorySelector).select2('val', null);
            $(categorySelector).select2('data', null);

            var tariffSelector = '#'+fieldToken + '_tariff';
            var sumSelector = '#'+fieldToken + '_sum';

            $(tariffSelector).val(0);
            $(sumSelector).val(0);

            if(professionId) {
                getCategoryByProfessionValue(professionId, categorySelector);
            }

            //check if profession category changed
        } else if(selector === 'professionCategory') {

            var categoryValue = selectedFieldValue;

            var professionSelector = '#'+fieldToken + '_profession';
            var profValue = $(professionSelector).val();

            tariffSelector = '#'+fieldToken + '_tariff';

            if(categoryValue && profValue) {
                //get prof. category with ajax
                getTariffForRouteCard(profValue, categoryValue, tariffSelector, fieldToken);
            }
        }

    });

    /**
     * This function is used to get categories by profession id
     *
     * @param id
     * @param selector
     */
    function getCategoryByProfessionValue(id, selector) {

        $.get("/admin/api/v1.0/profession-category/"+id, function(data) {

            if(data.length > 0) {

                var option = '<option value="id">name</option>';
                var options = '<option value=""></option>';

                for(var i = 0; i< data.length;i++)
                {
                    options += (option.replace('id', data[i].name).replace('name', data[i].name))
                }

                $(selector).html(options);
            }
        });
    }

    /**
     * This function is used to get tariff by prof. and category ids, generate sum and set data in form
     *
     * @param profId
     * @param categoryId
     * @param selector
     * @param fieldToken
     */
    function getTariffForRouteCard(profId, categoryId, selector, fieldToken) {

        profId = +profId;

        $.get("/admin/api/v1.0/route-card/tariff/"+profId+"/"+categoryId, function(data) {

            $(selector).val(data.tariff);

            var sumSelector =  '#'+fieldToken + '_sum';

            var jobTimeSelector =  '#'+fieldToken + '_jobTime';

            var timeValue = $(jobTimeSelector).val();

            if(timeValue && data.tariff) {

                var sum = timeValue * data.tariff;

                $(sumSelector).val(sum);
            }
        });
    }


    /**
     *
     * @param codeVal
     */
    function generateDependency(codeVal) {

        // var option = '<option value="id">name</option>';
        // var options = '<option value=""></option>';
        console.log(codeVal);
    }

});