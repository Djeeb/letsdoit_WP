<?php get_header() ?>
<?php // https://developer.wordpress.org/themes/basics/the-loop/?>
    <?php if (have_posts()): ?>
        <div class="row">

            <?php while(have_posts()): the_post(); ?>
                <div class="col-sm-4">
                    <?php // https://getbootstrap.com/docs/4.5/components/card/ ?>
                    <div class="card">
                        <?php the_post_thumbnail('medium', ['class' => 'card-img-top', 'alt' => '', 'style' => 'height: auto;']) ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php the_title() ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php the_category() ?></h6>
                            <p class="card-text">
                                <?php the_excerpt() ?>
                            </p>
                            <a href="<?php the_permalink() ?>" class="card-link">View more</a>
                        </div>
                    </div>
                </div>
            <?php endwhile ?>
        
        </div>

        <?php letsdoit_pagination() ?>

        

        <?= paginate_links(); ?>

    <?php else: ?>
        <h1>No articles</h1>
    <?php endif; ?>

<?php get_footer() ?>