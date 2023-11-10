$(document).ready(function() {
    $('#fileInput').on('change', function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).next('.custom-file-label').html(fileName);
    });

    $('#file-upload-form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: 'POST',
            url: './upload',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $("#fileInfo").addClass("alert-success");   
                $('#fileInfo').html(response.msg).show();
            },
            error: function (e) {
                $("#fileInfo").addClass("alert-danger");   
                $('#fileInfo').html(e.responseJSON.msg).show();
            }
            
        });
        // reset when done
        $("#fileInput").val(null);
        $('#protect').attr('checked',false);
    });
});