<?php
include 'config.php';
if($_SESSION['role']==0){
    header("Location: ".$hostname."admin/post.php");
}
$category_id = $_GET['id'];

$deleteCategory = "DELETE FROM category WHERE category_id = $category_id";
mysqli_query($conn, $deleteCategory) or die("can't delete Category");
header("Location: ".$hostname."admin/category.php");
?>