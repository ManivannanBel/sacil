<?php
//------------------------------START OF SCRIPT -------
$Date=$Place=$LPs_Name=$Remarks=$CBcrc=$LCBdate=$LCBconductor=$CBssnumber='';

//	TO UPDATE VALUE CHECK---------------------------------------
if(isset($_SESSION["idu"])){
		$id_set = 1;
		$idu = $_SESSION["idu"];
		$select_query1 = "SELECT * FROM `cb` WHERE `id` = $idu AND `clis_cms_id`='$cli_id'";
		$query_result1 = mysqli_query($conn, $select_query1);
		if(mysqli_num_rows($query_result1)>0){
			while($row = mysqli_fetch_assoc($query_result1)){
				$Date = format_output($row['date']);
				$CBcrc = format_output($row['on_duty_crc']);
				$LCBdate = format_output($row['lssd']);
				$LCBconductor = format_output($row['lssn']);
				$CBssnumber = format_output($row['no_of_safety_sem']);
				$Place = format_output($row['place']);
				
				$Remarks = format_output($row['remarks']);
			}	
		}
		
}
//---------------------------------END OF UPDATE check--------------------------------------
//-------------------------------SAVING CODE------------------------------------------------

if(isset($_POST["CBsubmit"]) || isset($_POST["CBsubmitUpdate"]) ||isset($_POST["DeleteRecord"])||isset($_POST["modify"])){
	if(!empty($_POST["CBdate"])){
		$Date = format_input($_POST["CBdate"]);
	}
	if(!empty($_POST["CBPlace"])){
		$Place = format_input($_POST["CBPlace"]);
	}
	if(!empty($_POST["CBremarks"])){
		$Remarks = format_input($_POST["CBremarks"]);
	}
	if(!empty($_POST["CBcrc"])){
		$CBcrc = format_input($_POST["CBcrc"]);
	}
	if(!empty($_POST["LCBdate"])){
		$LCBdate = format_input($_POST["LCBdate"]);
	}
	if(!empty($_POST["LCBconductor"])){
		$LCBconductor = format_input($_POST["LCBconductor"]);
	}
	if(!empty($_POST["CBssnumber"])){
		$CBssnumber = format_input($_POST["CBssnumber"]);
	}
if(isset($_POST["CBsubmit"])){
$sql = "INSERT INTO `cb` (`id`, `date`,`on_duty_crc`,`lssd` ,`lssn`,`no_of_safety_sem`,`place`, `remarks`,  `clis_cms_id`) 
VALUES (NULL, '$Date','$CBcrc','$LCBdate','$LCBconductor','$CBssnumber','$Place', '$Remarks',  '$cli_id')";
$res = mysqli_query($conn,$sql);
          if($res){
              $response_msg = 1;
           		$table = 'Crew Booking';	              	           	
	              	$location_recorded = writeLocationToDB($cli_id,$table,$dloc);	   
          }
          else{
              $response_msg = 0;            
          }
}
else if(isset($_POST["CBsubmitUpdate"])){
			      	if(!empty($_POST["trans_id"])){
					$idu = $_POST["trans_id"];
						}
      	     $sql = "UPDATE `cb` SET `date` = '$Date', `on_duty_crc` = '$CBcrc', `lssd` = '$LCBdate', `lssn` = '$LCBconductor', `no_of_safety_sem` = '$CBssnumber', `place` = '$Place', `remarks` = '$Remarks' WHERE `cb`.`id` = $idu AND `clis_cms_id` like '$cli_id';";
      	$res = mysqli_query($conn,$sql);
          if($res){
              $response_msg = 2;
          }
          else{
              $response_msg = 0;            
          }
          //unset($_SESSION['idu']);
          $id_set = 0;

      }
      else if(isset($_POST["DeleteRecord"])){
      	$idu = format_input($_POST["trans_id"]);
      	$sql = "DELETE FROM `cb` WHERE `cb`.`id` = $idu AND `clis_cms_id`='$cli_id'";
      	$res = mysqli_query($conn,$sql);
          if($res){
              $response_msg = 3;
          }
          else{
              $response_msg = 0;            
          }
          //unset($_SESSION['idu']);
          $id_set = 0;
      }
 }
//-------------------------------END OF SCRIPT--------------------------
?>

