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
$year=0;$mon=0;$i=0;$j=0;
while($the_query->have_posts()):
    $the_query->the_post();
    $year_tmp = get_the_time('Y');
    $mon_tmp = get_the_time('m');
    $y=$year;$m=$mon;
    if($mon!=$mon_tmp&&$mon>0) $output .= '</div></section>';
    if($year!=$year_tmp&&$year>0) $output .= '</div>';
    if($year!=$year_tmp){
        $year = $year_tmp;
        $output .= '<h4 class="al_year">'.$year.' 年</h4><div class="al_mon_list">';
    }
    if($mon!=$mon_tmp){
        $mon = $mon_tmp;
        $output .= '<section id="mon" style="overflow:hidden"><div class="al_mon">◉ '.$mon.' 月</div><div class="mon_arc" style="display:none">';    
    }
    $output .= '<div class="arc-t"><div class="arc-tile"><a href="'.get_permalink().'">'.get_the_title().'（'.get_comments_number('0','1','%').'）</a><br><span>'.get_the_time('y-m-d').'</span></div></div>';
endwhile;
$output .= '</div></section></div>';
get_header(); ?>
    <div id="container" class="container">
        <div class="row">
            <?php if(kratos_option('page_side_bar')=='left_side'&&!wp_is_mobile()){ ?>
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
                        <h2 class="title-h2" style="text-align:center;font-size:18pt">文章归档</h2>
                        <p style="text-align:center"><span style="color:#999">当前共有<?php echo wp_count_posts()->publish; ?>篇公开文章，<?php echo wp_count_posts('page')->publish; ?>个公开页面。点击月份可展开文章~<a href="javascript:;" id="al_collapse" style="color:#999;display:none">[折叠全部]</a><a href="javascript:;" id="al_expand" style="color:#999">[展开全部]</a></span></p>
                        <hr/>
                        <h4>Tags</h4>
                        <div class="arc-tag">
                        <?php echo $arc_tags; ?>
                        </div>
                        <?php echo $output; ?>
                        </div>
                        <hr/>
                        </div>
                        <script type="text/javascript">
                            $('#archives section#mon').each(function(){
                                var num=$(this).find('.arc-t').size();
                                var text=$(this).find('.al_mon').text();
                                $(this).find('.al_mon').html(text+'（'+num+' 篇文章）');
                            });
                            $('#archives h4.al_year').click(function(){
                                $(this).next().slideToggle(400);return false;
                            });
                            $('#archives div.al_mon').click(function(){
                                $(this).next().slideToggle(400);return false;
                            });
                            $('#al_collapse').click(function(){
                                $('.mon_arc').hide(400);$('#al_collapse').hide();$('#al_expand').show();
                            });
                            $('#al_expand').click(function(){
                                $('.mon_arc').show(400);$('#al_expand').hide();$('#al_collapse').show();
                            });
                        </script>
                        <?php if(kratos_option('page_cc')){ ?>
                        <div class="kratos-copyright text-center clearfix">
                            <h5>本作品采用 <a rel="license nofollow" target="_blank" href="http://creativecommons.org/licenses/by-sa/4.0/">知识共享署名-相同方式共享 4.0 国际许可协议</a> 进行许可</h5>
                        </div>
                        <?php } ?>
                        <?php if(kratos_option('page_like_donate')||kratos_option('page_share')){ ?>
                        <footer class="kratos-entry-footer clearfix">
                            <div class="post-like-donate text-center clearfix" id="post-like-donate"><?php
                                if(kratos_option('page_like_donate')) echo '<a href="javascript:;" class="Donate"><i class="fa fa-bitcoin"></i> 打赏</a>';
                                if(kratos_option('page_share')){
                                    echo '<a href="javascript:;" class="Share"><i class="fa fa-share-alt"></i> 分享</a>';
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
            <?php if(kratos_option('page_side_bar')=='right_side'&&!wp_is_mobile()){ ?>
            <aside id="kratos-widget-area" class="col-md-4 hidden-xs hidden-sm scrollspy">
                <div id="sidebar" class="affix-top">
                    <?php dynamic_sidebar('sidebar_tool'); ?>
                </div>
            </aside>
            <?php } ?>
        </div>
    </div>
    <?php if(kratos_option('script_tongji')) echo '<script type="text/javascript">'.kratos_option('script_tongji').'</script>'; ?>
</div>
<?php get_footer(); ?>