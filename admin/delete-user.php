<?php
include 'config.php';
if($_SESSION['role']==0){
    header("Location: ".$hostname."admin/post.php");
}
$userId = $_GET['id'];

$deleteUser = "DELETE FROM user WHERE user_id = $userId";
mysqli_query($conn, $deleteUser) or die("can't delete user ");
header("Location: ".$hostname."admin/users.php");
?>