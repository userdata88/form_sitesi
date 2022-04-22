<?php
  session_start();
  require_once ("v-db/db.php"); include_once("inc/menu.php");
?>
<!DOCTYPE html>
<html lang="<?php echo $forum_settings["Forum_lang"];?>">

  <?php
    include_once("inc/head.php");
    $topic_ok=null;
    if($_SESSION){
      if ($_POST) {
        $title =  strip_tags($_POST["Title"]);
        $content =  strip_tags($_POST["Content"]);
        $categories =  strip_tags($_POST["Categories"]);
        $Author = $_SESSION["id"];
        $topic_upload = $conn->prepare("INSERT into topics set Title=?, Content=?, Categori=?,Author=?");
        $topic_upload->execute([$title,$content,$categories,$Author]);
        
        if ($topic_upload) {
          $topic_ok= '<p class="text-success">Added as a topic.  you are being redirected...</p>';
          ?>
            <script>
              $(document).ready(function () {$("#form-button").prop("disabled", true);});
            </script>
          <?php
          header("refresh:3 url=/mytopics.php");
        }else {
          $topic_ok='<p class="text-danger">A problem was encountered, please try again.';
          ?>
            <script>
              $(document).ready(function () {
                $("#form-button").prop("disabled", true);
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
    <div class="container mt-5 mb-5 pt-5 pb-5 topic2">
      <form action="" method="post">
        <div class="form-group">
          <label><i class="material-icons"></i> Topic Title</label>
          <input type="text" class="form-control " name="Title" placeholder="Example: how to set up a website?">
        </div>
        <div class="form-group">
          <label>Topic content</label>
          <textarea class="form-control" name="Content" rows="3"></textarea>
        </div>
        <div class="form-group">
          <label>Topic categories</label>
          <select class="form-control" name="Categories" id="Topic-categori">
            <?php foreach($categories_output2 as $categ){
                    echo '<option value="'.$categ["id"].'">'.$categ["Name"].'</option>';
                  }?>
          </select>
        </div>
        <button id="form-button" type="submit" class="btn btn-danger">Save</button>
        <div id="topic-ok"><?php echo $topic_ok;?></div>
      </form>
    </div>
    <?php include_once("inc/footer.php");?>
    
  <script>$(document).ready(function () {
    $("#form-button").click(function(){
      setTimeout(() => {
        
      $("#form-button").prop("disabled", true);
      }, 1);

    });
  });</script>
  </body>
</html>

<?php }else{header("Location: http://".$_SERVER["SERVER_NAME"]."/logIn.php");}?>