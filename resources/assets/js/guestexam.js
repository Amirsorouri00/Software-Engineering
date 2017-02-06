//var http = require('http');
new Vue({
    el: '#guestexam',

    data: {
      newExam: {
        examID: '',
        id: ''
      },
      submitted: false,
    },

    computed: {
      errors: function(){
        for(var key in this.newExam){
          if( !this.newExam[key] ){
            return true;
          }
        }
        return false;
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
      },

      onSubmitForm: function(event){
        //prevent the default Action
        event.preventDefault();
        //add new exam to exams array
        this.exams.push(this.newExam);
        //reset input values
        this.newExam = {examID : '', id : '',};
        //send post ajax request
        //show thanks messages
        this.submitted = true;
        //hide the submit button

      }
    }
});
