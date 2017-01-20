var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

console.log("hi");

var visitorsData = {};
var userinfo = {};

io.use(function (socket, next) {
    console.log('new user')
    var handshakeData = socket.request;
    newuserid = handshakeData._query['username']
    if (userinfo[newuserid]) {
if(io.sockets.connected[userinfo[newuserid]['socketid']])
        {
            io.sockets.connected[userinfo[newuserid]['socketid']].disconnect();
        }
        delete visitorsData[userinfo[newuserid]['socketid']]
    }
    var tmp = {};
    tmp['socketid'] = socket.id;
    tmp['state'] = 0;
    userinfo[newuserid] = tmp
    visitorsData[socket.id] = newuserid
    // console.log(userinfo)
    //  console.log(visitorsData)
    //console.log("middleware:", handshakeData._query['username']);
    next();
});

server.listen(0158);
io.on('connection', function (socket) {

    var userid = visitorsData[socket.id];
    console.log(userid);
    var redisClient = redis.createClient();
    redisClient.subscribe('message');

    redisClient.on("message", function (channel, message2) {
        //  console.log("message2 is", message2);
        message = JSON.parse(message2);

        //     socket.emit('folan', '1');
        //  console.log(typeof (message));
        // console.log(message.mohsen);
        //  console.log("message.name is", message.ali);
        // console.log("userid is", visitorsData[socket.id]);
        message = message.users;
        //  console.log('users', message);
        //  console.log("After Array : ",message)
        for (var v in message) {
            console.log(message[v].userid)
            console.log(message[v].roundnumber);
            if (message[v].userid == userid) {
                console.log('yes')
                console.log(userid)

                socket.emit('updateroundnumber', message[v].roundnumber);
                socket.emit('showmodal', 1);
                console.log(socket.id)
                console.log(userinfo[message[v].userid]['socketid'])
                break;
            }
            //  console.log("V = ",v)
            //   console.log("Username = ", message[v].userid , "Age = ", message[v].Age);
        }


    });

    socket.on('disconnect', function () {
        console.log("this user has exit", visitorsData[socket.id]);
        redisClient.quit();
        delete visitorsData[socket.id];
    });

});

