var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

console.log("hi");

var visitorsData = {};

io.use(function (socket, next) {
    var handshakeData = socket.request;
    visitorsData[socket.id] = handshakeData._query['username']
    console.log("middleware:", handshakeData._query['username']);
    next();
});

server.listen(158);
io.on('connection', function (socket) {
  //  console.log("new client connected");
      console.log(socket.id);
    var username = visitorsData[socket.id];

    var redisClient = redis.createClient();
    redisClient.subscribe('message');
    // redisClient.suscribe('message2');
    redisClient.on("message", function (channel, message2) {
        console.log("message2 is", message2);
        message = JSON.parse(message2);

        socket.emit('folan', '1');
      //  console.log(typeof (message));
       // console.log(message.mohsen);
      //  console.log("message.name is", message.ali);
       // console.log("username is", visitorsData[socket.id]);
        message = message.users;
      //  console.log("After Array : ",message)
        for ( var v in message ) {
            console.log(message[v].username)
            console.log(username)
            if(message[v].username==username)
            {
                console.log('yes')
                console.log(username)
                socket.emit('folan', '1');
                break;
            }
          //  console.log("V = ",v)
           //   console.log("Username = ", message[v].username , "Age = ", message[v].Age);
        }

       /* message.usernames.forEach(function(item)
        {

        });*/

        //    console.log("channel:"+ channel);
        //if channel set true and in redis set this socket has operation the emit

    });
    /*  redisClient.on("message2", function(channel, message) {
     //   message=JSON.parse(message);
     console.log("mew message in queue "+ message + "channel");
     socket.emit(channel,message);
     });*/
    socket.on('disconnect', function () {
        console.log("this user has exit", visitorsData[socket.id]);
        redisClient.quit();
    });

});

