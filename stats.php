<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet" />
  <title>هلال | الموقع العربي لأختصار الروابط</title>
  <link rel="stylesheet" href="./index.css" />
</head>

<body>
  <div class="app">
    <div class="form-container">
      <div class="card">
        <?php
        include('connection.php');
        $id = $_GET['id'];
        if (isset($_SESSION['email'])) {
          $email = $_SESSION['email'];
          $sql_check = mysqli_query($connect, "SELECT * FROM links WHERE email='$email' AND id='$id'");
          if (mysqli_num_rows($sql_check) > 0) {
          } else {
            header('Location: index.php');
          }
        } else {
          $ip = $_SERVER['REMOTE_ADDR'];
          $sql_check = mysqli_query($connect, "SELECT * FROM links WHERE ip='$ip' AND id='$id'");
          if (mysqli_num_rows($sql_check) > 0) {
          } else {
            header('Location: index.php');
          }
        }
        $sql = "SELECT * FROM links WHERE id = $id";
        $query = mysqli_query($connect, $sql);
        if (mysqli_num_rows($query) > 0) {
          while ($row = mysqli_fetch_array($query)) {
            $link = $row['link'];
            $title = $row['meta_title'];
            $desc = $row['meta_desc'];
            $pic = $row['meta_pic'];
            $views = $row['views'];
            $website = $row['website'];
            $code = $row['short_link'];
            $date = $row['date'];
            $time = $row['time'];
            echo '
            <div class="img-container" style="width:200px">
            <img class="pic" src="' . $pic . '" alt="' . $title . '" style="width:100%;object-fit:cover" />
            </div>
  
            <div class="info">
            <h1 class="card-title">' . $title . '</h1>
            <a href="' . $link . '">' . $link . '</a>
            <p class="description">' . $desc . '</p>  
            </div>
            ';
          }
        } else {
          header('Location: index.php');
        }
        ?>

      </div>
      <form method="POST">
        <input type="text" name="change-title" class="change-title" placeholder="العنوان" value="<?php echo $title ?>" required>
        <input type="text" name="change-desc" class="change-desc" placeholder="الوصف" value="<?php echo $desc ?>" required>
        <input type="url" name="change-pic" class="change-pic" placeholder="رابط الصورة" value="<?php echo $pic ?>" required>
        <button type="submit" name="change">حفظ التعديلات</button>
        <button type="submit" class="delete-link" name="delete">حذف الرابط نهائياً</button>
      </form>
      <?php
      if (isset($_POST['change'])) {
        $change_title = $_POST['change-title'];
        $change_desc = $_POST['change-desc'];
        $change_pic = $_POST['change-pic'];
        if ($change_title !== "" && $change_desc !== "" && $change_pic !== "") {
          $sql = "UPDATE links SET meta_title = '$change_title', meta_desc = '$change_desc', meta_pic = '$change_pic' WHERE id = $id";
          $query = mysqli_query($connect, $sql);
          echo "<div style='text-align: center;color: #00e800;font-weight: bold;'><i class='fad fa-check-circle'></i> تم تعديل خصائص الرابط</div>";
          
          $url_facebook = "https://developers.facebook.com/tools/debug/echo/?q=http://$website/$code";
          echo "<iframe width=0 height=0 marginwidth=0 marginheight=0 frameborder=0 name='theframe' target='_top' src='$url_facebook'>$url_facebook</iframe>";
        } else {
          echo "<div style='text-align: center;color: red;font-weight: bold;'><i class='fad fa-times-octagon'></i> برجاء عدم ترك حقل فارغ</div>";
        }
      }
      if (isset($_POST['delete'])) {
        $sql_delete = mysqli_query($connect, "DELETE FROM links WHERE id='$id'");
        echo '<script type="text/javascript">';
        echo 'alert("تم حذف الرابط نهائياً");';
        echo 'window.location.href = "index.php";';
        echo '</script>';
      }
      ?>
    </div>
    <div class="stats">

      <a href="index.php" style="text-align: left;display: flex;align-items: center;direction:ltr;font-size: 20px;font-weight: bold;">
        <i class="fad fa-arrow-circle-left" style="margin-right:0.5%"></i> Back
      </a>

      <div class="stats-container">
        <div class="cell">
          <div class="colorful">
            <img src="./bar-chart.svg" alt="Stats" />
            <h1>عدد الزيارات</h1>
            <h6><?php echo "$views" ?></h6>
          </div>
        </div>
        <div class="cell">
          <div class="colorful">
            <img src="./calendar.svg" alt="Stats" />
            <h1>التاريخ</h1>
            <h6><?php echo "$date" ?></h6>
          </div>
        </div>
        <div class="cell">
          <div class="colorful">
            <img src="./link-2.svg" alt="Stats" />
            <h1>الرابط الاصلي</h1>
            <h6><a href="<?php echo $link ?>"><?php echo "$link" ?></a></h6>
          </div>
        </div>
        <div class="cell">
          <div class="colorful">
            <img src="./link-2.svg" alt="Stats" />
            <h1>الرابط المختصر</h1>
            <h6 style="text-align: center;"><a href="<?php echo "http://$website/$code" ?>"><?php echo "$website/$code" ?></a></h6>
          </div>
        </div>
        <div class="cell full">
          <div class="colorful">
            <img src="./clock.svg" alt="Stats" />
            <h1>الوقت</h1>
            <h6 style="direction: ltr;"><?php echo "$time" ?></h6>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script>
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>
<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/1351.js"></script>
<script>
  $('.change-title').keyup(function() {
    $('.card-title').html($(this).val());
  })
  $('.change-desc').keyup(function() {
    $('.description').html($(this).val());
  })
  $('.change-pic').keyup(function() {
    var pic = document.querySelector(".change-pic").value;
    $(".pic").attr("src", pic);
  })
</script>

</html>