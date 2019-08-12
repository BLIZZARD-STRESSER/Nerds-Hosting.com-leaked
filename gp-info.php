<?php
include('connect_db.php');

if (is_login() == false) {
    $_SESSION['error'] = "Niste logirani!";
    header("Location: /home");
    die();
} else {
    $server_id = $_GET['id'];
    $proveri_server = mysql_num_rows(mysql_query("SELECT * FROM `serveri` WHERE `id` = '$server_id' AND `user_id` = '$_SESSION[userid]'"));

    $server = mysql_fetch_array(mysql_query("SELECT * FROM `serveri` WHERE `id` = '$server_id' AND `user_id` = '$_SESSION[userid]'"));
    $server_ip = mysql_fetch_array(mysql_query("SELECT * FROM `box` WHERE `boxid` = '$server[box_id]'"));

    if (!$proveri_server) {
        $_SESSION['error'] = "Taj server ne postoji ili nemate ovlaščenje za isti.";
        header("Location: /gp-home.php");
        die();
    }
}

//LGSL - SERVER INFO
require './inc/libs/lgsl/lgsl_class.php';

$ss_ip = $server_ip['ip'];
$ss_port = $server['port'];
$info = mysql_fetch_array(mysql_query("SELECT * FROM `lgsl` WHERE ip='$ss_ip' AND q_port='$ss_port' AND c_port='$ss_port'"));

if($server['igra'] == "1") { $igras = "halflife"; }
else if($server['igra'] == "2") { $igras = "samp"; }
else if($server['igra'] == "4") { $igras = "callofduty4"; }
else if($server['igra'] == "3") { $igras = "minecraft"; }
else if($server['igra'] == "5") { $igras = "mta"; }

if($server['igra'] == "5") {
    $serverl = lgsl_query_live($igras, $info['ip'], NULL, $server['port']+123, NULL, 's');
} else {
    $serverl = lgsl_query_live($igras, $info['ip'], NULL, $server['port'], NULL, 's');
}
if(@$serverl['b']['status'] == '1') {
    $server_onli = "<span style='color:#54ff00;'>Online</span>"; 
} else {
    if ($server['startovan'] == "1") {
        $server_onli = "<span style='color:red;'>Server je offline.</span>";
    } else {
        $server_onli = "<span style='color:red;'>Server je stopiran u panelu.</span>";
    }
}
$server_mapa = @$serverl['s']['map'];
$server_name = @$serverl['s']['name'];
$server_play = @$serverl['s']['players'].'/'.@$serverl['s']['playersmax'];

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
                <?php include('style/server_nav_precice.php'); ?>
                </div>
        <div id="server_info_infor">

            <div id="server_info_infor2">
                <!-- Server meni precice -->
                <div class="space" style="margin-top: 50px;"></div>

                <div class="server_infoInfo" style="max-width: 350px;border:1px solid;border-color: orangered;margin-left:5%;padding-left:2%;">
                    <h5><?php echo $jezik['27']; ?></h5>
                    <div class="SrwInfo_Info">
					                        <?php  
                            if (is_pin() == false) {
                                $provera_pin = "#pin-auth"; 
                            } else {
                                $provera_pin = "#edit_name";
                            }
                        ?> 
                        <label style="color: #bbb;font-size: 15px;"><?php echo $jezik['28']; ?>                            <strong style="color: orangered;">
                                <?php echo $server['name']; ?>
                                <button style="background:none;border:none;color:#fff;" type="button" data-toggle="modal" data-target="<?php echo $provera_pin; ?>"><span class="fa fa-edit"></span></button>
                            </strong></label>

                        <label style="color: #bbb;font-size: 15px;"><?php echo $jezik['29']; ?>                             <strong style="color: orangered;">
                                <?php echo $server['istice']; ?>
                                <a href="produzi.php?id=<?php echo $server['id']; ?>" style="background:none;border:none;color:#fff;"><span class="fa fa-edit"></span></a>
                            </strong></label> <br/>

                        <label style="color: #bbb;font-size: 15px;"><?php echo $jezik['30']; ?> <strong style="color: orangered;"><?php echo gp_igra($server['igra']); ?></strong></label>
                            <?php  
                                $location_ip = json_decode(file_get_contents("http://ip-api.com/json/".$ss_ip));
                                $ip_gp_lokacija = $location_ip->countryCode;
                                $ip_gp_loc_name = $location_ip->country;
                            ?>
                        <label style="color: #bbb;font-size: 15px;"><?php echo $jezik['31']; ?>                             <strong style="color: orangered;" title="<?php echo $ip_gp_loc_name; ?>" data-toggle="tooltip" data-placement="right">
                                <?php echo $ip_gp_lokacija; ?> 
                                <i class="fa fa-chevron-right" style="font-size: 15px;"></i>
                                <img src="img/icon/country/<?php echo $ip_gp_lokacija; ?>.png">
                            </strong></label> <br/>

                        <label style="color: #bbb;font-size: 15px;"><?php echo $jezik['32']; ?><strong style="color: orangered;"><?php echo $server_ip['ip'].':'.$server['port']; ?></strong></label>
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
                        <label style="color: #bbb;font-size: 15px;"><?php echo $jezik['33']; ?><strong style="color: orangered;"><?php echo $serverStatus; ?></strong></label>
                     </div>

