<?php
//Photo Thumbnails
function kratos_photo_thumbnail(){  
    global $post;  
    if(has_post_thumbnail()){  
       the_post_thumbnail(array(750,),array('class'=>'img-responsive'));
    }else{ 
        $content = $post->post_content;  
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim',$content,$strResult,PREG_PATTERN_ORDER);  
        $n = count($strResult[1]);  
        if($n>0){ 
            echo '<img src="'.$strResult[1][0].'" class="img-responsive" />';  
        }else {
            echo '<img src="'.get_bloginfo('template_url').'/images/thumb/thumb_1.jpg" class="img-responsive" />';  
        }  
    }  
}
//Post Thumbnails
if(function_exists('add_image_size')) add_image_size('kratos-thumb',750);
function kratos_blog_thumbnail(){
    global $post;
    $img_id = get_post_thumbnail_id();
    $img_url = wp_get_attachment_image_src($img_id,'kratos-entry-thumb');
    $img_url = $img_url[0];
    if(has_post_thumbnail()) echo '<a href="'.get_permalink().'"><img src="'.$img_url.'" /></a>';
}
add_filter('add_image_size',create_function('','return 1;'));
add_theme_support("post-thumbnails");
function kratos_blog_thumbnail_new(){
    global $post;
    $img_id = get_post_thumbnail_id();
    $img_url = wp_get_attachment_image_src($img_id,'kratos-entry-thumb');
    $img_url = $img_url[0];
    if(has_post_thumbnail()){
        echo '<a href="'.get_permalink().'"><img src="'.$img_url.'" /></a>';
    }else{
        $content = $post->post_content;
        $img_preg = "/<img(.*?)src=\"(.+?)\".*?>/";
        preg_match($img_preg,$content,$img_src);
        $img_count=count($img_src)-1;
        if(isset($img_src[$img_count]))
        $img_val = $img_src[$img_count];
        if(!empty($img_val)){
            echo '<a href="'.get_permalink().'"><img src="'.$img_val.'" /></a>';
        }else if(!kratos_option('default_image')){
            $random = mt_rand(1,20);
            echo '<a href="'.get_permalink().'"><img src="'.get_bloginfo('template_url').'/images/thumb/thumb_'.$random.'.jpg" /></a>';
        }else echo '<a href="'.get_permalink().'"><img src="'.kratos_option('default_image').'" /></a>';   
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