<!DOCTYPE html>
<html>

<head>
    <title>هلال | الموقع العربي لأختصار الروابط</title>
    <?php include('links.php') ?>
    <?php
    if (isset($_GET['u'])) {
        include('connection.php');
        $u = mysqli_real_escape_string($connect, $_GET['u']);
        $query_fetch = mysqli_query($connect, "SELECT * FROM links WHERE short_link='$u'");
        if (mysqli_num_rows($query_fetch) > 0) {
            while ($row_fetch = mysqli_fetch_array($query_fetch)) {
                $link = $row_fetch['link'];
                $title = $row_fetch['meta_title'];
                $desc = $row_fetch['meta_desc'];
                $pic = $row_fetch['meta_pic'];
                $views = $row_fetch['views'];
                $total_views = $views + 1;
                $sql_update = mysqli_query($connect, "UPDATE links SET views = $total_views WHERE short_link='$u'");
                echo "$title";
                echo "$desc";
                echo "$pic";

                header('Location: ' . $link);
            }
        }
    }
    ?>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include('navbar.php') ?>
    <div class="container">
        <div class="row" style="margin-top: 5%;">
            <div class="col-lg">
                <div class="modify-url">
                    <div class="card mb-3" style="max-width: 540px;">
                        <?php
                        $id = $_GET['id'];
                        $sql = "SELECT * FROM links WHERE id = $id";
                        $query = mysqli_query($connect, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            $link = $row['link'];
                            $title = $row['meta_title'];
                            $desc = $row['meta_desc'];
                            $pic = $row['meta_pic'];
                            echo '
                            <div class="row g-0">
                            <div class="col-md-4">
                                <img style="width:100%;object-fit:cover" src="'.$pic.'" alt="'.$title.'">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">'.$title.'</h5>
                                    <p class="card-text"><small class="text-muted">'.$link.'</small></p>
                                    <p class="card-text" style="font-size: 13px;">'.$desc.'</p>
                                </div>
                            </div>
                        </div>
                        ';
                        } 
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg">

            </div>
        </div>
    </div>
    <?php include('footer.php') ?>
</body>
<?php include('scripts.php') ?>

</html>