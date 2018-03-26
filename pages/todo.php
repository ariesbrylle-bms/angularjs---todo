<div ng-controller="todo">
	<div class="panel panel-default">
  		<div class="panel-heading">To Do List</div>
		  <div class="panel-body">
		  		<div class="row">
				  <div class="col-sm-12">
				  	<div ng-show="is_success" class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					    <strong>Success!</strong> {{ message }}.
					</div>
				  </div>
				</div>
				<div class="row">
				  <div class="col-sm-12">
				  	<form id="todo" ng-submit="submitForm()">
					  <div class="form-group">
					    <label for="title">Title</label>
					    <input type="text" class="form-control" required id="title" ng-model="title" name="title">
					    <input type="hidden" class="form-control" value="0" id="id" ng-model="id" name="id">
					  </div>
					  <button type="submit" class="btn btn-primary">Save</button>
					</form>
				  </div>
				</div>
				
		  </div>
	</div>

	<div class="panel panel-default">
  		<div class="panel-heading">To Do List Table</div>
	  		<div class="panel-body">
			<div class="row">
			  <div class="col-sm-12">
			  	<table class="table">
			  		<thead>
			  			<tr>
			  				<td style="width:10%"></td>
			  				<td style="width:60%">Title</td>
			  				<td style="width:30%">Action</td>
			  			</tr>
			  		</thead>
				    <tbody>
				      <tr ng-repeat="x in todo_data">
				      	<td><input ng-checked="x.is_completed != 0" ng-change="update_status(x.is_completed, x.id)" type="checkbox" class="form-controll" ng-model="form.todo_id"></td>
					    <td>{{ x.title }}</td>
					    <td><div class="btn-group">
					    	<button type="button" ng-click="view_details(x.id)" class="btn btn-info">Edit</button>
					    	<button type="button" ng-click="delete_(x.id)" class="btn btn-danger">Delete</button>
					    	<button type="button" ng-click="move_type(x.id)" class="btn btn-success">Move to Notes</button>
					    	</div></td>
					  </tr>
				    </tbody>
				  </table>
			  </div>
			</div>
	  </div>
	</div>
</div>