<?php
// تضمين الاتصال بقاعدة البيانات
include('database.php');

// تحقق من الاتصال بقاعدة البيانات
if ($conn->connect_error) {
    echo json_encode(["error" => "فشل الاتصال بقاعدة البيانات: " . $conn->connect_error]);  // عرض رسالة خطأ JSON إذا فشل الاتصال
    exit();  // إنهاء السكربت في حال فشل الاتصال
}

// استرجاع الكلمة المراد البحث عنها من الطلب (GET)
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

// تحقق من أن المستخدم قد أدخل كلمة للبحث
if (empty($search_term)) {
    echo json_encode(["error" => "Please provide a search term."]);
    exit;
}

// استعلام لاسترجاع المنتجات التي تحتوي على الكلمة في اسم المنتج أو الوصف
$sql = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ?";
$stmt = $conn->prepare($sql);
$search_term_wildcard = '%' . $search_term . '%'; // إضافة % للبحث الجزئي
$stmt->bind_param("ss", $search_term_wildcard, $search_term_wildcard);

// تنفيذ الاستعلام
$stmt->execute();
$result = $stmt->get_result();

// إرسال النتيجة بتنسيق JSON
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

// إذا لم توجد نتائج
if (empty($products)) {
    echo json_encode(["message" => "No products found."]);
} else {
    echo json_encode($products);
}
?>
