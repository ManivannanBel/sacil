<?php
//------------------------------START OF SCRIPT -------
$subject=$topic = $no=$LPM=$LPP=$LPG=$LPS=$ALP=$date='';
//	TO UPDATE VALUE CHECK---------------------------------------
if(isset($_SESSION["idu"])){
		$id_set = 1;
		$idu = $_SESSION["idu"];
		$select_query1 = "SELECT * FROM `sob` WHERE `id` = $idu AND `clis_cms_id`='$cli_id'";
		$query_result1 = mysqli_query($conn, $select_query1);
		if(mysqli_num_rows($query_result1)>0){
			while($row = mysqli_fetch_assoc($query_result1)){
				$no = format_output($row['sob_no']);
				$subject = format_output($row['sob_subject']);
				$topic = format_output($row['sob_topic']);
				$date = format_output($row['date']);
				$LPM = format_output($row['lpm']);
				$LPP = format_output($row['lpp']);
				$LPG = format_output($row['lpg']);
				$LPS = format_output($row['lps']);
				$ALP = format_output($row['alp']);
			}	
		}
		
}
//---------------------------------END OF UPDATE check--------------------------------------
//-------------------------------SAVING CODE-------------------------------------------
if(isset($_POST["sobsubmit"]) || isset($_POST["sobsubmitUpdate"])||isset($_POST["DeleteRecord"])||isset($_POST["modify"])){
	if(!empty($_POST["TCStopic"])){
		$no = format_input($_POST["TCStopic"]);
	}
	if(!empty($_POST["TCSdate"])){
		$date = format_input($_POST["TCSdate"]);
	}
	if(!empty($_POST["TCSsubject"])){
		$subject = format_input($_POST["TCSsubject"]);
	}
	if(!empty($_POST["SOBtopic"])){
		$topic = format_input($_POST["SOBtopic"]);
	}
	if(!empty($_POST["tcsLPM"])){
		$LPM = format_input($_POST["tcsLPM"]);
	}
	if(!empty($_POST["tcsLPP"])){
		$LPP = format_input($_POST["tcsLPP"]);
	}
	if(!empty($_POST["tcsLPG"])){
		$LPG = format_input($_POST["tcsLPG"]);
	}
	if(!empty($_POST["tcsLPS"])){
		$LPS = format_input($_POST["tcsLPS"]);
	}
	if(!empty($_POST["tcsALP"])){
		$ALP = format_input($_POST["tcsALP"]);
	}

if(isset($_POST["sobsubmit"])){
$sql = "INSERT INTO `sob` (`id`, `sob_no`,`date` ,`sob_subject`,`sob_topic` ,`lpm`, `lpp`, `lpg`, `lps`, `alp`, `clis_cms_id`) 
VALUES (NULL, '$no','$date' ,'$subject','$topic', '$LPM', '$LPP', '$LPG', '$LPS', '$ALP', '$cli_id')";

$res = mysqli_query($conn,$sql);
if($res){
              $response_msg = 1;
             // $table = 'sob';	              	           	
	              	//$location_recorded = writeLocationToDB($cli_id,$table,$dloc);
          }
          else{
              $response_msg = 0;            
          }
}
else if(isset($_POST["sobsubmitUpdate"])){
			      	if(!empty($_POST["trans_id"])){
					$idu = format_input($_POST["trans_id"]);
						}
      	 $sql = "UPDATE `sob` SET `sob_no` = '$no',`date` = '$date', `sob_subject` = '$subject', `sob_topic` = '$topic' ,`lpm` = '$LPM', `lpp` = '$LPP', `lpg` = '$LPG', `lps` = '$LPS', `alp` = '$ALP' WHERE `sob`.`id` = $idu AND `clis_cms_id`='$cli_id'";
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
       	$sql = "DELETE FROM `sob` WHERE `sob`.`id` = $idu AND `clis_cms_id`='$cli_id'";
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
<form name="TCS" method="post" action="">

	<table name = "TCSt1">
		<tr>		
			<td><input type="hidden"  class = "form-control" name="trans_id" <?php if($id_set==1){
				$temp_id = $_SESSION['idu'];
			echo "value='$temp_id'";}  ?>/></td>
		</tr>
        <tr>
			<th>SOB Number: </th>
			<td><input type="text" class = "form-control" name="TCStopic" placeholder = "sob number" <?php if($id_set==1) echo "value='$no'"; ?>/></td>
		</tr>
		<tr>
			<th>SOB Date:</th>
			<td><input type="date" class = "form-control" name="TCSdate" placeholder = "DD/MM/YYYY" <?php if($id_set==1) echo "value='$date'"; ?>/></td>
		</tr>
		<tr>
			<th>SOB Subject:</th>
			<td><input type="text" class = "form-control" name="TCSsubject" placeholder = "sob Subject" <?php if($id_set==1) echo "value='$subject'"; ?>/></td>
		</tr>

		<tr>
		    <th>Topic:</th>
			<td rowspan="3"><textarea class = "form-control" name="SOBtopic" rows="3" cols="15" ><?php if($id_set==1) echo "$topic"; ?></textarea></td>
		</tr>	
		</table>

		<h4><i>No. of staffs counselled</i></h4>

		<table name = "TCSt2">

		<tr>
			<th>LPM: </th>
			<td><input type="number" class = "form-control toBCal" name="tcsLPM" placeholder = "LPM" <?php if($id_set==1) echo "value='$LPM'"; ?>/></td>
		</tr>	
		<tr>
			<th>LPP: </th>
			<td><input type="number" class = "form-control toBCal" name="tcsLPP" placeholder = "LPP" <?php if($id_set==1) echo "value='$LPP'"; ?>/></td>
		</tr>	
		<tr>
			<th>LPG: </th>
			<td><input type="number" class = "form-control toBCal" name="tcsLPG" placeholder = "LPG" <?php if($id_set==1) echo "value='$LPG'"; ?>/></td>
		</tr>	
		<tr>
			<th>LPS: </th>
			<td><input type="number" class = "form-control toBCal" name="tcsLPS" placeholder = "LPS" <?php if($id_set==1) echo "value='$LPS'"; ?>/></td>
		</tr>	
		<tr>
			<th>ALP: </th>
			<td><input type="number" class = "form-control toBCal" name="tcsALP" placeholder = "ALP" <?php if($id_set==1) echo "value='$ALP'"; ?>/></td>
		</tr>	
		


	</table>
	<div><span id="sum">0</span></div>
	<div class="spacing-for-button">
	<?php
		if($id_set==1){
	?>
	<input type="submit" name="sobsubmitUpdate" value="Update" class="btn btn-success"></input>
	<input type="submit" name="DeleteRecord" value="Delete" class="btn btn-danger"></input>
	<?php
		unset($_SESSION['idu']);
		$id_set = 0;
	}else{
	?>
	<input type="submit" name=
				"sobsubmit" value="Save" class="
				btn btn-success"></input>
	<?php 
		}
		
	 ?>
	<input type="submit" name="modify" value="Display" class="btn btn-warning"></input>	
	<?php
	if($modify_set==1){
	//----------------------------LIST OF RECORDS----------------------------
		echo "<hr><br>";
		//FRAMING QEUERY
		$select_query = "SELECT * FROM `sob` WHERE `sob_no` LIKE '%$no%' AND `date` LIKE '%$date%' AND `sob_subject` LIKE '%$subject%' AND `clis_cms_id`='$cli_id'";
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
		$select_query .=" order by `id` DESC limit 5";
		$query_result = mysqli_query($conn,$select_query);
		if(mysqli_num_rows($query_result)>0){
			echo '<div class="checks list-group">';
			while($row = mysqli_fetch_assoc($query_result)){
				$id1 = $row["id"];
				
				echo '<a class="list-group-item" href="god.php?fname=sob&idu='.$id1.'">'."<b>id:</b> " . $row["id"]. "&nbsp<b>sob_no:</b>" . format_output($row["sob_no"]). "&nbsp<b>date:</b>" . format_output($row["date"]). "&nbsp<b>sob_subject:</b> " . format_output($row["sob_subject"])."&nbsp<b>lpm:</b> " . format_output($row["lpm"])."&nbsp<b>lpp:</b> " . format_output($row["lpp"])."&nbsp<b>lpg:</b> " . format_output($row["lpg"]). "&nbsp<b>lps:</b> ".format_output($row["lps"])."&nbsp<b>alp:</b> " . format_output($row["alp"])."</a>";
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
