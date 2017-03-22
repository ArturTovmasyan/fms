$(document).ready(function () {

    var fieldId = $("input[id$='_token']").attr("id");
    var pos = fieldId.indexOf("_token");
    var fieldToken = fieldId.slice(0, pos);
    var imageSelector = "#"+fieldToken+"images";

    Dropzone.autoDiscover = false;

    var myDropzone = $('#dZUpload').dropzone({
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

});
