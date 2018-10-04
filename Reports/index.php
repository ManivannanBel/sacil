
<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
	<link rel="shortcut icon" href="pic/logo.ico" />
	<link href="https://fonts.googleapis.com/css?family=Tangerine" rel="stylesheet">
			<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<style type="text/css">
	
	

	
	.myjumbotron{
  		background:linear-gradient(rgba(27, 26, 26, 0.9), rgba(0, 0, 0, 0.55)),
        rgba(0,0,0,0.55) url('pic/wall.jpg') no-repeat center;
     	background-size: cover;
	    color: #fff;
	     height: 650px;
	    text-shadow: 2px 2px 4px #98974982;

	}
	.inner{
  	    color: #fff;
	    background: #1515195a;
	     height: 400px;
	    text-shadow: 2px 2px 4px #98974982;

	}
	.heading{
		font-family: 'Tangerine', cursive;
		font-size: 120px;
		font-weight: bold;
		color: black;
		text-align: center;
	}



     .a{
     	text-decoration: none;
     	font-family: 'Tangerine', cursive;
		font-size: 40px;
		font-weight: bold;
		color: black;
     }

	</style>
</head>
<body>


<div class="jumbotron myjumbotron" style="text-align: center;">
	<h1>CLI MONITORING PORTAL</h1>
  	<p>Salem Division, Southern Railway</p>
  	<p>Report Generation</p>
	<div class="container">
		<div class="jumbotron inner">

	<?php 
	session_start();
	include("adminlogin.php");
if(isset($_SESSION['admin_original'])){
    $usrnm = $_SESSION['admin_original'];
    $usrid = $_SESSION['adminid_original'];
?>
	<p style="text-align: right;">Admin:<?php echo "$usrnm";?></p>
	<div class="container" align="middle">
	<table>
		<tr>
			<th><a href="footplatereport.php" class="btn btn-lg btn-default">Footplate Report</a></th>
			<th><a href="checkform_report_all.php" class="btn btn-lg btn-default">VariousCheck Report</a></th>
			<th><a href="location_tracker.php" class="btn btn-lg btn-default">Location Tracker</a></th>
			<th><a href="handleuser/" class="btn btn-lg btn-default">User Control</a></th>
			<th><a href="topic_insert.php" class="btn btn-lg btn-default">Safety-Drive Topic</a></th>
			<th><a href="sobtopic_insert.php" class="btn btn-lg btn-default" style="width:150px;">SOB Topic</a></th>
			
		</tr>
	</table>
    </div>
    <div class="container" style="margin-top:80px;">
    <form method="POST">
    <input type="submit" class="btn btn-danger btn-lg" name="btn_logout" value="Logout">
    </form>
    </div>
<?php }
	?>
</div>
	</div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>