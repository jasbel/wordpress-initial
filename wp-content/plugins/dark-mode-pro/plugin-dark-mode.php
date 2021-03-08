<?php 

//Plugin name: Dark Name
//Description: Activa el modo oscuro en tu theme
//version: 1.0
//Author: Asbel JAR
//Author URI: https://github.com/jasbel

function style_plugin() {
    $style_url = plugin_dir_url(__FILE__);

    wp_enqueue_style('dark_mode', $style_url.'/assets/css/styles.css', '', '1.0', 'all');


};

add_action('wp_enqueue_scripts', 'style_plugin');
