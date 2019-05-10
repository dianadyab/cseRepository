<?php

//connect to the database
//mysqli or PDP(PHP Data Objects) to connect to data base
//mysqli
//connection reference
$conn = mysqli_connect('localhost','Diana','data12345','cserepo');
//check the connection
if(!$conn){
echo "connection error".mysqli_connection_error();
}


 ?>
