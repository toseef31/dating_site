jQuery(document).ready(function($){
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar, #content').toggleClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
    if($('#avatarPreview').length){

        var height = $('#avatarPreview').height();
        var $inputImage = $('#uploadImage');
        var $imageCover = $('#uploadPreview');
        var originalImageURL = $imageCover.attr('src');
        $('.change-avatar').click(function(){
            $inputImage.click();
        });
        $('.user .clear-avatar').click(function(){
            $inputImage.val('');
            $imageCover.cropper('destroy').attr('src', originalImageURL).cropper(cropOptions);
            $(this).hide();
        });
        var cropOptions = {
            aspectRatio: 1/1,
            cropBoxResizable: false,
            minCropBoxWidth: height,
            minContainerWidth: height,
            minContainerHeight: height,
            viewMode: 3,
            minCropBoxHeight: height,
            crop: function (e) {
                $('.avatar-upload #x').val(e.detail.x);
                $('.avatar-upload #y').val(e.detail.y);
                $('.avatar-upload #w').val(e.detail.width);
                $('.avatar-upload #h').val(e.detail.height);
            }
        };
        $imageCover.on({
            ready: function (e) {
                console.log(e.type);
            },
            cropstart: function (e) {
                console.log(e.type, e.detail.action);
            },
            cropmove: function (e) {
                console.log(e.type, e.detail.action);
            },
            cropend: function (e) {
                console.log(e.type, e.detail.action);
            },
            crop: function (e) {
                console.log(e.type);
            },
            zoom: function (e) {
                console.log(e.type, e.detail.ratio);
            }
        }).cropper(cropOptions);

        $inputImage.change(function () {
            var files = this.files;
            var file;
            if (!$imageCover.data('cropper')) {
                return;
            }

            if (files && files.length) {
                file = files[0];

                if (/^image\/\w+$/.test(file.type)) {

                    if (uploadedImageURL) {
                        URL.revokeObjectURL(uploadedImageURL);
                    }
                    uploadedImageURL = URL.createObjectURL(file);
                    $imageCover.cropper('destroy').attr('src', uploadedImageURL).cropper(cropOptions);
                    $('.user .clear-avatar').show();
                } else {
                    window.alert('Please choose an image file.');
                }
            }
        });
    }
    $('#summernote').summernote({
        height: 400
    });

    $('.editInterest').on('submit', function () {
        var data = $(this).serialize();
        var id = $(this).find('input[name=id]').val();
        var text = $(this).find('input[name=text]').val();
        var icon = $(this).find('input[name=icon]').val();
        $.ajax({
            url: ajax_url,
            data: data,
            type: 'POST',
            dataType: 'JSON',
            success: function(res){
                if(res.status === 'error'){
                    alert('Something went wrong!');
                }
                else{
                    $('#modal-interest-'+id).modal('hide');
                    var tr = $('#interest-'+id);
                    tr.find('.icon i').removeClass();
                    tr.find('.icon i').addClass(icon);
                    tr.find('.name').html(text);
                }
                return false;
            }
        });
        return false;
    })

    $('.addInterest').on('submit', function () {
        var data = $(this).serialize();
        $.ajax({
            url: ajax_url,
            data: data,
            type: 'POST',
            dataType: 'JSON',
            success: function(res){
                if(res.status === 'error'){
                    alert('Something went wrong!');
                }
                else{
                    window.location.reload();
                }
                return false;
            }
        });
        return false;
    })
    $('.delete-interest').click(function(){
        var id = $(this).attr('data-id');
        var conf = confirm('Are you sure?');
        if(conf){
            $.ajax({
                url: ajax_url,
                data: {action: 'delete_interest', id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(res){
                    if(res.status === 'error'){
                        alert('Something went wrong!');
                    }
                    else{
                        $('#interest-'+id).remove();
                    }
                }
            });
        }
    });
});