<?php
//------------------------------START OF SCRIPT -------
$Date=$Loco_no=$LPs_Name=$Remarks='';
//	TO UPDATE VALUE CHECK---------------------------------------
if(isset($_SESSION["idu"])){
		$id_set = 1;
		$idu = $_SESSION["idu"];
		$select_query1 = "SELECT * FROM `spm_checking` WHERE `id` = $idu AND `clis_cms_id` like '$cli_id1'";
		$query_result1 = mysqli_query($conn, $select_query1);
		if(mysqli_num_rows($query_result1)>0){
			while($row = mysqli_fetch_assoc($query_result1)){
				$fed_by = format_output($row['clis_cms_id']);
				$Date = format_output($row['date']);
				$LPs_Name = format_output($row['lps_name']);
				$Remarks = format_output($row['remarks']);
				$Loco_no = format_output($row['loco_no']);
			}	
		}
		
}
//---------------------------------END OF UPDATE check--------------------------------------
if(isset($_POST["SPMsubmit"]) || isset($_POST["SPMsubmitUpdate"])||isset($_POST["DeleteRecord"])||isset($_POST["modify"])){
	if(!empty($_POST["SPMdate"])){
		$Date = format_input($_POST["SPMdate"]);
	}
	if(!empty($_POST["SPMlocono"])){
		$Loco_no = format_input($_POST["SPMlocono"]);
	}
	if(!empty($_POST["SPMLPname"])){
		$LPs_Name = format_input($_POST["SPMLPname"]);
	}
	if(!empty($_POST["SPMremarks"])){
		$Remarks = format_input($_POST["SPMremarks"]);
	}
	
//---------------------------TO SAVE RECORD---------------
	if(isset($_POST["SPMsubmit"])){
		$sql = "INSERT INTO `spm_checking` (`id`,`date`, `loco_no`, `lps_name`, `clis_cms_id`, `remarks`) 
		VALUES (NULL,'$Date' ,'$Loco_no', '$LPs_Name', '$cli_id', '$Remarks')";
		$res = mysqli_query($conn,$sql);
	          if($res){
	              $response_msg = 1;
	          }
	          else{
	              $response_msg = 0;            
	          }
      }//------------------------------------------------------
		//--------------------------TO UPDATE RECORD---------------
      else if(isset($_POST["SPMsubmitUpdate"])){
			      	if(!empty($_POST["trans_id"])){
					$idu = format_input($_POST["trans_id"]);
						}
      	 $sql = "UPDATE `spm_checking` SET
      	   `loco_no` = '$Loco_no', `date`='$Date' ,`lps_name` = '$LPs_Name', `remarks` = '$Remarks',`clis_cms_id`='$cli_id' WHERE `spm_checking`.`id` = $idu and `spm_checking`.`clis_cms_id`like'$cli_id1';";
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
        $sql = "DELETE FROM `spm_checking` WHERE `spm_checking`.`id` = $idu and `spm_checking`.`clis_cms_id` like '$cli_id1';";
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
<div class="panel-heading">
	<h4>SPM Checking</h4>
</div>
<div class="panel-body" style="align:centre">
<!-- ADDING NEW CODES-->
<?php
	if($id_set==1){
		echo "<div id='status_of_form'><p>Update/Delete Record Ref: ".$idu."</p></div>";
	}else{
		echo "<div id='status_of_form'><p>Add New Record</p></div>";
	}
	echo "<br>";
?>

<!-- END NEW CODES-->
<form name="SPM" method="post"  action="">
	<table name = "SPMt1">
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
			<td><input type="date" class = "form-control" name="SPMdate" placeholder = "dd-mm-yyyy" <?php if($id_set==1) echo "value='$Date'"; ?>/></td>
		</tr>
		<tr>
			<th>Loco no: </th>
			<td><input type="number" class = "form-control" name="SPMlocono" placeholder = "Loco number"<?php if($id_set==1) echo "value='$Loco_no'"; ?>/></td>
		</tr>	
		<tr>
			<th>LPs Name: </th>
			<td><input type="text" class = "form-control" name="SPMLPname" placeholder = "LPs name" <?php if($id_set==1) echo "value='$LPs_Name'"; ?>/></td>
		</tr>	
		<tr>
		    <th>Remarks:</th>
			<td rowspan="3"><textarea class = "form-control" name="SPMremarks" rows="3" cols="15" ><?php if($id_set==1) echo "$Remarks"; ?></textarea></td>
		</tr>			
	</table>
	<div class="spacing-for-button">
		<input type="reset" name="SPMreset" class="btn btn-primary" value="Clear"/>
		<?php
		if($id_set==1){
	?>
	<input type="submit" name="SPMsubmitUpdate" value="Update" class="btn btn-success"></input>
	<input type="submit" name="DeleteRecord" value="Delete" class="btn btn-danger"></input>
	<?php
		unset($_SESSION['idu']);
		$id_set = 0;
	}else{
	?>


		<input type="submit" name="SPMsubmit" value="Save" class="btn btn-success"/>
		<?php 
		}
		
	 ?>
	 <input type="submit" name="modify" value="Display" class="btn btn-warning"></input>
	<?php
	//----------------------------LIST OF RECORDS----------------------------
		if($modify_set==1){
		echo "<hr><br>";
		
		$select_query = "SELECT * FROM `spm_checking` WHERE `date` LIKE '%$Date%' AND `loco_no` LIKE '%$Loco_no%' AND
		 `lps_name` LIKE '%$LPs_Name%' AND
		  `remarks` LIKE '%$Remarks%' AND 
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
				echo '<a class="list-group-item" href="god.php?fname=spm&idu='.$id1.'">'."<b>id:</b> " . $row["id"]. "&nbsp<b>date:</b>" . format_output($row["date"]). "&nbsp<b>:loco_no</b> " . format_output($row["loco_no"])."&nbsp<b>:lps_name</b> " . format_output($row["lps_name"]). "&nbsp<b>remarks:</b> ".format_output($row["remarks"])."<span id ='controller_style'> $ctrl_name</span></a>";
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