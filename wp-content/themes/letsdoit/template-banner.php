<?php
/**
 * Template Name: Page with banner
 * Template Post Type: page, post
 */
?>

<?php get_header() ?>

    <?php // https://developer.wordpress.org/themes/basics/the-loop/?>
    <?php if (have_posts()): while(have_posts())  : the_post(); ?>
            <p>Here the banner</p>
            <h1><?php the_title() ?></h1>
            <p>
                <img src="<?php the_post_thumbnail_url(); ?>" alt="" style="width:100%; height:auto;">
            </p>
            <?php the_content() ?>
    <?php endwhile; endif; ?>

<?php get_footer() ?>