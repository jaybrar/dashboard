<html>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>New User</title>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	<style type="text/css">
	.header, .body{
		margin-top: 30px;
	}
	</style>
</head>
<body>
	<div class = 'container'>
		<div class ='row'>
			<div class ='col-md-9'>
				<nav class="navbar navbar-default">
					<div class="container-fluid">
						<div class="navbar-header">
							<a class="navbar-brand" href="/">User Dashboard</a>
						</div>
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li><a href="/admin/dashboard">Dashboard</a></li>
							</ul>
							<ul class="nav navbar-nav">
								<li><a href="/user/profile">Profile</a></li>
							</ul>
							<ul class="nav navbar-nav navbar-right">
								<li><a href="/">Log Off</a></li>
							</ul>
						</div><!-- /.navbar-collapse -->
					</div><!-- /.container-fluid -->
				</nav>
			</div>
		</div>
		<div class="row">
			<div class="col-md-9 header">
				<h4 style="display:inline-block;margin:0">Add a new user</h4><a href="/admin/dashboard"><button class="pull-right">Return to dashboard</button></a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-5 farm">
					<div class="panel-body">
						<form action='/add_user' method='post' enctype='multipart/form-data'>	
							<div class="form-group">
								<label for="exampleInputEmail1">Email address</label>
								<input type='hidden' name='action' value='add'>
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
								<label for="exampleInputPassword1">Password</label>
								<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Re-Enter Password</label>
								<input type="password" name="password2" class="form-control" id="exampleInputPassword1" placeholder="Password">
							</div>
							<button type="submit" class="btn btn-success">Create</button>
						</form>
					</div>
			</div>
			<div class="col-md-5 farm">
				<?php if($this->session->flashdata('errors')){
					echo $this->session->flashdata('errors');
				}?>
			</div>
		</div>
	</div>			
</body>
</html>