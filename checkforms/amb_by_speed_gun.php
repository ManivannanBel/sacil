<?php
//------------------------------START OF SCRIPT -------
	$Date=$Place=$No_of_trains=$Train_nos=$Remarks='';
//	TO UPDATE VALUE CHECK---------------------------------------
if(isset($_SESSION["idu"])){
		$id_set = 1;
		$idu = $_SESSION["idu"];
		$select_query1 = "SELECT * FROM `amb_by_speed_gun` WHERE `id` = $idu AND `clis_cms_id` LIKE '$cli_id1'";
		$query_result1 = mysqli_query($conn, $select_query1);
		if(mysqli_num_rows($query_result1)>0){
			while($row = mysqli_fetch_assoc($query_result1)){
				$fed_by = format_output($row['clis_cms_id']);
				$Date = format_output($row['date']);
				$Place = format_output($row['place']);
				$No_of_trains = format_output($row['no_of_trains']);
				$Train_nos = format_output($row['train_no']);
				$Remarks = format_output($row['remarks']);
			}	
		}
		
}
//---------------------------------END OF UPDATE check--------------------------------------
//-------------------------------SAVING CODE------------------------------------------------

if(isset($_POST["Ambsubmit"]) || isset($_POST["AmbsubmitUpdate"]) || isset($_POST["DeleteRecord"]) || isset($_POST["modify"])){
	if(!empty($_POST["Ambdate"])){
		$Date = format_input($_POST["Ambdate"]);
	}
	if(!empty($_POST["Ambplace"])){
		$Place = format_input($_POST["Ambplace"]);
	}
	if(!empty($_POST["AmbNoOfTrains"])){
		$No_of_trains = format_input($_POST["AmbNoOfTrains"]);
	}
	if(!empty($_POST["AmbTrainNos"])){
		$Train_nos = format_input($_POST["AmbTrainNos"]);
	}
	if(!empty($_POST["Ambremarks"])){
		$Remarks = format_input($_POST["Ambremarks"]);
	}
if(isset($_POST["Ambsubmit"])){
$sql = "INSERT INTO `amb_by_speed_gun` (`id`, `date`, `place`, `no_of_trains`, `train_no`, `clis_cms_id`, `remarks`) 
VALUES (NULL, '$Date', '$Place', '$No_of_trains', '$Train_nos', '$cli_id', '$Remarks')";
	$res = mysqli_query($conn,$sql);
          if($res){
              $response_msg = 1;
          }
          else{
              $response_msg = 0;            
          }
}
else if(isset($_POST["AmbsubmitUpdate"])){
			      	if(!empty($_POST["trans_id"])){
					$idu = $_POST["trans_id"];
						}
      	 $sql = "UPDATE `amb_by_speed_gun` SET `date` = '$Date', `place` = '$Place', `no_of_trains` = '$No_of_trains', `train_no` = '$Train_nos', `remarks` = '$Remarks' ,`clis_cms_id`='$cli_id' 
WHERE `amb_by_speed_gun`.`id` = $idu AND `clis_cms_id` LIKE '$cli_id1'";
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
      	$sql = "DELETE FROM `amb_by_speed_gun` WHERE `amb_by_speed_gun`.`id` = $idu AND `clis_cms_id` like '$cli_id1'";
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
<div class="panel-heading">
	<h4>Speed Gun Check</h4>
</div>
<div class="panel-body">
<?php
	if($id_set==1){
		echo "<div id='status_of_form'><p>Update Record Ref: ".$idu."</p></div>";
	}else{
		echo "<div id='status_of_form'><p>Add New Record</p></div>";
	}
	echo "<br>";
?>
<form name="Amb" method="post" action="">

	<table name = "Ambt1">
		<tr>		
			<td><input type="hidden"  class = "form-control" name="trans_id" <?php if($id_set==1){
				$temp_id = $_SESSION['idu'];
			echo "value='$temp_id'";}  ?>/></td>
		</tr>
		<?php
		//ADDING CLI CMS ID FOR USER INCASE OF CONTROLLER------------------
		if(isset($_SESSION['logged_controller_id'])){
				
				?>
				<tr>
			<th>CLI CMS ID: </th>
			<td><input type="text" class = "form-control" name="clicmsid" placeholder = "CLI CMS ID" 
				<?php if($id_set==1) {
						$cli_id_only = extract_cliid($fed_by);
						echo "value='$cli_id_only'";

					}
					 ?>
						/>
					</td>
		</tr>
				<?php
			}
			//---------------------------------------------------
				?>
		<tr>
			<th>Date:</th>
			<td><input type="date" class = "form-control" name="Ambdate" placeholder = "dd-mm-yyyy" <?php if($id_set==1) echo "value='$Date'"; ?>/></td>
		</tr>

		<tr>
			<th>Place: </th>
			<td><input type="text" class = "form-control" name="Ambplace" placeholder = "Place" <?php if($id_set==1) echo "value='$Place'"; ?>/></td>
		</tr>	

		<tr>
			<th>No of trains: </th>
			<td><input type="number" class = "form-control" name="AmbNoOfTrains" placeholder = "No. of trains" <?php if($id_set==1) echo "value='$No_of_trains'"; ?>/></td>
		</tr>

		<tr>
			<th>Train nos: </th>
			<td><input type="text" class = "form-control" name="AmbTrainNos" placeholder = "Train Nos" <?php if($id_set==1) echo "value='$Train_nos'"; ?>/></td>
		</tr>
			
		
		<tr>
		    <th>Remarks:</th>
			<td rowspan="3"><textarea class = "form-control" name="Ambremarks" rows="3" cols="15" ><?php if($id_set==1) echo "$Remarks"; ?></textarea></td>
		</tr>			
	</table>
	<div class="spacing-for-button">
	<input type="reset" name="Ambreset" class="btn btn-primary" value="Clear"/>
	<?php
		if($id_set==1){
	?>
	<input type="submit" name="AmbsubmitUpdate" value="Update" class="btn btn-success"></input>
	<input type="submit" name="DeleteRecord" value="Delete" class="btn btn-danger"></input>
	<?php
		unset($_SESSION['idu']);
		$id_set = 0;
	}else{
	?>
	<input type="submit" name="Ambsubmit" value="Save" class="btn btn-success"></input>

	<?php 
		}
	 ?>
	<input type="submit" name="modify" value="Display" class="btn btn-warning"></input>

<?php
if($modify_set==1){
	//----------------------------LIST OF RECORDS----------------------------
		echo "<hr><br>";
		$select_query = "SELECT * FROM `amb_by_speed_gun` WHERE `date` LIKE '%$Date%' AND `place` LIKE '%$Place%' AND `no_of_trains` LIKE '%$No_of_trains%' AND `train_no` LIKE '%$Train_nos%' AND `remarks` LIKE '%$Remarks%' AND 
		  `clis_cms_id` like '%$clicmsid%' AND 
		  `clis_cms_id` like '$cli_id1' 
		  order by `id` desc limit $lim";
		  	$query_result = mysqli_query($conn,$select_query);
		if(mysqli_num_rows($query_result)>0){
			echo '<div class="checks list-group">';
			while($row = mysqli_fetch_assoc($query_result)){
				$id1 = $row["id"];
				$ctrl_name = '';
				if(isset($_SESSION['loggeduserid_original'])){
				$ctrl_name = add_TLC_String(extract_controller_name(extract_controller_id($row['clis_cms_id'])));

				}
				echo '<a class="list-group-item" href="god.php?fname=amb_by_speed_gun&idu='.$id1.'">'."<b>id:</b> " . $row["id"]. "&nbsp<b>date:</b>" . format_output($row["date"]). "&nbsp<b>place:</b> " . format_output($row["place"])."&nbsp<b>no_of_trains:</b> " . format_output($row["no_of_trains"])."&nbsp<b>train_no:</b> " . format_output($row["train_no"]). "&nbsp<b>remarks:</b> ".format_output($row["remarks"])."<span id ='controller_style'> $ctrl_name</span></a>";
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