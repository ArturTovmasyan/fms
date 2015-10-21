//var $collectionHolder1;
//
//// setup an "add new" link
//var $addTagLink1 = $('<a href="#" class="add_route_link">Add Route Card</a>');
//var $newLinkLi1 = $('<li></li>').append($addTagLink1);
//
//jQuery(document).ready(function() {
//    // Get the ul that holds the collection of tags
//    $collectionHolder1 = $('ul.route');
//
//    // add the "add a tag" anchor and li to the tags ul
//    $collectionHolder1.append($newLinkLi1);
//
//    // count the current form inputs we have (e.g. 2), use that as the new
//    // index when inserting a new item (e.g. 2)
//    $collectionHolder1.data('index', $collectionHolder1.find(':input').length);
//
//    $addTagLink1.on('click', function(e) {
//        // prevent the link from creating a "#" on the URL
//        e.preventDefault();
//
//        // add a new tag form (see next code block)
//        addTagForm1($collectionHolder1, $newLinkLi1);
//    });
//});
//
//function addTagForm1($collectionHolder, $newLinkLi) {
//    // Get the data-prototype explained earlier
//    var prototype = $collectionHolder.data('prototype1');
//
//    console.log(prototype);
//
//    // get the new index
//    var index = $collectionHolder.data('index');
//
//    // Replace '__name__' in the prototype's HTML to
//    // instead be a number based on how many items we have
//    var newForm = prototype.replace(/__name__/g, index);
//
//    // increase the index with one for the next item
//    $collectionHolder.data('index', index + 1);
//
//    // Display the form in the page in an li, before the "Add a tag" link li
//    var $newFormLi = $('<li></li>').append(newForm);
//    $newLinkLi.before($newFormLi);
//
//    // add a delete link to the new form
//    addTagFormDeleteLink1($newFormLi);
//}
//
//function addTagFormDeleteLink1($tagFormLi) {
//    var $removeFormA = $('<a href="#">remove</a>');
//    $tagFormLi.append($removeFormA);
//
//    $removeFormA.on('click', function(e) {
//        // prevent the link from creating a "#" on the URL
//        e.preventDefault();
//
//        // remove the li for the tag form
//        $tagFormLi.remove();
//    });
//}