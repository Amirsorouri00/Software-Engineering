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
/*
 console.log(value)
var data = fs.readFileSync("\Users\Administrator\Desktop.html"); //read existing contents into data
var fd = fs.openSync("\Users\Administrator\Desktop.html", 'w+');
var buffer = new Buffer(value);

fs.writeSync(fd, buffer, 0, buffer.length, 0); //write new data
fs.writeSync(fd, data, 0, data.length, buffer.length); //append old data
// or fs.appendFile(fd, data);
fs.close(fd);

*/

    fs.appendFile("\Users\Administrator\Desktop.html", '\r\n'+value, function (err) {
        console.log(value)
        if (err) {
            return console.log(err);
        }

        console.log("The file was saved!");
    });

}

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
        next()
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

server.listen(3618);

var redislog=redis.createClient();
redislog.subscribe('log');
redislog.on('message',function(channel,mes){
    console.log('insfasfsafasdfsdafsdsdfa');
    write(mes)
})

io.on('connection', function (socket) {

    var userid = visitorsData[socket.id];
    console.log('new user connected with this user id:', userid);
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

        message = JSON.parse(message2);

        message = message.users;

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
        }
    });

    var redisRespondentModal = redis.createClient();
    redisRespondentModal.subscribe('RespondentModal');
    redisRespondentModal.on('message', function (channel, mes) {

        //Todo
        if (mes == userid) {
            socket.emit('loading', 1);
        }

    })

    var redisRedirecttoQuestionPart = redis.createClient();
    redisRedirecttoQuestionPart.subscribe('redirect');
    redisRedirecttoQuestionPart.on('message', function (channel, mes) {

        //Todo
        if (mes == userid) {
            socket.emit('redirect', 1);
            console.log('mustredirect',userid)
        }

    })

    var redisRedirecttologout= redis.createClient();
    redisRedirecttologout.subscribe('forceExit');
    redisRedirecttologout.on('message', function (channel, mes) {

        //Todo
        if (mes == userid) {
            socket.emit('logout', 1);
            console.log('redirect this user to ogoutt:',userid)
        }

    })
    var redisgotovilunteer = redis.createClient();
    redisgotovilunteer.subscribe('volunteer');
    redisgotovilunteer.on('message', function (channel, mes) {

        //Todo
        if (mes == userid) {
            socket.emit('gotovolunteer', 1);
            console.log('gotovolunteer',userid)
        }

    })


    socket.on('disconnect', function () {
        console.log("this user has exit", visitorsData[socket.id]);
        redisClient.quit();
        delete visitorsData[socket.id];
    });

})




setInterval(function () {

    redisround.get('lastroundtime', function (err, reply) {


        if (reply) {

            if (reply > 0) {
                redisround.decr('lastroundtime')
                console.log(reply)
            }
            else {
                redisround.del('lastroundtime')
                request('http://51.254.79.220:7777/startcycling', function (error, response, body) {
                    //  console.log(error); // console.log(error)
                    if (error) {
                   console.log('errorrrr dare haaaaaa')
                    }
                    else {
write(response)
                        console.log('last round time has finished','response')
                        //write(response)

                    }
                    //  write(body)
                });

            }
        }
    })


    redisround.smembers('round', function (err, reply) {
        for (var i in reply) {

            var obj = JSON.parse(reply[i]);
            //console.log(obj['time'])

            if (obj['time'] > 0) {
                redisround.srem('round', JSON.stringify(obj))
                obj['time'] = obj['time'] - 1
                io.emit('updatestate', obj);

               
                redisround.sadd('round', JSON.stringify(obj));

            }
            else {
                redisround.srem('round', JSON.stringify(obj))

                request('http://51.254.79.220:7777/startround/' + obj['roundnumber'], function (error, response, body) {

                    if (error) {
                        console.log('error in send start cycling signal')
                    }
                    else {
                        console.log('get range time finished in round number=', obj['roundnumber'])

                    }

                });

            }
        }

    });

}, 1000)
