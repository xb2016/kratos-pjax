<article class="kratos-hentry clearfix">
    <div class="kratos-status">
    <i class="fa fa-refresh"></i>
        <div class="kratos-status-inner">
            <header><?php the_content() ?></header>
            <footer><?php echo get_the_date();echo get_the_date(' H:i'); ?> • <a href="<?php the_permalink() ?>"><?php comments_number('0','1','%');_e('条评论','moedog'); ?></a> • <?php echo kratos_get_post_views();_e('次阅读','moedog'); ?></footer>
        </div>
    </div>
</article>