$(function () {
    var token = $('meta[name=csrf_token]').attr('content');
    var typing=false;
    var timeout=undefined;
    var socket = io(socket_url, {
       transports: [ 'websocket' ]
    });
    function typingTimeout(id,receive_id){
        typing = false;
        socket.emit('stop-typing', {id: parseInt(id), receive_id: parseInt(receive_id)});
    }

    function isHTML(str) {
        var a = document.createElement('div');
        a.innerHTML = str;

        for (var c = a.childNodes, i = c.length; i--; ) {
            if (c[i].nodeType == 1) return true;
        }

        return false;
    }

    $(document).on('click','.conversations .message-box .delete_conversation', function (event) {
        var el = $(event.currentTarget);
        var id = el.attr('data-id');
        var receive_id = el.attr('data-receive');
        var conf = confirm('Are you sure?');
        if(conf) {
            $.ajax({
                url: ajax_url,
                data: {action: 'delete_conversation', id: id, _token: token},
                dataType: 'JSON',
                type: 'POST',
                success: function (res) {
                    if (res.status === 'success') {
                        $('.conversations .message-box').empty();
                        $('#conversation-' + id).remove();
                        socket.emit('delete_conversation', {id: parseInt(id), receive_id: receive_id});
                    } else if (res.status === 'login') {
                        $('.modal').modal('hide');
                        $('#modalLogin').modal('show');
                    }
                }
            })
        }
    });

    $(document).on('click','.conversations .message-box .write-message .send-photo', function (event) {
        $('.conversations .message-box .write-message #imageChat').click();
    });
    $(document).on('change','.conversations .message-box .write-message #imageChat', function (event) {
        var el = $(event.currentTarget);
        if(el.get(0).files.length){
            var chatuploadProgress = $('.conversations .message-box .write-message .progress');
            $('#uploadChat').ajaxForm({
                beforeSend: function () {
                    chatuploadProgress.css({opacity:1});
                    chatuploadProgress.find('.progress-bar').css({width: 0});
                    chatuploadProgress.find('.progress-bar').attr('aria-valuenow', 0);
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    chatuploadProgress.find('.progress-bar').css({width: percentVal});
                    chatuploadProgress.find('.progress-bar').attr('aria-valuenow', percentComplete);
                },
                complete: function(xhr) {
                    var res = JSON.parse(xhr.responseText);
                    if(res.status === 'success'){
                        var id = $('#uploadChat').attr('data-id');
                        var receive_id = $('#uploadChat').attr('data-receive');
                        $('#conversation-'+id).each(function () {
                            $(this).parent().prepend(this);
                        });
                        $('.message-box .list-messages ul .mCSB_container').append(res.html);
                        if(isHTML(res.message)){
                            res.message = '<i class="far fa-image"></i> Image';
                        }
                        $('#conversation-'+id).find('p').html('You: '+res.message);
                        socket.emit('send-message', {message: res.message, id: parseInt(id), receive_id: parseInt(receive_id), message_id: parseInt(res.id), receive_html: res.receive_html, conversation_html: res.conversation_html, notice_html: res.notice_html});
                    }
                    el.val('');
                    $('.message-box .list-messages ul').mCustomScrollbar("scrollTo","bottom",{scrollInertia:0});
                    chatuploadProgress.find('.progress-bar').css({width: 0});
                    chatuploadProgress.find('.progress-bar').attr('aria-valuenow', 0);
                    chatuploadProgress.css({opacity:0});
                }
            });
            $('#uploadChat').submit();
        }
    });

    $('#uploadChat').ajaxForm({
        beforeSend: function () {
            chatuploadProgress.css({opacity:1});
            chatuploadProgress.find('.progress-bar').css({width: 0});
            chatuploadProgress.find('.progress-bar').attr('aria-valuenow', 0);
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            chatuploadProgress.find('.progress-bar').css({width: percentVal});
            chatuploadProgress.find('.progress-bar').attr('aria-valuenow', percentComplete);
        },
        complete: function(xhr) {
            var res = JSON.parse(xhr.responseText);
            if(res.status === 'success'){
                var id = $('#uploadChat').attr('data-id');
                var receive_id = $('#uploadChat').attr('data-receive');
                $('#conversation-'+id).each(function () {
                    $(this).parent().prepend(this);
                });
                $('.message-box .list-messages ul .mCSB_container').append(res.html);
                $('#conversation-'+id).find('p').html('You: '+res.message);
                socket.emit('send-message', {message: res.message, id: parseInt(id), receive_id: parseInt(receive_id), message_id: parseInt(res.id), receive_html: res.receive_html, conversation_html: res.conversation_html, notice_html: res.notice_html});
            }
            el.val('');
            $('.message-box .list-messages ul').mCustomScrollbar("scrollTo","bottom",{scrollInertia:0});
            chatuploadProgress.find('.progress-bar').css({width: 0});
            chatuploadProgress.find('.progress-bar').attr('aria-valuenow', 0);
            chatuploadProgress.css({opacity:0});
        }
    });

    $(document).on('keyup','.conversations .message-box input.message-input',function (event) {
        event.preventDefault();
        var el = $(event.currentTarget);
        var keycode = (event.keyCode ? event.keyCode : event.which);
        var id = el.attr('data-id');
        var receive_id = el.attr('data-receive');
        var sender_name = el.attr('data-sendername');
        if (keycode === 13) {
            clearTimeout(timeout);
            typingTimeout(id,receive_id);
            var message = el.val();
            $.ajax({
                url: ajax_url,
                data: {action: 'send_message', id: id, text: message, _token: token},
                dataType: 'JSON',
                type: 'POST',
                success: function (res) {
                    el.val('');
                    if(res.status === 'success'){
                        $('#conversation-'+id).each(function () {
                            $(this).parent().prepend(this);
                        });
                        $('.message-box .list-messages ul .mCSB_container').append(res.html);
                        $('#conversation-'+id).find('p').html('You: '+message);
                        $('.message-box .list-messages ul').mCustomScrollbar("scrollTo","bottom",{scrollInertia:0});
                        socket.emit('send-message', {message: message, id: parseInt(id), receive_id: parseInt(receive_id), message_id: parseInt(res.id), receive_html: res.receive_html, conversation_html: res.conversation_html, notice_html: res.notice_html});
                    }
                    else if(res.status === 'login'){
                        $('.modal').modal('hide');
                        $('#modalLogin').modal('show');
                    }
                    else if(res.status === 'wait'){
                        $('.message-box .write-message').addClass('waiting');
                    }
                }
            })
        }
        else{
            socket.emit('typing-message', {id: parseInt(id), receive_id: parseInt(receive_id), sender_name: sender_name});
            clearTimeout(timeout);
            timeout=setTimeout(function(){
                typing = false;
                socket.emit('stop-typing', {id: parseInt(id), receive_id: parseInt(receive_id)});
            }, 3000);
        }
    });

    $(document).on('click', '.conversations .list-conversations .conversation-item', function (event) {
        var el = $(event.currentTarget);
        var id = el.attr('data-id');
        $.ajax({
            url:ajax_url,
            data: {action: 'load_conversation', id: id, _token: token},
            dataType: 'JSON',
            type: 'POST',
            success: function (res) {
                if(res.status === 'success'){
                    $('.conversations .list-conversations .conversation-item').removeClass('active');
                    el.addClass('active');
                    $('.conversations .message-box').empty();
                    $('.conversations .message-box').append(res.html);
                    if(res.unread === 0){
                        $('#message-sidebar .badge').empty()
                    }
                    else{
                        $('#message-sidebar .badge').text(res.unread);
                    }
                    window.history.pushState({}, null, res.url);
                    $('.conversations .message-box .list-messages ul').mCustomScrollbar().mCustomScrollbar("scrollTo","bottom",{scrollInertia:0});
                    socket.emit('seen-all-message', id);
                }
            }
        })
    });

    socket.on('seen-all-message', function (id) {
        var boxMessage = $('#message-box-'+id);
        if (boxMessage.length) {
            boxMessage.find('.message.self .message-detail span').text('Seen');
        }
    });

    socket.on('seen-message', function (data) {
        var boxMessage = $('#message-box-'+data.id);
        var messageItem = $('#message-'+data.message_id);
        if (boxMessage.length && messageItem.length) {
            messageItem.find('.message-detail span').text('Seen');
        }
    });

    socket.on('delete_conversation', function (data) {
        var conversation = $('#conversation-'+data.id);
        var boxMessage = $('#message-box-'+data.id);
        if(conversation.length){
            conversation.remove();
        }
        if(boxMessage.length){
            $('.conversations .message-box').empty();
        }
    });

    socket.on('receive-message', function (data) {
        if(data.receive_id === logged_id){
            var conversation = $('#conversation-'+data.id);
            var boxMessage = $('#message-box-'+data.id);
            if($('.conversations').length) {
                if (conversation.length) {
                    conversation.each(function () {
                        $(this).parent().prepend(this);
                    });
                    conversation.find('p').html(data.message);
                } else {
                    $('.list-conversations ul').prepend(data.conversation_html);
                }
                if (boxMessage.length) {
                    $.ajax({
                        url: ajax_url,
                        data: {id: data.message_id, action: 'seen', _token: token},
                        dataType: 'JSON',
                        type: 'POST',
                        success: function (res) {

                        }
                    });
                    $('#message-box-' + data.id + ' .list-messages ul .mCSB_container').append(data.receive_html);
                    socket.emit('seen-message', {id: data.id, message_id: data.message_id});
                    $('#message-box-' + data.id + ' .list-messages ul').mCustomScrollbar("scrollTo", "bottom", {scrollInertia: 0});
                }
                else{
                    var unread = $('#message-sidebar .badge').text();
                    if(unread === ''){
                        unread = 0;
                    }
                    else{
                        unread = parseInt(unread);
                    }
                    $('#message-sidebar .badge').text(unread+1);
                }
            }
            else{
                var notice_html = $(data.notice_html);
                if($('.notifications .notification').length === 3){
                    $('.notifications .notification:last-child').remove();
                }
                notice_html.prependTo('.notifications').delay(60000).queue(function() {
                    $(this).remove();
                });
                var unread = $('#message-sidebar .badge').text();
                if(unread === ''){
                    unread = 0;
                }
                else{
                    unread = parseInt(unread);
                }
                $('#message-sidebar .badge').text(unread+1);
            }

            document.getElementById('message_audio').play();
        }
    });
    socket.on('receive-typing-message' ,function (data) {
        var boxMessage = $('#message-box-'+data.id);
        if(data.receive_id === logged_id && boxMessage.length){
            boxMessage.find('.write-message .typing').html(data.sender_name+' is typing <span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span>');
            boxMessage.find('.write-message .typing').show();
        }
    });
    socket.on('receive-stop-typing' ,function (data) {
        var boxMessage = $('#message-box-'+data.id);
        if(data.receive_id === logged_id && boxMessage.length){
            boxMessage.find('.write-message .typing').hide();;
        }
    });
    socket.on('call-incoming', function (data) {
        console.log(data);
        if(data.receive_id === logged_id){
            var html = '<div class="imcoming"><a href="'+data.url+'"><img src="'+data.avatar+'">Video call<strong>'+data.name+'</strong></a><span><i class="fa fa-phone"></i></span></div>';
            $('.notifications').prepend(html);
            document.getElementById('calling_audio').play();
        }
    });
});