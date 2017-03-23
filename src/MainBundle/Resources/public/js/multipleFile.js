$(document).ready(function () {

    var fieldId = $("input[id$='_token']").attr("id");
    var pos = fieldId.indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);
    var imageSelector = "#"+fieldToken+"imageIds";
    var objectIdSelector = "#"+fieldToken+"objectId";
    var nameSelector = "#"+fieldToken+"name";
    var objId = $(objectIdSelector).val();
    var className = $(nameSelector).attr('class').split(' ')[0];
    var imageClassName = $(nameSelector).attr('class').split(' ')[1];

    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone('#dZUpload',{
        url: "/admin/api/v1.0/multiple-files/upload",
        params: {
            className: imageClassName
        },
        maxFilesize: 100,
        uploadMultiple: true,
        parallelUploads : 5,
        paramName: "file",
        addRemoveLinks: true,
        dictRemoveFile: "Remove",
        maxThumbnailFilesize: 5,
        autoProcessQueue: true,
        thumbnailWidth: null,
        thumbnailHeight: null,
        init: function() {

            // fix images view in page
            this.on("thumbnail", function() {
                $('.dz-image').last().find('img').attr({width: '100%', height: '100%'});
            });
            this.on("success", function() {
                $('.dz-image').last().find('img').attr({width: '100%', height: '100%'});
            });

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

            if(typeof(d.xhr.responseText) == 'string') {
                var text = JSON.parse(d.xhr.responseText);
                var index = text.name.indexOf(d.name);
                var removeImageId = text.id[index];
            }

            if(typeof(d.xhr.responseText) == 'number') {
                 removeImageId = d.xhr.responseText;
            }

            if(imageClassName == 'RawMaterialImages') {
                var remUrl = "/admin/api/v1.0/remove-material-file/"+removeImageId+"/"+className

            }else{
                remUrl = "/admin/api/v1.0/remove-file/"+removeImageId+"/"+imageClassName
            }

            $.ajax({
                url: remUrl,
                type: "GET"
            });
        }
    });

    var mockFile;

    if(objId) {

        var url = '/admin/api/v1.0/files/'+className+'/'+objId;

        $.get(url, function(res) {

            var data = res.images;

            if(data.length) {

                $.each(data, function (index, item) {

                    var path = item.download_link;
                    var type = item.type;

                    console.log(item);
                    mockFile = {
                        // name: item.file_original_name,
                        size: item.file_size,
                        xhr: {responseText: item.id}
                    };

                    if($.inArray(type, ['gif','png','jpg','jpeg']) == -1) {
                        path = "/bundles/main/images/file-icon.jpg";
                    }

                    myDropzone.emit("addedfile", mockFile);
                    myDropzone.emit("thumbnail", mockFile, path);
                });
            }
        });
    }
});
