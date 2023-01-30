<?php
include "header.php";
include "config.php";
if($_SESSION['role']==0){
    header("Location: ".$hostname."admin/post.php");
}
if(isset($_POST['submit'])){
    $catId = $_POST['cat_id'];
    $catName = mysqli_real_escape_string($conn,$_POST['cat_name']);

    $updateCategory = "UPDATE category SET category_name = '$catName' WHERE category_id = '$catId'";
    $searchCategoryName = "SELECT * FROM category WHERE category_name = '$catName' AND category_id != '$catId'";
    
    $serachResult = mysqli_query($conn,$searchCategoryName) or die("can't search data".mysqli_connect_error());
    if(mysqli_num_rows($serachResult)>0){
        echo "<p> Category name already exists. Choose another one.</p>";
    }
    else{
        $result = mysqli_query($conn,$updateCategory) or die("can't update category.".mysqli_connect_error());
        header("Location: ".$hostname."admin/category.php");
    }
}
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
              <?php
                  if(isset($_GET['id'])){
                    $categoryId = $_GET['id'];
                  }
                  else{
                      $categoryId = $_POST['cat_id'];
                  }
                  $showData = "SELECT * FROM category WHERE category_id=$categoryId";
                  $result = mysqli_query($conn, $showData) or die("can't get category data ".mysqli_connect_error());
                  while($row = mysqli_fetch_assoc($result)){
                  ?>
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="cat_id"  class="form-control" value="<?php echo $row['category_id']; ?>" placeholder="">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" value="<?php echo $row['category_name']; ?>"  placeholder="Category Name" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <?php 
                  }
                  mysqli_close($conn);
                  ?>
                </div>
              </div>
            </div>
          </div>
<?php include "footer.php"; ?>
