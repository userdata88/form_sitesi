<?php 
require_once ("v-db/db.php"); include_once("inc/menu.php");
if (!(empty($_GET["id"]))) {  
session_start();
    $profileid = $_GET["id"];
    $profile_conn = $conn->query("SELECT * FROM users WHERE id=$profileid");
    $profile_conn->execute([]);
    $profile = $profile_conn->fetch(PDO::FETCH_ASSOC);
    $profile_control=$profile_conn->rowCount();

    if (!$profile_control) {
        header("Location: http://".$_SERVER["SERVER_NAME"]."");
    }
    function pulldata($profile,$stat){
        echo'
            <section class="profile">
                <div class="container mt-5 bg-light">
                    <div class="row">
                        <div class="profile-title text-center"> Profile</div>
                        <div class="col-md-3">
                            <div class="profile-content mt-2">
                            <div class="profile-photo" style="border:1px solid lightgray;"><img src="'.@$profile["Photo"].'" alt="Profile Photos"></div>
                            <div class="profile-username mr-5"><a href="">@'.@$profile["Username"].'</a></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="profile-content2">
                            <div class="profile-subtitle1"><strong>My About</strong></div>
                            <p class="mt-2 profile-about">'.@$profile["About"].'</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="profile-content3">
                            <div class="profile-subtitle2"><strong>'.$stat.'</strong></div>
                            <div class="total-topic">Kayıt: <span class="text-secondary">'.@$profile["Registration_date"].'</span></div>
                            <div class="total-topic">Son Görülme: <span class="text-secondary">'.@$profile["Last_entry"].'</span></div>
                            <div class="total-topic">Toplam konu: <span class="text-secondary">'.@$profile["Total_topics"].'</span></div>
                            </div>
                        </div>
                        <div class="col-md-2 text-center mt-2">';
    }
    
    function pulldata2(){
        echo '
                            </div>
                        </div>
                    </div>
                </section>';
    }
    ?>
<!DOCTYPE html>
<html lang="<?php echo $forum_settings["Forum_lang"];?>">
<?php include_once("inc/head.php");?>
<body style="background-color:#dedede;">
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
                        if($_SESSION){
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
    <!--Menü son-->

<?php if (@$_SESSION['id'] == $profileid) {
    pulldata($profile,"My Stats");
echo '
            <a href="http://'.$_SERVER["SERVER_NAME"].'/settings.php"><i id="profile-edit" class="fa fa-cog ml-4" style="font-size:20px;">Settings</i></a>
            <a href="http://'.$_SERVER["SERVER_NAME"].'/topic.php"><i id="profile-write-topic" class="fa fa-edit ml-4 mt-3" style="font-size:18px;">write a topic</i></a>
';

pulldata2();
}
else{
    pulldata($profile,"Statistics");
    if(@$_SESSION["id"]){
    echo '

            <i class="fa fa-users ml-5" style="font-size:17px;">Arkadaş Ekle</i>';
    }
}
    pulldata2();
?>
<section class="signature">
    <div class="container mt-4 mb-5 bg-light">
        <div class="row">
            <div class="col-12">
                <div class="signature-title">Signature</div>
                <div class="signature-content">
                    <?php echo $profile["Signature"];?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once("inc/footer.php");?>

    </body>

</html>

    <?php
}
else {
    header("Location: http://".$_SERVER["SERVER_NAME"]."/");
}
?>



