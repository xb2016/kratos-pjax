<?php
/**
Template Name: 代码高亮转换
*/
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
                            <h2 class="title-h2" style="text-align:center;font-size:20px">代码高亮转换</h2>
                            <style>textarea{background:#fefefe;border:1px solid #B9B9B9}#wrapper{width:980px;margin:10px auto;padding:5px}#main_box{background:#fff;margin:10px 0 20px 0;padding:10px;border-top:3px solid #666;border-bottom:1px solid #666;border-left:1px solid #adadad;border-right:1px solid #adadad}#main_box h2{font-size:14px;margin:0 0 10px 10px}.options{margin:0 0 0 20px}.options_no{display:none}.render{float:right}button{color:#fff;background:#666;border:1px solid #fff}#preview{margin:0;color:#fff;width:100%;height:100%}.dp-highlighter {border:1px solid ##B9B9B9}</style>
                            <div id="main_box">
                                <h2>输入源代码</h2>
                                <textarea title="输入源代码." class="php" id="sourceCode" style="width: 100%" name="sourceCode" rows="6"></textarea>
                            </div>
                            <div id="main_box">
                                <h2>转换设置</h2>
                                <span class="options">选择语言:&nbsp;&nbsp;<select onchange="document.getElementById('sourceCode').className=this.value"><option value="java">java</option><option value="xml">xml</option><option value="sql">sql</option><option value="jscript">jscript</option><option value="groovy">groovy</option><option value="css">css</option><option value="cpp">cpp</option><option value="c#">c#</option><option value="python">python</option>vb<option value="perl">perl</option><option value="php" selected="selected">php</option><option value="ruby">ruby</option><option value="delphi">delphi</option></select></span><span class="options">选项：&nbsp;<input id="showGutter" checked="checked" type="checkbox"> 显示行号<input id="firstLine" checked="checked" type="checkbox" style="margin-left:15px"> 起始为1<span class="options_no"><input id="showControls" type="checkbox"> 工具栏<input id="collapseAll" type="checkbox"> 折叠<input id="showColumns" type="checkbox"> 显示列数</span></span><span class="render"><button style="width:70px;height:30px;" onclick="generateCode()">转&nbsp;&nbsp;换</button><button style="width:70px;height:30px;margin-left:15px" onclick="clearText()">清&nbsp;&nbsp;除</button></span>
                            </div>
                            <div id="main_box">
                                <h2>HTML 代码</h2>
                                <textarea id="htmlCode" style="width: 100%" name="htmlCode" rows="6"></textarea>
                            </div>
                            <div id="main_box">
                                <h2>HTML 预览</h2>
                                <div id="preview"></div>
                            </div>
                            <script src="https://cdn.jsdelivr.net/gh/xb2016/kratos-pjax@0.2.6/js/h/shCore.js"></script>
                            <script src="https://cdn.jsdelivr.net/gh/xb2016/kratos-pjax@0.2.6/js/h/rendered.js"></script>
                        </div>
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
</div>
<?php get_footer(); ?>