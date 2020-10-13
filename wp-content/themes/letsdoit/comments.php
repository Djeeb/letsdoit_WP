<?php

use Letsdoit\CommentWalker;

$count = absint(get_comments_number());
?>

<?php 
if ($count > 0): ?>
<h2><?= $count ?> comment<?= $count > 1 ? 's' : '' ?></h2>
<?php else: ?>
<h2>Leave a comment</h2>
<?php endif ?>

<?php if (comments_open()): ?>
<?php comment_form(['title_reply' => '']) ?><?php // https://developer.wordpress.org/reference/functions/comment_form/ ?>
<?php endif ?>

<?php wp_list_comments(['style' => 'div', 'walker' => new CommentWalker()]) ?>

<?php paginate_comments_links() ?>

