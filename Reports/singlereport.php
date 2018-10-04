<?php
include "../connect2db.php";
//-------------------taking care of new lines-------------------------------------------------
function strip_carriage_returns($string)
{
    return str_replace(array("\n\r", "\n", "\r"), ' ', $string);
}

//--------------------------------------------------------------------
function json_format($s){
	//$s = str_replace()

}
//--------------------------------------------------------------
	function getQuery($id ,$tablename, $from, $to){
		$id = "$id%";
	if($tablename=="sec/sfc"){
		 $sql = "SELECT *  FROM `$tablename` WHERE `conseled_date` between '$from' AND '$to' AND `clis_cms_id` like '$id'";	
	}
	else if($tablename=="safety_drive"){
			  $sql = "SELECT *   FROM $tablename WHERE `fromp` >= '$from' AND `top`<= '$to' AND `clis_cms_id` like '$id'";
	}
	else{
	$sql = "SELECT *   FROM $tablename WHERE `date` between '$from' AND '$to' AND `clis_cms_id` like '$id'";
}
	return $sql;
}

session_start();
if(isset($_SESSION['adminid_original'])){
$cmsid = $from = $to =$table='';
		if (isset($_GET['id']) && isset($_GET['fd']) && isset($_GET['td']) && isset($_GET['from'])) {
			 $cmsid = format_input($_GET['id']);
			 $from = format_input($_GET['fd']);
			 $to = format_input($_GET['td']);
			 $table=format_input($_GET['from']);
		}

		
		include "necessary_info.php";

		 $sql=getQuery($cmsid,$table,$from,$to);
		 $result=mysqli_query($conn,$sql);
		 $records='';
		 $counter = 1;
		 $special_table = ['safety_drive','safety_seminar','sob','tsc'];
		 $special_keys = ['lpm','lpp','lpg','lps','alp'];
		 while ($row=mysqli_fetch_assoc($result)) {
		 	$temp = '';
		 	$sum = 0;
		 	foreach ($row as $key => $value) {
		 		if($key == 'id'|| $key=='clis_cms_id') continue;
		 		//$value = format_output($value);
		 		if(in_array($key, $special_keys)){$sum = $sum + $value;}
		 		$temp[$key] = $value;
		 	}
		 	if(in_array($table, $special_table)){$temp['total'] = $sum;}
		 	$records[$counter++] = $temp;
		 }

//displaying data
		 
		$namesql="select clis_name from clis_details where clis_cms_id='$cmsid'";
		$res=mysqli_query($conn,$namesql);
		$name = "";
		if($res){
		$row=mysqli_fetch_assoc($res);
		$name=$row['clis_name'];
		}
		
	?>





<!DOCTYPE html>
<html>
<head>
	<title>Report of <?php echo "$name Reports";?></title>
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
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="panel-titile"><?php 
					$table = getFullForm($table);
				echo "CLI: $cmsid | <i>$name</i> | $table Report";

				?>

			</h4> 
			</div>
			<div class="panel-body">
				<?php 
		if (!empty($records)) {		 
		 $headings = array_keys($records[1]);
		 array_unshift($headings, "SN");
		 
		 
		 echo '<table class="table table-bordered table-hover"id="checkform1"';
		 echo "<tr>";
		 
		 foreach ($headings as $h) {
		 	if($h=="lps_name") $h="lp_name";
		 	if($h=="design") $h = "designation";
		 	if($h=="lssd") $h = "lss date";
		 	if($h=="lssn") $h = "lss by";

		 	$h = str_replace("_"," ",$h);
		 	echo "<th>$h</th>";
		 }
		 echo "</tr>";
		 //---------------------
		 	$jdata = [];
		 //----------------------
		 foreach ($records as $key => $value) {
		 	$jtemp = [];
		 	echo "<tr><td>$key</td>";
		 	array_push($jtemp, $key);
		 	foreach ($value as $col => $data) {
		 		//to remove new lines in order to parse json
		 		
		 		echo "<td>".format_output($data)."</td>";
		 		$data = strip_carriage_returns($data);
		 		array_push($jtemp, $data);
		 	}
		 	array_push($jdata, $jtemp);
		 	echo "</tr>";
		 }
		 //---------------------
		 echo "</table>";
		 $jResult = ["headings"=>$headings, "record"=>$jdata];
		 

		 ?>
		 <span style="float:right;" ><a href="#" class = "btn btn-md btn-danger"  onclick="write_Individual_Report_Excel();"><span class="glyphicon glyphicon-export"></span>&nbspEXPORT TO EXCEL</a></span>
		 <?php

}
?>
			</div>
		</div>

	</div>
<?php include "scripts/various_checks_report_to_excel.php"; ?>	
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

<?php include("report_unloggedpage.php"); include("home_button.php");?>
</body>
</head>
</html>
<?php 
}
?>