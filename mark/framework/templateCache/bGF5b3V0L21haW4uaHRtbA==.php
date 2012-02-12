<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
    	<title><?php echo $titel; ?></title>
		<LINK HREF="<?php echo $path; ?>style/style.css" TYPE="text/css" REL="stylesheet"> 
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
        <?php echo $head; ?>
        <script>
			function pgOnload(){
				XMLobjects=new Array();
				ajax_tab_init();
				<?php echo $onload; ?>
				return 0;
			}
			$(document).ready(
				function(){
					$("#content").height(1);
					$("#content").height($(window).height()-$("#wrapper").height()-50);
					
				}
			);
		</script>
    </head>
    <body onLoad="pgOnload();">
    
		<div id="wrapper">
			<img src="<?php echo $path; ?>images/header.jpg">
			<div id="menu"><?php echo $menu; ?></div>
            
            <div id="content">
				<?php echo $content; ?>
            </div>

        </form>
    </body>
</html>
