<?php
include_once "config.php";
$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if(!$connection){
    throw new Exception("Cant connect to Database");
}
$sql = "SELECT * FROM tasks WHERE complete =0";
$result = mysqli_query($connection,$sql);

$sql1 = "SELECT * FROM tasks WHERE complete=1";
$result1 = mysqli_query($connection,$sql1)
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Todo/Task</title>
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
    <style>
        body{
            margin-top: 30px;
        }
        #main{
            padding: 0px 150px 0px 150px;;
        }
        #action{
            width: 150px;
        }
    </style>
</head>
<body>
<div class="container" id="main">
    <h1>Task Manager</h1>
    <p>This is task Manager.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur cumque dolore eos eveniet reiciendis? Adipisci amet consequatur est id temporibus?
    </p>
    <?php
    if(mysqli_num_rows($result1)>0){
        ?>
    <h4>Completed Task</h4>
    <table>
        <thead>
        <tr>
            <th></th>
            <th>Id</th>
            <th>Task</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
    <?php
    while($data1 = mysqli_fetch_assoc($result1)){
        $timestamp = strtotime($data1['date']);
        $date = date("jS M,Y",$timestamp);
        ?>
        <tr>
            <td><input type="checkbox" class="label-inline" value="<?php echo $data1['id']; ?>"></td>
            <td><?php echo $data1['id']; ?></td>
            <td><?php echo $data1['task']; ?></td>
            <td><?php echo $date ?></td>
            <td> <a class="delete" data-taskid="<?php echo $data1['id']; ?>" href="#">Delete</a> | <a class="incomplete" data-taskid="<?php echo $data1['id']; ?>" href="#">Mark Incomplete</a> </td>
        </tr>
    <?php
    }
    ?>
    </tbody>
    </table>
    <?php
    }
    ?>
    <?php
    if(mysqli_num_rows($result)==0){
        ?>
        <p>No Task Found at DB</p>
    <?php
    }else{
    ?>
        <h4>UPCOMING Task</h4>
        <form action="tasks.php" method="post">
        <table>
            <thead>
            <tr>
                <th></th>
                <th>Id</th>
                <th>Task</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while($data =mysqli_fetch_assoc($result)){
                $timestamp = strtotime($data['date']);
                $date = date("jS M, Y",$timestamp);
                ?>
                <tr>
                    <td><input name="taskids[]" type="checkbox" class="label-inline" value="<?php echo $data['id']; ?>"></td>
                    <td><?php echo $data['id']; ?></td>
                    <td><?php echo $data['task']; ?></td>
                    <td><?php echo $date ?></td>
                    <td><a class="delete" data-taskid="<?php echo $data['id']; ?>" href="#">Delete</a> | <a class="complete" data-taskid="<?php echo $data['id']; ?>" href="#"> Complete</a> </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        <select id="action" name="action">
            <option value="0"  >With Selected</option>
            <option value="bulkdelete">Delete</option>
            <option value="bulkcomplete">Mark as complete</option>
        </select>
            <input type="submit" id="bulksubmit" class="button-primary" value="Submit" >
        </form>
    <?php
    }
    ?>
    <p>...</p>
    <h4>Add Task</h4>
    <form method="POST" action="tasks.php">
        <fieldset>
            <?php
            $added = isset($_GET['added']) ? $_GET['added'] : '';
            if($added){
                echo "<p>Task added Successfully</p>";
            }
            ?>
            <label for="task">Task</label>
            <input type="text" placeholder="Task Details" id="task" name="task">
            <label for="date">Date</label>
            <input type="text" placeholder="Task Date" id="date" name="date">

            <input type="submit" class="button-primary" value="Add Task">
            <input type="hidden" name="action" value="add">
        </fieldset>
    </form>
</div>
<form action="tasks.php" method="post" id="completeform">
    <input type="hidden" id="action" name="action" value="complete">
    <input type="hidden" id="taskid" name="taskid">
</form>
<form action="tasks.php" method="post" id="incompleteform">
    <input type="hidden" id="action" name="action" value="incomplete">
    <input type="hidden" id="itaskid" name="taskid">
</form>
<form action="tasks.php" method="post" id="deleteform">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" id="dtaskid" name="taskid">
</form>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
<script>
    ;(function($){
    $(document).ready(function() {
        $(".complete").on('click', function () {
            var id = $(this).data("taskid");
            $("#taskid").val(id);
            $("#completeform").submit();
        });
            $(".incomplete").on('click', function () {
                var id = $(this).data("taskid");
                $("#itaskid").val(id);
                $("#incompleteform").submit();
            });
            $(".delete").on('click',function(){
                if(confirm("Are you sure to delete this task?")) {
                    var id = $(this).data("taskid");
                    $("#dtaskid").val(id);
                    $("#deleteform").submit();
                }
            });
            $("#bulksubmit").on('click',function(){
                if($("#action").val()=='bulkdelete'){
                    if(!confirm("Are you sure to delete?")){
                        return false;
                    }
                }
            });
    });
    })(jQuery);
</script>
</html>