var $collectionHolder;

// setup an "add a tag" link
var $addTagLink = $('<div class=" btn-group btn-group-sm"><button type="button" class="btn btn-xs add-button">Add Image</button></div>');
var $newLinkLi = $('<p class="add-image"></p>').append($addTagLink);


jQuery(document).ready(function() {

    // remove 'checked' state

    if ($('.bl-radio').length > 0) {
        // it exists
        $('.bl-radio').iCheck('destroy');
    }

    // Get the ul that holds the collection of tags
    $collectionHolder = $('ul.images');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTagLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $newLinkLi);
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

    //console.log(newForm);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li class="file-list col-sm-3"></li>').append(newForm);
    addTagFormDeleteLink($newFormLi);
    $newLinkLi.after($newFormLi);
}

function addTagFormDeleteLink($newFormLi)
{
    var $removeFormA = $('<a class="delete-link" href="#">Delete</a>');
    $newFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $newFormLi.remove();
    });
}

function toHiddenList(hiddenId)
{
    console.log(hiddenId);
    $(".bl_list_hidden").val(0);
    $("#"+hiddenId).val(1);
}

function toHiddenCover(hiddenId)
{
    console.log(hiddenId);
    $(".bl_cover_hidden").val(0);
    $("#"+hiddenId).val(1);
}