<div id="sidebar" class="col-md-4">
    <!-- search box -->
    <div class="search-box-container">
        <h4>Search</h4>
        <form class="search-post" action="search.php" method ="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search .....">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-danger">Search</button>
                </span>
            </div>
        </form>
    </div>
    <!-- /search box -->
    <!-- recent posts box -->
    <div class="recent-post-container">
        <h4>Recent Posts</h4>
        <?php
                    include 'config.php';
                    $limit = 5;
                    $sql = "SELECT  p.title,p.post_id,p.post_date,p.post_img,c.category_name,c.category_id FROM post p
                      LEFT JOIN category c ON p.category = c.category_id
                      ORDER BY p.post_id DESC LIMIT $limit";
                    $result=mysqli_query($conn,$sql) or die("can't fetch data".mysqli_connect_error());
                    if(mysqli_num_rows($result)>0){
                      while($row = mysqli_fetch_assoc($result)){
                    ?>
        <div class="recent-post">
            <a class="post-img" href="single.php?id=<?php echo $row['post_id']; ?>">
                <img src="admin/upload/<?php echo $row['post_img']; ?>" alt=""/>
            </a>
            <div class="post-content">
                <h5><a href="single.php?id=<?php echo $row['post_id']; ?>"><?php 
                if(strlen($row['title'])>60){
                    echo substr($row['title'],0,60)."...";
                }
                else{
                    echo substr($row['title'],0,60);
                }
                ?></a></h5>
                <span>
                    <i class="fa fa-tags" aria-hidden="true"></i>
                    <a href='category.php?cid=<?php echo $row['category_id']; ?>'><?php echo $row['category_name']; ?></a>
                </span>
                <span>
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <?php echo $row['post_date']; ?>
                </span>
                <a class="read-more" href="single.php?id=<?php echo $row['post_id']; ?>">read more</a>
            </div>
        </div>
        <?php
                      }
                    }else{
                        echo "No recent posts";
                    }
        ?>
    </div>
    <!-- /recent posts box -->
</div>
