$( document ).ready(function() {

    //get data in forms
    var fieldId = $("input[id$='_token']").attr("id");
    var pos = fieldId.indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);
    var profSelector = '#'+fieldToken + 'profession';
    var profVal = $(profSelector).val();
    var addNewOperation = "span[id$=_routeCard] a.sonata-ba-action";

    var opSelector = '#field_container_' + fieldToken + 'routeCard';
    var operationCount = $(opSelector+' tbody.sonata-ba-tbody tr').length;

    generateDynamicValues(operationCount);

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
        var selector = splitId[3];
        var operationNumber = splitId[2];
        var selectedFieldValue = $(this).val();

        //check if profession is changed
        if(selector === 'profession') {

            var professionId = selectedFieldValue;
            var categorySelector = '#' + fieldToken + '_routeCard_' + operationNumber + '_professionCategory';

            //IMPORTANT` REMOVE CATEGORY SELECT FIELD VALUE AFTER AJAX CALL
            $(categorySelector).select2('val', null);
            $(categorySelector).select2('data', null);

            var tariffSelector = '#'+fieldToken + '_routeCard_' + operationNumber + '_tariff';
            var sumSelector = '#'+fieldToken + '_routeCard_' + operationNumber + '_sum';

            $(tariffSelector).val(0);
            $(sumSelector).val(0);

            if(professionId) {
                getCategoryByProfessionValue(professionId, categorySelector);
            }

            //check if profession category changed
        } else if(selector === 'professionCategory') {

            var categoryValue = selectedFieldValue;

            var professionSelector = '#'+fieldToken + '_routeCard_' + operationNumber + '_profession';
            var profValue = $(professionSelector).val();

            tariffSelector = '#'+fieldToken + '_routeCard_' + operationNumber + '_tariff';

            if(categoryValue && profValue) {
                //get prof. category with ajax
                getTariffForRouteCard(profValue, categoryValue, tariffSelector, operationNumber, fieldToken);
            }
        }

    }).on('change', 'input', function(e) {

        var number = e.target.id;
        var splitId = number.split('_');
        var fieldToken = splitId[0];
        var selector = splitId[3];
        var operationNumber = splitId[2];

        // check if job time is changed
        if(selector === 'jobTime') {

            var time = $(this).val();
            var tariffSelector = '#'+fieldToken + '_routeCard_' + operationNumber + '_tariff';
            var sumSelector = '#'+fieldToken + '_routeCard_' + operationNumber + '_sum';

            var tariffValue = $(tariffSelector).val();
            var sumValue = time * tariffValue;
            $(sumSelector).val(sumValue);
        }

    }).on("mousedown", addNewOperation, function(event) {

        var codes = [];
        var option = '<option value="id">name</option>';
        var options = '<option value=""></option>';
        var id = event.target.parentElement.id;
        var formId = id.split('_');
        fieldToken = formId[2];

        var operationCount = $(opSelector+' tbody.sonata-ba-tbody tr').length;

        if(operationCount > 0) {

            var percentSum = 0;

            for(var i =0; i<operationCount; i++)
            {
                var codeSelector = '#' + fieldToken + '_routeCard_'+i+'_operationCode';
                var percentSelector = '#' + fieldToken + '_routeCard_'+i+'_specificPercent';

                if($(codeSelector).val()) {
                    codes.push($(codeSelector).val());
                    options += (option.replace('id', codes[i]).replace('name',codes[i]))
                }

                //generate percent value
                var percentVal = $(percentSelector).val();
                percentSum += +percentVal;
            }

            //set percent value dynamically
            if (percentSum < 100) {
                var addedPercentValue = 100 - percentSum;
            } else{
                addedPercentValue = 0;
            }

        } else{

            setTimeout(function () {
                var opCodeSelector = 'input#' + fieldToken + '_routeCard_0_operationCode';
                $(opCodeSelector).after('<span class="help-block sonata-ba-field-widget-help">First code set manually</span>');
            }, 1100);
        }

        //check if request call back is defined
        if(requestCallBack) {

            requestCallBack = function (content) {
                //get form fields value
                var cells = content[0].cells;
                var opCode = cells[2];
                var opDependency = cells[3];
                var opPercent = cells[11];
                var opCodeValue = 'K1'+'O'+(operationCount+1);
                var inputField =  $(opCode).children("input");
                inputField.val(opCodeValue);
                $(opPercent).children("input").val(addedPercentValue);
                $(opDependency).children("select").html(options);

                return content
            }
        }

        return true;
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
     * @param operationNumber
     * @param fieldToken
     */
    function getTariffForRouteCard(profId, categoryId, selector, operationNumber, fieldToken) {

        profId = +profId;

        $.get("/admin/api/v1.0/route-card/tariff/"+profId+"/"+categoryId, function(data) {

            $(selector).val(data.tariff);

            var sumSelector =  '#'+fieldToken + '_routeCard_' + operationNumber + '_sum';
            var jobTimeSelector =  '#'+fieldToken + '_routeCard_' + operationNumber + '_jobTime';
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

        if(operationCount > 0) {

            for(var i = 0; i < operationCount; i++) {

                var categorySelector = '#' + fieldToken + 'routeCard_'+i+'_professionCategory';
                var attrId = $(categorySelector).attr('prof-id');
                var categoryArray = dataArray[attrId];

                if (categoryArray) {

                    var option = '<option value="id">name</option>';
                    var options = '<option value=""></option>';
                    var categoryVal = $(categorySelector).val();

                    for (var c = 0; c < categoryArray.length; c++) {
                        if (categoryArray[c].name === categoryVal) {
                            var setOpt = '<option value="id" selected>name</option>';
                            setOpt = setOpt.replace('id', categoryVal).replace('name', categoryVal);
                            options += setOpt;
                        } else {
                            options += (option.replace('id', categoryArray[c].name).replace('name', categoryArray[c].name))
                        }
                    }
                }
                $(categorySelector).html(options);

            }

        }

    }

    /**
     *
     * This function is used to generate dependency for route card edit page
     *
     * @param operationCount
     */
    function generateDynamicValues(operationCount) {

        var option = '<option value="id">name</option>';
        var options = '<option value=""></option>';

        if(operationCount > 0) {

            var professionIds = [];
            var codes = [];

            for(var i = 0; i < operationCount; i++)
            {
                //get profession ids and set it in category fields
                options = '';
                var profSelector = '#' + fieldToken + 'routeCard_'+i+'_profession';
                var profVal = $(profSelector).val();
                var categorySelector = '#' + fieldToken + 'routeCard_'+i+'_professionCategory';
                var index = professionIds.indexOf(+profVal);

                $(categorySelector).attr('prof-id', profVal);

                if(index === -1) {
                    professionIds.push(+profVal);
                }

                //get code and dependency values
                var codeSelector = '#' + fieldToken + 'routeCard_'+i+'_operationCode';
                var depSelector = '#' + fieldToken + 'routeCard_'+i+'_dependency';
                var depVal = $(depSelector).val();
                var codeVal = 'K1'+'O'+(i+1);

                $(codeSelector).val(codeVal);

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
            getCategoriesValue(professionIds);
        }
    }

});