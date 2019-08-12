<?php
include 'connect_db.php';

if (is_login() == false) {
	$_SESSION['error'] = "Niste ulogovani.";
    header("Location: /home");
    die();
} else {
    $proveri_servere = mysql_num_rows(mysql_query("SELECT * FROM `voiceservers` WHERE `user` = '$_SESSION[userid]'"));
    if (!$proveri_servere) {
        $_SESSION['info'] = "Nemate kod nas servera.";
        header("Location: /home");
        die();
    }
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
<?php include("style/gpmenu.php"); ?>

        <div id="server_info_infor">    
            <div id="server_info_infor">
                <div id="server_info_infor2">
                    <div class="space" style="margin-top: 20px;"></div>
                    <div class="gp-home">
                        <img src="/img/icon/gp/gp-server.png" alt="" style="margin-left:20px;">
                        <h2 style="margin-left: 6%;margin-top: -5%;">Serveri</h2>
                        <h3 style="font-size: 12px;margin-top: -1%;margin-left: 6%;">Lista svih vasih servera</h3>
                        <div class="space" style="margin-top: 60px;"></div>
                        
                        <div id="serveri">
                            <table class="darkTable">
                                <tbody>
                                    <tr>
                                        <th>Ime servera</th>
                                        <th>IP adresa</th>
                                        <th>Status</th>
                                    </tr>
                                    <?php  
                                        $gp_obv = mysql_query("SELECT * FROM `voiceservers` WHERE `user` = '$_SESSION[userid]'");

                                        while($row = mysql_fetch_array($gp_obv)) { 

                                            $srw_id = htmlspecialchars(mysql_real_escape_string(addslashes($row['voiceid'])));
                                            $naziv_servera = htmlspecialchars(mysql_real_escape_string(addslashes($row['name'])));
                                            $box_id = htmlspecialchars(mysql_real_escape_string(addslashes($row['boxid'])));
                                            $port = htmlspecialchars(mysql_real_escape_string(addslashes($row['port'])));
                                            $slotovi = htmlspecialchars(mysql_real_escape_string(addslashes($row['ip'])));


                                                $serverStatus = "<span style='color: green;'> Aktivan </span>";
                                          

                                           
                                        $igra = "img/icon/gp/game/ts3.ico";

                                            $server_ip = mysql_fetch_array(mysql_query("SELECT * FROM `box` WHERE `boxid` = '$box_id'"));
                                        ?>       
                                        <tr>
                                            <td>
                                                <img src="<?php echo $igra; ?>" style="width: 15px;">
                                                <a href="gp-voiceinfo.php?id=<?php echo $srw_id; ?>"><?php echo $naziv_servera ?></a>
                                            </td>
                                            <td class="ip"><?php echo $server_ip['ip'].':'.$port; ?></td>
                                            <td><div class="aktivan"><?php echo $serverStatus; ?></div></td>
                                        </tr>
                                    <?php } ?>                               
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="space" style="margin-bottom: 20px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Php script :) -->

    <?php include('style/footer.php'); ?>

    <?php include('style/pin_provera.php'); ?>

    <?php include('style/java.php'); ?>

</body>
</html>