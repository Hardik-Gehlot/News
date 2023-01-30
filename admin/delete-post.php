<?php
include 'config.php';
$postId = $_GET['id'];
$catid = $_GET['catid'];
$sql1 = "SELECT post_img FROM post WHERE post_id = $postId";
$result = mysqli_query($conn, $sql1);
$row = mysqli_fetch_assoc($result);
unlink("upload/".$row['post_img']);
$sql = "DELETE FROM post WHERE post_id = $postId;";
$sql .= "UPDATE category SET post = (post-1) WHERE category_id = $catid";
mysqli_multi_query($conn, $sql) or die("can't delete");
header("Location: ".$hostname."admin/post.php");
?>