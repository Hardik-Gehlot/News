<?php include "header.php";
include "config.php"; 
if(isset($_POST['submit'])){
    if(!isset($_FILES['new_image']['name'])){
        $file_name = $_POST['old_image'];
    }
    else{
        $error = array();
        $file_name = $_FILES['new_image']['name'];
        $file_size = $_FILES['new_image']['size'];
        $file_tmp = $_FILES['new_image']['tmp_name'];
        $file_type = $_FILES['new_image']['type'];
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
    $post_id = $_POST['post_id'];
    $title = mysqli_real_escape_string($conn,$_POST['post_title']);
    $description = mysqli_real_escape_string($conn,$_POST['postdesc']);
    $category = mysqli_real_escape_string($conn,$_POST['category']);

    $sql2 = "SELECT category FROM post WHERE post_id = $post_id";
    $result2 = mysqli_query($conn,$sql2) or die("Quiry Failed!");
    $row2 = mysqli_fetch_assoc($result2);
    $cat = $row2['category'];

    $sql1 = "UPDATE category SET post=post-1 WHERE category_id='$cat';";
    $sql1 .= "UPDATE post SET title='$title', description='$description', category='$category', post_img = '$file_name' WHERE post_id = $post_id;";
    $sql1 .= "UPDATE category SET post=post+1 WHERE category_id='$category'";
    if(mysqli_multi_query($conn,$sql1)){
        header("Location: ".$hostname."admin/post.php");
    }
    else{
        echo "<div class='alert alert-danger'> Query Failed!</div>";
    }
}
?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
    <?php
    if(isset($_GET['id'])){
      $postId = $_GET['id'];
    }
    else{
      $postId = $_POST['post_id'];
    }
    $sql = "SELECT  p.title,p.post_id,p.description,p.category,p.post_img,c.category_name FROM post p
    LEFT JOIN category c ON p.category = c.category_id
    LEFT JOIN user u ON p.author = u.user_id WHERE p.post_id = $postId";
    $result=mysqli_query($conn,$sql) or die("can't fetch data".mysqli_connect_error());
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
    ?>
        <!-- Form for show edit-->
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo $row['post_id']; ?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo $row['title']; ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="postdesc" class="form-control"  required rows="5"><?php echo $row['description']; ?>
                </textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputCategory">Category</label>
                <select class="form-control" name="category">
                <?php
                $sql1 = "SELECT * FROM category";
                $result1 = mysqli_query($conn,$sql1) or die("Query Failed!!");
                if(mysqli_num_rows($result1)>0){
                    while($row1 = mysqli_fetch_assoc($result1)){
                        if($row['category'] == $row1['category_id']){
                            $selected = "selected";
                        }
                        else{
                            $selected = "";
                        }
                        echo "<option $selected value='{$row1['category_id']}'> {$row1['category_name']} </option>";
                    }
                }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new_image">
                <img  src="upload/<?php echo $row['post_img']; ?>" height="150px">
                <input type="hidden" name="old_image" value="<?php echo $row['post_img']; ?>">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
        <!-- Form End -->
        <?php 
        }
        }
        mysqli_close($conn);
        ?>
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>