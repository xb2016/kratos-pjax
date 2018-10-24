<article class="kratos-hentry clearfix">
<?php if(kratos_option('list_layout')=='old_layout'){ ?>
<div class="kratos-entry-thumb">
    <?php kratos_blog_thumbnail() ?>
</div>    
<div class="kratos-post-inner">
    <header class="kratos-entry-header clearfix">
        <h2 class="kratos-entry-title"><a href="<?php the_permalink() ?>"><?php if(is_sticky()) echo '<span style="font-size:25px;color:#f00">[TOP] </span>';the_title() ?></a></h2>
        <div class="kratos-post-meta">
            <span class="pull-left">
            <a><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></a>
            </span>
            <span class="visible-lg visible-md visible-sm pull-left">
            <?php $category=get_the_category();if($category) echo '<a href="'.get_category_link($category[0]->term_id).'"><i class="fa fa-folder-open-o"></i> '.$category[0]->cat_name.'</a>'; ?>
            <a href="<?php the_permalink() ?>#comments"><i class="fa fa-commenting-o"></i> <?php comments_number('0','1','%');_e('条评论','moedog'); ?></a>
            </span>
            <span class="pull-left">
            <a href="<?php the_permalink() ?>"><i class="fa fa-eye"></i> <?php echo kratos_get_post_views();_e('次阅读','moedog'); ?></a>
            <a href="javascript:;" data-action="love" data-id="<?php the_ID(); ?>" class="Love<?php if(isset($_COOKIE['love_'.$post->ID])) echo ' done';?>"><i class="fa fa-thumbs-o-up"></i> <?php if(get_post_meta($post->ID,'love',true)) echo get_post_meta($post->ID,'love',true); else echo '0';_e('人点赞','moedog'); ?></a>
            <a href="<?php site_url() ?>/?author=<?php the_author_ID() ?>"><i class="fa fa-user"></i> <?php the_author(); ?></a>
            </span>
        </div>
    </header>
    <div class="kratos-entry-content clearfix">
    <p><?php echo wp_trim_words(get_the_excerpt(),kratos_option('w_num')); ?></p>
    </div>
</div>
<?php }else{ ?>
<div class="kratos-entry-border-new clearfix">
    <?php if(is_sticky()) echo '<img class="stickyimg" src="'.get_bloginfo('template_directory').'/static/images/sticky.png"/>'; ?>
    <div class="kratos-entry-thumb-new">
        <?php kratos_blog_thumbnail_new() ?>
    </div>
    <div class="kratos-post-inner-new">
        <header class="kratos-entry-header-new">
            <?php $category=get_the_category();if($category) echo '<a class="label" href="'.get_category_link($category[0]->term_id).'">'.$category[0]->cat_name.'</a>'; ?>
            <h2 class="kratos-entry-title-new"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
        </header>
        <div class="kratos-entry-content-new">
            <p><?php echo wp_trim_words(get_the_excerpt(),kratos_option('w_num')); ?></p>
        </div>
    </div>
    <div class="kratos-post-meta-new">
        <span class="pull-left">
            <a><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></a>
            <a href="<?php the_permalink() ?>#comments"><i class="fa fa-commenting-o"></i> <?php comments_number('0','1','%');_e('条评论','moedog'); ?></a>
        </span>
        <span class="visible-lg visible-md visible-sm pull-left">
            <a href="<?php the_permalink() ?>"><i class="fa fa-eye"></i> <?php echo kratos_get_post_views();_e('次阅读','moedog'); ?></a>
            <a href="javascript:;" data-action="love" data-id="<?php the_ID(); ?>" class="Love<?php if(isset($_COOKIE['love_'.$post->ID])) echo ' done';?>"><i class="fa fa-thumbs-o-up"></i> <?php if(get_post_meta($post->ID,'love',true)) echo get_post_meta($post->ID,'love',true); else echo '0';_e('人点赞','moedog'); ?></a>
            <a href="<?php site_url() ?>/?author=<?php the_author_ID() ?>"><i class="fa fa-user"></i> <?php the_author(); ?></a>
        </span>
        <span class="pull-right">
            <a class="read-more" href="<?php the_permalink() ?>" title="<?php _e('阅读全文','moedog'); ?>"><?php _e('阅读全文','moedog'); ?> <i class="fa fa-chevron-circle-right"></i></a>
        </span>
    </div>
</div>
<?php } ?>
</article>