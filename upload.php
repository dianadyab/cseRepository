<?php
session_start();
$errors=['courseName'=>'','courseInstructor'=>'','file'=>''];
$courseName=$courseInstructor=$fileType=$file="";
$firstName=$lastName="";
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
//mysqli_close($conn);//close connection
}
if(isset($_POST['submit'])){

  if(empty($_POST['courseName'])){
    $errors['courseName']="course name is required";
  }
  else{
    $courseName=$_POST['courseName'];
    //echo $courseName;
  }

  if(empty($_POST['courseInstructor'])){
    $errors['courseInstructor']="course instructor name is required";
  }
  else{
    $courseInstructor=$_POST['courseInstructor'];
    //echo $courseInstructor;
  }
//if no error
  if(!array_filter($errors)){
    //$_FILES to get the basic information about the uploaded file
    $file=$_FILES['file'];//'file ' is the name of input fiels used to upload file
    //print_r($file);//print all information about file
    $fileName=$file['name'];//extract file name
    $fileType=$file['type'];//file type
    $fileTmp=$file['tmp_name'];
    $fileSize=$file['size'];//file size
    $fileError=$file['error'];//if there is error stop uploading the file
     //now , determine which file allowed to be uploaded to website
     // allow images, word and pdf
     //-------------------
     $fileExt=explode('.',$fileName);//explode the extension of fileName
     //echo $fileExt[0];
     $actualFileExt=strtolower(end($fileExt));//make the extension lower case
     $allowed=array('jpg','jpeg','png','pdf','ppt','doc','docx');
     //now  CHECK IF THE FILE IS ACTUALLY ALLOWED
     if(in_array($actualFileExt,$allowed)){
       //IF THE EXTENSION INSIDE THE ARRAY
       if($fileError===0){
         //IF THERE NO ERROR UPLOADING FILE
         //check the size of the file
         if($fileSize<1000000){
           $fileDestination='uploads/'.$fileExt[0].'.'.$actualFileExt;
           //move the file from temp location to actual location
           //function move_uploaded_file('temp location','actual location')
           move_uploaded_file($fileTmp,$fileDestination);
           //NOW INSERT THE ROW TO DATABASE
           $courseName=mysqli_real_escape_string($conn,$_POST['courseName']);
           $courseInstructor=mysqli_real_escape_string($conn,$_POST['courseInstructor']);
           $fileType=mysqli_real_escape_string($conn,$_POST['fileType']);
           //write sql
           $sql="INSERT INTO files(firstName,lastName,fileType,courseName,instructorName,fileDir) VALUES('$firstName','$lastName','$fileType','$courseName','$courseInstructor','$fileDestination')";
           if(mysqli_query($conn,$sql)){
             //

           }



         }
         else{
           echo "your file is too big!!";
         }


       }
       else{
         //echo error
         echo "There was an error uploading your file!!";
       }

     }
     else{
       //error message
       echo "you cant upload file of this type";
     }


  }

}// end of if(isset())

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <?php include('templates/headerMain.php'); ?>
  <div class="signup" style="width:50%;margin:60px auto;">
    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

<!--Course Name -->
      <div class="form-group">
          <label class="control-label col-sm-2 " for="courseName" >Course Name</label>
          <div class="col-sm-8">

<input type="text" class="form-control" name="courseName" placeholder="Enter Course Name" value="<?php echo $courseName; ?>">

      </div>
          <div class="error" style="color:red;">
            <?php echo $errors['courseName']; ?>
          </div>

      </div>

<!--Instructor Name -->


      <div class="form-group">
          <label class="control-label col-sm-2" for="courseInstructor">Course Instructor</label>
          <div class="col-sm-8">
            <input  type="text" class="form-control" name="courseInstructor"  placeholder="Enter Course Instructor Name" value="<?php echo $courseInstructor; ?>">
          </div>
          <div class="error" style="color:red;">
            <?php echo $errors['courseInstructor']; ?>
          </div>
      </div>

<!-- File type-->

      <div class="form-group">
          <label class="control-label col-sm-2" for="email">File Type</label>
          <div class="col-sm-8">
            <select class="form-control" name="fileType" id="fileUpload">
                <option>Course's Material</option>
                <option>Course's exams</option>

              </select>
          </div>
          <!--
          <div class="error" style="color:red;">
            <?php echo $errors['fileType']; ?>
          </div>
        -->
      </div>


      <input style="margin:auto;" type="file" class="custom-file-input" name="file" required>


          <div class=" submit  " style="width:30%;margin:40px auto;padding:10px;" >
            <input class="signUpSubmit" type="submit" name="submit" value="UPLOAD"  >
          </div>

    </form>
  </div>

  </body>
</html>
