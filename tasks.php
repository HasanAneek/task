<?php
//$action = $_POST['action'] ?? '';
include_once "config.php";
$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if(!$connection){
    throw new Exception("Cant connect to Database");
}else {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    if (! $action) {
        header('Location: index.php');
        die();
    } else {
        if ('add' == $action) {
            $task = $_POST['task'];
            $date = $_POST['date'];

            if ($task && $date) {
                $sql = "INSERT INTO tasks(task, date) VALUES('$task','$date')";
                $result = mysqli_query($connection, $sql);
                header('Location: index.php?added=true');
            }
        }else if('complete'== $action){
            $taskid = $_POST['taskid'];
            if($taskid){
                $sql = "UPDATE tasks SET complete=1 WHERE id={$taskid} LIMIT 1";
                $result = mysqli_query($connection, $sql);
            }
            header('Location: index.php');
        }else if('incomplete' == $action){
            $taskid = $_POST['taskid'];
            if($taskid){
                $sql = "UPDATE tasks SET complete=0 WHERE id={$taskid} LIMIT 1";
                $result = mysqli_query($connection,$sql);
            }
            header('Location: index.php');
        }else if('delete' == $action){
            $taskid = $_POST['taskid'];
            if($taskid){
                $sql = "DELETE FROM tasks WHERE id={$taskid} LIMIT 1";
                $result = mysqli_query($connection,$sql);
            }
            header("Location: index.php");
        }else if('bulkcomplete' == $action){
            $taskids = $_POST['taskids'];
            $_taskids = join(",",$taskids);
            if($taskids){
                $sql = "UPDATE tasks SET complete=1 WHERE id in ($_taskids)";
                $result = mysqli_query($connection,$sql);
            }
            header("Location: index.php");
        }else if('bulkdelete' == $action){
            $taskids = $_POST['taskids'];
            $_taskids = join(',',$taskids);
            if($taskids) {
                $sql = "DELETE FROM tasks WHERE id in ($_taskids)";
                $result = mysqli_query($connection, $sql);
            }
        }
        header("Location: index.php");
    }
}
mysqli_close($connection);