<?php
/**
template name: 文章归档模板
*/
$arc_tags = wp_tag_cloud(array(
    'unit'=>'px',
    'smallest'=>14,
    'largest'=>14,
    'number'=>25,
    'format'=>'flat',
    'orderby'=>'cont',
    'order'=>'RAND',
    'echo'=>FALSE
));
$the_query = new WP_Query('posts_per_page=-1&ignore_sticky_posts=1');
$year=0;
while($the_query->have_posts()):
    $the_query->the_post();
    $year_tmp = get_the_time('Y');
    if($year!=$year_tmp){
        $year = $year_tmp;
        $output .= '<div class="collection-title"><h2 class="archive-year" id="archive-year-'.$year.'">'.$year.'</h2></div>';
    }
    $output .= '<article class="post post-type-normal" itemtype="http://schema.org/Article"><header class="post-header"><h2 class="post-title"><a class="post-title-link" href="'.get_permalink().'" itemprop="url"><span itemprop="name">'.get_the_title().'</span></a></h2><div class="post-meta"><time class="post-time" itemprop="dateCreated">'.get_the_time('m-d').'</time></div></header></article>';
endwhile;
get_header(); ?>
    <div id="container" class="container">
        <div class="row">
            <?php if(kratos_option('page_side_bar')=='left_side'){ ?>
                <aside id="kratos-widget-area" class="col-md-4 hidden-xs hidden-sm scrollspy">
                    <div id="sidebar" class="affix-top">
                        <?php dynamic_sidebar('sidebar_tool'); ?>
                    </div>
                </aside>
            <?php } ?>
            <section id="main" class='<?php echo (kratos_option('page_side_bar')=='center')?'col-md-12':'col-md-8'; ?>'>
            <?php if(have_posts()){the_post(); ?>
                <article>
                    <div class="kratos-hentry kratos-post-inner clearfix">
                        <div class="kratos-post-content">
                            <div id="archives">
                                <h2 class="title-h2" style="text-align:center;font-size:18pt"><?php _e('文章归档','moedog'); ?></h2>
                                <p style="text-align:center"><span style="color:#999"><?php _e('当前共有','moedog');echo wp_count_posts()->publish;_e('篇公开日志，','moedog');echo wp_count_posts('page')->publish;_e('个公开页面。 (゜-゜)つロ 干杯~','moedog'); ?></span></p>
                            <hr/>
                                <h4><?php _e('Tags','moedog'); ?></h4>
                                <div class="arc-tag">
                                <?php echo $arc_tags; ?>
                                </div>
                            <hr/>
                                <h4><?php _e('Archives','moedog'); ?></h4>
                                <div id="posts" class="posts-collapse">
                                <?php echo $output; ?>
                                </div>
                            </div>
                            <hr/>
                        </div>
                        <?php if(kratos_option('page_like_donate')||kratos_option('page_share')){ ?>
                        <footer class="kratos-entry-footer clearfix">
                            <div class="post-like-donate text-center clearfix" id="post-like-donate"><?php
                                if(kratos_option('page_like_donate')) echo '<a href="javascript:;" class="Donate"><i class="fa fa-bitcoin"></i> '.__('打赏','moedog').'</a>';
                                if(kratos_option('page_share')){
                                    echo '<a href="javascript:;" class="Share"><i class="fa fa-share-alt"></i> '.__('分享','moedog').'</a>';
                                    require_once(get_template_directory().'/inc/share.php');
                                } ?>
                            </div>
                        </footer>
                        <?php } ?>
                    </div>
                    <?php comments_template(); ?>
                </article>
            <?php } ?>
            </section>
            <?php if(kratos_option('page_side_bar')=='right_side'){ ?>
            <aside id="kratos-widget-area" class="col-md-4 hidden-xs hidden-sm scrollspy">
                <div id="sidebar" class="affix-top">
                    <?php dynamic_sidebar('sidebar_tool'); ?>
                </div>
            </aside>
            <?php } ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>