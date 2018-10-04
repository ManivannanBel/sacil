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
//----------------------------for cli-----------------------
if(isset($_GET['id'])){
$Cliscmsid=format_input($_GET["id"]);
$Name=$Railway=$Division=$Active=$Email=$Phone=$Hq='';
$sql="SELECT * FROM clis_details WHERE clis_cms_id LIKE '$Cliscmsid'";
$res=mysqli_query($conn,$sql);
if($res){
while($row=mysqli_fetch_assoc($res)){
	
			 $name=format_output($row["clis_name"]);
			 $railway=format_output($row["railway"]);
			 $division=format_output($row["division"]);
			 $cliscmsid=format_output($row["clis_cms_id"]);
			 $Active=format_output($row["Active"]);
			 $hq=format_output($row["hq"]);
			 $email=format_output($row["email"]);
			 $phone=format_output($row["phone"]);
}}
	if(isset($_POST["updateuser"])){
	if(!empty($_POST["name"])){
		$Name = format_output($_POST["name"]);
	}
	if(!empty($_POST["railway"])){
		$Railway = format_output($_POST["railway"]);
	}
	if(!empty($_POST["division"])){
		$Division = format_output($_POST["division"]);
	}
	if(!empty($_POST["hq"])){
		$Hq = format_output($_POST["hq"]);
	}
	if(!empty($_POST["active"])){
		$Active = format_output($_POST["active"]);
	}
	if(!empty($_POST["email"])){
		$Email = format_output($_POST["email"]);
	}
	if(!empty($_POST["phone"])){
		$Phone = format_output($_POST["phone"]);
	}
	$sql = "UPDATE `clis_details` SET `railway` = '$Railway', `division` = '$Division', `clis_name` = '$Name', `hq` = '$Hq',`active` = '$Active', `email` = '$Email', `phone` = '$Phone' WHERE `clis_cms_id`LIKE '$Cliscmsid'";
    $res = mysqli_query($conn,$sql);
    if(!$res){
        echo $response_msg = "Unable to update";
    }
    else{
        header("location:index.php");            
    }
}
//----------------------------------delete cli---------------------
//------------------------------delete-------------------
	if(isset($_POST["deleteuser"])){
		$sql = "DELETE FROM `clis_details` WHERE `clis_cms_id` = '$Cliscmsid'";
		$res = mysqli_query($conn,$sql);
    if(!$res){
        echo $response_msg = "Unable to Delete";
    }
    else{
        header("location:index.php");            
    }
	}
}
 // end for cli-------------------------------------------
if(isset($_GET['tlcid'])){
	$tlcid = $_GET['tlcid'];
	$id=$name=$email=$phone='';
	$sql="SELECT * FROM controller_details WHERE controller_id LIKE '$tlcid'";
	$res=mysqli_query($conn,$sql);
	if($res){
	while($row=mysqli_fetch_assoc($res)){
		
				 $id=format_output($row["controller_id"]);
				 $name=format_output($row["controller_name"]);
				 $email=format_output($row["email"]);
				 $phone=format_output($row["phone"]);
	}
}
//---------------------update---------------------
if(isset($_POST["updatetlc"])){

	if(!empty($_POST["name"])){
		$name = format_output($_POST["name"]);
	}
	if(!empty($_POST["email"])){
		$email = format_output($_POST["email"]);
	}
	if(!empty($_POST["phone"])){
		$phone = format_output($_POST["phone"]);
	}
	$sql = "UPDATE `controller_details` SET `controller_name` = '$name', `phone` = '$phone', `email` = '$email' WHERE  `controller_details`.`controller_id` = '$tlcid'";
	$res = mysqli_query($conn,$sql);
    if(!$res){
        echo $response_msg = "Unable to update";
    }
    else{
        header("location:index.php");            
    }
}
//------------------------------delete-------------------
	if(isset($_POST["deletetlc"])){
		$sql = "DELETE FROM `controller_details` WHERE `controller_id` = '$tlcid'";
		$res = mysqli_query($conn,$sql);
    if(!$res){
        echo $response_msg = "Unable to Delete";
    }
    else{
        header("location:index.php");            
    }
	}
}
//---------------------------end of tlc----------------------
//---------------------------lp------------------------------
if(isset($_GET['lpid'])){
	$lpid = $_GET['lpid'];

					$lp_id = $pf_no = $name = $des = $stn = $gr = 
					$ncli = $clis_cms_id = $pme = $grs = $ac = $dsl = $lmd = $trac='';
					$sql="SELECT * FROM lp_details WHERE lp_id like '$lpid'";
					$res=mysqli_query($conn,$sql);
					if($res){
						while($row=mysqli_fetch_assoc($res)){
							
									$lp_id = format_output($row['lp_id']);
									$pf_no = format_output($row['pf_no']);
									$name = format_output($row['name']);
									$des = format_output($row['designation']);
									$stn = format_output($row['station']);
									$gr = format_output($row['grade']);
									$trac = format_output($row['traction']);
									$ncli = format_output($row['nli']);
									$clis_cms_id = format_output($row['clis_cms_id']);
									$pme = format_output($row['pme_due']);
									$grs = format_output($row['grs_due']);
									$ac =format_output( $row['ac_due']);
									$dsl = format_output($row['dsl_due']);
									$lmd = format_output($row['last_monitoring_date']);
									$due_date = format_output($row['due_for_monitoring']);


						}
					}
//------------------------updating lp----------------------
	if(isset($_POST['updatelp'])){
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
	
			$sql = "UPDATE `lp_details` SET `lp_id` = '$lp_id',
					 `pf_no` = '$pf_no', `name` = '$name', `designation` = 
					 '$des', `station` = '$stn', `grade` = '$gr', `traction` = 
					 '$trac', `nli` = '$ncli', `clis_cms_id` = '$clis_cms_id', `pme_due` 
					 = '$pme', `grs_due` = '$grs', `ac_due` 
					 = '$ac', `dsl_due` = '$dsl', 
					 `last_monitoring_date` = '$lmd', 
					 `due_for_monitoring` = '$due_date' 
					 WHERE `lp_details`.`lp_id` like '$lpid';";
			$res = mysqli_query($conn,$sql);
		    if(!$res){
		        echo $response_msg = "Unable to update";
		    }
		    else{
		        header("location:index.php");            
		    }

	}
//-----------------------------------deleting of lp------------
		if(isset($_POST["deletelp"])){
		$sql = "DELETE FROM `lp_details` WHERE `lp_id` like '$lpid'";
		$res = mysqli_query($conn,$sql);
		    if(!$res){
		        echo $response_msg = "Unable to Delete";
		    }
		    else{
		        header("location:index.php");            
		    }
	}


}

