$( document ).ready(function() {

    //get form token id
    var fieldId = $("input[id$='_token']").attr("id");
    var pos = fieldId.indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);

    //FOR PRODUCT RAW EXPENSE CREATE OR EDIT PAGE
    var expenseMaterialSelector = "#"+fieldToken+"rawMaterials";
    var expenseSizeSelector = "#"+fieldToken+"size";
    var expenseCostSelector = "#"+fieldToken+"cost";
    var expenseSumSelector = "#"+fieldToken+"sum";
    var expenseCountSelector = "#"+fieldToken+"count";
    var addNew = "#field_actions_"+fieldToken+"productRawExpense";

    var expenseMaterialId = $(expenseMaterialSelector).val();

    if(expenseMaterialId) {
        setRawExpenseData(expenseMaterialId);
    }

    //set default values
    var ids = [];

    //get raw expense fields count
    var counts = $('tbody.sonata-ba-tbody tr').length;

    //generate material ids
    generateIds(counts);

    //detect change expense on product page
    $('body').on('click', addNew, function() {
            setTimeout(function () {
                generateIds(counts);
            }, 1000);
    });

    //detect change expense on product page
    $('body').on('change', "tbody.sonata-ba-tbody tr td select", function(event) {
        ids = [];
        var id = $(this).val();

        if(id) {
            ids.push(id);
            var number = event.target.id;
            var idNumber = number.split('_')[2];
            setSingleMaterialsData(ids, idNumber);
        }
    });


    //detect change expense on product page
    $('body').on('change', "tbody.sonata-ba-tbody tr td input", function(event) {
        var count = $(this).val();
        var number = event.target.id;
        var formId = number.split('_')[2];

        var costSelector = "#"+fieldToken+"productRawExpense_"+formId+"_cost";
        var materialSelect = '#'+fieldToken+'productRawExpense_'+formId+'_sum';

        var cost = $(costSelector).val();
        var sum = count*cost;

        $(materialSelect).val(sum);
    });


    //detect change on product raw expense page
    $(expenseMaterialSelector).change(function () {
        ids = [];
        var id = $(this).val();

        if(id) {
            ids.push(id);
            setRawExpenseData(ids);
        }
    });

    /**
     *
     * @param ids
     */
    function setMaterialsData(ids) {

        $.post("/admin/api/v1.0/raw-expense", JSON.stringify({'ids' : ids }), function(data) {

            if(data) {

                for(var i=0; i<counts;i++)
                {
                    var sizeSelector = "#"+fieldToken+"productRawExpense_"+i+"_size";
                    var costSelector = "#"+fieldToken+"productRawExpense_"+i+"_cost";
                    var sumSelector = "#"+fieldToken+"productRawExpense_"+i+"_sum";
                    var countSelector = "#"+fieldToken+"productRawExpense_"+i+"_count";

                    var size = getSizeValue(data[i].size);
                    var count = $(countSelector).val();

                    if(count) {
                        var sum = count*data[i].actualCost;
                    }else{
                        sum = 0;
                    }

                    $(sizeSelector).val(size);
                    $(costSelector).val(data[i].actualCost);
                    $(sumSelector).val(sum);
                }
            }
        });
    }

    /**
     *
     * @param ids
     * @param idNumber
     */
    function setSingleMaterialsData(ids, idNumber) {

        $.post("/admin/api/v1.0/raw-expense", JSON.stringify({'ids' : ids }), function(data) {

            if(data) {

                var sizeSelector = "#"+fieldToken+"productRawExpense_"+idNumber+"_size";
                var costSelector = "#"+fieldToken+"productRawExpense_"+idNumber+"_cost";
                var sumSelector = "#"+fieldToken+"productRawExpense_"+idNumber+"_sum";
                var countSelector = "#"+fieldToken+"productRawExpense_"+idNumber+"_count";
                var count = $(countSelector).val();

                if(count) {
                    var sum = count*data[0].actualCost;
                }else{
                    sum = 0;
                }

                var size = getSizeValue(data[0].size);

                $(sizeSelector).val(size);
                $(costSelector).val(data[0].actualCost);
                $(sumSelector).val(sum);
            }
        });

    }

    /**
     *
     * @param ids
     */
    function setRawExpenseData(ids) {

        $.post("/admin/api/v1.0/raw-expense", JSON.stringify({'ids' : ids }), function(data) {

            if(data) {
                var count = $(expenseCountSelector).val();

                if(count) {
                    var sum = count*data[0].actualCost;
                }else{
                    sum = 0;
                }

                var size = getSizeValue(data[0].size);

                $(expenseSizeSelector).val(size);
                $(expenseCostSelector).val(data[0].actualCost);
                $(expenseSumSelector).val(sum);
            }
        });
    }

    /**
     *
     * @param counts
     */
    function generateIds(counts) {

        if(counts > 0) {
            for(var i =0; i<counts; i++)
            {
                var materialSelector = "#"+fieldToken+"productRawExpense_"+i+"_rawMaterials";

                if($(materialSelector).val()) {
                    ids.push($(materialSelector).val());
                }
            }
        }

        if(ids) {
            setMaterialsData(ids);
        }
    }

    /**
     *
     * @param size
     */
    function getSizeValue(size) {

        switch(size) {
            case 0:
                size = "Կգ";
                break;
            case 1:
                size = "Մետր";
                break;
            case 2:
                size = "Հատ";
                break;
            case 3:
                size = "Կոմպլեկտ";
                break;
            case 4:
                size = "Լիտր";
                break;

            default:
                size= "";
        }

        return size;
    }

});