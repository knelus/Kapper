<?php echo $data["naam"]; ?>
<form method="post" action="<?php echo $this->url->make("","persoonSubmit",$data["id"]); ?>">
<input type="text" name="naam" value="<?php echo $data["naam"]; ?>" />
<input type="submit" value="submit" />
</form>