//------------------------------end of lp-------------------
?>



<html>
<head>
<title>Update User Details</title>
<link rel="shortcut icon" href="../pic/logo.ico" />

	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</title>
<style type="text/css">
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
}</style>
</head>
<body>
	<?php if(isset($_GET['id'])){?>
	<div class="container"  style="width:70%;">
<div class="panel panel-primary">

<div class="panel-heading">

<h4 class="panel-title">Update User Details</h4>
</div>
<div class="panel-body" align="center">
<form name="updateuser" method="post" action="">

	<table name = "updateuser">

	    <tr>
			<th>CLIs Name: </th>
			<td><input type="text" class = "form-control" name="name" value="<?php echo $name;?>"></td>
		</tr>	
		<tr>
				<th>Active:</th>
				<td><select name="active" class="form-control">
						  <?php
						  if($Active == 1){
						  	$des = "Active";
						  }
						  else $des= "Not Active";
						  echo "<option  selected disabled value='$Active'>$des</option>";
						   ?>
						  <option value="1">Active</option>
	                      <option value="0">Not Active</option>
				</select>
				</td>
		</tr>	
		<tr>
			<th>HQ:</th>
			<td><input type="text" class = "form-control" name="hq" value="<?php echo $hq;?>"></td>
		</tr>
		<tr>
			<th>Railway: </th>
			<td><input type="text" class = "form-control" name="railway" value="<?php echo $railway;?>"></td>
		</tr>	
		<tr>
			<th>Division:</th>
			<td><input type="text" class = "form-control" name="division" value="<?php echo $division;?>"></td>
		</tr>	
		<tr>
			<th>Email:</th>
			<td><input type="text" class = "form-control" name="email" value="<?php echo $email;?>"></td>
		</tr>
		<tr>
			<th>Phone No:</th>
			<td><input type="text" class = "form-control" name="phone" value="<?php echo $phone;?>"></td>
		</tr>			
	</table>
	<br>
	<input type="submit" name="updateuser" value="Update" class="btn btn-success btn-md"></input> &nbsp &nbsp
	<input type="submit" name="deleteuser" value="Delete" class="btn btn-danger btn-md"></input>
</form>
</div>
</div>
</div>
<?php
}
//------------------------------------------------END OF CLI FORM-------------------------------
else if(isset($_GET['tlcid'])){
	
 ?>
<div class="container"  style="width:70%;">
<div class="panel panel-warning">

<div class="panel-heading">

<h4 class="panel-title">Update TLC Details</h4>
</div>
<div class="panel-body" align="center">
<form name="updatetlc" method="post" action="">

	<table name = "updateuser">

	    <tr>
			<th>TLC Name: </th>
			<td><input type="text" class = "form-control" name="name" value="<?php echo $name;?>"></td>
		</tr>	
		<th>Email:</th>
			<td><input type="text" class = "form-control" name="email" value="<?php echo $email;?>"></td>
		</tr>
		<tr>
			<th>Phone No:</th>
			<td><input type="text" class = "form-control" name="phone" value="<?php echo $phone;?>"></td>
		</tr>			
	</table>
	<br>
	<input type="submit" name="updatetlc" value="Update" class="btn btn-success btn-md">&nbsp &nbsp
	<input type="submit" name="deletetlc" value="Delete" class="btn btn-danger btn-md">

</form>
</div>
</div>
</div>


<?php  }//-----------------------------------------end of tlc-------------------------

