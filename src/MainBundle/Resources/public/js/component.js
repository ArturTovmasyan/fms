var $collectionHolder;

var $collectionHolder1;

// setup an "add a tag" link
var $addTagLink = $('<a href="#" class="add_component_link">Add component</a>');
var $newLinkLi = $('<li></li>').append($addTagLink);

var $addTagLink1 = $('<a href="#" class="add_route_card_link">Add route card</a>');
var $newLinkLi1 = $('<li></li>').append($addTagLink1);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('ul.component');

    $collectionHolder1 = $('ul.route');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTagLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        $collectionHolder.append($newLinkLi1);

        // add a new tag form (see next code block)
        addComponentForm($collectionHolder, $newLinkLi);

    });

    $addTagLink1.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addCardForm($collectionHolder1, $newLinkLi1);
    });

});

function addComponentForm($collectionHolder, $newLinkLi) {

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
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);

    // add a delete link to the new form
    addComponentFormDeleteLink($newFormLi);
}

function addCardForm($collectionHolder1, $newLinkLi1) {

    // Get the data-prototype explained earlier
    var prototype = $collectionHolder1.data('prototype');

    // get the new index
    var index1 = $collectionHolder1.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm1 = prototype.replace(/__name__/g, index1);

    // increase the index with one for the next item
    $collectionHolder1.data('index', index1 + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi1 = $('<li></li>').append(newForm1);
    $newLinkLi1.before($newFormLi1);

    // add a delete link to the new form
    addRouteFormDeleteLink($newFormLi1);
}

function addComponentFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a href="#">remove component</a>');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $tagFormLi.remove();
    });
}

function addRouteFormDeleteLink($tagFormLi1) {
    var $removeFormA = $('<a href="#">remove route</a>');
    $tagFormLi1.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $tagFormLi1.remove();
    });
}