<?php
include_once("connect_db.php");
header('Content-Type: charset=UTF-8');
?>
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
        <div id="rotacalc">
            <div id="rotator">
              <div id="bgrot" class="stepcarousel">
                <div class="belt" style="width: 587px; left: 0px;">
                    <div class="panel">
                        <div id="rot-1">
                            <div id="title">
                                <div id="left">
                                <h3>Counter Strike Global Offenssive</h3>
                                Narucite CS:GO Server već danas lokacije Premium i Lite
                                </div>
                                <a id="right" href="https://www.facebook.com/nerdshosting/"></a>
                            </div>
                        </div>
                    </div>
                     <div class="panel">
                        <div id="rot-2" style="background:url(https://i.imgur.com/L67t3kL.jpg);">
                            <div id="title">
                                <div id="left">
                                <h3>Counter Strike 1.6 2019</h3>
Skinite Counter Strike 1.6 2019 zaštićen od svih slowhackova
                                </div>
                                <a id="right" href="http://cs.gametracker.xyz/"></a>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
						<div id="calc">
				<div id="left"><?php echo $jezik['2']; ?></div>
				<select id="cgame" class="gameList">
				</select>
				<div id="left" style="display:none;"><?php echo $jezik['3']; ?></div>
				<select style="display:none;" id="cgame" class="locList">
				</select>
				<div id="left"><?php echo $jezik['3']; ?></div>
				<select id="cgame" class="typeList">
				</select>
				<div id="left"><?php echo $jezik['4']; ?></div>
				<div id="cgo">
				<select id="cslots" class="slotList">
				</select>
				<a href="#"></a>
				</div>
			</div>
                    </div>
                    <div id="wraper" style="background: rgba(0,0,0,0.7); box-sizing: border-box; max-width: 1002px; color: #fff !important; margin: 15px 0;">
            <div id="game">
                <div id="title">COUNTER STRIKE</div>
                <div id="game-bg" class="cs">
                    <a href="https://www.facebook.com/nerdshosting/"></a>
                </div>
            </div>
            <div id="game">
                <div id="title">COUNTER STRIKE: GLOBAL OFFENSIVE</div>
                <div id="game-bg" class="csgo">
                    <a href="https://www.facebook.com/nerdshosting/"></a>
                </div>
            </div>
            <div id="game">
                <div id="title">TEAM FORTRESS 2</div>
                <div id="game-bg" class="tf2">
                    <a href="https://www.facebook.com/nerdshosting/"></a>
                </div>
            </div>
            <div id="game">
                <div id="title">LEFT 4 DEAD 2</div>
                <div id="game-bg" class="lfd2">
                    <a href="https://www.facebook.com/nerdshosting/"></a>
                </div>
            </div>
            <div id="game">
                <div id="title">TEAMSPEAK 3</div>
                <div id="game-bg" class="ts3">
                    <a href="https://www.facebook.com/nerdshosting/"></a>
                </div>
            </div>
            <div id="game">
                <div id="title">GRAND THEFT AUTO: SAN ANDREAS</div>
                <div id="game-bg" class="gtasa">
                    <a href="https://www.facebook.com/nerdshosting/"></a>
                </div>
            </div>
        <?php include ("style/footer.php"); ?>

        </div>
</div>
<script>
$('.stepcarousel').carousel({
  interval: 5000
})
</script>
</body></html>