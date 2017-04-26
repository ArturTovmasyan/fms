$( document ).ready(function() {

    //get form token id
    var fieldId = $("input[id$='_token']").attr("id");
    var pos = fieldId.indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);
    var routeCardBlock = "#sonata-ba-field-container-"+fieldToken+"productComponent";
    var addNewOperation = "span[id$=_routeCard] a.sonata-ba-action";

    var componentCount = $(routeCardBlock + ' div.sonata-ba-tabs > div').length;

     setValuesInEditPage(componentCount);

    // detect change expense on product page
    $(addNewOperation).mousedown(function(event) {

        var codes = [];
        var option = '<option value="id">name</option>';
        var options = '<option value=""></option>';
        var id = event.target.parentElement.id;
        var formId = id.split('_');

        fieldToken = formId[2];

        var componentNumber = + formId[formId.length - 2];
        var opSelector = '#field_container_' + fieldToken + '_productComponent_'+componentNumber+'_routeCard';
        var operationCount = $(opSelector+' tbody.sonata-ba-tbody tr').length;

        if(operationCount > 0) {

            for(var i =0; i<operationCount; i++)
            {
               var codeSelector = '#' + fieldToken + '_productComponent_'+componentNumber+'_routeCard_'+i+'_operationCode';

                if($(codeSelector).val()) {
                    codes.push($(codeSelector).val());
                    options += (option.replace('id', codes[i]).replace('name',codes[i]))
                }
            }
        }

        //check if request call back is defined
        if(requestCallBack) {

            requestCallBack = function (content) {
                var cells = content[0].cells;
                var opCode = cells[2];
                var opDependency = cells[3];
                var opCodeValue = 'K'+(+componentNumber + 1)+'O'+(operationCount+1);
                $(opCode).children("input").val(opCodeValue);
                $(opDependency).children("select").html(options);

                return content
            }
        }

        return true;
    });


    /**
     * This function is used to set all dynamically values
     *
     */
    function setValuesInEditPage() {

        var professionIds = [];

        for(var c = 0; c <= componentCount; c++)
        {
            var codes = [];
            var option = '<option value="id">name</option>';
            var options = '<option value=""></option>';

            var opSelector = '#field_container_' + fieldToken + 'productComponent_'+c+'_routeCard';
            var operationCount = $(opSelector+' tbody.sonata-ba-tbody tr').length;

            if(operationCount > 0) {

                for(var i = 0; i < operationCount; i++)
                {
                    options = '';

                    var codeSelector = '#' + fieldToken + 'productComponent_'+c+'_routeCard_'+i+'_operationCode';
                    var depSelector = '#' + fieldToken + 'productComponent_'+c+'_routeCard_'+i+'_dependency';
                    var codeVal = $(codeSelector).val();
                    var depVal = $(depSelector).val();

                    var profSelector = '#' + fieldToken + 'productComponent_'+c+'_routeCard_'+i+'_profession';
                    var profVal = $(profSelector).val();
                    var categorySelector = '#' + fieldToken + 'productComponent_'+c+'_routeCard_'+i+'_professionCategory';

                    $(categorySelector).attr('prof-id', profVal);

                    var index = professionIds.indexOf(+profVal);

                    if(index === -1) {
                        professionIds.push(+profVal);
                    }



                    //generate dependency values
                    codes.push(codeVal);

                    for(var z = 0; z< codes.length;z++)
                    {
                        if(i !== z) {
                            if(codes[z] === depVal) {
                                var setOpt = '<option value="id" selected>name</option>';
                                setOpt = setOpt.replace('id', depVal).replace('name', depVal);
                                options += setOpt;
                            }else{
                                options += (option.replace('id', codes[z]).replace('name', codes[z]))
                            }
                        }
                    }

                    $(depSelector).html(options);

                }

                getAllCategoriesValue(professionIds);

            }
        }
    }


    $(routeCardBlock).on('change', "input", function(e) {

        var number = e.target.id;
        var splitId = number.split('_');
        var selector = splitId[splitId.length - 1];
        var selectedFieldValue = $(this).val();
        var componentNumber = splitId[2];
        var operationNumber = splitId[splitId.length - 2];
        var fieldToken = splitId[0];

        // check if job time is changed
        if(selector === 'jobTime') {

            var time = selectedFieldValue;

            var tariffSelector = '#'+fieldToken + '_productComponent_' + componentNumber +'_routeCard_' +
                operationNumber + '_tariff';

            var sumSelector = '#'+fieldToken + '_productComponent_' + componentNumber +'_routeCard_' +
                operationNumber + '_sum';

            var tariffValue = $(tariffSelector).val();
            var sumValue = time * tariffValue;
            $(sumSelector).val(sumValue);
        }
    });

    $(routeCardBlock).on("change", "select", function(e) {

        var number = e.target.id;
        var splitId = number.split('_');
        var selector = splitId[splitId.length - 1];
        var selectedFieldValue = $(this).val();
        var componentNumber = splitId[2];
        var operationNumber = splitId[splitId.length - 2];
        var fieldToken = splitId[0];

        //check if profession is changed
        if(selector === 'profession') {

            var professionId = selectedFieldValue;
            var categorySelector = '#'+fieldToken + '_productComponent_' + componentNumber +'_routeCard_' +
                operationNumber + '_professionCategory';

            //IMPORTANT REMOVE CATEGORY SELECT FIELD VALUE AFTER AJAX CALL
            $(categorySelector).select2('val', null);
            $(categorySelector).select2('data', null);
            setTimeout(function () {
                $(categorySelector).val(null);
            }, 200);

            var tariffSelector = '#'+fieldToken + '_productComponent_' + componentNumber +'_routeCard_' +
                operationNumber + '_tariff';

            var sumSelector = '#'+fieldToken + '_productComponent_' + componentNumber +'_routeCard_' +
                operationNumber + '_sum';

            $(tariffSelector).val(0);
            $(sumSelector).val(0);

            if(professionId) {
                getCategoryByProfessionValue(professionId, categorySelector);
            }

            //check if profession category changed
        } else if(selector === 'professionCategory') {

            var categoryValue = selectedFieldValue;

            var professionSelector = '#'+fieldToken + '_productComponent_' + componentNumber +'_routeCard_' + operationNumber
                + '_profession';

            var profValue = $(professionSelector).val();
            tariffSelector = '#'+fieldToken + '_productComponent_' + componentNumber +'_routeCard_' + operationNumber
                + '_tariff';

            if(categoryValue && profValue) {
                //get prof. category with ajax
             getTariffForRouteCard(profValue, categoryValue, tariffSelector, componentNumber, operationNumber, fieldToken);
            }
        }
    });

    /**
     * This function is used to get prof. category and dynamically change route card values
     *
     * @param profId
     * @param categoryId
     * @param selector
     * @param componentNumber
     * @param operationNumber
     * @param fieldToken
     */
    function getTariffForRouteCard(profId, categoryId, selector, componentNumber, operationNumber, fieldToken) {

        profId = +profId;

        $.get("/admin/api/v1.0/route-card/tariff/"+profId+"/"+categoryId, function(data) {

            $(selector).val(data.tariff);

           var sumSelector =  '#'+fieldToken + '_productComponent_' + componentNumber +'_routeCard_' +
                operationNumber + '_sum';

            var jobTimeSelector =  '#'+fieldToken + '_productComponent_' + componentNumber +'_routeCard_' +
                operationNumber + '_jobTime';

            var timeValue = $(jobTimeSelector).val();

            if(timeValue && data.tariff) {

                var sum = timeValue * data.tariff;

                $(sumSelector).val(sum);
            }
        });
    }

    /**
     * This function is used to get profession categories by id
     *
     * @param id
     * @param selector
     */
    function getCategoryByProfessionValue(id, selector) {

        $.get("/admin/api/v1.0/profession-category/"+id, function(data) {

            if(data.length > 0) {

                var option = '<option value="id">name</option>';
                var options = '';

                for(var i = 0; i< data.length;i++)
                {
                    options += (option.replace('id', data[i].name).replace('name', data[i].name))
                }

                $(selector).html(options);
            }
        });
    }

    /**
     * This function is used to get and generate profession categories by ids
     *
     * @param ids
     * @param componentCount
     * @param fieldToken
     */
    function getAllCategoriesValue(ids) {

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
                setCategoriesValueByAjax(dataArray);
            }
        });
    }

    /**
     *
     * @param dataArray
     */
    function setCategoriesValueByAjax(dataArray) {

            for(var cm = 0; cm <= componentCount; cm++)
            {
                var opSelector = '#field_container_' + fieldToken + 'productComponent_'+cm+'_routeCard';
                var operationCount = $(opSelector+' tbody.sonata-ba-tbody tr').length;

                if(operationCount > 0) {

                    for(var ic = 0; ic < operationCount; ic++)
                    {
                        var categorySelector = '#' + fieldToken + 'productComponent_'+cm+'_routeCard_'+ic+'_professionCategory';
                        var attrId = $(categorySelector).attr('prof-id');
                        var catIndex = dataArray[attrId];

                        if(catIndex) {

                            var categoryVal = $(categorySelector).val();

                            if(!categoryVal) {
                              $(categorySelector).val(null);
                            }

                            var option = '<option value="id">name</option>';
                            var options = '<option value=""></option>';

                            for(var i = 0; i< catIndex.length;i++)
                            {
                                if(catIndex[i].name === categoryVal) {
                                    var setOpt = '<option value="id" selected>name</option>';
                                    setOpt = setOpt.replace('id', categoryVal).replace('name', categoryVal);
                                    options += setOpt;
                                }else{
                                    options += (option.replace('id', catIndex[i].name).replace('name', catIndex[i].name))
                                }
                            }

                            $(categorySelector).html(options);
                        }
                    }
                }
            }
    }
});