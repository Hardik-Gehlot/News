<?php include "header.php"; ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
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
                  if($_SESSION['role']==1){
                    $sql = "SELECT  p.title,p.post_id,p.post_date,c.category_name,c.category_id,u.username FROM post p
                    LEFT JOIN category c ON p.category = c.category_id
                    LEFT JOIN user u ON p.author = u.user_id
                    ORDER BY p.post_id DESC LIMIT $offset,$adminPaginationLimit";
                  }else{
                    $sql = "SELECT  p.title,p.post_id,p.post_date,c.category_name,c.category_id,u.username FROM post p
                    LEFT JOIN category c ON p.category = c.category_id
                    LEFT JOIN user u ON p.author = u.user_id
                    WHERE p.author = {$_SESSION['user_id']}
                    ORDER BY p.post_id DESC LIMIT $offset,$adminPaginationLimit";
                  }
                  $result=mysqli_query($conn,$sql) or die("can't fetch data".mysqli_connect_error());
                  if(mysqli_num_rows($result)>0){
                  ?>
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                      <?php
                          while($row = mysqli_fetch_assoc($result)){
                          ?>
                          <tr>
                              <td class='id'><?php echo $row['post_id']; ?></td>
                              <td><?php echo $row['title']; ?></td>
                              <td><?php echo $row['category_name']; ?></td>
                              <td><?php echo $row['post_date']; ?></td>
                              <td><?php echo $row['username']; ?></td>
                              <td class='edit'><a href='update-post.php?id=<?php echo $row['post_id']; ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?id=<?php echo $row['post_id']; ?>&catid=<?php echo $row['category_id']; ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php } ?>
                      </tbody>
                  </table>
                  <?php }
                  $getDataQuery = "SELECT * FROM post";
                  $dataResult = mysqli_query($conn, $getDataQuery) or die("can't get data");
                  if(mysqli_num_rows($dataResult)>0){
                      $total = mysqli_num_rows($dataResult);
                      $totalPages = ceil($total / $adminPaginationLimit);
                      echo "<ul class='pagination admin-pagination'>";
                      if($page > 1){
                        echo "<li><a href='post.php?page=".($page-1)."'>Prev</a></li>";
                      }
                      for($i=1; $i<=$totalPages; $i++) {
                          if($i == $page){
                              $active = "active";
                          }
                          else{
                              $active = "";
                          }
                          echo "<li class=$active><a href='post.php?page=$i'>$i</a></li>";
                      }
                      if($page < $totalPages){
                        echo "<li><a href='post.php?page=".($page+1)."'>Next</a></li>";
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
