<?php
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    // يمكنك الآن استخدام $product_id لاسترجاع بيانات المنتج وتعديلها
    // مثلاً: استعلام SQL لجلب بيانات المنتج من قاعدة البيانات
} else {
    echo "لم يتم تحديد معرف المنتج.";
}
?>
