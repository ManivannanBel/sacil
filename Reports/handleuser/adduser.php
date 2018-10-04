<?php
session_start();
if(isset($_SESSION['admin_original'])){
include("connect2db.php");
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
//--------------------------------------------------------------
$Name=$Cliscmsid=$Railway=$Division=$Hq=$Active=$Email=$Phone=$controller_id = '';
$designation = $station = $grade = $traction = $cli_id = [];
//------------------------------filling the data-----------
$designation = ['LPM','LPP','LPG','LPS','ALP'];
$station = ['ED', 'SA','CBE','ONR'];
$grade = ['A', 'B','C', 'D'];
$traction = ['AC','DSL','AC/DSL','DEMU','MEMU'];

$getCLI = "select clis_cms_id from clis_details order by clis_cms_id";
$cliRes = mysqli_query($conn,$getCLI);
if($cliRes){
	while($row=mysqli_fetch_assoc($cliRes)){
		array_push($cli_id, $row['clis_cms_id']);
	}
}

//-------------------------ADDING CLI----------------
if(isset($_POST["addusersubmit"])){
	if(!empty($_POST["name"])){
		$Name = format_input($_POST["name"]);
	}
	if(!empty($_POST["cliscmsid"])){
		$Cliscmsid = format_input($_POST["cliscmsid"]);
	}
	if(!empty($_POST["railway"])){
		$Railway = format_input($_POST["railway"]);
	}
	if(!empty($_POST["division"])){
		$Division = format_input($_POST["division"]);
	}
	if(!empty($_POST["hq"])){
		$Hq = format_input($_POST["hq"]);
	}
	if(!empty($_POST["active"])){
		$Active = format_input($_POST["active"]);
	}
	if(!empty($_POST["email"])){
		$Email = format_input($_POST["email"]);
	}
	if(!empty($_POST["phone"])){
		$Phone = format_input($_POST["phone"]);
	}

	$sql="INSERT INTO `clis_details` (`id`, `railway`, `division`, `clis_name`, `clis_cms_id`, `paswd`, `hq`, `Active`, `email`, `phone`) VALUES (NULL, '$Railway', '$Division', '$Name', '$Cliscmsid', '$Cliscmsid', '$Hq', '$Active', '$Email', '$Phone');"; //password is same as cliscmsid initially
	$res=mysqli_query($conn,$sql);
	if(!$res){
		$response_msg = 1;
		echo "not added";
    }
    else{
        header("location:index.php");            
    }
}
//---------------------------------------------------------ADDING TLC-------------------
if(isset($_POST['addtlc'])){
	echo "adding tlc";
	if(!empty($_POST["tlcname"])){
		$Name = format_input($_POST["tlcname"]);
	}
	if(!empty($_POST["tlcid"])){
		$controller_id = format_input($_POST["tlcid"]);
	}
	if(!empty($_POST["tlcemail"])){
		$Email = format_input($_POST["tlcemail"]);
	}
	if(!empty($_POST["tlcphone"])){
		$Phone = format_input($_POST["tlcphone"]);
	}

	 $sql= "INSERT INTO `controller_details` (`id`, `controller_id`, `controller_name`, `phone`, `email`, `paswd`) VALUES (NULL, '$controller_id', '$Name', '$Phone', '$Email', '$controller_id')";
	$res=mysqli_query($conn,$sql);
	if(!$res){
		$response_msg = 1;
		echo "not added";
    }
    else{
        header("location:index.php");            
    }
}
//-----------------------------------------------add lp---------------------------------
if(isset($_POST['addlp'])){
	$lp_id = $pf_no = $name = $des = $stn = $gr = 
	$ncli = $clis_cms_id = $pme = $grs = $ac = $dsl = $lmd = $trac='';
	if(!empty($_POST['lpcmsid'])){
		$lp_id = format_input($_POST['lpcmsid']);
	}
	if(!empty($_POST['pfno'])){
		$pf_no = format_input($_POST['pfno']);
	}
	if(!empty($_POST['lpname'])){
		$name = format_input($_POST['lpname']);
	}
	
	if(!empty($_POST['lpdesignation'])){
		$des = format_input($_POST['lpdesignation']);
	}
	if(!empty($_POST['lpstation'])){
		$stn = format_input($_POST['lpstation']);
	}
	if(!empty($_POST['lpgrade'])){
		$gr = format_input($_POST['lpgrade']);
	}
	if(!empty($_POST['lptraction'])){
		$trac = format_input($_POST['lptraction']);
	}
	if(!empty($_POST['ncli'])){
		$ncli = format_input($_POST['ncli']);
	}
	if(!empty($_POST['lp_clis_cms_id'])){
		$clis_cms_id = format_input($_POST['lp_clis_cms_id']);
	}
	if(!empty($_POST['pmedue'])){
		$pme = format_input($_POST['pmedue']);
	}
	if(!empty($_POST['grsdue'])){
		$grs = format_input($_POST['grsdue']);
	}
	if(!empty($_POST['acdue'])){
		$ac =format_input( $_POST['acdue']);
	}
	if(!empty($_POST['dsldue'])){
		$dsl = format_input($_POST['dsldue']);
	}
	if(!empty($_POST['lmd'])){
		$lmd = format_input($_POST['lmd']);
	}
	$due_date = getDueDate($lmd,$gr);
	echo $sql = "INSERT INTO `lp_details` (`id`, `lp_id`, `pf_no`, `name`, `designation`, `station`,
	 `grade`, `traction`, `nli`, `clis_cms_id`, `pme_due`, `grs_due`, `ac_due`, `dsl_due`, `last_monitoring_date`, `due_for_monitoring`) VALUES
	 (NULL, '$lp_id', '$pf_no', '$name', '$des', '$stn', '$gr', 
	 	'$trac', '$ncli', '$clis_cms_id', '$pme', '$grs', '$ac', '$dsl', '$lmd', '$due_date')";
$res=mysqli_query($conn,$sql);
	if(!$res){
		$response_msg = 1;
		echo "not added";
    }
    else{
        header("location:index.php");            
    }

	
}



