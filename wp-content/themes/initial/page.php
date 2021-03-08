<!-- Para el contenido de una pagina generica -->
<?php get_header(); ?>

<main class="container">
    <?php if (have_posts()) {
        // echo '<h1 class="my-3'.the_title().'</h1>';
        while (have_posts()) {
            the_post();
            ?>

            <?php the_content();?>

            <?php
        }
    };?>
</main>

<?php get_footer(); ?>