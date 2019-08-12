<?php
include 'connect_db.php';

if (is_login() == false) {
    $_SESSION['error'] = "Niste ulogovani.";
    header("Location: /home");
    die();
} else {
    $server_id = $_GET['id'];
    $proveri_server = mysql_num_rows(mysql_query("SELECT * FROM `serveri` WHERE `id` = '$server_id' AND `user_id` = '$_SESSION[userid]'"));

    $server = mysql_fetch_array(mysql_query("SELECT * FROM `serveri` WHERE `id` = '$server_id' AND `user_id` = '$_SESSION[userid]'"));
    
    if (!$proveri_server) {
        $_SESSION['error'] = "Taj server ne postoji ili nemas ovlascenje za isti.";
        header("Location: /gp-home.php");
        die();
    }

    $info = mysql_fetch_array(mysql_query("SELECT * FROM `box` WHERE `boxid` = '$server[box_id]'"));
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
                <div class="space" style="margin-top: 20px;"></div>

                <div id="ftp_container">
                    <div id="ftp_header">
											<div id="left_header">
                            <div>
                                <img src="/img/icon/gp/gp-plugins.png" style="margin-left:10px;">
                            </div> 
						<h2 style="margin-left: 6%;margin-top: -5%;">Modovi</h2>
                        <h3 style="font-size: 12px;margin-top: -1%;margin-left: 6%;">Ovde mozete instalirati ili obrisati modove sa vaseg servera.</h3>
                        <div class="space" style="margin-top: 60px;"></div>
                        </div>
                        
                    </div>              
                    <div id="plugin_body">
                        <?php  
                            $gp_mods = mysql_query("SELECT * FROM `modovi` WHERE `igra` = '$server[igra]'");

                            while($row = mysql_fetch_array($gp_mods)) { 

                                $mod_id = htmlspecialchars(addslashes($row['id']));
                                $ime = htmlspecialchars(addslashes($row['ime']));
                                $opis = htmlspecialchars(addslashes($row['opis']));
                                $mod_putanja = htmlspecialchars(addslashes($row['putanja']));

                            if ($server['mod'] == $mod_id) { ?>
                                    <p><strong><?php echo $ime; ?></strong></p>

                                    <p><?php echo nl2br($opis); ?></p>
                                    <form id="form" style="float:right;margin-top: -3%;" action="?instaliran" method="POST">
                                        <input hidden type="text" name="mod_id" value="<?php echo $mod_id; ?>">
                                        <input hidden type="text" name="server_id" value="<?php echo $server['id']; ?>">
                            <a href="javascript:{}" onclick="document.getElementById('form').submit();"><div class="divbutton" >INSTALIRAN</div></a>
                                    </form>                            
                            <?php } else { ?>
                                    <p><strong><?php echo $ime; ?></strong></p>

                                    <p><?php echo nl2br($opis); ?></p>
                                    <?php
                                        $mmod_token = $_SERVER['REMOTE_ADDR'].'_p_'.randomSifra(100);
                                        $_SESSION['mmod_token'] = $mmod_token;
                                    ?>
                                    <form id="form" action="process.php?task=promeni_mod" method="POST">
                                        <input hidden type="text" name="mod_id" value="<?php echo $mod_id; ?>">
                                        <input hidden type="text" name="server_id" value="<?php echo $server['id']; ?>">
                                        <input hidden type="text" name="mmod_token" value="<?php echo $mmod_token; ?>">
                            <a href="javascript:{}" onclick="document.getElementById('form').submit();"><div class="divbutton">INSTALIRAJ</div></a>
                                    </form>                            
                            <?php } ?>
                        <?php } ?>
                    </div>
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