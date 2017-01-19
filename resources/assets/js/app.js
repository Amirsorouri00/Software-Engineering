var io = require('socket.io-client');
var Vue = require('vue');
var VueResource = require('vue-resource');
Vue.use(VueResource);
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');//in meta in template
var sss = 1;
var app5 = new Vue({
    el: '#app-5',
    data: {
        message: 1,
        timeR: 10
    },
    watch: {
        timeR: {
            handler: function (val, oldVal) {
                if (val < 0) {
                    $('.ui.modal')
                        .modal('hide')
                    ;
                    $('#dmm').dimmer({
                            closable: false
                        })
                        .dimmer('show')
                    ;


                }
            },
            deep: true
        }
    },
    methods: {
        fnm: function () {

            this.timeR--;

        },
        reverseMessage: function () {
            console.log('timer', this.message)


            var myVar = setInterval(this.fnm, 1000);

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

var c = io.connect('http://localhost:158', {query: "username=" + "{{ Auth::user()->name}}"});
//var socket = io.connect('http://localhost:0158');


c.on('folan', function (data) {
    $('.ui.modal')
        .modal('hide')
    ;
    $('#dmm').dimmer({
            closable: false
        })
        .dimmer('show')
    ;

    sss = data;
    // app5.close();
    app5.$data.message = data;
    $("#messages").append("<p>" + data + "</p>");

});