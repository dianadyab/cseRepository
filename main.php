<?php

session_start();
$firstName='';
$lastName='';
//echo $_SESSION['email'] ;
if(!isset($_SESSION['email'])){
  header('Location:signin.php');
}
else{
  $email=$_SESSION['email'];
  include('config/dbConfig.php');
  $sql="SELECT * FROM student WHERE email='$email'";
  $result=mysqli_query($conn,$sql);
$student=mysqli_fetch_assoc($result);

$firstName=$student['firstName'];
$lastName=$student['lastName'];
mysqli_free_result($result);//free result
mysqli_close($conn);//close connection



}

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <?php include('templates/headerMain.php') ?>
  <div class="container about" style="background:white;width:50%;text-align:center;">
    <img src="image/logo.png" alt="" class="img-circle img-responsive" style="border:2px solid black;display: inline;
    margin-top: -70px;">
    <h2 style="margin-top:10px;"><?php

echo "Hello ".$firstName." ".$lastName." ^^";



     ?></h2>
    <div class="row">
      <div class="col-sm-12">
        <a href="search.php" class="btn  buttons" role="button" style="    border-color: #196419;" >SEARCH</a>

      </div>
      <div class="col-sm-12">
        <a href="upload.php" class="btn  buttons" role="button" style="border-color: #196419;" >UPLOAD</a>
      </div>
    </div>
  </div>

  </body>
</html>
