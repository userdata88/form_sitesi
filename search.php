<?php 
    session_start();

    require_once ("v-db/db.php"); include_once("inc/menu.php");

    if ($_POST) {
    $search_content=strip_tags($_POST["search-content"]);
    $topic_search_conn= $conn->prepare("SELECT * FROM topics WHERE Title LIKE ? or Content LIKE ?");
    $topic_search_conn->execute(["%$search_content%","%$search_content%"]);
    $topic_search= $topic_search_conn->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="<?php echo $forum_settings["Forum_lang"];?>">
    <?php include_once("inc/head.php");?>

    <body style="background-color:#dedede;">
    <!--Menu-->
        <nav class="container-fluid navbar-dark" style="background-color:#e32d2d">
            <a class="navbar-brand fw-bold" href="http://<?php echo $_SERVER['SERVER_NAME'];?>"><?php echo $forum_settings["Forum_name"]?></a>
            <div class="nav justify-content-end">
                <?php if (@$_SESSION["rank"]==1) {
                    echo '<a class="navbar-brand" href="/v-admin/">Admin Panel</a>';
                }?>
                <form action="" method="post" class="d-flex mt-3">
                    <input class="form-control me-2" type="search" placeholder="Search topic" aria-label="Search"> 
                    <button type="submit" style="background-color:white;border:1px solid #e32d2d;margin-left:5px;height:40px;width:70px;border-radius:10px;margin-top:-3px;"><i  class="fa fa-search" style="font-size:20px;color:#e32d2d;"></i></button>
                </form>
                <div class=" login-buttons">
                    <?php 
                        if(@$_SESSION["id"]){
                        #login menu
                            menu_profile($_SESSION["id"]);
                        }else{
                        #if not logged in
                            menu_login();
                        }
                    ?>
                </div>
            </div>
        </nav>
    <!--Menu end-->

    <!--Index content-->
        <section>
            <div class="container"style="border-radius:10px;">
                <div class="row">
                    <div class="col-md-9">
                        <div id="main">
                            <div class="topics" ><?php if ($forum_settings["Forum_new_topics"]==1) {
                                ?>
                                <div class="categori-title">Searched:</i> <?php echo $search_content;?></div>
                                <div id="topic-title">
                               
                                </div>
                                    <?php 
                                        $topic_number= 0;
                                        foreach ($topic_search as $topiclist) {
                                            $topic_author = $topiclist["Author"];
                                            $topic_comment=$topiclist["id"];
                                                $topic_number++;
                                                $comments_number_conn=$conn->query("SELECT * FROM comments WHERE Topic=$topic_comment");
                                                $comments_number_conn->execute([]);
                                                $comments_number2=$comments_number_conn->rowCount();
                                            ?><div class="topic <?php if ($topic_number > 10) {
                                                echo 'show-more';
                                            }else{echo'';}?>">
                                            <div class="row">
                                                <div class="col-1">
                                                    <div class="user-photo">
                                                        <a href="#"><img src="<?php 
                                                        
                                                            try {
                                                                $photo_author = $conn->query("SELECT * FROM users WHERE id=$topic_author");
                                                                $photo_author->execute();
                                                                $photo = $photo_author->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach ($photo as $photo2) {
                                                                echo $photo2["Photo"];
                                                                }
                                                            } catch (\Throwable $var) {}


                                                        ?>" alt="image"> </a> <a href="#"></a> </div>
                                                    </div>
                                                <div class="col-sm-8">
                                                    <div id="topic-title">
                                                        <h5 style="float:left;"><a href="content.php/?id=<?php echo $topiclist['id'];?>"><?php if(strlen($topiclist["Title"])<70){echo $topiclist["Title"];}else{echo substr($topiclist["Title"], 0, 70) . "...";} ?></a></h5>
                                                    </div>
                                                </div>
                                                
                                                    <div class="col-1 mt-2 index-hits">
                                                        <i class="fa fa-eye" style="font-size:14px"> <?php echo $topiclist["Hits"];?> </i>
                                                    </div>
                                                    <div class="col-1 mt-2 index-comments">
                                                        <i class="fa fa-comments-o" style="font-size:14px"> <?php echo $comments_number2;?> </i>
                                                    </div>
                                            </div>
                                        </div><?php }?>
                                        <div class="topic">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h5 style="display:<?php if($topic_number==0) {echo 'block';}else{echo 'none';}?>">There is no topic</h5>
                                        </div>
                                    </div>
                                </div>
                                    <?php }?>
                            </div>
                            
                        </div>
                            
                    </div>
                        
                        
                    <aside class="col-md-3 sidebar">
                        <div class="categories">
                            <h4>Categories</h4>
                            <ul>
                                <?php foreach ($categories_output as $categoriid) {
                                    echo '<li><a href="#">'.$categoriid["Name"].'</a></li>';
                                }?>      
                            </ul>
                        </div>
                        <div class="Sponsor" style="min-height:300px">
                            <h4>Sponsor</h4>
                            <?php echo $forum_settings["Forum_sponsor"];?>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
    <!--Index content end-->
    <!--Index footer-->
        <?php include_once("inc/footer.php");?>
    <!--Index footer end-->
    <script>
        $(document).ready(function () {
            $(".show-more").hide();
            $("#show-topic").click(function () {
                $(".show-more").show();
                $("#show-topic").hide();
                $("#hide-topic").show();
            });
            $("#hide-topic").click(function () {
                $(".show-more").hide();
                $("#show-topic").show();
                $("#hide-topic").hide();
            });
        });
    </script>
    </body>

</html>