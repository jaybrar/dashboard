<html>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>User Dashboard</title>
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
								<li><a href="dashboard">Dashboard</a></li>
							</ul>
							<ul class="nav navbar-nav">
								<li><a href="/user/profile">Profile</a></li>
							</ul>
							<ul class="nav navbar-nav navbar-right">
								<li><a href="/">Logg Off</a></li></li>
							</ul>
						</div><!-- /.navbar-collapse -->
					</div><!-- /.container-fluid -->
				</nav>
			</div>
		</div>
		<div class="row">
			<div class="col-md-9 header">
				<h4 style="display:inline-block;margin:0">All Users</h4>
			</div>
			<div class="col-md-9 body">
				<table id = "t01" class="table table-bordered">
					<thead>
						<tr>
							<th>Id</th>
							<th>Name</th>
							<th>email</th>
							<th>created_at</th>
							<th>user_level</th>
						</tr>
					</thead>
					<tbody>
						<?php if(isset($users)){
							foreach($users as $value) {?>
							<tr>
								<td><?=$value['id']?></td>
								<td><a href="/users/info/<?=$value['id']?>"><?=$value['name']?></a></td>
								<td><?=$value['email']?></td>
								<td><?=$value['created_at']?></td>
								<td><?=$value['user_level']?></td>
							</tr>
							<?}?>
						<?}?>
					</tbody>			
				</table>
			</div>
		</div>
	</div>			
</body>
</html>