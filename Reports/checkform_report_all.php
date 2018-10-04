<?php
session_start();
if(isset($_SESSION['adminid_original'])){
include "../connect2db.php";
$cms_details="";
//----------------Retriving Id and Names of CMS----------------------s
$q1="SELECT DISTINCT clis_cms_id, clis_name FROM `clis_details`";
$r1=mysqli_query($conn,$q1);
while ($row=mysqli_fetch_assoc($r1)) {
		$v1=$row['clis_cms_id'];
		$v2=$row['clis_name'];
		$cms_details[$v1]=$v2;
	
}
//------------------------creating queries-------------------
function getQuery($id ,$tablename, $from, $to){
	$id = "$id%";
	if($tablename=="sec/sfc"){
		 $sql = "SELECT COUNT(*) as total FROM `$tablename` WHERE `conseled_date` between '$from' AND '$to' AND `clis_cms_id` like '$id'";	
	}
	else if($tablename=="safety_drive"){
			  $sql = "SELECT COUNT(*) as total FROM $tablename WHERE `fromp` >= '$from' AND `top`<= '$to' AND `clis_cms_id` like '$id'";
	}
	else{


	$sql = "SELECT COUNT(*) as total FROM $tablename WHERE `date` between '$from' AND '$to' AND `clis_cms_id` like '$id'";
	}


return $sql;
}
//---------------------------executing query-------------------
function getCount($conn, $sql){
	$res = 0;
	$result = mysqli_query($conn, $sql);
	while($row=mysqli_fetch_assoc($result)){
		$res = $row['total'];
	}
	return $res;
}
//---------------------------End----------------------------
$cms=array_keys($cms_details);
$tablename = "spm_checking";
$from  = "0000-00-00";
$to = "9999-12-31";
$cmsid = "";
$isset=0;
if(isset($_POST['checkformsubmit'])){
		$isset=1;
	if(!empty($_POST['fromdate'])){
		$from=$_POST['fromdate'];
	}
		if(!empty($_POST['todate'])){
		$to=$_POST['todate'];
	}		
	if(!empty($_POST['clisid'])){
		$cmsid=$_POST['clisid'];
		$cms=[$cmsid];
	}
}
$tables = ['spm_checking','vcd_analysis','rr','cb','adj_division','amb_by_speed_gun','jss','mobile_phone_check','safety_seminar','sob','tsc','sec/sfc','safety_drive'];
//-------------------------------------------------------------
$Result_set = "";
if($isset==1){
	$counter=1;
	foreach ($cms as $id) {
	//$Result_set['$id']="";
	$single="";
	//echo $id;
	$single["id"]=$id;
	$single['name']=$cms_details[$id];
	$sum_of_records = 0;
	foreach ($tables as $tablename) {
	$sql = getQuery($id,$tablename, $from, $to);
	$val = getCount($conn, $sql);
	$sum_of_records = $sum_of_records + $val;
	$single["$tablename"] = $val;
}

if($sum_of_records<=0) continue;
$Result_set[$counter++]=$single;
}
//print_r($Result_set); echo "<br>";

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
<div id = "searchform" class = "jumbotron" align="middle">
	<form name = "checkform_report" method="post" class="form-group">
	<div class="form-group has-feedback has-feedback">
		<table id="checkform">
		<tr>
			<th>From: </th><td><input type="date" name="fromdate" placeholder="DD-MM-YYYY" class="form-control"></td>
			<th>To: </th><td><input type="date" name="todate" placeholder="DD-MM-YYYY" class="form-control"></td>
			
			<th>CLIS ID: </th><td><input type="text" name="clisid" placeholder="CLIS ID" class="form-control"></td>
			
			<td><span class="icon-input-btn"><span class="glyphicon glyphicon-search"></span> <input type="submit" class="btn btn-success btn-md" value="Search" name="checkformsubmit"></span>
			
			</td>
			</tr>
		</table>
		</div>
	</form>

</div>

<div class="container" id="myresult" >
	<hr>
	<h1 class="lead">Search Results</h1>
	<hr>
	<?php
	
	if($isset==1){
		if(!empty($Result_set)){
		$jheading = ["SN","CMS ID","NAME","SPM","VCD","RR","CB","ADJ DIVISION","AMB BY SPEED GUN",
			"JSS","MOBILE PHONE CHECK","SAFETY SEMINAR","SOB","TSC","SEC/SFC","SAFETY DRIVE"];
		
		echo '<div class="panel panel-primary">';
		echo '<div class="panel-heading">';
		echo '<h3 class="panel-title">Various Checks Summary</h3>';
		echo '</div>';
		echo '<div class="panel-body">';
		echo '<table class="table table-bordered table-hover" id="checkform1">';
		//printing headings of the table
		echo "<tr>";
		foreach ($jheading as $h) {
			echo "<th>$h</th>";
		}
		echo "</tr>";
		//Extracting data and printing them
		$jdata=[];
		$jrec = [];
		
		foreach ($Result_set as $key => $value) {
			
		$d1 = $Result_set[$key]['id'];
		$d2 = "id=$d1"."&&fd=$from&&td=$to";?>
				
			<tr style="cursor:pointer;" onclick="window.location='<?php echo "allreport.php?$d2"; ?>';">
			

			<?php echo "<td>$key</td>";
			$jtemp=[];	
			array_push($jtemp, $key);
			foreach ($value as $nkey => $nvalue) {
				echo "<td>$nvalue</td>";
				array_push($jtemp, $nvalue);
			}
			echo "</tr>";
			array_push($jdata, $jtemp);
		}
			$jrec = ["headings"=>$jheading, "record"=>$jdata];
		
			echo '</table></div></div>';
			?>
			
			<span style="float:right;" ><a href = "#"  class = "btn btn-md btn-danger" onclick = "write_Entire_Report_Excel();">EXPORT TO EXCEL</a></span>

	<?php 
	
	}else echo "No Results Found";
}

			?>
</div>
<?php include "scripts/various_checks_report_to_excel.php"; 
	
?>
<?php
//------------------Scroll to the result area----------------------
    if($isset==1){
    ?>
    <script type="text/javascript">
      $(document).ready(function () {
          // Handler for .ready() called.
          $('html, body').animate({
              scrollTop: $('#myresult').offset().top
          }, 'slow');
      });

      
    </script>
    <!-- END OF ANIMATION-->
<?php   }?>
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
<title>Various checks</title>
<body>

<?php 

include("report_unloggedpage.php"); 

//----------------------home button------------------
	include("home_button.php");
	 ?>
</body>
</head>
</html>
<?php 
}
?>
