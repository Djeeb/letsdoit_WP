<?php get_header() ?>

    <h1>See all our artworks</h1>

    <?php if (have_posts()): // https://developer.wordpress.org/themes/basics/the-loop/ ?>
        <div class="row">

            <?php while(have_posts()): the_post(); ?>
                <div class="col-sm-4">
                    <?php get_template_part('parts/card', 'post'); // https://developer.wordpress.org/reference/functions/get_template_part/?>
                </div>
            <?php endwhile ?>
        
        </div>

        <?php letsdoit_pagination() ?>
        <?= paginate_links(); ?>

    <?php else: ?>
        <h1>No articles</h1>
    <?php endif; ?>

<?php get_footer() ?>