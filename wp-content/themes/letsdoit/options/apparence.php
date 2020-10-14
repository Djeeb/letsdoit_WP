<?php
// https://developer.wordpress.org/reference/hooks/customize_register/
add_action('customize_register', function (WP_Customize_Manager $manager){

    $manager->add_section('letsdoit_apparence', [
        'title' => 'Customisation of appearance',
    ]);

    $manager->add_setting('header_background', [
        'default' => '#FF0000',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_hex_color'
    ]);

    $manager->add_control(new WP_Customize_Color_Control($manager, 'header_background', [ 
        'section' => 'letsdoit_apparence',
        'setting' => 'header_background',
        'label' => 'header colour'
    ]));
});

add_action('customize_preview_init', function () {
    wp_enqueue_script('letsdoit_apparence', get_template_directory_uri() . '/assets/apparence.js', ['jquery', 'customize-preview'], '', true);
});