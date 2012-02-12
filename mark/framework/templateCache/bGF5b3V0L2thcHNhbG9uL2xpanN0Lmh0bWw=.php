<table>
<?php if(is_array($lijst)){foreach($lijst as $val){ ?>
	<tr>
	<td><?php echo $val["naam"]; ?></td>
	<td><?php echo $val["adres"]; ?></td>
	<td><?php echo $val["plaats"]; ?></td>
	</tr>
<?php }} ?>
</table>