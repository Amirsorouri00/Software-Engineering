(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";

(function e(t, n, r) {
  function s(o, u) {
    if (!n[o]) {
      if (!t[o]) {
        var a = typeof require == "function" && require;if (!u && a) return a(o, !0);if (i) return i(o, !0);var f = new Error("Cannot find module '" + o + "'");throw f.code = "MODULE_NOT_FOUND", f;
      }var l = n[o] = { exports: {} };t[o][0].call(l.exports, function (e) {
        var n = t[o][1][e];return s(n ? n : e);
      }, l, l.exports, e, t, n, r);
    }return n[o].exports;
  }var i = typeof require == "function" && require;for (var o = 0; o < r.length; o++) {
    s(r[o]);
  }return s;
})({ 1: [function (require, module, exports) {
    'use strict';

    //var http = require('http');

    new Vue({
      el: '#guestexam',

      data: {
        newExam: {
          examID: '',
          id: ''
        },
        submitted: false
      },

      computed: {
        errors: function errors() {
          for (var key in this.newExam) {
            if (!this.newExam[key]) {
              return true;
            }
          }
          return false;
        }
      },

      ready: function ready() {
        console.log('manam manam');
        this.fetchexam();
      },

      methods: {
        fetchexam: function fetchexam() {
          var _this = this;

          //this.$http.get('http://localhost:3001/api/exams', function(messages){
          //this.exams = messages;
          //this.$set('exams', messages);
          console.log('hello');
          this.$http.get('/api/exams').then(function (response) {
            _this.$set('exams', response.body);
          }, function (response) {
            // error callback
          });
        },

        onSubmitForm: function onSubmitForm(event) {
          console.log('manam manam');
          event.preventDefault();
          /*
          if (teacher->individualStatus == 0 && teacher->accessibility == 1) {
              teacher->individualStatus = 1;
              submitted = false;
              this.$http.post('teacherUpdateStatus', teacher).then((response) => {
                }, (error) => {
                })
          }*/
        },

        enterToGame: function onSubmitForm(event) {
          //prevent the default Action
          event.preventDefault();
          //add new exam to exams array
          this.exams.push(this.newExam);
          //reset input values
          this.newExam = { examID: '', id: '' };
          //send post ajax request
          //show thanks messages
          this.submitted = true;
          //hide the submit button
        }
      }
    });
  }, {}] }, {}, [1]);



},{}]},{},[1]);

//# sourceMappingURL=teacher-main.js.map
