<?php
//Init theme
add_action('load-themes.php','Init_theme');
function Init_theme(){
  global $pagenow;
  if('themes.php'==$pagenow&&isset($_GET['activated'])){
    wp_redirect(admin_url('themes.php?page=kratos'));
    exit;
  }
}
//The admin control module
if(!function_exists('optionsframework_init')){
    define('OPTIONS_FRAMEWORK_DIRECTORY',get_template_directory_uri().'/inc/theme-options/');
    require_once (get_template_directory().'/inc/theme-options/options-framework.php');
    $optionsfile = locate_template('options.php');
    load_template($optionsfile);
}
function kratos_options_menu_filter($menu){
  $menu['mode'] = 'menu';
  $menu['page_title'] = '主题设置';
  $menu['menu_title'] = '主题设置';
  $menu['menu_slug'] = 'kratos';
  return $menu;
}
add_filter('optionsframework_menu','kratos_options_menu_filter');
//The menu navigation registration
function kratos_register_nav_menu(){register_nav_menus(array('header_menu'=>'顶部菜单'));}
add_action('after_setup_theme','kratos_register_nav_menu');
//Highlighting the active menu
function kratos_active_menu_class($classes){
    if(in_array('current-menu-item',$classes) OR in_array('current-menu-ancestor',$classes)) $classes[] = 'active';
    return $classes;
}
add_filter('nav_menu_css_class','kratos_active_menu_class');
//Disable automatic formatting
remove_filter('the_content','wpautop');
remove_filter('the_content','wptexturize');
//Support chinese tags
add_action('parse_request','kratos_chinese_tag_names_parse_request');
add_filter('get_pagenum_link','kratos_chinese_tag_names_get_pagenum_link');
function kratos_chinese_convencoding($str,$to='UTF-8',$from='GBK'){
    if(function_exists('mb_convert_encoding')){
        $str = mb_convert_encoding($str,$to,$from);
    }else if(function_exists('iconv')){
        $str = iconv($from,$to."//IGNORE",$str);
    }
    return $str;
}
function kratos_chinese_tag_names_parse_request($obj){
    if($obj->did_permalink==false) return;
    if(isset($obj->request)) $obj->request = kratos_chinese_convencoding($obj->request,get_option('blog_charset'));
    if(isset($obj->query_vars)) foreach ($obj->query_vars as $key => &$value){
        if($key=='s') continue;
        $value = kratos_chinese_convencoding($value,get_option('blog_charset'));
    }
}
function kratos_chinese_tag_names_get_pagenum_link($result){
    $result = kratos_chinese_convencoding($result,get_option('blog_charset'));
    return $result;
}
//Disable google fonts
function kratos_disable_open_sans($translations,$text,$context,$domain){
    if('Open Sans font: on or off'==$context&&'on'==$text) $translations = 'off';
    return $translations;
}
add_filter('gettext_with_context','kratos_disable_open_sans',888,4);
//Support webp upload
add_filter('upload_mimes','kratos_upload_webp');
function kratos_upload_webp ($existing_mimes=array()){
  $existing_mimes['webp']='image/webp';
  return $existing_mimes;
}
//The length and suffix
function kratos_excerpt_length($length){return 170;}
add_filter('excerpt_length','kratos_excerpt_length');
function kratos_excerpt_more($more){return '……';}
add_filter('excerpt_more','kratos_excerpt_more');
//Load scripts
function kratos_theme_scripts(){  
    if(kratos_option('js_out')) $dir = 'https://cdn.jsdelivr.net/gh/xb2016/theme-js@0.0.4'; else $dir = get_template_directory_uri();
    if(kratos_option('fa_url')) $fadir = kratos_option('fa_url'); else $fadir = $dir.'/css/font-awesome.min.css';
    if(kratos_option('jq_url')) $jqdir = kratos_option('jq_url'); else $jqdir = $dir.'/js/jquery.min.js';
    if(kratos_option('bs_url')) $bsdir = kratos_option('bs_url'); else $bsdir = $dir.'/js/bootstrap.min.js';
    if(!is_admin()){
        wp_enqueue_style('fontawe',$fadir,array(),'4.7.0');
        wp_enqueue_style('kratos',get_template_directory_uri().'/css/kratos.min.css',array(),KRATOS_VERSION);
        wp_enqueue_script('jquery',$jqdir,array(),'2.1.4');
        wp_enqueue_script('layer',$dir.'/js/layer.min.js',array(),'3.1.0');
        wp_enqueue_script('bootstrap',$bsdir,array(),'3.3');
        wp_enqueue_script('kratos',$dir.'/js/kratos.js',array(),KRATOS_VERSION);
        wp_enqueue_script('pjax',$dir.'/js/pjax.min.js',array(),'0.0.7');
    }
    if(comments_open()) wp_enqueue_script('OwO',$dir.'/js/OwO.min.js',array(),'1.0.1');
    if(kratos_option('site_girl')=='l2d'&&!wp_is_mobile()){
        wp_enqueue_script('live2d',$dir.'/js/live2d.js',array(),'l2d');
        wp_enqueue_script('waifu',$dir.'/js/waifu-tips.js',array(),'1.3');
    }
    if(kratos_option('site_sa')&&!wp_is_mobile()){if(kratos_option('head_mode')=='pic') $site_sa_h = 55; else $site_sa_h = 103;}
    $d2kratos = array(
         'thome'=> get_stylesheet_directory_uri(),
         'ctime'=> kratos_option('createtime'),
        'donate'=> kratos_option('paytext_head'),
          'scan'=> kratos_option('paytext'),
        'alipay'=> kratos_option('alipayqr_url'),
        'wechat'=> kratos_option('wechatpayqr_url'),
       'site_sh'=> $site_sa_h
    );
    wp_localize_script('kratos','xb',$d2kratos);
}
add_action('wp_enqueue_scripts','kratos_theme_scripts');
//Remove the head code
remove_action('wp_head','wp_print_head_scripts',9);
remove_action('wp_head','wp_generator');
remove_action('wp_head','rsd_link');
remove_action('wp_head','wlwmanifest_link');
remove_action('wp_head','index_rel_link');
remove_action('wp_head','parent_post_rel_link',10,0);
remove_action('wp_head','start_post_rel_link',10,0);
remove_action('wp_head','adjacent_posts_rel_link_wp_head',10,0);
remove_action('wp_head','rel_canonical');
remove_action('wp_head','feed_links',2);
remove_action('wp_head','feed_links_extra',3);
remove_action('admin_print_scripts','print_emoji_detection_script');
remove_action('admin_print_styles','print_emoji_styles');
remove_action('wp_head','print_emoji_detection_script',7);
remove_action('wp_print_styles','print_emoji_styles');
remove_action('embed_head','print_emoji_detection_script');
remove_filter('the_content','wptexturize'); 
remove_filter('the_content_feed','wp_staticize_emoji');
remove_filter('comment_text_rss','wp_staticize_emoji');
remove_filter('wp_mail','wp_staticize_emoji_for_email');
add_filter('emoji_svg_url','__return_false');
add_filter('show_admin_bar','__return_false');
add_action('wp_enqueue_scripts','mt_enqueue_scripts',1);
function mt_enqueue_scripts(){wp_deregister_script('jquery');}
//Prohibit character escaping
$qmr_work_tags = array('the_title','the_excerpt','single_post_title','comment_author','comment_text','link_description','bloginfo','wp_title','term_description','category_description','widget_title','widget_text');
foreach($qmr_work_tags as $qmr_work_tag){remove_filter ($qmr_work_tag,'wptexturize');}
remove_filter('the_content','wptexturize');
//Add the page html
add_action('init','html_page_permalink',-1);
function html_page_permalink(){
    if(kratos_option('page_html')){
        global $wp_rewrite;
        if(!strpos($wp_rewrite->get_page_permastruct(),'.html')) $wp_rewrite->page_structure = $wp_rewrite->page_structure.'.html';
    }
}
//Remove the revision
remove_action('post_updated','wp_save_post_revision');
//Auto add <p>
remove_filter('the_content','wpautop');
add_filter('the_content','wpautop',12);
//Link manager(Link page pre)
add_filter('pre_option_link_manager_enabled','__return_true');
//Remove the excess CSS selectors
add_filter('nav_menu_css_class','my_css_attributes_filter',100,1);
add_filter('nav_menu_item_id','my_css_attributes_filter',100,1);
add_filter('page_css_class','my_css_attributes_filter',100,1);
function my_css_attributes_filter($var){return is_array($var)?array_intersect($var,array('current-menu-item','current-post-ancestor','current-menu-ancestor','current-menu-parent')):'';}
//Add article type
add_theme_support('post-formats',array('gallery','video'));
//Keywords Description set
function kratos_keywords(){
    if(is_home()||is_front_page()){echo kratos_option('site_keywords');}
    elseif(is_category()){single_cat_title();}
    elseif(is_single()){
        echo trim(wp_title('',FALSE)).',';
        if(has_tag()){foreach((get_the_tags()) as $tag){echo $tag->name.',';}}
        foreach((get_the_category()) as $category){echo $category->cat_name.',';} 
    }
    elseif(is_search()){the_search_query();}
    else{echo trim(wp_title('',FALSE));}
}
function kratos_description(){
    if(is_home()||is_front_page()){echo trim(kratos_option('site_description'));}
    elseif(is_category()){$description = strip_tags(category_description());echo trim($description);}
    elseif(is_single()){ 
        if(get_the_excerpt()){echo get_the_excerpt();}
        else{global $post;$description = trim(str_replace(array("\r\n","\r","\n","　"," ")," ",str_replace("\"","'",strip_tags($post->post_content ))));echo mb_substr($description,0,220,'utf-8');}
    }
    elseif(is_search()){echo '“';the_search_query();echo '”为您找到结果 ';global $wp_query;echo $wp_query->found_posts;echo ' 个';}
    elseif(is_tag()){$description = strip_tags(tag_description());echo trim($description);}
    else{$description = strip_tags(term_description());echo trim($description);}
}
//Article outside chain optimization
function imgnofollow($content){
    $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>";
    if(preg_match_all("/$regexp/siU",$content,$matches,PREG_SET_ORDER)){
        if(!empty($matches)){
            $srcUrl = get_option('siteurl');
            for ($i=0;$i<count($matches);$i++){
                $tag = $matches[$i][0];
                $tag2 = $matches[$i][0];
                $url = $matches[$i][0];
                $noFollow = '';
                $pattern = '/target\s*=\s*"\s*_blank\s*"/';
                preg_match($pattern,$tag2,$match,PREG_OFFSET_CAPTURE);
                if(count($match)<1) $noFollow .= ' target="_blank" ';
                $pattern = '/rel\s*=\s*"\s*[n|d]ofollow\s*"/';
                preg_match($pattern, $tag2, $match, PREG_OFFSET_CAPTURE);
                if(count($match)<1) $noFollow .= ' rel="nofollow" ';
                $pos = strpos($url,$srcUrl);
                if($pos===false){
                    $tag = rtrim ($tag,'>');
                    $tag .= $noFollow.'>';
                    $content = str_replace($tag2,$tag,$content);
                }
            }
        }
    }
    $content = str_replace(']]>',']]>',$content);
    return $content;
}
add_filter('the_content','imgnofollow');
//The title set
function kratos_wp_title($title,$sep){
    global $paged,$page;
    if(is_feed()) return $title;
    $title .= get_bloginfo('name');
    $site_description = get_bloginfo('description','display');
    if($site_description&&(is_home()||is_front_page())) $title = "$title $sep $site_description";
    if($paged>=2||$page>=2) $title = "$title $sep " . sprintf('第 %s 页',max($paged,$page));
    return $title;
}
add_filter('wp_title','kratos_wp_title',10,2);
//Banner
function kratos_banner(){
    if(!$output = get_option('kratos_banners')){
        $output = '';
        $kratos_banner_on = kratos_option("kratos_banner")?kratos_option("kratos_banner"):0;
        if($kratos_banner_on){
            for($i=1; $i<6; $i++){
                $kratos_banner{$i} = kratos_option("kratos_banner{$i}")?kratos_option("kratos_banner{$i}"):"";
                $kratos_banner_url{$i} = kratos_option("kratos_banner_url{$i}")?kratos_option("kratos_banner_url{$i}"):"";
                if($kratos_banner{$i}){
                    $banners[] = $kratos_banner{$i};
                    $banners_url[] = $kratos_banner_url{$i};
                }
            }
            $count = count($banners);
            $output .= '<div id="slide" class="carousel slide" data-ride="carousel">';
            $output .= '<ol class="carousel-indicators">';
            for($i=0;$i<$count;$i++){
                $output .= '<li data-target="#slide" data-slide-to="'.$i.'"';
                if($i==0) $output .= 'class="active"';
                $output .= '></li>';
            };
            $output .='</ol>';
            $output .= '<div class="carousel-inner" role="listbox">';
            for($i=0;$i<$count;$i++){
                $output .= '<div class="item';
                if($i==0) $output .= ' active';
                $output .= '">';
                if(!empty($banners_url[$i])){
                    $output .= '<a href="'.$banners_url[$i].'"><img src="'.$banners[$i].'"/></a>';
                }else{
                    $output .= '<img src="'.$banners[$i].'"/>';
                }
                $output .= "</div>";
            };
            $output .= '</div>';
            $output .= '<a class="left carousel-control" href="#slide" role="button" data-slide="prev">';
            $output .= '<span class="fa fa-chevron-left glyphicon glyphicon-chevron-left"></span></a>';
            $output .= '<a class="right carousel-control" href="#slide" role="button" data-slide="next">';
            $output .= '<span class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></span></a></div>';
            update_option('kratos_banners',$output);
        }
    }
    echo $output;
}
function clear_banner(){update_option('kratos_banners','');}
add_action('optionsframework_after_validate','clear_banner');
//More users' info
function get_client_ip(){
    if(getenv("HTTP_CLIENT_IP")&&strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown")) $ip = getenv("HTTP_CLIENT_IP");
    elseif(getenv("HTTP_X_FORWARDED_FOR")&&strcasecmp(getenv("HTTP_X_FORWARDED_FOR"),"unknown")) $ip = getenv("HTTP_X_FORWARDED_FOR");
    elseif(getenv("REMOTE_ADDR")&&strcasecmp(getenv("REMOTE_ADDR"),"unknown")) $ip = getenv("REMOTE_ADDR");
    elseif(isset($_SERVER['REMOTE_ADDR'])&&$_SERVER['REMOTE_ADDR']&&strcasecmp($_SERVER['REMOTE_ADDR'],"unknown")) $ip = $_SERVER['REMOTE_ADDR'];
    else $ip = "unknown";
    return ($ip);
}
add_action('wp_login','insert_last_login');
function insert_last_login($login){
    global $user_id;
    $user = get_userdatabylogin($login);
    update_user_meta($user->ID,'last_login',current_time('mysql'));
    $last_login_ip = get_client_ip();
    update_user_meta($user->ID,'last_login_ip',$last_login_ip);
}
add_filter('manage_users_columns','add_user_additional_column');
function add_user_additional_column($columns){
    $columns['user_nickname'] = '昵称';
    $columns['user_url'] = '网站';
    $columns['reg_time'] = '注册时间';
    $columns['last_login'] = '上次登录';
    $columns['last_login_ip'] = '登录IP';
    unset($columns['name']);
    return $columns;
}
add_action('manage_users_custom_column','show_user_additional_column_content',10,3);
function show_user_additional_column_content($value,$column_name,$user_id){
    $user = get_userdata($user_id);
    if('user_nickname'==$column_name) return $user->nickname;
    if('user_url'==$column_name) return '<a href="'.$user->user_url.'" target="_blank">'.$user->user_url.'</a>';
    if('reg_time'==$column_name) return get_date_from_gmt($user->user_registered);
    if('last_login'==$column_name&&$user->last_login) return get_user_meta($user->ID,'last_login',ture);
    if('last_login_ip'==$column_name) return get_user_meta($user->ID,'last_login_ip',ture);
    return $value;
}
add_filter("manage_users_sortable_columns",'cmhello_users_sortable_columns');
function cmhello_users_sortable_columns($sortable_columns){
    $sortable_columns['reg_time'] = 'reg_time';
    return $sortable_columns;
}
add_action( 'pre_user_query','cmhello_users_search_order');
function cmhello_users_search_order($obj){
    if(!isset($_REQUEST['orderby'])||$_REQUEST['orderby']=='reg_time'){
        if(!in_array($_REQUEST['order'],array('asc','desc'))) $_REQUEST['order'] = 'desc';
        $obj->query_orderby = "ORDER BY user_registered ".$_REQUEST['order']."";
    }
}
//Enable comments <img>
function sig_allowed_html_tags_in_comments(){
   define('CUSTOM_TAGS',true);
   global $allowedtags;
   $allowedtags = array(
      'img'=> array(
         'alt' => true,
         'class' => true,
         'height'=> true,
         'src' => true,
         'width' => true,
      ),
   );
}
add_action('init','sig_allowed_html_tags_in_comments',10);
//Compress
function wp_compress_html(){
    function wp_compress_html_main($buffer){
        $initial=strlen($buffer);
        $buffer=explode("<!--wp-compress-html-->",$buffer);
        $count=count($buffer);
        for($i=0;$i<=$count;$i++){
            if(stristr($buffer[$i],'<!--wp-compress-html no compression-->')){
                $buffer[$i]=(str_replace("<!--wp-compress-html no compression-->","",$buffer[$i]));
            }else{
                $buffer[$i]=(str_replace("\t"," ",$buffer[$i]));
                $buffer[$i]=(str_replace("\n\n","\n",$buffer[$i]));
                $buffer[$i]=(str_replace("\n","",$buffer[$i]));
                $buffer[$i]=(str_replace("\r","",$buffer[$i]));
                while(stristr($buffer[$i],'  ')) $buffer[$i]=(str_replace("  "," ",$buffer[$i]));
                if(kratos_option('co_comp')) $buffer[$i]=preg_replace(array('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s','!/\*[^*]*\*+([^/][^*]*\*+)*/!'),'',$buffer[$i]);
                if(kratos_option('xhtml_comp')&&strtolower(substr(ltrim($buffer[$i]),0,15))=='<!doctype html>') $buffer[$i]=str_replace(' />','>',$buffer[$i]);
                if(kratos_option('html_relative')) $buffer[$i]=str_replace(array('href="https://'.$_SERVER['HTTP_HOST'].'/','href="http://'.$_SERVER['HTTP_HOST'].'/','href="//'.$_SERVER['HTTP_HOST'].'/'),'href="/',$buffer[$i]);
                if(kratos_option('html_relative')) $buffer[$i]=str_replace(array("href='https://".$_SERVER['HTTP_HOST'].'/',"href='http://".$_SERVER['HTTP_HOST'].'/',"href='//".$_SERVER['HTTP_HOST'].'/'),"href='/",$buffer[$i]);
                if(kratos_option('html_scheme')) $buffer[$i]=str_replace(array('href="http://','href="https://',"href='http://","href='https://"),array('href="//','href="//',"href='//","href='//"),$buffer[$i]);
            }
            $buffer_out.=$buffer[$i];
       }
    $final=strlen($buffer_out);
    $savings=($initial-$final)/$initial*100;
    $savings=round($savings,2);
    $buffer_out.="\n<!--压缩前: $initial bytes; 压缩后: $final bytes; 节约：$savings% -->";
    return $buffer_out;
}
ob_start("wp_compress_html_main");
}
if(!is_admin()&&kratos_option('site_comp')) add_action('init','wp_compress_html');
//Hex2rgb
function hex2rgb($hexColor){
    $color=str_replace('#','',$hexColor);
    if(strlen($color)>3){
        $rgb=hexdec(substr($color,0,2)).','.hexdec(substr($color,2,2)).','.hexdec(substr($color,4,2));
    }else{
        $color=str_replace('#','',$hexColor);
        $r=substr($color,0,1).substr($color,0,1);
        $g=substr($color,1,1).substr($color,1,1);
        $b=substr($color,2,1).substr($color,2,1);
        $rgb=hexdec($r).','.hexdec($g).','.hexdec($b);
    }
    return $rgb;
}
//New window-comment author link
function comment_author_link_window(){
    global $comment;
    $url = get_comment_author_url();
    $author = get_comment_author();
    if(empty($url)||'http://'==$url||'https://'==$url)
        $return = $author;
    else
        $return = "<a href='".$url."' target='_blank'>".$author."</a>"; 
    return $return;
}
add_filter('get_comment_author_link','comment_author_link_window');
//Notice
function kratos_admin_notice(){
    $noticeinfo = wp_remote_retrieve_body(wp_remote_get('https://www.fczbl.vip/api/kratos_notice.txt'));
    if(!is_wp_error($noticeinfo)&&$noticeinfo){ ?>
    <style type="text/css">.about-description a{text-decoration:none}</style>
    <div class="notice notice-info">
        <p class="about-description"><?php echo $noticeinfo; ?></p>
    </div><?php
    }
}
add_action('welcome_panel','kratos_admin_notice');