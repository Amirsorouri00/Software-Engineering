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

    onSubmitForm: function(event){
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

},{}]},{},[1]);

//# sourceMappingURL=guestexam.js.map
