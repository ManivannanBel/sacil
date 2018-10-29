<?php
	$comment_added=0;
	session_start();
	include("connect2db.php");
	if(isset($_POST['submit_comment'])){
		$create_table_query = "create TABLE if not EXISTS comments (comment varchar(5000), clis_cms_id varchar(20), date timestamp default CURRENT_TIMESTAMP);";
		$conn->query($create_table_query);
		$comment = format_input($_POST['comment']);
		if(!empty($comment)){
			$clis_id = $_SESSION['loggeduserid_original'];
			$query = "INSERT into comments (comment, clis_cms_id) value('$comment','$clis_id');";
			$conn->query($query);
			$comment_added = 1;
		}
		
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>CLI Monitoring</title>
  <link rel="shortcut icon" href="reports/pic/logo.ico" />

	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">


	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Keywords" content="southern,railway,monitoring,cli,clis,sona,daya, dayanand, dayanand raut, sagar, sagar poudel, ragas, raj, raj shikhar, raj shikhar tandukar, aparna, aparna c, aparna chandrasekharan, vishnu, vishu raj, vishnu sivakumar, railway,">
	<link rel="stylesheet" type="text/css" href="mystyle.css">
	<link rel="stylesheet" type="text/css" href="footerstyle.css">
  
	</head>
<body>
	<?php

		include("header.php");
	?>
	<header class="header" id="myHeader">
		<div class="container" >
		  <nav class="navbar navbar-inverse">
		    <div class="container-fluid">
		      <div class="navbar-header">
		        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		          <span  class="sr-only"></span>
		          <span  class="icon-bar"></span>
		          <span  class="icon-bar"></span>
		          <span class="icon-bar"></span>
		          
		        </button>

		      </div>
		      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		        <ul class="nav navbar-nav"  style="float:left;">
		          <li><a href=""><logo style="font-weight:bold;">COMMENTS SECTION</logo><span class="sr-only">(current)</span></a></li>
		        </ul>

		        <ul class="nav navbar-nav"  style="float:right;" >
		        
		          <li><a href="index.php">Home</a></li>
		          <li><a href="footplateinspectionviewpage.php">Foot Plate Inspection</a></li>
		          <li><a href="various_checks.php">Various Checks</a></li>
		          <li><a href="activity_log.php">Activity Log</a></li>
		          <li><a href="clis_profile.php">Profile</a></li>
		          
		          
		        </ul>
		      </div>
		    </div>
		  </nav>
		</div>
	</header>
  <?php
    if(isset($_SESSION['loggeduserid_original'])||isset($_SESSION['logged_controller_id'])){

    	if($comment_added==1){
    		?>
    		<div class="container"><h1>Comment added</h1></div>
    		<?php
    	}else{

   ?>
	<div class="container">
		<h2>Add Your Comment</h2>
		<form method="POST">
			<textarea  class = "form-control" name="comment" rows="10" cols="15"></textarea>
			<input type="submit" name="submit_comment" value="submit comment" class="btn btn-success"></input>
		</form>
	</div>
  <?php
  		}
  	}else
  		include("unloggedpage.php");
  ?>
</body>
</html>