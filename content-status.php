<article class="kratos-hentry clearfix">
    <div class="kratos-status">
    <i class="fa fa-refresh"></i>
        <div class="kratos-status-inner">
            <header><?php the_content() ?></header>
            <footer><?php echo get_the_date('Y年m月d日 H:i'); ?> • <a href="<?php the_permalink() ?>"><?php comments_number('0','1','%'); ?>条评论</a> • <?php echo kratos_get_post_views(); ?>次阅读</footer>
        </div>
    </div>
</article>