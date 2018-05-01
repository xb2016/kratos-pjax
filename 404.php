<!DOCTYPE HTML>
<html>
  <head>
    <title><?php wp_title('-',true,'right'); ?></title>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index,follow">
    <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telphone=no, email=no">
    <meta name="description" itemprop="description" content="<?php kratos_description(); ?>">
    <meta name="keywords" content="<?php kratos_keywords(); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo kratos_option('site_ico'); ?>">
    <?php wp_head();wp_print_scripts('jquery');?>
    <style><?php
        echo '#offcanvas-menu{background:rgba('.kratos_option('mobi_color').')}';
        if(kratos_option('site_bw')) echo 'html{filter:grayscale(100%);-webkit-filter:grayscale(100%);-moz-filter:grayscale(100%);-ms-filter:grayscale(100%);filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1);filter:gray;-webkit-filter:grayscale(1)}';
        if(kratos_option('background_mode')=='image'&&!wp_is_mobile()&&!kratos_option('site_bw')) echo '@media(min-width:768px){.kratos-hentry{background-color:rgba(253,253,253,.85)!important}body.custom-background{background-image:url('.kratos_option('background_index_image').');background-size:cover;background-attachment:fixed}}'; ?>
    </style>
  </head>
    <?php flush(); ?>
    <body <?php if(kratos_option('background_mode')=='image') echo 'class="custom-background"'; ?>>
        <div id="kratos-wrapper">
            <div id="kratos-page">
                <div id="kratos-header">
                    <header id="kratos-header-section" class="color-banner" style="background:rgba(22,23,26,.9)">
                        <div class="container">
                            <div class="nav-header">
                                <div class="color-logo"><a href="javascript:window.location.href='/'"><?php if(!kratos_option('banner_logo')) echo bloginfo('name'); else echo '<img src="'.kratos_option('banner_logo').'">'; ?></a></div>
                            </div>
                        </div>
                    </header>
                </div>
                <div class="kratos-start kratos-hero"></div>
                <div id="kratos-blog-post">
                    <div id="main" class="page404">
                        <div class="kratos-hentry kratos-post-inner clearfix">
                            <div class="col-md-7">
                                <img style="width:100%" src="<?php echo bloginfo('template_url'); ?>/images/404.png">
                            </div>
                            <div class="col-md-5 text-center errtxt">
                                <h3><?php echo kratos_option('error_text1'); ?></h3>
                                <h5><?php echo kratos_option('error_text2'); ?></h5>
                                <p><a href="javascript:history.go(-1)" class="back-p">返回上页</a><a href="javascript:window.location.href='/'" class="back-index">返回主页</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php get_footer(); ?>