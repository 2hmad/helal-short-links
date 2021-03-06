<!DOCTYPE html>
<html>

<head>
    <?php include('links.php') ?>
    <?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    $address = $_SERVER['REQUEST_URI'];
    $u = preg_match("/[^\/]+$/", $address, $matches);
    if (isset($matches[0])) {
        $word = $matches[0];
        if ($word == "login.php") {
            header('Location: login.php');
        } elseif ($word == "register.php") {
            header('Location: register.php');
        } elseif ($word == "index.php") {
            header('Location: ./');
        } elseif ($word == "add-user.php") {
            header('Location: add-user.php');
        } elseif ($word == "robots.txt") {
            header('Location: robots.txt');
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

                    <meta property="fb:app_id" content="2732149070222866" />

    <?php           
                    
                    header('Refresh: 0; URL=' . $link);
                    die();
                }
            } else {
                header('Location: ./');
            }
        }
    }
    ?>

    <style>
        form input[type="url"] {
            width: 80%;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #CCC;
            outline: none;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        form select {
            width: 80%;
            padding: 10px;
            border-radius: 10px;
            outline: none;
            border: 1px solid #CCC;
            margin-top: 3%;
            margin-bottom: 5%;
        }

        form input[type="submit"] {
            background: #1277ee;
            border: 1px solid #1277ee;
            padding: 10px;
            width: 150px;
            border-radius: 10px;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        form button {
            padding: 10px;
            width: 150px;
            border-radius: 10px;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        table {
            width: 100%
        }

        table tr {
            height: 50px;
        }

        .otherButton {
            background: transparent;
            border: none;
            color: white;
            outline: none;
            margin-left: auto;
            display: block
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100" style="background-image: url('pics/background.jpg');background-size: cover;background-repeat: no-repeat;">
    <?php include('navbar.php') ?>
    <div class="container">
        <div class="row" style="margin-top: 10%;">
            <div class="col-lg" style="text-align:center;align-self: center;">
                <p style="font-weight:bold;text-transform: uppercase;color: white;font-size: 35px;">?????????? ????????????</p>
                <p style="font-weight:300;text-transform: uppercase;color: white;font-size: 15px;">???????????? ???????????????? ??????
                    ???????????????? ??????????????</p>
                <form method="POST">
                    <input type="url" name="url-short" placeholder="???????????? ???????????? ??????????????">
                    <select name="url-option">
                        <option value="">???????? ?????????? ????????????????</option>
                        <option>lckerava.net</option>
                        <option>lv0.xyz</option>
                    </select>
                    <?php
                    if (isset($_SESSION['email'])) {
                        echo '<input type="submit" name="short" value="????????????">';
                    } else {
                        echo '<button type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="???????? ?????????? ???????????? ????????" disabled>??????????</button>';
                    }
                    ?>

                </form>
                <?php
                if (isset($_POST['short'])) {
                    $url = $_POST['url-short'];
                    $option = $_POST['url-option'];
                    if ($url !== "" && $option !== "") {
                        $check_num = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM links WHERE link='$url'"));
                        $length = 8;
                        $random = substr(str_shuffle('0123456789AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz'), 1, $length);
                        $short_link = "$random";

                        $ip = $_SERVER['REMOTE_ADDR'];

                        $metas = get_meta_tags($url);

                        function getTitle($url)
                        {
                            $page = file_get_contents($url);
                            $title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $page, $match) ? $match[1] : null;
                            return $title;
                        }

                        // Meta Description => <meta property="og:description" content="">
                        $metaDesc = $metas['description'];

                        function page_title($url)
                        {
                            $fp = file_get_contents($url);
                            if (!$fp)
                                return null;

                            $res = preg_match("/<title>(.*)<\/title>/siU", $fp, $title_matches);
                            if (!$res)
                                return null;

                            $title = preg_replace('/\s+/', ' ', $title_matches[1]);
                            $title = trim($title);
                            return $title;
                        }

                        // Meta title => <meta property="og:title" content="">
                        $metaTitle = page_title("$url");

                        $html = file_get_contents('' . $url . '');
                        preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', $html, $matches);
                        $picture_path = $matches[1][0];

                        // Meta image => <meta property="og:image" content="">
                        $metaPic = "$picture_path";

                        date_default_timezone_set("Africa/Cairo");
                        $current_date = date("Y/m/d");
                        $current_time = date("h:i A");

                        if (isset($_SESSION['email'])) {
                            $email = $_SESSION['email'];
                        } else {
                            $email = "";
                        }
                        $sql = "INSERT INTO links (email, link, short_link, website, date, time, meta_title, meta_desc, meta_pic, ip) VALUES ('$email', '$url', '$short_link', '$option', '$current_date', '$current_time', '$metaTitle', '$metaDesc', '$metaPic', '$ip')";
                        $query = mysqli_query($connect, $sql);
                        if ($query) {
                            echo "<div class='alert alert-success' style='margin-top:2%'>???? ?????????? ???????????? ??????????????</div>";
                        }
                    }
                }
                ?>
            </div>
            <div class="col-lg">
                <div class="urls">
                    <span style="color:white;font-weight:bold;text-transform:capitalize">?????? ?????????????? ????????????????</span>
                    <table style="color:white;margin-top:5%">
                        <?php
                        $ip = $_SERVER['REMOTE_ADDR'];
                        if (isset($_SESSION['email'])) {
                            $email = $_SESSION['email'];
                            $sql_select = "SELECT * FROM links WHERE email='$email' OR ip='$ip'";
                        } else {
                            $sql_select = "SELECT * FROM links WHERE ip='$ip'";
                        }
                        $query_select = mysqli_query($connect, $sql_select);
                        if (mysqli_num_rows($query_select) > 0) {
                            while ($row = mysqli_fetch_array($query_select)) {
                                $id = $row['id'];
                                $short_link = $row['short_link'];
                                $website = $row['website'];
                                echo '
                                    <tr>
                                        <th>
                                            <a href="stats.php?id=' . $id . '" style="float: left;">' . $short_link . '</a>
                                            <button class="otherButton"><i class="far fa-paste"></i></button>
                                        </th>
                                    </tr>
                                ';
                            }
                        } else {
                            echo '<caption>???? ???????? ?????????? ????????????</caption>';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include('footer.php') ?>
</body>
<?php include('scripts.php') ?>
<script>
    var a = document.getElementsByClassName('otherButton');

    for (var i = 0; i < a.length; i++) {
        a[i].addEventListener('click', function() {
            var b = this.parentNode.parentNode.cells[0].textContent;
            copyToClipboard(b);
            alert("Copied to clipboard!");
        });
    }

    function copyToClipboard(text) {
        var dummy = document.createElement("textarea");
        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand("copy");
        document.body.removeChild(dummy);
    }
</script>

</html>