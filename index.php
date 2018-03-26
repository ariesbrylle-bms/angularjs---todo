<!DOCTYPE html>
<html lang="en">
<head>
  <title>Todo -- Notes</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body ng-app="myApp">

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">myApp</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="#!todo">Todo</a></li>
      <li><a href="#!notes">Notes</a></li>
    </ul>
  </div>
</nav>
  
<div class="container" ng-view>
    Welcome to may App
</div>

</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.1/angular-sanitize.js"></script>

<script type="text/javascript">
  var app = angular.module("myApp", ["ngRoute", "ngSanitize"]); 

  app.config(function($routeProvider) {
      $routeProvider
      .when("/", {
          templateUrl : "./pages/welcome.php"
      })
      .when("/notes", {
          templateUrl : "./pages/notes.php",
          controller : "notes"
      })
      .when("/todo", {
          templateUrl : "./pages/todo.php",
          controller : "todo"
      });
  });


  app.controller("todo", function($scope, $http) {
      
      var formData = {
         title : "",
         id : ""
      };

      var id;

      var config = {
       params: {id : '0'},
       headers : {'Accept' : 'application/json'}
      };

      $scope.is_success = false;
      $scope.message = '';

      $http.get("./api/todo.php", config).then(function (response) {
        $scope.todo_data = response.data;
      });

      $scope.load_todo_table = function(){
        config = {
         params: {id : '0'},
         headers : {'Accept' : 'application/json'}
        };

        $scope.title = '';
        $scope.id = 0;

        $http.get("./api/todo.php", config).then(function (response) {
          $scope.todo_data = response.data;
        });
      }

      $scope.submitForm = function() {
          formData = { title: $scope.title, id : $scope.id };
          if ($scope.id > 0){
            $http.put('./api/todo.php', formData).then(function(){
                /*success callback*/
                $scope.is_success = true;
                $scope.message = 'To do List has been successfully Updated';
                $scope.load_todo_table();
              });
          }else{
              $http.post('./api/todo.php', formData).then(function(){
                /*success callback*/
                $scope.is_success = true;
                $scope.message = 'New To do List has been successfully Added';
                $scope.load_todo_table();
              });
          }
          
      };

      $scope.view_details = function(id) {
          config = {
             params: {id : id}
          };

          $http.get("./api/todo.php?id="+id).then(function (response) {
            $scope.title = response.data[0].title;
            $scope.id = response.data[0].id;
          });
      }

      $scope.update_status = function(status, id) {
          formData = {
            status : status,
            id : id
          };
          $http.put('./api/todo.php', formData).then(function(){
                /*success callback*/
                $scope.is_success = true;
                $scope.message = 'Status has been successfully updated.';
                $scope.load_todo_table();
              });
      };

      $scope.move_type = function(id) {
          formData = {
            type : 'notes',
            id : id
          };
          $http.put('./api/todo.php', formData).then(function(){
                /*success callback*/
                $scope.is_success = true;
                $scope.message = 'To do List has been successfully moved to Notes.';
                $scope.load_todo_table();
              });
      };

      $scope.delete_ = function(id) {
          formData = {
            deleted : 'yes',
            id : id
          };
          $http.put('./api/todo.php', formData).then(function(){
                /*success callback*/
                $scope.is_success = true;
                $scope.message = 'To do List has been successfully Deleted.';
                $scope.load_todo_table();
              });
      };
  });

  app.controller("notes", function($scope, $http) {
      var formData = {
         title : "",
         id : ""
      };

      var id;
      var config = {
       params: {id : '0'},
       headers : {'Accept' : 'application/json'}
      };

      $scope.is_success = false;
      $scope.message = '';

      $http.get("./api/notes.php", config).then(function (response) {
        $scope.notes_data = response.data;
      });

      $scope.load_note_table = function(){
        config = {
         params: {id : '0'},
         headers : {'Accept' : 'application/json'}
        };

        $scope.title = '';
        $scope.id = 0;
        CKEDITOR.instances.desc.setData('')

        $http.get("./api/notes.php", config).then(function (response) {
          $scope.notes_data = response.data;
        });
      }

      $scope.submitForm = function() {
          formData = { title: $scope.title, id : $scope.id, desc : CKEDITOR.instances.desc.getData() };
          if ($scope.id > 0){
            $http.put('./api/notes.php', formData).then(function(){
                /*success callback*/
                $scope.is_success = true;
                $scope.message = 'Note has been successfully Updated';
                $scope.load_note_table();
              });
          }else{
              $http.post('./api/notes.php', formData).then(function(){
                /*success callback*/
                $scope.is_success = true;
                $scope.message = 'New Note has been successfully Added.';
                $scope.load_note_table();
              });
          }
      };

      $scope.view_details = function(id) {
          config = {
             params: {id : id}
          };

          $http.get("./api/notes.php?id="+id).then(function (response) {
            $scope.title = response.data[0].title;
            $scope.desc = response.data[0].description;
            CKEDITOR.instances.desc.setData(response.data[0].description)
            $scope.id = response.data[0].id;
          });
      }

      $scope.move_type = function(id) {
          formData = {
            type : 'todo',
            id : id
          };
          $http.put('./api/notes.php', formData).then(function(){
                /*success callback*/
                $scope.is_success = true;
                $scope.message = 'Note has been successfully moved to To Do List.';
                $scope.load_note_table();
              });
      };

      $scope.delete_ = function(id) {
          formData = {
            deleted : 'yes',
            id : id
          };
          $http.put('./api/notes.php', formData).then(function(){
                /*success callback*/
                $scope.is_success = true;
                $scope.message = 'Note has been successfully Deleted.';
                $scope.load_note_table();
              });
      };
  });

</script>
</html>