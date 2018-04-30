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
    $return = '<iframe class="" style="width:100%" frameborder="no" border="0" marginwidth="0" marginheight="0" height=86 src="//music.163.com/outchain/player?type=2&id=';
    $return .= $content;
    $return .= '&auto='. kratos_option('wy_music') .'&height=66"></iframe>';
    return $return;
}
add_shortcode('music','wymusic');
function bdbtn($atts,$content=null,$code=""){
    $return = '<a class="downbtn" href="';
    $return .= $content;
    $return .= '" target="_blank"><i class="fa fa-download"></i> 本地下载</a>';
    return $return;
}
add_shortcode('bdbtn','bdbtn');
function ypbtn($atts,$content=null,$code=""){
    $return = '<a class="downbtn downcloud" href="';
    $return .= $content;
    $return .= '" target="_blank"><i class="fa fa-cloud-download"></i> 云盘下载</a>';
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
    extract(shortcode_atts(array("title"=>'标题内容'),$atts));
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
        if(!$comments) $content = '<div class="hide_notice">抱歉，只有<a href="'.wp_login_url(get_permalink()).'" rel="nofollow">登录</a>并在本文发表评论才能阅读隐藏内容</div>';
    }else{
        if($email){
            global $wpdb;
            global $id;
            $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_author_email = '".$email."' and comment_approved = '1'");
        }
        if(!$comments) $content = '<div class="hide_notice">抱歉，只有<a href="'.wp_login_url(get_permalink()).'" rel="nofollow">登录</a>并在本站任一文章发表评论才能阅读隐藏内容</div>';
    }
    if($comments) $content = '<div class="unhide"><div class="info">以下为隐藏内容：</div>'.$content.'</div>';
    return $content;
}
add_shortcode('hide','hide');
function successbox($atts,$content=null,$code=""){
    extract(shortcode_atts(array("title"=>'标题内容'),$atts));
    $return = '<div class="panel panel-success"><div class="panel-heading"><h3 class="panel-title">';
    $return .= $title;
    $return .= '</h3></div><div class="panel-body">';
    $return .= do_shortcode($content);
    $return .= '</div></div>';
    return $return;
}
add_shortcode('successbox','successbox');
function infobox($atts,$content=null,$code=""){
    extract(shortcode_atts(array("title"=>'标题内容'),$atts));
    $return = '<div class="panel panel-info"><div class="panel-heading"><h3 class="panel-title">';
    $return .= $title;
    $return .= '</h3></div><div class="panel-body">';
    $return .= do_shortcode($content);
    $return .= '</div></div>';
    return $return;
}
add_shortcode('infobox','infobox');
function warningbox($atts,$content=null,$code=""){
    extract(shortcode_atts(array("title"=>'标题内容'),$atts));
    $return = '<div class="panel panel-warning"><div class="panel-heading"><h3 class="panel-title">';
    $return .= $title;
    $return .= '</h3></div><div class="panel-body">';
    $return .= do_shortcode($content);
    $return .= '</div></div>';
    return $return;
}
add_shortcode('warningbox','warningbox');
function dangerbox($atts,$content=null,$code=""){
    extract(shortcode_atts(array("title"=>'标题内容'),$atts));
    $return = '<div class="panel panel-danger"><div class="panel-heading"><h3 class="panel-title">';
    $return .= $title;
    $return .= '</h3></div><div class="panel-body">';
    $return .= do_shortcode($content);
    $return .= '</div></div>';
    return $return;
}
add_shortcode('dangerbox','dangerbox');
function youku($atts,$content=null,$code=""){
    $return = '<div class="video-container"><iframe height="498" width="750" src="http://player.youku.com/embed/';
    $return .= $content;
    $return .= '" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>';
    return $return;
}
add_shortcode('youku','youku');
function tudou($atts,$content=null,$code=""){
    extract(shortcode_atts(array("code"=>'0'),$atts));
    $return = '<div class="video-container"><iframe src="http://www.tudou.com/programs/view/html5embed.action?type=1&code=';
    $return .= $content;
    $return .= '&lcode=';
    $return .= $code;
    $return .= '&resourceId=0_06_05_99" allowtransparency="true" allowfullscreen="true" allowfullscreenInteractive="true" scrolling="no" border="0" frameborder="0"></iframe></div>';
    return $return;
}
add_shortcode('tudou','tudou');
function vqq($atts,$content=null,$code=""){
    extract(shortcode_atts(array("auto"=>'0'),$atts));
    $return = '<div class="video-container"><iframe frameborder="0" width="640" height="498" src="//v.qq.com/iframe/player.html?vid=';
    $return .= $content;
    $return .= '&tiny=0&auto=';
    $return .= $auto;
    $return .= '" allowfullscreen></iframe></div>';
    return $return;
}
add_shortcode('vqq','vqq');
function youtube($atts,$content=null,$code=""){
    $return = '<div class="video-container"><iframe height="498" width="750" src="https://www.youtube.com/embed/';
    $return .= $content;
    $return .= '" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>';
    return $return;
}
add_shortcode('youtube','youtube');
function pptv($atts,$content=null,$code=""){
    $return = '<div class="video-container"><iframe src="http://player.pptv.com/iframe/index.html#id=';
    $return .= $content;
    $return .= '&ctx=o%3Dv_share" allowtransparency="true" width="640" height="400" scrolling="no" frameborder="0" ></iframe></div>';
    return $return;
}
add_shortcode('pptv','pptv');
function bilibili($atts,$content=null,$code=""){
    $return = '<div class="video-container"><embed height="415" width="544" quality="high" allowfullscreen="true" type="application/x-shockwave-flash" src="http://static.hdslb.com/miniloader.swf" flashvars="aid=';
    $return .= $content;
    $return .= '&page=1" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash"></embed></div>';
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
    array_push($buttons," ","pptv");
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
    $plugin_array['pptv'] = get_bloginfo('template_url').'/inc/buttons/more.js';
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
    foreach($wpsmilies as $alt => $src_path){
        $traimgna = substr($alt,1,-1);
        $output .= '<a class="add-smily" data-smilies="'.$alt.'"><img src="'.get_bloginfo('template_directory').'/images/smilies/'.$traimgna.'.png"></a>';
    }
    return $output;
}
add_action('media_buttons_context','fa_smilies_custom_button');
function fa_smilies_custom_button($context){
    $context .= '<style>.smilies-wrap{background:#fff;border: 1px solid #ccc;box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.24);padding: 10px;position: absolute;top: 60px;width: 380px;display:none}.smilies-wrap img{height:24px;width:24px;cursor:pointer;margin-bottom:5px} .is-active.smilies-wrap{display:block}</style><a id="REPLACE-media-button" style="position:relative" class="button REPLACE-smilies add_smilies" title="添加表情" data-editor="content" href="javascript:;">添加表情</a><div class="smilies-wrap">'. fa_get_wpsmiliestrans() .'</div><script>jQuery(document).ready(function(){jQuery(document).on("click", ".REPLACE-smilies",function() { if(jQuery(".smilies-wrap").hasClass("is-active")){jQuery(".smilies-wrap").removeClass("is-active");}else{jQuery(".smilies-wrap").addClass("is-active");}});jQuery(document).on("click", ".add-smily",function() { send_to_editor(" " + jQuery(this).data("smilies") + " ");jQuery(".smilies-wrap").removeClass("is-active");return false;});});</script>';
    return $context;
}
function appthemes_add_quicktags(){
?>
<style>.mce-container.mce-toolbar.mce-stack-layout-item{display:block!important}</style>
<script type="text/javascript"> 
QTags.addButton( 'hr分隔', 'hr分隔', '\n\n<hr />\n\n', '' );
QTags.addButton( '内容标题', '内容标题', '[title]', '[/title]' );
QTags.addButton( '蓝色字体', '蓝色字体', '<span style="color: #0000ff;">', '</span>' );
QTags.addButton( '红色字体', '红色字体', '<span style="color: #ff0000;">', '</span>' );
QTags.addButton( '展开/收缩', '展开/收缩', '[collapse title="标题内容"]', '[/collapse]' );
QTags.addButton( '回复可见', '回复可见', '[hide reply_to_this="true"]', '[/hide]' );
QTags.addButton( '本地下载', '本地下载', '[bdbtn]', '[/bdbtn]' );
QTags.addButton( '云盘下载', '云盘下载', '[ypbtn]', '[/ypbtn]' );
QTags.addButton( '网易云音乐', '网易云音乐', '[music]', '[/music]' );
QTags.addButton( '绿色背景栏', '绿色背景栏', '[success]', '[/success]' );
QTags.addButton( '蓝色背景栏', '蓝色背景栏', '[info]', '[/info]' );
QTags.addButton( '黄色背景栏', '黄色背景栏', '[warning]', '[/warning]' );
QTags.addButton( '红色背景栏', '红色背景栏', '[danger]', '[/danger]' );
QTags.addButton( '绿色面板', '绿色面板', '[successbox title="标题内容"]', '[/successbox]' );
QTags.addButton( '蓝色面板', '蓝色面板', '[infobox title="标题内容"]', '[/infobox]' );
QTags.addButton( '黄色面板', '黄色面板', '[warningbox title="标题内容"]', '[/warningbox]' );
QTags.addButton( '红色面板', '红色面板', '[dangerbox title="标题内容"]', '[/dangerbox]' );
</script>
<?php
}
add_action('admin_print_footer_scripts', 'appthemes_add_quicktags' );