<?php
$date=$locono=$trainno=$from=$to=$lpsname=$lpscmsid=$safetycat=$alpsname=$alpscmsid=$departure=$arrival=$mydeptime=$myarrtime="";
$bct=$bft=$bpt=11;
$lc=$snsn=$hg=$caution_aspect=$st1=$st2=$red=$alertness=$caution_order=$attacking=$up_technique=$brake=$spad=$vcd=$cts=$pts="";
$due_date_message = '';
$lp_cli_message = '';
//----------------------function to check the lp-cli association---------
function isLpRelatedToCli($lp_id=0, $clis_cms_id=0){
      global $conn;
      $clis_cms_id = explode("||", $clis_cms_id);
      $clis_cms_id = $clis_cms_id[0];
      $query1 = "SELECT * FROM `lp_details` WHERE `lp_id` like '$lp_id' and `clis_cms_id` like '$clis_cms_id'";
      $isRelated = mysqli_query($conn, $query1);
      if(mysqli_num_rows($isRelated)>0)return 1;
      
      else return 0;
}
//-----------------------end of lp-cli association-----------------------
//----------------------function to retrieve due date---------------------
function getDueDate($last_date='0000-00-00', $category='D'){
  $d = 0;
  $category = strtoupper($category);
  switch ($category) {
    case 'A':
      $d = 90;
      break;
    case 'B':
      $d = 60;
      break;
    case 'C':
      $d = 30;
      break;
    
    default:
      $d = 0;
      break;
  }
   $dueDate = date("Y-m-d",strtotime($last_date."+ $d days"));
   return $dueDate;

}
//--------------------------------------------------------------
//---------------function to update due date of lp-----
            function updateDueDate($lp_id, $last_date ,$gr, $clis_cms_id){
              $dueDate = getDueDate($last_date, $gr);
              global $conn;
              global $due_date_message;
              $clis_cms_id = explode("||", $clis_cms_id);
              $clis_cms_id = $clis_cms_id[0];
             $update_query = "UPDATE `lp_details` SET `grade` = '$gr', 
              `last_monitoring_date` = '$last_date', `due_for_monitoring` = '$dueDate' WHERE `lp_id` like '$lp_id' AND `clis_cms_id` LIKE '$clis_cms_id'";
              $update_success = mysqli_query($conn,$update_query);
              if($update_success){
              if(mysqli_affected_rows($conn)>0) $due_date_message = " | Due Date Updated.";
              else $due_date_message = " | Due Date Not Updated - Invalid LP-CLI Association.";
            }else $due_date_message = " | Due Date Not Updated";
              
              return; 


            }
