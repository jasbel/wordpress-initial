wp_head();
wp_footer();

get_header();
get_footer();

<!-- Agregando nuestro menu navegacion -->
wp_nav_menu(
    array(
        'theme_location' => 'top_menu',
        'menu_class' => 'menu-principal',
        'container_class' => 'container--menu',
    )
)

widget: bloques dinamicos o staticos

dynamic_sidebar('footer');

post type: contenidos de diferente tipos

loop: muestra el contenido, vista-source-code-database
    WP_Query

jerarquia de aarchivos wordpress https://developer.wordpress.org/files/2014/10/Screenshot-2019-01-23-00.20.04.png


page.php para las paginas de

have_posts() <!-- => si contiene posts o blogs -->
the_post(); <!-- => verifica si hay un post y si no hay saale del bucle -->


the_title(); <!-- => titulo del apagina -->
the_content() <!-- =>  contenido de la pagina -->
the_post_thumbnail('large') <!-- => imagen principal de la ebtrada post -->
<?php the_permalink();?> <!-- => url del post -->

<?php echo home_url() ?> <!-- URL de la pagina principa; -->

single.php => <!-- Paara lasa entraadas --> <!-- TAmbien funciona para post type personalizados como product creado en functions -->

dir template-part/post-navigation <!-- PArtes para la navegacion -->

<?php previous_post_link();?>
<?php next_post_link();?>

single-nameporttype.php

<?php $taxonomy = get_the_terms(get_the_ID(), 'categoria-productos');?> <!-- obtener las taxonomias del posta actual con el ID) -->

<?php $terms = get_terms('categoria-productos', array('hide_empty' => true));?> <!-- terminos -->


<!-- instalar plugins de site kit google, yoast seo, wordfence -->