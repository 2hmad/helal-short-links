<html>

<head>
    <title>تسجيل الدخول | هلال - الموقع العربي لأختصار الروابط</title>
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

        input[name="email-login"],
        input[name="pass-login"] {
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
        <span style="text-align: center;font-size: 20px;color: white;margin-bottom: 3%;font-weight: bold;">تسجيل الدخول</span>
        <input type="email" name="email-login" placeholder="ادخل البريد الالكتروني">
        <input type="password" name="pass-login" placeholder="كلمة المرور">
        <div><input type="checkbox" name="stay-login" id="stay-login"><label style="margin-right: 1%;color:white" for="stay-login">تذكرني</label></div>
        <input type="submit" name="login" value="تسجيل الدخول">
        <span style="text-align: center;position: relative;top: 20px;">أليس لديك حساب ؟ <a href="register.php" style="text-decoration: underline !important;">انشئ حسابك الان</a></span>
        <?php
        if(isset($_SESSION['email'])) {
            header('Location: ./');
        }
        if (isset($_POST['login'])) {
            $email = $_POST['email-login'];
            $pass = sha1($_POST['pass-login']);
            if ($email !== "" && $pass !== "") {
                $sql_check = mysqli_query($connect, "SELECT * FROM users WHERE email='$email' AND password='$pass'");
                if (mysqli_num_rows($sql_check) > 0) {
                    $_SESSION['email'] = $email;
                    echo "<div class='alert alert-success'>تم تسجيل الدخول بنجاح سيتم نقلك خلال 5 ثوان</div>";
                    header('Refresh: 5; URL=./');
                } else {
                    echo "<div class='alert alert-danger'>لا توجد حساب بهذه البيانات برجاء <a href='register.php'>تسجيل حساب</a></div>";
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