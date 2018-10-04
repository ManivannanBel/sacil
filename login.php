<?php
//include("connect2db.php"); // as it is already mentioned in the index.php
$table = 'clis_details';
if(isset($_POST['login_submit'])){
  $uid = format_input($_POST['uid']);
  $upas = format_input($_POST['upas']);
  $column_id = "clis_cms_id";
          if(isset($_POST['iscontroller'])){
          $table = 'controller_details';
          $column_id = "controller_id";
        }
  if($uid!='' && $upas!=''){
    $sql = "SELECT * FROM $table WHERE $column_id LIKE '$uid' AND `paswd` LIKE '$upas'";
    
    $res1 = mysqli_query($conn,$sql);
      if($res1){
    $row=mysqli_fetch_assoc($res1);

            if($row>=1)
            {   if($table=='clis_details'){
                $_SESSION['loggeduser_original'] = format_output($row['clis_name']);
                $_SESSION['loggeduserid_original'] = format_output($row['clis_cms_id']);
              }else{
                $_SESSION['logged_controller_name'] = format_output($row['controller_name']);
                $_SESSION['logged_controller_id'] = format_output($row['controller_id']);
              }
                $islogged = 1;
                
            } 
          }
  }
}
//logging out
  if(isset($_POST['btn_logout'])){
    session_unset();
  }
//---------------------
if(isset($_SESSION['loggeduser_original'])||isset($_SESSION['logged_controller_id'])){
if(isset($_SESSION['loggeduser_original'])){
    $usrnm = $_SESSION['loggeduser_original'];
    $usrid = $_SESSION['loggeduserid_original'];
}else if(isset($_SESSION['logged_controller_id'])){
    $usrnm = $_SESSION['logged_controller_name']." As a <i>TLC</i>";
    $usrid = $_SESSION['logged_controller_id'];
}
?>
<!-- +++++++++++++++++++++++++++++++++++++++== -->
<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class="panel-title"><?php echo "$usrnm";?></h4>
  </div>
  <div class="panel-body" style="text-align:center;">
    <p> You are logged in as</p>
    <p><img src="pic/propic.png"></p>
    <p>
      <b>Name:</b><?php echo "$usrnm";?><br>
      <b>ID:</b><?php echo "$usrid";?>
    </p>
    <p><a href="fpinotification.php">FPI Notification</a></p>
    <form method="post">
    <input name = "btn_logout" class=" btn btn-md btn-danger" type="submit" value="Log Out">

    </form>
  </div>
</div>
<!--
<div><span><?php //echo "Logged in successfully!<br>$usrid : $usrnm";?></span></div>
<!-- +++++++++++++++++++++++++++++++++++++ -->
<?php
}else{ 

?>



  <div class="panel panel-default" > 
    <div class="panel-heading" id="title">
          <h4 class="panel-title" >Login</h4>
    </div>
    <div class="panel-body">
      <form method="post" id="contactform" action="" role="form" class="form-horizontal" >
        <div class="form-group">
          <label class="control-label col-sm-4" for="contactname">CMS ID</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" style="text-transform:none;" placeholder="CMS ID" id="contactname" name="uid" required>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-4" for="contactpassword" >PASSWORD</label>
          <div class="col-sm-8">
            <input type="password" class="form-control" style="text-transform:none;" placeholder="Password" id="contactpassword" name="upas" required>
          </div>
        </div>

        <div class="form-group" style="padding-left: 30px;">
          
            <div class="checkbox checkbox-primary col-sm-10 control-label">
                        <input name = "iscontroller" id="checkbox2" type="checkbox" >
                        <label for="checkbox2">
                            LOG IN AS TLC
                        </label>
                    </div>
        </div>

        <div style="text-align: center;">
        <input type="submit" id="contactbtn" class="btn btn-primary btn-md col-md-offset-1" value="login" name="login_submit" >
        </div>
      </form>
      <p style="text-align: center;"><a href="forgotpassword.php" target="_blank" >Forgot Password?</a></p>
    </div>
  </div>

<?php
}
?>