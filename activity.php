
<style>
* {box-sizing: border-box}
body {font-family: "Lato", sans-serif;}

/* Style the tab */
.tab {
    float: left;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
    width: 30%;
    height: 300px;
}

/* Style the buttons inside the tab */
.tab button {
    display: block;
    background-color: inherit;
    color: black;
    padding: 22px 16px;
    width: 100%;
    border: none;
    outline: none;
    text-align: left;
    cursor: pointer;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    float: left;
    padding: 0px 12px;
    border: 1px solid #ccc;
    width: 70%;
    border-left: none;
   
}

.serif {
    font-family: "Times New Roman", Times, serif;
    font-size: 20;
}
</style>


<?php

    $res_cb=mysqli_query($conn,"select * from cb where clis_cms_id='".$_SESSION['loggeduserid_original']."' order by date desc");
    $res_jss=mysqli_query($conn,"select * from jss where clis_cms_id='".$_SESSION['loggeduserid_original']."' order by date desc");
    $res_rr=mysqli_query($conn,"select * from rr where clis_cms_id='".$_SESSION['loggeduserid_original']."' order by date desc");
    $res_ss=mysqli_query($conn,"select * from sec/sfc where clis_cms_id='".$_SESSION['loggeduserid_original']."' order by conseled_date desc");
    $res_mpc=mysqli_query($conn,"select * from mobile_phone_check where clis_cms_id='".$_SESSION['loggeduserid_original']."' order by date desc");
    $res_abs=mysqli_query($conn,"select * from amb_by_speed_gun where clis_cms_id='".$_SESSION['loggeduserid_original']."' order by date desc");
    $res_vcd=mysqli_query($conn,"select * from vcd_analysis where clis_cms_id='".$_SESSION['loggeduserid_original']."' order by date desc");
    $res_sc=mysqli_query($conn,"select * from spm_checking where clis_cms_id='".$_SESSION['loggeduserid_original']."' order by date desc");
    
    $date_array = array();
    if($res_cb){
      while ($row=mysqli_fetch_assoc($res_cb)) {
          $date_array[] = $row['date'];        
      }
    }
    if($res_jss){
      while ($row=mysqli_fetch_assoc($res_jss)) {
          $date_array[] = $row['date'];        
      }
    }
    if($res_rr){
      while ($row=mysqli_fetch_assoc($res_rr)) {
          $date_array[] = $row['date'];        
      }
    }
    if($res_ss){
      while ($row=mysqli_fetch_assoc($res_ss)) {
          $date_array[] = $row['date'];        
      }
    }
    if($res_mpc){
      while ($row=mysqli_fetch_assoc($res_mpc)) {
          $date_array[] = $row['date'];        
      }
    }
    if($res_abs){
      while ($row=mysqli_fetch_assoc($res_abs)) {
          $date_array[] = $row['date'];        
      }
    }
    if($res_vcd){
      while ($row=mysqli_fetch_assoc($res_vcd)) {
          $date_array[] = $row['date'];        
      }
    }
    if($res_sc){
      while ($row=mysqli_fetch_assoc($res_sc)) {
          $date_array[] = $row['date'];        
      }
    }

    function date_sort($a, $b) {
    return strtotime($a) - strtotime($b);
    }
    usort($date_array, "date_sort");
 //   print_r($date_array);
    $older_date = $date_array[0];
    $newer_date = $date_array[sizeof($date_array)-1];
    
  for ($date = $newer_date; (strtotime($date))>=(strtotime($older_date)); $date=date('Y-m-d',strtotime("-1 day", strtotime($date)))){
    $res_cb=mysqli_query($conn,"select * from cb where clis_cms_id='".$_SESSION['loggeduserid_original']."' AND date='".$date."';");
    if($res_cb){
      while ($row=mysqli_fetch_assoc($res_cb)) {
      ?>
        <li class="list-group-item">
          <div class="col-sm serif">
           <?php
            echo "<B>Crew Booking:</B>";
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Clis cms id: </B>".$row['clis_cms_id'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Place: </B>".$row['place'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>no of saftey sem: </B>".$row['no_of_safety_sem'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Lssn: </B>".$row['lssn'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Lssd: </B>".$row['lssd'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>On duty crc: </B>".$row['on_duty_crc'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Date: </B>".$row['date'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Remarks: </B>".$row['remarks'];
           ?> 
          </div>
        </li>    
      <?php        
      }
    }

    $res_jss=mysqli_query($conn,"select * from jss where clis_cms_id='".$_SESSION['loggeduserid_original']."' AND date='".$date."';");
    if($res_jss){
      while ($row=mysqli_fetch_assoc($res_jss)) {
       ?>
        <li class="list-group-item">
          <div class="col-sm  serif">
           <?php
            echo "<B>Joint Signal Sigthing:</B>";
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Clis cms id: </B>".$row['clis_cms_id'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Section: </B>".$row['section'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Train no: </B>".$row['train_no'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Loco no: </B>".$row['loco_no'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Timing: </B>".$row['timing'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Date: </B>".$row['date'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Remarks: </B>".$row['remarks'];
           ?> 
          </div>
        </li>    
      <?php      
      }
    }
    $res_rr=mysqli_query($conn,"select * from rr where clis_cms_id='".$_SESSION['loggeduserid_original']."' AND date='".$date."';");
    if($res_rr){
      while ($row=mysqli_fetch_assoc($res_rr)) {
          ?>
        <li class="list-group-item">
          <div class="col-sm  serif">
           <?php
            echo "<B>Running Room:</B>";
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Clis cms id: </B>".$row['clis_cms_id'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Place: </B>".$row['place'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Date: </B>".$row['date'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Remarks: </B>".$row['remarks'];
           ?> 
          </div>
        </li>    
      <?php 
      }
    }

    $res_ss=mysqli_query($conn,"select * from sec/sfc where clis_cms_id='".$_SESSION['loggeduserid_original']."' AND conseled_date='".$date."';");
    if($res_ss){
      while ($row=mysqli_fetch_assoc($res_ss)) {
           ?>
        <li class="list-group-item">
          <div class="col-sm serif">
           <?php
            echo "<B>SEC/SFC Counselling:</B>";
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>clis cms id: </B>".$row['clis_cms_id'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Lps name: </B>".$row['lps_name'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Conseled date: </B>".$row['conseled_date'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Remarks: </B>".$row['remarks'];
           ?> 
          </div>
        </li>    
      <?php 
      }
    }
    
    $res_mpc=mysqli_query($conn,"select * from mobile_phone_check where clis_cms_id='".$_SESSION['loggeduserid_original']."' AND date='".$date."';");
    if($res_mpc){
      while ($row=mysqli_fetch_assoc($res_mpc)) {
          ?>
        <li class="list-group-item">
          <div class="col-sm serif">
           <?php
            echo "<B>Mobile Phone Check:</B>";
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Clis cms id: </B>".$row['clis_cms_id'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Train no: </B>".$row['train_no'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Crew name: </B>".$row['crew_name'];
           ?> 
          </div>
          <div class="col-sm">
          <?php
            echo "<B>Phone no: </B>".$row['phone_no'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Design: </B>".$row['design'];
           ?> 
          </div>
          <div class="col-sm">
          <?php
            echo "<B>Date: </B>".$row['date'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Remarks: </B>".$row['remarks'];
           ?> 
          </div>
        </li>    
      <?php
      }
    }

    $res_abs=mysqli_query($conn,"select * from amb_by_speed_gun where clis_cms_id='".$_SESSION['loggeduserid_original']."' AND date='".$date."';");
    if($res_abs){
      while ($row=mysqli_fetch_assoc($res_abs)) {
             ?>
        <li class="list-group-item">
          <div class="col-sm serif">
           <?php
            echo "<B>Speed Gun Check:</B>";
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Clis cms id: </B>".$row['clis_cms_id'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Train no: </B>".$row['train_no'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>no of trains: </B>".$row['no_of_trains'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Place: </B>".$row['place'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Date: </B>".$row['date'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Remarks: </B>".$row['remarks'];
           ?> 
          </div>
        </li>    
      <?php       
      }
    }

     $res_vcd=mysqli_query($conn,"select * from vcd_analysis where clis_cms_id='".$_SESSION['loggeduserid_original']."' AND date='".$date."';");
    if($res_vcd){
      while ($row=mysqli_fetch_assoc($res_vcd)) {
       ?>
        <li class="list-group-item">
          <div class="col-sm serif">
           <?php
            echo "<B>Vigilance control device:</B>";
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Clis cms id: </B>".$row['clis_cms_id'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Lps name: </B>".$row['lps_name'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Loco no: </B>".$row['loco_no'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Date: </B>".$row['date'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Remarks: </B>".$row['remarks'];
           ?> 
          </div>
        </li>    
      <?php                  
      }
    }

    $res_sc=mysqli_query($conn,"select * from spm_checking where clis_cms_id='".$_SESSION['loggeduserid_original']."' AND date='".$date."';");
    if($res_sc){
      while ($row=mysqli_fetch_assoc($res_sc)) {
       ?>
        <li class="list-group-item">
          <div class="col-sm serif">
           <?php
            echo "<B>Speedometer Analysis:</B>";
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Clis cms id: </B>".$row['clis_cms_id'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Lps name: </B>".$row['lps_name'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Loco no: </B>".$row['loco_no'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Date: </B>".$row['date'];
           ?> 
          </div>
          <div class="col-sm">
           <?php
            echo "<B>Remarks: </B>".$row['remarks'];
           ?> 
          </div>
        </li>    
      <?php           
      }
    }      
  }

?>

</div>


<script>
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsB
    yClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>

