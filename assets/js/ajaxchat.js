jQuery(document).ready(function ($) {
    var id = 0;
    if($('.conversation-item.active').length){
        id = $('.conversation-item.active').attr('data-id');
    }
    var token = $('meta[name=csrf_token]').attr('content');
    setInterval(function(){
        $.ajax({
            url: ajax_url,
            data: {action: 'check_messages', _token: token, id: id},
            dataType: 'JSON',
            type: 'POST',
            success: function (res) {
                if(res.status === 'success'){
                    $.each(res.result, function(id, item){
                        if($('#conversation-'+item.id).length){
                            $('#conversation-'+item.id).find('p').html(item.last_message);
                            $('#conversation-'+item.id).each(function(){
                                $(this).parent().prepend(this);
                            });
                            if($('#message-box-'+item.id).length){
                                if(item.messages.length){
                                    $.each(item.messages, function(im, message){
                                        if(!$('#message-'+message.id).length){
                                            $('#message-box-'+item.id+' .list-messages ul .mCSB_container').append(message.html);
                                            $('#message-box-'+item.id+' .list-messages ul').mCustomScrollbar("scrollTo","bottom",{scrollInertia:0});
                                        }
                                    });
                                }
                            }
                        }
                        else{
                            $('.list-conversations ul').prepend(item.html);
                            $('#conversation-'+item.id).each(function(){
                                $(this).parent().prepend(this);
                            });
                        }
                        document.getElementById('message_audio').play();
                    })
                }
            }
        })
    }, 3000);

    $(document).on('keyup','.conversations .message-box input.message-input',function (event) {
        var el = $(event.currentTarget);
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode === 13){
            var message = el.val();
            var id = el.attr('data-id');
            $.ajax({
                url: ajax_url,
                data: {action: 'send_message', id: id, text: message, _token: token},
                dataType: 'JSON',
                type: 'POST',
                success: function (res) {
                    el.val('');
                    if(res.status === 'success'){
                        $('.message-box .list-messages ul .mCSB_container').append(res.html);
                        $('#conversation-'+id).find('p').html('You: '+message);
                        $('.message-box .list-messages ul').mCustomScrollbar("scrollTo","bottom",{scrollInertia:0});
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
    });
});