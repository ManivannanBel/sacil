<?php
//------------------------------START OF SCRIPT -------
$Seminar_topic=$Date=$Place=$LPM=$LPP=$LPG=$LPS=$ALP='';
//	TO UPDATE VALUE CHECK---------------------------------------
if(isset($_SESSION["idu"])){
		$id_set = 1;
		$idu = $_SESSION["idu"];
		$select_query1 = "SELECT * FROM `safety_seminar` WHERE `id` = $idu AND `clis_cms_id` LIKE '$cli_id1'";
		$query_result1 = mysqli_query($conn, $select_query1);
		if(mysqli_num_rows($query_result1)>0){
			while($row = mysqli_fetch_assoc($query_result1)){
				$fed_by = format_output($row['clis_cms_id']);
				$Seminar_topic = format_output($row['seminar_topic']);
				$Date = format_output($row['date']);
				$Place = format_output($row['place']);
				$LPM = format_output($row['lpm']);
				$LPP = format_output($row['lpp']);
				$LPG = format_output($row['lpg']);
				$LPS =format_output( $row['lps']);
				$ALP = format_output($row['alp']);
			}	
		}
		
}
//---------------------------------END OF UPDATE check--------------------------------------
//-------------------------------SAVING CODE-------------------------------------------
if(isset($_POST["sssubmit"]) || isset($_POST["sssubmitUpdate"])||isset($_POST["DeleteRecord"])||isset($_POST["modify"])){
	if(!empty($_POST["sstopic"])){
		$Seminar_topic = format_input($_POST["sstopic"]);
	}
	if(!empty($_POST["ssdate"])){
		$Date = format_input($_POST["ssdate"]);
	}
	if(!empty($_POST["ssPlace"])){
		$Place = format_input($_POST["ssPlace"]);
	}
	if(!empty($_POST["ssLPM"])){
		$LPM = format_input($_POST["ssLPM"]);
	}
	if(!empty($_POST["ssLPP"])){
		$LPP = format_input($_POST["ssLPP"]);
	}
	if(!empty($_POST["ssLPG"])){
		$LPG = format_input($_POST["ssLPG"]);
	}
	if(!empty($_POST["ssLPS"])){
		$LPS = format_input($_POST["ssLPS"]);
	}
	if(!empty($_POST["ssALP"])){
		$ALP = format_input($_POST["ssALP"]);
	}

if(isset($_POST["sssubmit"])){	
$sql = "INSERT INTO `safety_seminar` (`id`, `clis_cms_id`, `seminar_topic`, `date`, `place`, `lpm`, `lpp`, `lpg`, `lps`, `alp`) 
VALUES (NULL, '$cli_id', '$Seminar_topic', '$Date', '$Place', '$LPM', '$LPP', '$LPG', '$LPS', '$ALP')";

$res = mysqli_query($conn,$sql);
if($res){
              $response_msg = 1;
          }
          else{
              $response_msg = 0;            
          }
}
else if(isset($_POST["sssubmitUpdate"])){
			      	if(!empty($_POST["trans_id"])){
					$idu = format_input($_POST["trans_id"]);
						}
      	 $sql = "UPDATE `safety_seminar` SET `seminar_topic` = '$Seminar_topic', `date` = '$Date', `place` = '$Place', `lpm` = '$LPM', `lpp` = '$LPP', `lpg` = '$LPG', `lps` = '$LPS', `alp` = '$ALP' ,`clis_cms_id`='$cli_id' 
 WHERE `safety_seminar`.`id` = $idu AND `clis_cms_id` LIKE '$cli_id1'";
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
      	$sql = "DELETE FROM `safety_seminar` WHERE `safety_seminar`.`id` = $idu AND `clis_cms_id`LIKE '$cli_id1'";
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
	<h4>Safety Seminar</h4>
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
<form name="ss" method="post" action="">

	<table name = "sst1">
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
			<th>Seminar topic: </th>
			<td><input type="text" class = "form-control" name="sstopic" placeholder = "Seminar Topic" <?php if($id_set==1) echo "value='$Seminar_topic'"; ?>/></td>
		</tr>
		
		<tr>
			<th>Date:</th>
			<td><input type="date" class = "form-control" name="ssdate" placeholder = "dd-mm-yyyy" <?php if($id_set==1) echo "value='$Date'"; ?>/></td>
		</tr>
		<tr>
			<th>Place: </th>
			<td><input type="text" class = "form-control" name="ssPlace" placeholder = "Place" <?php if($id_set==1) echo "value='$Place'"; ?>/></td>
		</tr>	

		</table>

		<h4><i>No. of staffs counselled</i></h4>

		<table name = "sst2">

		<tr>
			<th>LPM: </th>
			<td><input type="number" class = "form-control toBCal" name="ssLPM" placeholder = "LPM" <?php if($id_set==1) echo "value='$LPM'"; ?>/></td>
		</tr>	
		<tr>
			<th>LPP: </th>
			<td><input type="number" class = "form-control toBCal" name="ssLPP" placeholder = "LPP" <?php if($id_set==1) echo "value='$LPP'"; ?>/></td>
		</tr>	
		<tr>
			<th>LPG: </th>
			<td><input type="number" class = "form-control toBCal" name="ssLPG" placeholder = "LPG" <?php if($id_set==1) echo "value='$LPG'"; ?>/></td>
		</tr>	
		<tr>
			<th>LPS: </th>
			<td><input type="number" class = "form-control toBCal" name="ssLPS" placeholder = "LPS" <?php if($id_set==1) echo "value='$LPS'"; ?>/></td>
		</tr>	
		<tr>
			<th>ALP: </th>
			<td><input type="number" class = "form-control toBCal" name="ssALP" placeholder = "ALP" <?php if($id_set==1) echo "value='$ALP'"; ?>/></td>
		</tr>	
		


	</table>
	<div><span id="sum">0</span></div>
	<div class="spacing-for-button">
	<input type="reset" name="ssreset" class="btn btn-primary" value="Clear"/>
	<?php
		if($id_set==1){
	?>
	<input type="submit" name="sssubmitUpdate" value="Update" class="btn btn-success"></input>
	<input type="submit" name="DeleteRecord" value="Delete" class="btn btn-danger"></input>
	<?php
		unset($_SESSION['idu']);
		$id_set = 0;
	}else{
	?>
	<input type="submit" name=
				"sssubmit" value="Save" class="
				btn btn-success"></input>
	<?php 
		}
		
	 ?>
	<input type="submit" name="modify" value="Display" class="btn btn-warning"></input>	
	
	<?php
	//----------------------------LIST OF RECORDS----------------------------
		if($modify_set==1){
		echo "<hr><br>";
		
		//FRAMING QEUERY
		$select_query = "SELECT * FROM `safety_seminar` WHERE `seminar_topic` LIKE '%$Seminar_topic%' AND `date` LIKE '%$Date%' AND `place` LIKE '%$Place%' AND 
		  `clis_cms_id` like '%$clicmsid%' AND 
		  `clis_cms_id` like '$cli_id1' ";
		  
		//ADDING FURTHER PARAMS
		if(!empty($LPM)){
			$select_query .= "AND `lpm`='$LPM'";
		}
		if(!empty($LPS)){
			$select_query .= "AND `lps`='$LPS'";
		}
		if(!empty($LPG)){
			$select_query .= "AND `lpg`='$LPG'";
		}
		if(!empty($LPP)){
			$select_query .= "AND `lpp`='$LPP'";
		}
		if(!empty($ALP)){
			$select_query .= "AND `alp`='$ALP'";
		}
		$select_query .=" order by `id` desc limit $lim";
		$query_result = mysqli_query($conn,$select_query);
		if(mysqli_num_rows($query_result)>0){
			echo '<div class="checks list-group">';
			while($row = mysqli_fetch_assoc($query_result)){
				$id1 = $row["id"];
				
			$ctrl_name = '';
			if(isset($_SESSION['loggeduserid_original'])){
				$ctrl_name = add_TLC_String(extract_controller_name(extract_controller_id($row['clis_cms_id'])));

				}
				echo '<a class="list-group-item" href="god.php?fname=safety_seminar&idu='.$id1.'">'."<b>id:</b> " . $row["id"]. "&nbsp<b>seminar_topic:</b>" . format_output($row["seminar_topic"]). "&nbsp<b>date:</b> " . format_output($row["date"])."&nbsp<b>place:</b> " . format_output($row["place"])."&nbsp<b>lpm:</b> " . format_output($row["lpm"])."&nbsp<b>lpp:</b> " . format_output($row["lpp"])."&nbsp<b>lpg:</b> " . format_output($row["lpg"]). "&nbsp<b>lps:</b> ".format_output($row["lps"])."&nbsp<b>alp:</b> " . format_output($row["alp"])."<span id ='controller_style'> $ctrl_name</span></a>";
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