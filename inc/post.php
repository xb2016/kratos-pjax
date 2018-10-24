<?php
//The article reading quantity statistics
function kratos_set_post_views(){
    if(is_singular()){
      global $post;
      $post_ID = $post->ID;
      if($post_ID){
          $post_views = (int)get_post_meta($post_ID,'views',true);
          if(!update_post_meta($post_ID,'views',($post_views+1))) add_post_meta($post_ID,'views',1,true);
      }
    }
}
add_action('wp_head','kratos_set_post_views');
function num2tring($num){
    if($num>=1000) $num = round($num/1000*100)/100 .'k';
    return $num;
}
function kratos_get_post_views($before='',$after='',$echo=1){
  global $post;
  $post_ID = $post->ID;
  $views = (int)get_post_meta($post_ID,'views',true);
  return num2tring($views);
}
//Appreciate the article
function kratos_love(){
    global $wpdb,$post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    if($action=='love'){
        $raters = get_post_meta($id,'love',true);
        $expire = time()+99999999;
        $domain = ($_SERVER['HTTP_HOST']!='localhost')?$_SERVER['HTTP_HOST']:false;
        setcookie('love_'.$id,$id,$expire,'/',$domain,false);
        if(!$raters||!is_numeric($raters)){
            update_post_meta($id,'love',1);
        }else{
            update_post_meta($id,'love',($raters+1));
        }
        echo get_post_meta($id,'love',true);
    }
    die;
}
add_action('wp_ajax_nopriv_love','kratos_love');
add_action('wp_ajax_love','kratos_love');
//Post title optimization
add_filter('private_title_format','kratos_private_title_format' );
add_filter('protected_title_format','kratos_private_title_format' );
function kratos_private_title_format($format){return '%s';}
//Password protection articles
add_filter('the_password_form','custom_password_form');
function custom_password_form(){
    $url = wp_login_url();
    global $post;$label='pwbox-'.(empty($post->ID)?rand():$post->ID);$o='
    <form class="protected-post-form" action="'.$url.'?action=postpass" method="post">
        <div class="panel panel-pwd">
            <div class="panel-body text-center">
                <img class="post-pwd" src="'.get_template_directory_uri().'/static/images/fingerprint.png"><br />
                <h4>'.__('这是一篇受保护的文章，请输入阅读密码！','moedog').'</h4>
                <div class="input-group" id="respond">
                    <div class="input-group-addon"><i class="fa fa-key"></i></div>
                    <p><input class="form-control" placeholder="'.__('输入阅读密码','moedog').'" name="post_password" id="'.$label.'" type="password" size="20"></p>
                </div>
                <div class="comment-form" style="margin-top:15px;"><button id="generate" class="btn btn-primary btn-pwd" name="Submit" type="submit">'.__('确认','moedog').'</button></div>
            </div>
        </div>
    </form>';
return $o;
}
//Comments face
add_filter('smilies_src','custom_smilies_src',1,10);
function custom_smilies_src($img_src,$img,$siteurl){
    if(kratos_option('owo_out')) $owodir = 'https://cdn.jsdelivr.net/gh/xb2016/kratos-pjax@'.KRATOS_VERSION; else $owodir = get_bloginfo('template_directory');
    return $owodir.'/static/images/smilies/'.$img;
}
function smilies_reset(){
    global $wpsmiliestrans,$wp_smiliessearch,$wp_version;
    if(!get_option('use_smilies')||$wp_version<4.2) return;
    $wpsmiliestrans = array(
     ':hehe:' => 'hehe.png',
     ':haha:' => 'haha.png',
    ':tushe:' => 'tushe.png',
        ':a:' => 'a.png',
       ':ku:' => 'ku.png',
       ':nu:' => 'nu.png',
   ':kaixin:' => 'kaixin.png',
      ':han:' => 'han.png',
      ':lei:' => 'lei.png',
  ':heixian:' => 'heixian.png',
    ':bishi:' => 'bishi.png',
':bugaoxing:' => 'bugaoxing.png',
 ':zhenbang:' => 'zhenbang.png',
     ':qian:' => 'qian.png',
    ':yiwen:' => 'yiwen.png',
  ':yinxian:' => 'yinxian.png',
       ':tu:' => 'tu.png',
       ':yi:' => 'yi.png',
    ':weiqv:' => 'weiqv.png',
   ':huaxin:' => 'huaxin.png',
       ':hu:' => 'hu.png',
  ':xiaoyan:' => 'xiaoyan.png',
     ':leng:' => 'leng.png',
':taikaixin:' => 'taikaixin.png',
     ':meng:' => 'meng.png',
    ':huaji:' => 'huaji.png',
   ':huaji2:' => 'huaji2.png',
   ':huaji3:' => 'huaji3.gif',
   ':huaji4:' => 'huaji4.png',
   ':huaji5:' => 'huaji5.gif',
   ':huaji6:' => 'huaji6.png',
   ':huaji7:' => 'huaji7.png',
   ':huaji8:' => 'huaji8.png',
   ':huaji9:' => 'huaji9.png',
  ':huaji10:' => 'huaji10.png',
  ':huaji11:' => 'huaji11.png',
  ':huaji12:' => 'huaji12.png',
  ':huaji13:' => 'huaji13.png',
  ':huaji14:' => 'huaji14.png',
  ':huaji15:' => 'huaji15.png',
  ':huaji16:' => 'huaji16.gif',
  ':huaji17:' => 'huaji17.png',
  ':huaji18:' => 'huaji18.png',
  ':huaji19:' => 'huaji19.png',
  ':huaji20:' => 'huaji20.gif',
  ':huaji21:' => 'huaji21.gif',
  ':huaji22:' => 'huaji22.png',
  ':huaji23:' => 'huaji23.png',
':mianqiang:' => 'mianqiang.png',
 ':kuanghan:' => 'kuanghan.png',
     ':guai:' => 'guai.png',
 ':shuijiao:' => 'shuijiao.png',
   ':jingku:' => 'jingku.png',
  ':shengqi:' => 'shengqi.png',
   ':jingya:' => 'jingya.png',
      ':pen:' => 'pen.png',
    ':aixin:' => 'aixin.png',
   ':xinsui:' => 'xinsui.png',
   ':meigui:' => 'meigui.png',
     ':liwu:' => 'liwu.png',
  ':caihong:' => 'caihong.png',
     ':xxyl:' => 'xxyl.png',
      ':sun:' => 'sun.png',
    ':money:' => 'money.png',
     ':bulb:' => 'bulb.png',
      ':cup:' => 'cup.png',
     ':cake:' => 'cake.png',
    ':music:' => 'music.png',
    ':haha2:' => 'haha2.png',
      ':win:' => 'win.png',
     ':good:' => 'good.png',
      ':bad:' => 'bad.png',
       ':ok:' => 'ok.png',
     ':stop:' => 'stop.png',
   ':hahaha:' => 'hahaha.png',
    );
}
smilies_reset();
//Paging
function kratos_pages($range=5){
    global $paged,$wp_query,$max_page;
    if(!$max_page){$max_page=$wp_query->max_num_pages;}
    if($max_page>1){if(!$paged){$paged=1;}
    echo "<div class='text-center' id='page-footer'><ul class='pagination'>";
        if($paged != 1) echo '<li><a href="'.get_pagenum_link(1).'" class="extend" title="'.__('首页','moedog').'">&laquo;</a></li>';
        if($paged>1) echo '<li><a href="'.get_pagenum_link($paged-1).'" class="prev" title="'.__('上一页','moedog').'">&lt;</a></li>';
        if($max_page>$range){
            if($paged<$range){
                for($i=1;$i<=($range+1);$i++){
                    echo "<li";
                    if($i==$paged) echo " class='active'";
                    echo "><a href='".get_pagenum_link($i)."'>$i</a></li>";
                }
            }
            elseif($paged>=($max_page-ceil(($range/2)))){
                for($i=$max_page-$range;$i<=$max_page;$i++){
                    echo "<li";
                    if($i==$paged) echo " class='active'";echo "><a href='".get_pagenum_link($i)."'>$i</a></li>";
                }
            }
            elseif($paged>=$range&&$paged<($max_page-ceil(($range/2)))){
                for($i=($paged-ceil($range/2));$i<=($paged+ceil(($range/2)));$i++){
                    echo "<li";
                    if($i==$paged) echo " class='active'";
                    echo "><a href='".get_pagenum_link($i)."'>$i</a></li>";
                }
            }
        }else{
            for($i=1;$i<=$max_page;$i++){
                echo "<li";
                if($i==$paged) echo " class='active'";
                echo "><a href='".get_pagenum_link($i)."'>$i</a></li>";
            }
        }
        if($paged<$max_page) echo '<li><a href="'.get_pagenum_link($paged+1).'" class="next" title="'.__('下一页','moedog').'">&gt;</a></li>';
        if($paged!=$max_page) echo '<li><a href="'.get_pagenum_link($max_page).'" class="extend" title="'.__('尾页','moedog').'">&raquo;</a></li>';
        echo "</ul></div>";
    }
}