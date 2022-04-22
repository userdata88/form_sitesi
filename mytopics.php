<?php 
session_start();
require_once ("v-db/db.php");
include_once("inc/menu.php");


if(@$_SESSION["id"]){
    
$user_id=@$_SESSION["id"];
$topic = $conn->query("SELECT * FROM topics WHERE Author=$user_id ");
$topic->execute([]);
$topic_output = array_reverse($topic->fetchAll(PDO::FETCH_ASSOC));
?>
<!DOCTYPE html>
<html lang="<?php echo $forum_settings["Forum_lang"];?>">
    <?php include_once("inc/head.php");?>
    <body style="background-color:#dedede;">
    <style>
        .mytopics-edit>a{
            color:#373737;
        }
        .mytopics-edit>a:hover{
            color:gray;
        }
    </style>
    <!--Menü-->
        <nav class="container-fluid navbar-dark" style="background-color:#e32d2d">
            <a class="navbar-brand fw-bold" href="http://<?php echo $_SERVER['SERVER_NAME'];?>"><?php echo $forum_settings["Forum_name"]?></a>
            <div class="nav justify-content-end">
            <?php if (@$_SESSION["rank"]==1) {
                    echo '<a class="navbar-brand" href="/v-admin/">Admin Panel</a>';
                }?>
                <form action="" method="post" class="d-flex mt-3">
                    <input class="form-control me-2" type="search" placeholder="Konu ara" aria-label="Search"> 
                    <button type="submit" style="background-color:white;border:1px solid #e32d2d;margin-left:5px;height:40px;width:70px;border-radius:10px;margin-top:-3px;"><i  class="fa fa-search" style="font-size:20px;color:#e32d2d;"></i></button>
                </form>
                <div class=" login-buttons">
                    <?php 
                        if($_SESSION["id"]){
                        #giriş bölümü menüsü
                            menu_profile($_SESSION["id"]);
                        }else{
                        #üye değilse
                            menu_login();
                        }
                    ?>
                </div>
            </div>
        </nav>
        <!--Index content-->
        <section>
            <div class="container"style="border-radius:10px;min-height:600px">
                <div class="row">
                    <div class="col-md-12">
                        <div id="main">
                            <div class="topics" >
                                <div class="categori-title pl-5"> My Topics</div>
                                <div id="topic-title">
                                <div class="topic">
                                    <div class="row">
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
                                               
                                                <div class="col-sm-8 ml-5">
                                                    <div id="topic-title">
                                                        <h5 style="float:left;"><a href="content.php/?id=<?php echo $topicid2['id'];?>"><?php if(strlen($topicid2["Title"])<70){echo $topicid2["Title"];}else{echo substr($topicid2["Title"], 0, 70) . "...";} ?></a></h5>
                                                    </div>
                                                </div>
                                                
                                                    <div class="col-1 mt-2 mytopics-hits">
                                                        <i class="fa fa-eye" style="font-size:14px"> <?php echo $topicid2["Hits"];?> </i>
                                                    </div>
                                                    <div class="col-1 mt-2 mytopics-comments">
                                                        <i class="fa fa-comments-o" style="font-size:14px"> <?php echo $comments_number2;?> </i>
                                                    </div>
                                                    <div class="col-1 mt-2 mytopics-edit">
                                                         <a href='http://<?php echo$_SERVER["SERVER_NAME"]?>/topicedit.php/?id=<?php echo $topicid2["id"];?>' class="text-decoration-none ">Edit</a> 
                                                    </div>
                                            </div>
                                        </div><?php } if ($topic_number==0) {
                                ?>
                                <div id="topic-title">
                                <div class="topic">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h5>There is no topic</h5>
                                        </div>
                                    </div>
                                </div>
                                </div><?php }?>
                            </div>
                            
                        </div>
                            
                    </div>
                        
                     
                </div>
            </div>
        </section>
    <!--Index content end-->
    <?php include_once("inc/footer.php");?>
    </body>
</html>

<?php
#üye değilse
}else{
    header("Location: http://".$_SERVER["SERVER_NAME"]."");
}
#


?>