$( document ).ready(function() {

    var fieldId = $("input[id$='_token']").attr("id");
    var pos = fieldId.indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);

    var typeSelector = "#"+fieldToken+"productRawExpense_0_rawMaterials";
    var sizeSelector = "#"+fieldToken+"productRawExpense_0_size";
    var costSelector = "#"+fieldToken+"productRawExpense_0_cost";

     var materialId = $(typeSelector).val();

     if(materialId) {
         getTypes(materialId);
     }

    $('body').on('change', typeSelector, function() {
        var id = $(this).val();
        getTypes(id);
    });

    /**
     *
     * @param id
     */
    function getTypes(id) {

        $.get("/admin/api/v1.0/raw-expense/"+id, function(data) {

            if(data) {
                var size = getSizeValue(data.size);
                $(sizeSelector).val(size);
                $(costSelector).val(data.actualCost);
            }
        });
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