$( document ).ready(function() {

    //get form token id
    var fieldId = $("input[id$='_token']").attr("id");
    var pos = fieldId.indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);

    var routeCardBlock = "#sonata-ba-field-container-"+fieldToken+"productComponent";
    var componentCount = $(routeCardBlock + ' div.sonata-ba-tabs > div').length;
    var addNewOperation = "span[id$=_routeCard] a.sonata-ba-action";

    setDependency(componentCount);

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

        if(requestCallBack){

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
     * This function is used to set dependency fields value
     *
     * @param componentCount
     */
    function setDependency(componentCount) {

        for(var c = 0; c < componentCount; c++)
        {
            var codes = [];
            var option = '<option value="id">name</option>';
            var options = '<option value=""></option>';

            var opSelector = '#field_container_' + fieldToken + 'productComponent_'+c+'_routeCard';
            var operationCount = $(opSelector+' tbody.sonata-ba-tbody tr').length;

            if(operationCount > 0) {

                // options += '<option value=""> </option>';

                for(var i = 0; i<operationCount; i++)
                {
                    var codeSelector = '#' + fieldToken + 'productComponent_'+c+'_routeCard_'+i+'_operationCode';
                    var depSelector = '#' + fieldToken + 'productComponent_'+c+'_routeCard_'+i+'_dependency';
                    var myClass = $(depSelector).attr('class');
                    var codeVal = $(codeSelector).val();

                    //generate dependency values
                    codes.push(codeVal);
                    options += (option.replace('id', codes[i]).replace('name',codes[i]));

                    //check id dependencies exist(EDIT PAGE)
                    if(myClass) {
                        var index = options.indexOf(myClass);
                        if(index === -1) {
                            var setOpt = '<option value="id" selected>name</option>';
                                setOpt = setOpt.replace('id', myClass).replace('name', myClass);
                                options += setOpt;
                        } else {
                            options = options.slice(0, index + myClass.length + 1) + ' selected' + options.slice(index + myClass.length + 1);
                        }
                    }
                    $(depSelector).html(options);
                }
            }
        }
    }


    $(routeCardBlock).on("change", "select", function(e) {

        var number = e.target.id;
        var splitId = number.split('_');
        var selector = splitId[splitId.length - 1];

        if(selector === 'profession') {

            var professionId = $(this).val();
            var componentNumber = splitId[2];
            var operationNumber = splitId[splitId.length - 2];
            var fieldToken = splitId[0];

            var categorySelector = '#'+fieldToken + '_productComponent_' + componentNumber +'_routeCard_' +
                operationNumber + '_professionCategory';

            if(professionId) {
                getCategoryByProfessionValue(professionId, categorySelector);
            }
        }
    });


    /**
     * This function is used to get profession categories by id
     *
     * @param id
     * @param selector
     */
    function getCategoryByProfessionValue(id, selector) {

        $.get("/admin/api/v1.0/profession-category/"+id, function(data) {

            if(data.length > 0) {
                console.log(data);

                var option = '<option value="id">name</option>';
                var options = '';

                for(var i = 0; i< data.length;i++)
                {
                    options += (option.replace('id', data[i].id).replace('name',data[i].name))
                }

                $(selector).html(options);
            }
        });
    }
});