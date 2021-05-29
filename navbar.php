<nav>
    <a href="index.php"><span style="float: left;color:white;font-size: 19px;">مدونة هلال</span></a>
    <div class="sign">
        <?php
        if (isset($_SESSION['email'])) {
            echo '<a href="logout.php"><button type="button" class="login-nav">تسجيل الخروج</button></a>';
        } else {
            echo '
            <a href="login.php"><button type="button" class="login-nav">تسجيل الدخول</button></a>
            <a href="register.php"><button type="button" class="register-nav">تسجيل حساب</button></a>
            ';
        }
        ?>
    </div>
</nav>