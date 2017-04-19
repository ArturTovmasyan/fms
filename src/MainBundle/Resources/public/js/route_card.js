$( document ).ready(function() {

    //get form token id
    var fieldId = $("input[id$='_token']").attr("id");
    var pos = fieldId.indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);

    var routeCardBlock = "#sonata-ba-field-container-"+fieldToken+"productComponent";
    var componentCount = $(routeCardBlock + ' div.sonata-ba-tabs > div').length;
    var addNew = "span[id$=_routeCard] a.sonata-ba-action";


    // detect change expense on product page
    $(addNew).click(function(event) {

        if(requestCallBack){
            requestCallBack = function (content) {
                //todo change content
                return content
            }
        }
        var codes = [];
        var option = '<option value="id">name</option>';
        var options = '';

        var id = event.target.parentElement.id;
        var formId = id.split('_');

        fieldToken = formId[2];

        var componentNumber = formId[formId.length - 2];
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

        var opNumber = operationCount-2;
        var opCode = '#' + fieldToken + '_productComponent_'+componentNumber+'_routeCard_'+opNumber+'_operationCode';
        var opDependency = '#' + fieldToken + '_productComponent_'+componentNumber+'_routeCard_'+opNumber+'_dependency';


        $(opCode).val('K'+componentNumber+'O'+operationCount);
        $(opDependency).html(options);
    });

});