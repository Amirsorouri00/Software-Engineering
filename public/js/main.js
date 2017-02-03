var jq = require('jquery');
var io = require('socket.io-client');
var Vue = require('vue');
var sss = 'hgjhg';
var app5 = new Vue({
    el: '#app-5',
    data: {
        message: sss
    },
    methods: {
        reverseMessage: function () {
            this.message = this.message.split('').reverse().join('')
            $('.ui.modal')
                .modal();
        },
        close: function () {
            $('.ui.modal')
                .modal()
            ;

        }
    }
})

var aap = new Vue({
    el: '#aap',
    data: {},
    methods: {
        close: function () {
            $('.ui.modal').modal('hide')
        }
    }
})

var c = io.connect('http://localhost:158', {query: "username=" + "{{ Auth::user()->name}}"});
//var socket = io.connect('http://localhost:0158');


c.on('folan', function (data) {
    sss = data;
    app5.$data.message = data;
    $("#messages").append("<p>" + data + "</p>");

});
