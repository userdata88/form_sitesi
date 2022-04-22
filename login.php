<?php 
  require_once("v-db/db.php");?>
<!DOCTYPE html>
<html lang="<?php echo $forum_settings["Forum_lang"];?>">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="title" content="<?php echo $forum_settings["Forum_name"];?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta name="description" content="<?php echo $forum_settings["Forum_description"];?>">
        <meta name="keywords" content="<?php echo $forum_settings["Forum_tags"];?>">
        <meta name="robots" content="index, nofollow">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title><?php echo$forum_settings["Forum_name"]?></title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
     <link rel="stylesheet" href="css/loginstyle.css">
</head>
<?php
  session_start();
  $login_ok=null;
  if (empty($_SESSION["name"])) {
    if ($_POST) {
      $e_mail = $_POST["E-mail"];
      $password = md5($_POST["Password"]);
      if (empty($e_mail) || empty($password)) {
        $login_ok="Please fill in all fields.";
      }
      else{
      $login_conn= $conn->prepare("SELECT * FROM users WHERE E_mail=? and Password=?");
      $login_conn ->execute([$e_mail,$password]);
      $login = $login_conn->fetch(PDO::FETCH_ASSOC);
      $login_succ=$login_conn->rowCount();
      if($login_succ){
        //giriş kısmı 
          $_SESSION["id"] = $login["id"];
          $_SESSION["name"] = $login["Username"];
          $_SESSION["rank"] = $login["Rank"];
          $login_ok="You have successfully logged in, you are being redirected...";
          header("refresh:3 url=http://".$_SERVER["SERVER_NAME"]."");
          ?>
          <script>$(document).ready(function () {
            $(".button").prop("disabled",true);
            $("#login-ok").addClass("text-success");
            $("#login-ok").removeClass("text-danger");
            $(".buttons,.button,#hide").hide();
          });</script>
          <?php
        
        }else{
        $login_ok = "The entered information does not match.";
        }
      }
    }
  }
  else {
    header("Location: http://".$_SERVER["SERVER_NAME"]."");
  }
?>
  <body>

    <div class="modal-wrap">
      <div class="modal-bodies">
        <div class="modal-body modal-body-step-1 is-showing">
        <a class="buttons" href="http://<?php echo $_SERVER["SERVER_NAME"];?>"><div style="color:gray;position:absolute;right:20px;top:15px">Anasayfaya dön</div></a>
          <div class="title">Login</div>
          <form action="" method="post">
            <input id="hide"  maxlength="50" placeholder="E-mail" name="E-mail" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
            <input id="hide"  maxlength="32" type="password" placeholder="Password" name="Password"/>
            <div class="text-center">
              <input class="button" type="submit" style="border:1px solid #dedede;" value="Login">
                <a class="buttons" href="signup.php"><div class="button">Sign up</div></a>
                <p id="login-ok" class="text-danger mt-3"><?php echo $login_ok;?></p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
