<?php get_header(); ?>
    <div id="container" class="container">
        <div class="row">
        <?php get_template_part('/inc/single-templates/single',get_post_format()); ?>
        </div><?php
        if(current_user_can('manage_options')&&is_single()||is_page()){ ?><div class="cd-tool text-center"><div class="<?php if(kratos_option('cd_weixin')&&(kratos_option('site_girl')&&!wp_is_mobile())) echo 'edit-box3 '; elseif(kratos_option('cd_weixin')||(kratos_option('site_girl')&&!wp_is_mobile())) echo 'edit-box2 '; ?>edit-box"><?php echo edit_post_link('<span class="fa fa-pencil"></span>'); ?></div></div><?php } ?>
    </div>
</div>
<?php get_footer(); ?>