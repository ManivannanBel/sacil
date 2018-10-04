<?php
//------------------------------START OF SCRIPT -------
$Date=$Loco_no=$Section=$Remarks=$Train_no=$Timing='';

//	TO UPDATE VALUE CHECK---------------------------------------
if(isset($_SESSION["idu"])){
		$id_set = 1;
		$idu = $_SESSION["idu"];
		$select_query1 = "SELECT * FROM `jss` WHERE `id` = $idu AND `clis_cms_id`='$cli_id'";
		$query_result1 = mysqli_query($conn, $select_query1);
		if(mysqli_num_rows($query_result1)>0){
			while($row = mysqli_fetch_assoc($query_result1)){
				$Date = format_output($row['date']);
				$Loco_no = format_output($row['loco_no']);
				$Section = format_output($row['section']);
				$Remarks = format_output($row['remarks']);
				$Train_no = format_output($row['train_no']);
				$Timing = format_output($row['timing']);
				
			}	
		}
		
}
//---------------------------------END OF UPDATE check--------------------------------------
//-------------------------------SAVING CODE------------------------------------------------

if(isset($_POST["JSSsubmit"]) || isset($_POST["JSSsubmitUpdate"]) ||isset($_POST["DeleteRecord"])||isset($_POST["modify"]) ){
	if(!empty($_POST["JSSdate"])){
		$Date = format_input($_POST["JSSdate"]);
	}
	if(!empty($_POST["JSSlocono"])){
		$Loco_no = format_input($_POST["JSSlocono"]);
	}
	if(!empty($_POST["JSSSection"])){
		$Section = format_input($_POST["JSSSection"]);
	}
	if(!empty($_POST["JSSremarks"])){
		$Remarks = format_input($_POST["JSSremarks"]);
	}
	if(!empty($_POST["JSStrainno"])){
		$Train_no = format_input($_POST["JSStrainno"]);
	}
	if(!empty($_POST["JSSTiming"])){
		$Timing = format_input($_POST["JSSTiming"]);
	}
if(isset($_POST["JSSsubmit"])){
$sql = "INSERT INTO `jss` (`id`, `date`, `loco_no`,`train_no`, `timing` ,`section`,  `clis_cms_id`, `remarks`) 
VALUES (NULL, '$Date', '$Loco_no','$Train_no','$Timing','$Section','$cli_id', '$Remarks')";

$res = mysqli_query($conn,$sql);
if($res){
              $response_msg = 1;
             // $table = 'jss';	              	           	
	              	//$location_recorded = writeLocationToDB($cli_id,$table,$dloc);
          }
          else{
              $response_msg = 0;            
          }
}
else if(isset($_POST["JSSsubmitUpdate"])){
			      	if(!empty($_POST["trans_id"])){
					$idu = format_input($_POST["trans_id"]);
						}
      	 $sql = "UPDATE `jss` SET `date` = '$Date', `loco_no` = '$Loco_no',`train_no`='$Train_no',`timing`='$Timing' ,`section` = '$Section', `remarks` = '$Remarks' WHERE `jss`.`id` = $idu AND `clis_cms_id`='$cli_id'";
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
      	$idu = $_POST["trans_id"];
      	$sql = "DELETE FROM `jss` WHERE `jss`.`id` = $idu AND `clis_cms_id`='$cli_id'";
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
<form name="JSS" method="post" action="">

	<table name = "JSSt1">
		<tr>		
			<td><input type="hidden"  class = "form-control" name="trans_id" <?php if($id_set==1){
				$temp_id = $_SESSION['idu'];
			echo "value='$temp_id'";}  ?>/></td>
		</tr>
		<tr>
			<th>Date:</th>
			<td><input type="date" class = "form-control" name="JSSdate" placeholder = "dd-mm-yyyy" <?php if($id_set==1) echo "value='$Date'"; ?>/></td>
		</tr>
		<tr>
			<th>Loco no: </th>
			<td><input type="number" class = "form-control" name="JSSlocono" placeholder = "Loco number" <?php if($id_set==1) echo "value='$Loco_no'"; ?>/></td>
		</tr>
		<tr>
			<th>Train no: </th>
			<td><input type="text" class = "form-control" name="JSStrainno" placeholder = "Train number" <?php if($id_set==1) echo "value='$Train_no'"; ?>/></td>
		</tr>
		<tr>
			<th>Timing: </th>
			<td><select name="JSSTiming" class="form-control">
						  <?php /*code to write here */?>
						  <?php if($id_set==1){

						  	echo "<option value='$Timing' selected>$Timing</option>";
						  }else{
						  ?> 
						  <option disabled SELECTED value> -- TIMING -- </option>
						  <?php
						  	}
						  ?>
						  <option value="DAY">DAY</option>
	                      <option value="NIGHT">NIGHT</option>
	                  </select>
	        </td>
		</tr>
		<tr>
			<th>Section: </th>
			<td><select name="JSSSection" class="form-control">
						  <?php /*code to write here */?>
						  <?php if($id_set==1){

						  	echo "<option value='$Section' selected>$Section</option>";
						  }else{
						  ?> 
						  <option disabled SELECTED value> -- SECTION -- </option>
						  <?php
						  	}					  
							//extracting all the options from database
							$query1 = "SELECT * FROM `section`";
							$results1 = mysqli_query($conn,$query1);

							foreach ($results1 as $section) {
						?>
							<option value="<?php echo $section['sec']; ?>"><?php echo $section["sec"]; ?></option>
						<?php	
								}

						?>
	                     <option value="other">OTHER</option>
				</select>
			</td>		
		</tr>	
		<tr>
		    <th>Remarks:</th>
			<td rowspan="3"><textarea class = "form-control" name="JSSremarks" rows="3" cols="15" ><?php if($id_set==1) echo "$Remarks"; ?></textarea></td>
		</tr>			
	</table>
	<div class="spacing-for-button">
	<?php
		if($id_set==1){
	?>
	<input type="submit" name="JSSsubmitUpdate" value="Update" class="btn btn-success"></input>
	<input type="submit" name="DeleteRecord" value="Delete" class="btn btn-danger"></input>
	<?php
		unset($_SESSION['idu']);
		$id_set = 0;
	}else{
	?>
	<input type="submit" name=
				"JSSsubmit" value="Save" class="
				btn btn-success"></input>
	<?php 
		}
	 ?>
	<input type="submit" name="modify" value="Display" class="btn btn-warning"></input>
	
	<?php
	if($modify_set==1){
	//----------------------------LIST OF RECORDS----------------------------
		echo "<hr><br>";
		$select_query = "SELECT * FROM `jss` WHERE `date` LIKE '%$Date%' AND `loco_no` LIKE '%$Loco_no%'  AND `train_no` LIKE '%$Train_no%' AND `section` LIKE '%$Section%' AND `remarks` LIKE '%$Remarks%' AND `clis_cms_id`='$cli_id' order by `id` desc limit 5";
		$query_result = mysqli_query($conn,$select_query);
		if(mysqli_num_rows($query_result)>0){
			echo '<div class="checks list-group">';
			while($row = mysqli_fetch_assoc($query_result)){
				$id1 = $row["id"];
				
				echo '<a class="list-group-item" href="god.php?fname=jss&idu='.$id1.'">'."<b>id:</b> " . $row["id"]. "&nbsp<b>date:</b>" . format_output($row["date"]). "&nbsp<b>loco_no:</b> " . format_output($row["loco_no"]). "&nbsp<b>	train_no:</b> " . format_output($row["train_no"]). "&nbsp<b>	timing:</b> " . format_output($row["timing"])."&nbsp<b>section:</b> " . format_output($row["section"]). "&nbsp<b>remarks:</b> ".format_output($row["remarks"])."</a>";
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
