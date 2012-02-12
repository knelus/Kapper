<a href="<?php echo $this->url->make("","abboneer"); ?>"><img src="<?php echo $path; ?>images/buttons/abboneren.png" /></a>
<h1>Geabboneerde codes</h1>
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
                <a href="<?php echo $this->url->make("","abbonementVerwijderen",$val["cuId"].",".$val["code"]); ?>" class="button">Verwijderen</a>
            </td>
            
        </tr>
    <?php }} ?>
</table>
