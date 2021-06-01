<html>

<head>
    <title>اضافة عضو | هلال - الموقع العربي لأختصار الروابط</title>
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

        input[name="email-add"],
        input[name="pass-add"],
        select {
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
        <span style="text-align: center;font-size: 20px;color: white;margin-bottom: 3%;font-weight: bold;">اضافة عضو</span>
        <input type="email" name="email-add" placeholder="ادخل البريد الالكتروني">
        <input type="password" name="pass-add" placeholder="كلمة المرور">
        <select name="role">
            <option value="">--اختر الوظيفة--</option>
            <option value="Admin">مشرف</option>
            <option value="User">مستخدم</option>
        </select>
        <input type="submit" name="add" value="اضافة عضو">
        <?php
        if (isset($_SESSION['email'])) {
            $check = mysqli_query($connect, "SELECT * FROM users WHERE email = '$email'");
            if (mysqli_num_rows($check) > 0) {
                while ($row_check = mysqli_fetch_array($check)) {
                    $role = $row_check['role'];
                    if ($role == "Admin") {
                        if (isset($_POST['add'])) {
                            $email_add = $_POST['email-add'];
                            $pass = sha1($_POST['pass-add']);
                            $role = $_POST['role'];
                            if ($email_add !== "" && $pass !== "" && $role !== "") {
                                $sql = "INSERT INTO users (email, password, role) VALUES ('$email_add', '$pass', '$role')";
                                $query = mysqli_query($connect, $sql);
                                echo "<div class='alert alert-success'>تم انشاء الحساب</div>";
                            } else {
                                echo "<div class='alert alert-success'>قم بتعبئة جميع الحقول</div>";
                            }
                        }
                    } else {
                        header('Location: ./');
                    }
                }
            } else {
                header('Location: ./');
            }
        } else {
            header('Location: ./');
        }
        ?>

    </form>
</body>
<?php include('scripts.php') ?>

</html>