$( document ).ready(function() {

    //get data in forms
    var fieldId = $("input[id$='_token']").attr("id");
    var pos = fieldId.indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);
    var codeSelector = '#'+fieldToken + 'operationCode';
    var codeVal = $(codeSelector).val();
    var profSelector = '#'+fieldToken + 'profession';
    var profVal = $(profSelector).val();

    var categorySelector = '#'+fieldToken + 'professionCategory';
    var categoryVal = $(categorySelector).val();
    $(categorySelector).attr('prof-id', profVal);

    if(codeVal) {
        generateDependency(codeVal);
    }

    if(profVal) {
        getCategoriesValue(profVal);
    }

    //close left menu after page loaded
    $('body.sonata-bc').addClass('sidebar-collapse');

    //set event on change select and input fields
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

    }).on('input', "input", function(e) {

        var number = e.target.id;
        var splitId = number.split('_');
        var fieldToken = splitId[0];
        var selector = splitId[1];

        // check if job time is changed
        if(selector === 'jobTime') {

            var time = $(this).val();
            var tariffSelector = '#'+fieldToken + '_tariff';
            var sumSelector = '#'+fieldToken + '_sum';

            var tariffValue = $(tariffSelector).val();
            var sumValue = time * tariffValue;
            $(sumSelector).val(sumValue);
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
     * This function is used to get and generate categories array for all profession in list
     *
     * @param ids
     */
    function getCategoriesValue(ids) {

        var dataArray = [];

        $.post("/admin/api/v1.0/route-card/categories", JSON.stringify({'ids' : ids }), function(data) {

            if(data) {

                for(var i=0; i<data.length;i++)
                {
                    var pid = data[i][0].id;
                    var cid = data[i].id;
                    var cname = data[i].name;
                    var index = ids.indexOf(pid);

                    if(index > -1) {

                        var key = ids[index];

                        if(key) {
                            if(dataArray[key]) {
                                dataArray[key].push({
                                    'id':cid,
                                    'name':cname
                                });
                            } else {
                                dataArray[key] = [{
                                    'id':cid,
                                    'name':cname
                                }]
                            }
                        }
                    }
                }
            }

            if(dataArray.length > 0) {
                //set categories select options by generated dataArray
                setCategoriesValue(dataArray);
            }
        });
    }

    /**
     * This function is used to set categories selected options by generated dataArray via top ajax
     *
     * @param dataArray
     */
    function setCategoriesValue(dataArray) {

        var option = '<option value="id">name</option>';
        var options = '<option value=""></option>';

        var attrId = $(categorySelector).attr('prof-id');
        var categoryArray = dataArray[attrId];

        if(categoryArray) {

            for(var i = 0; i < categoryArray.length; i++)
            {
                if(categoryArray[i].name === categoryVal) {
                    var setOpt = '<option value="id" selected>name</option>';
                    setOpt = setOpt.replace('id', categoryVal).replace('name', categoryVal);
                    options += setOpt;
                }else{
                    options += (option.replace('id', categoryArray[i].name).replace('name', categoryArray[i].name))
                }
            }

            $(categorySelector).html(options);

        }
    }

    /**
     *
     * This function is used to generate dependency for route card edit page
     *
     * @param codeVal
     */
    function generateDependency(codeVal) {

        var option = '<option value="id">name</option>';
        var options = '<option value=""></option>';

        var number = codeVal.replace(/[^0-9]/g, '_');
        var arrayNumber = number.slice(1);
        var kVal = arrayNumber.slice(0, arrayNumber.indexOf('_'));
        var opVal = arrayNumber.slice(arrayNumber.indexOf('_') + 1);
        var depSelector = '#'+fieldToken + 'dependency';
        var depVal = $(depSelector).val();

        if(opVal > 1) {
            var codes = [];

            for(var i = 1; i < opVal; i++) {
                var setOpVal = opVal - i;
                var depValues = 'K'+kVal+'O'+ setOpVal;
                codes.push(depValues);
            }
        }

        if(codes && codes.length > 0) {
            for(i = 0; i < codes.length; i++)
            {
                if(codes[i] === depVal) {
                    var setOpt = '<option value="id" selected>name</option>';
                    setOpt = setOpt.replace('id', depVal).replace('name', depVal);
                    options += setOpt;
                }else{
                    options += (option.replace('id', codes[i]).replace('name', codes[i]))
                }
            }

            $(depSelector).html(options);
        }
    }

});