<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db_host = "localhost";
$db_user = "root";
$db_pass = ""; 
$db_name = "my_database"; 

try {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        throw new Exception("فشل الاتصال: " . $conn->connect_error);
    }

    if (!isset($_POST["direction"])) {
        throw new Exception("لم يتم استلام بيانات الاتجاه");
    }

    $direction = $_POST["direction"];

    $stmt = $conn->prepare("INSERT INTO movement_table (direction) VALUES (?)");
    if (!$stmt) {
        throw new Exception("خطأ في إعداد الاستعلام: " . $conn->error);
    }

    $stmt->bind_param("s", $direction);

    if (!$stmt->execute()) {
        throw new Exception("خطأ عند تنفيذ الاستعلام: " . $stmt->error);
    }

    echo "تم تسجيل الحركة بنجاح";

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo "خطأ: " . $e->getMessage();
}
?>