else if(isset($_GET['lpid'])){
	$designation = ['LPM','LPP','LPG','LPS','ALP'];
	$station = ['ED', 'SA','CBE','ONR'];
	$grade = ['A', 'B','C', 'D'];
	$traction = ['AC','DSL','AC/DSL','DEMU','MEMU'];
	$cli_id = [];
	$getCLI = "select clis_cms_id from clis_details order by clis_cms_id";
$cliRes = mysqli_query($conn,$getCLI);
if($cliRes){
	while($row=mysqli_fetch_assoc($cliRes)){
		array_push($cli_id, $row['clis_cms_id']);
	}
}

?>
<div class="container"  style="width:70%;">
<div class="panel panel-primary">	
<div class="panel-heading">
<center><h4>UPDATE CREW PARTICULARS </h4></center>
</div>
<div class="panel-body" align="center">
	
		<form method="POST">
			<table>
			<tr>
				<th>LP CMS ID:</th>
				<td><input type="text" class = "form-control" name="lpcmsid" placeholder = "LP CMS ID" value="<?php echo $lp_id;?>" required></td>
			</tr>
			<tr>
				<th>PF NO.:</th>
				<td><input type="number" class = "form-control" name="pfno" placeholder = "PF NO." value="<?php echo $pf_no;?>" required></td>
			</tr>
			<tr>
				<th>Name:</th>
				<td><input type="text" class = "form-control" name="lpname" placeholder = "LP Name" value="<?php echo $name;?>" required></td>
			</tr>
			
		<tr>
			<th>Designation: </th>
			<td>
				<select name="lpdesignation" class="form-control">
										 
						  <option disabled  value> -- DESIGNATION -- </option>
						  <?php
						  echo "<option value='$des' selected>$des</option>";
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
					 <option disabled > -- STATION -- </option>
					 <?php
					 		 echo "<option value='$stn' selected>$stn</option>";
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
					 <option disabled > -- GRADE -- </option>
					 <?php
					 	 echo "<option value='$gr' selected>$gr</option>";
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
					 <option disabled > -- TRACTION -- </option>
					 <?php
					  echo "<option value='$trac' selected>$trac</option>";
						  	foreach ($traction as $tr) {
						  		echo "<option value = '$tr'>$tr</option>";
						  	}
						   ?>
					
				</select>
			</td>
		</tr>

		<tr>
				<th>N CLI:</th>
				<td><input type="text" class = "form-control" name="ncli" placeholder = "N CLI" value="<?php echo $ncli;?>" required></td>
		</tr>
		<tr>
				<th>CLI CMS ID:</th>
				<td><select class = "form-control" name="lp_clis_cms_id">
					 <option disabled> -- CLI CMS ID -- </option>
					 <?php
					 		 echo "<option value='$clis_cms_id' selected>$clis_cms_id</option>";
						  	foreach ($cli_id as $id) {
						  		echo "<option value = '$id'>$id</option>";
						  	}
						   ?>
					
				</select></td>
		</tr>
		<tr>
				<th>PME Due:</th>
				<td><input type="date" class = "form-control" name="pmedue" value="<?php echo $pme;?>" placeholder = "PME Due" ></td>
		</tr>
		<tr>
				<th>GRS Due:</th>
				<td><input type="date" class = "form-control" name="grsdue" value="<?php echo $grs;?>" placeholder = "GRS Due" ></td>
		</tr>
		<tr>
				<th>AC Due:</th>
				<td><input type="date" class = "form-control" name="acdue" placeholder = "AC Due" value="<?php echo $ac;?>"></td>
		</tr>
		<tr>
				<th>DSL Due:</th>
				<td><input type="date" class = "form-control" name="dsldue" placeholder = "DSL Due" value="<?php echo $dsl;?>" ></td>
		</tr>
		<tr>
				<th>Last Monitoring Date:</th>
				<td><input type="date" class = "form-control" name="lmd" placeholder = "Last Monitoring Date" value="<?php echo $lmd;?>"></td>
		</tr>
		<tr>
				<th>Due for Monitoring:</th>
				<td><input type="date" class = "form-control" name="dmd" placeholder = "Due for Monitoring" disabled></td>
		</tr>
		</table>		
		
	<br>
	<input type="submit" name="updatelp" value="Update" class="btn btn-success btn-md">&nbsp &nbsp
	<input type="submit" name="deletelp" value="Delete" class="btn btn-danger btn-md">
	</form>
</div>
</div>
</div>
<?php 
}
//---------------------------------------------------end of lp------------------------
 ?>
<a href="index.php" class="btn btn-primary btn-md btn-circle btn-xl" id="homebutton"><span class="glyphicon glyphicon-home "id="home"></span></a>
</body>
</html>
<?php } ?>