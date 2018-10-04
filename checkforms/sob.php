<?php
//------------------------------START OF SCRIPT -------
$subject=$topic = $no=$LPM=$LPP=$LPG=$LPS=$ALP=$date='';
//	TO UPDATE VALUE CHECK---------------------------------------
if(isset($_SESSION["idu"])){
		$id_set = 1;
		$idu = $_SESSION["idu"];
		$select_query1 = "SELECT * FROM `sob` WHERE `id` = $idu AND `clis_cms_id` LIKE '$cli_id1'";
		$query_result1 = mysqli_query($conn, $select_query1);
		if(mysqli_num_rows($query_result1)>0){
			while($row = mysqli_fetch_assoc($query_result1)){
				$fed_by = format_output($row['clis_cms_id']);
				$no = format_output($row['sob_no']);
				$subject = format_output($row['sob_subject']);
				$topic =format_output( $row['sob_topic']);
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
		$no = $_POST["TCStopic"];
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
          }
          else{
              $response_msg = 0;            
          }
}
else if(isset($_POST["sobsubmitUpdate"])){
			      	if(!empty($_POST["trans_id"])){
					$idu = format_input($_POST["trans_id"]);
						}
      	 $sql = "UPDATE `sob` SET `sob_no` = '$no',`date` = '$date', `sob_subject` = '$subject', `sob_topic` = '$topic' ,`lpm` = '$LPM', `lpp` = '$LPP', `lpg` = '$LPG', `lps` = '$LPS', `alp` = '$ALP' ,`clis_cms_id`='$cli_id' 
 WHERE `sob`.`id` = $idu AND `clis_cms_id`LIKE '$cli_id1'";
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
       	$sql = "DELETE FROM `sob` WHERE `sob`.`id` = $idu AND `clis_cms_id` LIKE '$cli_id1'";
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

if(isset($_POST['getData'])) {

      	$topic_set = 1;

      	$topicID = $_POST['topicID'];

      	$fetch_topics_query = "SELECT * FROM sobtopics WHERE `ID` = '$topicID'";

		$exec_fetch_topics = mysqli_query($conn, $fetch_topics_query);

		$data = mysqli_fetch_assoc($exec_fetch_topics);

		$Drive_number = $topicNumber = $data['topic_number'];

		$topicFrom = $data['topic_from'];

		$Drive_topic = $topicTitle = $data['topic_title'];

		$topicDesc = $data['topic_desc'];

      }       
//-------------------------------END OF SCRIPT--------------------------
?>
<div class="panel-heading">
	<h4>Standing Order Book</h4>
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
<form name="TCS" method="post" action="">

	<table name = "TCSt1">
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
			<th>SOB Number: </th>
			<td><input type="text" class = "form-control" name="TCStopic" placeholder = "sob number" <?php if(isset($topic_set) && $topic_set==1) echo "value='$topicNumber'"; ?>/></td>
			<td> 
				<button type="button" class="btn btn-link btn-sm" name="pic_topic" data-target="#popup" data-toggle="modal" style="padding-top:0px;">SELECT SOB TOPIC</button>
			  	<div class="modal" data-keyboard="false" data-backdrop="static" id="popup" tabindex="-1" style="margin-top:5px;">
              	<div class="modal-dialog modal-lg">
              	<div class="modal-content">
              	<div class="modal-header text-center">
                        <h4 class="modal-title text-primary">STANDING ORDER BOOK DETAILS</h4>
                        <button class="btn btn-xl close" data-dismiss="modal" padding-bottom>&times;</button>
              	</div>
	                <div class="modal-body">
	                <div id="popupg">
	                <div class="panel panel-default">
	                <div class="panel-body">
		                <table class="table table-primary table-bordered  table-hover table-resoponsive"text-align="center">
		                     <thead class="text-warning">
		                            <tr class="table-primary">
		                                  <th width="130px auto;">SOB NUMBER</th>
		                                  <th width="100px auto;">SOB DATE</th>
		                                  <th width="100px auto;">SOB SUBJECT</th>
		                                  <th width="200px auto;">SOB TOPIC</th>
		                                  <th width="100px auto;">OPTIONS</th>
		                             </tr>
		                      </thead>
		                      <tbody>

		                      	<?php

		                      		$fetch_topics_query = "SELECT * FROM sobtopics";

		                      		$exec_fetch_topics = mysqli_query($conn, $fetch_topics_query);

		                      		$total_results = mysqli_num_rows($exec_fetch_topics);

		                      		if($total_results > 0) {

		                      			while($row = mysqli_fetch_assoc($exec_fetch_topics)) {

		                      				?>

											<tr>
			                                    <td><?php echo $row['topic_number'];?></td>
			                                    <td><?php echo date('d-m-Y', strtotime($row['topic_from']));?></td>
			                                    <td><?php echo $row['topic_title'];?></td>
			                                    <td><?php echo $row['topic_desc'];?></td>
			                                    <td><form method="POST" action=""><input type="hidden" name="topicID" value="<?php echo $row['ID']; ?>"/><button type="submit" class="btn btn-info" name="getData" style="padding:5px;">GET DATA</button></form></td>
		                              		</tr> 

		                      				<?php 
		                      					// newcode
		                      						
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

		<!-- -->
      	<tr>
			<th>SOB Date:</th>
			<td><input type="date" class = "form-control" name="TCSdate" placeholder = "DD/MM/YYYY" <?php if(isset($topic_set) && $topic_set==1) echo "value='$topicFrom'"; ?>/></td>
		</tr>
		<tr>
			<th>SOB Subject:</th>
			<td><input type="text" class = "form-control" name="TCSsubject" placeholder = "sob Subject" <?php if(isset($topic_set) && $topic_set==1) echo "value='$topicTitle'"; ?>/></td>
		</tr>

		<tr>
		    <th>Topic:</th>
			<td rowspan="3"><textarea class = "form-control" name="SOBtopic" rows="3" cols="15" ><?php if(isset($topic_set) && $topic_set==1) echo $topicDesc; ?></textarea></td>
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
	<input type="reset" name="sobreset" class="btn btn-primary" value="Clear"/>
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
		$select_query = "SELECT * FROM `sob` WHERE `sob_no` LIKE '%$no%' AND `date` LIKE '%$date%' AND `sob_subject` LIKE '%$subject%' AND 
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

				echo '<a class="list-group-item" href="god.php?fname=sob&idu='.$id1.'">'."<b>id:</b> " . $row["id"]. "&nbsp<b>sob_no:</b>" . format_output($row["sob_no"]). "&nbsp<b>date:</b>" . format_output($row["date"]). "&nbsp<b>sob_subject:</b> " . format_output($row["sob_subject"])."&nbsp<b>lpm:</b> " . format_output($row["lpm"])."&nbsp<b>lpp:</b> " . format_output($row["lpp"])."&nbsp<b>lpg:</b> " . format_output($row["lpg"]). "&nbsp<b>lps:</b> ".format_output($row["lps"])."&nbsp<b>alp:</b> " . format_output($row["alp"])."<span id ='controller_style'> $ctrl_name</span></a>";
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
