<?php

$host = 'localhost';
$username = 'u678154600_migration';
$password = 'Support123';
$database = 'u678154600_migration';
$port = 3306;

$conn = new mysqli($host, $username, $password, $database, $port);

// تحقق من الاتصال بقاعدة البيانات
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);  // في حال فشل الاتصال
} else {
    // يمكننا تعليق هذه الرسالة في الإنتاج
    echo "تم الاتصال بقاعدة البيانات بنجاح.";  // في حال كان الاتصال ناجحًا
}
?>
