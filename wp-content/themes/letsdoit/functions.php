<?php

function letsdoit_supports (){
    add_theme_support('title-tag'); // https://developer.wordpress.org/reference/functions/add_theme_support/
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    register_nav_menu('header', 'menu header');
    register_nav_menu('footer', 'menu footer');
    add_image_size('post-thumbnail', 350, 215, true);
}

function letsdoit_register_assets(){
    wp_register_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', []); // https://developer.wordpress.org/reference/functions/wp_register_style/
    wp_register_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', ['popper', 'jquery'], false, true); // https://getbootstrap.com/docs/4.5/getting-started/introduction/
    wp_register_script('popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js', [], false, true);
    wp_deregister_script('jquery'); // Disable Bootstrap's default jQuery
    wp_register_script('jquery', 'https://code.jquery.com/jquery-3.5.1.slim.min.js', [], false, true); // Enable our Bootstrap
    wp_enqueue_style('bootstrap'); // https://developer.wordpress.org/reference/functions/wp_enqueue_style/
    wp_enqueue_script('bootstrap');
}

function letsdoit_title_separator(){
    return ' | ';  
}

function letsdoit_menu_class($classes){
    $classes[] = 'nav-item';
    return $classes;
}

function letsdoit_menu_link_class($attrs){
    $attrs['class'] = 'nav-link';
    return $attrs;
}

function letsdoit_pagination(){
    
    $pages = paginate_links(['type' => 'array']);
    if ($pages === null){
        return;
    }
    echo '<nav aria-label="Pagination" class="my-4">';
    echo '<ul class="pagination">';
    foreach($pages as $page){
        $active = strpos($page, 'current') !== false;
        $class = 'page-item';
        if ($active){
            $class .= ' active';
        }
        echo '<li class="' .$class . '">';
        echo str_replace('page-numbers', 'page-link', $page);
        echo '</li>';
    }
    echo '</ul>';
    echo '</nav>';

}

function letsdoit_init (){
    register_taxonomy('discipline', 'post', [
        // https://developer.wordpress.org/reference/functions/get_taxonomy_labels/
        'labels' => [
            'name' => 'Discipline',
            'singular_name'     =>  'Discipline',
            'plural_name'       =>  'Disciplines',
            'search_items'      =>  'Search disciplines',
            'all_items'         =>  'All disciplines',
            'edit_item'         =>  'Edit discipline',
            'update_item'       =>  'Update discipline',
            'add_new_item'      =>  'Add new discipline',
            'new_item_name'     =>  'Add new discipline name',
            'menu_name'         =>  'Discipline',
        ],
        'show_in_rest'  => true, // https://developer.wordpress.org/reference/functions/register_taxonomy/
        'hierarchical'  => true,
        'show_admin_column' => true,
    ]);
    register_post_type('artwork', [ // https://developer.wordpress.org/reference/functions/register_post_type/
        'label' => 'Artwork',
        'public' => true,
        'menu_position' => 3,
        'menu_icon' => 'dashicons-building', // https://developer.wordpress.org/resource/dashicons/#screenoptions
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'has_archive' => 'true',
        ]);
}

add_action('init','letsdoit_init');
add_action('after_setup_theme', 'letsdoit_supports'); // https://developer.wordpress.org/reference/hooks/after_setup_theme/
add_action('wp_enqueue_scripts', 'letsdoit_register_assets'); // https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/
add_filter('document_title_separator', 'letsdoit_title_separator'); // https://developer.wordpress.org/reference/functions/wp_get_document_title/
add_filter('nav_menu_css_class', 'letsdoit_menu_class');
add_filter('nav_menu_link_attributes', 'letsdoit_menu_link_class');

require_once('metaboxes/sponso.php');
require_once('options/gallery.php');

SponsoMetaBox::register();
GalleryMenuPage::register();

add_filter('manage_artwork_posts_columns', function($columns){
    return [
        'cb' => $columns['cb'],
        'thumbnail' => 'Miniature',
        'title' => $columns['title'],
        'date' => $columns['date']
    ];
});

add_filter('manage_artwork_posts_custom_column', function($column, $postId){
    if ($column === 'thumbnail'){
        the_post_thumbnail('thumbnail', $postId);
    }
}, 10, 2);

add_action('admin_enqueue_scripts', function () {
    wp_enqueue_style('admin_letsdoit', get_template_directory_uri() . '/assets/admin.css');
});

add_filter('manage_post_posts_columns', function($columns){
    $newColumns = [];
    foreach($columns as $k => $v){
        if ($k === 'date'){
            $newColumns['sponso'] = 'Sponsored article ?';
        }
        $newColumns[$k] = $v;
    }
    return $newColumns;
});

add_filter('manage_post_posts_custom_column', function($column, $postId){
    if ($column === 'sponso'){
        if (!empty(get_post_meta($postId, SponsoMetaBox::META_KEY, true))){
            $class = 'yes';
        } else{
            $class = 'no';
        }
        echo '<div class="bullet bullet-' . $class . '"></div>';
    }
}, 10, 2);


/**
 * @param WP_Query $query
 */
function letsdoit_pre_get_posts ($query) {
    if (is_admin() || !is_search() || !$query->is_main_query()) {
        return;
    }
    if (get_query_var('sponso') === '1') {
        $meta_query = $query->get('meta_query', []);
        $meta_query[] = [
            'key' => SponsoMetaBox::META_KEY,
            'compare' => 'EXISTS',
        ];
        $query->set('meta_query', $meta_query);
    }
}

function letsdoit_query_vars ($params) {
    $params[] = 'sponso';
    return $params;
}

add_action('pre_get_posts', 'letsdoit_pre_get_posts');
add_filter('query_vars', 'letsdoit_query_vars');