<?php

//sql voorbereiden
$sql->query("SET NAMES utf8");
//header van php instellen (zou ook in php.ini kunnen maar deze fix werkt ook)
header("Content-Type: text/html; charset=UTF-8"); 
//html zo instellen dat hij unicode charachers accepteerd
out('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">',"head")
//fix voor magic quotes.




?>
