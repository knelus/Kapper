<a href="<?php echo $this->url->make("","index"); ?>"><img src="<?php echo $path; ?>images/buttons/terug.png" /></a>
<div clsss="tableList">
    <h1>Eigen tabellen</h1>
    
    <table>
<tr>
	<td class="top">Tabel</td>
    <td class="top">Opties</td>
</tr>
    <?php if(is_array($eigen)){foreach($eigen as $val){ ?>
    	<tr>
        <td><?php echo $val["naam"]; ?></td>
        <td>
        <a href="<?php echo $this->url->make("","eigenTabel",$val["id"].",".$val["naam"]); ?>" class="button">Openen</a>
        </td>
    <?php }} ?>
    <br />
</table>
</div>
