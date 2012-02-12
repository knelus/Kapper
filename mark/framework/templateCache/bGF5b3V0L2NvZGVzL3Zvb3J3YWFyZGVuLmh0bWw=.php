<p><label>Gebruik voorwaarden</label><input type="checkbox" name="gebruikVoorwaarden" <?php if($codeInfo["wherefield"]){ ?>checked="checked"<?php } ?>/></p>
<div id="codeVoorwaarden">
    <p><label>Voorwaarden</label>
    <select name="wherefield">
        <?php if(is_array($columns)){foreach($columns as $column){ ?>
            <option value="<?php echo $column["naam"]; ?>" <?php if($column["naam"] == $codeInfo["wherefield"]){echo 'selected="selected"';} ?>><?php echo $column["naam"]; ?></option>
        <?php }} ?>
    </select>
    
    
    <select name="whereoperator">
        <?php if(is_array($operators)){foreach($operators as $operator=>$operatorNaam){ ?>
            <option value="<?php echo $operator; ?>" <?php if($operator == $codeInfo["whereoperator"]){echo 'selected="selected"';} ?>><?php echo $operatorNaam; ?></option>
        <?php }} ?>
    </select>
    
    <input type="text" name="wherewaarde"  value="<?php echo $codeInfo["wherewaarde"]; ?>"/>
    </p>
</div>