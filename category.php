<?php include 'header.php'; ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                  <?php
                  include 'config.php';
                  $cid = $_GET['cid'];
                  $getDataQuery = "SELECT * FROM category WHERE category_id=$cid";
                  $dataResult = mysqli_query($conn, $getDataQuery) or die("can't get data");
                  $total_records = mysqli_fetch_assoc($dataResult);
                  ?>
                  <h2 class="page-heading"><?php echo $total_records['category_name']; ?></h2>
                    <?php
                    if(isset($_GET['page'])){
                      $page = $_GET['page'];
                    }
                    else{
                      $page = 1;
                    }
                    $offset = ($page-1)*$adminPaginationLimit;
                    $sql = "SELECT  p.title,p.post_id,p.post_date,p.description,p.post_img,p.author,c.category_name,c.category_id,u.username FROM post p
                      LEFT JOIN category c ON p.category = c.category_id
                      LEFT JOIN user u ON p.author = u.user_id
                      WHERE p.category = $cid
                      ORDER BY p.post_id DESC LIMIT $offset,$adminPaginationLimit";
                    $result=mysqli_query($conn,$sql) or die("can't fetch data");
                    if(mysqli_num_rows($result)>0){
                      while($row = mysqli_fetch_assoc($result)){
                    ?>
                        <div class="post-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="post-img" href="single.php?id=<?php echo $row['post_id']; ?>"><img src="admin/upload/<?php echo $row['post_img']; ?>" alt=""/></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href='single.php?id=<?php echo $row['post_id']; ?>'><?php echo $row['title']; ?></a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href='category.php?cid=<?php echo $row['category_id']; ?>'><?php echo $row['category_name']; ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href='author.php?aid=<?php echo $row['author']; ?>'><?php echo $row['username']; ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo $row['post_date']; ?>
                                            </span>
                                        </div>
                                        <p class="description">
                                        <?php echo substr($row['description'],0,130)."..."; ?>
                                        </p>
                                        <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']; ?>'>read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                      }
                    }else{
                        echo "<h1>No Record Found.</h1>";
                    }
                  if(mysqli_num_rows($dataResult)>0){
                      $total = $total_records['post'];
                      $totalPages = ceil($total / $adminPaginationLimit);
                      echo "<ul class='pagination admin-pagination'>";
                      if($page > 1){
                        echo "<li><a href='category.php?cid=$cid&page=".($page-1)."'>Prev</a></li>";
                      }
                      for($i=1; $i<=$totalPages; $i++) {
                          if($i == $page){
                              $active = "active";
                          }
                          else{
                              $active = "";
                          }
                          echo "<li class=$active><a href='category.php?cid=$cid&page=$i'>$i</a></li>";
                      }
                      if($page < $totalPages){
                        echo "<li><a href='category.php?cid=$cid&page=".($page+1)."'>Next</a></li>";
                      }
                      echo "</ul>";
                  }
                  mysqli_close($conn);
                  ?>
                  </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
