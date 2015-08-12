
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>User Information</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="wall_css.css">
	</style>
	<style>
	.row{
		margin-top: 20px;
	}
	.message{
		width: 775px;
		height: 50px;
		border: 1px solid black;
		margin-bottom: 20px;
		/*margin-top: 10px;*/
		background-color: yellow;
		margin-left: 170px;
	}
	.comment{
		width: 640px;
		height: 50px;
		border: 1px solid black;
		margin-left: 300px;
		margin-bottom: 20px;
		background-color: lightgreen;
	}
	.text2{
		margin-left: 320px;
		/*margin-top: 20px;*/
	}
	.title{
		color: darkblue;
		font-size: 15px;
	}
	.title p{
		display: block;
		margin-bottom: 10px;
	}
	p{
		display: inline-block;
		margin: 0;
	}
	.msg-p{
		margin-right: 590px;
		margin-left: 170px;
	}
	.cmt-p{
		margin-left: 300px;
		margin-right: 440px;
	}
	</style>
	<script>
	$(document).ready(function(){
		<?php if (isset($_SESSION['warning'])) {
			echo $_SESSION['warning'];
			unset($_SESSION['warning']);
		}?>
	});
	</script>
</head>
<body>
	<div class = "container">
		<div class ='row'>
			<div class ='col-md-10'>
				<nav class="navbar navbar-default">
					<div class="container-fluid">
						<div class="navbar-header">
							<a class="navbar-brand" href="/">User Dashboard</a>
						</div>
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li>
									<?php if($this->session->userdata('user')['user_level']==9){
										echo "<a href='/admin/dashboard'>Dashboard</a>";
									}else {echo "<a href='/dashboard'>Dashboard</a>";}?>
								</li>
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
		<div class = "row">
			<div class = 'col-md-9 title'>
				<?php if($this->session->userdata('receiver_info')){
					$receiver_info = $this->session->userdata('receiver_info');
				}?>
				<h3><?=$receiver_info['name']?></h3>
				<p>Registered: <?=$receiver_info['created_at']?></p>
				<p>User Id: <?=$receiver_info['id']?></p>
				<p>Email Address: <?=$receiver_info['email']?></p>
				<p>Description: <?=$receiver_info['description']?></p>
			</div>
		</div>	
		<div class="row content">
			<div class="col-md-10 body">		
				<form action='/add_message' method='post'>	
					<div class="form-group">
						<label for="exampleInputEmail1"><h4>Leave a message for <?=$receiver_info['name']?></h4></label>
						<textarea type="text" name="text" id="resizable" class="ui-widget-content form-control" rows="2" id="exampleInputEmail1" placeholder="Message"></textarea>
						<input type="hidden" name="action" value="post">
					</div>
					<button type="submit" name="submit" class="btn btn-primary pull-right">Post</button>
				</form>
			</div>
		</div>
				<?php if(isset($message)){
					foreach ($message as $value) {
						$msg_id = $value['id'];?>
				
		<div class="row content">
			<div class="col-md-10 body">
				<p class="msg-p"><a href="/users/info/<?=$value['user_id']?>"><?=$value['name']?></a></p><p><?=$value['created_at']?></p>
				<div class="message"><p><?=$value['message']?></p></div>
				<?php foreach ($comment as $value2) {
						if($msg_id == $value2['original_msg']){?>
					<p class="cmt-p"><a href="/users/info/<?=$value2['user_id']?>"><?=$value2['name']?></a></p><p><?=$value2['created_at']?></p>
					<div class="comment"><p><?=$value2['message']?></p></div>
				
				<?}}?>
			</div>
		</div>	
		<div class="row content">
			<div class="col-md-10 body">
				<form action='/add_comment' method='post' class="form2">	
					<div class="form-group">
						<textarea type="text" name="text" class="text2" rows="2" cols="90"placeholder="Comment"></textarea>
						<input type="hidden" name="action" value="comment">
					</div>
					<button type="submit" name="msg_id" value="<?=$value['id']?>" class="btn btn-success pull-right">Post</button>
				</form>
			</div>
		</div>
			<?}?>
		<?}?>
	</div>
</body>
</html>
