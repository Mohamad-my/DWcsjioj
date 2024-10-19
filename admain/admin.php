

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
</head>
<style>
    body{
        margin: 0;
        padding: 0;
        background-color:#f4f4f4 ;
    }
    .container{
        width: 400px;
        margin: 80px auto;
        padding: 30px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1{
        text-align: center;
        margin-bottom: 20px;
    }
    h3{
        text-align: center;
        margin-bottom: 20px;
    }
    form{
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    label{
        display: block;
        margin-bottom: 5px;
    }
    input[type="text"], input[type="email"] {
        width: 90%;
        padding: 10px;
        border: 1px solid #ccc;
        margin-bottom: 15px;
    }
    button{
        width: 100%;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        cursor: pointer;
    }
</style>
<body>
    <main>
        <?php
        session_start();
        include('../include/connected.php');
        

       @$ADemail = $_POST['email'];
       @$ADpassword = $_POST['password'];
       @$ADadd = $_POST['add'];

        if (isset($ADadd)) {
            if (empty($ADemail) || empty($ADpassword)) {
                echo '<script>alert("الرجاء ادخال البريد الالكتروني و كلمة السر");</script>';
            } else { 
                $query = "SELECT * FROM admin WHERE EMAIL = '$ADemail' AND PASSWORD = '$ADpassword'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);
                    var_dump($row);  // تحقق من البيانات المُعادة من قاعدة البيانات
                    $_SESSION['EMAIL'] = $ADemail;
                    header("Refresh:2; url=admainbanel.php");
                    exit();
                } 
                 else {
                    echo '<script>alert("ليس مسموح لك دخول هذه الصفحة، سوف يتم تحويلك الى المتجر");</script>';
                    header("REFRESH:2; URL=../index.php");
                }
            }
        }
        ?>
        <div class="container">
            <h1>تسجيل الدخول</h1>
                <h3>هذه الصفحة مخصصة ل الاداري فقط</h3>
            <form action="admin.php" method="post">
                <label for="em">البريد الالكتروني</label>
                <input type="email" name="email" id="em">
                <br>
                <label for="pass">الرقم السري</label>
                <input type="text" name="password" id="pass">
                <br>
                <button type="submit" name="add">تسجيل الدخول</button>
            </form>
        </div>
    </main>
</body>
</html>


