<?php
session_start();

$fajl = "login";

include("konfiguracija.php");

$naslov = "Admin login";

if (isset($_GET['task'])) $task = mysql_real_escape_string($_GET['task']);

function AdminUlogovan()
{
	if (!empty($_SESSION['a_id']) && is_numeric($_SESSION['a_id']))
	{
		$verifikacija = mysql_query( "SELECT `username` FROM `admin` WHERE `id` = '".$_SESSION['a_id']."'" );
		if (mysql_num_rows($verifikacija) == 1)
		{
			return TRUE;
		}
		unset($verifikacija);
	}
	return FALSE;
}

if (AdminUlogovan() == TRUE) { header("Location: index.php"); die(); }

?>
<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">

  <title>NERDS HOSTING - ADMIN LOGIN</title>

    <link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />

</head>

<body>

  <html lang="en-US">
  <head>

    <meta charset="utf-8">

    <title>Login</title>

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,700">

    <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
 <![endif]-->

  </head>

  <body>

    <div class="container">

      <div id="login">

        <form class="form-signin" role="form" action="login_process.php" method="POST">
            
		  <input type="hidden" name="task" value="login" />
            <fieldset class="clearfix">
                			<input type="hidden" name="return" value="<?php
		if (isset($_GET['return']))
		{
			echo htmlspecialchars($_GET['return'], ENT_QUOTES);
		}
?>" />
            <p><span class="fontawesome-user"></span><input name="username" type="text" placeholder="Username" required></p> <!-- JS because of IE support; better: placeholder="Username" -->
            <p><span class="fontawesome-lock"></span><input name="sifra" type="password"  placeholder="Password" required></p> <!-- JS because of IE support; better: placeholder="Password" -->
            <p><input type="submit" style="background-color: orangered;" value="Sign In"></p>

          </fieldset>

        </form>

      </div> <!-- end login -->

    </div>

  </body>
</html>

</body>

</html>