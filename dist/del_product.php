<?php
$pro_name = $_GET['pro_name'];
require '../connect.php';
$sql = "DELETE FROM product WHERE pro_name='$pro_name'";
$result = $con->query($sql);
if ($result) {
    echo "<script>alert('Product successfully deleted ✅'); window.location.href='index.php?page=product';</script>";
} else {
    echo "<script>alert('Delete failed ❌'); window.location.href='index.php?page=product';</script>";
}
?>