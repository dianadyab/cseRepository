<?php
$errors=['firstName'=>'','lastName'=>'','email'=>'','password'=>'','re-password'=>''];
$firstName=$lastName=$email=$password=$rePassword="";
if (isset($_POST['submit'])) {
if(empty($_POST['firstName'])){
  $errors['firstName']='your first name is required';
  //echo $errors['firstName'];
}
else{
  $firstName=$_POST['firstName'];
  if(!preg_match('/^[a-zA-z\s]+$/',$firstName)){
    $errors['firstName']="first name must be letters only";


  }
}
if(empty($_POST['lastName'])){
  $errors['lastName']="your last name is required";
  //echo $errors['lastName'];
}
else{
  $lastName=$_POST['lastName'];
  if(!preg_match('/^[a-zA-z\s]+$/',$lastName)){
    $errors['lastName']='last name must be letters only';
    //echo $errors['lastName'];

  }
}
if(empty($_POST['email'])){
  $errors['email']='your email is required';
  //echo $errors['email'];
}
else {
  $email=$_POST['email'];
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
     $errors['email']='syntax is not vaild';
  }
}

if(empty($_POST['password'])){
  $errors['password']='password is required';
   //$errors['password'];
}
else{
  $password=$_POST['password'];
}

if(empty($_POST['re-password'])){
  $errors['re-password']='confirm your password';
}
else{

}
if(!empty($_POST['password'])&&!empty($_POST['re-password'])){
if($_POST['password']!=$_POST['re-password']){
  $errors['re-password']="Passwords do not match";
}
else{
  $rePassword=$_POST['re-password'];
}
}

if(!array_filter($errors)){
  //insert to database
$conn=mysqli_connect('localhost','Diana','data12345','cserepo');
$firstName=mysqli_real_escape_string($conn,$_POST['firstName']);
$lastName=mysqli_real_escape_string($conn,$_POST['lastName']);
$email=mysqli_real_escape_string($conn,$_POST['email']);
$password=mysqli_real_escape_string($conn,$_POST['password']);

$sql="INSERT INTO student(firstName,lastName,email,password) VALUES('$firstName','$lastName','$email','$password')";

if(mysqli_query($conn,$sql)){
  session_start();
  $_SESSION['email']=$email;
  header('Location:main.php');

}
else{
  //error
  echo 'query error:'. mysqli_error($conn);
}



}

}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <?php include('templates/signUpHeader.php') ?>

<div class="signup" style="width:50%;margin:60px auto;">
  <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">


    <div class="form-group">
        <label class="control-label col-sm-2 " for="firstName" >First Name</label>
        <div class="col-sm-8">
          <input  type="text" name="firstName" class="form-control" id="firstName" placeholder="Enter First Name" value="<?php echo $firstName; ?>">
        </div>
        <div class="error" style="color:red;">
          <?php echo $errors['firstName']; ?>
        </div>

    </div>




    <div class="form-group">
        <label class="control-label col-sm-2" for="lastName">Last Name</label>
        <div class="col-sm-8">
          <input  type="text" class="form-control" name="lastName" id="lastName" placeholder="Enter Last Name" value="<?php echo $firstName; ?>">
        </div>
        <div class="error" style="color:red;">
          <?php echo $errors['lastName']; ?>
        </div>
    </div>



    <div class="form-group">
        <label class="control-label col-sm-2" for="email">Email</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="error" style="color:red;">
          <?php echo $errors['email']; ?>
        </div>
    </div>



    <div class="form-group">
        <label class="control-label col-sm-2" for="password">Password</label>
        <div class="col-sm-8">
          <input   type="password" class="form-control" id="password" name="password"placeholder="Enter Password" value="<?php echo $password; ?>">
        </div>
        <div class="error" style="color:red;">
          <?php echo $errors['password']; ?>
        </div>
    </div>


    <div class="form-group">
        <label class="control-label col-sm-2" for="re-password">Re Password</label>
        <div class="col-sm-8">
          <input  type="password" class="form-control" id="re-password" name="re-password" placeholder="Re-Enter Password" value="<?php echo $rePassword; ?>">
        </div>
        <div class="error" style="color:red;">
          <?php echo $errors['re-password']; ?>
        </div>
    </div>





        <div class=" submit  " style="width:30%;margin:40px auto;" >
          <input class="signUpSubmit" type="submit" name="submit" value="SIGN UP"  >
        </div>










  </form>
</div>

  </body>
</html>
