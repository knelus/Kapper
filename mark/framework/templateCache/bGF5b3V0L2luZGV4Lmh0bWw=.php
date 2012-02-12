<script type="text/javascript">
$(document).ready(function(){
	if(){
	$('#kapsalon').hide();
	}
});
</script>
<h2>Waar wilt u zich knippen?</h2> <br />

Vul uw plaats in waar u geknipt wil worden: <br />
<form name="input"action="index.php" method="get">
Plaats: <input type="text" name="plaats" />
<input type="submit" value="Verder" onclick="hide();" />
</form>

Selecteer Kapsalon:<br />
<form method="get" action='index.php' name='kapsalon'>
<select name="kapsalon" size="2">
<?php if(is_array($kapsalon)){foreach($kapsalon as $val){ ?>
	<option value="<?php echo $val["kapsalonId"]; ?>"><?php echo $val["naam"]; ?></option>
<?php }} ?>
</select>
<input type="submit"/>
</form>

Selecteer Behandeling
<form method="get" action="index.php" name="behandeling" >
<select name="behandeling" size="2">
<?php if(is_array($behandeling)){foreach($behandeling as $val){ ?>
	<option value="<?php echo $val["naam"]; ?>"><?php echo $val["naam"]; ?></option>
<?php }} ?>
</select>
<input type="submit"/>
</form>

Selecteer Kapper:<br />
<form method="get" action='index.php' name='kapper' id="kapper">
<select name="kapper" size="2">
<?php if(is_array($kapper)){foreach($kapper as $val){ ?>
	<option value="<?php echo $val["kapperId"]; ?>"><?php echo $val["naam"]; ?></option>
<?php }} ?>
</select>
<input type="submit"/>
</form>

