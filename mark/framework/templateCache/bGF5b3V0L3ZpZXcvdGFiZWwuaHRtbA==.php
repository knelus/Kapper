<table border="1" width="300">
	<tr>
    	<?php if(is_array($columns)){foreach($columns as $val){ ?>	
        	<td class="top"><?php echo $val["naam"]; ?></td>
        <?php }} ?>
    </tr>
    
    <?php if(is_array($data)){foreach($data as $val){ ?>
    	<tr>
       		<?php if(is_array($val)){foreach($val as $vala){ ?>
            	<td><?php echo $vala["data"]; ?></td>
            <?php }} ?>
        </tr>
    <?php }} ?>
</table>