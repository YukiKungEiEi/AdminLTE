<?php
require '../connect.php';

$filename = $_FILES['csv_file']['name'];
move_uploaded_file($_FILES['csv_file']['tmp_name'], 'assets/user_csv/' . $filename);

$csv = fopen("assets/user_csv/" . $filename, "r");

while ($csvArr = fgetcsv($csv, 1000, ',')) {
    $username = $csvArr[0];
    $password = $csvArr[1];
    $fullname = $csvArr[2];
    $phone    = $csvArr[3];
    $email    = $csvArr[4];

    $sql = "INSERT INTO users(username,password,fullname,phone,email) 
            VALUES('$username','$password','$fullname','$phone','$email')";
    $result = $con->query($sql);

    if (!$result) {
        echo "<script>alert('ไม่สามารถเพิ่มข้อมูลได้')</script>";
    } else {
        echo "<script>window.location.href='index.php?page=users'</script>";
    }
}

?>
