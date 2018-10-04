<?php
//------------------------------START OF SCRIPT -------
	$Date=$Crew_Name=$Design=$Train_no=$Phone_no=$Remarks='';
//	TO UPDATE VALUE CHECK---------------------------------------
if(isset($_SESSION["idu"])){
		$id_set = 1;
		$idu = $_SESSION["idu"];
		$select_query1 = "SELECT * FROM `mobile_phone_check` WHERE `id` = $idu AND `clis_cms_id` LIKE '$cli_id1'";
		$query_result1 = mysqli_query($conn, $select_query1);
		if(mysqli_num_rows($query_result1)>0){
			while($row = mysqli_fetch_assoc($query_result1)){
				$fed_by = format_output($row['clis_cms_id']);
				$Date = format_output($row['date']);
				$Crew_Name = format_output($row['crew_name']);
				$Design = format_output($row['design']);
				$Train_no = format_output($row['train_no']);
				$Phone_no = format_output($row['phone_no']);
				$Remarks = format_output($row['remarks']);
			}	
		}
		
}
//---------------------------------END OF UPDATE check--------------------------------------
//-------------------------------SAVING CODE-------------------------------------------
if(isset($_POST["mpcsubmit"]) || isset($_POST["mpcsubmitUpdate"])||isset($_POST["DeleteRecord"])||isset($_POST["modify"])){
	if(!empty($_POST["mpcdate"])){
		$Date = format_input($_POST["mpcdate"]);
	}
	if(!empty($_POST["mpcname"])){
		$Crew_Name = format_input($_POST["mpcname"]);
	}
	if(!empty($_POST["mpcdesign"])){
		$Design = format_input($_POST["mpcdesign"]);
	}
	if(!empty($_POST["mpctrainno"])){
		$Train_no = format_input($_POST["mpctrainno"]);
	}
	if(!empty($_POST["mpcphoneno"])){
		$Phone_no = format_input($_POST["mpcphoneno"]);
	}
	if(!empty($_POST["mpcremarks"])){
		$Remarks = format_input($_POST["mpcremarks"]);
	}

if(isset($_POST["mpcsubmit"])){

$sql = "INSERT INTO `mobile_phone_check` (`id`, `clis_cms_id`, `date`, `crew_name`, `design`, `train_no`, `phone_no`, `remarks`) 
VALUES (NULL, '$cli_id', '$Date', '$Crew_Name', '$Design', '$Train_no', '$Phone_no', '$Remarks')";

$res = mysqli_query($conn,$sql);
if($res){
              $response_msg = 1;
          }
          else{
              $response_msg = 0;            
          }
}
else if(isset($_POST["mpcsubmitUpdate"])){
			      	if(!empty($_POST["trans_id"])){
					$idu = format_input($_POST["trans_id"]);
						}
      	 $sql = "UPDATE `mobile_phone_check` SET `date` = '$Date', `crew_name` = '$Crew_Name', `design` = '$Design', `train_no` = '$Train_no', `phone_no` = '$Phone_no', `remarks` = '$Remarks' ,`clis_cms_id`='$cli_id' 
WHERE `mobile_phone_check`.`id` = $idu AND `clis_cms_id` LIKE '$cli_id1'";
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
      	$sql = "DELETE FROM `mobile_phone_check` WHERE `mobile_phone_check`.`id` = $idu AND `clis_cms_id` LIKE '$cli_id1'";
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
	<h4>Mobile Phone Check</h4>
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
<form name="mpc" method="post" action="">

	<table name = "mpct1">
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
			<td><input type="date" class = "form-control" name="mpcdate" placeholder = "dd-mm-yyyy" <?php if($id_set==1) echo "value='$Date'"; ?>/></td>
		</tr>
		
		<tr>
			<th>Crew Name: </th>
			<td><input type="text" class = "form-control" name="mpcname" placeholder = "Crew name" <?php if($id_set==1) echo "value='$Crew_Name'"; ?>/></td>
		</tr>	

		<tr>
			<th>Designation: </th>
			<td>
				<select name="mpcdesign" class="form-control">
				<?php if($id_set==1){

						  	echo "<option value='$Design' selected>$Design</option>";
						  }else{
						  ?> 
						  <option disabled SELECTED value> -- DESIGNATION -- </option>
						  <?php
						  	}
						  ?>
						  <option value="LPM">LPM</option>
	                      <option value="LPP">LPP</option>
	                      <option value="LPG">LPG</option>
	                      <option value="LPS">LPS</option>
	                      <option value="ALP">ALP</option>
	                      
	                     
				</select>
			</td>
		</tr>	

		<tr>
			<th>Train no: </th>
			<td><input type="text" class = "form-control" name="mpctrainno" placeholder = "Train number" <?php if($id_set==1) echo "value='$Train_no'"; ?>/></td>
		</tr>	
		<tr>
			<th>Phone no: </th>
			<td><input type="number" class = "form-control" name="mpcphoneno" placeholder = "Phone number" <?php if($id_set==1) echo "value='$Phone_no'"; ?>/></td>
		</tr>	
		<tr>
		    <th>Remarks:</th>
			<td rowspan="3"><textarea class = "form-control" name="mpcremarks" rows="3" cols="15" ><?php if($id_set==1) echo "$Remarks"; ?></textarea></td>
		</tr>			
	</table>
	<div class="spacing-for-button">
	<input type="reset" name="mpcreset" class="btn btn-primary" value="Clear"/>
	<?php
		if($id_set==1){
	?>
	<input type="submit" name="mpcsubmitUpdate" value="Update" class="btn btn-success"></input>
	<input type="submit" name="DeleteRecord" value="Delete" class="btn btn-danger"></input>

	<?php
		unset($_SESSION['idu']);
		$id_set = 0;
	}else{
	?>
	<input type="submit" name=
				"mpcsubmit" value="Save" class="
				btn btn-success"></input>
	<?php 
		}
		
	 ?>
	<input type="submit" name="modify" value="Display" class="btn btn-warning"></input>

	<?php
	if($modify_set==1){
	//----------------------------LIST OF RECORDS----------------------------
		echo "<hr><br>";
		$select_query = "SELECT * FROM `mobile_phone_check` WHERE `date` LIKE '%$Date%' AND `crew_name` LIKE '%$Crew_Name%' AND `design` LIKE '%$Design%' AND `train_no` LIKE '%$Train_no%' AND `phone_no` LIKE '%$Phone_no%' AND `remarks` LIKE '%$Remarks%' AND 
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
				echo '<a class="list-group-item" href="god.php?fname=mobile_phone_check&idu='.$id1.'">'."<b>id:</b> " . $row["id"]. "&nbsp<b>date:</b>" . format_output($row["date"]). "&nbsp<b>crew_name:</b> " . format_output($row["crew_name"])."&nbsp<b>design:</b> " . format_output($row["design"])."&nbsp<b>train_no:</b> " . format_output($row["train_no"])."&nbsp<b>phone_no:</b> " . format_output($row["phone_no"]). "&nbsp<b>remarks:</b> ".format_output($row["remarks"])."<span id ='controller_style'> $ctrl_name</span></a>";
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
