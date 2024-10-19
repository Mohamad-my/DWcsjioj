<?php 
include('include/connected.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $text = $_POST['text'];
    $rating = $_POST['rating'];

    // إدخال البيانات إلى قاعدة البيانات
    $sql = "INSERT INTO reviews (name, text, rating) VALUES ('$name', '$text', $rating)";
    
    if ($conn->query($sql) === TRUE) {
        // إعادة التوجيه إلى الصفحة بعد الإدخال
        header("Location: Review.php");
        exit(); // تأكد من استخدام exit بعد header
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; // عرض خطأ في حالة فشل الإدخال
    }
}

// جلب الآراء من قاعدة البيانات
$sql = "SELECT * FROM reviews";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review and Rating</title>
    <link rel="website icon" type="png"  href="img/4660619.png">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1EMFlnCdhS3NB1I" crossorigin="anonymous">



    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        .navbar {
    background-color: #333 !important; /* ضمان تطبيق اللون */
    padding: 15px;
}

.navbar-nav {
    color:#fff;
    font-size: 28px !important;
    margin-left: auto;
    margin-right: 0;
}
.navbar-brand {
        color: #fff;
        font-size: 28px !important; /* تعديل حجم النص هنا */
        font-weight: bold;
    }

.navbar-nav .nav-link {
    color: #fff !important; /* ضمان تطبيق اللون الأبيض */
    margin-right: 20px;
    font-size: 18px;
}

.navbar-nav .nav-link:hover {
    color: gray !important; /* تغيير اللون عند التمرير */
}

        .form-group label {
            font-size: 18px;
            font-weight: bold;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 16px;
        }

        .star-rating {
            direction: rtl;
            display: inline-flex;
            justify-content: flex-end;
        }

        .star-rating input[type="radio"] {
            display: none;
        }

        .star-rating label {
            font-size: 30px;
            color: #ccc;
            cursor: pointer;
        }

        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #f5b301;
        }

        .btn-primary {
            background-color: #28a745;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        .reviews-container {
            margin-top: 30px;
        }

        .review-card {
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .review-card .card-header {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            font-size: 18px;
            border-radius: 10px 10px 0 0;
            padding: 15px;
        }

        .review-card .card-body {
            padding: 20px;
            font-size: 16px;
        }

        .card-text {
            margin-bottom: 10px;
            color: #555;
        }

        .card .card-body .rating {
            font-size: 20px;
            color: #f5b301;
        }

        h2 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
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






    <!-- Review Form -->
    <div class="container mt-5">
        <form id="reviewForm" action="Review.php" method="POST">
            <div class="form-group">
                <label for="reviewerName">Your Name</label>
                <input type="text" name="name" id="reviewerName" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="reviewText">Your Review</label>
                <textarea name="text" id="reviewText" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="rating">Rating</label>
                <div class="star-rating">
                    <input type="radio" id="star5" name="rating" value="5" required><label for="star5">&#9733;</label>
                    <input type="radio" id="star4" name="rating" value="4"><label for="star4">&#9733;</label>
                    <input type="radio" id="star3" name="rating" value="3"><label for="star3">&#9733;</label>
                    <input type="radio" id="star2" name="rating" value="2"><label for="star2">&#9733;</label>
                    <input type="radio" id="star1" name="rating" value="1"><label for="star1">&#9733;</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Submit Review</button>
        </form>
    </div>

    <!-- Display Reviews -->
    <div class="container reviews-container">
        <h2>Reviews</h2>
        <?php while($review = $result->fetch_assoc()): ?>
            <div class="card review-card">
                <div class="card-header">
                    <?php echo $review['name']; ?>
                </div>
                <div class="card-body">
                    <p class="card-text"><?php echo $review['text']; ?></p>
                    <div class="rating">Rating: <?php echo str_repeat('&#9733;', $review['rating']) . str_repeat('&#9734;', 5 - $review['rating']); ?></div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<script src="je.js"></script>
</body>
</html>
