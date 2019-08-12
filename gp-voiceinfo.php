<?php
include('connect_db.php');

if (is_login() == false) {
    $_SESSION['error'] = "Niste logirani!";
    header("Location: /home");
    die();
} else {
    $server_id = $_GET['id'];
    $proveri_server = mysql_num_rows(mysql_query("SELECT * FROM `voiceservers` WHERE `voiceid` = '$server_id' AND `user` = '$_SESSION[userid]'"));

    $server = mysql_fetch_array(mysql_query("SELECT * FROM `voiceservers` WHERE `voiceid` = '$server_id' AND `user` = '$_SESSION[userid]'"));
    $server_ip = mysql_fetch_array(mysql_query("SELECT * FROM `box` WHERE `boxid` = '$server[boxid]'"));

    if (!$proveri_server) {
        $_SESSION['error'] = "Taj server ne postoji ili nemate ovlaščenje za isti.";
        header("Location: /gp-home.php");
        die();
    }
}
$igras = "ts";

if ($server_name == "") {
    $server_name = "n/a";
}
if ($server_mapa == "") {
    $server_mapa = "n/a";
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include ("assets/php/head.php"); ?>
<?php include('style/err_script.php'); ?>
<body>
		    <div id="content">
        <div id="TOP">
            <div id="header">
                <a id="logo" href="/"></a>
<?php include ("style/login_provera.php"); ?>
	            </div>
<?php include ("style/navigacija.php"); ?>
        </div>
<div id="wraper" style="background: rgba(0,0,0,0.7); box-sizing: border-box; max-width: 1002px; color: #fff !important; margin: 0px 0;">
    <div id="ServerBox">
<div id="gamenav">
                <ul>
    <li style="float:right;">
        <form action="voice_process.php?task=stop" method="POST">
            <input hidden="" type="text" name="voiceid" value="<?php echo $server_id; ?>">
            <button href="" class="start_btn" style="background:none;border:none;">
                <i class="glyphicon glyphicon-stop" style="font-size: 20px;"></i> Stop
            </button>
        </form>
    </li> 
    
    <li style="float:right;">
        <form action="voice_process.php?task=start" method="POST">
            <input hidden="" type="text" name="voiceid" value="<?php echo $server_id; ?>">
            <button href="" class="start_btn" style="background:none;border:none;">
                <i class="glyphicon glyphicon-play" style="font-size: 20px;"></i> Start
            </button>
        </form>
    </li> 
     </ul>                </div>
        <div id="server_info_infor">

            <div id="server_info_infor2">
                <!-- Server meni precice -->
                <div class="space" style="margin-top: 50px;"></div>

                <div class="server_infoInfo" style="max-width: 350px;border:1px solid;border-color: orangered;margin-left:5%;padding-left:2%;">
                    <h5>Informacije o serveru</h5>
                    <div class="SrwInfo_Info">
					                        <?php  
                            if (is_pin() == false) {
                                $provera_pin = "#pin-auth"; 
                            } else {
                                $provera_pin = "#edit_name";
                            }
                        ?> 
                        <label style="color: #bbb;font-size: 15px;">Ime servera:                            <strong style="color: orangered;">
                                <?php echo $server['name']; ?>
                                <button style="background:none;border:none;color:#fff;" type="button" data-toggle="modal" data-target="<?php echo $provera_pin; ?>"><span class="fa fa-edit"></span></button>
                            </strong></label>

                        <label style="color: #bbb;font-size: 15px;">Igra: <strong style="color: orangered;">TeamSpeak3</strong></label>
                            <?php  
                                $location_ip = json_decode(file_get_contents("http://ip-api.com/json/".$server_ip['ip']));
                                $ip_gp_lokacija = $location_ip->countryCode;
                                $ip_gp_loc_name = $location_ip->country;
                            ?>
                        <label style="color: #bbb;font-size: 15px;">Lokacija:                             <strong style="color: orangered;" title="<?php echo $ip_gp_loc_name; ?>" data-toggle="tooltip" data-placement="right">
                                <?php echo $ip_gp_lokacija; ?> 
                                <i class="fa fa-chevron-right" style="font-size: 15px;"></i>
                                <img src="img/icon/country/<?php echo $ip_gp_lokacija; ?>.png">
                            </strong></label> <br/>

                        <label style="color: #bbb;font-size: 15px;">IP adresa:<strong style="color: orangered;"><?php echo $server_ip['ip'].':'.$server['port']; ?></strong></label>
                        <br/>
                        <?php
                            $serverStatus = $server['status'];  
                            if ($serverStatus == "Aktivan") {
                                $serverStatus = "<span style='color: #54ff00;'> Aktivan </span>";
                            } else if($serverStatus == "Suspendovan") {
                                $serverStatus = "<span style='color: #ffd800;'> Suspendovan </span>";
                            } else {
                                $serverStatus = "<span style='color: red;'> Neaktivan </span>";
                            }
                        ?> 
                        <label style="color: #bbb;font-size: 15px;">GP-Status:<strong style="color: orangered;"><?php echo $serverStatus; ?></strong></label>
                     </div>

<br>
                </div>

                <div class="server_infoInfo2" style="max-width: 350px;border:1px solid;border-color: orangered;    float: right;margin-top: -30%;margin-right: 10%;padding-left:2%;height:95px;width: 350px;margin-top: -209px;">
                    <h5 class="pc-icon">User info</h5>
                    <div class="ServerInfoFTP">
                        <label style="color: #bbb;font-size: 15px;">TOKEN:                             <strong style="color: orangered;font-size: 13px;">
                                <?php if (is_pin() == false) { ?>
                                   [SAKRIVEN]
                                   <i class="fa fa-chevron-right" style="font-size: 15px;"></i>
                                                               <?php if (is_pin() == false) { ?>
                            <a style="cursor: pointer;" type="button" data-toggle="modal" data-target="#pin-auth">Prikazi TOKEN</a>
                            <?php } ?>
                                <?php } else { echo $server['password'];  ?>
                                                            <a style="cursor: pointer;" type="button" data-toggle="modal" data-target="#ftp-pw">Promeni TOKEN</a> <?php } ?>
                            </strong></label>
                    </div>
                </div>
                
                
                <!-- server ftp precice -->
                <div class="space" style="margin-top: 20px;"></div>
            </div>
        </div>
    </div>
    <!-- Php script :) -->

    <?php include('style/footer.php'); ?>

    <?php include('style/pin_provera.php'); ?>

    <?php include('style/java.php'); ?>

</body>
</html>