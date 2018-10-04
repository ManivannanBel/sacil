<?php
//------------------------------START OF SCRIPT -------
$Date=$Loco_no=$LPs_Name=$Remarks='';
//	TO UPDATE VALUE CHECK---------------------------------------
if(isset($_SESSION["idu"])){
		$id_set = 1;
		$idu = $_SESSION["idu"];
		$select_query1 = "SELECT * FROM `vcd_analysis` WHERE `id` = $idu AND `clis_cms_id` like '$cli_id1'";
		$query_result1 = mysqli_query($conn, $select_query1);
		if(mysqli_num_rows($query_result1)>0){
			while($row = mysqli_fetch_assoc($query_result1)){
				$fed_by = format_output($row['clis_cms_id']);
				$Date = format_output($row['date']);
				$Loco_no = format_output($row['loco_no']);
				$LPs_Name = format_output($row['lps_name']);
				$Remarks = format_output($row['remarks']);
			}	
		}
		
}
//---------------------------------END OF UPDATE check--------------------------------------
//-------------------------------SAVING CODE------------------------------------------------
if(isset($_POST["VCDsubmit"]) || isset($_POST["VCDsubmitUpdate"]) ||isset($_POST["DeleteRecord"])||isset($_POST["modify"])){
	if(!empty($_POST["VCDdate"])){
		$Date = format_input($_POST["VCDdate"]);
	}
	if(!empty($_POST["VCDlocono"])){
		$Loco_no = format_input($_POST["VCDlocono"]);
	}
	if(!empty($_POST["VCDLPname"])){
		$LPs_Name = format_input($_POST["VCDLPname"]);
	}
	if(!empty($_POST["VCDremarks"])){
		$Remarks = format_input($_POST["VCDremarks"]);
	}

if(isset($_POST["VCDsubmit"])){
$sql = "INSERT INTO `vcd_analysis` (`id`, `date`, `loco_no`, `lps_name`, `clis_cms_id`, `remarks`) 
VALUES (NULL, '$Date', '$Loco_no', '$LPs_Name',  '$cli_id', '$Remarks')";

$res = mysqli_query($conn,$sql);
if($res){
              $response_msg = 1;
          }
          else{
              $response_msg = 0;            
          }
}
else if(isset($_POST["VCDsubmitUpdate"])){
			      	if(!empty($_POST["trans_id"])){
					$idu = format_input($_POST["trans_id"]);
						}
      	 $sql = "UPDATE `vcd_analysis` SET `date` = '$Date', `loco_no` = '$Loco_no', `lps_name` = '$LPs_Name', `remarks` = '$Remarks',`clis_cms_id`='$cli_id' WHERE `vcd_analysis`.`id` = $idu AND `clis_cms_id` like '$cli_id1'";
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
      //---------------------------DELETING DATA-----------------
      else if(isset($_POST["DeleteRecord"])){
      	$idu = $_POST["trans_id"];
      	$sql = "DELETE FROM `vcd_analysis` WHERE `vcd_analysis`.`id` = $idu AND `clis_cms_id` like '$cli_id1'";
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
	<h4>VCD Analysis</h4>
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
<form name="VCD" method="post" action="">

	<table name = "VCDt1">
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
			<td><input type="date" class = "form-control" name="VCDdate" placeholder = "dd-mm-yyyy" <?php if($id_set==1) echo "value='$Date'"; ?>/></td>
		</tr>
		<tr>
			<th>Loco no: </th>
			<td><input type="number" class = "form-control" name="VCDlocono" placeholder = "Loco number" <?php if($id_set==1) echo "value='$Loco_no'"; ?>/></td>
		</tr>	
		<tr>
			<th>LPs Name: </th>
			<td><input type="text" class = "form-control" name="VCDLPname" placeholder = "LPs name" <?php if($id_set==1) echo "value='$LPs_Name'"; ?>/></td>
		</tr>	
		<tr>
		    <th>Remarks:</th>
			<td rowspan="3"><textarea class = "form-control" name="VCDremarks" rows="3" cols="15" ><?php if($id_set==1) echo "$Remarks"; ?></textarea></td>
		</tr>			
	</table>
	<div class="spacing-for-button">
	<input type="reset" name="VCDreset" class="btn btn-primary" value="Clear"/>
	<?php
		if($id_set==1){
	?>
	<input type="submit" name="VCDsubmitUpdate" value="Update" class="btn btn-success"></input>
	<input type="submit" name="DeleteRecord" value="Delete" class="btn btn-danger"></input>
	<?php
		unset($_SESSION['idu']);
		$id_set = 0;
	}else{
	?>
	<input type="submit" name=
				"VCDsubmit" value="Save" class="
				btn btn-success"></input>

    <?php 
		}
	 ?>
	<input type="submit" name="modify" value="Display" class="btn btn-warning"></input>
	
    	<?php
    	if($modify_set==1){
	//----------------------------LIST OF RECORDS----------------------------
		echo "<hr><br>";
		$select_query = "SELECT * FROM `vcd_analysis` WHERE `date` LIKE '%$Date%' AND `loco_no` LIKE '%$Loco_no%' AND `lps_name` LIKE '%$LPs_Name%' AND `remarks` LIKE '%$Remarks%'
		AND  `clis_cms_id` like '%$clicmsid%' AND 
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
				echo '<a class="list-group-item" href="god.php?fname=vcd&idu='.$id1.'">'."<b>id:</b> " . $row["id"]. "&nbsp<b>date:</b>" . format_output($row["date"]). "&nbsp<b>loco_no:</b> " . format_output($row["loco_no"])."&nbsp<b>lps_name:</b> " . format_output($row["lps_name"]). "&nbsp<b>remarks:</b> ".format_output($row["remarks"])."<span id ='controller_style'> $ctrl_name</span></a>";
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
