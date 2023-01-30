<?php
include "header.php";
include 'config.php';
if(isset($_FILES['fileToUpload'])){
    $error = array();
    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
    $file_ext = strtolower(end(explode(".", $file_name)));
    $extensions = array("jpeg","jpg","png");
    if(in_array($file_ext,$extensions)==false){
        $error[] = "This type of file is not allowed. Please upload jpg or PNG files.";
    }
    if($file_size > 5242880){
        $error[] = "File size must be less than 5MB";
    }
    if(empty($error)){
        move_uploaded_file($file_tmp,"upload/".$file_name);
    }
    else{
        print_r($error);
        die();
    }
}
    $title = mysqli_real_escape_string($conn,$_POST['post_title']);
    $description = mysqli_real_escape_string($conn,$_POST['postdesc']);
    $category = mysqli_real_escape_string($conn,$_POST['category']);
    $date = date("d M, Y");
    $author = $_SESSION['user_id'];

    $sql1 = 'INSERT INTO post (title,description,category,post_date,author,post_img) VALUES ("'.$title.'", "'.$description.'", "'.$category.'", "'.$date.'", "'.$author.'", "'.$file_name.'"); ';
    $sql1 .= "UPDATE category SET post=post+1 WHERE category_id=$category";
    // echo $sql1;
    // die();
    if(mysqli_multi_query($conn,$sql1)){
        header("Location: ".$hostname."admin/post.php");
    }
    else{
        echo "<div class='alert alert-danger'> Query Failed!</div>";
    }
    mysqli_close($conn);
?>