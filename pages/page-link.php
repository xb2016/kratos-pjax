<?php
/**
template name: 友情链接模板
*/
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
                        <div class="kratos-post-content-l">
                            <h2 class="title-h2" style="text-align:center;font-size:18pt"><?php _e('dalao们','moedog'); ?></h2>
                            <p style="text-align:center"><span style="color:#999999"><?php _e('dalao们的链接，每次刷新随机排序~','moedog'); ?></span></p>
                            <div class="linkpage">
                                <hr/>
                                <ul><?php
                                $bookmarks = get_bookmarks(array('orderby'=>'rand'));
                                if(!empty($bookmarks)){
                                    foreach($bookmarks as $bookmark){
                                        $friendimg = $bookmark->link_image;
                                        if(empty($friendimg)) $friendimg = get_stylesheet_directory_uri().'/static/images/avatar.png';
                                        echo '<li><a href="'.$bookmark->link_url.'" target="_blank"><img src="'.$friendimg.'"><h4>'.$bookmark->link_name.'</h4><p>'.$bookmark->link_description.'</p></a></li>';
                                    }
                                } ?>
                                </ul>
                                <hr/>
                            </div>
                            <?php the_content(); ?>
                        </div>
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
        </div><?php
        if(current_user_can('manage_options')&&is_single()||is_page()){ ?><div class="cd-tool text-center"><div class="<?php if(kratos_option('cd_weixin')&&(kratos_option('site_girl')&&!wp_is_mobile())) echo 'edit-box3 '; elseif(kratos_option('cd_weixin')||(kratos_option('site_girl')&&!wp_is_mobile())) echo 'edit-box2 '; ?>edit-box"><?php echo edit_post_link('<span class="fa fa-pencil"></span>'); ?></div></div><?php } ?>
    </div>
</div>
<?php get_footer(); ?>