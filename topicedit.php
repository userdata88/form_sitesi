<?php
  session_start();
  require_once ("v-db/db.php"); include_once("inc/menu.php");
?>
<!DOCTYPE html>
<html lang="<?php echo $forum_settings["Forum_lang"];?>">
  <?php
  if ($_GET["id"]) {
    $topicid=$_GET["id"];
  }
  else {
    header("Location: http://".$_SERVER["SERVER_NAME"]."");
  }
    $topic_edit2 = $conn->query("SELECT * FROM topics WHERE id=$topicid");
    $topic_edit2->execute([]);
    $topic_show= $topic_edit2->fetch(PDO::FETCH_ASSOC);
    include_once("inc/head.php");
    $topic_ok=null;
    if($_SESSION){
      if (@$_POST["submit"]=="false") {#delete işlemi yapıyoor mert durden
        $query = $conn->prepare("DELETE FROM topics WHERE id = :id");
        $delete = $query->execute(['id' => $_GET['id']]);

        $comment_delete = $conn->prepare("DELETE FROM comments WHERE Topic =:Topic");
        $comment_delete2 = $comment_delete->execute(['Topic' => $_GET['id']]);
        $topic_ok= '<p class="text-success">Topic successfully deleted. you are being redirected...</p>';
        header("refresh:3 url=/mytopics.php");
          ?>
            <script>
              $(document).ready(function () {$("button").prop("disabled", true);});
            </script>
          <?php
      }
      elseif(@$_POST["submit"]=="true"){
        $title =  strip_tags($_POST["Title"]);
        $content =  strip_tags($_POST["Content"]);
        $Author = $_SESSION["id"];
        $topic_edit = $conn->prepare("UPDATE topics set Title=?, Content=? WHERE id=$topicid");
        $topic_edit->execute([$title,$content]);
        
        if ($topic_edit) {
          $topic_ok= '<p class="text-success">Topic successfully edited. you are being redirected....</p>';
          ?>
            <script>
              $(document).ready(function () {$("button").prop("disabled", true);});
            </script>
          <?php
          header("refresh:3 url=/mytopics.php");
        }else {
          $topic_ok='<p class="text-danger">A problem was encountered, please try again.</p>';
          ?>
            <script>
              $(document).ready(function () {
                $("button").prop("disabled", true);
              });
            </script>
          <?php
        }
      }
  ?>
  <body style="background-color:#dedede;">
    <!--Menu-->
    <nav class="container-fluid navbar-dark" style="background-color:#e32d2d">
      <a class="navbar-brand fw-bold" href="http://<?php echo $_SERVER['SERVER_NAME'];?>"><?php echo $forum_settings["Forum_name"]?></a>
      <div class="nav justify-content-end">
      <?php if (@$_SESSION["rank"]==1) {
                    echo '<a class="navbar-brand" href="/v-admin/">Admin Panel</a>';
                }?>
          <form action="" method="post" class="d-flex mt-3">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"> 
              <button type="submit" style="background-color:white;border:1px solid #e32d2d;margin-left:5px;height:40px;width:70px;border-radius:10px;margin-top:-3px;"><i  class="fa fa-search" style="font-size:20px;color:#e32d2d;"></i></button>
          </form>
          <div class=" login-buttons">
              <?php menu_profile($_SESSION["id"]);?>
          </div>
      </div>
    </nav>
    <!--Menu son-->
    <div class="container mt-5 mb-5 pt-5 pb-5 topic-edit">
      <form action="" method="post">
        <div class="form-group mt-3">
          <label><i class="material-icons"></i> Topic Title</label>
          <input type="text" class="form-control " name="Title" value="<?php echo $topic_show['Title'];?>">
        </div>
        <div class="form-group">
          <label>Topic content</label>
          <textarea class="form-control" name="Content" rows="3"><?php echo $topic_show["Content"];?></textarea>
        </div>
        <button id="form-button" name="submit" type="submit" class="btn btn-danger topicedit-save" value="true">Save</button>
        <button id="form-button" name="submit" class="btn btn-danger topicedit-save" value="false">Delete</button>
        <div id="topic-ok"><?php echo $topic_ok;?></div>
      </form>
      
    </div>
    <?php include_once("inc/footer.php");?>
  </body>
</html>

<?php }else{header("Location: http://".$_SERVER["SERVER_NAME"]."/logIn.php");}?>