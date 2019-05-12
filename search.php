<?php

//get all courses int array and display them in the form
$coursesName=[];
include('config/dbConfig.php');
$sql='SELECT DISTINCT courseName from files';
$result=mysqli_query($conn,$sql);
$coursesName=mysqli_fetch_all($result,MYSQLI_ASSOC);
mysqli_free_result($result);
//print_r($coursesName);

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
  <?php include('templates/headerMain.php') ?>
  <div class="signup" style="width:50%;margin:60px auto;">
    <form class="form-horizontal" action="download.php" method="post" >

<!--Course Name -->
      <div class="form-group">
          <label class="control-label col-sm-2 " for="course" >Course Name</label>
          <div class="col-sm-8">
            <select class="form-control" name="course">
                <?php foreach ($coursesName as $key ): ?>
                  <option value="<?php echo $key['courseName']; ?>"><?php echo $key['courseName']; ?></option>
                <?php endforeach; ?>

            </select>


          </div>


      </div>
      <div class=" submit  " style="width:30%;margin:40px auto;padding:10px;" >
        <input class="signUpSubmit" type="submit" name="submit" value="Search"  >
      </div>







    </form>
  </div>

   </body>
 </html>
