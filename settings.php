
<?php 
    session_start();
    require_once("v-db/db.php"); include_once("inc/menu.php");

    if(!(@$_GET["page"]==""|| @$_GET["page"]=="Profile" ||@$_GET["page"]=="Security")){
        header("location: http://".$_SERVER["SERVER_NAME"]."/settings.php");
    }

    if($_SESSION){
        $settings_id = $_SESSION["id"];
        $settings_ok=null;
        
       
    $settings_conn = $conn->query("SELECT * FROM users WHERE id=$settings_id");
    $settings_conn->execute([]);
    $settings = $settings_conn->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="<?php echo $forum_settings["Forum_lang"];?>">

    <?php
        include_once("inc/head.php");
        if ((@$_GET["page"]=="Profile" || @$_GET["page"]=="") && $_POST) {
            $profile_photo =  strip_tags($_POST["photo"]);
            $profile_about =  strip_tags($_POST["about"]);
            $profile_signature =  strip_tags($_POST["signature"]);
            $settings_profile = $conn->prepare("UPDATE users SET Photo=:photo, About=:about, Signature=:signature WHERE id=:id");
            $settings_profile->execute([":photo" => $profile_photo, ":about" => $profile_about, ":signature"=>$profile_signature, ":id" => $settings_id]);
            
            if($settings_profile){
                $settings_ok= '<p class="text-success">Profile saved successfully.</p>';
                header("refresh:2");
                ?> 
                <script>$(function(){$( "#disabled" ).prop("disabled",true);});</script>
                <?php
            }else {
                $settings_ok='<p class="text-danger">There was a problem, please contact the administrators.</p>';
            }
    }
        if (@$_GET["page"]=="Security" && $_POST) {
            $username =  strip_tags($_POST["username"]);
            $e_mail =  strip_tags($_POST["e-mail"]);
            $new_pass =  strip_tags($_POST["new-pass"]);
            $old_pass =  strip_tags($_POST["old-pass"]);
            if (empty($e_mail)) {
                $e_mail = $settings["E_mail"];
            }

            if (empty($new_pass) && empty($old_pass)) {
                if ($e_mail == $settings["E_mail"]&&$username== $settings["Username"]) {
                    $settings_ok= '<p class="text-danger">Your email address and username are the same.</p>';
                }
                else{
                $new_pass = $settings["Password"];
                settings($conn,$username,$e_mail,$new_pass,$settings_id);
                $settings_ok= '<p class="text-success">Profile saved successfully.</p>';
                header("refresh:2");
                ?> 
                <script>$(function(){$( "#disabled" ).prop("disabled",true);});</script>
                <?php
                }
            }
            elseif (empty($new_pass) && !(empty($old_pass))) {
                $settings_ok = '<p class="text-danger">Please enter the new password.</p>';
            }
            elseif (!(empty($new_pass)) && (empty($old_pass))) {
                $settings_ok = '<p class="text-danger">Please enter the old password.</p>';
            }
            elseif (!(empty($new_pass)) && !(empty($old_pass)) && $settings["Password"]!=md5($old_pass)) {
                $settings_ok= '<p class="text-danger">Please enter your old password correctly.</p>';
            }
            elseif (!(empty($new_pass)) && !(empty($old_pass)) && $settings["Password"]==md5($old_pass)) {
                if ($new_pass == $settings["Password"]) {
                    $settings_ok= '<p class="text-danger">Your new password is the same as your old password.</p>';
                }
                else{
                    $new_pass= md5($new_pass);
                settings($conn,$username,$e_mail,$new_pass,$settings_id);
                $settings_ok= '<p class="text-success">Profile saved successfully.</p>';
                ?> 
                <script>$(function(){$( "#disabled" ).prop("disabled",true);});</script>
                <?php
                header("refresh:2");
                }
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
    <!--Menu end-->
    
    <!--settings content-->
        <section>
            <div class="container mt-5 mb-5" style="border-radius:10px;">
                <div class="row">
                    <div class="categori-title text-center"> settings</div>
                    <div class="col-3 settings-bg">
                        <div class="settings-menu">
                        <a href="?page=Profile"><div class="settings-submenu"><p>Profile</p></div></a>
                        <a href="?page=Security"><div class="settings-submenu"><p>Registration Information</p></div></a>
                        </div>
                    </div>
                    <div class="col-9 settings-bg-2">
                        <?php
                            #Profile page#
                                $profile_page= '
                                <center><strong><div class="settings-subtitle">Profile</strong></center>
                                <form action="" method="post">
                                    <div class="row mt-4">
                                        <div class="col-3 mt-4">Profile Photo:</div>
                                        <div class="col-7 mt-4"><input type="url" name="photo" size="50" value="'.$settings["Photo"].'"></div>
                                        <div class="col-3 mt-4">My about:</div>
                                        <div class="col-7 mt-4"><textarea name="about" maxlength="255" cols="52" rows="4">'.$settings["About"].'</textarea></div>
                                        <div class="col-3 mt-4">Signature:</div>
                                        <div class="col-7 mt-4"><textarea name="signature" maxlength="255" cols="52" rows="4">'.$settings["Signature"].'</textarea></div>
                                        <div id="settings-ok" class="col-12 text-center">'.$settings_ok.'</div>
                                        <div id="settings-button" class="col-12 mt-4 text-center settings-button"><b><input id="disabled" type="submit" value="Save"></b></div>
                                    </div>
                                </form>';
                            #Profil page end#

                            #Pagination#
                                if (!(empty($_GET["page"]))) {

                                    #Security page#
                                        if ($_GET["page"]=="Security") {
                                            echo '<center><strong><div class="settings-subtitle">Security</strong></center>
                                            <form action="" method="post">
                                            <div class="row mt-4">
                                            <div class="col-3 ">Username:</div>
                                            <div class="col-7 "><input type="text" minlength="5" maxlength="32" name="username" id="" value="'.$settings["Username"].'"></div>
                                            <div class="col-3 mt-4">E-mail:</div>
                                            <div class="col-9 mt-4"><input type="email" name="e-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="'.$settings["E_mail"].'"/></div>
                                            <div class="col-3 mt-4">New Password:</div>
                                            <div class="col-7 mt-4"><input type="password" minlength="8" maxlength="32" name="new-pass" id=""></div>
                                            <div class="col-3 mt-4">Old password:</div>
                                            <div class="col-7 mt-4"><input type="password"  minlength="8" maxlength="32"  name="old-pass" id=""></div>
                                            <div id="settings-ok" class="col-12 text-center">'.$settings_ok.'</div>
                                            <div class="col-12 mt-4 text-center settings-button"><b><input id="disabled" type="submit" value="Save"></b></div>
                                            </form>
                                            ';}
                                    #Security page end#

                                    else{echo $profile_page;}
                                }else{echo $profile_page;}
                            #Pagination end#
                            
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <?php include_once("inc/footer.php");?>
        
    </body>
</html>
<?php }else{header("Location: http://".$_SERVER["SERVER_NAME"]."/logIn.php");}?>