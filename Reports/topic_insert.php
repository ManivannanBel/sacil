<?php
session_start();
if(isset($_SESSION['adminid_original'])){
require('../connect2db.php');

$update_flag = false;

if(isset($_POST['edit'])) {

  $id = $_POST['topic_id'];

  $update_query = "SELECT * FROM `topics` WHERE `ID` = '$id'";

  $result = mysqli_query($conn, $update_query);

  $row = mysqli_fetch_assoc($result);

  $update_flag = true;

}


?>
<!DOCTYPE html>
<html>
<head>
    <title>SAFET-DRIVE TOPIC</title>
    <link rel="shortcut icon" href="pic/logo.ico" />
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

  </head>
  <body>
     <ul class="pagination  pagination-lg pull-right" style="margin-right:25px;"> 

          <li>
          <a  class="btn" href="index.php"><i class="glyphicon glyphicon-home glyphicon-lg"></i> Home</a>
          </li> 
      </ul>
      
  	<div class="container">

  				<form method="post">
          <div class="panel panel-primary"style="margin:20px 190px; height:520px;"> 
          <div class="panel-heading"><marquee behavior="alternate">CLI-MONITORING</marquee></div>
          <div panel-body>
  					<fieldset  class="scheduler-border"style=" width:auto; height:auto;margin:20px 26px;">
  					<div class="form-group">
              <?php if($update_flag) { ?>
              <input type="hidden" name="topic_id" value="<?php echo $row['ID']; ?>"/>
              <?php } ?>
   							 <label for="topic" class="control-label">SAFETY-DRIVE TOPIC</label>
  							 <input id="topic" type="text" name="topic_title" class="form-control input-lg" value="<?php if($update_flag) echo $row['topic_title']; else echo '';?>" placeholder="ENTER SAFETY-DRIVE TOPIC" autocomplete="off">
  					    
                 <label for="from_date" class="control-label" style="margin-top:15px;">FROM</label>
                 <input id="from_date" type="date" name="topic_start_date" value="<?php if($update_flag) echo $row['topic_from']; else echo '';?>" class="form-control input-lg " >
                 
                 <label for="to_date" class="control-label" style="margin-top:15px;">TO</label>
                 <input id="to_date" type="date" name="topic_end_date" value="<?php if($update_flag) echo $row['topic_to']; else echo '';?>" class="form-control input-lg" >                
                 <label for="topic-description" class="control-label" style="margin-top:15px;">SAFETY-DRIVE TOPIC DESCRIPTION</label>
                 <textarea id="topic-description" type="text" name="topic_description"  rows="3"class="form-control input-lg" placeholder="ENTER SAFETY-DRIVE TOPIC DESCRIPTION" style="resize:none"><?php if($update_flag) echo $row['topic_desc']; else echo '';?></textarea>
  							
                 <button id="add_topic" type="submit" <?php if($update_flag) echo 'name="update"'; else echo 'name="add"'; ?> class="btn btn-success" style="margin-top:15px; width:90px;"><?php if($update_flag) echo 'UPDATE'; else echo 'ADD'; ?></button>
  							  							
                 <button type="submit"  name="search" class="btn btn-info"    style="margin-top:15px; width:90px;">SEARCH</button>
                
                 <button type="reset"   name="clear"  class="btn btn-primary" style="margin-top:15px; width:90px;">CLEAR</button>

                 <button type="submit"   name="display"  class="btn btn-danger" style="margin-top:15px; width:90px;">VIEW ALL</button>

            </div>
  					</fieldset>
            </div>
            </div>
  				</form>
          <div>

            <?php 

            if(isset($_POST['display'])) {

              $display_query = "SELECT * FROM `topics`";

              $result = mysqli_query($conn, $display_query);

              $total_rows = mysqli_num_rows($result);

              if($total_rows > 0) {

                ?>

                <table class="table table-primary table-bordered table-hover table-responsive" cellpadding="5">

                  <thead class="text-primary">
                    
                    <th style="width:200px;">TOPIC-TITLE</th>

                    <th>FROM</th>

                    <th>TO</th>

                    <th>DURATION</th>

                    <th style="width:400px;">TOPIC-DESCRIPTION</th>

                    <th>OPTIONS <button class="btn btn-secondary pull-right" id="close_table"><span class="glyphicon glyphicon-remove"></span></button></th>
                      <script>
                          $(document).ready(function()
                            {
                              $("#close_table").click(function()
                                {
                                      $("table").hide();
                                });
                            });
                      </script>

                  </thead>

                  <tbody>

                  <?php 

                while ($row = mysqli_fetch_assoc($result)) {

                  ?>

                    <tr>
                      
                      <td><?php echo $row['topic_title'] ?></td>

                      <td><?php echo date('d-m-Y', strtotime($row['topic_from'])); ?></td>

                      <td><?php echo date('d-m-Y', strtotime($row['topic_to'])); ?></td>

                      <td><?php echo round(abs(strtotime($row['topic_from']) - strtotime($row['topic_to'])) / 86400); ?> Days</td>

                      <td><?php echo $row['topic_desc'] ?></td>
                      <td>
                        <form method="POST" action=""><input type="hidden" name="topic_id" value="<?php echo $row['ID']; ?>"/><button id="delete_data" type="submit" class="btn btn-danger" name="delete" style="padding:5px;">DELETE</button>
                        <button type="submit"  name="edit" class="btn btn-warning" style="padding:5px;">EDIT</button>
                        </form>

                      </td>

                    </tr>

                    <?php } ?>

                </tbody>

                </table>

                <?php 

              }
              else
              {
                 echo "<script>alert('DATA DO NOT EXISTS')</script";
              }

            }

            if(isset($_POST['add'])) {

              $drive_topic = $_POST['topic_title'];
              $time_from = $_POST['topic_start_date'];
              $time_to = $_POST['topic_end_date'];
              $time_desc = $_POST['topic_description'];

              $add_query = "INSERT INTO `topics` (`topic_title`,`topic_from`,`topic_to`,`topic_desc`) VALUES('$drive_topic', '$time_from','$time_to','$time_desc')";

              if(mysqli_query($conn, $add_query)) 
                {
                
                echo "<script>alert('TOPIC ADDED');</script>";
              } else {

                echo "<script>alert('FAILED TO ADD TOPIC');</script>";

              }

            }

            if(isset($_POST['update'])) {

              $id = $_POST['topic_id'];
              $drive_topic = $_POST['topic_title'];
              $time_from = $_POST['topic_start_date'];
              $time_to = $_POST['topic_end_date'];
              $time_desc = $_POST['topic_description'];

              $edit_query = "UPDATE `topics` SET `topic_title` = '$drive_topic', `topic_from` = '$time_from', `topic_to` = '$time_to', `topic_desc` = '$time_desc' WHERE `ID` = '$id'";

              if(mysqli_query($conn, $edit_query)) 
                {
                
                echo "<script>alert('TOPIC UPDATED');</script>";
              } else {

                echo "<script>alert('FAILED TO UPDATE TOPIC');</script>";

              }

            }

            if(isset($_POST['search'])) {

              $drive_topic = $_POST['topic_title'];

              $search_query = "SELECT * FROM `topics` WHERE `topic_title` = '$drive_topic'";

              $exec_query = mysqli_query($conn, $search_query);

              $total_rows = mysqli_num_rows($exec_query);

              if($total_rows > 0) {

                ?>

                <table class="table table-primary table-bordered table-hover table-responsive" cellpadding="5">

                  <thead class="text-primary">
                    
                    <th >TOPIC-TITLE</th>

                    <th>FROM</th>

                    <th>TO</th>

                    <th>DURATION</th>

                    <th>OPTIONS</th>

                  </thead>

                  <tbody>

                    <?php while($row = mysqli_fetch_assoc($exec_query)) { ?>

                    <tr>
                      
                      <td><?php echo $row['topic_title'] ?></td>

                      <td><?php echo date('d-m-Y', strtotime($row['topic_from'])); ?></td>

                      <td><?php echo date('d-m-Y', strtotime($row['topic_to'])); ?></td>

                      <td><?php echo round(abs(strtotime($row['topic_from']) - strtotime($row['topic_to'])) / 86400); ?> Days</td>

                      <td><form method="POST" action=""><input type="hidden" name="topic_id" value="<?php echo $row['ID']; ?>"/><button id="delete_data"type="submit" class="btn btn-danger" name="delete" style="padding:5px;">DELETE</button></form></td>

                    </tr>

                    <?php } ?>

                </tbody>

                </table>

                <?php 
                
              } else {

                echo "<script>alert('NO SUCH TOPIC FOUND');</script>";
              }

            }

            if(isset($_POST['delete'])) {

              $id = $_POST['topic_id'];

              $delete_query = "DELETE FROM `topics` WHERE `ID` = '$id'";

              if(mysqli_query($conn, $delete_query)) {
               echo "<script>alert('TOPIC DELETED');</script>";
            } else {

                echo "<script>alert('FAILED TO DELETE TOPIC');</script>";

              }

            }
            ?>
          </div>
  	</div>
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="BOOTSTRAP/js/bootstrap.min.js" ></script>
  </body>	
</html>
<?php 
}
?>