<?php
add_action('wp_enqueue_scripts', function (){
    wp_enqueue_style('letsdoit-child', get_stylesheet_uri());
}, 11);

add_action('after_setup_theme', function(){
    load_child_theme_textdomain('letsdoit-child', get_stylesheet_directory() . '/languages');
});

add_filter('letsdoit_search_title', function(){
    return 'Search : %s';
});
