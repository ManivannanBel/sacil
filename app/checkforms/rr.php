<?php
//------------------------------START OF SCRIPT --------------
	$Date=$Place=$LPs_Name=$Remarks='';
	
//	TO UPDATE VALUE CHECK---------------------------------------
if(isset($_SESSION["idu"])){
		$id_set = 1;
		$idu = $_SESSION["idu"];
		$select_query1 = "SELECT * FROM `rr` WHERE `id` = $idu AND `clis_cms_id`='$cli_id'";
		$query_result1 = mysqli_query($conn, $select_query1);
		if(mysqli_num_rows($query_result1)>0){
			while($row = mysqli_fetch_assoc($query_result1)){
				$Date = format_output($row['date']);
				$Place = format_output($row['place']);
				$Remarks = format_output($row['remarks']);
			}	
		}
		
}
//---------------------------------END OF UPDATE check--------------------------------------
if(isset($_POST["RRsubmit"]) || isset($_POST["RRsubmitUpdate"])||isset($_POST["DeleteRecord"])||isset($_POST["modify"])){

			if(!empty($_POST["RRdate"])){
				$Date = format_input($_POST["RRdate"]);
			}
			if(!empty($_POST["RRPlace"])){
				$Place = format_input($_POST["RRPlace"]);
			}
			if(!empty($_POST["RRremarks"])){
				$Remarks = format_input($_POST["RRremarks"]);
			}
	//---------------------------TO SAVE RECORD---------------
	if(isset($_POST["RRsubmit"])){
		$sql = "INSERT INTO `rr` (`id`, `date`, `place`,   `clis_cms_id`, `remarks`) 
		VALUES (NULL, '$Date', '$Place',  '$cli_id', '$Remarks');";
		$res = mysqli_query($conn,$sql);
	          if($res){
	              $response_msg = 1;
	              $table = 'Running Room';	              	           	
	              	$location_recorded = writeLocationToDB($cli_id,$table,$dloc); 
	          }
	          else{
	              $response_msg = 0;            
	          }
      }//------------------------------------------------------
   	//--------------------------TO UPDATE RECORD---------------
      else if(isset($_POST["RRsubmitUpdate"])){
			      	if(!empty($_POST["trans_id"])){
					$idu = format_input($_POST["trans_id"]);
						}
      	 $sql = "UPDATE `rr` SET `date` = '$Date', `place` = '$Place', `remarks` = '$Remarks' WHERE `rr`.`id` = $idu AND `clis_cms_id`='$cli_id';";
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
    //---------------------------END UPDATING------------------
    //---------------------------DELETING DATA-----------------
      else if(isset($_POST["DeleteRecord"])){
      	$idu = $_POST["trans_id"];
      	$sql = "DELETE FROM `rr` WHERE `rr`.`id` = $idu AND `clis_cms_id`='$cli_id'";
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
    //-----------------------------END OF DELETE----------------
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
<form name="RR" method="post" action="">

	<table name = "RRt1">
		<tr>
			
			<td><input type="hidden"  class = "form-control" name="trans_id" <?php if($id_set==1){
				$temp_id = $_SESSION['idu'];
			echo "value='$temp_id'";}  ?>/></td>
		</tr>
		<tr>
			<th>Date:</th>
			<td><input type="date"  class = "form-control" name="RRdate" placeholder = "dd-mm-yyyy" <?php if($id_set==1) echo "value='$Date'"; ?>/></td>
		</tr>
		<tr>
			<th>Location: </th>
							<td><select name="RRPlace" class="form-control">
						  <?php /*code to write here */?>
						  <?php if($id_set==1){

						  	echo "<option value='$Place' selected>$Place</option>";
						  }else{
						  ?> 
						  <option disabled SELECTED value> -- LOCATION -- </option>
						  <?php
						  	}
						  ?>
						  <option value="ED">ED</option>
	                      <option value="CBE">CBE</option>
	                      <option value="MTP">MTP</option>
	                      <option value="SA">SA</option>
	                      <option value="OML">OML</option>
	                      <option value="TPT">TPT</option>
	                      <option value="KRR">KRR</option>
	                      <option value="MTPP">MTPP</option>
	                     
				</select>
			</td>
		</tr>	
		<tr>
		    <th>Remarks:</th>
			<td rowspan="3"><textarea  class = "form-control" name="RRremarks" rows="3" cols="15"><?php if($id_set==1) echo "$Remarks"; ?></textarea></td>
		</tr>			
	</table>
	<div class="spacing-for-button">
	<?php
		if($id_set==1){
	?>
	<input type="submit" name="RRsubmitUpdate" value="Update" class="btn btn-success"></input>
	<input type="submit" name="DeleteRecord" value="Delete" class="btn btn-danger"></input>
	<?php
		unset($_SESSION['idu']);
		$id_set = 0;
	}else{
	?>
	<input type="submit" name="RRsubmit" value="Save" class="btn btn-success"></input>
	<?php 
		}

	 ?>
	<input type="submit" name="modify" value="Display" class="btn btn-warning"></input>
	
	<?php
	if($modify_set==1){

//----------------------------LIST OF RECORDS----------------------------	
		echo "<hr><br>";
		//FRAMING QEUERY
		 $select_query = "SELECT * FROM `rr` WHERE `date` LIKE '%$Date%' AND `place` LIKE '%$Place%' AND `remarks` LIKE '%$Remarks%' AND `clis_cms_id`='$cli_id' order by `id` desc limit 5";
		$query_result = mysqli_query($conn,$select_query);
		if(mysqli_num_rows($query_result)>0){
			
			echo '<div class="checks list-group">';
			while($row = mysqli_fetch_assoc($query_result)){
				$id1 = $row["id"];
				
				echo '<a class="list-group-item" href="god.php?fname=rr&idu='.$id1.'">'."<b>id:</b> " . $row["id"]. "&nbsp<b>date:</b>" . format_output($row["date"]). "&nbsp<b>place:</b> " . format_output($row["place"]). "&nbsp<b>remarks:</b> ".format_output($row["remarks"])."</a>";
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
