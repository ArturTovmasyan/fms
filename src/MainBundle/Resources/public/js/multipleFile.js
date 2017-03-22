$(document).ready(function () {

    var fieldId = $("input[id$='_token']").attr("id");
    var pos = fieldId.indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);
    var imageSelector = "#"+fieldToken+"imageIds";
    var objectIdSelector = "#"+fieldToken+"objectId";
    var nameSelector = "#"+fieldToken+"name";
    var objId = $(objectIdSelector).val();
    var className = $(nameSelector).attr('class').split(' ')[0];

    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone('#dZUpload',{
        url: "/admin/api/v1.0/multiple-files/upload",
        maxFilesize: 100,
        uploadMultiple: true,
        parallelUploads : 5,
        paramName: "file",
        addRemoveLinks: true,
        dictRemoveFile: "Remove",
        maxThumbnailFilesize: 5,
        autoProcessQueue: true,
        init: function() {


            this.on("successmultiple", function(file, json) {

                //upload images to server
                var val = $(imageSelector).val();
                var parse = val ? (JSON.parse(val)+',') : '';
                parse = parse.concat(json.id);
                var ids = JSON.stringify(parse);
                jQuery(imageSelector).val(ids);

            });
        },
        removedfile: function(d){

            $(d.previewElement).remove();

            var text = JSON.parse(d.xhr.responseText);
            var index = text.name.indexOf(d.name);
            var removeImageId = text.id[index];

            $.ajax({
                url: "/admin/api/v1.0/remove-file/"+removeImageId+"/"+"sparepart",
                type: "GET"
            });
        }
    });

    var mockFile;

    if(objId) {

        var url = '/admin/api/v1.0/files/'+className+'/'+objId;

        var imagePath = '/uploads/sparePart/';

        $.get(url, function(data) {

            $.each(data, function (index, item) {

                var path = imagePath+item.fileName;

                //// Create the mock file:
                mockFile = {
                    name: item.fileOriginalName,
                    size: item.fileSize,
                    accepted: true,
                    fileName: item.fileName,
                    xhr: {responseText: item.id}

                };

                console.log(mockFile);

                myDropzone.emit("addedfile", mockFile);
                myDropzone.emit("thumbnail", mockFile, path);
            });
        });
    }

});
