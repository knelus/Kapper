<h1>Abbonement Toevoegen</h1>
<form method="post" action="<?php echo $this->url->make("","abboneerSubmit"); ?>">
	<p><label>Code</label><input type="text" name="code"/></p>
    <input type="hidden" name="refferer" value="<?php echo $refferer; ?>" />
    <input type="submit" value="Abboneer"/>
</form>