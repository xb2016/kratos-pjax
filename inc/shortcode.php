<?php
function success($atts,$content=null,$code=""){
    $return = '<div class="alert alert-success">';
    $return .= do_shortcode($content);
    $return .= '</div>';
    return $return;
}
add_shortcode('success','success');
function info($atts,$content=null,$code=""){
    $return = '<div class="alert alert-info">';
    $return .= do_shortcode($content);
    $return .= '</div>';
    return $return;
}
add_shortcode('info','info');
function warning($atts,$content=null,$code=""){
    $return = '<div class="alert alert-warning">';
    $return .= do_shortcode($content);
    $return .= '</div>';
    return $return;
}
add_shortcode('warning','warning');
function danger($atts,$content=null,$code=""){
    $return = '<div class="alert alert-danger">';
    $return .= do_shortcode($content);
    $return .= '</div>';
    return $return;
}
add_shortcode('danger','danger');
function wymusic($atts,$content=null,$code=""){
    extract(shortcode_atts(array("autoplay"=>'0'),$atts));
    $return = '<iframe style="width:100%" frameborder="no" border="0" marginwidth="0" marginheight="0" height="86" src="https://music.163.com/outchain/player?type=2&id=';
    $return .= $content;
    $return .= '&auto='.$autoplay.'&height=66"></iframe>';
    return $return;
}
add_shortcode('music','wymusic');
function bdbtn($atts,$content=null,$code=""){
    $return = '<a class="downbtn" href="';
    $return .= $content;
    $return .= '" target="_blank"><i class="fa fa-download"></i> '.__('本地下载','moedog').'</a>';
    return $return;
}
add_shortcode('bdbtn','bdbtn');
function ypbtn($atts,$content=null,$code=""){
    $return = '<a class="downbtn downcloud" href="';
    $return .= $content;
    $return .= '" target="_blank"><i class="fa fa-cloud-download"></i> '.__('云盘下载','moedog').'</a>';
    return $return;
}
add_shortcode('ypbtn','ypbtn');
function nrtitle($atts,$content=null,$code=""){
    $return = '<h2 class="title-h2">';
    $return .= $content;
    $return .= '</h2>';
    return $return;
}
add_shortcode('title','nrtitle');
function kbd($atts,$content=null,$code=""){
    $return = '<kbd>';
    $return .= $content;
    $return .= '</kbd>';
    return $return;
}
add_shortcode('kbd','kbd');
function nrmark($atts,$content=null,$code=""){
    $return = '<mark>';
    $return .= $content;
    $return .= '</mark>';
    return $return;
}
add_shortcode('mark','nrmark');
function striped($atts,$content=null,$code=""){
    $return = '<div class="progress progress-striped active"><div class="progress-bar" style="width: ';
    $return .= $content;
    $return .= '%;"></div></div>';
    return $return;
}
add_shortcode('striped','striped');
function xcollapse($atts,$content=null,$code=""){
    extract(shortcode_atts(array("title"=>__('标题内容','moedog')),$atts));
    $return = '<div class="xControl"><div class="xHeading"><div class="xIcon"><i class="fa fa-plus"></i></div><h5>';
    $return .= $title;
    $return .= '</h5></div><div class="xContent"><div class="inner">';
    $return .= do_shortcode($content);
    $return .= '</div></div></div>';
    return $return;
}
add_shortcode('collapse','xcollapse');
function hide($atts,$content=null,$code=""){
    extract(shortcode_atts(array("reply_to_this"=>'true'),$atts));
    global $current_user;
    get_currentuserinfo();
    if($current_user->ID) $email = $current_user->user_email;
    if($reply_to_this=='true'){
        if($email){
            global $wpdb;
            global $id;
            $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_author_email = '".$email."' and comment_post_id='".$id."'and comment_approved = '1'");
            }
        if(!$comments) $content = '<div class="hide_notice">'.sprintf(__('抱歉，只有<a href="%s" rel="nofollow">登录</a>并在本文发表评论才能阅读隐藏内容','moedog'),wp_login_url(get_permalink())).'</div>';
    }else{
        if($email){
            global $wpdb;
            global $id;
            $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_author_email = '".$email."' and comment_approved = '1'");
        }
        if(!$comments) $content = '<div class="hide_notice">'.sprintf(__('抱歉，只有<a href="%s" rel="nofollow">登录</a>并在本站任一文章发表评论才能阅读隐藏内容','moedog'),wp_login_url(get_permalink())).'</div>';
    }
    if($comments) $content = '<div class="unhide"><div class="info">'.__('以下为隐藏内容：','moedog').'</div>'.$content.'</div>';
    return $content;
}
add_shortcode('hide','hide');
function successbox($atts,$content=null,$code=""){
    extract(shortcode_atts(array("title"=>__('标题内容','moedog')),$atts));
    $return = '<div class="panel panel-success"><div class="panel-heading"><h3 class="panel-title">';
    $return .= $title;
    $return .= '</h3></div><div class="panel-body">';
    $return .= do_shortcode($content);
    $return .= '</div></div>';
    return $return;
}
add_shortcode('successbox','successbox');
function infobox($atts,$content=null,$code=""){
    extract(shortcode_atts(array("title"=>__('标题内容','moedog')),$atts));
    $return = '<div class="panel panel-info"><div class="panel-heading"><h3 class="panel-title">';
    $return .= $title;
    $return .= '</h3></div><div class="panel-body">';
    $return .= do_shortcode($content);
    $return .= '</div></div>';
    return $return;
}
add_shortcode('infobox','infobox');
function warningbox($atts,$content=null,$code=""){
    extract(shortcode_atts(array("title"=>__('标题内容','moedog')),$atts));
    $return = '<div class="panel panel-warning"><div class="panel-heading"><h3 class="panel-title">';
    $return .= $title;
    $return .= '</h3></div><div class="panel-body">';
    $return .= do_shortcode($content);
    $return .= '</div></div>';
    return $return;
}
add_shortcode('warningbox','warningbox');
function dangerbox($atts,$content=null,$code=""){
    extract(shortcode_atts(array("title"=>__('标题内容','moedog')),$atts));
    $return = '<div class="panel panel-danger"><div class="panel-heading"><h3 class="panel-title">';
    $return .= $title;
    $return .= '</h3></div><div class="panel-body">';
    $return .= do_shortcode($content);
    $return .= '</div></div>';
    return $return;
}
add_shortcode('dangerbox','dangerbox');
function youku($atts,$content=null,$code=""){
    $return = '<div class="video-container"><iframe height="498" width="100%" src="https://player.youku.com/embed/';
    $return .= $content;
    $return .= '" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>';
    return $return;
}
add_shortcode('youku','youku');
function tudou($atts,$content=null,$code=""){
    extract(shortcode_atts(array("code"=>'0'),$atts));
    $return = '<div class="video-container"><iframe src="https://www.tudou.com/programs/view/html5embed.action?type=1&code=';
    $return .= $content;
    $return .= '&lcode=';
    $return .= $code;
    $return .= '&resourceId=0_06_05_99" allowtransparency="true" allowfullscreen="true" allowfullscreenInteractive="true" scrolling="no" border="0" frameborder="0"></iframe></div>';
    return $return;
}
add_shortcode('tudou','tudou');
function vqq($atts,$content=null,$code=""){
    extract(shortcode_atts(array("auto"=>'0'),$atts));
    $return = '<div class="video-container"><iframe frameborder="0" width="100%" height="498" src="https://v.qq.com/iframe/player.html?vid=';
    $return .= $content;
    $return .= '&tiny=0&auto=';
    $return .= $auto;
    $return .= '" allowfullscreen></iframe></div>';
    return $return;
}
add_shortcode('vqq','vqq');
function youtube($atts,$content=null,$code=""){
    $return = '<div class="video-container"><iframe height="498" width="100%" src="https://www.youtube.com/embed/';
    $return .= $content;
    $return .= '" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>';
    return $return;
}
add_shortcode('youtube','youtube');
function bilibili($atts,$content=null,$code=""){
    extract(shortcode_atts(array("danmaku"=>'1'),$atts));
    extract(shortcode_atts(array("page"=>'1'),$atts));
    $return = '<div class="video-container"><iframe src="https://player.bilibili.com/player.html?bvid=';
    $return .= $content;
    $return .= '&page=';
    $return .= $page;
    $return .= '&high_quality=1&danmaku=';
    $return .= $danmaku;
    $return .= '" allowtransparency="true" width="100%" height="498" scrolling="no" frameborder="0" ></iframe></div>';
    return $return;
}
add_shortcode('bilibili','bilibili');
add_action('init','more_button_a');
function more_button_a(){
   if(!current_user_can('edit_posts')&&!current_user_can('edit_pages')) return;
   if(get_user_option('rich_editing')=='true'){
     add_filter('mce_external_plugins','add_plugin');
     add_filter('mce_buttons','register_button');
   }
}
add_action('init','more_button_b');
function more_button_b(){
   if(!current_user_can('edit_posts')&&!current_user_can('edit_pages')) return;
   if(get_user_option('rich_editing')=='true'){
     add_filter('mce_external_plugins','add_plugin_b');
     add_filter('mce_buttons_3','register_button_b');
   }
}
function register_button($buttons){
    array_push($buttons," ","title");
    array_push($buttons," ","highlight");
    array_push($buttons," ","accordion");
    array_push($buttons," ","hide");
    array_push($buttons," ","kbd");
    array_push($buttons," ","mark");
    array_push($buttons," ","striped");
    array_push($buttons," ","bdbtn");
    array_push($buttons," ","ypbtn");
    array_push($buttons," ","music");
    array_push($buttons," ","youku");
    array_push($buttons," ","tudou");
    array_push($buttons," ","vqq");
    array_push($buttons," ","youtube");
    array_push($buttons," ","bilibili");
    return $buttons;
}
function register_button_b($buttons){
    array_push($buttons," ","success");
    array_push($buttons," ","info");
    array_push($buttons," ","warning");
    array_push($buttons," ","danger");
    array_push($buttons," ","successbox");
    array_push($buttons," ","infoboxs");
    array_push($buttons," ","warningbox");
    array_push($buttons," ","dangerbox");
    return $buttons;
}
function add_plugin($plugin_array){
    $plugin_array['title'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['highlight'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['accordion'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['hide'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['kbd'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['mark'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['striped'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['bdbtn'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['ypbtn'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['music'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['youku'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['tudou'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['vqq'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['youtube'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['bilibili'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    return $plugin_array;
}
function add_plugin_b($plugin_array){
    $plugin_array['success'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['info'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['warning'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['danger'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['successbox'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['infoboxs'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['warningbox'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['dangerbox'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    return $plugin_array;
}
function add_more_buttons($buttons){
        $buttons[] = 'hr';
        $buttons[] = 'fontselect';
        $buttons[] = 'fontsizeselect';
        $buttons[] = 'styleselect';
    return $buttons;
}
add_filter("mce_buttons_2","add_more_buttons");
function fa_get_wpsmiliestrans(){
    global $wpsmiliestrans;
    $wpsmilies = array_unique($wpsmiliestrans);
    if(kratos_option('owo_out')) $owodir = 'https://cdn.jsdelivr.net/gh/xb2016/kratos-pjax@'.KRATOS_VERSION; else $owodir = get_bloginfo('template_directory');
    foreach($wpsmilies as $alt => $src_path){
        $traimgna = substr($alt,1,-1);
        $output .= '<a class="add-smily" data-smilies="'.$alt.'"><img src="'.$owodir.'/static/images/smilies/'.$traimgna.'.png"></a>';
    }
    return $output;
}
add_action('media_buttons_context','fa_smilies_custom_button');
function fa_smilies_custom_button($context){
    $context .= '<style>.smilies-wrap{background:#fff;border: 1px solid #ccc;box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.24);padding: 10px;position: absolute;top: 60px;width: 380px;display:none}.smilies-wrap img{height:24px;width:24px;cursor:pointer;margin-bottom:5px} .is-active.smilies-wrap{display:block}</style><a id="REPLACE-media-button" style="position:relative" class="button REPLACE-smilies add_smilies" title="'.__('添加表情','moedog').'" data-editor="content" href="javascript:;">'.__('添加表情','moedog').'</a><div class="smilies-wrap">'. fa_get_wpsmiliestrans() .'</div><script>jQuery(document).ready(function(){jQuery(document).on("click", ".REPLACE-smilies",function() { if(jQuery(".smilies-wrap").hasClass("is-active")){jQuery(".smilies-wrap").removeClass("is-active");}else{jQuery(".smilies-wrap").addClass("is-active");}});jQuery(document).on("click", ".add-smily",function() { send_to_editor(" " + jQuery(this).data("smilies") + " ");jQuery(".smilies-wrap").removeClass("is-active");return false;});});</script>';
    return $context;
}
function appthemes_add_quicktags(){ ?>
<script type="text/javascript">
try{
QTags.addButton( 'pre', 'pre', '<pre>\n', '\n</pre>' );
QTags.addButton( 'hr', 'hr', '\n\n<hr />\n\n', '' );
QTags.addButton( '<?php _e('代码高亮','moedog'); ?>', '<?php _e('代码高亮','moedog'); ?>', '<pre class="hl"><code class="">', '</code></pre>' );
QTags.addButton( '<?php _e('内容标题','moedog'); ?>', '<?php _e('内容标题','moedog'); ?>', '[title]', '[/title]' );
QTags.addButton( '<?php _e('蓝色字体','moedog'); ?>', '<?php _e('蓝色字体','moedog'); ?>', '<span style="color: #0000ff;">', '</span>' );
QTags.addButton( '<?php _e('红色字体','moedog'); ?>', '<?php _e('红色字体','moedog'); ?>', '<span style="color: #ff0000;">', '</span>' );
QTags.addButton( '<?php _e('展开/收缩','moedog'); ?>', '<?php _e('展开/收缩','moedog'); ?>', '[collapse title="<?php _e('标题内容','moedog'); ?>"]', '[/collapse]' );
QTags.addButton( '<?php _e('回复可见','moedog'); ?>', '<?php _e('回复可见','moedog'); ?>', '[hide reply_to_this="true"]', '[/hide]' );
QTags.addButton( '<?php _e('本地下载','moedog'); ?>', '<?php _e('本地下载','moedog'); ?>', '[bdbtn]', '[/bdbtn]' );
QTags.addButton( '<?php _e('云盘下载','moedog'); ?>', '<?php _e('云盘下载','moedog'); ?>', '[ypbtn]', '[/ypbtn]' );
QTags.addButton( '<?php _e('网易云音乐','moedog'); ?>', '<?php _e('网易云音乐','moedog'); ?>', '[music autoplay="0"]', '[/music]' );
QTags.addButton( '<?php _e('绿色背景栏','moedog'); ?>', '<?php _e('绿色背景栏','moedog'); ?>', '[success]', '[/success]' );
QTags.addButton( '<?php _e('蓝色背景栏','moedog'); ?>', '<?php _e('蓝色背景栏','moedog'); ?>', '[info]', '[/info]' );
QTags.addButton( '<?php _e('黄色背景栏','moedog'); ?>', '<?php _e('黄色背景栏','moedog'); ?>', '[warning]', '[/warning]' );
QTags.addButton( '<?php _e('红色背景栏','moedog'); ?>', '<?php _e('红色背景栏','moedog'); ?>', '[danger]', '[/danger]' );
QTags.addButton( '<?php _e('绿色面板','moedog'); ?>', '<?php _e('绿色面板','moedog'); ?>', '[successbox title="<?php _e('标题内容','moedog'); ?>"]', '[/successbox]' );
QTags.addButton( '<?php _e('蓝色面板','moedog'); ?>', '<?php _e('蓝色面板','moedog'); ?>', '[infobox title="<?php _e('标题内容','moedog'); ?>"]', '[/infobox]' );
QTags.addButton( '<?php _e('黄色面板','moedog'); ?>', '<?php _e('黄色面板','moedog'); ?>', '[warningbox title="<?php _e('标题内容','moedog'); ?>"]', '[/warningbox]' );
QTags.addButton( '<?php _e('红色面板','moedog'); ?>', '<?php _e('红色面板','moedog'); ?>', '[dangerbox title="<?php _e('标题内容','moedog'); ?>"]', '[/dangerbox]' );
}catch(err){}
</script>
<?php
}
add_action('admin_print_footer_scripts', 'appthemes_add_quicktags');
