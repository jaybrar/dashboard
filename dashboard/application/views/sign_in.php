<html>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>Sign In</title>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/styles.css">
</head>
<body>
	<div class = 'container'>
		<div class ='row'>
			<div class ='col-md-9'>
				<nav class="navbar navbar-default">
					<div class="container-fluid">
						<div class="navbar-header">
							<a class="navbar-brand" href="/">Test Asspp</a>
						</div>
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li><a href="/">Home</a></li>
							</ul>
							<ul class="nav navbar-nav navbar-right">
								<li><a href="/signin">Sign In</a></li>
							</ul>
						</div><!-- /.navbar-collapse -->
					</div><!-- /.container-fluid -->
				</nav>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 farm">
				<div class="panel panel-success">
					<div class="panel-heading"><h3 style="margin:0">Sign In</h3></div>
					<div class="panel-body">
						<form action='/signin' method='post' enctype='multipart/form-data'>	
							<div class="form-group">
								<label for="exampleInputEmail1">Email address</label>
								<input type='hidden' name='action' value='login'>
								<input type="text" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Password</label>
								<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
							</div>
							<button type="submit" class="btn btn-success">Sign In</button>
						</form>
						<a href="register">Don't have an accout? Register.</a>
					</div>
				</div>
			</div>
			<div class="col-md-5 farm">
				<?php if($this->session->flashdata('errors2')){
					echo $this->session->flashdata('errors2');}
					if($this->session->flashdata('login_error')){
					echo $this->session->flashdata('login_error');
				}?>
			</div>
		</div>
	</div>			
</body>
</html>