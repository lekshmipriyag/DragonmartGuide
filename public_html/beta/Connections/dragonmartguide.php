<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_dragonmartguide = "localhost";
$database_dragonmartguide = "dragonma_dmgbeta";
$username_dragonmartguide = "dragonma_betanew";
$password_dragonmartguide = "u^Q8[38v{c.X";
$dragonmartguide = mysql_pconnect($hostname_dragonmartguide, $username_dragonmartguide, $password_dragonmartguide) or trigger_error(mysql_error(),E_USER_ERROR);


$db = new mysqli($hostname_dragonmartguide, $username_dragonmartguide, $password_dragonmartguide, $database_dragonmartguide);
?>