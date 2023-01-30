<?php include "header.php"; 
if($_SESSION['role']==0){
    header("Location: ".$hostname."admin/post.php");
}
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
            <?php
                  include 'config.php';
                  if(isset($_GET['page'])){
                    $page = $_GET['page'];
                  }
                  else{
                      $page = 1;
                  }
                  $offset = ($page-1)*$adminPaginationLimit;
                  $showUser = "SELECT * FROM category ORDER BY category_id DESC LIMIT $offset,$adminPaginationLimit";
                  $result=mysqli_query($conn,$showUser) or die("can't fetch data1".mysqli_connect_error());
                  if(mysqli_num_rows($result)>0){
                  ?>
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                          <?php
                          while($row = mysqli_fetch_assoc($result)){
                          ?>
                        <tr>
                            <td class='id'><?php echo $row['category_id']; ?></td>
                            <td><?php echo $row['category_name']; ?></td>
                            <td>0</td>
                            <td class='edit'><a href='update-category.php?id=<?php echo $row['category_id']; ?>'><i class='fa fa-edit'></i></a></td>
                            <td class='delete'><a href='delete-category.php?id=<?php echo $row['category_id']; ?>'><i class='fa fa-trash-o'></i></a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php }
                  $getDataQuery = "SELECT * FROM category";
                  $dataResult = mysqli_query($conn, $getDataQuery) or die("can't get data");
                  if(mysqli_num_rows($dataResult)>0){
                      $total = mysqli_num_rows($dataResult);
                      $totalPages = ceil($total / $adminPaginationLimit);
                      echo "<ul class='pagination admin-pagination'>";
                      if($page > 1){
                        echo "<li><a href='category.php?page=".($page-1)."'>Prev</a></li>";
                      }
                      for($i=1; $i<=$totalPages; $i++) {
                          if($i == $page){
                              $active = "active";
                          }
                          else{
                              $active = "";
                          }
                          echo "<li class=$active><a href='category.php?page=$i'>$i</a></li>";
                      }
                      if($page < $totalPages){
                        echo "<li><a href='category.php?page=".($page+1)."'>Next</a></li>";
                      }
                      echo "</ul>";
                  }
                  mysqli_close($conn);
                  ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
