<h1>Bestand importeren</h1>
<form method="post" enctype="multipart/form-data" action=<?php echo $this->url->make("","submit"); ?>>
	<p><label>Bestand</label><input type="file" name="importFile" /></p>
   <p> <input type="submit" name="submit" value="Importeer"/></p>
</form>