<div class="panel-body">
<?php
	if($id_set==1){
		echo "<div id='status_of_form'><p>Update Record Ref: ".$idu."</p></div>";
	}else{
		echo "<div id='status_of_form'><p>Add New Record</p></div>";
	}
	echo "<br>";
?>
<form name="CB" method="post" action="">

	<table name = "CBt1">
		<tr>		
			<td><input type="hidden"  class = "form-control" name="trans_id" <?php if($id_set==1){
				$temp_id = $_SESSION['idu'];
			echo "value='$temp_id'";}  ?>/></td>
		</tr>
		<tr>
			<th>Date:</th>
			<td><input type="date" class = "form-control" name="CBdate" placeholder = "dd-mm-yyyy" <?php if($id_set==1) echo "value='$Date'"; ?>/></td>
		</tr>
		<tr>
			<th>Place: </th>
			<td><input type="text" class = "form-control" name="CBPlace" placeholder = "Place" <?php if($id_set==1) echo "value='$Place'"; ?>/></td>
		</tr>
		<tr>
			<th>On Duty CRC: </th>
			<td><input type="text" class = "form-control" name="CBcrc" placeholder = "Name" <?php if($id_set==1) echo "value='$CBcrc'"; ?>/></td>
		</tr>
		<tr>
			<th>Last Safety Seminar Conducted Date:</th>
			<td><input type="date" class = "form-control" name="LCBdate" placeholder = "dd-mm-yyyy" <?php if($id_set==1) echo "value='$LCBdate'"; ?>/></td>
		</tr>
		<tr>
			<th>Last Safety Seminar Conducted By: </th>
			<td><input type="text" class = "form-control" name="LCBconductor" placeholder = "Name" <?php if($id_set==1) echo "value='$LCBconductor'"; ?>/></td>
		</tr>
		<tr>
			<th>No. of Safety Seminar in this Month: </th>
			<td><input type="number" class = "form-control" name="CBssnumber"  <?php if($id_set==1) echo "value='$CBssnumber'"; ?>/></td>
		</tr>		
		<tr>
		    <th>Remarks:</th>
			<td rowspan="3"><textarea class = "form-control" name="CBremarks" rows="3" cols="15" ><?php if($id_set==1) echo "$Remarks"; ?></textarea></td>
		</tr>			
	</table>
	<div class="spacing-for-button">
	<?php
		if($id_set==1){
	?>
	<input type="submit" name="CBsubmitUpdate" value="Update" class="btn btn-success"></input>
	<input type="submit" name="DeleteRecord" value="Delete" class="btn btn-danger"></input>
	<?php
		unset($_SESSION['idu']);
		$id_set = 0;
	}else{
	?>
	<input type="submit" name=
				"CBsubmit" value="Save" class="
				btn btn-success"></input>
	<?php 
		}
		
	 ?>
	<input type="submit" name="modify" value="Display" class="btn btn-warning"></input>
	
	
	<?php
	if($modify_set==1){
	//----------------------------LIST OF RECORDS----------------------------
		echo "<hr><br>";
		$select_query = "SELECT * FROM `cb` WHERE `date` LIKE '%$Date%' AND `place` LIKE '%$Place%' AND `remarks` LIKE '%$Remarks%' AND `clis_cms_id`='$cli_id' order by `id` desc limit 5";
		$query_result = mysqli_query($conn,$select_query);
		if(mysqli_num_rows($query_result)>0){
			echo '<div class="checks list-group">';
			while($row = mysqli_fetch_assoc($query_result)){
				$id1 = $row["id"];
				
				echo '<a class="list-group-item" href="god.php?fname=cb&idu='.$id1.'">'."<b>id:</b> " . $row["id"]. "&nbsp<b>date:</b>" . format_output($row["date"]). "&nbsp<b>crc:</b>" . format_output($row["on_duty_crc"]). "&nbsp<b>last SS on:</b>" . format_output($row["lssd"]). "&nbsp<b>by:</b>" . format_output($row["lssn"]). "&nbsp<b>no. of SS this month:</b>" . format_output($row["no_of_safety_sem"]). "&nbsp<b>place:</b> " . format_output($row["place"]). "&nbsp<b>remarks:</b> ".format_output($row["remarks"])."</a>";
			}
			echo '</div>';
		}else{
		echo "Zero records found";
	}
		}
	//-------------------------------END OF RECORDS-------------------------
		
	?>					
	</div>			

</form>
</div>