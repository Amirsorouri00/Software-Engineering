var io = require('socket.io-client');
var Vue = require('vue');
var VueResource = require('vue-resource');
Vue.use(VueResource);
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');//in meta in template
var sss = 12;
var userID = $('meta[name=userid]').attr('content');
var interval
var app5 = new Vue({
    el: '#main',
    data: {
        message: 'not defind',
        timeR: 10,
        roundnum: 0,
        num1: 0,
        num2: 20,
        startroundtime: 0,
        cansend: true,
        errormessage: '',
        studentid: userID
    },

    watch: {
        num1: {
            handler: function (val, oldval) {

                console.log(val)
                if (isNaN(val)) {
                    console.log('hear')
                    this.num1 = oldval
                }
                if (val > 20 || val < 0) {
                    console.log(val)
                    this.num1 = oldval

                    this.errormessage = "بازه نمره به درسستی وارد نشده است"
                    this.cansend = false;
                }
                else {
                    this.cansend = true;
                    this.errormessage = ''
                }
            }
        }, num2: {
            handler: function (val, oldval) {
                if (isNaN(val)) {
                    this.num2 = oldval
                }
                if (val > 20 || val < 0) {
                    console.log(val)
                    this.num2 = oldval
                    this.errormessage = "بازه نمره به درسستی وارد نشده است"
                    this.cansend = false;
                }
                else {
                    this.errormessage = ''
                    this.cansend = true;
                }
            }
        },
        timeR: {
            handler: function (val, oldVal) {

                console.log(val)
                if (val < 0) {

console.log('injasssssssssssssssssssssssssss')
                    this.submit();
                }
            },
            deep: true
        }
    },
    methods: {
        sendtest: function () {

            this.$http.get('http://www.google.com').then(function (s) {
                console.log('OKKKKKKKKKKK')
            }, function (er) {
                console.log(er)

            });

        },
        gameover: function () {
            clearInterval(interval);
            this.timeR = 120
            $('.ui.modal')
                .modal('hide')
            ;
            $('#dmm').dimmer({
                    closable: false
                })
                .dimmer('show')
            ;
        },
        submit: function () {
            if (!this.num1) {
                this.num1 = 0
            }
            else if (!this.num2) {
                this.num2 = 20;
            }
            console.log(this.num1)
            this.gameover();
            var data = {
                'num1': this.num1,
                'num2': this.num2,
                'roundnumber': this.roundnumber,
                'studentid': this.studentid
            };
            this.$http.post('/Ajtest', data).then(function (res) {
                console.log(res)
            }, function (err) {

            });
        },
        fnm: function () {

            this.timeR--;

        },
        reverseMessage: function () {
            console.log('timer', this.message)

            console.log(c.id);
            interval = setInterval(this.fnm, 1000);

            /*
             $('#main').addClass('dimmer');
             $('.dimmer').dimmer('show');
             */

            // this.message = this.message.split('').reverse().join('')
        },
        close: function () {
            $('#dmm').dimmer({
                    closable: false
                })
                .dimmer('show')
            ;


        },
        Aj: function () {
            // this.message = this.message.split('').reverse().join('')
            console.log('iam hear')

            this.$http.post('/Ajtest', [sdfd = ['sdf'], 'data']).then(function (res) {

                console.log('sssssss', res.body.name);

            }, function (err) {

            });
            console.log('ssssssdddddsssss');
        }
    }
})

var aap = new Vue({
    el: '#aap',
    data: {},
    methods: {
        close: function () {
            $('.ui.modal').modal()
        }
    }
})

//var c = io.connect('http://localhost:158', {query: "username=" + "{{ Auth::user()->name}}"});

var c = io.connect('51.254.79.220:3618', {query: "username=" + userID });

//var socket = io.connect('http://localhost:0158');

c.on('updateroundnumber', function (data) {


    app5.$data.message = data;
    app5.$data.roundnum = data;

});
c.on('setstartroundtime', function (data) {

    app5.$data.timeR = data;

})
c.on('gotoquestionpart', function (data) {
    console.log('heeeeeeeeeeeeeee')
    var sendv = new Vue();
    //  window.location = "http://www.google.com";
    app5.sendtest();


})
c.on('redirect', function (data) {
    if (data == 1) {
        window.location = "http://77.244.214.149:2000/"+userID;//Todo send to question part with user id
    }


})
c.on('loading', function (data) {

    if (data == 1) {
        app5.gameover();
    }
})
c.on('showmodal', function (data) {
    console.log('im hear');
    if (data == 1) {
        $('.ui.modal')
            .modal('show')
        ;
        interval = setInterval(app5.fnm, 1000);

    }
    /*
     $('#dmm').dimmer({
     closable: false
     })
     .dimmer('show')
     ;
     */
    sss = data;
    // app5.close();
    app5.$data.message = data;
    $("#messages").append("<p>" + data + "</p>");

});
