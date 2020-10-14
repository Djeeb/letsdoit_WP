<?php

require_once('walker/CommentWalker.php');
require_once('options/apparence.php');
require_once('options/cron.php');

function letsdoit_supports (){
    add_theme_support('title-tag'); // https://developer.wordpress.org/reference/functions/add_theme_support/
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    add_theme_support('html5');
    register_nav_menu('header', 'menu header');
    register_nav_menu('footer', 'menu footer');
    add_image_size('post-thumbnail', 350, 215, true);
}

function letsdoit_register_assets(){
    wp_register_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', []); // https://developer.wordpress.org/reference/functions/wp_register_style/
    wp_register_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', ['popper', 'jquery'], false, true); // https://getbootstrap.com/docs/4.5/getting-started/introduction/
    wp_register_script('popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js', [], false, true);
    if (!is_customize_preview()){
        wp_deregister_script('jquery'); // Disable Bootstrap's default jQuery
        wp_register_script('jquery', 'https://code.jquery.com/jquery-3.5.1.slim.min.js', [], false, true); // Enable our Bootstrap
    }
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

require_once 'widgets/YoutubeWidget.php';

function lestdoit_register_widget(){
    register_widget(YoutubeWidget::class);
    register_sidebar([
        'id' => 'homepage',
        'name' => __('Sidebar Home', 'letsdoit'),
        'description' => 'Here the description',
        'before_widget' => '<div class="p-4 %2$s" id="%1$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="font-italic">',
        'after_title' => '</h4>'
    ]);
}

add_action('widgets_init', 'lestdoit_register_widget');

add_filter('comment_form_default_fields', function ($fields){
    $fields['author'] = <<<HTML
    <div class="form-group"><label for="author">Author*</label><input class="form-control" name="author" id="author" required></div>
HTML;
    $fields['email'] = <<<HTML
    <div class="form-group"><label for="email">Email*</label><input class="form-control" name="email" id="email" required></div>
HTML;
    $fields['url'] = <<<HTML
    <div class="form-group"><label for="url">Website*</label><input class="form-control" name="url" id="url" required></div>
HTML;
    $fields['cookies'] = <<<HTML
    <div class="form-check"><input class="form-check-input" type="checkbox" value="" id="defaultCheck1"><label for="cookies">Save my name, e-mail and website in the browser for my next comment.</label></div>
HTML;
    return $fields;
});

add_action('after_switch_theme', 'flush_rewrite_rules');

add_action('switch_theme', 'flush_rewrite_rules');