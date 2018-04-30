<?php if(kratos_option('head_mode')=='pic'){ ?>
    <div class="kratos-start kratos-hero-2">
        <div class="kratos-overlay"></div>
        <div class="kratos-cover kratos-cover_2 text-center" style="background-image: url(<?php echo kratos_option('background_image'); ?>);">
            <div class="desc desc2 animate-box">
                <a href="<?php echo get_bloginfo('url'); ?>"><h2><?php if(is_category()) echo single_cat_title('',false);else echo kratos_option('background_image_text1'); ?></h2><br><span><?php if(is_category()) echo category_description();else echo  kratos_option('background_image_text2'); ?></span></a>
            </div>
        </div>
    </div>
<?php }else{ ?>
    <div class="kratos-start kratos-hero"></div>
<?php } ?>
    <div id="kratos-blog-post" <?php if(kratos_option('background_mode')=='color') echo 'style="background:'.kratos_option('background_index_color').'"'; ?>>