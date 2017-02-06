(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');//in meta in template
var individualStatus = document.querySelector('#teacher').getAttribute('content');
var status = document.querySelector('#status').getAttribute('content');
var max = document.querySelector('#max').getAttribute('content');

new Vue({
  el: '#guestexam',

  data: {
    newExam: {
      examID: '',
      id: ''
    },
    submitted: false,
    error: 0,
  },

  computed: {
    errors: function errors() {
      if (status == 0 || this.error == 0) {
        return true;
      }
      else {
        return false;
      }
      /*
      for (var key in this.newExam) {
        if (!this.newExam[key]) {
          return true;
        }
      }
      return false;*/
    },
    notstarted: function(){
      if (max == 0) {
        console.log(max);
        return false;
      }
      else {
        return true;
      }
    }
  },

  ready: function ready() {
    if (status == 0) {
      this.error = 0;
    }
    else {
      this.error = 1;
    }
    this.fetchexam();
  },

  methods: {
    fetchexam: function fetchexam() {
      //this.$http.get('http://localhost:3001/api/exams', function(messages){
      //this.exams = messages;
      //this.$set('exams', messages);
      console.log(status);
      console.log('hello');
      this.$http.get('/api/teacherstatus').then(function (response) {
        _this.$set('exams', response.body);
      }, function (response) {
        // error callback
      });
    },

    onSubmitForm: function onSubmitForm(event) {
      //prevent the default Action
      event.preventDefault();
      //add new exam to exams array
      //this.exams.push(this.newExam);
      console.log(status);
      this.submitted = true;
      this.error = 0;
      status = 0;
      //reset input values
      this.newExam = { examID: '', id: '' };
      //send post ajax request
      this.$http.post('/api/teacherstatus', {'json': individualStatus}).then(function (response) {
        _this.$set('exams', response.body);
      }, function (response) {
        // error callback
      });
      //show thanks messages

      //hide the submit button
    }
  }
});

},{}]},{},[1]);

//# sourceMappingURL=guestexam.js.map
