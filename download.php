<?php

include('config/dbConfig.php');

if(isset($_POST['submit'])){

  $course=$_POST['course'];

  //retrieve rows from database

  $sql="SELECT * FROM files WHERE courseName = '$course' ";
  $result=mysqli_query($conn,$sql);
  $files=mysqli_fetch_all($result,MYSQLI_ASSOC);
  mysqli_free_result($result);
  //print_r($files);

}

if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];


    // fetch file to download from database
    $sql = "SELECT * FROM files WHERE id=$id";
    $result=mysqli_query($conn,$sql);
    $file=mysqli_fetch_all($result,MYSQLI_ASSOC);

    $filepath =$file[0]['fileDir'];
    echo $filepath;

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
}

}

  ?>



<!DOCTYPE html>
<html lang="en" dir="ltr">

  <?php include('templates/downloadHeader.php') ?>
  <div class="container" >

  <div class="row" >
    <?php foreach ($files as $file) :?>
<div class="col-md-6 " >
  <div class="card" style="text-align:center;background:white;margin-bottom:60px;color:green">

    <h3 style="padding-top:10px;"><?php echo strtoupper($file['courseName']); ?></h3>
    <h4 style="padding-top:10px;"><?php echo  "Instructor Name: ".$file['instructorName']; ?></h4>
    <h5 style="padding-top:10px;"><?php echo  $file['fileType'] ?></h5>
    <h6 style="padding-top:10px;"><?php echo  "uploaded by : ".$file['firstName']." ".$file['lastName']; ?></h6>
    <a href="download.php?file_id=<?php echo $file['id']?>">Download</a>



  </div>
</div>
<?php endforeach; ?>
  </div>
</div>


  </body>
</html>
