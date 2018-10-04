<?php
session_start();
 if(isset($_SESSION['loggeduserid_original'])){
 	$inspector_id = $_SESSION['loggeduserid_original'];
include 'connect2db.php';
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');

//----------------------function to retrieve due date---------------------
function getDueDate($last_date='0000-00-00', $category='C'){
	$d = 0;
	$category = strtoupper($category);
	switch ($category) {
		case 'A':
			$d = 90;
			break;
		case 'B':
			$d = 60;
			break;
		case 'C':
			$d = 30;
			break;
		
		default:
			$d = 0;
			break;
	}
	 $dueDate = date("Y-m-d",strtotime($last_date."+ $d days"));
	 return $dueDate;

}
//------------------------------------function to sort record datewise------------
function date_compare($a, $b){
	$fieldname = "Due Date";
	$t1 = strtotime($a[$fieldname]);
	$t2 = strtotime($b[$fieldname]);
	return $t1 - $t2;
}
//---------------------------------------function to authorise notify -------------10 days for notification---
function days_remaining($duedate){
	global $current_date;
	$sec = strtotime($duedate) - strtotime($current_date);
	$day = $sec / 86400 ;
	return $day;
}

//------------------------------------function to retrieve lp's info---------------
function getLp($cli_id){
	$lim = 70;
	global $conn;
	$lp_set = [];
	$sql = "select lp_id,name,grade,last_monitoring_date from lp_details where clis_cms_id = '$cli_id' LIMIT $lim";
	$res = mysqli_query($conn, $sql);
	//$skip = ['id', 'clis_cms_id', 'pf_no'];
	if($res){
		while($row = mysqli_fetch_assoc($res)){
			$temp = '';
			foreach ($row as $key => $value) {
				//if(in_array($key, $skip)) continue;
				$temp[$key] = $value;	
			}
			//		echo $row['grade'];
			$duedate = getDueDate($row['last_monitoring_date'],$row['grade']);
			if(days_remaining($duedate)<=60){
				$temp['Due Date'] = $duedate;
				$temp['Remaining Days']= days_remaining($duedate);
					array_push($lp_set, $temp);
			}
			
		}
	}
	return $lp_set;
}
//---------------------------------------------------------------------------------
//echo "<br><br>";
?>
<!DOCTYPE html>
<html>
<head>
	<title>FPI Notification</title>
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
	<br>
<?php 

$sa = getLp($inspector_id);
if(!empty($sa)) {
	foreach ($sa as $key => $rec) {?>
		<div class="panel panel-success">
			<div class="panel-heading">
				<h1 class="panel-title"><strong><?php  echo $rec['name'];?></strong></h1>
			</div>
			<div class="panel-body">
				<?php
				//echo "my anem si sagar";
				echo '<table class="table table-hover">';
				foreach ($rec as $key => $data) {
					if($key=="name") continue;
					if($key=="Remaining Days"){
						$data = "<span id='dayalert'><b>$data Days <b></span>";
					}
					$key= strtoupper(str_replace("_"," ", $key));
					echo "<tr>
						<th>$key</th>
						<td>$data</td>
				
				</tr>";
			}
			echo "</table>";
			echo "</div>";
			echo "</div>";
		}
		
	}
	
	


?>

</div>
</div>
</div>
<a href="index.php" class="btn btn-xl btn-primary  btn-circle" id="homebutton"><i class="glyphicon glyphicon-home"></i></a>
<a href="footplateinspectionviewpage.php" class="btn btn-xl btn-primary  btn-circle" id="fpi"><p id="fpibu">FPI</p></a>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
		$(document).ready(function(){	
		$('span#dayalert').each(function(){
			$days=$(this).text();
			console.log($days);
			$days=parseInt($days);
			console.log($days);
			if($days>=10){
				$(this).css('color', 'green');
			}
			else if($days>=2){
				$(this).css('color', 'orange');

			}
			else{
				$(this).css('color', 'red');

			}
		});	
			
});
</script>
</body>
</html>
<?php
}else{
	//echo "testing";
	include("unloggedpage.php");
	if(isset($_SESSION['logged_controller_id'])){
		echo "<p align='center'>Note: Login as CLI</p>";
	}

}
?>