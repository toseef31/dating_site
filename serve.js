var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var port = process.env.PORT || 2888;

io.on('connection', function(socket){
    socket.on('send-message', function(data){
        socket.broadcast.emit('receive-message', data);
    });
    socket.on('typing-message', function(data){
        socket.broadcast.emit('receive-typing-message', data);
    });
    socket.on('stop-typing', function(data){
        socket.broadcast.emit('receive-stop-typing', data);
    });
    socket.on('seen-all-message', function(data){
        socket.broadcast.emit('seen-all-message', data);
    });
    socket.on('seen-message', function(data){
        socket.broadcast.emit('seen-message', data);
    });
    socket.on('delete_conversation', function(data){
        socket.broadcast.emit('delete_conversation', data);
    });
    socket.on('call-incoming', function(data){
        socket.broadcast.emit('call-incoming', data);
    });
});

http.listen(port, function(){
    console.log('listening on *:' + port);
});