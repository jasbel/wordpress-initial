<!-- Paara laasa entraadas del producto-->
<?php get_header(); ?>


<main class="container">
    <h1 class="my-3"> <?php the_title();?> </h1>

    <?php if (have_posts()) {
        while (have_posts()) {
            the_post();
        ?>

            <!-- <h1 class="my-3"> <?php the_title();?> </h1> -->
            <?php $taxonomy = get_the_terms(get_the_ID(), 'categoria-productos');?>
            <div class="row my-5">
                <div class="col-md-6">
                    <?php the_post_thumbnail('large');?>
                </div>
                <div class="col-md-6">
                    <?php echo  do_shortcode( '[contact-form-7 id="44" title="Form"]' ) ?>
                </div>
                <div class="col-12">
                    <?php the_content();?>
                </div>
            </div>

            <?php
                $args = array(
                    'post_type' => 'producto',
                    'posts_per_page'    => 6,
                    'order' => 'ASC',
                    'orderby' => 'title',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'categoria-productos',
                            'field' => 'slug',
                            'terms' => $taxonomy[0]->slug 
                        )
                    )
                );

                $products = new WP_Query($args);
            ?>

            <?php if ($products->have_posts()) { ?>
                <h3 class="text-center">Productos Relacionados</h3>
                <div class="row justify-content-center product-related">
                    <?php while ($products->have_posts()) {
                        $products->the_post();
                        ?>
                        
                        <div class="col-2 my-3">
                            <?php the_post_thumbnail('thumbnail');?>
                            <h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                        </div>

                        <?php
                    }?>
                </div>
            <?php };?>

        <?php
        }
    };?>
     
</main>


<?php get_footer(); ?>