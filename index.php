<?php get_header(); ?>
    <div id="container" class="container">
        <div class="row">
            <?php if(kratos_option('home_side_bar')=='left_side'&&!wp_is_mobile()){ ?>
                <aside id="kratos-widget-area" class="col-md-4 hidden-xs hidden-sm scrollspy">
                    <div id="sidebar" class="affix-top">
                        <?php dynamic_sidebar('sidebar_tool'); ?>
                    </div>
                </aside>
            <?php } ?>
            <section id="main" class="<?php echo (kratos_option('home_side_bar')=='center')?'col-md-12':'col-md-8'; ?>">
            <?php
                if(is_home()){kratos_banner();}
                elseif(is_category()){
            if(kratos_option('show_head_cat')){ ?>
                <div class="kratos-hentry clearfix">
                    <h1 class="kratos-post-header-title">分类：<?php echo single_cat_title('',false); ?></h1>
                    <h1 class="kratos-post-header-title"><?php echo category_description(); ?></h1>
                </div>    
            <?php }
                }elseif(is_tag()){
            if(kratos_option('show_head_tag')){ ?>
                <div class="kratos-hentry clearfix">
                    <h1 class="kratos-post-header-title">标签：<?php echo single_cat_title('',false); ?></h1>
                    <h1 class="kratos-post-header-title"><?php echo category_description(); ?></h1>
                </div>
            <?php }
                }elseif(is_search()){ ?>
                <div class="kratos-hentry clearfix">
                    <h1 class="kratos-post-header-title">搜索结果：<?php the_search_query(); ?></h1>
                </div>                
            <?php }
                if(have_posts()){
                    while(have_posts()){
						the_post();
                        get_template_part('content',get_post_format());
                    }
                }else{ ?>
            <div class="kratos-hentry clearfix">
                    <h1 class="kratos-post-header-title">很抱歉，没有找到任何内容。</h1>
            </div>
            <?php }
                kratos_pages(3);wp_reset_query(); ?>
            </section>
            <?php if(kratos_option('home_side_bar')=='right_side'&&!wp_is_mobile()){ ?>
            <aside id="kratos-widget-area" class="col-md-4 hidden-xs hidden-sm scrollspy">
                <div id="sidebar" class="affix-top">
                    <?php dynamic_sidebar('sidebar_tool'); ?>
                </div>
            </aside>
            <?php } ?>
        </div>
        <?php if(kratos_option('script_tongji')) echo '<script type="text/javascript">'.kratos_option('script_tongji').'</script>'; ?>
    </div>
</div>
<?php get_footer(); ?>