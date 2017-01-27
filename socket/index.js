var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');
var request = require('request');
var fs = require('fs');
var http = require("http");
/*

 */
var r;
var redisround = redis.createClient();
var socketsmap = new Map()
function write(value) {
    fs.writeFile("\Users\Administrator\Desktop.html", value, function (err) {
        if (err) {
            return console.log(err);
        }

        console.log("The file was saved!");
    });

}
setInterval(function () {

    redisround.get('lastroundtime', function (err, reply) {


        if (reply) {

            if (reply < 10) {
                redisround.incr('lastroundtime')
            }
            else {
                redisround.del('lastroundtime')
                request('http://51.254.79.220:2222/startcycling/', function (error, response, body) {
                  //  console.log(error); // console.log(error)
                    if (error) {
                        // Show the HTML for the Modulus homepage.
                    }
                    else {

                    }
                  //  write(body)
                });

            }
        }
    })



    redisround.smembers('round', function (err, reply) {
        for (var i in reply) {

            var obj = JSON.parse(reply[i]);


            if (obj['time'] < 200) {
                redisround.srem('round',JSON.stringify(obj))
                obj['time'] = obj['time'] + 1
                redisround.sadd('round', JSON.stringify(obj));

            }
            else {
                redisround.srem('round',JSON.stringify(obj))
                
                request('http://51.254.79.220:2222/startround/'+obj['roundnumber'], function (error, response, body) {

                    if (error) {

                    }
                    else {

                    }

                });

            }
        }

    });

}, 1000)
var visitorsData = {};
var userinfo = {};

io.use(function (socket, next) {
    console.log('new user')
    var handshakeData = socket.request;
    newuserid = handshakeData._query['username']
    if (userinfo[newuserid]) {
        if (io.sockets.connected[userinfo[newuserid]['socketid']]) {
            io.sockets.connected[userinfo[newuserid]['socketid']].disconnect();
        }
        delete visitorsData[userinfo[newuserid]['socketid']]
        visitorsData[socket.id] = newuserid
        userinfo[newuserid]['socketid'] = socket.id
        //Todo reload history
        //Todo next
    }
    var tmp = {};
    tmp['socketid'] = socket.id;
    tmp['state'] = 0;
    tmp['startroundtime'] = 0;
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
    var redisGet = redis.createClient();
    redisGet.subscribe('goToquestionpart');
    socketsmap.set(userid, socket);
    redisGet.on('message', function (channel, mes) {

        if (mes == userid)
            socket.emit('gotoquestionpart')


    })

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

                redisround.smembers('round', function (err, reply) {


                    for (var i in reply) {
                        var round = JSON.parse(reply[i]);
                        if (round['roundnumber'] == message[v].roundnumber) {
                            socket.emit('setstartroundtime', round['time'])
                            userinfo[userid]['startroundtime'] = round['time']
                        }

                    }
                });
                socket.emit('showmodal', 1);
                console.log(socket.id)
                console.log(userinfo[message[v].userid]['socketid'])
                break;
            }
            //  console.log("V = ",v)
            //  console.log("V = ",v)
            //   console.log("Username = ", message[v].userid , "Age = ", message[v].Age);
        }
    });

    socket.on('disconnect', function () {
        console.log("this user has exit", visitorsData[socket.id]);
        redisClient.quit();
        delete visitorsData[socket.id];
    });

})
