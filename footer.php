                <footer>
                    <div id="footer"<?php echo ' style="background:rgba('.kratos_option('footer_color').')"'; ?>>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3 footer-list text-center">
                                    <p class="kratos-social-icons"><?php
                                        echo (!kratos_option('social_weibo'))?'':'<a target="_blank" rel="nofollow" href="'.kratos_option('social_weibo').'"><i class="fa fa-weibo"></i></a>';
                                        echo (!kratos_option('social_tweibo'))?'':'<a target="_blank" rel="nofollow" href="'.kratos_option('social_tweibo').'"><i class="fa fa-tencent-weibo"></i></a>';
                                        echo (!kratos_option('social_mail'))?'':'<a target="_blank" rel="nofollow" href="'.kratos_option('social_mail').'"><i class="fa fa-envelope"></i></a>';
                                        echo (!kratos_option('social_twitter'))?'':'<a target="_blank" rel="nofollow" href="'.kratos_option('social_twitter').'"><i class="fa fa-twitter"></i></a>';
                                        echo (!kratos_option('social_facebook'))?'':'<a target="_blank" rel="nofollow" href="'.kratos_option('social_facebook').'"><i class="fa fa-facebook-official"></i></a>';
                                        echo (!kratos_option('social_linkedin'))?'':'<a target="_blank" rel="nofollow" href="'.kratos_option('social_linkedin').'"><i class="fa fa-linkedin-square"></i></a>';
                                        echo (!kratos_option('social_github'))?'':'<a target="_blank" rel="nofollow" href="'.kratos_option('social_github').'"><i class="fa fa-github"></i></a>'; ?>
                                    </p>
                                    <p> © <?php echo date('Y'); ?> <a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a>. All Rights Reserved. | <?php _e('已在风雨中度过','moedog'); ?> <span id="span_dt_dt">Loading...</span><br>Theme <a href="https://moedog.org/787.html" target="_blank" rel="nofollow">Kratos</a> Made by <a href="https://www.vtrois.com" target="_blank" rel="nofollow">Vtrois</a> Modified by <a href="https://moedog.org" target="_blank" rel="nofollow">Moedog</a><?php if(kratos_option('sitemap')) echo ' | <a href="'.get_option('home').'/sitemap.html" target="_blank">Sitemap</a>'; ?>
                                    <?php if(kratos_option('icp_num')) echo '<br><a href="https://beian.miit.gov.cn" rel="external nofollow" target="_blank">'.kratos_option('icp_num').'</a>';
                                          if(kratos_option('gov_num')) echo '<br><a href="'.kratos_option('gov_link').'" rel="external nofollow" target="_blank"><i class="govimg"></i>'.kratos_option('gov_num').'</a>'; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="cd-tool text-center">
                            <?php if(kratos_option('site_girl')&&!wp_is_mobile()){ ?><div class="<?php if(kratos_option('cd_weixin')) echo 'waifu-btn2 '; ?>waifu-btn" title="Waifu"><span class="fa fa-venus"></span></div><?php } ?>
                            <div class="<?php if(kratos_option('cd_weixin')) echo 'gotop-box2 '; ?>gotop-box"><div class="gotop-btn"><span class="fa fa-chevron-up"></span></div></div>
                            <?php if(kratos_option('cd_weixin')) echo '<div id="wechat-img" class="wechat-img"><span class="fa fa-weixin"></span><div id="wechat-pic"><img src="'.kratos_option('weixin_image').'"></div></div>'; ?>
                            <div class="search-box">
                                <span class="fa fa-search"></span>
                                <form class="search-form" role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
                                    <input type="text" name="s" id="search" placeholder="Search..." style="display:none"/>
                                </form>
                            </div>
                        </div>
                        <?php if(kratos_option('site_girl')&&!wp_is_mobile()){ ?>
                        <div class="waifu">
                            <div class="waifu-tips"></div>
                            <canvas id="live2d" width="220" height="250" class="live2d"></canvas>
                            <div class="waifu-tool">
                                <span class="fa fa-home"></span>
                                <span class="fa fa-comments"></span>
                                <span class="fa fa-drivers-license-o"></span>
                                <span class="fa fa-street-view"></span>
                                <span class="fa fa-camera"></span>
                                <span class="fa fa-info-circle"></span>
                                <span class="fa fa-close"></span>
                            </div>
                        </div>
                        <?php }if(kratos_option('ap_footer')){ ?>
                        <div class="aplayer-footer">
                            <div id="ap-footer" data-json="<?php echo kratos_option('ap_json'); ?>" data-autoplay="<?php echo kratos_option('ap_autoplay'); ?>" data-loop="<?php echo kratos_option('ap_loop'); ?>" data-order="<?php echo kratos_option('ap_order'); ?>"></div>
                        </div>
                        <?php }if(kratos_option('site_snow')&&(!wp_is_mobile()||wp_is_mobile()&&kratos_option('snow_xb2016_mobile'))){ ?>
                        <div class="xb-snow">
                            <canvas id="Snow" data-count="<?php echo kratos_option('snow_xb2016_flakecount'); ?>" data-dist="<?php echo kratos_option('snow_xb2016_mindist'); ?>" data-color="<?php echo kratos_option('snow_xb2016_snowcolor'); ?>" data-size="<?php echo kratos_option('snow_xb2016_size'); ?>" data-speed="<?php echo kratos_option('snow_xb2016_speed'); ?>" data-opacity="<?php echo kratos_option('snow_xb2016_opacity'); ?>" data-step="<?php echo kratos_option('snow_xb2016_stepsize'); ?>"></canvas>
                        </div>
                        <?php } ?>
                    </div>
                </footer>
            </div>
        </div>
        <?php wp_footer();if(kratos_option('script_tongji')||kratos_option('add_script')){ ?>
        <script type="text/javascript">
            <?php echo kratos_option('script_tongji');echo kratos_option('add_script'); ?>
        </script>
        <?php } ?>
    </body>
</html>