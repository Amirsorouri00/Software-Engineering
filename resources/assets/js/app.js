var io = require('socket.io-client');
var Vue = require('vue');
var VueResource = require('vue-resource');
Vue.use(VueResource);
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');//in meta in template
var sss = 12;
var interval
var app5 = new Vue({
    el: '#app-5',
    data: {
        message: 'not defind',
        timeR: 10,
        roundnum: 0,
        num1: 0,
        num2: 20,
        cansend: true,
        errormessage: '',
        studentid:''
    },
    watch: {
        num1: {
            handler: function (val, oldval) {
                if (val > this.num2 || val > 20 || val < 0) {
                    console.log(val)
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
                if (val < this.num1 || val > 20 || val < 0) {
                    console.log(val)
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


                    this.submit();
                }
            },
            deep: true
        }
    },
    methods: {
        gameover: function () {
            clearInterval(interval);
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
            this.gameover();
            var data={'num1':this.num1,'num2':this.num2,'roundnumber':this.roundnumber,'studentid':this.studentid};
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
var c = io.connect('http://localhost:0158', {query: "username=" + "MetR2I7"});
//var socket = io.connect('http://localhost:0158');

c.on('updateroundnumber', function (data) {


    app5.$data.message = data;

});

c.on('showmodal', function (data) {
    console.log('im hear');
    if (data == 1) {
        $('.ui.modal')
            .modal('show')
        ;
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