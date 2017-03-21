var $collectionHolder;

// setup an "add a tag" link
var $addTagLink = $('<div class="btn-group btn-group-sm"><button type="button" class="btn btn-xs add-button">Add File</button></div>');
var $newLinkLi = $('<p class="add-image"></p>').append($addTagLink);


jQuery(document).ready(function() {

    // Get the ul that holds the collection of tags
    $collectionHolder = $('ul.images');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find('.col-sm-1').length);

    $addTagLink.on('click', function(e) {

        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $newLinkLi);

    });

    var id = $("input[id$='token']").attr("id");
    var pos = id.indexOf("_token");
    var fieldToken = id.slice(0, pos);
    var tkn = fieldToken.slice(0, -1);
    var index = $collectionHolder.data('index');
    var fieldName = tkn+'[spare_part_multiple_file]['+index+'][file][]';
    var fieldId = fieldToken+'spare_part_multiple_file_'+index+'_fIle';
    var fileSelector = '#'+fieldId;

    // '<input type="file" id="s58d114bd5b304_spare_part_multiple_file_2_file" ' +
    // 'name="s58d114bd5b304[spare_part_multiple_file][2][file][]" ' +
    // 'required="required" ' +
    // 'multiple="multiple">'

    $(fileSelector).change(function () {
        var files = $(this).val().length;
        console.log(files);
    });

});

function addTagForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li class="file-list col-sm-3"></li>').append(newForm);
    addTagFormDeleteLink($newFormLi);
    $newLinkLi.after($newFormLi);

    imageView();

}

function addTagFormDeleteLink($newFormLi)
{
    var $removeFormA = $('<a class="glyphicon glyphicon-remove" href="#"></a>');
    $newFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $newFormLi.remove();
    });
}

function imageView() {

    $('input[type=file]').first().on('change', function (event) {
        var input = event.target;

        if (input.files && input.files[0]) {

            var file = input.files[0];
            var reader = new FileReader();

            reader.onload = function (e){

                if(e && e.target){
                    var image = e.target.result;
                    var fileType = $('input[type=file]').val().split('.').pop().toLowerCase();

                    if($.inArray(fileType, ['gif','png','jpg','jpeg']) != -1) {
                        $('input[type=file]').first().parent().append('<img height="100" width="100" src="'+image+'">');
                    }
                }
            };

            reader.readAsDataURL(file);
        }
    })
}
