<?php
//------------------------------START OF SCRIPT -------
$LPs_Name=$Conseled_Date=$Remarks='';
//	TO UPDATE VALUE CHECK---------------------------------------
if(isset($_SESSION["idu"])){
		$id_set = 1;
		$idu = $_SESSION["idu"];
		$select_query1 = "SELECT * FROM `sec/sfc` WHERE `id` = $idu AND `clis_cms_id`='$cli_id'";
		$query_result1 = mysqli_query($conn, $select_query1);
		if(mysqli_num_rows($query_result1)>0){
			while($row = mysqli_fetch_assoc($query_result1)){
				$LPs_Name = format_output($row['lps_name']);
				$Conseled_Date = format_output($row['conseled_date']);
				$Remarks = format_output($row['remarks']);
			}	
		}
		
}
//---------------------------------END OF UPDATE check--------------------------------------
//-------------------------------SAVING CODE------------------------------------------------
if(isset($_POST["SECsubmit"]) || isset($_POST["SECsubmitUpdate"])||isset($_POST["DeleteRecord"])||isset($_POST["modify"])){
	if(!empty($_POST["SECLPname"])){
		$LPs_Name = format_input($_POST["SECLPname"]);
	}
	if(!empty($_POST["SECdate"])){
		$Conseled_Date = format_input($_POST["SECdate"]);
	}
	if(!empty($_POST["SECremarks"])){
		$Remarks = format_input($_POST["SECremarks"]);
	}
if(isset($_POST["SECsubmit"])){
$sql = "INSERT INTO `sec/sfc` (`id`, `lps_name`, `clis_cms_id`, `conseled_date`, `remarks`)
 VALUES (NULL, '$LPs_Name',  '$cli_id', '$Conseled_Date', '$Remarks')";

$res = mysqli_query($conn,$sql);
if($res){
              $response_msg = 1;
              //$table = 'sec/sfc';	              	           	
	              	//$location_recorded = writeLocationToDB($cli_id,$table,$dloc);
          }
          else{
              $response_msg = 0;            
          }
}
else if(isset($_POST["SECsubmitUpdate"])){
			      	if(!empty($_POST["trans_id"])){
					$idu = format_input($_POST["trans_id"]);
						}
      	 $sql = "UPDATE `sec/sfc` SET `lps_name` = '$LPs_Name', `conseled_date` = '$Conseled_Date', `remarks` = '$Remarks' WHERE `sec/sfc`.`id` = $idu AND `clis_cms_id`='$cli_id'";
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
else if(isset($_POST["DeleteRecord"])){
      	$idu = $_POST["trans_id"];
      	$sql = "DELETE FROM `sec/sfc` WHERE `sec/sfc`.`id` = $idu AND `clis_cms_id`='$cli_id'";
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
<form name="SEC" method="post" action="">

	<table name = "SECt1">
		<tr>
			
			<td><input type="hidden"  class = "form-control" name="trans_id" <?php if($id_set==1){
				$temp_id = $_SESSION['idu'];
			echo "value='$temp_id'";}  ?>/></td>
		</tr>
	    <tr>
			<th>LPs Name: </th>
			<td><input type="text" class = "form-control" name="SECLPname" placeholder = "LPs name" <?php if($id_set==1) echo "value='$LPs_Name'"; ?>/></td>
		</tr>	
		<tr>
			<th>Conseled Date:</th>
			<td><input type="date" class = "form-control" name="SECdate" placeholder = "dd-mm-yyyy" <?php if($id_set==1) echo "value='$Conseled_Date'"; ?>/></td>
		</tr>
		<tr>
		    <th>Remarks:</th>
			<td rowspan="3"><textarea class = "form-control" name="SECremarks" rows="3" cols="15" ><?php if($id_set==1) echo "$Remarks"; ?></textarea></td>
		</tr>			
	</table>
	<div class="spacing-for-button">
	<?php
		if($id_set==1){
	?>
	<input type="submit" name="SECsubmitUpdate" value="Update" class="btn btn-success"></input>
	<input type="submit" name="DeleteRecord" value="Delete" class="btn btn-danger"></input>
	<?php
		unset($_SESSION['idu']);
		$id_set = 0;
	}else{
	?>
	<input type="submit" name=
				"SECsubmit" value="Save" class="
				btn btn-success"></input>
	<?php 
		}
	 ?>
	<input type="submit" name="modify" value="Display" class="btn btn-warning"></input>
	
		<?php
		if($modify_set==1){
	//----------------------------LIST OF RECORDS----------------------------
		echo "<hr><br>";
		$select_query = "SELECT * FROM `sec/sfc` WHERE `lps_name` LIKE '%$LPs_Name%' AND `conseled_date` LIKE '%$Conseled_Date%' AND `remarks` LIKE '%$Remarks%' AND `clis_cms_id`='$cli_id' order by `id` desc limit 5";
		$query_result = mysqli_query($conn,$select_query);
		if(mysqli_num_rows($query_result)>0){
			echo '<div class="checks list-group">';
			while($row = mysqli_fetch_assoc($query_result)){
				$id1 = $row["id"];
				
				echo '<a class="list-group-item" href="god.php?fname=sec_sfc&idu='.$id1.'">'."<b>id:</b> " . $row["id"]. "&nbsp<b>lps_name:</b>" . format_output($row["lps_name"]). "&nbsp<b>conseled_date:</b> " . format_output($row["conseled_date"]). "&nbsp<b>remarks:</b> ".format_output($row["remarks"])."</a>";
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
