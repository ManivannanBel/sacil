<?php
//include("connect2db.php");
$flag=0;
if(isset($_POST['change_submit'])){
    $userid = $column_id = $table = '';
    //---------------------------------------
    if(isset($_SESSION['loggeduser_original'])){
       
        $userid=$_SESSION['loggeduserid_original'];
        $column_id = "clis_cms_id";
        $table = "clis_details";
    }else if(isset($_SESSION['logged_controller_id'])){
          
          $userid=$_SESSION['logged_controller_id'];
          $column_id = "controller_id";
          $table = 'controller_details';
    }

    //----------------------------------------
  $cr = $_POST['cr_pass'];
  $new = $_POST['n_pass'];
  $new_cnf = $_POST['n_pass_cnf'];
  if($cr!='' && $new!='' && $new==$new_cnf){
        $sql = "UPDATE $table set paswd = '$new'  where $column_id='$userid' and paswd = '$cr'";
        $res1 = mysqli_query($conn,$sql);
        if($res1) $flag = 1;
  }
}
?>
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal"></span>
Change Password</button>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" style="z-index:9991;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×</button>
                <h4 class="modal-title" id="myModalLabel" style="color: black;">
                    Change Password </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#Login" data-toggle="tab">New Password</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                   
                            <div class="tab-pane active" id="Login">
                                <form role="form" class="form-horizontal" action="" method="POST" id="form_design">
                                <div class="form-group">
                                    <label for="curr_pass" class="col-sm-2 control-label">
                                        Current Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="curr_pass" placeholder="Current password" name="cr_pass" style="text-transform:none;" required autofocus/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="new_pass" class="col-sm-2 control-label">
                                        New Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="new_pass" placeholder="New Password" name="n_pass" style="text-transform:none;" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="new_pass_cnf" class="col-sm-2 control-label">
                                        Confirm Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="new_pass" placeholder="New Password" name="n_pass_cnf" style="text-transform:none;" required />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary btn-sm" name="change_submit">
                                        Change</button>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>








