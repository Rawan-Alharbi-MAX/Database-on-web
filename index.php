<?php
// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "first database");
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}
// إضافة مستخدم جديد
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name']) && isset($_POST['age'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $conn->query("INSERT INTO info (name, age) VALUES ('$name', $age)");
}

// تبديل الحالة (status)
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['toggle_id'])) {
    $id = $_GET['toggle_id'];
    $result = $conn->query("SELECT status FROM info WHERE id = $id");
    $row = $result->fetch_assoc();
    $new_status = $row['status'] == 1 ? 0 : 1;
    $conn->query("UPDATE info SET status = $new_status WHERE id = $id");
}

// جلب كل المستخدمين
$users = $conn->query("SELECT * FROM info");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Toggle Users</title>
</head>
<body>
    <h2>أدخل الاسم والعمر</h2>
    <form method="post" action="">
        Name: <input type="text" name="name" required>
        Age: <input type="number" name="age" required>
        <input type="submit" value="Submit">
    </form>

    <h2>سجل المستخدمين</h2>
    <table border="1">
        <tr>
            <th>ID</th><th>Name</th><th>Age</th><th>Status</th><th>Action</th>
        </tr>
        <?php while ($row = $users->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['age'] ?></td>
            <td><?= $row['status'] ?></td>
            <td><a href="?toggle_id=<?= $row['id'] ?>">Toggle</a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