//--------------------------------------------------------------------------------------
?>



<html>
<title>Add Users</title>
<link rel="shortcut icon" href="../pic/logo.ico" />
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<style type="text/css">
		.th{
			padding: 6;
		}
		.td{
			padding: 6;
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
</title>
<body>
<div class="container">	
<div class="panel panel-primary">	
<div class="panel-heading">
<center><h4>Add CLI</h4></center>
</div>
<div class="panel-body" align="center">
<form name="adduser" method="post">
	<table name = "adduser">
	    <tr>
			<th>Name: </th>
			<td><input type="text" class = "form-control" name="name" placeholder = "Name" required></td>
		</tr>	
		<tr>
			<th>CLIs CMS ID:</th>
			<td><input type="text" class = "form-control" name="cliscmsid" placeholder = "CLIs CMS ID"  required></td>
		</tr>
		<tr>
				<th>Active:</th>
				<td><select name="active" class="form-control">
						  <option value="" selected disabled hidden>--ACTIVE--</option>
						  <option value="1">Active</option>
	                      <option value="0">Not Active</option>
				</select>
				</td>
		</tr>
		<tr>
			<th>HQ:</th>
			<td><input type="text" class = "form-control" name="hq" placeholder = "HQ" required></td>
		</tr>
		<tr>
			<th>Railway: </th>
			<td><input type="text" class = "form-control" name="railway" placeholder = "Railway" value="Southern Railway(SR)" required></td>
		</tr>	
		<tr>
			<th>Division:</th>
			<td>
				<select class = "form-control" name="division">
					<option value='MAS'>MAS</option>
					<option value='SA' selected>SA</option>
					<option value='PGT'>PGT</option>
					<option value='TVC'>TVC</option>
					<option value='MDU'>MDU</option>
					<option value='TPJ'>TPJ</option>
					<option value='other'>OTHER</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>Email:</th>
			<td><input type="text" class = "form-control" name="email" placeholder = "Email" required></td>
		</tr>
		<tr>
			<th>Phone No:</th>
			<td><input type="number" class = "form-control" name="phone" placeholder = "Phone" min='5555555555' max= '9999999999' required></td>
		</tr>			
	</table>
	<br>
	<input type="submit" name="addusersubmit" value="ADD CLI" class="btn btn-primary">
</form>
</div>
</div>
<!-- ------------------------------ADD TLC----------------------------------- -->
<div class="panel panel-warning">	
<div class="panel-heading">
<center><h4>Add TLC</h4></center>
</div>
<div class="panel-body" align="center">
	
		<form method="POST">
			<table>
			<tr>
				<th>TLC ID:</th>
				<td><input type="text" class = "form-control" name="tlcid" placeholder = "TLC ID" required></td>
			</tr>

			<tr>
				<th>Name:</th>
				<td><input type="text" class = "form-control" name="tlcname" placeholder = "Name" required></td>
			</tr>
			<tr>
			<th>Email:</th>
			<td><input type="text" class = "form-control" name="tlcemail" placeholder = "Email" required></td>
		</tr>
		<tr>
			<th>Phone No:</th>
			<td><input type="number" class = "form-control" name="tlcphone" placeholder = "Phone" min='5555555555' max= '9999999999' required></td>
		</tr>
		</table>		
		

		<br>
	<input type="submit" name="addtlc" value="ADD TLC" class="btn btn-warning">
	</form>
</div>
</div>

<!-- ------------------------------ END OF ADD TLC----------------------------------- -->
<!-- ------------------------------ADD LP----------------------------------- -->
<div class="panel panel-success">	
<div class="panel-heading">
<center><h4>CREW PARTICULARS FORM</h4></center>
</div>
<div class="panel-body" align="center">
	
		<form method="POST">
			<table>
			<tr>
				<th>LP CMS ID:</th>
				<td><input type="text" class = "form-control" name="lpcmsid" placeholder = "LP CMS ID" required></td>
			</tr>
			<tr>
				<th>PF NO.:</th>
				<td><input type="number" class = "form-control" name="pfno" placeholder = "PF NO." required></td>
			</tr>
			<tr>
				<th>Name:</th>
				<td><input type="text" class = "form-control" name="lpname" placeholder = "LP Name" required></td>
			</tr>
			
		<tr>
			<th>Designation: </th>
			<td>
				<select name="lpdesignation" class="form-control">
										 
						  <option disabled SELECTED value> -- DESIGNATION -- </option>
						  <?php
						  	foreach ($designation as $des) {
						  		echo "<option value = '$des'>$des</option>";
						  	}
						   ?>
						  
	                      
	                     
				</select>
			</td>
		</tr>	
		<tr>
			<th>Station:</th>
			<td>
				<select class = "form-control" name="lpstation">
					 <option disabled SELECTED value> -- STATION -- </option>
					 <?php
						  	foreach ($station as $st) {
						  		echo "<option value = '$st'>$st</option>";
						  	}
						   ?>
					
				</select>
			</td>
		</tr>

		<tr>
			<th>Grade:</th>
			<td>
				<select class = "form-control" name="lpgrade">
					 <option disabled SELECTED value> -- GRADE -- </option>
					 <?php
						  	foreach ($grade as $gr) {
						  		echo "<option value = '$gr'>$gr</option>";
						  	}
						   ?>
					
				</select>
			</td>
		</tr>

		<tr>
			<th>Traction Trained:</th>
			<td>
				<select class = "form-control" name="lptraction">
					 <option disabled SELECTED value> -- TRACTION -- </option>
					 <?php
						  	foreach ($traction as $tr) {
						  		echo "<option value = '$tr'>$tr</option>";
						  	}
						   ?>
					
				</select>
			</td>
		</tr>

		<tr>
				<th>N CLI:</th>
				<td><input type="text" class = "form-control" name="ncli" placeholder = "N CLI" required></td>
		</tr>
		<tr>
				<th>CLI CMS ID:</th>
				<td><select class = "form-control" name="lp_clis_cms_id">
					 <option disabled SELECTED value> -- CLI CMS ID -- </option>
					 <?php
						  	foreach ($cli_id as $id) {
						  		echo "<option value = '$id'>$id</option>";
						  	}
						   ?>
					
				</select></td>
		</tr>
		<tr>
				<th>PME Due:</th>
				<td><input type="date" class = "form-control" name="pmedue" placeholder = "PME Due" ></td>
		</tr>
		<tr>
				<th>GRS Due:</th>
				<td><input type="date" class = "form-control" name="grsdue" placeholder = "GRS Due" ></td>
		</tr>
		<tr>
				<th>AC Due:</th>
				<td><input type="date" class = "form-control" name="acdue" placeholder = "AC Due" ></td>
		</tr>
		<tr>
				<th>DSL Due:</th>
				<td><input type="date" class = "form-control" name="dsldue" placeholder = "DSL Due" ></td>
		</tr>
		<tr>
				<th>Last Monitoring Date:</th>
				<td><input type="date" class = "form-control" name="lmd" placeholder = "Last Monitoring Date"></td>
		</tr>
		<tr>
				<th>Due for Monitoring:</th>
				<td><input type="date" class = "form-control" name="dmd" placeholder = "Due for Monitoring" disabled></td>
		</tr>
		</table>		
		

		<br>
	<input type="submit" name="addlp" value="ADD" class="btn btn-success">
	</form>
</div>
</div>

<!-- ------------------------------ END OF ADD LP----------------------------------- -->

</div>
<a href="index.php" class="btn btn-primary btn-md btn-circle btn-xl" id="homebutton"><span class="glyphicon glyphicon-home "id="home"></span></a>
</body>
</html>
<?php } ?>