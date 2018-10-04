<?php
//------------------------------START OF SCRIPT -------
$Drive_topic=$Drive_Period1=$Drive_Period2=$LPM=$LPP=$LPG=$LPS=$ALP=$sddrivetype='';
$new=0;
//	TO UPDATE VALUE CHECK---------------------------------------
if(isset($_SESSION["idu"])){
		$id_set = 1;
		$idu = $_SESSION["idu"];
		$select_query1 = "SELECT * FROM `safety_drive` WHERE `id` = $idu AND `clis_cms_id` lIKE '$cli_id'";
		$query_result1 = mysqli_query($conn, $select_query1);
		if(mysqli_num_rows($query_result1)>0){
			while($row = mysqli_fetch_assoc($query_result1)){
				$fed_by = format_output($row['clis_cms_id']);
				$Drive_topic = format_output($row['drive_topic']);
				if(isset($Drive_topic)){
					$new=1;
				}
				$sddrivetype = format_output($row['drive_type']);
				$Drive_Period1 = format_output($row['fromp']);
				$Drive_Period2 = format_output($row['top']);
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
if(isset($_POST["sdsubmit"]) || isset($_POST["sdsubmitUpdate"])||isset($_POST["DeleteRecord"])||isset($_POST["modify"])){
	if(!empty($_POST["sdtopic"])){
		$Drive_topic = format_input($_POST["sdtopic"]);
	}
	if(!empty($_POST["sdperiod1"])){
		$Drive_Period1 = format_input($_POST["sdperiod1"]);
	}
	if(!empty($_POST["sdperiod2"])){
		$Drive_Period2 = format_input($_POST["sdperiod2"]);
	}
	if(!empty($_POST["sdLPM"])){
		$LPM = format_input($_POST["sdLPM"]);
	}
	if(!empty($_POST["sdLPP"])){
		$LPP = format_input($_POST["sdLPP"]);
	}
	if(!empty($_POST["sdLPG"])){
		$LPG = format_input($_POST["sdLPG"]);
	}
	if(!empty($_POST["sdLPS"])){
		$LPS = format_input($_POST["sdLPS"]);
	}
	if(!empty($_POST["sdALP"])){
		$ALP = format_input($_POST["sdALP"]);
	}
	if(!empty($_POST["sddrivetype"])){
		$sddrivetype = format_input($_POST["sddrivetype"]);
	}
if(isset($_POST["sdsubmit"])){
$sql = "INSERT INTO `safety_drive` (`id`, `drive_topic`,`drive_type` ,`fromp`, `top`, `lpm`, `lpp`, `lpg`, `lps`, `alp`, `clis_cms_id`) 
VALUES (NULL, '$Drive_topic','$sddrivetype' ,'$Drive_Period1', '$Drive_Period2', '$LPM', '$LPP', '$LPG', '$LPS', '$ALP', '$cli_id')";

$res = mysqli_query($conn,$sql);
if($res){
              $response_msg = 1;
          }
          else{
              $response_msg = 0;            
          }
}
else if(isset($_POST["sdsubmitUpdate"])){
			      	if(!empty($_POST["trans_id"])){
					$idu = format_input($_POST["trans_id"]);
						}
      	 $sql = "UPDATE `safety_drive` SET `drive_topic` = '$Drive_topic',`drive_type`='$sddrivetype', `fromp` = '$Drive_Period1', `top` = '$Drive_Period2', `lpm` = '$LPM', `lpp` = '$LPP', `lpg` = '$LPG', `lps` = '$LPS', `alp` = '$ALP' ,`clis_cms_id`='$cli_id' 
 WHERE `safety_drive`.`id` = $idu AND `clis_cms_id` LIKE '$cli_id'";
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
      	$sql = "DELETE FROM `safety_drive` WHERE `safety_drive`.`id` = $idu AND `clis_cms_id` LIKE '$cli_id'";
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
$topic_set=0;
if(isset($_POST['getTitle'])) {

      	$topic_set = 1;

      	$Drive_topic = $_POST['topic_title'];

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
<form name="sd" method="post" action="">

	<table name = "sdt1">
		<tr>		
			<td><input type="hidden"  class = "form-control" name="trans_id" <?php if($id_set==1){
				$temp_id = $_SESSION['idu'];
			echo "value='$temp_id'";}  ?>/></td>
		</tr>
        <tr>
			<th>Drive topic: </th>
			<td><input type="text" class = "form-control" name="sdtopic" placeholder = "Drive Topic" <?php if($topic_set==1||$new==1) echo "value='$Drive_topic'"; ?>/></td>
			<td> 
				<button type="button" class="btn btn-link btn-sm" name="pic_topic" data-target="#popup" data-toggle="modal">SELECT-TOPIC</button>
			  	<div class="modal" data-keyboard="false" data-backdrop="static" id="popup" tabindex="-1">
              	<div class="modal-dialog modal-lg">
              	<div class="modal-content">
              	<div class="modal-header">
                        <h4 class="modal-title" text-align="center">TOPIC</h4>
                        <button class="close" data-dismiss="modal">&times;</button>
              	</div>
	                <div class="modal-body">
	                <div id="popupg">
	                <div class="panel panel-default">
	                <div class="panel-body">
		                <table class="table table-bordered  table-hover table-resoponsive"text-align="center">
		                     <thead>
		                            <tr>
		                                  <th>TOPIC NAME</th>
		                                  <th>TIME FROM</th>
		                                  <th>TIME TO</th>
		                                  <th>OPTIONS</th>
		                             </tr>
		                      </thead>
		                      <tbody>

		                      	<?php

		                      		$fetch_topics_query = "SELECT * FROM `topics`";

		                      		$exec_fetch_topics = mysqli_query($conn, $fetch_topics_query);

		                      		$total_results = mysqli_num_rows($exec_fetch_topics);

		                      		if($total_results > 0) {

		                      			while($row = mysqli_fetch_assoc($exec_fetch_topics)) {

		                      					// new code

		                      					$current_date=date('Y-m-d');
		                      					$current_date=date('Y-m-d',strtotime($current_date));
		                      					$current_begin=date('Y-m-d',strtotime($row['topic_from']));
		                      					$current_end=date('Y-m-d',strtotime($row['topic_to']));
		                      					if(($current_date>=$current_begin)&&($current_date<=$current_end)){

		                      				?>

											<tr>
			                                    <td><?php echo $row['topic_title'];?></td>
			                                    <td><?php echo $row['topic_from'];?></td>
			                                    <td><?php echo $row['topic_to'];?></td>
			                                    <td><form method="POST" action=""><input type="hidden" name="topic_title" value="<?php echo $row['topic_title']; ?>"/><button type="submit" class="btn btn-info" name="getTitle" style="padding:5px;">GET TITLE</button></form></td>
		                              		</tr> 

		                      				<?php 
		                      					// newcode
		                      						}
		                      			}

		                      		}

		                      	 ?>
		                      </tbody>
		                </table>
                    </div>                
                    </div>
                    </div>
            	    </div>
	            </div>
	            </div>
	            </div>
	            
		</tr>
		<tr>
			<th>Drive Type: </th>
			<td>
				<select name="sddrivetype" class="form-control">
					<?php if($id_set==1){

						  	echo "<option value='$sddrivetype' selected>$sddrivetype</option>";
						  }else{
						  ?> 
						  <option disabled SELECTED value> -- DRIVE TYPE -- </option>
						  <?php
						  	}
						  ?>
						  <option value="CALENDER DRIVE">CALENDER DRIVE</option>
	                      <option value="SPECIAL DRIVE">SPECIAL DRIVE</option>
	                  </select>
			</td>
		</tr>
		<tr>
			<td><i>Drive Period:<i></td>
		</tr>	
		<tr>
			<th>FROM</th>
			<td><input type="DATE" class = "form-control" name="sdperiod1" <?php if($id_set==1) echo "value='$Drive_Period1'"; ?>/></td>
		</tr>
		<tr>
			<th>TO</th>
			<td><input type="DATE" class = "form-control" name="sdperiod2" <?php if($id_set==1) echo "value='$Drive_Period2'"; ?>/></td>
		</tr>
		</table>

		<h4><i>No. of staffs counselled</i></h4>

		<table name = "sdt2">

		<tr>
			<th>LPM: </th>
			<td><input type="number" class = "form-control toBCal" name="sdLPM" placeholder = "LPM" <?php if($id_set==1) echo "value='$LPM'"; ?>/></td>
		</tr>	
		<tr>
			<th>LPP: </th>
			<td><input type="number" class = "form-control toBCal" name="sdLPP" placeholder = "LPP" <?php if($id_set==1) echo "value='$LPP'"; ?>/></td>
		</tr>	
		<tr>
			<th>LPG: </th>
			<td><input type="number" class = "form-control toBCal" name="sdLPG" placeholder = "LPG" <?php if($id_set==1) echo "value='$LPG'"; ?>/></td>
		</tr>	
		<tr>
			<th>LPS: </th>
			<td><input type="number" class = "form-control toBCal" name="sdLPS" placeholder = "LPS" <?php if($id_set==1) echo "value='$LPS'"; ?>/></td>
		</tr>	
		<tr>
			<th>ALP: </th>
			<td><input type="number" class = "form-control toBCal" name="sdALP" placeholder = "ALP" <?php if($id_set==1) echo "value='$ALP'"; ?>/></td>
		</tr>	
		


	</table>
	<div><span id="sum">0</span></div>
	<div class="spacing-for-button">
	<input type="reset" name="sdreset" class="btn btn-primary" value="Clear" onclick="clear()"/>
	<?php
		if($id_set==1){
	?>
	<input type="submit" name="sdsubmitUpdate" value="Update" class="btn btn-success"></input>
	<input type="submit" name="DeleteRecord" value="Delete" class="btn btn-danger"></input>
	<?php
		unset($_SESSION['idu']);
		$id_set = 0;
	}else{
	?>
	<input type="submit" name="sdsubmit" value="Save" class="btn btn-success"></input>
	
	<?php 
		}
		
	 ?>
	<input type="submit" name="modify" value="Display" class="btn btn-warning"></input>
		
	<?php
	//----------------------------LIST OF RECORDS----------------------------
		if($modify_set==1){
		echo "<hr><br>";
		
		//FRAMING QEUERY
		 $select_query = "SELECT * FROM `safety_drive` WHERE `drive_topic` LIKE '%$Drive_topic%' AND `fromp` LIKE '%$Drive_Period1%' AND `top` LIKE '%$Drive_Period2%' AND 
		  `clis_cms_id` like '%$clicmsid%' AND 
		  `clis_cms_id` like '$cli_id'"; 
		  
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
		$select_query .=" order by `id` desc limit $lim";;
		//------------END OF QUERY----------------
		$query_result = mysqli_query($conn,$select_query);
		if(mysqli_num_rows($query_result)>0){
			echo '<div class="checks list-group">';
			while($row = mysqli_fetch_assoc($query_result)){
				$id1 = $row["id"];
				
$ctrl_name = '';
if(isset($_SESSION['loggeduserid_original'])){
				$ctrl_name = add_TLC_String(extract_controller_name(extract_controller_id($row['clis_cms_id'])));

				}
				echo '<a class="list-group-item" href="god.php?fname=safety_drive&idu='.$id1.'">'."<b>id:</b> " . $row["id"]. "&nbsp<b>drive_topic:</b>" . format_output($row["drive_topic"]). "&nbsp<b>drive_type:</b>" . format_output($row["drive_type"]). "&nbsp<b>from:</b> " . format_output($row["fromp"]). "&nbsp<b>to:</b> " . format_output($row["top"])."&nbsp<b>lpm:</b> " . format_output($row["lpm"])."&nbsp<b>lpp:</b> " . format_output($row["lpp"])."&nbsp<b>lpg:</b> " . format_output($row["lpg"]). "&nbsp<b>lps:</b> ".format_output($row["lps"])."&nbsp<b>alp:</b> " . format_output($row["alp"])."<span id ='controller_style'> $ctrl_name</span></a>";
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
 	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="BOOTSTRAP/js/bootstrap.min.js" ></script>
</div>
