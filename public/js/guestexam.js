//var http = require('http');
new Vue({
    el: '#guestexam',

    data: {
      newExam: {
        examID: 'examID',
        id: 'id'
      }
    },

    ready: function() {
      this.fetchexam();
    },

    methods: {
      fetchexam: function() {
          //this.$http.get('http://localhost:3001/api/exams', function(messages){
          //this.exams = messages;
          //this.$set('exams', messages);
          console.log('hello');
          this.$http.get('/api/exams').then(response => {
          this.$set ('exams', response.body)
        }, response => {
            // error callback
        });
      }
    }
});
