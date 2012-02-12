<?php if(is_array($data)){foreach($data as $klant){ ?>
<a href="<?php echo $this->url->make("","persoon",$klant["id"]); ?>">naam: <?php echo $klant["naam"]; ?></a> <br />
<?php }} ?>
<div class="iets">Halooow</div>