<?php
session_start();
if(isset($_SESSION['admin_original'])){
?>

 <!DOCTYPE html>
<html>
<head>
	<title>Users Management</title>
	<link rel="shortcut icon" href="../pic/logo.ico" />
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<style type="text/css">
#stickybutton{
    	  position: fixed;
		  bottom: 20px;
		  right: 30px;
		  z-index: 99;
		  border: none;
	}
	#homebutton{
    	  position: fixed;
		  bottom: 20px;
		  right: 90px;
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
	padding-top:30px;
}
#home
{		
	padding-top:5px;
}
</style>
</head>
<body style="font-size: 1.5rem;">
	<div class="jumbotron myjumbotron" style="text-align: center;">
	<h1>CLI MONITORING PORTAL</h1>
  	<p>Salem Division, Southern Railway</p>
  			<p><b>User Details</b></p>
		<?php include("searchuser.php");?>
		
	</div>
	<a href="../" class="btn btn-primary btn-md btn-circle btn-xl" id="homebutton"><span class="glyphicon glyphicon-home "id="home"></span></a>
	<?php
	//echo $isset.$role;
	//---------------------------------FOR CLI--------------------------------------------
if($isset==1){
	$sql="SELECT * FROM `clis_details` WHERE `clis_name` LIKE '%$Name%' AND `clis_cms_id` LIKE '%$Cliscmsid%' ORDER BY `clis_name`";
	$res=mysqli_query($conn,$sql);
	if(mysqli_num_rows($res)>0){
		echo '<div class="checks list-group">';
		echo '<table class="table table-bordered">';
		echo '<tr><th>SN</th><th>CLIs Name</th><th>Railway</th><th>Division</th><th>CLIs CMS ID</th><th>Active</th><th>Headquarter</th><th>Email</th><th>Phone</th><th>Operation</th></tr>';
			$sn = 0;
			while($row = mysqli_fetch_assoc($res)){
		//		$id1 = $row["id"];
				$sn++;
			//	echo '<a class="list-group-item" href="">'."<b>Id:</b> " . $row["id"]. "&nbsp<b>CLIs name:</b>" . $row["clis_name"]. "&nbsp<b>CLIs CMS Id:</b>" . $row["clis_cms_id"]. "&nbsp<b>:Railway</b> " . $row["railway"]."&nbsp<b>:Division</b> " . $row["division"]. "&nbsp<b>Active:</b> ".$row["Active"]. "&nbsp<b>HQ:</b>" . $row["hq"]. "&nbsp<b>CLIs name:</b>" . $row["clis_name"]"</a>";
			 $id=format_output($row["id"]);
			 $clisname=format_output($row["clis_name"]);
			 $railway=format_output($row["railway"]);
			 $division=format_output($row["division"]);
			 $cliscmsid=format_output($row["clis_cms_id"]);
			 $active=format_output($row["Active"]);
			 $hq=format_output($row["hq"]);
			 $email=format_output($row["email"]);
			 $phone=format_output($row["phone"]);
			 echo "<tr><td>$sn</td><td>$clisname</td><td>$railway</td><td>$division</td><td>$cliscmsid</td><td>$active</td><td>$hq</td><td>$email</td><td>$phone</td>";
			 echo "<td><a  class='btn btn-md btn-warning'href='updateuser.php?id=$cliscmsid'>Edit</a>    
			 		   </td></tr>";?>
		<?php

		}
		echo "</table>";
	}
	else{
		$message= "Zero records found";
	}
}
//------------------------------FOR TLC-----------------------------------
if($isset==2){
	$sql="SELECT * FROM `controller_details` WHERE  `controller_name` LIKE '%$Name%' AND `controller_id` LIKE '%$Cliscmsid%' ORDER BY `controller_name`";
	$res=mysqli_query($conn,$sql);
	if(mysqli_num_rows($res)>0){
		echo '<div class="checks list-group">';
		echo '<table class="table table-bordered">';
		echo '<tr><th>SN</th><th>TLC Name</th><th>TLC ID</th><th>Phone</th><th>Email</th><th>Operation</th></tr>';
			$sn = 0;
			while($row = mysqli_fetch_assoc($res)){
		//		$id1 = $row["id"];
				$sn++;
			//	echo '<a class="list-group-item" href="">'."<b>Id:</b> " . $row["id"]. "&nbsp<b>CLIs name:</b>" . $row["clis_name"]. "&nbsp<b>CLIs CMS Id:</b>" . $row["clis_cms_id"]. "&nbsp<b>:Railway</b> " . $row["railway"]."&nbsp<b>:Division</b> " . $row["division"]. "&nbsp<b>Active:</b> ".$row["Active"]. "&nbsp<b>HQ:</b>" . $row["hq"]. "&nbsp<b>CLIs name:</b>" . $row["clis_name"]"</a>";
			 $id=format_output($row["id"]);
			 $controller_name=format_output($row["controller_name"]);
			 $controller_id=format_output($row["controller_id"]);
			 $phone=format_output($row["phone"]);
			 $email=format_output($row["email"]);

			 echo "<tr><td>$sn</td><td>$controller_name</td><td>$controller_id</td><td>$phone</td><td>$email</td>";
			 echo "<td><a  class='btn btn-md btn-warning'href='updateuser.php?tlcid=$controller_id'>Edit</a>    
			 		   </td></tr>";?>
		<?php

		}
		echo "</table>";
	}
	else{
		$message= "Zero records found";
	}
}

//------------------------------END OF TLC-----------------------------------
//------------------------------for crew -------------------------------------
if($isset == 3){
	$lim = 200;
	$sql = "SELECT * FROM `lp_details` where `name` like '%$Name%'";
	if(!empty($Cliscmsid)){
			 $sql .= "AND (`lp_id` like '$Cliscmsid' or `clis_cms_id` like '$Cliscmsid' or `pf_no` like '$Cliscmsid')"; 
			}
	$sql .= "order by name limit $lim";
	//echo $sql;
	$res=mysqli_query($conn,$sql);
	if(mysqli_num_rows($res)>0){
		$sn  = 1;
		$set = [];
		while ($row = mysqli_fetch_assoc($res)) {
			$temp = '';
			$temp['SN'] = $sn++; 
			foreach ($row as $h => $d) {
				if($h == 'id') continue;
				$temp[$h] = $d;
			}
			array_push($set, $temp);
		}
		$headings = array_keys($set[0]);
		echo '<div class="checks list-group">';
		echo '<table class="table table-bordered">';
		//printing headings
		echo "<tr>";
		foreach ($headings as $h) {
			$h = strtoupper((str_replace("_", " ", $h)));
			echo "<th>$h</th>";
		}
		echo "<th>Operation</th>";

		echo "</tr>";
		//printing records
		//print_r($set);
		foreach ($set as $key => $rec) {
			$searchid = '';
			echo "<tr>";
			foreach ($rec as $h => $d) {
				if($h == 'lp_id') $searchid = $d;
				echo "<td>".format_output($d)."</td>";
			}
			echo "<td><a  class='btn btn-md btn-warning'href='updateuser.php?lpid=$searchid'>Edit</a>    
			 		   </td></tr>";
			echo "</tr>";
		}

		echo "</table>";

	}else{
		$message= "Zero records found";
	}

}

//-----------------------------end of lp------------------------------------


?>
<a href="adduser.php" class="btn btn-xl btn-primary  btn-circle" id="stickybutton"><i class="glyphicon glyphicon-plus"></i></a>

</body>
</html>
<?php }
?>