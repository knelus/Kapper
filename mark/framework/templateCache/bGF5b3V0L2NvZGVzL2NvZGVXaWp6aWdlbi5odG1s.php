<h1>Codeinstellingen</h1>
<form method="post" action="<?php echo $action; ?>">
	<p><label>Tabel</label><select name="tabel" id="codesTabel">
    <?php if($codeInfo){ ?><?php }else{ ?>
    	<option value="leeg" selected="selected">(Kies een tabel)</option>
    <?php } ?>
    <?php if(is_array($tabellen)){foreach($tabellen as $tabel){ ?>
    	<option value="<?php echo $tabel["id"]; ?>" <?php if($codeInfo["tabel"] == $tabel["id"]){echo 'selected="selected"';} ?>><?php echo $tabel["naam"]; ?></option>
    <?php }} ?>
    </select></p>
    
    <div id="voorwaarden">
    	<?php if($codeInfo){ ?>
    		<?php include("templateCache/bGF5b3V0L2NvZGVzL3Zvb3J3YWFyZGVuLmh0bWw=.php"); ?>
        <?php } ?>
    </div>
    <input type="hidden" name="refferer" value="<?php echo $refferer; ?>" />
    
    
	<input type="submit" value="verstuur" name="submit"/>
</form>