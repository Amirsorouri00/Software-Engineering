var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();
redis.subscribe('message', function(err, count) {
});
redis.on('message', function(channel, message) {
    console.log('Message Recieved: ' + message);
    //message = JSON.parse(message);
    io.emit(channel, message);
});
http.listen(3000, function(){
    console.log('Listening on Port 3000');
});

io.on('connection', function (socket) {
   console.log('new client connected');
});