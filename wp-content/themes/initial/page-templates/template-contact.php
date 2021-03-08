<!-- Para el contenido de una pagina generica -->
<?php 
//Template Name: Pagina Contact
get_header(); ?>

<main class="container my-5">
    <?php if (have_posts()) { ?>

        <h1 class="my-3"> TEMPLATE: <?php the_title();?> </h1>

        <?php while (have_posts()) {
            the_post();
            ?>

            <?php the_content();?>

            <?php 
        }
        
    };?>
    
</main>

<?php get_footer(); ?>