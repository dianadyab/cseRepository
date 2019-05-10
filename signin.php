<?php

$email=$password="";
$errors=['email'=>'','password'=>'','emailPassword'=>''];
if(isset($_POST['submit'])){
  if(empty($_POST['email'])){
    $errors['email']='email is required';
  }
  else{
    $email=$_POST['email'];
    //preg match
  }
  if(empty($_POST['password'])){
    $errors['password']='password is required';


  }
  else{
    $password=$_POST['password'];
    //preg match
  }

if(!array_filter($errors)){

  include("config/dbConfig.php");//connect to data base
  session_start();// start the session
  $email = mysqli_real_escape_string($conn,$_POST['email']);
  $password = mysqli_real_escape_string($conn,$_POST['password']);
  $sql = "SELECT * FROM student WHERE email = '$email' and password = '$password'";//write query
  $result = mysqli_query($conn,$sql);//make query
  $row = mysqli_fetch_all($result,MYSQLI_ASSOC);//fetch all record
  //print_r($row);
   $count = mysqli_num_rows($result);
   //echo $count;
  if($count == 1) {
        // print_r($row);
        //session_register('email');

        $_SESSION['email'] = $email;


        header("Location:main.php");
      }
      else {
         $errors['emailPassword'] = "invalid email or password";
      }


}

}


 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <?php include('templates/signinHeader.php') ?>

<div class="signup" style="width:50%;margin:60px auto;">
  <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">


    <div class="form-group">
        <label class="control-label col-sm-2" for="email">Email</label>
        <div class="col-sm-8">
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
        </div>
        <div class="" style="color:red;">
          <?php echo $errors['email']; ?>
        </div>
    </div>



    <div class="form-group">
        <label class="control-label col-sm-2" for="password">Password</label>
        <div class="col-sm-8">
          <input  name="password" type="password" class="form-control" id="password" placeholder="Enter Password">
        </div>
        <div class="" style="color:red;">
          <?php echo $errors['password']; ?>
        </div>
    </div>

    <div class="submit" style="width:30%;margin:40px auto;" >
        <input class="signUpSubmit" type="submit" name="submit" value="SIGN IN"  >
    </div>
    <div class="" style="color:red;text-align:center;">
      <?php echo $errors['emailPassword']; ?>
    </div>

  </form>
</div>

  </body>
</html>
