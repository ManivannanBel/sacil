<?php
session_start();
 if(isset($_SESSION['loggeduserid_original'])){
 	$inspector_id = $_SESSION['loggeduserid_original'];
	include 'connect2db.php';
	$res = $conn->query("SELECT * FROM comments order by date desc;");
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Comments</title>
	  <link rel="shortcut icon" href="reports/pic/logo.ico" />

	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<style type="text/css">
			#homebutton{
    	  position: fixed;
		  bottom: 20px;
		  right: 90px;
		  z-index: 99;
		  border: none;
		}
		  #fpi{
    	  position: fixed;
		  bottom: 20px;
		  right: 25px;
		  z-index: 99;
		  border: none;
	}
	.btn-circle.btn-xl {
    width: 50px;
    height: 50px;
    padding: 10px 16px;
    border-radius: 35px;
    color: white;
    line-height: 1.33;
    font-size: 20px;
    text-align: center;
}
.input-group-text{
		font-size: 1.5rem;
	}
	input.form-control{
		font-size: 1.5rem;
	}
.glyphicon-home
{		
	padding-top:5px;
}
#fpibu
{		
	padding-left:-3px;
}
	</style>
</head>
<body>
	<div class="container" style="width: 80%;">	
	<br><h1>COMMENT</h1><br>
	<?php
		while ($arr = mysqli_fetch_assoc($res)) {
			?>
			<li class="list-group-item">
				<div class="col-sm serif">
           		<?php
            		echo "<B>Date: </B>".$arr['date'];
           		?> 
          		</div>
				<div class="col-sm serif">
           		<?php
            		echo "<B>Cli id: </B>".$arr['clis_cms_id'];
           		?> 
          		</div>
          		<div class="col-sm serif">
           		<?php
            		echo "<B>Comment: </B>".$arr['comment'];
           		?> 
          		</div>
			</li>
			<?php
		}
	}
	?>

</body>
</html>