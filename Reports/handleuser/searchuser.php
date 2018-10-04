<?php
include("connect2db.php");
$Name=$Cliscmsid=$isset=$role='';
if(isset($_POST["searchuser"])){
	if(!empty($_POST['role'])){
		$role = $_POST['role'];
	}
	if($role == 'cli') $isset = 1;
	elseif ($role == 'tlc') $isset = 2;
	elseif($role=='lp') $isset = 3;

	//$isset=1;
	if(!empty($_POST["name"])){
		$Name=format_input($_POST["name"]);
	}
	if(!empty($_POST["cliscmsid"])){
		$Cliscmsid=format_input($_POST["cliscmsid"]);
	}
}
?>
<html>
<head>
<title>Search Users</title>
	
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</title>
<style type="text/css">
	.btn{
		font-size: 1.5rem;
	}
	.input-group-text{
		font-size: 1.5rem;
	}
	.body{
		font-size: 1.5rem;
	}
	input.form-control{
		font-size: 1.5rem;
	}
	.myjumbotron{
  		background:linear-gradient(rgba(27, 26, 26, 0.9), rgba(0, 0, 0, 0.55)),
        rgba(0,0,0,0.55) url('pic/wall.jpg') no-repeat center;
     	background-size: cover;
	    color: #fff;
	    text-shadow: 2px 2px 4px #98974982;

	}
</style>
</head>
<body >
	<div class="container" style="width: 60%;">
	<form name="searchuser" method="POST" action="">
		<div class="input-group">
			 <div class="input-group-prepend">
			 	<span class="input-group-text" id="inputGroup-sizing-default">
			 		<select name="role" class="form-control" aria-label="role" aria-describedby="inputGroup-sizing-default" > 
    				<option value="cli">CLI</option>
    				<option value="lp">Crew</option>
    				<option value="tlc">TLC</option>
    			</select></span>
  			</div>
  			
  			<div class="input-group-prepend">
    			<span class="input-group-text" id="inputGroup-sizing-default">Name</span>
  			</div>
  			<input type="text" class="form-control" aria-label="Name" aria-describedby="inputGroup-sizing-default" name="name">
  			<div class="input-group-prepend">
    			<span class="input-group-text" id="inputGroup-sizing-default"> CMS ID</span>
  			</div>
  			<input type="text" class="form-control" aria-label="CMS ID" aria-describedby="inputGroup-sizing-default" name="cliscmsid">
  			<div class="input-group-append">
    		<input type="submit" class="btn btn-md btn-success" value="Search" name="searchuser">	
  			</div>
		</div>

	</form>
</div>

</body>
</html>