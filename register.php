<html>

<head>
    <title>انشاء حساب | هلال - الموقع العربي لأختصار الروابط</title>
    <?php include('links.php') ?>
    <style>
        form {
            background: linear-gradient(to right, #f7bb97, #dd5e89);
            max-width: 500px;
            padding: 15px;
            border-radius: 5px;
            text-align: right;
            min-height: 355px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-top: 6%;
            margin-right: auto;
            margin-left: auto;
        }

        nav {
            background: #404040;
        }

        input[name="email-register"],
        input[name="pass-register"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #CCC;
            border-radius: 5px;
            display: block;
            margin-bottom: 4%;
            outline: none;
        }

        input[type="submit"] {
            padding: 10px;
            background: #1277ee;
            color: white;
            border: 1px solid #1277ee;
            border-radius: 5px;
            margin-right: auto;
            margin-left: auto;
            display: block;
        }
    </style>
</head>

<body>
    <?php include('navbar.php') ?>
    <form method="POST" style="text-align: right;">
        <span style="text-align: center;font-size: 20px;color: white;margin-bottom: 3%;font-weight: bold;">تسجيل حساب جديد</span>
        <input type="email" name="email-register" placeholder="ادخل البريد الالكتروني" required>
        <input type="password" name="pass-register" placeholder="كلمة المرور" required>
        <input type="submit" name="register" value="انشاء حساب">
        <span style="text-align: center;position: relative;top: 20px;">لديك حساب بالفعل ؟ <a href="login.php" style="text-decoration: underline !important;">تسجيل الدخول</a></span>
        <?php
        if (isset($_SESSION['email'])) {
            header('Location: ./');
        }

        if (isset($_POST['register'])) {
            $email = $_POST['email-register'];
            $pass = sha1($_POST['pass-register']);
            if ($email !== "" && $pass !== "") {
                $sql_check = mysqli_query($connect, "SELECT * FROM users WHERE email='$email'");
                if (mysqli_num_rows($sql_check) > 0) {
                    echo "<div class='alert alert-danger'>لقد قمت بتسجيل هذا البريد من قبل</div>";
                } else {
                    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$pass')";
                    $query = mysqli_query($connect, $sql);
                    echo "<div class='alert alert-success'>تم تسجيل هذا الحساب بنجاح ، يرجي <a href='login.php'>تسجيل الدخول</a></div>";
                }
            } else {
                echo "<div class='alert alert-danger'>لا تترك حقول فارغة</div>";
            }
        }
        ?>
    </form>
</body>
<?php include('scripts.php') ?>

</html>