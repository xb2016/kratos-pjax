<?php get_header(); ?>
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
                        <header class="kratos-entry-header">
                            <h1 class="kratos-entry-title text-center"><?php the_title(); ?></h1>
                        </header>
                        <div class="kratos-post-content"><?php the_content(); ?></div>
                        <?php if(kratos_option('page_cc')){ ?>
                        <div class="kratos-copyright text-center clearfix">
                            <h5><?php _e('本作品采用 <a rel="license nofollow" target="_blank" href="http://creativecommons.org/licenses/by-sa/4.0/">知识共享署名-相同方式共享 4.0 国际许可协议</a> 进行许可','moedog'); ?></h5>
                        </div>
                        <?php } ?>
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
        </div><?php
        if(current_user_can('manage_options')&&is_single()||is_page()){ ?><div class="cd-tool text-center"><div class="<?php if(kratos_option('cd_weixin')&&(kratos_option('site_girl')&&!wp_is_mobile())) echo 'edit-box3 '; elseif(kratos_option('cd_weixin')||(kratos_option('site_girl')&&!wp_is_mobile())) echo 'edit-box2 '; ?>edit-box"><?php echo edit_post_link('<span class="fa fa-pencil"></span>'); ?></div></div><?php } ?>
    </div>
</div>
<?php get_footer(); ?>