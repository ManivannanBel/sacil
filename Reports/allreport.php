<?php
//------------------------creating queries-------------------
function getQuery($tablename, $from, $to, $cmsid){
	$cmsid  = "$cmsid%";
if($tablename=="sec/sfc"){
		 $sql = "SELECT COUNT(*) as total FROM `$tablename` WHERE `conseled_date` between '$from' AND '$to' AND `clis_cms_id` like '$cmsid'";	
	}
	else if($tablename=="safety_drive"){
			  $sql = "SELECT COUNT(*) as total FROM $tablename WHERE `fromp` >= '$from' AND `top`<= '$to' AND `clis_cms_id` like '$cmsid'";
	}
	else{


$sql = "SELECT COUNT(*) as total FROM $tablename WHERE `date` between '$from' AND '$to' AND `clis_cms_id` like '$cmsid'";
}
//---------------------------executing query-------------------
return $sql;

}
function getCount($conn, $sql){
	$res = 0;
	$result = mysqli_query($conn, $sql);
	while($row=mysqli_fetch_assoc($result)){
		$res = $row['total'];
	}
	return $res;
}
//---------------------------------end of functions-----------------------
session_start();
if(isset($_SESSION['adminid_original'])){
		$cmsid = $from = $to ='';
		if (isset($_GET['id']) && isset($_GET['fd']) && isset($_GET['td'])) {
			$cmsid = $_GET['id'];
			$from = $_GET['fd'];
			$to = $_GET['td'];
		}
	
include "../connect2db.php";
include "necessary_info.php"; //for full forms and other information
$tables = ['spm_checking','vcd_analysis','rr','cb','adj_division','amb_by_speed_gun','jss','mobile_phone_check','safety_seminar','sob','tsc','sec/sfc','safety_drive'];
//----------------------------retrieving name---------------------------------
$namesql="select clis_name from clis_details where clis_cms_id='$cmsid'";
		$res=mysqli_query($conn,$namesql);
		$row=mysqli_fetch_assoc($res);
		 $name=$row['clis_name'];
//-------------------------------------------------------------
$Result_set = "";
foreach ($tables as $tablename) {
	$sql = getQuery($tablename, $from, $to, $cmsid);
	$val = getCount($conn, $sql);
	$Result_set["$tablename"] = $val;
}





?>
<!DOCTYPE html>
<html>
<head>
	<title>Various Check Summary</title>
	<link rel="shortcut icon" href="pic/logo.ico" />
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<style type="text/css">
		#checkform,#checkform1{
			text-transform: uppercase;

		}
		#checkform{
			border-collapse: separate;
			border-spacing: 0 1em;
		}
		.icon-input-btn{
        display: inline-block;
        position: relative;
    }
    .icon-input-btn input[type="submit"]{
        padding-left: 2em;
    }
    .icon-input-btn .glyphicon{
        display: inline-block;
        position: absolute;
        left: 0.65em;
        top: 30%;
    }

	</style>
</head>
<body>

<?php
//----------------------home button------------------
	include("home_button.php");
	 ?>
<div class="container" style="width: 80%;">
	
	<?php
		echo '<div class="panel panel-primary">';
		echo '<div class="panel-heading">';
		echo "<h3 class='panel-title'>CLI: $cmsid | <i>$name</i> | Various Checks Summary</h3>";
		echo '</div>';
		echo '<div class="panel-body">';
		echo '<table class="table table-bordered table-hover"id="checkform1">';
		foreach ($Result_set as $key => $value) {
			
			$d2 = "from=$key&&id=$cmsid&&fd=$from&&td=$to";
				?>

							<tr style="cursor:pointer;" onclick="window.location='<?php echo "singlereport.php?$d2"; ?>';">

			<?php
					$key = getFullForm($key);
				echo "<th> $key </th>";
				echo "<td> $value</td>";
				echo "</tr>";
			}
		echo '</table></div></div>';

	

			?>
</div>

</body>
</html>
<?php 
}else{ ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style type="text/css">
.unlog-jumbo{
	background-color: #FFFFFF;
}
</style>
<title>Individual Various checks</title>
<body>

<?php include("report_unloggedpage.php");include("home_button.php"); ?>
</body>
</head>
</html>
<?php 
}
?>