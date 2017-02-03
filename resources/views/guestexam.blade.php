<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>GUESTEXAM</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <style media="screen">
      body {padding: 2em 0;}
    </style>
  </head>
  <body class="container">

    <div class="" id="guestexam">

        <form class="" v-on:="submit: onSubmitFrom" action="index.html" method="post">
          <div class="form-group">
            <label for="examID">ExamID: </label>
            <input type="text" v-model="newExam.examID" name="examID" id="examID" class="form-control" value="">
          </div>

          <div class="form-group">
            <label for="id">ID: </label>
            <input type="text" v-model="newExam.id" name="id" id="id" class="form-control" value="">
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-default" name="button">
              Sign Guestexam
            </button>
          </div>

        </form>

        <hr>

        <article class="" v-repeat="exams">
            <h3>@{{ examID }}</h3>
            <div class="body">
                @{{ id }}
            </div>
        </article>

        <pre>
            @{{ $data | json }}
        </pre>
    </div>

    <script src="js/vendor.js"></script>
    <script src="js/guestexam.js"></script>
  </body>
</html>
