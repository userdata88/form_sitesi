<?php 
    session_start();

    require_once ("v-db/db.php"); include_once("inc/menu.php");

    $default_notopic= "none";  $d_showbutton= "none";
    if ($topic->rowCount() == 0) {$default_notopic= "block";}
    if ($topic->rowCount() > 10) {$d_showbutton= "block";}

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
                <form action="/search.php" method="post" class="d-flex mt-3">
                    <input class="form-control me-2" minlength="4" name="search-content" type="search" placeholder="Search topic" aria-label="Search"> 
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
                                <div class="categori-title"><i class="fa fa-star-o" aria-hidden="true"></i> New Topics</div>
                                <div id="topic-title">
                                <div class="topic">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h5 style="display:<?php echo $default_notopic;?>">There is no topic</h5>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                    <?php 
                                        $topic_number= 0;
                                        foreach ($topic_output as $topicid2) {
                                            $topic_author = $topicid2["Author"];
                                            $topic_comment=$topicid2["id"];
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
                                                        <h5 style="float:left;"><a href="content.php/?id=<?php echo $topicid2['id'];?>"><?php if(strlen($topicid2["Title"])<70){echo $topicid2["Title"];}else{echo substr($topicid2["Title"], 0, 70) . "...";} ?></a></h5>
                                                    </div>
                                                </div>
                                                
                                                    <div class="col-1 mt-2 index-hits">
                                                        <i class="fa fa-eye" style="font-size:14px"> <?php echo $topicid2["Hits"];?> </i>
                                                    </div>
                                                    <div class="col-1 mt-2 index-comments">
                                                        <i class="fa fa-comments-o" style="font-size:14px"> <?php echo $comments_number2;?> </i>
                                                    </div>
                                            </div>
                                        </div><?php }?>
                                    <center><button style="display:<?php echo $d_showbutton;?>" id="show-topic">Show more topics</button></center>
                                    <center><button id="hide-topic">Show less topics</button></center><?php }?>
                            </div>
                            <?php foreach ($categories_output2 as $cate) {
                                if($cate["Hide"] == 0){?>
                                    <div class="topics mt-4" style="border-radius:10px;">
                                        <div class="categori-title"> <?php echo $cate["Name"]; ?></div>
                                        <?php 
                                        $topic_number= 0;
                                        
                                        
                                        foreach ($topic_output2 as $topicid) {
                                            $topic_id = $topicid["Author"];
                                            if ($cate["id"] == $topicid["Categori"] && $topic_number <=9) {
                                                $topic_comment=$topicid2["id"];
                                                $topic_number++;
                                                $comments_number_conn=$conn->query("SELECT * FROM comments WHERE Topic=$topic_comment");
                                                $comments_number_conn->execute([]);
                                                $comments_number2=$comments_number_conn->rowCount();
                                                ?><div class="topic">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <div class="user-photo">
                                                            <a href="#"><img src="<?php
                                                            try {
                                                            $photo_author2 = $conn->query("SELECT * FROM users WHERE id=$topic_id");
                                                            $photo_author2->execute();
                                                            $photo3 = $photo_author2->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($photo3 as $photo4) {
                                                                echo $photo4["Photo"];
                                                            }
                                                            } catch (\Throwable $th) {}


                                                            ?>" alt="image"> </a> <a href="#"></a> 
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div id="topic-title">
                                                            <h5 style="float:left;"><a href="content.php/?id=<?php echo $topicid['id'];?>"><?php if(strlen($topicid["Title"])<70){echo $topicid["Title"];}else{echo substr($topicid["Title"], 0, 70) . "...";} ?></a></h5></div>
                                                        </div>
                                                        <div class="col-sm-1 mt-2 index-hits">
                                                            <i class="fa fa-eye" style="font-size:14px"> <?php echo $topicid["Hits"];?> </i>
                                                        </div>
                                                        <div class="col-sm-1 mt-2 index-comments">
                                                            <i class="fa fa-comments-o" style="font-size:14px"> <?php echo $comments_number2;?> </i>
                                                        </div>
                                                    </div>
                                                </div><?php
                                        
                                        
                                            }
                                        
                                    
                                        }
                                        if ($topic_number ==0) {
                                            echo'<div class="topic">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h5>There is no topic</h5>
                                                    </div>
                                                </div>
                                            </div>';
                                        }?>
                                
                                    </div><?php }
                                else {
                                    continue;
                                }
                            }?>
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