<br>
                </div>

                <div class="server_infoInfo2" style="max-width: 350px;border:1px solid;border-color: orangered;    float: right;margin-top: -30%;margin-right: 10%;padding-left:2%;height:190px;width: 350px;margin-top: -258px;">
                    <h5 class="pc-icon"><?php echo $jezik['34']; ?></h5>
                    <div class="ServerInfoFTP">
                        <label style="color: #bbb;font-size: 15px;"><?php echo $jezik['35']; ?> <strong style="color: orangered;font-size: 13px;"><?php echo $server_ip['ip']; ?></strong></label><br/>

                        <label style="color: #bbb;font-size: 15px;"><?php echo $jezik['36']; ?> <strong style="color: orangered;font-size: 13px;">21</strong></label><br/>

                        <label style="color: #bbb;font-size: 15px;"><?php echo $jezik['37']; ?> <strong style="color: orangered;font-size: 13px;"><?php echo $server['username']; ?></strong></label>
                        <br/>

                        <label style="color: #bbb;font-size: 15px;"><?php echo $jezik['38']; ?>                             <strong style="color: orangered;font-size: 13px;">
                                <?php if (is_pin() == false) { ?>
                                   <?php echo $jezik['39']; ?>
                                   <i class="fa fa-chevron-right" style="font-size: 15px;"></i>
                                                               <?php if (is_pin() == false) { ?>
                            <a style="cursor: pointer;" type="button" data-toggle="modal" data-target="#pin-auth"><?php echo $jezik['40']; ?></a>
                            <?php } ?>
                                <?php } else { echo $server['password'];  ?>
                                                            <a style="cursor: pointer;" type="button" data-toggle="modal" data-target="#ftp-pw">Promeni FTP sifru</a> <?php } ?>
                            </strong></label>
                    </div>
                </div>
                
                <div class="server_infoInfo3" style="max-width: 350px;border: 1px solid;border-color: orangered;margin-left: 5%;padding-left: 2%;float: right;height: 285px;width: 350px;margin-right: 10%;margin-top:-5%;">
                    <h5 class="pc-icon">Server Status <button style="background: none; border:none;"><i class="fa fa-refresh"></i></button></h5>
                    <div class="ServerInfoFTP">
                        <label style="color: #bbb;font-size: 15px;"><?php echo $jezik['41']; ?></label>
                        <span><strong style="color: orangered;"><?php echo $server_onli; ?></strong></span> <br/>
                        <?php if ($server['startovan'] == "1") {
                            if (@$serverl['b']['status'] == '0') { ?>
                                <label style="color: #bbb;font-size: 15px;">Moguce resenje:</label>
                                <span><strong style="color: orangered;">Izbacite zadnji plugin koji ste dodali.</strong></span> <br/> 
                        <?php } } ?> 
                        <label style="color: #bbb;font-size: 15px;"><?php echo $jezik['43']; ?></label>
                        <span><strong style="color: orangered;"><?php echo $server_name; ?></strong></span> <br/>

                        <label style="color: #bbb;font-size: 15px;"><?php echo $jezik['44']; ?></label>
                        <span><strong style="color: orangered;"><?php echo $server_mapa; ?></strong></span> <br/>

                        <label style="color: #bbb;font-size: 15px;"><?php echo $jezik['45']; ?></label>
                        <span><strong style="color: orangered;"><?php echo $server_play; ?></strong></span> <br/>

                        <label style="color: #bbb;font-size: 15px;"><?php echo $jezik['46']; ?></label>
                        <span><strong style="color: orangered;"><?php echo $server['rank']; ?></strong></span> <br/>

                        <label style="color: #bbb;font-size: 15px;"><?php echo $jezik['47']; ?></label>
                        <span><strong style="color: orangered;"><?php echo mod_ime($server['mod']); ?></strong></span> <br/>
                    </div>
                </div>

                <div class="grafik" style="margin: 50px 0px 0px 25px;">
					 <h5 class="server-activity" style="color:#fff;font-size: 18px;">Banner by GameTracker.xyz</h5>
                     <a href="http://www.gametracker.xyz/server_info/<?php echo $server_ip['ip'];?>:<?php echo $server['port'];?>"><img style="background: transparent url(//i.imgur.com/iOLR4Iu.gif) center no-repeat;width: 45%;" src="http://nerds-hosting.com/api_baner.php?ip=<?php echo $server_ip['ip'];?>&port=<?php echo $server['port'];?>" alt="GRAFIK" class="grafik_img"></a>
				</div>
                
                <!-- server ftp precice -->
                <?php include('style/server_precice.php'); ?>
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