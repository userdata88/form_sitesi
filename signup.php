<?php 
require_once("v-db/db.php");?>

<!DOCTYPE html>
  <html >
  <head>
    <meta charset="UTF-8">
    <meta name="title" content="<?php echo $forum_settings["Forum_name"];?>">
    <meta name="description" content="<?php echo $forum_settings["Forum_description"];?>">
    <meta name="keywords" content="<?php echo $forum_settings["Forum_tags"];?>">
    <meta name="robots" content="index, nofollow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="css/loginstyle.css">
    <title><?php echo$forum_settings["Forum_name"]?></title>
</head>

  <?php

  $sign_ok = null;
  
  $signup_conn=$conn->prepare("insert into users set 
  Last_ip=?,
  username=?,
  E_mail=?,
  Password=?,
  Photo=?,
  Last_entry=now();");
  if(@$_POST["username"]){
 $ip=$_SERVER["REMOTE_ADDR"];
 $username=str_replace(' ', '', strip_tags($_POST["username"]));
 $e_mail=str_replace(' ', '', strip_tags($_POST["e-mail"]));
 $password=md5(str_replace(' ', '', strip_tags($_POST["password"])));
 $signup_control_conn= $conn->prepare("SELECT * FROM users WHERE E_mail=? or Username=?");
 $signup_control_conn ->execute([$e_mail,$username]);
 $signup_control_fetch = $signup_control_conn->fetch(PDO::FETCH_ASSOC);
 $signup_control=$signup_control_conn->rowCount();

 if(!$username | !$e_mail | !$password){

   $sign_ok='<p class="text-danger">Please fill in all fields.</p>';

 }elseif(strlen($username) <= 4){

  $sign_ok='<p class="text-danger">Username must be greater than 5 characters.</p>';

 }elseif(strlen($_POST["password"]) < 7){

  $sign_ok='<p class="text-danger">Password must be greater than 8 characters.</p>';

 }elseif($signup_control && $signup_control_fetch["Username"]==$username){

  $sign_ok='<p class="text-danger">Username already taken.</p>';

 }elseif($signup_control && $signup_control_fetch["E_mail"]==$e_mail){

  $sign_ok='<p class="text-danger">E-mail already taken.</p>';

 }else {

 $signup=$signup_conn->execute([$ip,$username,$e_mail,$password,"https://cdn.pixabay/,com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png"]);
 $sign_ok='<p class="text-success">You have successfully registered, you are being redirected...</p>';
 header("Refresh: 2; url=http://".$_SERVER["SERVER_NAME"]."/logIn.php");
 ?>
 <script>$(document).ready(function () {
  $("#login-ok").addClass("text-success");
  $("#login-ok").removeClass("text-danger");
  $(".buttons,.button,#hide").hide();
});</script><?php

 }


 }



?>
  
  <body>
    
  <div class="modal-wrap">
  
    <div class="modal-bodies">
      <div class="modal-body modal-body-step-1 is-showing">
        <a class="buttons" href="http://<?php echo $_SERVER["SERVER_NAME"];?>"><div style="color:gray;position:absolute;right:20px;top:15px">Anasayfaya dön</div></a>
        <div class="title">Sign up</div>
        <div id="hide" class="description">Hello...</div>
        <form id="hide" action="" method="post">
          <input type="text" name="username" maxlength="20" placeholder="Username"/>
          <input type="email"name="e-mail" maxlength="50" placeholder="E-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
            <input id="hide" type="password" maxlength="32" name="password" minlength="8" placeholder="Password">
                 <div class="col-md-4">
                          <div class="row text-center sign-with">
                              <div class="col-md-12">
                              </div>
                              <div class="col-md-12 sign-in28912">
                                  <div class="btn-group btn-group-justified">
  
                                  </div>
                              </div>
                          </div>
                      </div>
          <div class="text-center">
            <input type="submit" class="button" value="Sign up" style="border:1px solid #FF7361;">
                <a href="login.php"><div class="button">Login</div></a>
          </div>
        </form>
            <div id="sign-ok" class="mt-3 text-center"><?php echo $sign_ok;?></div>
      </div>
  
   
    </div>
  </div>
  
      
  
  </body>
  </html>