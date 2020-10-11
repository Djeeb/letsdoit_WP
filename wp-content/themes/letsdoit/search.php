<?php get_header() ?>

    <form class="form-inline">
    <input type="search" name="s" class="form-control mb-2 mr-sm-2" value="<?= get_search_query() ?>" placeholder="Your search">

    <div class="form-check mb-2 mr-sm-2">
        <input class="form-check-input" type="checkbox" value="1" name="sponso" id="inlineFormCheck" <?= checked('1', get_query_var('sponso')) ?>>
        <label class="form-check-label" for="inlineFormCheck">
        Sponsored article only
        </label>
    </div>

    <button type="submit" class="btn btn-primary mb-2">Submit</button>
    </form>

    <h1 class="mb-4">Result for your search "<?= get_search_query() ?>"</h1>

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