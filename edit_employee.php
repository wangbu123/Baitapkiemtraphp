<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('location: login.php');
    exit(); 
}


if (!isset($_GET['id'])) {
    header('location: index.php');
    exit();
} else {
    include 'config/connect.php';

    $ma_nv = $_GET['id'];

    $sql = "SELECT * FROM NHANVIEN WHERE Ma_NV = '$ma_nv'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (isset($_POST['submit'])) {
    
            $ten_nv = $_POST['ten_nv'];
            $phai = $_POST['phai'];
            $noi_sinh = $_POST['noi_sinh'];
            $ma_phong = $_POST['ma_phong'];
            $luong = $_POST['luong'];
            $update_sql = "UPDATE NHANVIEN 
                           SET Ten_NV = '$ten_nv', Phai = '$phai', Noi_Sinh = '$noi_sinh', 
                               Ma_Phong = '$ma_phong', Luong = $luong 
                           WHERE Ma_NV = '$ma_nv'";

            if ($conn->query($update_sql) === TRUE) {
                header('location: index.php');
                exit();
            } else {
                echo "Lỗi: " . $conn->error;
            }
        }
    } else {
        echo "Không tìm thấy nhân viên.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Thông Tin Nhân Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"] {
            width: calc(100% - 10px);
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Sửa Thông Tin Nhân Viên</h1>
    <form action="" method="POST">
        <label for="ma_nv">Mã Nhân Viên:</label>
        <input type="text" id="ma_nv" name="ma_nv" value="<?php echo $row['Ma_NV']; ?>" disabled>
        
        <label for="ten_nv">Tên Nhân Viên:</label>
        <input type="text" id="ten_nv" name="ten_nv" value="<?php echo $row['Ten_NV']; ?>">
        
        <label for="phai">Giới Tính:</label>
        <input type="text" id="phai" name="phai" value="<?php echo $row['Phai']; ?>">
        
        <label for="noi_sinh">Nơi Sinh:</label>
        <input type="text" id="noi_sinh" name="noi_sinh" value="<?php echo $row['Noi_Sinh']; ?>">
        
        <label for="ma_phong">Mã Phòng:</label>
        <input type="text" id="ma_phong" name="ma_phong" value="<?php echo $row['Ma_Phong']; ?>">
        
        <label for="luong">Lương:</label>
        <input type="text" id="luong" name="luong" value="<?php echo $row['Luong']; ?>">
        
        <input type="submit" name="submit" value="Lưu">
    </form>
</body>
</html>


