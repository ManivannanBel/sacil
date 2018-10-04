
	<style type="text/css">
			.nav-tabs {
    margin-bottom: 15px;
}
.sign-with {
    margin-top: 25px;
    padding: 20px;
}
div#OR {
    height: 30px;
    width: 30px;
    border: 1px solid #C2C2C2;
    border-radius: 50%;
    font-weight: bold;
    line-height: 28px;
    text-align: center;
    font-size: 12px;
    float: right;
    position: absolute;
    right: -16px;
    top: 40%;
    z-index: 1;
    background: #DFDFDF;
}
#form_design{
     	text-decoration: none;
		font-weight: bold;
		color: black;
     }		
</style>
		<script type="text/javascript">
			$('#myModal').modal('show');

		</script>
<?php
if(isset($_POST['admin_submit'])){
  $uid = $_POST['clisid'];
  $upas = $_POST['password'];
  if($uid!='' && $upas!=''){
    $sql = "SELECT * FROM `adminpanel` WHERE `clis_cms_id` LIKE '$uid' AND `password` LIKE '$upas'";
    include("../connect2db.php");
    $res1 = mysqli_query($conn,$sql);
    

            if(mysqli_num_rows($res1)>0)
            {$row=mysqli_fetch_assoc($res1);
               $_SESSION['admin_original'] = $row['Name'];
                $_SESSION['adminid_original'] = $row['clis_cms_id'];
                 $islogged = 1;
                
            } 
  }
}
//logging out
  if(isset($_POST['btn_logout'])){
    session_unset();
  }
  if(!isset($_SESSION['admin_original'])){
?>
<img src="pic/tubelight.gif" height="200" width="200"><br>
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-log-in"></span>
Login</button>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    X</button>
                <h4 class="modal-title" id="myModalLabel" style="color: black;">
                    Login </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#Login" data-toggle="tab">Login</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                   
                            <div class="tab-pane active" id="Login">
                                <form role="form" class="form-horizontal" action="" method="POST" id="form_design">
                                <div class="form-group">
                                    <label for="cmsid" class="col-sm-2 control-label">
                                        CMSID</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="cmsid" placeholder="CMSID" name="clisid" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-sm-2 control-label">
                                        Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="password" placeholder="Password" name="password" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary btn-sm" name="admin_submit">
                                            LOGIN</button>
                                        <a href="javascript:;">Forgot your password?</a>
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
<?php }?>






