<?php
include "header.php";
include "config.php";
if($_SESSION['role']==0){
    header("Location: ".$hostname."admin/post.php");
}
if(isset($_POST['save'])){
    $category = mysqli_real_escape_string($conn,$_POST['cat']);

    $addCategory = "INSERT INTO category(category_name) VALUES ('$category')";
    $searchCategoryName = "SELECT * FROM category WHERE category_name = '$category'";
    
    $serachResult = mysqli_query($conn,$searchCategoryName) or die("can't add category".mysqli_connect_error());
    if(mysqli_num_rows($serachResult)>0){
        echo "<p> Category already exists.</p>";
    }
    else{
        $result = mysqli_query($conn,$addCategory) or die("can't add category".mysqli_connect_error());
        header("Location: ".$hostname."admin/category.php");
    }
    mysqli_close($conn);
}
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add New Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off">
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat" class="form-control" placeholder="Category Name" required>
                      </div>
                      <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                  </form>
                  <!-- /Form End -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
