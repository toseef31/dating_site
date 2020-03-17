jQuery(document).ready(function ($) {
    $(window).bind('popstate', function(){
        window.location.href = window.location.href;
    });
    var token = $('meta[name=csrf_token]').attr('content');
    var uploadProgress = $('.upload-progress');
    $(document).on('click','.conversations .message-box .list-messages ul li.message .view-chat-photo', function (event) {
        var el = $(event.currentTarget);
        var url = el.attr('data-view');
        $.fancybox.open([{src : url}]);
    });
    $(document).on('click',function(e){
        if(($(e.target).closest("#list-emojis").attr("id") != "list-emojis") && ($(e.target).closest("#emojis").attr("id") != "emojis")){
            $('.conversations .message-box .write-message .emojis div.list-emojis').hide();
        }
    });
    $(document).on('click','.notifications .notification .close',function (event) {
        var el = $(event.currentTarget);
        el.parent().remove();
    });
    $(document).on('click','.conversations .message-box .write-message .emojis .list-emojis a', function (event) {
        var el = $(event.currentTarget);
        $('.conversations .message-box input.message-input').val($('.conversations .message-box input.message-input').val()+' '+el.text());
    });
    $(document).on('click','.conversations .message-box .write-message .emojis span', function (event) {
        var el = $(event.currentTarget);
        $('.conversations .message-box .write-message .emojis div.list-emojis').show();
    });
    $(document).on('click','.conversations .message-box .list-messages ul li.load_more_message', function (event) {
        var el = $(event.currentTarget);
        var page = el.attr('data-page');
        page = parseInt(page)+1;
        var id = el.attr('data-id');
        $.ajax({
            url:ajax_url,
            data: {action: 'load_messages', page: page, id: id, _token: token},
            dataType: 'JSON',
            type: 'POST',
            success: function (res) {
                if(res.status === 'success'){
                    el.after(res.html);
                    el.attr('data-page', page);
                }
                else if(res.status === 'empty'){
                    el.remove();
                }
            }
        })
    });
    if($('.conversations .message-box .list-messages ul').length){
        $('.conversations .message-box .list-messages ul').mCustomScrollbar().mCustomScrollbar("scrollTo","bottom",{scrollInertia:0});
    }
    if($('.conversations .list-conversations ul').length){
        $('.conversations .list-conversations ul').mCustomScrollbar().mCustomScrollbar();
    }
    $('.load_more_photo').click(function (e) {
        var el = $(this);
        el.addClass('loading');
        el.attr('disabled', true);
        var id = el.attr('data-id');
        var page = el.attr('data-page');
        page = parseInt(page)+1;
        $.ajax({
            url: ajax_url,
            data: {id: id, page: page, _token: token, action: 'load_photo'},
            type: 'POST',
            dataType: 'JSON',
            success: function (res) {
                el.removeClass('loading');
                if(res.status === 'success'){
                    el.removeAttr('disabled');
                    $('.main-photos .row').append(res.html);
                    el.attr('data-page', page);
                }
            }
        })
    });
    $('#formQuick').submit(function (e) {
        const errors = [];
        const username = $('#register-username').val();
        const email = $('#register-email').val();
        const gender = $('#quick-gender').val();
        const password = $('#quick-pass').val();
        const country = $('#quick-country').val();
        if(username === ''){
            errors.push('Username is required');
        }
        if($('#register-username').hasClass('invalid')){
            errors.push('Username already exist');
        }
        if(username.leng < 6){
            errors.push('Username must be at least 6 characters');
        }
        if(email === ''){
            errors.push('Email is required');
        }
        if(!validateEmail(email)){
            errors.push('Email is invalid');
        }
        if($('#register-email').hasClass('invalid')){
            errors.push('Email already exist');
        }
        if(gender === ''){
            errors.push('Gender is required');
        }
        if(country === ''){
            errors.push('Location is required');
        }
        if(password === ''){
            errors.push('Password is required');
        }
        if(password.length < 6){
            errors.push('Password must be at least 6 characters');
        }
        if(errors.length){
            var html = '<div class="alert alert-warning alert-dismissible fade show text-left p-1" role="alert"><ul class="mb-0 pl-1 list-unstyled text-small">';
            $.each(errors, function(idx, val){
                html += '<li>- '+val+'</li>';
            });
            html += '</ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $('#formQuick').prepend(html);
            setTimeout(function () {
                $('#formQuick .alert').remove();
            }, 3000);
            return false;
        }
    });
    $('.photo-item.add-photo').click(function(){
        $('#upload-photo').click();
    });
    $('.btn-love').click(function () {
        var el = $(this);
        var id = el.attr('data-id');
        var type = el.attr('data-type');
        $.ajax({
            url: ajax_url,
            data: {action: 'love', _token: token, id: id, type: type},
            dataType: 'JSON',
            type: 'POST',
            success: function (res) {
                if(res.status === 'success'){
                    if(res.type == 'old'){
                        var checkClass = el.hasClass('active');
                        $('.btn-love, .btn-unlove').removeClass('active');
                        if(!checkClass){
                            el.addClass('active');
                        }
                    }
                    else{
                        el.addClass('active');
                    }
                }
                else if(res.status === 'login'){
                    $('.modal').modal('hide');
                    $('#modalLogin').modal('show');
                }
            }
        });
    });
    $(document).on('click','.btn-follow', function (e) {
        var el = $(e.currentTarget);
        var id = el.attr('data-id');
        $.ajax({
            url: ajax_url,
            data: {_token: token, action: 'follow', id: id},
            dataType: 'JSON',
            type: 'POST',
            success: function (res) {
                if(res.status === 'success'){
                    if(res.type === 'self'){
                        alert('You can not follow your self');
                    }
                    else if(res.type == 'unfollow'){
                        el.html('Follow');
                    }
                    else{
                        el.html('<i class="fas fa-check"></i> Followed');
                    }
                }
                else if(res.status === 'login'){
                    $('.modal').modal('hide');
                    $('#modalLogin').modal('show');
                }
            }
        })
    });
    $('#formUpload').ajaxForm({
        beforeSend: function () {
            uploadProgress.css({opacity:1});
            uploadProgress.find('.progress-bar').css({width: 0});
            uploadProgress.find('.progress-bar').attr('aria-valuenow', 0);
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            uploadProgress.find('.progress-bar').css({width: percentVal});
            uploadProgress.find('.progress-bar').attr('aria-valuenow', percentComplete);
        },
        complete: function(xhr) {
            var result = JSON.parse(xhr.responseText);
            if(result.status === 'success'){
                var html = '<div class="col-md-2">';
                html += '<div class="photo-item view-photo border" data-id="'+result.id+'" data-url="'+result.file+'" style="background-image: url('+result.thumb+')"></div>';
                html += '</div>';
                var count = $('.users-photo .col-md-2').length;
                if(count > 1){
                    if(count === 6){
                        $('.users-photo .col-md-2').each(function(idx,val){
                            if(idx == 4){
                                val.remove();
                            }
                        })
                    }
                    $('.users-photo').prepend(html);
                }
            }
            $('#modalUpload').find('textarea').val('');
            $('#modalUpload').modal('hide');
            uploadProgress.find('.progress-bar').css({width: 0});
            uploadProgress.find('.progress-bar').attr('aria-valuenow', 0);
            uploadProgress.css({opacity:0});
        }
    });
    $('#upload-photo').on('change', function () {
        if($(this).get(0).files.length){
            $('#modalUpload').modal('show');
        }
    });
    $(document).on('click','.close-view-photo',function () {
        $('#modalPhoto').modal('hide');
    });
    $(document).on('keyup','.view-photo-right .photo-action .write-comment', function (event) {
        var el = $(event.currentTarget);
        var keycode = (event.keyCode ? event.keyCode : event.which);
        var photo_id = el.attr('data-id');
        if(keycode === 13){
            event.preventDefault();
            el.val( el.val().replace( /\r?\n/gi, '' ) );
            var comment = el.val();
            if(comment !== ''){
                $.ajax({
                    url: ajax_url,
                    data: {id: photo_id, action: 'comment_photo', text: comment, _token: token},
                    dataType: 'JSON',
                    type: 'POST',
                    success: function (res) {
                        if(res.status === 'success'){
                            $('.view-photo-right .comments ul').append(res.html);
                            el.val('');
                        }
                        else if(res.status === 'login'){
                            $('.modal').modal('hide');
                            $('#modalLogin').modal('show');
                        }
                    }
                })
            }
            return false;
        }
    });
    $(document).on('click','.view-photo-right .photo-action .like-photo .fa-heart', function (e) {
        var el = $(e.currentTarget);
        var photo_id = el.attr('data-id');
        var count = el.parent().find('span').text();
        if(count == ''){
            count = 0;
        }
        count = parseInt(count);
        $.ajax({
            url: ajax_url,
            data: {action: 'like_photo', id: photo_id, _token: token},
            dataType: 'JSON',
            type: 'POST',
            success: function (res) {
                if(res.status === 'success'){
                    if(res.type === 'like'){
                        count = count+1;
                        el.removeClass('far');
                        el.addClass('fas');
                        el.parent().find('span').text(count);
                    }
                    else{
                        el.removeClass('fas');
                        el.addClass('far');
                        count = count-1;
                        if(count === 0){
                            el.parent().find('span').empty();
                        }
                        else{
                            el.parent().find('span').text(count);
                        }
                    }
                }
                else if(res.status === 'login'){
                    $('.modal').modal('hide');
                    $('#modalLogin').modal('show');
                }
            }
        })
    });
    $(document).on('click','.photo-item.view-photo', function (e) {
        var el = $(e.currentTarget);
        var photo_id = el.attr('data-id');
        var url = el.attr('data-url');
        // alert(url);
        var modalBody = $('#modalPhoto .modal-body');
        modalBody.empty();
        $.ajax({
            url: ajax_url,
            data: {action: 'view_photo', _token: token, id: photo_id},
            dataType: 'JSON',
            type: 'POST',
            success: function (res) {
                if(res.status == 'success') {
                    modalBody.append(res.html);
                    $('#modalPhoto').modal('show').css({opacity: 0});
                    $('.view-photo-right .content-photo').mCustomScrollbar();
                    var image_box_width = modalBody.find('.full_photo').width();
                    // console.log(image_box_width);
                    // modalBody.find('.full_photo').height('auto');
                    // modalBody.find('.view-photo-right').height('auto');
                    $('.view-photo-right .content-photo').mCustomScrollbar('scrollTo', '100%');
                    // if(res.height >= res.width){
                    //     if(res.height >= image_box_width){
                    //         modalBody.find('.full_photo img').height('auto');
                    //     }
                    // }
                    // else{
                    //     if(res.height >= image_box_width){
                    //         modalBody.find('.full_photo img').width('auto');
                    //     }
                    // }
                    $('#modalPhoto').css({opacity: 1});
                }
            }
        });

    });
    $(document).on('click','.search-content .pagination .page-link', function (e) {
        var el = $(e.currentTarget);
        if(!el.hasClass('active')){
            var page = el.attr('data-page');
            var data = $('#formFilter').serialize();
            $.ajax({
                url: ajax_url,
                data: data,
                dataType: 'HTML',
                type: 'POST',
                beforeSend: function(xhr, settings){
                    settings.data += '&action=search_more&page='+page+'&_token='+token;
                },
                success: function (res) {
                    $('.search-content').empty();
                    $('.search-content').append(res);
                    return false;
                }
            })
        }
        return false;
    });
    if($('#register-birthday').length) {
        $('#register-birthday').datepicker({
            format: 'yyyy-mm-dd',
            endDate:'-15y'
        });
    }

    function validateEmail(email)
    {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
    /*REGISTRATION*/
    $('#register-username').on('keyup change',function (e) {
        var username = $(this).val();
        if(username.length > 6){
            $.ajax({
                url: ajax_url,
                data: {action: 'check_username', username: username, _token: token},
                dataType: 'JSON',
                type: 'POST',
                success: function (res) {
                    if(res.status == 'error'){
                        $('#register-username').addClass('invalid');
                        $('#register-username').parent().find('.helper').remove();
                        $('#register-username').parent().append('<p class="helper text-danger">Username already exist</p>');
                    }
                    else{
                        $('#register-username').removeClass('invalid');
                        $('#register-username').parent().find('.helper').remove();
                    }
                }
            });
        }
    });
    $('#register-email').on('keyup change',function (e) {
        var email = $(this).val();
        if(email.length > 6){
            $.ajax({
                url: ajax_url,
                data: {action: 'check_email', email: email, _token: token},
                dataType: 'JSON',
                type: 'POST',
                success: function (res) {
                    if(res.status == 'error'){
                        $('#register-email').addClass('invalid');
                        $('#register-email').parent().find('.helper').remove();
                        $('#register-email').parent().append('<p class="helper text-danger">Email already exist</p>');
                    }
                    else{
                        $('#register-email').removeClass('invalid');
                        $('#register-email').parent().find('.helper').remove();
                    }
                }
            });
        }
    });
    var register_interests = $('#register-interests-input').length && $('#register-interests-input').val() !== '' ?$('#register-interests-input').val().split(',') : [];
    $('.interest-item').click(function(){
        var id = $(this).attr('data-id');
        if($(this).hasClass('active')){
            register_interests.splice(register_interests.indexOf(id),1);
        }
        else{
            register_interests.push(id);
        }
        console.log(register_interests.join(','));
        $('#register-interests-input').val(register_interests.join(','));
        $(this).toggleClass('active');
    });
    $('.nav-tabs .nav-item a').click(function(){
        if(!$(this).hasClass('confirmed')){
            return false;
        }
    });
    $('.nav-tabs .nav-item a.confirmed').click(function(e){
        e.preventDefault();
        $(this).tab('show');
    });
    $('.btn-age').click(function(e){
        e.preventDefault();
        var username = $('#register-username').val();
        var email = $('#register-email').val();
        var password = $('#register-password').val();
        var password_confirm = $('#register-password-confirm').val();
        var gender = $('#register-gender').val();
        var preference = $('#register-preference').val();
        var errors = [];
        if($('#register-username').hasClass('invalid')){
            errors.push('Username already exist');
        }
        if($('#register-email').hasClass('invalid')){
            errors.push('Email already exist');
        }
        if(username === ''){
            errors.push('Username is required');
        }
        if(username.length < 6){
            errors.push('Username minimum 6 characters');
        }
        if(email === ''){
            errors.push('Email is required');
        }
        else if(!validateEmail(email)){
            errors.push('Email is not validated');
        }
        if(password === ''){
            errors.push('Password is required');
        }
        if(password_confirm === ''){
            errors.push('Confirm Password is required');
        }
        if(password !== password_confirm){
            errors.push('Password does not match');
        }
        if(password.length < 6){
            errors.push('Password minimum 6 characters');
        }
        if(gender === ''){
            errors.push('Gender is required');
        }
        if(preference === ''){
            errors.push('Preference is required');
        }
        if(errors.length){
            var html = '<div class="alert alert-warning alert-dismissible fade show" role="alert"><ul class="mb-0">';
            $.each(errors, function(idx, val){
                html += '<li>'+val+'</li>';
            });
            html += '</ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $('#register-account').prepend(html);
            setTimeout(function(){
                $('#register-account .alert').remove();
            }, 3000);
        }
        else{
            $('#account-tab').addClass('confirmed');
            $('#age-tab').addClass('confirmed');
            $('#age-tab').click();
        }
    });
    $('.btn-interests').click(function(e){
        e.preventDefault();
        var day = $('#register-day').val();
        var month = $('#register-month').val();
        var year = $('#register-year').val();
        var address = $('#register-address').val();
        var country = $('#register-country').val();
        var errors = [];
        if(day === ''){
            errors.push('Day field is required');
        }
        if(month === ''){
            errors.push('Month field is required');
        }
        if(year === ''){
            errors.push('Year field is required');
        }
        if(address === ''){
            errors.push('Address field is required');
        }
        if(country === ''){
            errors.push('Country field is required');
        }
        if(errors.length){
            var html = '<div class="alert alert-warning alert-dismissible fade show" role="alert"><ul class="mb-0">';
            $.each(errors, function(idx, val){
                html += '<li>'+val+'</li>';
            });
            html += '</ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $('#register-age').prepend(html);
            setTimeout(function(){
                $('#register-age .alert').remove();
            }, 3000);
        }
        else{
            $('#interest-tab').addClass('confirmed');
            $('#interest-tab').click();
        }
    });
    $('.btn-about').click(function(e){
        e.preventDefault();
        var errors = [];
        if($('#register-interests-input').val() === ''){
            errors.push('Please choose some interests');
            var html = '<div class="alert alert-warning alert-dismissible fade show" role="alert"><ul class="mb-0">';
            $.each(errors, function(idx, val){
                html += '<li>'+val+'</li>';
            });
            html += '</ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $('#register-interests').prepend(html);
            setTimeout(function(){
                $('#register-interests .alert').remove();
            }, 3000);
        }
        else{
            $('#about-tab').addClass('confirmed');
            $('#about-tab').click();
        }
    });
    $('#formRegister').on('submit',function (e) {
        var username = $('#register-username').val();
        var email = $('#register-email').val();
        var password = $('#register-password').val();
        var password_confirm = $('#register-password-confirm').val();
        var gender = $('#register-gender').val();
        var preference = $('#register-preference').val();
        var day = $('#register-day').val();
        var month = $('#register-month').val();
        var year = $('#register-year').val();
        var address = $('#register-address').val();
        var country = $('#register-country').val();
        var errors = [];
        if($('#register-username').hasClass('invalid')){
            errors.push('Username already exist');
        }
        if($('#register-email').hasClass('invalid')){
            errors.push('Email already exist');
        }
        if(username === ''){
            errors.push('Username is required');
        }
        if(username.length < 6){
            errors.push('Username minimum 6 characters');
        }
        if(email === ''){
            errors.push('Email is required');
        }
        else if(!validateEmail(email)){
            errors.push('Email is not validated');
        }
        if(password === ''){
            errors.push('Password is required');
        }
        if(password_confirm === ''){
            errors.push('Confirm Password is required');
        }
        if(password !== password_confirm){
            errors.push('Password does not match');
        }
        if(password.length < 6){
            errors.push('Password minimum 6 characters');
        }
        if(gender === ''){
            errors.push('Gender is required');
        }
        if(preference === ''){
            errors.push('Preference is required');
        }
        if(day === ''){
            errors.push('Day field is required');
        }
        if(month === ''){
            errors.push('Month field is required');
        }
        if(year === ''){
            errors.push('Year field is required');
        }
        if(address === ''){
            errors.push('Address field is required');
        }
        if(country === ''){
            errors.push('Country field is required');
        }
        if($('#register-interests-input').val() === ''){
            errors.push('Please choose some interests');
        }
        if(errors.length){
            e.preventDefault();
            var html = '<div class="alert alert-warning alert-dismissible fade show" role="alert"><ul class="mb-0">';
            $.each(errors, function(idx, val){
                html += '<li>'+val+'</li>';
            });
            html += '</ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $('#formRegister .tab-content .tab-pane.active').prepend(html);
            setTimeout(function(){
                $('#formRegister .tab-content .tab-pane.active .alert').remove();
            }, 3000);
            return false;
        }
    });
    if($('#register-upload-avatar').length){
        var $inputImage = $('#register-avatar');
        var $imageCover = $('#register-upload-avatar');
        var originalImageURL = $imageCover.attr('src');
        $('.register-upload-avatar .clear-avatar').click(function(){
            $inputImage.val('');
            $imageCover.cropper('destroy').attr('src', originalImageURL).cropper(cropOptions);
            $(this).hide();
        });
        var cropOptions = {
            aspectRatio: 1/1,
            cropBoxResizable: false,
            minCropBoxWidth: 250,
            minContainerWidth: 250,
            minContainerHeight: 250,
            viewMode: 3,
            minCropBoxHeight: 250,
            crop: function (e) {
                $('.register-upload-avatar #x').val(e.detail.x);
                $('.register-upload-avatar #y').val(e.detail.y);
                $('.register-upload-avatar #w').val(e.detail.width);
                $('.register-upload-avatar #h').val(e.detail.height);
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
                    $('.register-upload-avatar .clear-avatar').show();
                } else {
                    window.alert('Please choose an image file.');
                }
            }
        });
    }
});
var restrictCountry = $('#register-country').val();
var autocomplete;
function initMap() {
    var options = {
        types: ['establishment'],
        componentRestrictions: {country: restrictCountry},
    };
    var input = document.getElementById('register-address');
    autocomplete = new google.maps.places.Autocomplete(input, options);
    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();
        var storableLocation = {};
        for (var ac = 0; ac < place.address_components.length; ac++) {
            var component = place.address_components[ac];

            switch(component.types[0]) {
                case 'locality':
                    storableLocation.city = component.long_name;
                    break;
                case 'administrative_area_level_1':
                    storableLocation.state = component.short_name;
                    break;
                case 'country':
                    storableLocation.country = component.long_name;
                    storableLocation.registered_country_iso_code = component.short_name;
                    break;
            }
        };
        $('#register-address').val((typeof storableLocation.city!= "undefined"? storableLocation.city+', ':'')+storableLocation.state);
        $('#register-lat').val(place.geometry.location.lat());
        $('#register-lng').val(place.geometry.location.lng());
    });
    document.getElementById('register-country').addEventListener('change', setAutocompleteCountry);
}
function setAutocompleteCountry(){
    var country = document.getElementById('register-country').value;
    autocomplete.setComponentRestrictions({'country': country});
}
