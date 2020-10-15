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

add_filter( 'rest_authentication_errors', function( $result ) {
    // If a previous authentication check was applied,
    // pass that result along without modification.
    if ( true === $result || is_wp_error( $result ) ) {
        return $result;
    }
 
    // No authentication has been performed yet.
    // Return an error if user is not logged in.
    if ( ! is_user_logged_in() ) {
        return new WP_Error(
            'rest_not_logged_in',
            __( 'You are not currently logged in.' ),
            array( 'status' => 401 )
        );
    }
 
    // Our custom authentication check should have no effect
    // on logged-in requests
    return $result;
});