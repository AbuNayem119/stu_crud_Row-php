<?php

    if (isset($_GET['stu_sl'])) {
        $stu_id = $_GET['stu_sl'];
    }

    $conn = new mysqli('localhost','root','','stu_crud');

    $sql = "SELECT * FROM student WHERE stu_id='$stu_id'";
    $data = $conn -> query($sql);
    $all_data = $data -> fetch_assoc();
    unlink("image/".$all_data['image']);

    $sql = "DELETE FROM student WHERE stu_id='$stu_id'";
    $data = $conn -> query($sql);


    header("location:all_stu.php");
























