<?php
// الاتصال بقاعدة البيانات
include('include/connected.php');

// الحصول على معرف المنتج من الرابط
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// جلب تفاصيل المنتج من قاعدة البيانات
$sql = "SELECT * FROM product WHERE id = $product_id";
$result = $conn->query($sql);

// التحقق من وجود المنتج
if ($result && $result->num_rows > 0) {
    $product = $result->fetch_assoc();

    // التحقق من أن رابط الفيديو موجود
if (!empty($product['video_link'])) {
    $video_url = $product['video_link'];

    // تحويل رابط youtu.be إلى صيغة embed
    if (strpos($video_url, 'youtu.be') !== false) {
        $video_id = substr(parse_url($video_url, PHP_URL_PATH), 1); // استخراج الـ VIDEO_ID
        $video_url = "https://www.youtube.com/embed/" . $video_id;
    } 
    // تحويل رابط youtube.com/watch إلى صيغة embed
    elseif (strpos($video_url, 'watch?v=') !== false) {
        $video_id = explode("v=", $video_url)[1]; // استخراج الـ VIDEO_ID
        $ampersandPosition = strpos($video_id, '&'); // التحقق إذا كان هناك متغيرات بعد الـ ID
        if ($ampersandPosition !== false) {
            $video_id = substr($video_id, 0, $ampersandPosition); // استخراج الـ ID فقط
        }
        $video_url = "https://www.youtube.com/embed/" . $video_id;
    }
    // تحويل رابط فيسبوك إلى embed مع الرابط المباشر
    elseif (strpos($video_url, 'facebook.com') !== false) {
        // استخدم الرابط المباشر للفيديو على فيسبوك
        $video_url = "https://www.facebook.com/plugins/video.php?href=" . urlencode($video_url) . "&show_text=0&width=560";
    }
    // تحويل رابط انستقرام إلى صيغة embed
    elseif (strpos($video_url, 'instagram.com') !== false) {
        $video_url = strtok($video_url, '?') . "/embed"; // إزالة أي متغيرات إضافية
    }
}

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['proname']); ?> - تفاصيل المنتج</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- تضمين Facebook SDK -->
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ar_AR/sdk.js#xfbml=1&version=v17.0"></script>

    <style>
         body {
            background-color: #e9ecef;
            font-family: 'Tajawal', sans-serif;
            color: #333;
        }

        h1 {
            font-size: 2.2rem;
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        p {
            font-size: 1.1rem;
            color: #555;
        }
        a{
            display: inline-block; /* عرض الرابط ككتلة داخلية */
    background-color: #2c3e50;
    border-color: #28a745;
    padding: 10px 25px;
    font-size: 1.1rem;
    transition: background-color 0.3s ease-in-out;
    color: white; /* لون النص */
    text-align: center; /* محاذاة النص في الوسط */
    text-decoration: none; /* إزالة الخط السفلي من الرابط */
    margin: 0 auto; /* توسيط الرابط أفقياً */
        }

        .container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
        }

        .text-center img {
            border-radius: 10px;
            transition: all 0.3s ease-in-out;
        }

        .text-center img:hover {
            transform: scale(1.05);
        }

        .row img {
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }

        .row img:hover {
            transform: scale(1.1);
        }

        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
            padding: 10px 25px;
            font-size: 1.1rem;
            transition: background-color 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #218838;
            border-color: #218838;
        }

        a {
            color: #28a745;
            text-decoration: none;
        }

        a:hover {
            color: #218838;
            text-decoration: underline;
        }

        .product-video iframe {
            border-radius: 8px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        }

        .description {
            text-align: center; /* وضع الوصف في المنتصف */
            margin-top: 20px;
        }

    </style>
</head>
<body dir="rtl">
       
    <div class="container mt-5">
        <!-- عرض اسم المنتج -->
       <h1><?php echo htmlspecialchars($product['proname']); ?></h1>
        <!-- عرض الصورة الرئيسية -->
        <div class="text-center mb-4">
            <img src="/Task/uploads/img/<?php echo htmlspecialchars($product['proimg']); ?>" width="350" alt="الصورة الرئيسية" class="img-fluid">
        </div><br><br>

        <!-- عرض الصور الإضافية بجانب بعضها -->
        <div class="row mb-4">
            <div class="col">
                <img src="/Task/uploads/img/<?php echo htmlspecialchars($product['img_1']); ?>" width="180" alt="الصورة الأولى" class="img-thumbnail">
            </div>
            <div class="col">
                <img src="/Task/uploads/img/<?php echo htmlspecialchars($product['img_2']); ?>" width="180" alt="الصورة الثانية" class="img-thumbnail">
            </div>
            <div class="col">
                <img src="/Task/uploads/img/<?php echo htmlspecialchars($product['img_3']); ?>" width="180" alt="الصورة الثالثة" class="img-thumbnail">
            </div>
        </div><br><br>

     


     

        <!-- عرض وصف المنتج في المنتصف -->
        <div class="description">
            <p><?php echo htmlspecialchars($product['prodescipr']); ?></p>
        </div><br><br><br>

        
        <!-- عرض فيديو عن المنتج إذا كان موجوداً -->
        <?php if (!empty($product['video_link'])): ?>
            <div class="text-center">
    <a href="<?php echo htmlspecialchars($video_url); ?>" target="_blank">شاهد الفيديو على فيسبوك</a>
</div>
<?php else: ?>
    <!-- عرض رسالة عدم وجود فيديو -->
    <p>لا يوجد فيديو متاح لعرضه.</p>
<?php endif; ?><br><br>

        <!-- رابط العودة إلى صفحة المنتجات -->
        <div class="text-center">
            <a href="index.php" class="btn btn-primary">عودة إلى قائمة المنتجات</a>
        </div>
    </div>
</body>
</html>


<?php
} else {
    echo "لم يتم العثور على المنتج.";
}

$conn->close();
?>