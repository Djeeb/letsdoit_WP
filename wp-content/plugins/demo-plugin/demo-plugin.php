<?php
/**
 * Plugin Name: Demo Plugin
*/
defined('ABSPATH') or die('nothing to see');

register_activation_hook(__FILE__, function(){
    touch(__DIR__ . '/demo');
});

register_deactivation_hook(__FILE__, function(){
    unlink(__DIR__ . '/demo');
});

add_action('init', function(){
    register_post_type('artwork', [ // https://developer.wordpress.org/reference/functions/register_post_type/
        'label' => 'Artwork',
        'public' => true,
        'menu_position' => 3,
        'menu_icon' => 'dashicons-building', // https://developer.wordpress.org/resource/dashicons/#screenoptions
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'has_archive' => 'true',
        ]);
});