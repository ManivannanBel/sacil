<?php
//echo "This is location tracking";
session_start();
include "../connect2db.php";
//=================function to locate=================================
function locate($latitude1, $longitude1){
	$location =  'Exactly Not Found';
	 if (!preg_match('/^[0-9]+(\.[0-9]{1,})?$/',$latitude1) || !preg_match('/^[0-9]+(\.[0-9]{1,})?$/',$latitude1)) return "InValid Coordinates";
	
    $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude1).','.trim($longitude1).'&sensor=false';
    $json = @file_get_contents($url);
    $data = json_decode($json);
    @$status = $data->status;
    if($status=="OK"){
        //Get address from json data
        $location = $data->results[0]->formatted_address;
    }
        
    
    return $location;

}
    //===================================================

//---------------------------extracting information from location table--------------
$Resultset = [];
$fromdate = '0000-00-00';
$todate = '9999-12-31';
$clisid = '%';
if(isset($_SESSION['adminid_original'])){
if(isset($_POST['location_submit'])){
	if(!empty($_POST['fromdate'])) $fromdate = format_input($_POST['fromdate']);
	if(!empty($_POST['todate'])) $todate = format_input($_POST['todate']);
	if(!empty($_POST['clisid'])) $clisid = format_input($_POST['clisid']);
 $sql = "SELECT user_id as id, clis_name as name, table_name , date_time as date, 
 location as coordinates from user_location INNER Join clis_details where
 
 user_location.user_id=clis_details.clis_cms_id and
 user_location.date_time BETWEEN '$fromdate' and '$todate' and user_location.user_id like '$clisid'
 order by user_location.date_time DESC; ";

 $res = mysqli_query($conn, $sql);
 if($res){
 	$count = 1;
 	while($row=mysqli_fetch_assoc($res)){
 		
 		$temp = [];
 		$temp['sn'] = $count++;
 		foreach ($row as $key => $value) {

 			$temp[$key] = $value;
 			//echo "$key: $value";
 			if($key=='coordinates'){

 				$lat_lon = explode(",", $value);
 				$lat = $lat_lon[0];
 				$lon = $lat_lon[1];

 				$addr = locate($lat,$lon);
 				$temp["address"] = locate($lat,$lon);
 				//echo "Address: $addr";
 			}
 		}
 		array_push($Resultset, $temp);

 	}
 }
}
} //--------------end of session log in--------------
?>
<html>
<head>
	<title>Location Tracking</title>
	<link rel="shortcut icon" href="pic/logo.ico" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	 
<style type="text/css">
.icon-input-btn input[type="submit"]{
        padding-left: 2em;
    }
    .icon-input-btn .glyphicon{
        display: inline-block;
        position: absolute;
        left: 0.65em;
        top: 30%;
    }
    .icon-input-btn{
        display: inline-block;
        position: relative;
    }
</style>
</head>
<body>
	<div id="main-content">
<div id = "searchform" class = "jumbotron" align="middle">
	<h3>CLI LOCATION TRACKING</h3><br>
	<form name = "footplatereport" method="post">
		<table>
			<th>FROM: </th><td><input type="date" name="fromdate" placeholder="DD-MM-YYYY" class="form-control"></td>
			<th>TO: </th><td><input type="date" name="todate" placeholder="DD-MM-YYYY" class="form-control"></td>
			<th>CLI ID: </th><td><input type="text" name="clisid" placeholder="CLI ID" class="form-control"></td>			
			<td><span class="icon-input-btn"><span class="glyphicon glyphicon-search"></span> <input type="submit" class="btn btn-success btn-md" value="Search" name="location_submit"></span>
		</table>
	</form>
</div>
<hr>
<div class="jumbotron jumbo1">
<?php 
	if(isset($_SESSION['adminid_original'])){
if (isset($Resultset) && !empty($Resultset)){ 
		$headings = array_keys($Resultset[0]);

	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Location Tracking</h3>
		</div>
	<div class="panel-body">
	<table class="table table-bordered table-hover">
		<?php
		//---------------headings--------------
			echo '<tr>';
			foreach ($headings as $h) {
				$h = strtoupper($h);
				echo "<th>$h</th>";
			}
			echo '</tr>';
			foreach ($Resultset as $rec) {
				$cords = $rec['coordinates'];?>
				<tr style="cursor:pointer;" onclick="window.open('<?php echo "http://www.google.com/maps/place/$cords"; ?>','_blank');">
				<?php foreach ($rec as $key => $value) {
					echo "<td>$value</td>";
				}
				echo "</tr>";
			}
		?>
	</table>
	</div>
	</div>
	<?php  } 
}//end of login check
else{
	include("report_unloggedpage.php");
}
	?>
</div>
</div>
<?php include("home_button.php");?>
</body>
</html>