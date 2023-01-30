<?php
include 'config.php';
$page = basename($_SERVER['PHP_SELF']);
switch($page){
    case "single.php":
        if(isset($_GET['id'])){
            $sql_title = "SELECT title FROM post WHERE post_id = {$_GET['id']}";
            $result_title = mysqli_query($conn, $sql_title) or die("Query Failed");
            $row_title = mysqli_fetch_assoc($result_title);
            $page_title = $row_title['title'];
        }
        else{
            $page_title = "No Result Found";
        }
        break;
    case "search.php":
        if(isset($_GET['search'])){
            $page_title = $_GET['search'];
        }
        else{
            $page_title = "No Result Found";
        }
        break;
    case "author.php":
        if(isset($_GET['aid'])){
            $sql_title = "SELECT username FROM user WHERE user_id = {$_GET['aid']}";
            $result_title = mysqli_query($conn, $sql_title) or die("Query Failed");
            $row_title = mysqli_fetch_assoc($result_title);
            $page_title = $row_title['username'];
        }
        else{
            $page_title = "No Result Found";
        }
        break;
    case "category.php":
        if(isset($_GET['cid'])){
            $sql_title = "SELECT category_name FROM category WHERE category_id = {$_GET['cid']}";
            $result_title = mysqli_query($conn, $sql_title) or die("Query Failed");
            $row_title = mysqli_fetch_assoc($result_title);
            $page_title = $row_title['category_name'];
        }
        else{
            $page_title = "No Result Found";
        }
        break;
    default:
    $page_title = "News";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title." - News" ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class=" col-md-offset-4 col-md-4">
                    <a href="index.php" id="logo"><img src="images/news.jpg"></a>
                </div>
                <!-- /LOGO -->
            </div>
        </div>
    </div>
    <!-- /HEADER -->
    <!-- Menu Bar -->
    <div id="menu-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
             if(isset($_GET['cid'])){
                 $cid = $_GET['cid'];
             }
             include 'config.php';
             
             $sql = "SELECT * FROM category WHERE post > 0";
             $result=mysqli_query($conn,$sql) or die("can't fetch data".mysqli_connect_error());
                 if(mysqli_num_rows($result)>0){
                     $active = "";
                     $active_home = "";
                    if(isset($_GET['cid'])){
                        $active_home = "";
                    }
                    else{
                        $active_home = "active";
                    }
             ?>
                    <ul class='menu'>
                    <li><a class="<?php echo $active_home; ?>" href='<?php echo $hostname; ?>'>Home</a></li>
                        <?php
                        // echo "<li><a class='{$active_home}' href='{$hostname}'>Home</a></li>";
                        while($row = mysqli_fetch_assoc($result)){
                            if(isset($_GET['cid'])){
                                if($row['category_id']==$cid){
                                    $active = "active";
                                }else{
                                    $active = "";
                                }
                            }
                    echo "<li><a class='{$active}' href='category.php?cid={$row['category_id']}'>{$row['category_name']}</a></li>";
                    } ?>
                    </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /Menu Bar -->