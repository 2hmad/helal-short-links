<!DOCTYPE html>
<html>
<head>
    <?php include('connection.php') ?>
    <?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    $address = $_SERVER['REQUEST_URI'];
    $u = preg_match("/[^\/]+$/", $address, $matches);
    if (isset($matches[0])) {
        $word = $matches[0];
        if ($word == "login.php") {
            header('Location: http://lckerava.net/login.php');
        } elseif ($word == "register.php") {
            header('Location: http://lckerava.net/register.php');
        } elseif ($word == "index.php") {
            header('Location: http://lckerava.net/');
        } elseif ($word == "add-user.php") {
            header('Location: http://lckerava.net/add-user.php');
        } else {
            $query_fetch = mysqli_query($connect, "SELECT * FROM links WHERE short_link='$word'");
            if (mysqli_num_rows($query_fetch) > 0) {
                while ($row_fetch = mysqli_fetch_array($query_fetch)) {
                    $link = $row_fetch['link'];
                    $title = $row_fetch['meta_title'];
                    $desc = $row_fetch['meta_desc'];
                    $pic = $row_fetch['meta_pic'];
                    $views = $row_fetch['views'];
                    $total_views = $views + 1;
                    $sql_update = mysqli_query($connect, "UPDATE links SET views = $total_views WHERE short_link='$word'");
    ?>
                    <meta name="description" content="<?php echo $desc ?>">
                    <meta property="og:type" content="website">
                    <meta property="og:url" content="<?php echo $link ?>">
                    <meta property="og:title" content="<?php echo $title ?>">
                    <meta property="og:description" content="<?php echo $desc ?>">
                    <meta property="og:image" content="<?php echo $pic ?>">

                    <meta property="twitter:card" content="summary_large_image">
                    <meta property="twitter:url" content="<?php echo $link ?>">
                    <meta property="twitter:title" content="<?php echo $title ?>">
                    <meta property="twitter:description" content="<?php echo $desc ?>">
                    <meta property="twitter:image" content="<?php echo $pic ?>">
    <?php
                    header('Refresh: 1; URL=' . $link);
                }
            } else {
                header('Location: http://lckerava.net/');
            }
        }
    }
    ?>
</html>