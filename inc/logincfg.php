<?php
//Custom login
function custom_login(){
    echo '<link rel="stylesheet" id="wp-admin-css" href="'.get_bloginfo('template_directory').'/static/css/customlogin.min.css" type="text/css" />';
    echo '<style>body{background:#92C1D1 url('.kratos_option('login_bak').') fixed center top no-repeat!important;background-size:cover!important}.login h1 a{background-image:url('.kratos_option('login_logo').')!important}</style>';
}
add_action('login_head','custom_login');
//Register domain limit
add_action('register_post','validdomain',10,3);
function validdomain($login,$email,$errors){
    $validDomains = explode("\r\n",kratos_option('dwhite'));
    $invalidDomains = explode("\r\n",kratos_option('dblack'));
    if(kratos_option('dmode')=='black'){
        $isValidEmailDomain = true;
        foreach($invalidDomains as $badDomain){
          if(!empty($badDomain)){
            $domainLength = strlen($badDomain);
            $emailDomain = strtolower(substr($email,-($domainLength),$domainLength));
            if($emailDomain==strtolower($badDomain)){
              $isValidEmailDomain = false;
              break;
            }
          }
        }
    }else{
        $isValidEmailDomain = false;
        foreach($validDomains as $domain){
          if(!empty($domain)){
            $domainLength = strlen($domain);
            $emailDomain = strtolower(substr($email,-($domainLength),$domainLength));
            if($emailDomain==strtolower($domain)){
              $isValidEmailDomain = true;
              break;
            }
          }
        }
    }
    if($isValidEmailDomain===false) $errors->add('domain_error','<strong>'.__('错误','moedog').'</strong>：'.kratos_option('derror'));
}
//Pwd register
add_action('register_form','kratos_show_extra_register_fields');
add_action('register_post','kratos_check_extra_register_fields',10,3);
add_action('user_register','kratos_register_extra_fields',100);
function kratos_show_extra_register_fields(){ ?>
    <p>
        <label for="nickname"><?php _e('昵称','moedog'); ?><br/>
            <input id="nickname" class="input" type="text" name="nickname" value="" size="20" />
        </label>
    </p>
    <?php if(kratos_option('mail_reg')){ ?>
    <p>
        <label for="password"><?php _e('密码','moedog'); ?><br/>
            <input id="password" class="input" type="password" name="password" value="" size="25" />
        </label>
    </p>
    <p>
        <label for="repeat_password"><?php _e('重复密码','moedog'); ?><br/>
            <input id="repeat_password" class="input" type="password" name="repeat_password" value="" size="25" />
        </label>
    </p><?php }
    $num1=rand(10,89);$num2=rand(0,9); ?>
    <p>
        <label for="are_you_human"><?php _e('人机验证：','moedog');echo $num1.' + '.$num2.' = ?'; ?><br/>
            <input id="are_you_human" class="input" autocomplete="off" type="text" name="are_you_human" value="" size="25" />
            <input type="hidden" name="num1" value="<?php echo $num1; ?>">
            <input type="hidden" name="num2" value="<?php echo $num2; ?>">
        </label>
    </p><?php
}
function kratos_check_extra_register_fields($login,$email,$errors){
    if($_POST['nickname']=='') $errors->add('no_nickname',__("<strong>错误</strong>：昵称一栏不能为空。",'moedog'));
    if($_POST['password']!==$_POST['repeat_password']&&kratos_option('mail_reg')) $errors->add('passwords_not_matched',__("<strong>错误</strong>：两次输入的密码不一致。",'moedog'));
    if(strlen($_POST['password'])<8&&kratos_option('mail_reg')) $errors->add('password_too_short',__("<strong>错误</strong>：密码长度必须大于8位。",'moedog'));
    if($_POST['are_you_human']!=$_POST['num1']+$_POST['num2']) $errors->add('not_human',__("<strong>错误</strong>：验证码错误，请重试。",'moedog'));
}
function kratos_register_extra_fields($user_id){
    $userdata = array();
    $userdata['ID'] = $user_id;
    if(kratos_option('mail_reg')) $userdata['user_pass'] = $_POST['password'];
    $userdata['nickname'] = $_POST['nickname'];
    $userdata['display_name'] = $_POST['nickname'];
    $new_user_id = wp_update_user($userdata);
}
//Login limit
if(kratos_option('login_limit')){
    if(kratos_option('cookies')){
        limit_login_handle_cookies();
        add_action('auth_cookie_bad_username','limit_login_failed_cookie');
        add_action('auth_cookie_bad_hash','limit_login_failed_cookie_hash');
        add_action('auth_cookie_valid','limit_login_valid_cookie',10,2);
    }
    add_filter('wp_authenticate_user','limit_login_wp_authenticate_user',99999,2);
    add_filter('shake_error_codes','limit_login_failure_shake');
    add_action('login_head','limit_login_add_error_message');
    add_action('login_errors','limit_login_fixup_error_messages');
    add_action('wp_authenticate','limit_login_track_credentials',10,2);
    add_action('wp_login_failed','limit_login_failed');
}
$limit_login_my_error_shown = false;
$limit_login_just_lockedout = false;
$limit_login_nonempty_credentials = false;
function limit_login_get_address(){
    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
        $cip = $_SERVER["HTTP_CLIENT_IP"];
    }elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
        $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }elseif(!empty($_SERVER["REMOTE_ADDR"])){
        $cip = $_SERVER["REMOTE_ADDR"];
    }else{
        $cip = '';
    }
    preg_match("/[\d\.]{7,15}/",$cip,$cips);
    $cip = isset($cips[0])?$cips[0]:'unknown';
    unset($cips);
    return $cip;
}
function is_limit_login_ok(){
    $ip = limit_login_get_address();
    $lockouts = get_option('limit_login_lockouts');
    return (!is_array($lockouts)||!isset($lockouts[$ip])||time()>=$lockouts[$ip]);
}
function limit_login_wp_authenticate_user($user,$password){
    if(is_wp_error($user)||is_limit_login_ok()) return $user;
    global $limit_login_my_error_shown;
    $limit_login_my_error_shown = true;
    $error = new WP_Error();
    $error->add('too_many_retries',limit_login_error_msg());
    return $error;
}
function limit_login_failure_shake($error_codes){
    $error_codes[] = 'too_many_retries';
    return $error_codes;
}
function limit_login_handle_cookies(){
    if(is_limit_login_ok()) return;
    limit_login_clear_auth_cookie();
}
function limit_login_failed_cookie_hash($cookie_elements){
    limit_login_clear_auth_cookie();
    extract($cookie_elements,EXTR_OVERWRITE);
    $user = get_userdatabylogin($username);
    if(!$user){
        limit_login_failed($username);
        return;
    }
    $previous_cookie = get_user_meta($user->ID,'limit_login_previous_cookie',true);
    if($previous_cookie&&$previous_cookie==$cookie_elements) return;
    if ($previous_cookie)
        update_user_meta($user->ID,'limit_login_previous_cookie',$cookie_elements);
    else
        add_user_meta($user->ID,'limit_login_previous_cookie',$cookie_elements,true);
    limit_login_failed($username);
}
function limit_login_valid_cookie($cookie_elements,$user){
    if(get_user_meta($user->ID,'limit_login_previous_cookie')) delete_user_meta($user->ID, 'limit_login_previous_cookie');
}
function limit_login_failed_cookie($cookie_elements){
    limit_login_clear_auth_cookie();
    limit_login_failed($cookie_elements['username']);
}
function limit_login_clear_auth_cookie(){
    wp_clear_auth_cookie();
    if(!empty($_COOKIE[AUTH_COOKIE])) $_COOKIE[AUTH_COOKIE] = '';
    if(!empty($_COOKIE[SECURE_AUTH_COOKIE])) $_COOKIE[SECURE_AUTH_COOKIE] = '';
    if(!empty($_COOKIE[LOGGED_IN_COOKIE])) $_COOKIE[LOGGED_IN_COOKIE] = '';
}
function limit_login_failed($username) {
    $ip = limit_login_get_address();
    $lockouts = get_option('limit_login_lockouts');
    if(!is_array($lockouts)) $lockouts = array();
    if(isset($lockouts[$ip])&&time()<$lockouts[$ip]) return;
    $retries = get_option('limit_login_retries');
    $valid = get_option('limit_login_retries_valid');
    if(!is_array($retries)){
        $retries = array();
        add_option('limit_login_retries',$retries,'','no');
    }
    if(!is_array($valid)){
        $valid = array();
        add_option('limit_login_retries_valid',$valid,'','no');
    }
    if(isset($retries[$ip])&&isset($valid[$ip])&&time()<$valid[$ip]){
        $retries[$ip]++;
    }else{
        $retries[$ip]=1;
    }
    $valid[$ip] = time()+kratos_option('valid_duration');
    if($retries[$ip]%kratos_option('allowed_retries')!=0){
        limit_login_cleanup($retries,null,$valid);
        return;
    }
    $retries_long = kratos_option('allowed_retries')*kratos_option('allowed_lockouts');
    global $limit_login_just_lockedout;
    $limit_login_just_lockedout = true;
    if($retries[$ip]>=$retries_long){
        $lockouts[$ip] = time()+kratos_option('long_duration');
        unset($retries[$ip]);
        unset($valid[$ip]);
    }else{
        $lockouts[$ip] = time()+kratos_option('lockout_duration');
    }
    limit_login_cleanup($retries,$lockouts,$valid);
    limit_login_notify_email($username);
    $total = get_option('limit_login_lockouts_total');
    if($total===false||!is_numeric($total)){
        add_option('limit_login_lockouts_total',1,'','no');
    }else{
        update_option('limit_login_lockouts_total',$total+1);
    }
}
function limit_login_cleanup($retries = null, $lockouts = null, $valid = null) {
    $now = time();
    $lockouts = !is_null($lockouts)?$lockouts:get_option('limit_login_lockouts');
    if(is_array($lockouts)){
        foreach($lockouts as $ip=>$lockout){
            if($lockout<$now) unset($lockouts[$ip]);
        }
        update_option('limit_login_lockouts',$lockouts);
    }
    $valid = !is_null($valid)?$valid:get_option('limit_login_retries_valid');
    $retries = !is_null($retries)?$retries:get_option('limit_login_retries');
    if(!is_array($valid)||!is_array($retries)) return;
    foreach($valid as $ip=>$lockout){
        if($lockout<$now){
            unset($valid[$ip]);
            unset($retries[$ip]);
        }
    }
    foreach($retries as $ip=>$retry){
        if(!isset($valid[$ip])) unset($retries[$ip]);
    }
    update_option('limit_login_retries',$retries);
    update_option('limit_login_retries_valid',$valid);
}
function is_limit_login_multisite(){
    return function_exists('get_site_option')&&function_exists('is_multisite')&&is_multisite();
}
function limit_login_notify_email($user){
    if(!kratos_option('lockout_notify_m')) return;
    $ip = limit_login_get_address();
    $retries = get_option('limit_login_retries');
    if(!is_array($retries)) $retries = array();
    if(isset($retries[$ip])&&(($retries[$ip]/kratos_option('allowed_retries'))%kratos_option('notify_email_after'))!=0) return;
    if(!isset($retries[$ip])){
        $count = kratos_option('allowed_retries')*kratos_option('allowed_lockouts');
        $lockouts = kratos_option('allowed_lockouts');
        $time = round(kratos_option('long_duration')/3600);
        $when = sprintf(__('%d 小时','moedog'),$time);
    }else{
        $count = $retries[$ip];
        $lockouts = floor($count/kratos_option('allowed_retries'));
        $time = round(kratos_option('lockout_duration')/60);
        $when = sprintf(__('%d 分钟','moedog'),$time);
    }
    $blogname = htmlspecialchars_decode(get_option('blogname'),ENT_QUOTES);
    $subject = '['.$blogname.'] '.__('登录失败次数过多','moedog');
    $message = sprintf(__("失败登录次数：%d ，IP：%s",'moedog')
                  ."\r\n\r\n",$count,$ip);
    if ($user != '') {
        $message .= sprintf(__("最后一次尝试登录的用户名：%s",'moedog')
                    ."\r\n\r\n",$user);
    }
    $message .= sprintf(__('此 IP 已被封锁，封锁时长：%s','moedog'),$when);
    $admin_email = is_limit_login_multisite()?get_site_option('admin_email'):get_option('admin_email');
    @wp_mail($admin_email,$subject,$message);
}
function limit_login_error_msg(){
    $ip = limit_login_get_address();
    $lockouts = get_option('limit_login_lockouts');
    $msg = __('<strong>错误</strong>：登录失败次数过多，','moedog');
    if(!is_array($lockouts)||!isset($lockouts[$ip])||time()>= $lockouts[$ip]){
        $msg .= __('请稍候再试。','moedog');
        return $msg;
    }
    $when = ceil(($lockouts[$ip]-time())/60);
    if($when>60){
        $when = ceil($when/60);
        $msg .= sprintf(__('请在 %d 小时后重试。','moedog'),$when);
    } else {
        $msg .= sprintf(__('请在 %d 分钟后重试。','moedog'),$when);
    }
    return $msg;
}
function limit_login_retries_remaining_msg(){
    $ip = limit_login_get_address();
    $retries = get_option('limit_login_retries');
    $valid = get_option('limit_login_retries_valid');
    if(!is_array($retries)||!is_array($valid)) return '';
    if(!isset($retries[$ip])||!isset($valid[$ip])||time()>$valid[$ip]) return '';
    if(($retries[$ip]%kratos_option('allowed_retries'))==0) return '';
    $remaining = max((kratos_option('allowed_retries')-($retries[$ip]%kratos_option('allowed_retries'))),0);
    return sprintf(__('<strong>错误</strong>：账号或密码有误，您还有<strong>%d</strong>次尝试机会。','moedog'),$remaining);
}
function limit_login_get_message(){
    if(!is_limit_login_ok()) return limit_login_error_msg();
    return limit_login_retries_remaining_msg();
}
function should_limit_login_show_msg(){
    if(isset($_GET['key'])) return false;
    $action = isset($_REQUEST['action'])?$_REQUEST['action']:'';
    return ($action!='lostpassword'&&$action!='retrievepassword'&&$action!='resetpass'&&$action!='rp'&&$action!='register');
}
function limit_login_fixup_error_messages($content){
    global $limit_login_just_lockedout,$limit_login_nonempty_credentials,$limit_login_my_error_shown;
    if(!should_limit_login_show_msg()) return $content;
    if(!is_limit_login_ok()&&!$limit_login_just_lockedout) return limit_login_error_msg();
    $msgs = explode("<br />\n",$content);
    if(strlen(end($msgs))==0) array_pop($msgs);
    $count = count($msgs);
    $my_warn_count = $limit_login_my_error_shown?1:0;
    if($limit_login_nonempty_credentials&&$count>$my_warn_count){
        if($limit_login_my_error_shown){
            $content = limit_login_get_message()."<br />";
        }
        return $content;
    }elseif($count<=1){
        return $content;
    }
    $new = '';
    while($count-- > 0){
        $new .= array_shift($msgs)."<br />\n";
        if($count>0) $new .= "<br />\n";
    }
    return $new;
}
function limit_login_add_error_message(){
    global $error, $limit_login_my_error_shown;
    if(!should_limit_login_show_msg()||$limit_login_my_error_shown) return;
    $msg = limit_login_get_message();
    if($msg!=''){
        $limit_login_my_error_shown = true;
        $error .= $msg;
    }
    return;
}
function limit_login_track_credentials($user,$password){
    global $limit_login_nonempty_credentials;
    $limit_login_nonempty_credentials = (!empty($user)&&!empty($password));
}