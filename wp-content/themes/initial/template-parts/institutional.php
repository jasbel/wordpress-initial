<?php
$fields = get_fields();
$image = get_field('institutional_image')?:'';
?>

<h1 class="my-3"><?php echo $fields['institutional_title'];?> </h1>
<img src="<?php echo $image;?>" alt="Imagen">
<hr>