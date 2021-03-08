<!-- Para el contenido de una pagina generica -->
<?php 
//Template Name: Pagina Institucional
get_header();
$fields = get_fields();
$image = get_field('institutional_image')?:'';
?>

<main class="container my-5">
    <?php if (have_posts()) { ?>

        <!-- <h1 class="my-3"><?php echo $fields['institutional_title'];?> </h1> -->

        <?php while (have_posts()) {
            the_post();
            ?>

            <!-- <img src="<?php echo $image;?>" alt="Imagen"> -->
            <hr>
            <?php the_content();?>

            <?php 
        }
        
    };?>
    
</main>

<?php get_footer(); ?>