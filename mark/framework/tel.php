<?php 

session_start(); 

define('n', "\n"); 

class projectTeller { 

    var $config = array( 
                'countSubDirs' => 1, 
                'countComments' => 1, 
                'countEmptyLines' => 1, 
                'countExt' => array( 
                    'php', 
                    'php3', 
                    'phtml', 
                    'php4', 
                    'inc' 
                ) 
            ); 
    var $files = array(); 

    function showError($error) { 
        die('Er is een fout opgetreden:<br /><br />' . $error); 
    } 
     
    function countDir($dir, &$lines, &$fileSize) { 

        if (!file_exists($dir)) 
            return $this->showError($dir . ' isn\'t found.'); 

        $openDir = opendir($dir); 

        while ($file = readdir($openDir)) 

            if ($file == '..' || $file == '.') 
                continue; 

            elseif (is_dir($dir . $file . '/')) { 

                if ($this->config['countSubDirs'] == true) 

                    $this->countDir($dir . $file . '/', $lines, $fileSize); 

            } else 

                $this->countFile($dir, $file, $lines, $fileSize); 
    } 

    function countFile($dir, $file, &$lines, &$fileSize) { 

        if (!file_exists($dir . $file)) 
            return $this->showError($file . ' isn\'t found in the dir ' . $dir); 

        list($ext) = explode(".", strrev($file)); 

        $ext = strrev($ext); 

        if (!in_array($ext, $this->config['countExt'])) 
            return; 

        $tLines = 0; 
        $tFileSize = 0; 

        if ($this->config["countEmptyLines"] == 0 || $this->config["countComments"] == 0) { 

            $readFile = file($dir . $file); 

            if (count($readFile) == 0) 
                return; 
            else 
                foreach ($readFile AS $line) { 

                    $line = trim($line); 
                    $line = str_replace('        ', '', $line); 

                    if ($line == '' && $this->config["countEmptyLines"] == 0) 
                        continue; 

                    $lineFirstTwoChars = substr($line, 0, 2); 

                    if ($this->config["countComments"] == 0 && ($lineFirstTwoChars == '/*' || $lineFirstTwoChars == '*/' || $lineFirstTwoChars == '//' || substr($line, 0, 1) == '#')) 
                        continue; 

                    $tLines++; 
                    $tFileSize += strlen($line); 

                } 

        } else { 

            $tLines    = count(file($dir . $file)); 
            $tFileSize = filesize($dir . $file); 

        } 

        $lines    += $tLines; 
        $fileSize += $tFileSize; 

        $exp = explode("/", $dir); 

        $code = ''; 
        foreach ($exp AS $dir) if ($dir != '.' && $dir != '..' && !empty($dir)) $code .= '["' . $dir . '"]'; 

        eval('$this->files' . $code . '["' . $file . '"] = array(\'tiaf\', ' . $tLines . ', ' . $tFileSize . ');'); 
    } 
     
    function getDirStat($dir, &$lines, &$size, $rebuild = 0) { 

        $this->countDir($dir, $lines, $size); 

        return array('lines' => $lines, 'fileSize' => $size, 'info' => $this->files); 

    } 

} 
function doFileSize($size) { 

    $c = 0; 
    $a = array('bytes', 'KB', 'MB', 'GB'); 

    while ($size >= 1024) { 
        $size /= 1024; 
        $c++; 
    } 

    return round($size, 3) . ' ' . $a[$c]; 

} 

function showFiles($map, $info) { 

    $cache = ''; 
    $lines = 0; 
    $size  = 0; 

    foreach ($info AS $file => $fInfo) 

        if (is_array($fInfo) && (!isset($fInfo[0]) || $fInfo[0] != 'tiaf')) { 

            $dInfo = showFiles($map . $file . '/', $fInfo); 

            $cache .=' <tr bgcolor="white" style="color: red">'.n.'  <td>' . $map . $file . '/</font></td>'.n.'  <td>' . $dInfo[0] . '</td>'.n.'  <td>' . doFileSize($dInfo[1]) . '</td>'.n.' </tr>'.n; 
            $cache .= $dInfo[2]; 

            $lines += $dInfo[0]; 
            $size  += $dInfo[1]; 

        } else { 

            $lines += $fInfo[1]; 
            $size  += $fInfo[2]; 

            $cache .= ' <tr bgcolor="white" style="color: green">'.n.'  <td>' . $map . $file . '</td>'.n.'  <td>' . $fInfo[1] . '</td>'.n.'  <td>' . doFileSize($fInfo[2]) . '</td>'.n.' </tr>'.n; 

        } 

    return array($lines, $size, $cache); 
} 

$pt = new projectTeller; 
if (!isset($_GET['map'])) { 
    ?> 
<form action="" method="GET"> 
Map:<br /> 
<input type="text" name="map" value="./"><br /> 
<input type="submit" value="Tel!"> 
</form> 
    <? 
    exit; 
} 
$regels = ''; 
$grootte = ''; 

$a = $pt->getDirStat($_GET['map'], $regels, $grootte); 

$i = showFiles($_GET['map'], $a['info']); 
echo ' > <a href="?">Andere map</a><br /> '; 
echo '<table width="100%" cellspacing="1" cellpadding="3" bgcolor="#EEEEEE">'.n; 
echo ' <tr bgcolor="white">'.n; 
echo '  <td width="60%"><b>Bestand</b></td>'.n; 
echo '  <td width="20%"><b>Regels</b></td>'.n; 
echo '  <td width="20%"><b>Grootte</b></td>'.n; 
echo ' </tr>'.n; 
echo $i[2]; 
echo ' <tr bgcolor="white">'.n; 
echo '  <td colspan="3"><hr style="border-style: dashed" noshade color="#000000" size="1"></td>'.n; 
echo ' </tr>'.n; 
echo ' <tr bgcolor="white" style="color: green">'.n; 
echo '  <td width="60%">Subtotaal</td>'.n; 
echo '  <td width="20%">' . $i[0] . '</td>'.n; 
echo '  <td width="20%">' . doFileSize($i[1]) . '</td>'.n; 
echo ' </tr>'.n; 
echo '</table>'.n; 
echo ' <br /> > <a href="?">Andere map</a>'; 
?> 