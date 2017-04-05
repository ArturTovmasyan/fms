$(document).on('click', '.post-history', function () {

    var postId = $(this).attr("data-id");
    var column = '<tr><td>_post_</td><td>_personnel_</td><td>_from_</td><td>_to_</td></tr>';

    if(postId) {

        $.get("/admin/api/v1.0/post-history/"+postId, function(data) {

            if(data.length > 0) {

                var columns = '';

                for(var i = 0; i< data.length;i++)
                {
                    var toDate = '';

                    if(data[i].toDate) {
                        toDate = new Date(data[i].toDate);
                        // toDate = $.datepicker.formatDate('yy-mm-dd', toDate);
                        toDate = toDate.toDateString('yy-mm-dd');
                    }

                    var fromDate = new Date(data[i].fromDate);
                    fromDate = fromDate.toDateString('yy-mm-dd');

                    columns += (column.replace('_post_', data[i].postName).replace('_personnel_',data[i].persName)
                        .replace('_from_', fromDate).replace('_to_', toDate));
                }

                $('.add-history').html(columns);

            }else{
                $('.add-history').html('');
            }
        });
    }
});



