
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Edit User</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	<style type="text/css">
	*{
		font-family: sans-serif;
	}
	.container{
		padding: 20px;
		margin-top: 20px;
	}
	.exampleInputFile{
		height: 30px;
		color: red;
		font-size: 20px;
	}
	form{
		color: green;
		font-size: 20px;
	}
	.panel-heading h3{
		margin: 0;
	}
	.errors{
		color: red;
	}
	h5{
		margin: 0;
	}
	.header{
		margin-bottom: 30px;
	}
	</style>
	<script>
	$(document).ready(function(){
		// $('#datepicker').datepicker();
	});
	</script>
</head>
<body>
	<div class = "container">
		<div class ='row'>
			<div class ='col-md-9'>
				<nav class="navbar navbar-default">
					<div class="container-fluid">
						<div class="navbar-header">
							<a class="navbar-brand" href="/">Test App</a>
						</div>
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li><a href="/admin/dashboard">Dashboard</a></li>
							</ul>
							<ul class="nav navbar-nav">
								<li><a href="/user/profile">Profile</a></li>
							</ul>
							<ul class="nav navbar-nav navbar-right">
								<li><a href="/">Log off</a></li>
							</ul>
						</div><!-- /.navbar-collapse -->
					</div><!-- /.container-fluid -->
				</nav>
			</div>
		</div>
		<div class="row">
			<div class="col-md-10 farm" style="color:red">
				<?php if($this->session->flashdata('info')){
					echo $this->session->flashdata('info');
				}?>
			</div>
			<div class="col-md-9 header">
				<h4 style="display:inline-block;margin:0">Edit user #[user_id]</h4><a href="/admin/dashboard"><button class="pull-right">Return to dashboard</button></a>
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-5 farm">
				<div class="panel panel-danger">
					<div class="panel-heading"><h5>Edit Information</h5></div>
					<div class="panel-body">
						<form action='/users/edit/<?php echo $id;?>' method='post'>	
							<div class="form-group">
								<label for="exampleInputEmail1">Email address</label>
								<input type='hidden' name='action' value='information'>
								<input type="text" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">First Name</label>
								<input type="name" name="first_name" class="form-control" id="exampleInputEmail1" placeholder="First Name">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Last Name</label>
								<input type="name" name="last_name" class="form-control" id="exampleInputEmail1" placeholder="Last Name">
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">User Level</label>
								<select name="level">
									<option value="1">Normal</option>
									<option value="9">Admin</option>
								</select>
							</div>
							<button type="submit" class="btn btn-success pull-right">Save</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-4 farm">
				<div class="panel panel-danger">
					<div class="panel-heading"><h5>Change password</h5></div>
					<div class="panel-body">
						<form action='/users/edit/<?php echo $id;?>' method='post' enctype='multipart/form-data'>	
							<div class="form-group">
								<label for="exampleInputPassword1">Password</label>
								<input type='hidden' name='action' value='password'>
								<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Password Confirmation</label>
								<input type="password" name="password2" class="form-control" id="exampleInputPassword1" placeholder="Password">
							</div>
							<button type="submit" class="btn btn-success pull-right">Update Password</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
