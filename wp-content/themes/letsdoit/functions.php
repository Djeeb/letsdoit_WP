<?php

function letsdoit_supports (){
    add_theme_support('title-tag'); // https://developer.wordpress.org/reference/functions/add_theme_support/
}

function letsdoit_register_assets(){
    wp_register_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', []); // https://developer.wordpress.org/reference/functions/wp_register_style/
    wp_register_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', ['popper', 'jquery'], false, true); // https://getbootstrap.com/docs/4.5/getting-started/introduction/
    wp_register_script('popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js', [], false, true);
    wp_deregister_script('jquery'); // Disable Bootstrap's default jQuery
    wp_register_script('jquery', 'https://code.jquery.com/jquery-3.5.1.slim.min.js', [], false, true); // Enable our Bootstrap
    wp_enqueue_style('bootstrap'); // https://developer.wordpress.org/reference/functions/wp_enqueue_style/
}

add_action('after_setup_theme', 'letsdoit_supports'); // https://developer.wordpress.org/reference/hooks/after_setup_theme/
add_action('wp_enqueue_scripts', 'letsdoit_register_assets'); // https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/
