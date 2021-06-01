<nav>
    <a href="index.php"><span style="float: left;color:white;font-size: 19px;">مدونة هلال</span></a>
    <div class="sign">
        <?php
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $sql = mysqli_query($connect, "SELECT * FROM users WHERE email='$email'");
            while($row = mysqli_fetch_array($sql)) {
                $role = $row['role'];
                if($role == "Admin") {
                    echo '<a href="add-user.php"><button type="button" class="login-nav">اضافة عضو</button></a>';
                }
            }
            echo '
            <a href="logout.php"><button type="button" class="login-nav">تسجيل الخروج</button></a>
            ';
        } else {
            echo '
            <a href="login.php"><button type="button" class="login-nav">تسجيل الدخول</button></a>
            ';
        }
        ?>
    </div>
</nav>