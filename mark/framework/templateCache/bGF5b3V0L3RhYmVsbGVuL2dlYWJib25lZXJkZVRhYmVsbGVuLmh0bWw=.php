<?php if($userMode){ ?>
<a href="<?php echo $this->url->make("codes","abboneer"); ?>"><img src="<?php echo $path; ?>images/buttons/abboneren.png" /></a>
<a href="<?php echo $this->url->make("codes","mijnCodes"); ?>"><img src="<?php echo $path; ?>images/buttons/abboBeheren.png" /></a>
<a href="<?php echo $this->url->make("","index"); ?>"><img src="<?php echo $path; ?>images/buttons/terug.png" /></a>
<?php } ?>
<h1>Geabboneerde tabellen</h1>
<div clsss="tableList">
<table>
<tr>
	<td class="top">Tabel</td>
    <td class="top">Code</td>
    <td class="top">Opties</td>
</tr>
    <?php if(is_array($ander)){foreach($ander as $val){ ?>
    	<tr>
        <td><?php echo $val["naam"]; ?></td>
        <td><?php echo $val["code"]; ?></td>
        <td>
        <a href="<?php echo $this->url->make("","abboTabel",$val["code"].",".$val["naam"]); ?>" class="button">openen</a>
        </td>
    <?php }} ?>
    <br />
</table>
    
</div>