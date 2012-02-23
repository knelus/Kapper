<script type="text/javascript">

</script>
<h2>Waar wilt u zich knippen?</h2> <br />

<!--
Beschikbare Plaatse <br />
<form name="input" action="index.php" method="get">
<select name="lijstPlaatsen" size="4">
<?php if(is_array($plaats)){foreach($plaats as $val){ ?>
	<option value=""><?php echo $val["plaats"]; ?></option>
<?php }} ?>
</select>
</form>
-->

Vul uw plaats in waar u geknipt wil worden: <br />
<form name="input"action="index.php" method="post">
Plaats: <input type="text" name="plaats" />
<input type="submit" value="Verder" onclick="hide();" />
</form>

Selecteer Kapsalon:<br />
<form method="post" action="index.php" name="kapsalon">
<input type="hidden" value="<?php echo $plaatsSelected; ?>" name="plaats"/>
<select name="kapsalon" size="2">
<?php if(is_array($kapsalon)){foreach($kapsalon as $val){ ?>
	<option value="<?php echo $val["kapsalonId"]; ?>"><?php echo $val["naam"]; ?></option>
<?php }} ?>
</select>
<input type="submit"/>
</form>

Selecteer Behandeling
<form method="post" action="index.php" name="behandeling" >
<input type="hidden" value="<?php echo $plaatsSelected; ?>" name="plaatsSelected"/>
<input type="hidden" value="<?php echo $kapsalonSelected; ?>" name="kapsalonSelected"/>
<select name="behandeling" size="2">
<?php if(is_array($behandeling)){foreach($behandeling as $val){ ?>
	<option value="<?php echo $val["0"]["behandelingId"]; ?>"><?php echo $val["0"]["naam"]; ?></option>
<?php }} ?>
</select>
<input type="submit"/>
</form>

Selecteer Kapper:<br />
<form method="post" action="index.php" name="kapper" >
<input type="hidden" value="<?php echo $plaatsSelected; ?>" name="plaatsSelected"/>
<input type="hidden" value="<?php echo $kapsalonSelected; ?>" name="kapsalonSelected"/>
<input type="hidden" value="<?php echo $behandelingSelected; ?>" name="behandelingSelected"/>
<select name="kapper" size="2">
<?php if(is_array($kapper)){foreach($kapper as $val){ ?>
	<option value="<?php echo $val["0"]["naam"]; ?>"><?php echo $val["0"]["naam"]; ?></option>
<?php }} ?>
</select>
<input type="submit" id="volForm"/>
</form>

<div id="dataReservation">
<?php echo $plaatsSelected; ?><br />
<?php if(is_array($kapsalonName)){foreach($kapsalonName as $val){ ?>
<?php echo $val["naam"]; ?><br />
<?php }} ?>
<?php if(is_array($behandelingName)){foreach($behandelingName as $val){ ?>
<?php echo $val["naam"]; ?><br />
<?php }} ?>
</div>