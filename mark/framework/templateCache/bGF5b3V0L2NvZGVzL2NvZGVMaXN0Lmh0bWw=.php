<a href="<?php if($id){ ?><?php echo $this->url->make("","codeMaken",$id); ?><?php }else{ ?><?php echo $this->url->make("","codeMaken"); ?><?php } ?>"><img src="<?php echo $path; ?>images/buttons/nieuwcode.png" /></a>
<h1>Codes beheren</h1>
<table>	
	<tr>
    	<td class="top">Code</td>
        <td class="top">Tabel</td>
        <td class="top">Voorwaarden</td>
        <td class="top">Opties</td>
    </tr>
    <?php if(is_array($data)){foreach($data as $val){ ?>
    	<tr>
        	<td><?php echo $val["code"]; ?></td>
            <td><?php echo $val["tabel"]; ?></td>
            <td><?php echo $val["wherefield"]; ?> <?php echo $val["whereoperator"]; ?> <?php echo $val["wherewaarde"]; ?></td>
            <td>
            	<a href="<?php echo $this->url->make("","codeWijzigen",$val["id"].",".$val["code"]); ?>" class="button">Wijzigen</a>
                <a href="<?php echo $this->url->make("","codeVerwijderen",$val["id"].",".$val["code"]); ?>" class="button">Verwijderen</a>
            </td>
            
        </tr>
    <?php }} ?>
</table>

