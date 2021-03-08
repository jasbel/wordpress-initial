<?php

/* para iniciar wordpress */
function init_template() {
    /*aniade soporte a  Image destacada  en la bara superior*/
    add_theme_support('post-thumbnails');
    /* aniade soorte de : titulo en la barra superior*/
    add_theme_support('title-tag');
    /* registrar menu de navegacion en el panel admin*/
    register_nav_menus(
        array(
            'top_menu' => 'Menu Principal'
        )
    );

}

/* Elgegir el tema antes de ejcutar wordpress */
add_action('after_setup_theme', 'init_template');

/* dependencias cargar css js */
function assets() {
    /* Registro de estilos de depeendencias */
    wp_register_style('boostrap','https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css', '', '5.0.1', 'all');
    wp_register_style('font_primary', 'https://fonts.googleapis.com/css2?family=Montserrat&display=swap', '', '1.0', 'all');

    
    /* Cargar las depencias de css */
    wp_enqueue_style( 'stylesAll', get_stylesheet_uri(), array('boostrap', 'font_primary'), '1.0', 'all' );

    /* true: que se ejecute en el footer */

    wp_register_script( 'validate', plugins_url( '/validate.js', __FILE__ ), array( 'jquery' ) );
    wp_enqueue_script('validate'); 

    wp_register_script('popper', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js', '', '1.16.0', true);
    
    wp_enqueue_script('b5','https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js', array('popper'), '1.0', true );
    wp_enqueue_script('custom', get_template_directory_uri().'/assets/js/custom.js', '', '1.0', true );

    /* enviar informacion de js a una funcions, uso de apirest */
    wp_localize_script('custom', 'ajar', array( 
        'ajaxurl' => admin_url('admin-ajax.php'),
        'apiurl' => home_url('wp-json/ajar/v1/'),
    ));

}

add_action( 'wp_enqueue_scripts', 'assets' );

/* Creacion de widget: sidebar */

function sidebar() {
    register_sidebar(
        array(
            'name' => 'Pie de Pagina',
            'id' => 'footer',
            'description' => 'Zona de widget para el footer',
            'before_title' => '<p>',
            'after_title' => '</p>',
            'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>',
        )
    );
}

add_action('widgets_init', 'sidebar');


//generacion de un custom post type
function products_type() {

    $labels = array(
        'name'  => 'Productos',
        'singular_name' => 'Producto',
        'menu_name' => 'Productos',
    );

    $args = array(
        'label' => 'Productos',
        'description' => 'Productos de Platzi',
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
        'public'   => true,
        'show_in_menu'  => true,
        'menu_position' => 5,
        'menu_icon' =>  'dashicons-cart',
        'can_export'    =>  true,
        'publicly'  => true,
        'rewrite'   => true,
        'show_in_rest'  => true,
    );

    register_post_type('producto', $args);
}

add_action('init', 'products_type');

/* Registro de categoria para Productos*/
function ajarRegisterTaxonomy() {
    $args = array(
        'hierarchical' => true, //con/sin jerarquia
        'labels' => array(
            'name' => 'Categorias de Productos',
            'singular_name' => 'Categoria de Productos',
        ),
        'show_in_nav_menu' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'categoria-productos')
    );
    register_taxonomy('categoria-productos', array('producto'), $args);
}

add_action( 'init', 'ajarRegisterTaxonomy' );

/* FILTRO CON AJAX*/
function ajarFilterProducts() {
    $args = array(
        'post_type' => 'producto',
        'posts_per_page'    => -1, /* REcibir todos los productos */
        'order' => 'ASC',
        'orderby' => 'title',
        
    );

    if ($_POST['categoria']) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categoria-productos',
                'field' => 'slug',
                'terms' => $_POST['categoria']
            )
        );
    }

    $products = new WP_Query($args);
    $return  = array();
    if ($products->have_posts()) {

        while ($products->have_posts()) {
            $products->the_post();
            $return[] = array(
                'imagen' => get_the_post_thumbnail(get_the_id(), 'large'),
                'link' => get_the_permalink(),
                'titulo' => get_the_title(),
            );
        }

    }
    wp_send_json($return);
}

add_action("wp_ajax_nopriv_ajarFilterProducts", "ajarFilterProducts"); /* PAra usauarios no tregistrados */
add_action("wp_ajax_ajarFilterProducts", "ajarFilterProducts");


/* API REST - para mostrar las ultimas entradas o posts*/
function novedadesAPI() {
    register_rest_route( 'ajar/v1', '/novedades/(?P<cantidad>\d+)', array(
        'method' => 'GET',
        'callback' => 'pedidoNovedades',
    ));

}

add_action( 'rest_api_init', 'novedadesAPI');

function pedidoNovedades($data) {
    $args = array(
        'post_type' => 'post',
        'posts_per_page'    => $data['cantidad'],
        'order' => 'ASC',
        'orderby' => 'title',
        
    );

    $novedades = new WP_Query($args);

    $return  = array();
    if ($novedades->have_posts()) {

        while ($novedades->have_posts()) {
            $novedades->the_post();
            $return[] = array(
                'imagen' => get_the_post_thumbnail(get_the_id(), 'large'),
                'link' => get_the_permalink(),
                'titulo' => get_the_title(),
                'lorem' => 'lorem',
            );
        }

    } else {
        return null;
    }
    // wp_send_json($return);
    return $return;

}

/* Registro de bloques de reack */

function ajarRegisterBlock() {

    //Archivo php generado del builds
    $assets = include_once get_template_directory().'/blocks/build/index.asset.php';

    wp_register_script(
        'ajar-block', // handle del script
        get_template_directory_uri().'/blocks/build/index.js', //url del directorio
        $assets['dependencies'], //all dep
        $assets['version'] // cada build cambia la version, para evitaas conflictos de cache
    );

    register_block_type(
        'ajar/basic',
        array(
            'editor_script' => 'ajar-block', //copiar el script ya registrado
            'attributes' => array( //repetimos los attr del block de index.js
                'content' => array(
                    'type' => "string",
                    'default' => 'Hello World'
                ),
                'mediaURL' => array(
                    "type" => 'string'
                ),
                'mediaAlt' => array(
                    "type" => 'string'
                ),
            ),
            'render_callback' => 'ajarRenderDinamycBlock' //funcion para generar el SSR(server side render)
        )
    );
}

add_action('init', 'ajarRegisterBlock');


/* React Bloque dinamico, para usar hast con preview page*/
function ajarRenderDinamycBlock($attributes, $content) {
    return  '<h1 class="my-3">'.$attributes['content'].'</h1>'.
            '<img src="'.$attributes['mediaURL'].'" alt="'.$attributes['mediaAlt'].'" />'.
            '<hr>';
}


/* ACF */
function acfRegisterBlocks() {
    acf_register_block(
        array(
            'name' => 'ajar-institucional',
            'title' => 'institucional',
            'description' => 'block part institucional',
            'render_template' => get_template_directory(  ).'/template-parts/institutional.php',
            'category '=> 'layout',
            'icon' => 'smiley',
            'mode' => 'edit'
        )
    );
}

add_action('acf/init', 'acfRegisterBlocks');
