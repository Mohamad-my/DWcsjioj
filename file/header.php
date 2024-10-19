<?php
$host="localhost:3309:3309";
$username="root";
$password="";
$dbname="task";

$conn=mysqli_connect($host ,$username,$password,$dbname);
if(isset($conn)){
    echo"اتصال ناجح بقاعدة البيانات";
}
else{
    echo"لم يتم الاتصال يقاعدة البيانات";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png"href="img/4660619.png">
    <title>منتجات</title>
    <style>
    .navbar {
        background-color: #333;
        padding: 15px !important;
    }

    .navbar-brand {
        color: #fff;
        font-size: 28px !important;
        font-weight: bold;
    }

    .navbar-nav .nav-link {
        color: #fff;
        margin-right: 20px;
        font-size: 18px;
    }

    .navbar-nav .nav-link:hover {
        color: gray;
    }

    .last-post {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        background-color: #f8f9fa;
        padding: 10px 20px;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .cart ul {
        list-style-type: none;
        display: flex;
        gap: 15px;
        margin: 0;
        padding: 0;
    }

    .cart ul li {
        display: inline-block;
        position: relative;
    }

    .cart ul li a {
        color: #343a40;
        font-size: 1.5rem;
        text-decoration: none;
    }

    .cart ul li .cart-icon {
        position: relative;
    }

    .cart ul li .cart-icon .cart-count {
        position: absolute;
        top: -8px;
        right: -12px;
        background-color: #dc3545;
        color: white;
        font-size: 0.8rem;
        padding: 3px 6px;
        border-radius: 50%;
    }

    body {
        background-color: #f4f4f9;
        font-family: 'Tajawal', sans-serif;
        color: #333;
        margin: 0;
        padding: 0;
    }

    main {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        padding: 2rem;
        gap: 1.5rem;
        background-color: #e9ecef;
    }

    /* تنسيق عام للكرت */
/* تنسيق عام للكرت */
.product {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    text-align: center;
    background-color: #ffffff;
    padding: 20px;
    margin-bottom: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    color: #000; /* النص داخل الكرت باللون الأسود */
}

.product:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

/* تنسيق صورة المنتج */
.product-img img {
    width: 100%;
    height: 180px; /* تحديد ارتفاع الصورة */
    object-fit: contain; /* تكيف الصورة مع الكرت */
    border-radius: 10px;
}

/* تنسيق النصوص داخل الكرت */
.product-name, .product-price, .product-description {
    margin: 12px 0;
    font-size: 1.1rem;
    color: #000; /* تأكيد أن اللون الأسود يطبق على النصوص */
}

.product-name a, .product-price a, .product-description a {
    color: #000; /* جعل الروابط باللون الأسود */
    text-decoration: none; /* إزالة خط التسطير تحت النص */
}

.product-name a:hover, .product-price a:hover, .product-description a:hover {
    color: #000; /* عدم تغيير اللون عند مرور الماوس */
}

/* تنسيق للكمية */
.qty-input input {
    padding: 8px;
    border-radius: 8px;
    border: 1px solid #ccc;
    width: 80px;
    text-align: center;
}

/* زر الإضافة إلى السلة */
.addto-cart {
    background-color: #28a745;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.addto-cart:hover {
    background-color: #218838;
    transform: scale(1.05);
}


.cart-count{
color:red;
position: absolute;
top: -8px;
right: -12px;
background-color: #dc3545;
color: white;
font-size: 0.8rem;
padding: 3px 6px;
 border-radius: 50%;
}
.cart-modal {
    display: flex;
    justify-content: flex-end; /* محاذاة المحتوى إلى اليمين */
    align-items: flex-start; /* محاذاة العناصر في الأعلى */
    position: fixed; /* جعلها ثابتة في الشاشة */
    z-index: 1000; /* أعلى من العناصر الأخرى */
    top: 0; /* بداية من الأعلى */
    right: 0; /* الظهور من الجهة اليمنى */
    width: 400px; /* عرض السلة */
    height: 100%; /* ملء الشاشة من الأعلى إلى الأسفل */
    background-color: rgba(0, 0, 0, 0.6); /* خلفية مظللة */
}

.cart-modal-content {
    background: #fff; /* خلفية بيضاء للمحتوى */
    padding: 20px;
    border-radius: 4px; /* زوايا دائرية */
    width: 100%; /* العرض الكامل للسلة */
    height: 100%;
    max-width: 100%; /* أقصى عرض */
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2); /* ظل خفيف */
    position: relative; /* لنقطة الإغلاق */
}

.close {
    position: absolute; /* مكانها فوق المحتوى */
    top: 10px;
    left: 15px; /* تغيير الموضع إلى اليسار */
    font-size: 24px;
    color: #333; /* لون النص */
    cursor: pointer; /* تغيير المؤشر عند التمرير */
}

.close:hover {
    color: #ff0000; /* لون عند التمرير */
}

h2 {
    text-align: center; /* توسيط العنوان */
    color: #007bff; /* لون العنوان */
}

.cart-items {
    list-style: none; /* إزالة النقاط */
    padding: 0; /* إزالة الحشو */
    max-height: 200px; /* أقصى ارتفاع للقائمة */
    overflow-y: auto; /* تمكين التمرير */
}

.cart-items li {
    background: #f9f9f9; /* خلفية عناصر السلة */
    margin-bottom: 10px; /* مسافة بين العناصر */
    padding: 10px; /* مسافة داخلية */
    border-radius: 5px; /* زوايا دائرية */
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); /* ظل خفيف */
}