//----------------------end of function----------    
//----TO UPDATE VALUE CHECK---------------------------------------
if(isset($_SESSION["idu"])){
    $id_set = 1;
    $idu = $_SESSION["idu"];
    $select_query1 = "SELECT * FROM `foot_plate_inspection`WHERE `id` = $idu AND `clis_cms_id`='$cli_id'";
    $query_result1 = mysqli_query($conn, $select_query1);
    if(mysqli_num_rows($query_result1)>0){
      while($row = mysqli_fetch_assoc($query_result1)){
          $date = format_output($row['date']);
          $locono = format_output($row['loco_no']);
          $trainno = format_output($row['train_no']);
          $from = format_output($row['from_station']);     
          $to = format_output($row['to_station']);
          $lpsname = format_output($row['lps_name']);
          $lpscmsid = format_output($row['lps_cms_id']);
          $safetycat = format_output($row['safey_cate']);
          $alpsname = format_output($row['alps_name']);
          $alpscmsid = format_output($row['alps_cms_id']);
         $departure = format_output($row['departure']);
          $arrival = format_output($row['arrival']);
          //to convert dates to proper format so as to display in the fields
          function change_to_date($str){
              $str1 = explode(" ",$str);
              $str = $str1[0]."T".$str1[1];
              return $str;
            }
            
            $departure = change_to_date($departure);
            $arrival = change_to_date($arrival);
        $bct = format_output($row['bct']);
        $bft = format_output($row['bft']);
        $bpt = format_output($row['bpt']);
        $lc = format_output($row['lc']);
        $snsn = format_output($row['snsn']);
        $hg = format_output($row['hg']);
        $caution_aspect = format_output($row['caution_aspect']);
        $st1 = format_output($row['st1']);
        $st2 = format_output($row['st2']);
        $red = format_output($row['red']);
        $alertness = format_output($row['alertness']);
        $caution_order = format_output($row['caution_order']);
        $attacking = format_output($row['attacking']);
        $up_technique = format_output($row['up_technique']);
        $brake=format_output($row['brake_technique']);
        $spad = format_output($row['spad']);
        $vcd=format_output($row['vcd']);
        $cts = format_output($row['cts']);
        $pts = format_output($row['pts']); 

      } 
    }

    
}
//echo "is set:".$id_set."<br>";
//---------------------------------END OF UPDATE check--------------------------------------
if(isset($_POST["SaveRecord"]) || isset($_POST['UpdateRecord'])||isset($_POST['modify']) || isset($_POST["DeleteRecord"])){
  //FOOTPLATE
  if(!empty($_POST["footplateinspectiondate"])){
     $date = format_input($_POST["footplateinspectiondate"]);
  }
    if(!empty($_POST["footplateinspectionlocono"])){
    $locono = format_input($_POST["footplateinspectionlocono"]);
  }
    if(!empty($_POST["footplateinspectiontrainno"])){
    $trainno = format_input($_POST["footplateinspectiontrainno"]);
  }
    if(!empty($_POST["footplateinspectionfrom"])){
    $from = format_input($_POST["footplateinspectionfrom"]);
  }
    if(!empty($_POST["footplateinspectionto"])){
    $to = format_input($_POST["footplateinspectionto"]);
  }
    if(!empty($_POST["footplateinspectionlpsname"])){
    $lpsname = format_input($_POST["footplateinspectionlpsname"]);
  }
    if(!empty($_POST["footplateinspectionlpscmsid"])){
    $lpscmsid = format_input($_POST["footplateinspectionlpscmsid"]);
  }
    if(!empty($_POST["footplateinspectionsafetycat"])){
    $safetycat = format_input($_POST["footplateinspectionsafetycat"]);
  }
    if(!empty($_POST["footplateinspectionalpsname"])){
    $alpsname = format_input($_POST["footplateinspectionalpsname"]);
  }
    if(!empty($_POST["footplateinspectionalpscmsid"])){
    $alpscmsid = format_input($_POST["footplateinspectionalpscmsid"]);
  }
    if(!empty($_POST["footplateinspectiondeparture"])){
    $departure = format_input($_POST["footplateinspectiondeparture"]);
    $mydeptime = ($departure);
  }
    if(!empty($_POST["footplateinspectiondarrival"])){
    $arrival = format_input($_POST["footplateinspectiondarrival"]);
    $myarrtime = ($arrival);

  }
  //OBSERVATION
  if(!empty($_POST['obs1'])){
      $bct=format_input($_POST['obs1']);
  }
  if(!empty($_POST['obs2'])){
      $bft=format_input($_POST['obs2']);
  }
  if(!empty($_POST['obs3'])){
      $bpt=format_input($_POST['obs3']);
  }
  if(!empty($_POST['obs4'])){
      $lc=format_input($_POST['obs4']);
  }
  if(!empty($_POST['obs5'])){
      $snsn=format_input($_POST['obs5']);
  }
  if(!empty($_POST['obs6'])){
      $hg=format_input($_POST['obs6']);
  }
  if(!empty($_POST['obs19'])){
      $caution_aspect=format_input($_POST['obs19']);
  }
  if(!empty($_POST['obs7'])){
      $st1=format_input($_POST['obs7']);
  }
  if(!empty($_POST['obs8'])){
      $st2=format_input($_POST['obs8']);
  }
  if(!empty($_POST['obs9'])){
      $red=format_input($_POST['obs9']);
  }
  if(!empty($_POST['obs10'])){
      $alertness=format_input($_POST['obs10']);
  }
  if(!empty($_POST['obs11'])){
      $caution_order=format_input($_POST['obs11']);
  }
  if(!empty($_POST['obs12'])){
      $attacking=format_input($_POST['obs12']);
  }
  if(!empty($_POST['obs13'])){
      $up_technique=format_input($_POST['obs13']);
  }
  if(!empty($_POST['obs14'])){
      $brake=format_input($_POST['obs14']);
  }
  if(!empty($_POST['obs15'])){
      $spad=format_input($_POST['obs15']);
  }
  if(!empty($_POST['obs16'])){
      $vcd=format_input($_POST['obs16']);
  }
  if(!empty($_POST['obs17'])){
      $cts=format_input($_POST['obs17']);
  }
  if(!empty($_POST['obs18'])){
      $pts=format_input($_POST['obs18']);
  }
  //-----------------------END OF DATA TAKINGS------
  //-------- TO SAVE RECORDS--------
    if(isset($_POST["SaveRecord"])){
      //footplate
      
      $sql1 = "INSERT INTO `foot_plate_inspection` (`id`,`date`,`loco_no`,`train_no`,`from_station`,`to_station`,`lps_name`,`lps_cms_id`,`safey_cate`,`alps_name`,`alps_cms_id`,`departure`,`arrival`,
        `bct`, `bft`, `bpt`, `lc`, `snsn`, `hg`, `caution_aspect`, `st1`, `st2`, `red`, `alertness`, `caution_order`, `attacking`, `up_technique`, `brake_technique`, `spad`, `vcd`, `cts`, `pts`,`clis_cms_id`) 
      VALUES (NULL, '$date', '$locono', '$trainno', '$from', '$to', '$lpsname','$lpscmsid','$safetycat','$alpsname','$alpscmsid','$mydeptime','$myarrtime',
        '$bct', '$bft', '$bpt', '$lc', '$snsn', '$hg', '$caution_aspect', '$st1', '$st2', '$red', '$alertness', '$caution_order', '$attacking', '$up_technique', '$brake', '$spad', '$vcd', '$cts', '$pts', '$cli_id')";

      $res1 = mysqli_query($conn,$sql1);
      
                if($res1){
                    $response_msg = 1;
                    $table = 'foot_plate_inspection'; 
                    updateDueDate($lpscmsid, $date ,$safetycat, $cli_id);                             
                  $location_recorded = writeLocationToDB($cli_id,$table,$dloc);
                }
                else{
                    $response_msg = 0;            
                }
              }
  //--------END OF SAVING-----------------
  
  //----------------  TO UPDATE THE RECORDS--------------
   else if(isset($_POST["UpdateRecord"])){
              if(!empty($_POST["trans_id"])){
          $idu = format_input($_POST["trans_id"]);
            }
        //footplate 
        
        $sql1 = "UPDATE `foot_plate_inspection` SET `date` = '$date', `loco_no` = '$locono', `train_no` = '$trainno', `from_station` = '$from', `to_station` = '$to', `lps_name` = '$lpsname', `lps_cms_id` = '$lpscmsid', `safey_cate` = '$safetycat', `alps_name` = '$alpsname', `alps_cms_id` = '$alpscmsid', `departure` = '$departure', `arrival` = '$arrival', `bct` = '$bct', `bft` = '$bft', `bpt` = '$bpt',
         `lc` = '$lc', `snsn` = '$snsn', `hg` = '$hg', `caution_aspect` = '$caution_aspect',
          `st1` = '$st1', `st2` = '$st2', `red` = '$red',`alertness` = '$alertness', `caution_order` = '$caution_order', 
        `attacking` = '$attacking', `up_technique` = '$up_technique', `brake_technique` = '$brake', 
        `spad` = '$spad', `vcd` = '$vcd', `cts` = '$cts', `pts` = '$pts' WHERE `foot_plate_inspection`.`id` = $idu AND `clis_cms_id`='$cli_id';";
        $res1 = mysqli_query($conn,$sql1);
        //observation
        
          if($res1){
              $response_msg = 2;
              updateDueDate($lpscmsid, $date ,$safetycat,$cli_id);
          }
          else{
              $response_msg = 0;            
          }
          //unset($_SESSION['idu']);
          $id_set = 0;
        }
      
  //-------------------END OF UPDATE-------------------------
      //---------------------DELETE-----------------------
       else if(isset($_POST["DeleteRecord"])){
       
        $idu = $_POST["trans_id"];
        $sql = "DELETE FROM `foot_plate_inspection` WHERE `foot_plate_inspection`.`id` = $idu AND `clis_cms_id`='$cli_id'";
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
<form name="footplateinspection" method="post" action="" class="form-horizontal">
<!-- include two forms  -->
<?php
  if($id_set==1){
    echo "<div id='status_of_form'><p>Update/Delete Record Ref: ".$idu."</p></div>";
  }else{
    echo "<div id='status_of_form'><p>Add New Record</p></div>";
  }
  echo "<br>";
?>


		<div class = "panel" id="footplate-panel">
      <?php
        //include footplate
      
      include("footplateinspection.php");

  //message
      $msg_from_script = "";
        if($response_msg==1){
          $msg_from_script = "Successfully Added";
        }else if($response_msg==2){
          $msg_from_script = "Successfully Updated";
        }else if($response_msg==3){
          $msg_from_script = "Successfully Deleted";
        }else if($response_msg==0){
          $msg_from_script = "Failed, Please try again";
        }else{
          $msg_from_script = "";
        }
      $msg_from_script .= $due_date_message; 
      $msg_from_script .= $lp_cli_message; 
    if($response_msg==1||$response_msg==0||$response_msg==2||$response_msg==3){

      
  ?>
  <div class=" container success-failed-reply" style="text-align:center;margin-left:20px;color:#fff;padding-bottom:5px;padding-top:5px;background-color: #0b1021;width:92%;"><span><?php echo $msg_from_script;?></span></div>
  <?php
    }
  ?>
      
      </div>
  
  	<div class = "panel" id="observation-panel">
      <?php
        //include observation
      include("observation.php");
      ?>
  </div>



</form>


<script type="text/javascript">
function hideshow() {
    var x = document.getElementById("observation-panel");
    var y = document.getElementById("mytoggle");
    if (x.style.display === "none") {
        x.style.display = "block";
        y.innerHTML="HIDE OBS";
    } else {
        x.style.display = "none";
        y.innerHTML="OBSERVATION"
    }
}
</script>