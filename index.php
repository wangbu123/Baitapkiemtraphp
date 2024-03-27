<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit(); 
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chính</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style>
   * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

h1, h2 {
    text-align: center;
    margin-bottom: 20px;
}

p {
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    background-color: #fff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

table th, table td {
    border: 1px solid #ddd;
    padding: 10px;
}

th {
    background-color: #f2f2f2;
}

img {
    width: 30px;
    height: 30px;
}

form {
    text-align: center;
}

input[type=submit],
button {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type=submit]:hover,
button:hover {
    background-color: #45a049;
}

button {
    background-color: #008CBA;
}

button:hover {
    background-color: #0073ba;
}

.add-button {
    text-align: center;
    margin-bottom: 20px;
}

.add-button button {
    display: inline-block;
}

.logout {
    float: right;
}
 .material-icons {
    vertical-align: middle;
    font-size: 1.2em; 
}
.material-icons:hover {
    color: #007bff; 
}

</style>

</head>
<body>
    <h1>Quản lý nhân sự</h1>
    <p>Hello ^_^ <?php echo $_SESSION['username']; ?>!</p>
    
    <form action="" method="POST" class="logout">
    <input type="submit" name="logout" value="Đăng xuất">
</form>

    <?php
    if ($_SESSION['role'] == 'admin') {
        echo '<button onclick="location.href=\'add_employee.php\'">Thêm nhân viên mới</button>';
    }
    ?>

    <h2 class="has">Thông Tin Nhân Viên</h2>
    <table>
        <tr>
            <th>Mã Nhân Viên</th>
            <th>Tên Nhân Viên</th>
            <th>Giới tính</th>
            <th>Nơi Sinh</th>
            <th>Tên Phòng</th>
            <th>Lương</th>
            <?php
            if ($_SESSION['role'] == 'admin') {
                echo '<th>Thao tác</th>';
            }
            ?>
        </tr>
        
         <?php
        include 'config/connect.php';
        $results_per_page = 5;

        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }

        $start_from = ($page - 1) * $results_per_page;

        $sql = "SELECT NHANVIEN.Ma_NV, Ten_NV, Phai, Noi_Sinh, Ten_Phong, Luong
                FROM NHANVIEN
                JOIN PHONGBAN ON NHANVIEN.Ma_Phong = PHONGBAN.Ma_Phong
                LIMIT $start_from, $results_per_page";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Ma_NV'] . "</td>";
                echo "<td>" . $row['Ten_NV'] . "</td>";
                echo "<td>";
                if ($row['Phai'] == 'NU') {
                    echo '<img src="images/woman.jpg" alt="Woman">';
                } else {
                    echo '<img src="images/man.jpg" alt="Man">';
                }
                echo "</td>";
                echo "<td>" . $row['Noi_Sinh'] . "</td>";
                echo "<td>" . $row['Ten_Phong'] . "</td>";
                echo "<td>" . $row['Luong'] . "</td>";
                if ($_SESSION['role'] == 'admin') {
                   echo '<td><a href="edit_employee.php?id=' . $row['Ma_NV'] . '"><i class="material-icons">edit</i></a> | <a href="delete_employee.php?id=' . $row['Ma_NV'] . '"><i class="material-icons">delete</i></a></td>';


                }
                echo "</tr>";
            }
        } else {
            echo "Không có dữ liệu.";
        }
        $conn->close();
        ?> 
    </table>
    <?php
        include 'pagination.php';
    ?>
</body>
</html>
