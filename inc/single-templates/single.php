<?php if(kratos_option('side_bar')=='left_side'){ ?>
<aside id="kratos-widget-area" class="col-md-4 hidden-xs hidden-sm scrollspy">
    <div id="sidebar" class="affix-top">
        <?php dynamic_sidebar('sidebar_tool'); ?>
    </div>
</aside>
<?php } ?>
<section id="main" class='<?php echo (kratos_option('side_bar')=='center')?'col-md-12':'col-md-8'; ?>'>
    <?php if(have_posts()){the_post();update_post_caches($posts); ?>
    <article>
        <div class="kratos-hentry kratos-post-inner clearfix">
            <header class="kratos-entry-header">
                <h1 class="kratos-entry-title text-center"><?php the_title(); ?></h1>
                <div class="kratos-post-meta text-center">
                    <span>
                    <i class="fa fa-calendar"></i> <?php echo get_the_date(); ?>
                    <i class="fa fa-commenting-o"></i> <?php comments_number('0','1','%');_e('条评论','moedog'); ?>
                    <i class="fa fa-eye"></i> <?php echo kratos_get_post_views();_e('次阅读','moedog'); ?>  
                    <span class="hd">
                    <i class="fa fa-thumbs-o-up"></i> <?php if(get_post_meta($post->ID,'love',true)){echo get_post_meta($post->ID,'love',true);}else{echo '0'; }_e('人点赞','moedog'); ?>
                    <i class="fa fa-user"></i> <?php the_author(); ?>
                    </span>
                    </span>
                </div>
            </header>
            <div class="kratos-post-content">
            <?php the_content(); ?>
            </div>
            <?php if(kratos_option('post_cc')){ ?>
            <div class="kratos-copyright text-center clearfix">
                <h5><?php _e('本作品采用 <a rel="license nofollow" target="_blank" href="http://creativecommons.org/licenses/by-sa/4.0/">知识共享署名-相同方式共享 4.0 国际许可协议</a> 进行许可','moedog'); ?></h5>
            </div>
            <?php } ?>
            <footer class="kratos-entry-footer clearfix">
                <div class="post-like-donate text-center clearfix" id="post-like-donate">
                <?php if(kratos_option('post_like_donate')) echo '<a href="javascript:;" class="Donate"><i class="fa fa-bitcoin"></i> '.__('打赏','moedog').'</a>'; ?>
                   <a href="javascript:;" id="btn" data-action="love" data-id="<?php the_ID() ?>" class="Love<?php if(isset($_COOKIE['love_'.$post->ID])) echo ' done';?>"><i class="fa fa-thumbs-o-up"></i> <?php _e('点赞','moedog'); ?></a>
                <?php if(kratos_option('post_share')) {
                    echo '<a href="javascript:;" class="Share"><i class="fa fa-share-alt"></i> '.__('分享','moedog').'</a>';
                    require_once(get_template_directory().'/inc/share.php');
                } ?>
                </div>
                <div class="footer-tag clearfix">
                    <div class="pull-left">
                    <i class="fa fa-tags"></i>
                    <?php if(get_the_tags()){the_tags('',' ','');}else{echo '<a>No Tag</a>';}?>
                    </div>
                    <div class="pull-date">
                    <span><?php _e('最后编辑：','moedog');the_modified_date();?></span>
                    </div>
                </div>
            </footer>
        </div>
        <nav class="navigation post-navigation clearfix" role="navigation">
            <?php
            $prev_post = get_previous_post();
            if(!empty($prev_post)){ ?>
            <div class="nav-previous clearfix">
                <a title="<?php echo $prev_post->post_title;?>" href="<?php echo get_permalink($prev_post->ID); ?>">&lt; <?php _e('上一篇','moedog'); ?></a>
            </div>
            <?php }
            $next_post = get_next_post();
            if(!empty($next_post)){ ?>
            <div class="nav-next">
                <a title="<?php echo $next_post->post_title; ?>" href="<?php echo get_permalink($next_post->ID); ?>"><?php _e('下一篇','moedog'); ?> &gt;</a>
            </div>
            <?php } ?>
        </nav>
        <?php comments_template(); ?>
    </article>
    <?php } ?>
</section>
<?php if(kratos_option('side_bar')=='right_side'){ ?>
    <aside id="kratos-widget-area" class="col-md-4 hidden-xs hidden-sm scrollspy">
        <div id="sidebar" class="affix-top">
            <?php dynamic_sidebar('sidebar_tool'); ?>
        </div>
    </aside>
<?php } ?>