<?php
//The article heat
function most_comm_posts($days=30,$nums=5){
    global $wpdb;
    $today = date("Y-m-d H:i:s");
    $daysago = date("Y-m-d H:i:s",strtotime($today)-($days*24*60*60));
    $result = $wpdb->get_results("SELECT comment_count,ID,post_title,post_date FROM $wpdb->posts WHERE post_date BETWEEN '$daysago' AND '$today' and post_type='post' and post_status='publish' ORDER BY comment_count DESC LIMIT 0 ,$nums");
    $output = '';
    if(empty($result)){
        $output = '<li>暂时没有数据</li>';
    }else{
        foreach($result as $topten){
            $postid = $topten->ID;
            $title = $topten->post_title;
            $commentcount = $topten->comment_count;
            if($commentcount>=0){
                $output .= '<a class="list-group-item visible-lg" title="'.$title.'" href="'.get_permalink($postid).'" rel="bookmark"><i class="fa  fa-book"></i> ';
                $output .= strip_tags($title);
                $output .= '</a>';
                $output .= '<a class="list-group-item visible-md" title="'.$title.'" href="'.get_permalink($postid).'" rel="bookmark"><i class="fa  fa-book"></i> ';
                $output .= strip_tags($title);
                $output .= '</a>';
            }
        }
    }
    echo $output;
}
//time ago
function timeago($ptime){
    $ptime = strtotime($ptime);
    $etime = time()-$ptime;
    if($etime<1) return'刚刚';
    $interval = array(
        12*30*24*60*60 => ' 年前 ('.date('m月d日',$ptime).')',
        30*24*60*60 => ' 个月前 ('.date('m月d日',$ptime).')',
        7*24*60*60 => ' 周前 ('.date('m月d日',$ptime).')',
        24*60*60 => ' 天前 ('.date('m月d日',$ptime).')',
        60*60 => ' 小时前 ('.date('m月d日',$ptime).')',
        60 => ' 分钟前 ('.date('m月d日',$ptime).')',
        1 => ' 秒前 ('.date('m月d日',$ptime).')',
    );
    foreach($interval as $secs=>$str){
        $d=$etime/$secs;
        if($d>=1){
        $r=round($d);
        return$r.$str;
        }
    };
}
//string cut
function kratos_string_cut($string, $sublen, $start = 0, $code = 'UTF-8') {
    if($code == 'UTF-8') {
        $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
        preg_match_all($pa,$string,$t_string);
        if(count($t_string[0])-$start>$sublen) return join('',array_slice($t_string[0],$start,$sublen))."...";
        return join('',array_slice($t_string[0],$start,$sublen));
    }else{
        $start = $start*2;
        $sublen = $sublen*2;
        $strlen = strlen($string);
        $tmpstr = '';
        for($i=0;$i<$strlen;$i++){
            if($i>=$start&&$i<($start+$sublen)){
                if(ord(substr($string,$i,1))>129) $tmpstr .= substr($string,$i,2);
                else $tmpstr .= substr($string,$i,1);
            }
        if(ord(substr($string,$i,1))>129) $i++;
        }
        return $tmpstr;
    }
}
function kratos_widgets_init(){
    register_sidebar(array(
        'name'=>'侧边栏工具',
        'id'=>'sidebar_tool',
        'before_widget'=>'<aside id="%1$s" class="widget %2$s clearfix">',
        'after_widget'=>'</aside>',
        'before_title'=>'<h4 class="widget-title">',
        'after_title'=>'</h4>'
    ));   
}
add_action('widgets_init','kratos_widgets_init');
function remove_default_widget(){
       unregister_widget('WP_Widget_Recent_Posts');
       unregister_widget('WP_Widget_Tag_Cloud');
       unregister_widget('WP_Widget_RSS');
       unregister_widget('WP_Widget_Calendar');
       unregister_widget('WP_Widget_Pages');
       unregister_widget('WP_Widget_Search');
       unregister_widget('WP_Nav_Menu_Widget');
       unregister_widget('WP_Widget_Meta');
       unregister_widget('WP_Widget_Media_Image');
       unregister_widget('WP_Widget_Media_Video');
       unregister_widget('WP_Widget_Recent_Comments');
       unregister_widget('WP_Widget_Text');
}
add_action('widgets_init','remove_default_widget');
class kratos_widget_ad extends WP_Widget {
    function __construct() {
        $widget_ops = array(
            'classname'  => 'widget_kratos_ad',
            'name'       => '广告位',
            'description'=> 'Kratos主题特色组件 - 广告位'
        );
        parent::__construct(false,false,$widget_ops);
    }
    function widget($args,$instance){
        extract($args);
        $aurl = $instance['aurl']?$instance['aurl']:'';
        $title = $instance['title']?$instance['title']:'';
        $imgurl = $instance['imgurl']?$instance['imgurl']:'';
        echo $before_widget;
        if(!empty($title)){ ?>
            <h4 class="widget-title"><?php echo $title; ?></h4><?php
        }
        if(!empty($imgurl)){ ?>
            <a href="<?php echo $aurl; ?>" target="_blank">
                <img class="carousel-inner img-responsive img-rounded" src="<?php echo $imgurl; ?>" />
            </a><?php
        }
        echo $after_widget;
    }
    function update($new_instance,$old_instance){
        return $new_instance;
    }
    function form($instance){
        @$title = esc_attr($instance['title']);
        @$aurl = esc_attr($instance['aurl']);
        @$imgurl = esc_attr($instance['imgurl']); ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">
                    标题：
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('aurl'); ?>">
                    链接：
                    <input class="widefat" id="<?php echo $this->get_field_id('aurl'); ?>" name="<?php echo $this->get_field_name('aurl'); ?>" type="text" value="<?php echo $aurl; ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('imgurl'); ?>">
                    图片：
                    <input class="widefat" id="<?php echo $this->get_field_id('imgurl'); ?>" name="<?php echo $this->get_field_name('imgurl'); ?>" type="text" value="<?php echo $imgurl; ?>" />
                </label>
            </p><?php
    }
}
class kratos_widget_about extends WP_Widget {
    function __construct() {
        $widget_ops = array(
            'classname'  => 'widget_kratos_about',
            'name'       => '个人简介',
            'description'=> 'Kratos主题特色组件 - 个人简介'
        );
        parent::__construct(false,false,$widget_ops);
    }
    function widget($args,$instance){
        extract($args);
        $profile = $instance['profile']?$instance['profile']:'';
        $imgurl = $instance['imgurl']?$instance['imgurl']:'';
        $bkimgurl = $instance['bkimgurl']?$instance['bkimgurl']:'';
        echo $before_widget;
        if(!is_home()) $redirect = get_permalink(); else $redirect = get_bloginfo('home');?>
        <div class="photo-background">
            <div class="photo-background" style="background:url(<?php if(!empty($bkimgurl)) echo $bkimgurl; else echo bloginfo('template_url')."/images/about.jpg"; ?>) no-repeat center center;-webkit-background-size:cover;background-size:cover"></div>
        </div>
        <?php if(current_user_can('manage_options')){ ?>
        <div class="photo-wrapper clearfix">
            <div class="photo-wrapper-tip text-center">
                <?php global $current_user;echo get_avatar($current_user->user_email); ?>
            </div>
        </div>
        <div class="textwidget">
            <div class="widget-admin text-center">
                <p>
                    <a href="<?php echo admin_url('/post-new.php'); ?>"><i class="fa fa-pencil"></i> 撰写文章 </a>
                    <a class="widget-admin-center" href="<?php echo admin_url('/post-new.php?post_type=page'); ?>"><i class="fa fa-plus"></i> 新建页面 </a>
                    <a href="<?php echo admin_url('/edit-comments.php'); ?>"><i class="fa fa-comments"></i> 查看评论</a>
                </p>
                <p>
                    <a href="<?php echo admin_url('/options-general.php'); ?>"><i class="fa fa-cogs"></i> 站点设置 </a>
                    <a class="widget-admin-center" href="<?php echo admin_url('/themes.php?page=kratos'); ?>"><i class="fa fa-cog"></i> 主题设置 </a>
                    <a href="<?php echo wp_logout_url($redirect); ?>"><i class="fa fa-sign-out"></i> 退出登录</a>
                </p>
            </div>
        </div>
        <?php }elseif(is_user_logged_in()){ ?>
        <div class="photo-wrapper clearfix">
            <div class="photo-wrapper-tip text-center">
                <?php global $current_user;echo get_avatar($current_user->user_email); ?>
            </div>
        </div>
        <div class="textwidget">
            <div class="widget-admin text-center">
                <p>
                    <a href="<?php echo admin_url('/profile.php'); ?>"><i class="fa fa-pencil"></i> 个人资料 </a>
                    <a href="<?php echo admin_url('/'); ?>"><i class="fa fa-dashboard"></i> 仪表盘 </a>
                    <a href="<?php echo wp_logout_url($redirect); ?>"><i class="fa fa-sign-out"></i> 退出登录</a>
                </p>
            </div>
        </div>
        <?php }else{ ?>
        <div class="photo-wrapper clearfix">
            <div class="photo-wrapper-tip text-center">
                <a href="<?php echo wp_login_url($redirect); ?>" rel="nofollow"><img class="about-photo" src="<?php if(!empty($imgurl)) echo $imgurl; else echo bloginfo('template_url')."/images/photo.jpg"; ?>" alt=""/></a>
            </div>
        </div>
        <div class="textwidget">
            <p class="text-center"><?php echo $profile; ?></p>
        </div><?php
    }
        echo $after_widget;
    }
    function update($new_instance,$old_instance){return $new_instance;}
    function form($instance){
        @$imgurl = esc_attr($instance['imgurl']);
        @$bkimgurl = esc_attr($instance['bkimgurl']);
        @$profile = esc_attr($instance['profile']); ?>
        <p>
            <label for="<?php echo $this->get_field_id('imgurl'); ?>">
                头像地址：
                <input class="widefat" id="<?php echo $this->get_field_id('imgurl'); ?>" name="<?php echo $this->get_field_name('imgurl'); ?>" type="text" value="<?php echo $imgurl; ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('profile'); ?>">
                简介内容：
                <textarea class="widefat" rows="4" id="<?php echo $this->get_field_id('profile'); ?>" name="<?php echo $this->get_field_name('profile'); ?>" ><?php echo $profile; ?></textarea>
            </label>
        </p> 
        <p>
            <label for="<?php echo $this->get_field_id('bkimgurl'); ?>">
                卡片背景：
                <input class="widefat" id="<?php echo $this->get_field_id('bkimgurl'); ?>" name="<?php echo $this->get_field_name('bkimgurl'); ?>" type="text" value="<?php echo $bkimgurl; ?>" />
            </label>
        </p><?php 
    }
}
class kratos_widget_tags extends WP_Widget {
    function __construct() {
        $widget_ops = array(
            'name'       => '标签聚合',
            'description'=> 'Kratos主题特色组件 - 标签聚合'
        );
        parent::__construct(false,false,$widget_ops);
    }
    function widget($args, $instance){
        extract($args);
        $result = '';
        $title = $instance['title']?esc_attr($instance['title']):'';
        $title = apply_filters('widget_title',$title);
        $number = (!empty($instance['number']))?intval($instance['number']):50;
        $orderby = (!empty($instance['orderby']))?esc_attr($instance['orderby']):'count';
        $order = (!empty($instance['order']))?esc_attr($instance['order']):'DESC';
        $tags = wp_tag_cloud(array(
                    'unit' => 'px',
                    'smallest' => 13,
                    'largest' => 13,
                    'number' => $number,
                    'format' => 'flat',
                    'orderby' => $orderby,
                    'order' => $order,
                    'echo' => FALSE
                )
        );
        $result .= $before_widget;
        if($title) $result .= '<h4 class="widget-title">'.$title .'</h4>';
        $result .= '<div class="tag_clouds">';
        $result .= $tags;
        $result .= '</div>';
        $result .= $after_widget;
        echo $result;
    }
    function update($new_instance,$old_instance){
        if(!isset($new_instance['submit'])) return false;
        $instance = $old_instance;
        $instance['title'] = esc_attr($new_instance['title']);
        $instance['number'] = intval($new_instance['number']);
        $instance['orderby'] = esc_attr($new_instance['orderby']);
        $instance['order'] = esc_attr($new_instance['order']);
        return $instance;
    }
    function form($instance){
        global $wpdb;
        $instance = wp_parse_args((array) $instance,array('title'=>'标签聚合','number'=>'20','orderby'=>'count','order'=>'RAND'));
        $title =  esc_attr($instance['title']);
        $number = intval($instance['number']);
        $orderby =  esc_attr($instance['orderby']);
        $order =  esc_attr($instance['order']); ?>
        <p>
            <label for='<?php echo $this->get_field_id("title"); ?>'>标题：<input type='text' class='widefat' name='<?php echo $this->get_field_name("title"); ?>' id='<?php echo $this->get_field_id("title"); ?>' value="<?php echo $title; ?>"/></label>
        </p>
        <p>
            <label for='<?php echo $this->get_field_id("number"); ?>'>数量：<input type='text' name='<?php echo $this->get_field_name("number"); ?>' id='<?php echo $this->get_field_id("number"); ?>' value="<?php echo $number; ?>"/></label>
        </p>
        <p>
            <label for='<?php echo $this->get_field_id("orderby"); ?>'>类型：
                <select name="<?php echo $this->get_field_name("orderby"); ?>" id='<?php echo $this->get_field_id("orderby"); ?>'>
                    <option value="count" <?php echo ($orderby=='count')?'selected':''; ?>>数量</option>
                    <option value="name" <?php echo ($orderby=='name')?'selected':''; ?>>名字</option>
                </select>
            </label>
        </p>
        <p>
            <label for='<?php echo $this->get_field_id("order"); ?>'>排序：
                <select name="<?php echo $this->get_field_name("order"); ?>" id='<?php echo $this->get_field_id("order"); ?>'>
                    <option value="DESC" <?php echo ($order=='DESC')?'selected':''; ?>>降序</option>
                    <option value="ASC" <?php echo ($order=='ASC')?'selected':''; ?>>升序</option>
                    <option value="RAND" <?php echo ($order=='RAND')?'selected':''; ?>>随机</option>
                </select>
            </label>
        </p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" /><?php
    }
}
class kratos_widget_posts extends WP_Widget {
    function __construct() {
        $widget_ops = array(
            'classname'  => 'kratos_widget_posts',
            'name'       => '文章聚合',
            'description'=> 'Kratos主题特色组件 - 文章聚合'
        );
        parent::__construct(false,false,$widget_ops);
    }
    function widget($args,$instance){
        extract($args);
        $result = '';
        $number = (!empty($instance['number']))?intval($instance['number']):5; ?>
        <aside class="widget widget_kratos_poststab">
            <ul id="tabul" class="nav nav-tabs nav-justified visible-lg">
                <li class="active"><span href="#newest" data-toggle="tab">最新文章</span></li>
                <li><span href="#hot" data-toggle="tab">热点文章</span></li>
                <li><span href="#rand" data-toggle="tab">随机文章</span></li>
            </ul>
            <ul id="tabul" class="nav nav-tabs nav-justified visible-md">
                <li class="active"><span href="#newest" data-toggle="tab">最新</span></li>
                <li><span href="#hot" data-toggle="tab">热点</span></li>
                <li><span href="#rand" data-toggle="tab">随机</span></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="newest">
                    <ul class="list-group">
                        <?php $myposts = get_posts('numberposts='.$number.' & offset=0');foreach($myposts as $post): ?>
                            <a class="list-group-item visible-lg" title="<?php echo $post->post_title; ?>" href="<?php echo get_permalink($post->ID); ?>" rel="bookmark"><i class="fa  fa-book"></i> <?php echo strip_tags($post->post_title) ?>
                            </a>
                            <a class="list-group-item visible-md" title="<?php echo $post->post_title; ?>" href="<?php echo get_permalink($post->ID); ?>" rel="bookmark"><i class="fa  fa-book"></i> <?php echo strip_tags($post->post_title) ?>
                            </a>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="tab-pane fade" id="hot">
                    <ul class="list-group">
                        <?php if(function_exists('most_comm_posts')) most_comm_posts(180,$number); ?>
                    </ul>
                </div>
                <div class="tab-pane fade" id="rand">
                    <ul class="list-group">
                        <?php $myposts = get_posts('numberposts='.$number.' & offset=0 & orderby=rand');foreach($myposts as $post): ?>
                            <a class="list-group-item visible-lg" title="<?php echo $post->post_title; ?>" href="<?php echo get_permalink($post->ID); ?>" rel="bookmark"><i class="fa  fa-book"></i> <?php echo strip_tags($post->post_title) ?>
                            </a>
                            <a class="list-group-item visible-md" title="<?php echo $post->post_title; ?>" href="<?php echo get_permalink($post->ID); ?>" rel="bookmark"><i class="fa  fa-book"></i> <?php echo strip_tags($post->post_title) ?>
                            </a>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </aside><?php
    }
    function update($new_instance,$old_instance){
        if(!isset($new_instance['submit'])) return false;
        $instance = $old_instance;
        $instance['number'] = intval($new_instance['number']);
        return $instance;
    }
    function form($instance){
        global $wpdb;
        $instance = wp_parse_args((array) $instance,array('number'=>'5'));
        $number = intval($instance['number']); ?>
        <p>
            <label for='<?php echo $this->get_field_id("number"); ?>'>每项展示数量：<input type='text' name='<?php echo $this->get_field_name("number"); ?>' id='<?php echo $this->get_field_id("number"); ?>' value="<?php echo $number; ?>"/></label>
        </p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" /><?php
    }
}
class kratos_widget_comments extends WP_Widget {
    function __construct() {
        $widget_ops = array(
            'classname'  => 'widget_kratos_comments',
            'name'       => '最近评论',
            'description'=> 'Kratos主题特色组件 - 最近评论'
        );
        parent::__construct(false,false,$widget_ops);
    }
    function widget($args,$instance){
        if(!isset($args['widget_id'])) $args['widget_id'] = $this->id;
        $output = '';
        $title = isset($instance['title'])?$instance['title']:'最近评论';
        $number = isset($instance['number'])?absint($instance['number']):5;
        $comments = get_comments(apply_filters('widget_comments_args',array(
            'number' => $number,
            'status' => 'approve',
            'type' => 'comment',
            'post_status' => 'publish'
            )));
        $output    = $args['before_widget'];
        if($title) $output .= $args['before_title'].$title.$args['after_title'];
        $output .= '<div class="recentcomments">';
        if(is_array($comments)&&$comments){
            foreach($comments as $comment){
                $output .= '<li class="comment-listitem">';
                $output .= '<div class="comment-user">';
                $output .= '<span class="comment-avatar">'.get_avatar($comment,50,null).'</span>';
                $output .= '<span class="comment-author">'.$comment->comment_author.'</span>';
                $output .= '<span class="comment-date">'.timeago($comment->comment_date_gmt).'</span>';
                $output .= '</div>';
                $output .= '<div class="comment-content-link"><a href="'.get_comment_link($comment->comment_ID).'"><div class="comment-content">'.convert_smilies(kratos_string_cut(strip_tags(get_comment_excerpt($comment->comment_ID)),30)).'</div></a></div>';
                $output .= '</li>';
            }
        }
        $output .= '</div>';
        $output .= $args['after_widget'];
        echo $output;
    }
    public function update($new_instance,$old_instance){
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['number'] = absint($new_instance['number']);
        return $instance;
    }
    public function form($instance){
        $title = !empty($instance['title'])?$instance['title']:'最近评论';
        $number = !empty($instance['number'])?absint($instance['number']):5; ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                标题：
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>">
                显示数量：
                <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1" max="99" value="<?php echo $number; ?>" size="3" />
            </label>
        </p><?php
    }
}
function kratos_register_widgets(){
    register_widget('kratos_widget_ad'); 
    register_widget('kratos_widget_about'); 
    register_widget('kratos_widget_tags'); 
    register_widget('kratos_widget_posts'); 
    register_widget('kratos_widget_comments'); 
}
add_action('widgets_init','kratos_register_widgets');