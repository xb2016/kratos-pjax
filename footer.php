                <footer>
                    <div id="footer"<?php echo ' style="background:rgba('.kratos_option('footer_color').')"'; ?>>
                        <div class="cd-tool text-center">
                            <div class="<?php if(kratos_option('cd_weixin')) echo 'gotop-box2 '; ?>gotop-box"><div class="gotop-btn"><span class="fa fa-chevron-up"></span></div></div>
                            <?php if(kratos_option('cd_weixin')) echo '<div id="wechat-img" class="wechat-img"><span class="fa fa-weixin"></span><div id="wechat-pic"><img src="'.kratos_option('weixin_image').'"></div></div>'; ?>
                            <div class="search-box">
                                <span class="fa fa-search"></span>
                                <form class="search-form" role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
                                    <input type="text" name="s" id="search" placeholder="Search..." style="display:none"/>
                                </form>
                            </div>
                        </div>
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
                                    <p> © <?php echo date('Y'); ?> <a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a>. All Rights Reserved. | <?php _e('本站已运行','moedog'); ?><span id="span_dt_dt">Loading...</span><br>Theme <a href="https://www.fczbl.vip/787.html" target="_blank" rel="nofollow">Kratos</a> Made by <a href="https://www.vtrois.com" target="_blank" rel="nofollow">Vtrois</a> Modified by <a href="https://www.fczbl.vip" target="_blank" rel="nofollow">MoeDog</a>
                                    <?php if(kratos_option('icp_num')) echo '<br><a href="http://www.miitbeian.gov.cn/" rel="external nofollow" target="_blank">'.kratos_option('icp_num').'</a>';
                                          if(kratos_option('gov_num')) echo '<br><a href="'.kratos_option('gov_link').'" rel="external nofollow" target="_blank"><i class="govimg"></i>'.kratos_option('gov_num').'</a>'; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
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
        </div><?php }
        wp_footer();
        if(kratos_option('script_tongji')||kratos_option('add_script')){ ?>
            <script type="text/javascript">
            <?php echo kratos_option('script_tongji');echo kratos_option('add_script'); ?>
            </script><?php
        }
        if(kratos_option('ap_footer')){ ?>
        <div class="aplayer-footer">
            <div class="ap-f" id="ap-f"></div>
            <script>
            $(function(){
                $.ajax({
                    url:"<?php echo kratos_option('ap_json'); ?>",
                    success:function(e){
                        var a = new APlayer({
                            element:document.getElementById("ap-f"),
                            autoplay:<?php if(kratos_option('ap_autoplay')) echo 'true'; else echo 'false'; ?>,
                            fixed:true,
                            loop:"<?php echo kratos_option('ap_loop'); ?>",
                            order:"<?php echo kratos_option('ap_order'); ?>",
                            listFolded:true,
                            showlrc:3,
                            theme:"#e6d0b2",
                            listmaxheight:"200px",
                            music:eval(e)
                        });
                        window.aplayers || (window.aplayers = []),
                        window.aplayers.push(a)
                    }
                })
            })
            </script>
        </div><?php }
        if(kratos_option('site_snow')&&(!wp_is_mobile()||wp_is_mobile()&&kratos_option('snow_xb2016_mobile'))){ ?>
        <div id="xb_snow">
            <canvas id="Snow"></canvas>
            <script>
            (function(){var requestAnimationFrame=window.requestAnimationFrame||window.mozRequestAnimationFrame||window.webkitRequestAnimationFrame||window.msRequestAnimationFrame||function(callback){window.setTimeout(callback,1000/60);};window.requestAnimationFrame=requestAnimationFrame;})();
            (function(){
                var flakes=[],canvas=document.getElementById("Snow"),ctx=canvas.getContext("2d"),flakeCount=<?php echo kratos_option('snow_xb2016_flakecount'); ?>,mX=-100,mY=-100;
                canvas.width=window.innerWidth;
                canvas.height=window.innerHeight;
                function snow(){
                    ctx.clearRect(0,0,canvas.width,canvas.height);
                    for(var i=0;i<flakeCount;i++){
                        var flake=flakes[i],x=mX,y=mY,minDist=<?php echo kratos_option('snow_xb2016_mindist'); ?>,x2=flake.x,y2=flake.y;
                        var dist=Math.sqrt((x2-x)*(x2-x)+(y2-y)*(y2-y)),dx=x2-x,dy=y2-y;
                        if(dist<minDist){
                            var force=minDist/(dist*dist),xcomp=(x-x2)/dist,ycomp=(y-y2)/dist,deltaV=force/2;
                            flake.velX-=deltaV*xcomp;
                            flake.velY-=deltaV*ycomp;
                        }else{
                            flake.velX*=0.98;
                            if(flake.velY<=flake.speed){flake.velY = flake.speed;}
                            flake.velX+=Math.cos(flake.step+=.05)*flake.stepSize;
                        }
                        ctx.fillStyle="rgba(<?php echo kratos_option('snow_xb2016_snowcolor'); ?>,"+flake.opacity+")";
                        flake.y+=flake.velY;
                        flake.x+=flake.velX;
                        if(flake.y>=canvas.height||flake.y<=0){reset(flake);}
                        if(flake.x>=canvas.width||flake.x<=0){reset(flake);}
                        ctx.beginPath();
                        ctx.arc(flake.x,flake.y,flake.size,0,Math.PI*2);
                        ctx.fill();
                    }
                    requestAnimationFrame(snow);
                };
                function reset(flake){
                    flake.x=Math.floor(Math.random()*canvas.width);
                    flake.y=0;
                    flake.size=(Math.random()*3)+2;
                    flake.speed=(Math.random()*1)+0.5;
                    flake.velY=flake.speed;
                    flake.velX=0;
                    flake.opacity=(Math.random()*0.5)+0.3;
                }
                function init(){
                    for(var i=0;i<flakeCount;i++){
                        var x=Math.floor(Math.random()*canvas.width),y=Math.floor(Math.random()*canvas.height),size=(Math.random()*3)+<?php echo kratos_option('snow_xb2016_size'); ?>,speed=(Math.random()*1)+<?php echo kratos_option('snow_xb2016_speed'); ?>,opacity=(Math.random()*0.5)+<?php echo kratos_option('snow_xb2016_opacity'); ?>;
                        flakes.push({speed:speed,velY:speed,velX:0,x:x,y:y,size:size,stepSize:(Math.random())/30*<?php echo kratos_option('snow_xb2016_stepsize'); ?>,step:0,angle:180,opacity:opacity});
                    }
                    snow();
                };
                document.addEventListener("mousemove",function(e){mX=e.clientX,mY=e.clientY});
                window.addEventListener("resize",function(){canvas.width=window.innerWidth;canvas.height=window.innerHeight;});
                init();
            })();
            </script>
        </div>
        <?php } ?>
    </body>
</html>