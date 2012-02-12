<table>
<?php if(is_array($mogelijkheden)){foreach($mogelijkheden as $val){ ?>
	<tr>
	<td><?php echo $val["naam"]; ?></td>
	<td><?php echo $val["duur"]; ?></td>
	</tr>
<?php }} ?>
</table>