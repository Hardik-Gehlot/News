<?php
include "header.php";
include "config.php";
if($_SESSION['role']==0){
    header("Location: ".$hostname."admin/post.php");
}
if(isset($_POST['submit'])){
    $userId = $_POST['user_id'];
    $firstName = mysqli_real_escape_string($conn,$_POST['f_name']);
    $lastName = mysqli_real_escape_string($conn,$_POST['l_name']);
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $role = mysqli_real_escape_string($conn,$_POST['role']);

    $updateUser = "UPDATE user SET username = '$username',first_name = '$firstName',last_name = '$lastName',role = '$role' WHERE user_id = '$userId'";
    $searchUsername = "SELECT * FROM user WHERE username = '$username' AND user_id != '$userId'";
    
    $serachResult = mysqli_query($conn,$searchUsername) or die("can't update user".mysqli_connect_error());
    if(mysqli_num_rows($serachResult)>0){
        echo "<p> Username already exists. Choose another one.</p>";
    }
    else{
        $result = mysqli_query($conn,$updateUser) or die("can't add user".mysqli_connect_error());
        header("Location: ".$hostname."admin/users.php");
    }
}
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">
                  <!-- Form Start -->
                  <?php
                  if(isset($_GET['id'])){
                    $userId = $_GET['id'];
                  }
                  else{
                      $userId = $_POST['user_id'];
                  }
                  $showData = "SELECT * FROM user WHERE user_id=$userId";
                  $result = mysqli_query($conn, $showData) or die("can't get user data ".mysqli_connect_error());
                  while($row = mysqli_fetch_assoc($result)){
                  ?>
                  <form  action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="user_id"  class="form-control" value="<?php echo $row['user_id']; ?>" placeholder="" >
                      </div>
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" value="">
                              <?php
                              if($row['role']==1){
                                echo '<option value="0">normal User</option>
                                <option value="1" selected>Admin</option>';
                              }
                              else{
                                echo '<option value="0"selected>normal User</option>
                                <option value="1">Admin</option>';
                              }
                              ?>
                              
                          </select>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <?php 
                  }
                  mysqli_close($conn);
                  ?>
                  <!-- /Form -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