.cart-summary {
    text-align: center; /* توسيط المحتوى */
    margin-top: 20px; /* مسافة فوق ملخص السلة */
}

button {
    background-color:#218838; /* لون زر */
    color: white; /* لون النص */
    border: none;
    border-radius: 5px; /* زوايا دائرية */
    padding: 10px 15px; /* مسافة داخلية */
    cursor: pointer; /* تغيير المؤشر عند التمرير */
    transition: background-color 0.3s; /* تأثير عند التمرير */
    margin: 5px; /* مسافة بين الأزرار */
}

button:hover {
    background-color:#28a745; /* لون الزر عند التمرير */
}


    @media (max-width: 480px) {
        .navbar-brand {
            font-size: 22px;
        }

        .navbar-nav .nav-link {
            font-size: 16px;
        }

        .product-price a {
            font-size: 16px;
        }

        .cart-summary button {
            font-size: 1rem;
        }
    }
</style>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   <!-- Navbar -->
   <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgb(43, 42, 42);">
    <div class="container">
        <a class="navbar-brand" href="#" style="display: flex; align-items: center;">
            <span>Medical Devices</span>
            <img src="img/34.png" alt="Logo" width="90" height="40" style="margin-left: 10px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto"> <!-- ms-auto لنقل القائمة إلى اليمين -->
                <li class="nav-item">
                    <a class="nav-link" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="About_us.html">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Review.php">Review</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
     <!---------- cart start------------>
     <div class="last-post">
     <div class="cart">
    <ul>
        <li><a href="admain/admin.php"><i class="bi bi-person-circle"></i></a></li>
        <li class="cart-icon">
           <a href="#" onclick="toggleCart()"><i class="bi bi-bag-fill"></i></a>
            <div class="cart-summary">
    <span class="cart-count">0</span> 
</div>
        </li>
    </ul>
    
<!-- نافذة السلة -->
<div class="cart-modal" id="cartModal" style="display: none;">
    <div class="cart-modal-content">
        <span class="close" onclick="toggleCart()">&times;</span>
        <h2>عناصر السلة</h2>
        <ul class="cart-items"></ul> <!-- هذه القائمة سيتم تعبئتها بعناصر السلة -->
        <div class="cart-summary">
            <p>إجمالي العناصر: 
                <span id="totalItems"></span></p> <!-- إجمالي العناصر -->
            <button onclick="emptyCart()">إفراغ السلة</button>
            <button onclick="confermcart()">تأكيد الطلب</button>
        </div>
    </div>
</div>



<script>
    function toggleCart() {
    const cartModal = document.getElementById('cartModal');
    
    // عرض أو إخفاء السلة بناءً على حالتها الحالية
    if (cartModal.style.display === 'none' || cartModal.style.display === '') {
        cartModal.style.display = 'block'; // إظهار السلة
    } else {
        cartModal.style.display = 'none'; // إخفاء السلة
    }
}


    </script>


</div>
        <!---------- cart end------------>

    </div>

    