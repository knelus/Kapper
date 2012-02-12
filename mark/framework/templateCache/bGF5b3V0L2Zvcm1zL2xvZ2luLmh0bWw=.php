<html>
	<head>	
		<LINK HREF="style/login.css" TYPE="text/css" REL="stylesheet">
		<title><?php echo $lang["title"]; ?></title>
	</head>
	<body>
	<form method="post">
		<div class="container">
			<div class="venster">
				<h1><?php echo $lang["title"]; ?></h1>
				<p><label><?php echo $lang["naam"]; ?></label><input type="text" name="naam" value="<?php echo $naam; ?>"></p>
				<p><label><?php echo $lang["wachtwoord"]; ?></label><input name="wachtwoord" type="password"></p>
				<p><label>&nbsp;</label><input type="submit" value="<?php echo $lang["submit"]; ?>" name="submit"></p>
			</div>
		</div>
	</form>
	</body>
</html>
