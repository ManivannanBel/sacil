<?php

  //------------------function to extract cli cms id
    function extract_cliid($id){
      $main = explode("||",$id);
      return $main[0];
    }
  //-----------------------------------------------
    function extract_controller_id($s){
      $t = explode("||", $s);
      if(sizeof($t)<2) return "";
      return $t[1];
      
    }

    function extract_controller_name($s){
      if($s=='') return $s;
      global $conn;
      $sql = "SELECT controller_name FROM `controller_details` where controller_id = '$s'";
      $query_result = mysqli_query($conn,$sql);
      if(mysqli_num_rows($query_result)>0){
        $row = mysqli_fetch_assoc($query_result);
        return $row['controller_name'];

      }
      return '';
    }
    function add_TLC_String($s){
      if($s=='') return $s;
      return "<i>TLC:</i>".$s;
    }

  //------------------------------------------------
  $cli_id = "";
  $cli_id1 = "";
  $clicmsid = "";
  $lim = 10;
  $controller_id = 'ctrl1';
    if(isset($_SESSION['loggeduserid_original'])){
      $cli_id = $_SESSION['loggeduserid_original'];
      $cli_id1 = $cli_id."%";
      if(isset($_SESSION['logged_controller_id'])) unset($_SESSION['logged_controller_id']);
  }



  if(isset($_SESSION['logged_controller_id'])){
    if(isset($_SESSION['loggeduserid_original'])) unset($_SESSION['loggeduserid_original']);
      $controller_id = $_SESSION['logged_controller_id'];
      if(isset($_POST["clicmsid"])){
            if(!empty($_POST["clicmsid"])){
              $cli_id = $_POST["clicmsid"];
              $clicmsid = $cli_id;
            }
          }
      $cli_id = $cli_id."||".$controller_id;
      $cli_id1 = "%||".$controller_id;
      $lim = 25;
  }

?>