<?php
session_start();
if(isset($_SESSION['adminid_original'])){
include '../connect2db.php';
include 'necessary_info.php';
$idvalue=$_GET['idvalue'];

//----------------- STARTING OF THE PERFORMACE CHECKING---------------------
function performance($value){
		$smallest = min($value);

		if($smallest<5){
			return "poor";
		}
		elseif($smallest==5){
			return "average";
		}
		elseif ($smallest>=6 and $smallest<8) {
			return "good";
		}
		elseif ($smallest>=8) {
			return "excellent";
		}
	}
//--------------------------END OF PERFORMANCE CHECK------------------
//--------------------------FUNCTION TO RETRIEVE CLI ID AND TLC ID----
function separateId($id){
	$cli_id = $tlc_id = '';
	$id = explode("||", $id);
	$cli_id = $id[0];
	if(sizeof($id)>1) $tlc_id = $id[1];
	$res = ['cli_id'=>$cli_id, 'tlc_id'=>$tlc_id];
	return $res;
}
//--------------------------FUNCTION TO RETRIEVE NAME----------------
function getName($id, $option){
	$ret = '';
	if ($option == "cli") {$table = "clis_details"; $name = "clis_name"; $matching_id = "clis_cms_id";}
	else if($option=="tlc") {$table = "controller_details";$name = "controller_name"; $matching_id = "controller_id"; }
	else return $ret;
	global $conn;
	 $sql = "select $name from $table where $matching_id='$id'";
	$res = mysqli_query($conn, $sql);
	if(mysqli_num_rows($res)>0){
		$row = mysqli_fetch_assoc($res);
		$ret =  $row[$name];
	}
	return $ret;

}
//--------------------------FUNCTION TO PRINT THE HEADING-------------

function getHeading($cli_id, $tlc_id){
	$cli_name = $tlc_name = $heading='';
	if ($cli_id!='') $cli_name = getName($cli_id,"cli");
	if ($tlc_id!='')$tlc_name = getName($tlc_id,"tlc");
	if($cli_name!='') $heading .= "<b>CLI:</b><i>$cli_id</i> || $cli_name<br>";
	if($tlc_name!='') $heading .= "<b>TLC:</b><i>$tlc_id</i> || $tlc_name";
	return $heading;
}
//--------------------------FORMAT OF HEADINGS------------------------
		function formatHeading($h){
			$h = str_replace("_"," ",$h);
			$h = strtoupper($h);
			return $h;
		}
//--------------------------------------------------------------------


$sql = "SELECT * FROM `foot_plate_inspection` WHERE id='$idvalue'";
$query_res = mysqli_query($conn, $sql);
if(mysqli_num_rows($query_res)>0){
			
			//-----------------------Extracting all data ----------------------
				
			$Result_set = [];
			$headings = [];
			
			$observation = ['bct', 'bft', 'bpt', 'lc', 'snsn', 'hg','caution_aspect', 'st1', 
								'st2', 'red', 'alertness', 'caution_order','attacking', 
								'up_technique', 'brake_technique', 'spad', 'vcd', 'cts', 'pts'];
			
			while($row = mysqli_fetch_assoc($query_res)){
			//-----------------------Extracting all data ----------------------
				$temp = [];
				$performance_param = [];
				$observation_temp = [];
				
				foreach ($row as $key => $value) {				
					
					if(in_array($key, $observation)) array_push($performance_param, $value);
					if($key=="id"||in_array($key, $observation)) continue;
					$temp[$key] = $value;
				}
				
				$temp['performance'] = performance($performance_param);
				$Result_set["general_info"] = $temp;

				foreach ($row as $key => $value) {
					
					if(in_array($key, $observation)){
						$observation_temp[$key] = $value;
					} 
				}
				$Result_set["observation"] = $observation_temp;
				
			}
		       $gen_headings = array_keys($Result_set["general_info"]);
		       $obs_headings = array_keys($Result_set["observation"]);
				
			//------------------------End of Extraction ------------------------
			//------------------------DISPLAYING THE DATA -----------------------------

		     
	} //eclosing the logged in condition	 
?>
<html>
<head>
	<title>LP Profile</title>
	<link rel="shortcut icon" href="pic/logo.ico" />
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<style type="text/css">
		#profile_data{
			text-transform: uppercase;
		}
	</style>
</head>
<body>
	<?php if(isset($_SESSION['adminid_original']))
		{
	?>
	<div class="container main_content">
        <div class="rows">
        	<div class="col-lg-6">
        		<div class="panel panel-primary" align="left">
        		<div class="panel-heading">
        			<h3 class="panel-title">Loco Profile</h3>
        		</div>
        		<div class="panel-body" id="profile_data">
					<table name = "profie_table" class="table table-bordered table-hover" >
						<?php
						$gi = $Result_set['general_info'];
						$c = separateId($gi['clis_cms_id']);
						$h = getHeading($c['cli_id'],$c['tlc_id']);
						echo "<tr >								
								<td colspan='2' style='text-align:center;'>$h</td>

							</tr>";
						foreach ($gi as $h => $d) {
							if($h=='clis_cms_id') continue;
							$h = formatHeading($h);
							echo "<tr>
								<th>$h</th>
								<td>$d</td>

							</tr>";
						}
						?>
						
				
				</table>
				</div>
			</div>
        	</div>
        	<div class="col-lg-6">
        		
        				<div class="panel panel-primary" align="left">
        		<div class="panel-heading">
        			<h3 class="panel-title">Observation</h3>
        		</div>
        		<div class="panel-body" id="profile_data">
					<table name = "profie_table" class="table table-bordered table-hover" >
						<?php
						$od = $Result_set['observation'];
						foreach ($od as $h => $d) {
							$h = getFullForm($h);
							echo "<tr>
								<th>$h</th>
								<td>$d</td>

							</tr>";
						}
						?>
					
				</table>
				</div>
			</div>
        			<?php

        			}
        		?>
        	</div>
        </div>  	
	</div>
	<?php 
		} // end of logged in
		else{
			include("report_unloggedpage.php");
		}
		include("home_button.php");
	?>
</body>
</html>
