<!-- home o pagina de inicio -->
<?php get_header(); ?>

<main class="container">
    <?php if (have_posts()) {
        
        while (have_posts()) {
            the_post();
            ?>
            <h1 class="my-3"> <?php the_title();?> !!!</h1>

            <?php the_content();?>

            <?php 
        }
    };?>




    
    
    <!-- Seccion para el post type product -->
    <div class="product__list my-5">
        <div class="text-center">Productos</div>
        <!-- Para mostrar las categorias del producto -->
        <div class="row">
            <div class="col-12">
                <select class="form-control" name="categorias-productos " id="categorias-productos">
                    <option value="">Todas las Categorias</option>
                    <?php $terms = get_terms('categoria-productos', array('hide_empty' => true));?>
                    <?php foreach ($terms as $term ) {
                        echo '<option value="'.$term->slug.'">'.$term->name.'</option>';
                    };?>
                </select>
            </div>
        </div>
        <div id="resultado-productos" class="row justify-content-center">
            <?php 
            $args = array(
                'post_type' => 'producto',
                'post_per_page' =>  -1, /* -1: traa todo lops post */
                'order'         => 'DESC', /* Ascendente/Descenndennte */
                'orderby'       => 'title'
            );

            $products = new WP_Query($args);

            if ($products->have_posts()) {
                while ($products->have_posts()) {
                    $products->the_post();
                    ?>
                    <div class="col-4">
                        <figure>
                            <?php the_post_thumbnail('large');?>
                        </figure>
                        <h4 class="text-center my-3">
                            <a href="<?php the_permalink();?>">
                                <?php the_title();?>
                            </a>
                        </h4>
                    </div>
                    <?php
                }
            }
            ;?>
        </div>
    </div>

    <!-- Novedades -->
    <div class="row">
        <div class="col-12">
            <h1>Novedades</h1>
        </div>
        <div id="resultado-novedades" class="row"></div>
    </div>

</main>

<?php get_footer(); ?>