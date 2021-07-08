<?php
include_once "config.php";

$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if(!$connection){
   throw new Exception("Cant connect to Database");
}else{
    echo "Connected<br>";
    #mysqli query
    //mysqli_query($connection,"INSERT INTO tasks (task,date) VALUES ('Do something new','2021-05-17')");
//    $result = mysqli_query($connection,"SELECT * FROM tasks");
//    while($data = mysqli_fetch_assoc($result)){
//       echo "<pre>";
//        print_r ($data);
//        echo "</pre>";
//    }
    //mysqli_query($connection,"DELETE FROM tasks");
    mysqli_close($connection);
}