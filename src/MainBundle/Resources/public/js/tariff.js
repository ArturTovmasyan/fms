$( document ).ready(function() {

var fieldId = $("input[id$='_token']").attr('id');
var pos = fieldId.indexOf("_token");
var fieldToken = fieldId.slice(0, pos);

var tariffBlock = '#sonata-ba-field-container-' + fieldToken + 'tariff';
var tariffSelector = '#field_container_' + fieldToken + 'tariff';
var tariffCount = $(tariffSelector+' tbody.sonata-ba-tbody tr').length;

var rates = getRatesInTariff();

if(rates.length > 0) {
    setSalaryInTariff(rates, null);
}

//if select field is changed, generate by ajax dynamically values for fields
$(tariffBlock).on('change', 'input', function(e) {
    var ratesArray = [];

    var targetId = e.target.id;
    var split = targetId.split('_');
    var fieldNumber = split[split.length - 2];
    var value = $(this).val();

    if(value) {
        ratesArray.push(value);
        setSalaryInTariff(ratesArray, fieldNumber);
    }

});

function getRatesInTariff() {

    var ratesArray = [];

    for(var i = 0; i < tariffCount; i++)
    {
        var rateSelector = '#'+ fieldToken + 'tariff_' + i + '_rate';
        var rateVal = $(rateSelector).val();

        if(rateVal) {
            ratesArray.push(rateVal);
        }
    }

    return ratesArray;
}

function setSalaryInTariff(rates, singleRate) {

    $.post('/admin/api/v1.0/tariff-data', JSON.stringify({'rates' : rates }), function(data) {

        if(data) {

            console.log(data);

            if(singleRate) {
                var hourSalarySelector = '#' + fieldToken + 'tariff_' + singleRate + '_hourSalary';
                var daySalarySelector = '#' + fieldToken + 'tariff_' + singleRate + '_daySalary';

                $(hourSalarySelector).val(data[0]['hour']);
                $(daySalarySelector).val(data[0]['day']);

            } else {

                for(var i = 0; i < tariffCount; i++)
                {
                     hourSalarySelector = '#' + fieldToken + 'tariff_' + i + '_hourSalary';
                     daySalarySelector = '#' + fieldToken + 'tariff_' + i + '_daySalary';

                    if(data[i]) {

                        $(hourSalarySelector).val(data[i]['hour']);
                        $(daySalarySelector).val(data[i]['day']);
                    }
                }
            }
        }
    });
}

});