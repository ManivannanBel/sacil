<?php
include 'connect2db.php';
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');

 $user="user";
if(isset($_POST['loggeduserid_original'])||isset($_COOKIE[$user])){
                if(isset($_POST['loggeduserid_original'])){
                 $cli_id= $_POST['loggeduserid_original'];
                 //echo " post working $cli_id<br> ";
                setcookie($user, $cli_id);
              }
                else if(isset($_COOKIE[$user])){
                $cli_id=$_COOKIE[$user];
               // echo "cookie working $cli_id<br>";
                }
              }
//----------------------function to retrieve due date---------------------
function getDueDate($last_date, $category='C'){
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
	<title>Notification</title>
	  <link rel="shortcut icon" href="pic/titlepic.ico" />

	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>
<body>	
<?php 
if(isset($cli_id)){
$sa = getLp($cli_id);
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
	
}


?>

</div>
</div>







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