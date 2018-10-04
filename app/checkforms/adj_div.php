<?php
//------------------------------START OF SCRIPT -------
$Date=$Loco_no=$Train_no=$From=$To=$LPs_Name=$Remarks='';

//	TO UPDATE VALUE CHECK---------------------------------------
if(isset($_SESSION["idu"])){
		$id_set = 1;
		$idu = $_SESSION["idu"];
		$select_query1 = "SELECT * FROM `adj_division` WHERE `id` = $idu AND `clis_cms_id`='$cli_id'";
		$query_result1 = mysqli_query($conn, $select_query1);
		if(mysqli_num_rows($query_result1)>0){
			while($row = mysqli_fetch_assoc($query_result1)){
				$Date = format_output($row['date']);
				$Loco_no = format_output($row['loco_no']);
				$Train_no = format_output($row['train_no']);
				$From = format_output($row['from1']);
				$To = format_output($row['to1']);
				$LPs_Name = format_output($row['lps_name']);
				$Remarks = format_output($row['remarks']);
			}	
		}
		
}
//---------------------------------END OF UPDATE check--------------------------------------
//-------------------------------SAVING CODE------------------------------------------------

if(isset($_POST["Adjsubmit"])  || isset($_POST["AdjsubmitUpdate"])|| isset($_POST["DeleteRecord"])||isset($_POST["modify"])) {
	if(!empty($_POST["Adjdate"])){
		$Date = format_input($_POST["Adjdate"]);
	}
	if(!empty($_POST["Adjlocono"])){
		$Loco_no = format_input($_POST["Adjlocono"]);
	}
	if(!empty($_POST["Adjtrainno"])){
		$Train_no = format_input($_POST["Adjtrainno"]);
	}
	if(!empty($_POST["Adjfrom"])){
		$From = format_input($_POST["Adjfrom"]);
	}
	if(!empty($_POST["Adjto"])){
		$To = format_input($_POST["Adjto"]);
	}
	if(!empty($_POST["AdjLPname"])){
		$LPs_Name = format_input($_POST["AdjLPname"]);
	}
	if(!empty($_POST["Adjremarks"])){
		$Remarks = format_input($_POST["Adjremarks"]);
	}
	//---------------------------TO SAVE RECORD---------------
	if(isset($_POST["Adjsubmit"])){
$sql = "INSERT INTO `adj_division` (`id`, `clis_cms_id`, `date`, `loco_no`,`train_no` ,`from1`, `to1`, `lps_name`, `remarks`) 
VALUES (NULL, '$cli_id', '$Date', '$Loco_no', '$Train_no' , '$From', '$To', '$LPs_Name', '$Remarks')";
$res = mysqli_query($conn,$sql);
          if($res){
              $response_msg = 1;
              //$table = 'adj_division';	              	           	
	              	//$location_recorded = writeLocationToDB($cli_id,$table,$dloc);
          }
          else{
              $response_msg = 0;            
          }

}
else if(isset($_POST["AdjsubmitUpdate"])){
			      	if(!empty($_POST["trans_id"])){
					$idu = format_input($_POST["trans_id"]);
						}
      	 $sql = "UPDATE `adj_division` SET `date` = '$Date', `loco_no` = '$Loco_no', `train_no` = 'Train_no' ,`from1` = '$From', `to1` = '$To', `lps_name` = '$LPs_Name', `remarks` = '$Remarks' WHERE `adj_division`.`id` = $idu AND `clis_cms_id`='$cli_id'";
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
      	$sql = "DELETE FROM `adj_division` WHERE `adj_division`.`id` = $idu AND `clis_cms_id`='$cli_id'";
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
<form name="Adj" method="post" action="">

	<table name = "Adjt1">
		<tr>		
			<td><input type="hidden"  class = "form-control" name="trans_id" <?php if($id_set==1){
				$temp_id = $_SESSION['idu'];
			echo "value='$temp_id'";}  ?>/></td>
		</tr>
		<tr>
			<th>Date:</th>
			<td><input type="date" class = "form-control" name="Adjdate" placeholder = "dd-mm-yyyy" <?php if($id_set==1) echo "value='$Date'"; ?>/></td>
		</tr>
		<tr>
			<th>Loco no: </th>
			<td><input type="number" class = "form-control" name="Adjlocono" placeholder = "Loco number" <?php if($id_set==1) echo "value='$Loco_no'"; ?>/></td>
		</tr>
		<tr>
			<th>Loco no: </th>
			<td><input type="text" class = "form-control" name="Adjtrainno" placeholder = "Train number" <?php if($id_set==1) echo "value='$Train_no'"; ?>/></td>
		</tr>
		<tr>
			<th>From: </th>
			<td><input type="text" class = "form-control" name="Adjfrom" placeholder = "Source" <?php if($id_set==1) echo "value='$From'"; ?>/></td>
		</tr>	
		<tr>
			<th>To: </th>
			<td><input type="text" class = "form-control" name="Adjto" placeholder = "Destination" <?php if($id_set==1) echo "value='$To'"; ?>/></td>
		</tr>		
		<tr>
			<th>LPs Name: </th>
			<td><input type="text" class = "form-control" name="AdjLPname" placeholder = "LPs name" <?php if($id_set==1) echo "value='$LPs_Name'"; ?>/></td>
		</tr>	
		<tr>
		    <th>Remarks:</th>
			<td rowspan="3"><textarea class = "form-control" name="Adjremarks" rows="3" cols="15" ><?php if($id_set==1) echo "$Remarks"; ?></textarea></td>
		</tr>			
	</table>
	<div class="spacing-for-button">
	<?php
		if($id_set==1){
	?>
	<input type="submit" name="AdjsubmitUpdate" value="Update" class="btn btn-success"></input>
	<input type="submit" name="DeleteRecord" value="Delete" class="btn btn-danger"></input>
	<?php
		unset($_SESSION['idu']);
		$id_set = 0;
	}else{
	?>
	<input type="submit" name="Adjsubmit" value="Save" class="btn btn-success"></input>
	<?php 
		}
		
	 ?>
	<input type="submit" name="modify" value="Display" class="btn btn-warning"></input>



	<?php
	if($modify_set==1){
	//----------------------------LIST OF RECORDS----------------------------
		echo "<hr><br>";
		$select_query = "SELECT * FROM `adj_division` WHERE `date` LIKE '%$Date%' AND `loco_no` LIKE '%$Loco_no%' AND `from1` LIKE '%$From%' AND `to1` LIKE '%$To%' AND `lps_name` LIKE '%$LPs_Name%' AND `remarks` LIKE '%$Remarks%' AND `clis_cms_id`='$cli_id' order by `id` desc limit 5";
		$query_result = mysqli_query($conn,$select_query);
		if(mysqli_num_rows($query_result)>0){
			echo '<div class="checks list-group">';
			while($row = mysqli_fetch_assoc($query_result)){
				$id1 = $row["id"];
				
				echo '<a class="list-group-item" href="god.php?fname=adj_div&idu='.$id1.'">'."<b>id:</b> " . $row["id"]. "&nbsp<b>date:</b>" . format_output($row["date"]). "&nbsp<b>loco_no:</b> " . format_output($row["loco_no"])."&nbsp<b>from:</b> " . format_output($row["from1"])."&nbsp<b>to:</b> " . format_output($row["to1"])."&nbsp<b>lps_name:</b> " . format_output($row["lps_name"]). "&nbsp<b>remarks:</b> ".format_output($row["remarks"])."</a>";
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