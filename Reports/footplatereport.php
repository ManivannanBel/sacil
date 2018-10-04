<?php
$status=0;
session_start();
include '../connect2db.php';
if(isset($_SESSION['adminid_original'])){

$fromdate = "0000-00-00";
$todate= "9999-12-31";

$clisid=$lpsid='';
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
	 //------------------function to extract cli cms id
    function extract_cliid($id){
      $main = explode("||",$id);
      return $main[0];
    }
//--------------------------FORMAT OF HEADINGS------------------------
		function formatHeading($h){
			$h = str_replace("_"," ",$h);
			$h = strtoupper($h);
			return $h;
		}
//--------------------------------------------------------------------
if(isset($_POST['footplatereportsubmit'])){
	$status = 1;
	if(!empty($_POST['fromdate'])){
		$fromdate = $_POST['fromdate'];
	}
	if(!empty($_POST['todate'])){
		$todate = $_POST['todate'];
	}
	if(!empty($_POST['clisid'])){
		$clisid = $_POST['clisid'];
	}
	if(!empty($_POST['lpsid'])){
		$lpsid = $_POST['lpsid'];
	}
	$sql = "SELECT * FROM `foot_plate_inspection` WHERE `date` BETWEEN '$fromdate' AND '$todate'";
	if(!empty($clisid)){
		$sql .= "AND `clis_cms_id` LIKE '$clisid'";
	}
	if(!empty($lpsid)){
		$sql .= "AND `lps_cms_id` LIKE '$lpsid'";
	}
	//echo $sql."<br>";
	$query_res = mysqli_query($conn, $sql);
	
}
}
?>
<html>
<head>
	<title>Reports Generation</title>
	<link rel="shortcut icon" href="pic/logo.ico" />
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	<style type="text/css">
		#myresult{
			text-transform: uppercase;
		}
		#myhide{
			display: none;
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
    .icon-input-btn{
        display: inline-block;
        position: relative;
    }
	</style>
	
</head>
<body>
	
<div id = "main-content">
<div id = "searchform" class = "jumbotron" align="middle">
	<h3>FOOTPLATE INSPECTION REPORT</h3><br>
	<form name = "footplatereport" method="post">
		<table>
			<th>FROM: </th><td><input type="date" name="fromdate" placeholder="DD-MM-YYYY" class="form-control"></td>
			<th>TO: </th><td><input type="date" name="todate" placeholder="DD-MM-YYYY" class="form-control"></td>
			<th>CLI ID: </th><td><input type="text" name="clisid" placeholder="CLI ID" class="form-control"></td>
			<th>LP ID: </th><td><input type="text" name="lpsid" placeholder="LPS ID" class="form-control"></td>
			
			<td><span class="icon-input-btn"><span class="glyphicon glyphicon-search"></span> <input type="submit" class="btn btn-success btn-md" value="Search" name="footplatereportsubmit"></span>
		</table>
	</form>
</div>
<div id="myresult">
	<hr>
	<h3><i>&nbsp &nbsp Search Results</i></h3>
	<hr>
	<?php
			if(!isset($_SESSION['adminid_original'])){ include("report_unloggedpage.php");}
			else{
				
				if($status==1){
			if(mysqli_num_rows($query_res)>0){
			//making an array to hold the entire data
				
			
			
			$Result_set = [];
			$headings = [];
			$counter = 1;
			$observation = ['bct', 'bft', 'bpt', 'lc', 'snsn', 'hg','caution_aspect', 'st1', 
								'st2', 'red', 'alertness', 'caution_order','attacking', 
								'up_technique', 'brake_technique', 'spad', 'vcd', 'cts', 'pts'];
			
			while($row = mysqli_fetch_assoc($query_res)){
			//-----------------------Extracting all data ----------------------
				$temp = [];
				$performance_param = [];
				
				$temp['SN'] = $counter++;
				foreach ($row as $key => $value) {
					//if($key=='clis_cms_id') $value = extract_cliid($value);
					if($key == 'safey_cate') $key = "safety cat";
					$temp[$key] = $value;
					if(in_array($key, $observation)) array_push($performance_param, $value);
				}
				$temp['performance'] = performance($performance_param);
				array_push($Result_set, $temp); 
			}
		        $headings = array_keys($Result_set[0]);
			//------------------------End of Extraction -------------------------

			//------------------------FORMING TABLE -----------------------------
  			echo '<div class="checks list-group">';
			echo '<table  class="table table-bordered table-hover" id="tblResult">';
			echo "<tr>";
			//------------------------HEADING--------------
			foreach ($headings as $tbl_headings){
				if(in_array($tbl_headings, $observation)||$tbl_headings=="id") continue;
				$tbl_headings=formatHeading($tbl_headings);
				echo "<th>$tbl_headings</th>";
			}

			echo "</tr>";
			//-------------DATA-------------------
			
			foreach ($Result_set as $rec) { 
				$d1="idvalue=".$rec['id']; ?>
			 	<tr style="cursor:pointer;" onclick="window.location='<?php echo "profile.php?$d1"; ?>';">
			 	<?php 
			 	foreach ($rec as $key => $value) {
			 		if(in_array($key, $observation)||$key=="id") continue;
					echo "<td>$value</td>";	
			 	}
			 	echo "</tr>";
			 }
			 //------------------------END OF TABLE--------------------------------	
			  ?>
			
			
			
			</table>
			
			<span style="padding:5px 5px; float:right; " ><a href="#" class = "btn btn-md btn-primary"  onclick="JSONtoEXCEL();"><span class="glyphicon glyphicon-export"></span>&nbspEXPORT TO EXCEL</a></span>
			
			</div>
		<?php
			//-------------------PREPARING JSON DATA-----------------------------
			$Jres = array();
			foreach ($Result_set as $row) {
				$tmp = array();
				foreach ($row as $field => $data) {
					if ($field=="id"||in_array($field, $observation)) continue;
					$tmp[$field] = $data;
				}
				foreach ($row as $field => $data) {
					if (in_array($field, $observation)){
					$tmp[$field] = $data;
					}
				}
				array_push($Jres, $tmp);

			}
			$Jhead = array_keys($Jres[0]);
			$Jtable = ["headings"=>$Jhead, "record"=>$Jres, "title"=>"FOOTPLATE INSPECTION REPORT"];
			//--------------------
			/*print_r($Jtable);
			echo "<br>-------------<br>";
			echo json_encode($Jtable);*/

			//-------------------END OF JSON DATA--------------------------------

		}else{
		echo "Zero records found";
	}
}
}

	?>
	
</div>
</div>
<?php
//------------------Scroll to the result area----------------------
    if($status==1){
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
<?php //-------------------including script file and home btn
					 include "scripts/footreport.php"; include("home_button.php");
				//------------------------------------------------------ ?>
</body>
</html>