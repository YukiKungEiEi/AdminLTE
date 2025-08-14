<?php
require '../connect.php';

// ใช้ GET ก่อน ถ้าไม่มีใช้ POST แทน
$pro_name = $_GET['pro_name'] ?? $_POST['pro_name'] ?? '';

if (!empty($pro_name)) {
    $sql = "SELECT * FROM product WHERE pro_name = '$pro_name'";
    $result = $con->query($sql);
    $row = mysqli_fetch_array($result);
}

// เช็คว่ามีการ submit form หรือยัง
if (isset($_POST['submit'])) {
    $pro_name   = $_POST['pro_name'];
    $pro_price  = $_POST['pro_price'];
    $pro_amount = $_POST['pro_amount'];
    $pro_status = $_POST['pro_status'];
    
    $filename = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $upload_dir = 'assets/product_img/';

    // ตรวจสอบข้อมูลครบถ้วน
    if (empty($pro_name) || empty($pro_price) || empty($pro_amount) || empty($pro_status)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); history.back();</script>";
        exit;
    }

    // ถ้ามีไฟล์รูปใหม่ถูกอัพโหลด
    if (!empty($filename) && $_FILES['image']['error'] == 0) {
        // ลบไฟล์รูปเก่า ถ้ามี
        if (!empty($row['image']) && file_exists($upload_dir . $row['image'])) {
            unlink($upload_dir . $row['image']);
        }
        // ย้ายไฟล์รูปใหม่
        move_uploaded_file($tmp_name, $upload_dir . $filename);

        // อัพเดตข้อมูลรวมรูปภาพ
        $sql = "UPDATE product SET 
                pro_price='$pro_price',
                pro_amount='$pro_amount',
                pro_status='$pro_status',
                image='$filename'
                WHERE pro_name='$pro_name'";
    } else {
        // อัพเดตข้อมูลไม่เปลี่ยนรูปภาพ
        $sql = "UPDATE product SET 
                pro_price='$pro_price',
                pro_amount='$pro_amount',
                pro_status='$pro_status'
                WHERE pro_name='$pro_name'";
    }

    if ($con->query($sql)) {
        echo "<script>alert('อัปเดตข้อมูลสินค้าสำเร็จ ✅'); window.location.href='index.php?page=product';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล ❌'); history.back();</script>";
    }
}
?>


<!--begin::App Content Header--><!--begin::App Content Header-->
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Edit Product</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">edit_pro</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!--end::App Content Header-->

<!--begin::App Content-->
<div class="app-content">
  <div class="container-fluid">
    <div class="row g-4">
      <div class="col-md-6">
        <div class="card card-primary card-outline mb-4">
          <div class="card-header">
            <div class="card-title">แก้ไขข้อมูลสินค้า 🖋</div>
          </div>

          <form action="" method="POST" enctype="multipart/form-data">
            <div class="card-body">
              <div class="mb-3">
                <label class="form-label">Products Name</label>
                <input type="text" name="pro_name" class="form-control" value="<?php echo $row['pro_name']; ?>" />
              </div>

              <div class="mb-3">
                <label class="form-label">Products Price</label>
                <input type="text" name="pro_price" class="form-control" value="<?php echo $row['pro_price']; ?>" />
              </div>

              <div class="mb-3">
                <label class="form-label">Products Amount</label>
                <input type="number" name="pro_amount" class="form-control" value="<?php echo $row['pro_amount']; ?>" />
              </div>

              <div class="mb-3">
                <label class="form-label">Products Status</label>
                <input type="text" name="pro_status" class="form-control" value="<?php echo $row['pro_status']; ?>" />
              </div>

              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">รูปภาพเดิม</label>
                <img src="assets/product_img/<?php echo htmlspecialchars($row['image']); ?>" width="250px" height="250px" alt="รูปภาพเดิม" class="mb-3" />
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">รูปภาพใหม่</label>
                <input type="file" name="image" class="form-control" id="exampleInputPassword1" />
              </div>

            </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-success" name="submit">บันทึกข้อมูล</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
<!--end::App Content-->