<?php get_header() ?>

<h1><?= esc_html(get_queried_object()->name) ?></h1>
<p>
    <?= esc_html(get_queried_object()->description) ?>
</p>

<?php $disciplines = get_terms(['taxonomy' => 'discipline']); // https://developer.wordpress.org/reference/functions/get_terms/ ?>
<?php if (is_array($sports)): ?>
<ul class="nav nav-pills">
    <?php foreach($disciplines as $discipline): ?>
    <li class="nav-item my-4">
        <a href="<?= get_term_link($discipline) ?>" 
        class="nav-link <?= is_tax('discipline', $discipline->term_id) ? 'active' : '' ?>">
        <?= $discipline->name ?></a>
    </li>
    <?php endforeach; ?>
</ul>
<?php endif ?>

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