<?php
    $username = $_GET["username"]; //รับข้อมูล username มาจาก URL
    require '../connect.php'; // เชื่อมต่อ database
    $sql = "DELETE FROM users WHERE username='$username'";
    $result = $con->query($sql);
    if (!$result) {
        echo "<script>alert('ไม่สามารถลบข้อมูลได้')</script>";
    }else{
        echo "<script>window.location.href='index.php?page=users'</script>";
    }
    ?>