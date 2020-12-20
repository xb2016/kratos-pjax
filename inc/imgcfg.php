<?php
//Banner
function kratos_banner(){
    if(!$output = get_option('kratos_banners')){
        $output = '';
        $kratos_banner_on = kratos_option("kratos_banner")&&kratos_option("kratos_banner1")?1:0;
        if($kratos_banner_on){
            for($i=1; $i<6; $i++){
                $kratos_banner[$i] = kratos_option("kratos_banner{$i}")?kratos_option("kratos_banner{$i}"):"";
                $kratos_banner_url[$i] = kratos_option("kratos_banner_url{$i}")?kratos_option("kratos_banner_url{$i}"):"";
                if($kratos_banner[$i]){
                    $banners[] = $kratos_banner[$i];
                    $banners_url[] = $kratos_banner_url[$i];
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
            $output .= '<span class="left carousel-control" href="#slide" role="button" data-slide="prev">';
            $output .= '<span class="fa fa-chevron-left glyphicon glyphicon-chevron-left"></span></span>';
            $output .= '<span class="right carousel-control" href="#slide" role="button" data-slide="next">';
            $output .= '<span class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></span></span></div>';
            update_option('kratos_banners',$output);
        }
    }
    echo $output;
}
function clear_banner(){update_option('kratos_banners','');}
add_action('optionsframework_after_validate','clear_banner');
//Post Thumbnails
if(function_exists('add_image_size')) add_image_size('kratos-thumb',750);
function kratos_blog_thumbnail(){
    global $post;
    $img_id = get_post_thumbnail_id();
    $img_url = wp_get_attachment_image_src($img_id,'kratos-entry-thumb');
    $img_url = $img_url[0];
    if(has_post_thumbnail()) echo '<a href="'.get_permalink().'"><img src="'.$img_url.'" alt="'.get_the_title().'"></a>';
}
add_filter('add_image_size',function(){return 1;});
add_theme_support("post-thumbnails");
function kratos_blog_thumbnail_new(){
    global $post;
    $img_id = get_post_thumbnail_id();
    $img_url = wp_get_attachment_image_src($img_id,'kratos-entry-thumb');
    $img_url = $img_url[0];
    $title = get_the_title();
    if(has_post_thumbnail()){
        echo '<a href="'.get_permalink().'"><img src="'.$img_url.'" alt="'.$title.'"></a>';
    }else{
        $content = $post->post_content;
        $img_preg = "/<img(.*?)src=\"(.+?)\".*?>/";
        preg_match($img_preg,$content,$img_src);
        $img_count=count($img_src)-1;
        if(isset($img_src[$img_count]))
        $img_val = $img_src[$img_count];
        if(!empty($img_val)&&!post_password_required()){
            echo '<a href="'.get_permalink().'"><img src="'.$img_val.'" alt="'.$title.'"></a>';
        }else if(!kratos_option('default_image')){
            $random = mt_rand(1,20);
            echo '<a href="'.get_permalink().'"><img src="'.get_bloginfo('template_url').'/static/images/thumb/thumb_'.$random.'.jpg" alt="'.$title.'"></a>';
        }else echo '<a href="'.get_permalink().'"><img src="'.kratos_option('default_image').'" alt="'.$title.'"></a>';
    }
}
//Share the thumbnail fetching
function share_post_image(){
    global $post;
    if(has_post_thumbnail($post->ID)){
        $post_thumbnail_id = get_post_thumbnail_id( $post_id );
        $img = wp_get_attachment_image_src($post_thumbnail_id,'full');
        $img = $img[0];
    }else{
        $content = $post->post_content;
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim',$content,$strResult,PREG_PATTERN_ORDER);
        if(!empty($strResult[1])){
            $img = $strResult[1][0];
        }else{
            $img = '';
        }
    }
    return $img;
}
//Add media from url
add_action('admin_menu','add_submenu');
add_action('post-plupload-upload-ui','post_upload_ui');
add_action('post-html-upload-ui','post_upload_ui');
add_action('wp_ajax_add_external_media_without_import','wp_ajax_add_external_media_without_import');
add_action('admin_post_add_external_media_without_import','admin_post_add_external_media_without_import');
function add_submenu(){
    add_submenu_page(
        'upload.php',
        __('从URL添加','moedog'),
        __('从URL添加','moedog'),
        'manage_options',
        'add-from-url',
        'print_submenu_page'
    );
}
function post_upload_ui(){
    wp_enqueue_style('emwi',get_template_directory_uri().'/inc/theme-options/css/media.css');
    wp_enqueue_script('emwi',get_template_directory_uri().'/inc/theme-options/js/media.js');
    $media_library_mode = get_user_option('media_library_mode',get_current_user_id()); ?>
    <div id="emwi-in-upload-ui">
      <div class="row1"><?php _e('或','moedog'); ?></div>
      <div class="row2">
        <?php if('grid' === $media_library_mode): ?>
          <button id="emwi-show" class="button button-large"><?php _e('从URL导入','moedog'); ?></button>
          <?php print_media_new_panel( true ); ?>
        <?php else : ?>
          <a class="button button-large" href="<?php echo esc_url(admin_url('/upload.php?page=add-from-url')); ?>"><?php _e('从URL导入','moedog'); ?></a>
        <?php endif; ?>
      </div>
    </div><?php
}
function print_submenu_page(){ ?>
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
      <?php print_media_new_panel(false); ?>
    </form><?php
}
function print_media_new_panel($is_in_upload_ui){
    wp_enqueue_style('emwi',get_template_directory_uri().'/inc/theme-options/css/media.css');
    wp_enqueue_script('emwi',get_template_directory_uri().'/inc/theme-options/js/media.js'); ?>
    <div id="emwi-media-new-panel" <?php if($is_in_upload_ui): ?>style="display:none"<?php endif; ?>>
      <div class="url-row">
        <label><?php _e('从URL添加媒体项目','moedog'); ?></label>
        <span id="emwi-url-input-wrapper">
          <input id="emwi-url" name="url" type="url" required placeholder="Image URL" value="<?php echo esc_url($_GET['url']); ?>">
        </span>
      </div>
      <div id="emwi-hidden" <?php if($is_in_upload_ui||empty($_GET['error'])): ?>style="display: none"<?php endif; ?>>
        <div><span id="emwi-error"><?php echo esc_html($_GET['error']); ?></span><?php _e('请手动指定图像大小与格式','moedog'); ?></div>
        <div id="emwi-properties">
          <label><?php _e('宽','moedog'); ?></label>
          <input id="emwi-width" name="width" type="number" value="<?php echo esc_html($_GET['width']); ?>">
          <label><?php _e('高','moedog'); ?></label>
          <input id="emwi-height" name="height" type="number" value="<?php echo esc_html($_GET['height']); ?>">
          <label><?php _e('MIME类型','moedog'); ?></label>
          <input id="emwi-mime-type" name="mime-type" type="text" value="<?php echo esc_html($_GET['mime-type']); ?>">
        </div>
      </div>
      <div id="emwi-buttons-row">
        <input type="hidden" name="action" value="add_external_media_without_import">
        <span class="spinner"></span>
        <input type="button" id="emwi-clear" class="button" value="<?php _e('清除','moedog'); ?>">
        <input type="submit" id="emwi-add" class="button button-primary" value="<?php _e('添加','moedog'); ?>">
        <?php if($is_in_upload_ui): ?>
          <input type="button" id="emwi-cancel" class="button" value="<?php _e('取消','moedog'); ?>">
        <?php endif; ?>
      </div>
    </div><?php
}
function wp_ajax_add_external_media_without_import(){
    $info = add_external_media_without_import();
    if(isset($info['id'])){
        if($attachment = wp_prepare_attachment_for_js($info['id'])){
            wp_send_json_success($attachment);
        }else{
            $info['error'] = __('相关JS加载失败','moedog');
            wp_send_json_error($info);
        }
    }else{
        wp_send_json_error($info);
    }
}
function admin_post_add_external_media_without_import(){
    $info = add_external_media_without_import();
    $redirect_url = 'upload.php';
    if(!isset($info['id'])){
        $redirect_url = $redirect_url.'?page=add-from-url&url='.urlencode($info['url']);
        $redirect_url = $redirect_url.'&error='.urlencode($info['error']);
        $redirect_url = $redirect_url.'&width='.urlencode($info['width']);
        $redirect_url = $redirect_url.'&height='.urlencode($info['height']);
        $redirect_url = $redirect_url.'&mime-type='.urlencode( $info['mime-type']);
    }
    wp_redirect(admin_url($redirect_url));
    exit;
}
function sanitize_and_validate_input(){
    $input = array(
        'url' => esc_url_raw($_POST['url']),
        'width' => sanitize_text_field($_POST['width']),
        'height' => sanitize_text_field($_POST['height']),
        'mime-type' => sanitize_mime_type($_POST['mime-type'])
    );
    $width_str = $input['width'];
    $width_int = intval($width_str);
    if(!empty($width_str)&&$width_int<=0){
        $input['error'] = __('图像大小不合法','moedog');
        return $input;
    }
    $height_str = $input['height'];
    $height_int = intval($height_str);
    if(!empty($height_str)&&$height_int<=0){
        $input['error'] = __('图像大小不合法','moedog');
        return $input;
    }
    $input['width'] = $width_int;
    $input['height'] = $height_int;
    return $input;
}
function add_external_media_without_import(){
    $input = sanitize_and_validate_input();
    if(isset($input['error'])) return $input;
    $url = $input['url'];
    $width = $input['width'];
    $height = $input['height'];
    $mime_type = $input['mime-type'];
    if(empty($width)||empty($height)||empty($mime_type)){
        $image_size = @getimagesize($url);
        if(empty($image_size)){
            if(empty($mime_type)){
                $response = wp_remote_head($url);
                if(is_array($response)&&isset($response['headers']['content-type'])){
                    $input['mime-type'] = $response['headers']['content-type'];
                }
            }
            $input['error'] = __('无法获取图像大小','moedog');
            return $input;
        }
        if(empty($width)) $width = $image_size[0];
        if(empty($height)) $height = $image_size[1];
        if(empty($mime_type)) $mime_type = $image_size['mime'];
    }
    $filename = wp_basename($url);
    $attachment = array(
        'guid' => $url,
        'post_mime_type' => $mime_type,
        'post_title' => preg_replace('/\.[^.]+$/','',$filename),
    );
    $attachment_metadata = array('width'=>$width,'height'=>$height,'file'=>$filename);
    $attachment_metadata['sizes'] = array('full'=>$attachment_metadata);
    $attachment_id = wp_insert_attachment($attachment);
    wp_update_attachment_metadata($attachment_id,$attachment_metadata);
    $input['id'] = $attachment_id;
    return $input;
}
//a img
function content_a_img($content){
    $pattern = "/<a href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)><img/i";
    $replacement = '<a href=$1$2.$3$4 rel="nofollow" target="_blank"><img';
    $content = preg_replace($pattern,$replacement,$content);
    return $content;
}
add_filter('the_content','content_a_img');
