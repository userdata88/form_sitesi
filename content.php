<?php 
session_start();
require_once ("v-db/db.php"); include_once("inc/menu.php");
if (empty($_GET["id"])) {
    header("Location: http://".$_SERVER["SERVER_NAME"]."");
}
else{
    $id2=@$_GET["id"];
$topic_conn=$conn->query("SELECT * FROM topics where id=$id2");
$topic_conn->execute([]);
$topic_fetch = $topic_conn->fetch(PDO::FETCH_ASSOC);
$author = $topic_fetch["Author"];
$topic_user_conn=$conn->query("SELECT * FROM users where id=$author");
$topic_user_conn->execute([]);
$topic_user_fetch = $topic_user_conn->fetch(PDO::FETCH_ASSOC);
$comments_conn=$conn->query("SELECT * FROM comments where Topic=$id2");
$comments_conn->execute([]);
$comments = $comments_conn->fetchAll(PDO::FETCH_ASSOC);



if(!@$_COOKIE["hits".$id2]) {
    $topic_update = $conn->prepare("UPDATE topics SET Hits=Hits+1 WHERE id=$id2");
    $topic_update->execute([]);
    setcookie("hits".$id2,"_",time()+5184000);
}
}
?>

<html lang="<?php echo $forum_settings["Forum_lang"];?>">
<meta charset="utf-8">
    <?php include_once("inc/head.php");
    if (@$_POST) {
        $comment_add_content= $_POST["comment-content"];
        $comment_add_author= $_SESSION["id"];
        $categori_comm=$topic_fetch["Categori"];
        $comment_add_conn=$conn->prepare("INSERT into comments set Author=?, Topic=?, Content=?, Categori=?");
        $comment_add_conn->execute([$comment_add_author,$id2,$comment_add_content,$categori_comm]);
        if ($comment_add_conn) {?>
            <script>$(document).ready(function () {
                $("#disabled").prop("disabled",true);
                $("#comment-ok").show().html('<div class="alert alert-success alert-dismissible"><a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success</strong> Your comment has been successfully added. you are being redirected...</div>');
              });</script>
              <?php
              header("refresh:3");
        }
    
    }
    ?>

    <body style="background-color:#dedede;">
    <!--Menü-->
        <nav class="container-fluid navbar-dark" style="background-color:#e32d2d">
            <a class="navbar-brand fw-bold" href="<?php echo $_SERVER["SERVER_NAME"];?>">Vihkon</a>
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
                        if(@$_SESSION["id"]){
                        #giriş bölümü menüsü
                            menu_profile(@$_SESSION["id"]);
                        }else{
                        #üye değilse
                            menu_login();
                        }
                        
                    ?>
                </div>
            </div>
        </nav>
    <!--Menü son-->
                    
<!--Index content-->
<section>
            <div class="container"style="border-radius:10px;">
                <div class="row">
                    <div class="col-md-9 mt-5">
                        <p class="ml-2" style="font-size:20px;color:gray">-<?php echo $topic_fetch["Title"];?></p>
                        <p class="ml-4" style="font-size:15px;color:gray"><?php echo substr($topic_fetch["Topic_date"],0,10);?></p>
                        <div class="row mt-3" style="min-height:300px;">
                            <div class="col-3 bg-light" style="border-right:1px solid lightgray;">
                                <div class="content-profil mt-2 text-center">
                                    <img src="<?php echo $topic_user_fetch["Photo"];?>">
                                    <a href="/profile.php/?id=<?php echo $author;?>"><div id="username">@<?php echo $topic_user_fetch["Username"];?></div></a>
                                    <div style="color:lightblack;font-size:12px">Registration date: <br><?php echo substr($topic_user_fetch["Registration_date"],0,10);?><br></div>
                                </div>
                            </div>
                            <div class="col-9 bg-light pt-3"><?php echo $topic_fetch["Content"];?></div>
                        </div>
                        <?php foreach ($comments as $comment) {
                            $author2 = $comment["Author"];
                            $comment_author_conn= $conn->query("SELECT * FROM users WHERE id=$author2");
                            $comment_author_conn->execute([]);
                            $comment_author = $comment_author_conn->fetch(PDO::FETCH_ASSOC);
                            ?>
                        <div class="row mt-3" style="min-height:300px;">
                            <div class="col-3 bg-light mt-5 mb-2" style="border-right:1px solid lightgray;">
                                <div class="content-profil mt-2 text-center">
                                    <img src="<?php echo $comment_author["Photo"];?>">
                                    <a href="/profile.php/?id=<?php echo $comment_author["id"];?>"><div>@<?php echo $comment_author["Username"];?></div></a>
                                    <div style="color:lightblack;font-size:12px">Registration date: <br><?php echo substr($comment_author["Registration_date"],0,10);?></div>
                                </div>
                            </div>
                            <div class="col-9 bg-light mt-5 mb-2 pt-3"><?php echo strip_tags($comment["Content"]);?></div>
                        </div>
                        <?php }?>
                        <div class="row mt-3 mb-5" >
                            <div class="col-3 bg-light mt-5 mb-2" style="border-right:1px solid lightgray;">
                                <div class="content-profil mt-2 mb-2 text-center">
                                    <img src="/image/comments.webp">
                                    
                                </div>
                            </div>
                                <div class="col-9 bg-light mt-5 mb-2" style="min-height:200px;"><form action="<?php if(@$_SESSION["id"]){echo '';}else{echo'/signup.php';}?>" method="post"><textarea class="mt-2" <?php if(@$_SESSION["id"]){echo'name="comment-content"';}?>minlength="100" style="width:100%;height:160px;resize:none;border-radius:5px;border:none;border: 0.1em solid gray"></textarea><input id="disabled" type="submit" style="position:absolute;right:5px;bottom:5px;border-radius:5px;padding-left:3px;padding-right:3px;background-color:#e32d2d;color:white;border:none;"Value="<?php if(@$_SESSION["id"]){echo 'Send';}else{echo'Sign up';}?>"></form></div>
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
    <div id="comment-ok" style="display:none;position:fixed;right:10px;top:30px"></div>
        </section>
    <!--Index content end-->
    <!--Index footer-->
        <?php include_once("inc/footer.php");?>
    <!--Index footer son-->
    </body>
    <style>

.topic-content{
background-color:white;
padding:5px;
border-radius:10px;
height:auto;

}
        </style>

</html>



