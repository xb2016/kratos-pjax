<?php
//smtp init
add_action('phpmailer_init','mail_smtp');
function mail_smtp($phpmailer){
    if(kratos_option('mail_smtps')==1){
        $mail_name = kratos_option('mail_name');
        $mail_host = kratos_option('mail_host');
        $mail_port = kratos_option('mail_port');
        $mail_username = kratos_option('mail_username');
        $mail_passwd = kratos_option('mail_passwd');
        $mail_smtpsecure = kratos_option('mail_smtpsecure');
        $phpmailer->FromName = $mail_name?$mail_name:'Moe-dog Services Team'; 
        $phpmailer->Host = $mail_host?$mail_host:'smtp.office365.com';
        $phpmailer->Port = $mail_port?$mail_port:'587';
        $phpmailer->Username = $mail_username?$mail_username:'no_reply@fczbl.vip';
        $phpmailer->Password = $mail_passwd?$mail_passwd:'123456789';
        $phpmailer->From = $mail_username?$mail_username:'no_reply@fczbl.vip';
        $phpmailer->SMTPAuth = kratos_option('mail_smtpauth')==1?true:false ;
        $phpmailer->SMTPSecure = $mail_smtpsecure?$mail_smtpsecure:'STARTTLS';
        $phpmailer->IsSMTP();
    }
}
//Comment approved mail
add_action('comment_unapproved_to_approved','kratos_comment_approved');
function kratos_comment_approved($comment){
    if(is_email($comment->comment_author_email)){
        $wp_email = 'no-reply@'.preg_replace('#^www\.#','',strtolower($_SERVER['SERVER_NAME']));
        $to = trim($comment->comment_author_email);
        $post_link = get_permalink($comment->comment_post_ID);
        $subject = __('[通知]您的留言已经通过审核','moedog');
        $message = '
            <style>img.wp-smiley{width:auto!important;height:auto!important;max-height:8em!important;margin-top:-4px;display:inline}</style>
            <div style="background:#ececec;width: 100%;padding: 50px 0;text-align:center;">
            <div style="background:#fff;width:750px;text-align:left;position:relative;margin:0 auto;font-size:14px;line-height:1.5;">
                    <div style="zoom:1;padding:25px 40px;background:#518bcb; border-bottom:1px solid #467ec3;">
                        <h1 style="color:#fff; font-size:25px;line-height:30px; margin:0;"><a href="'.get_option('home').'" style="text-decoration: none;color: #FFF;">'.htmlspecialchars_decode(get_option('blogname'),ENT_QUOTES).'</a></h1>
                    </div>
                <div style="padding:35px 40px 30px;">
                    <h2 style="font-size:18px;margin:5px 0;">Hi '.trim($comment->comment_author).':</h2>
                    <p style="color:#313131;line-height:20px;font-size:15px;margin:20px 0;">'.__('您有一条留言通过了管理员的审核并显示在文章页面，摘要信息请见下表。','moedog').'</p>
                        <table cellspacing="0" style="font-size:14px;text-align:center;border:1px solid #ccc;table-layout:fixed;width:500px;">
                            <thead>
                                <tr>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="280px;">'.__('文章','moedog').'</th>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="270px;">'.__('内容','moedog').'</th>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="110px;">'.__('操作','moedog').'</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">《'.get_the_title($comment->comment_post_ID).'》</td>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">'.convert_smilies(trim($comment->comment_content)).'</td>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><a href="'.get_comment_link($comment->comment_ID).'" style="color:#1E5494;text-decoration:none;vertical-align:middle;" target="_blank">'.__('查看留言','moedog').'</a></td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                    <div style="font-size:13px;color:#a0a0a0;padding-top:10px">'.__('该邮件由系统自动发出，如果不是您本人操作，请忽略此邮件。','moedog').'</div>
                    <div class="qmSysSign" style="padding-top:20px;font-size:12px;color:#a0a0a0;">
                        <p style="color:#a0a0a0;line-height:18px;font-size:12px;margin:5px 0;">'.htmlspecialchars_decode(get_option('blogname'),ENT_QUOTES).'</p>
                        <p style="color:#a0a0a0;line-height:18px;font-size:12px;margin:5px 0;"><span style="border-bottom:1px dashed #ccc;" t="5" times="">'.date("Y-m-d",time()).'</span></p>
                    </div>
                </div>
            </div>
        </div>';
        $from = "From: \"".htmlspecialchars_decode(get_option('blogname'),ENT_QUOTES)."\" <$wp_email>";
        $headers = "$from\nContent-Type: text/html; charset=".get_option('blog_charset')."\n";
        wp_mail($to,$subject,$message,$headers);
    }
}
//Comment reply mail
add_action('comment_post','comment_mail_notify');
function comment_mail_notify($comment_id){
    $comment = get_comment($comment_id);
    $parent_id = $comment->comment_parent?$comment->comment_parent:'';
    $spam_confirmed = $comment->comment_approved;
    if(($parent_id!='')&&($spam_confirmed!='spam')){
        $wp_email = 'no-reply@'.preg_replace('#^www\.#','',strtolower($_SERVER['SERVER_NAME']));
        $to = trim(get_comment($parent_id)->comment_author_email);
        $subject = __('[通知]您的留言有了新的回复','moedog');
        $message = '
            <style>img.wp-smiley{width:auto!important;height:auto!important;max-height:8em!important;margin-top:-4px;display:inline}</style>
            <div style="background:#ececec;width: 100%;padding: 50px 0;text-align:center;">
            <div style="background:#fff;width:750px;text-align:left;position:relative;margin:0 auto;font-size:14px;line-height:1.5;">
                    <div style="zoom:1;padding:25px 40px;background:#518bcb; border-bottom:1px solid #467ec3;">
                        <h1 style="color:#fff; font-size:25px;line-height:30px; margin:0;"><a href="'.get_option('home').'" style="text-decoration: none;color: #FFF;">'.htmlspecialchars_decode(get_option('blogname'),ENT_QUOTES).'</a></h1>
                    </div>
                <div style="padding:35px 40px 30px;">
                    <h2 style="font-size:18px;margin:5px 0;">Hi '.trim(get_comment($parent_id)->comment_author).':</h2>
                    <p style="color:#313131;line-height:20px;font-size:15px;margin:20px 0;">'.__('您有一条留言有了新的回复，摘要信息请见下表。','moedog').'</p>
                        <table cellspacing="0" style="font-size:14px;text-align:center;border:1px solid #ccc;table-layout:fixed;width:500px;">
                            <thead>
                                <tr>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="235px;">'.__('原文','moedog').'</th>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="235px;">'.__('回复','moedog').'</th>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="100px;">'.__('作者','moedog').'</th>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="90px;">'.__('操作','moedog').'</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">'.convert_smilies(trim(get_comment($parent_id)->comment_content)).'</td>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">'.convert_smilies(trim($comment->comment_content)).'</td>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">'.trim($comment->comment_author).'</td>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><a href="'.get_comment_link($comment->comment_ID).'" style="color:#1E5494;text-decoration:none;vertical-align:middle;" target="_blank">'.__('查看回复','moedog').'</a></td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                    <div style="font-size:13px;color:#a0a0a0;padding-top:10px">'.__('该邮件由系统自动发出，如果不是您本人操作，请忽略此邮件。','moedog').'</div>
                    <div class="qmSysSign" style="padding-top:20px;font-size:12px;color:#a0a0a0;">
                        <p style="color:#a0a0a0;line-height:18px;font-size:12px;margin:5px 0;">'.htmlspecialchars_decode(get_option('blogname'),ENT_QUOTES).'</p>
                        <p style="color:#a0a0a0;line-height:18px;font-size:12px;margin:5px 0;"><span style="border-bottom:1px dashed #ccc;" t="5" times="">'.date("Y-m-d",time()).'</span></p>
                    </div>
                </div>
            </div>
        </div>';
        $from = "From: \"".htmlspecialchars_decode(get_option('blogname'),ENT_QUOTES)."\" <$wp_email>";
        $headers = "$from\nContent-Type: text/html; charset=".get_option('blog_charset')."\n";
        wp_mail($to,$subject,$message,$headers);
    }
}
//Reset pwd mail
add_filter('retrieve_password_message','kratos_reset_password_message',null,2);
function kratos_reset_password_message($message,$key){
    add_filter('wp_mail_content_type',create_function('','return "text/html";'));
    if(strpos($_POST['user_login'],'@')){
        $user_data = get_user_by('email',trim($_POST['user_login']));
    }else{
        $login = trim($_POST['user_login']);
        $user_data = get_user_by('login',$login);
    }
    $msg = '<div class="emailcontent" style="width:100%;max-width:720px;text-align:left;margin:0 auto;padding-top:80px;padding-bottom:20px"><div class="emailtitle"><h1 style="color:#fff;background:#51a0e3;line-height:70px;font-size:24px;font-weight:400;padding-left:40px;margin:0">'.__('密码重设通知','moedog').'</h1><div class="emailtext" style="background:#fff;padding:20px 32px 20px"><div style="padding:0;font-weight:700;color:#6e6e6e;font-size:16px">Hi '.$user_data->display_name.':</div><p style="color:#6e6e6e;font-size:13px;line-height:24px">'.sprintf(__("有人要求重设您在[%s]的密码，若不是您本人请求，请忽略本邮件。",'moedog'),get_option('blogname')).'</p><table cellpadding="0" cellspacing="0" border="0" style="width:100%;border-top:1px solid #eee;border-left:1px solid #eee;color:#6e6e6e;font-size:16px;font-weight:normal"><thead><tr><th colspan="2" style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center;background:#f8f8f8">'.__('密码重设信息','moedog').'</th></tr></thead><tbody><tr><td style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center;width:100px">'.__('用户名','moedog').'</td><td style="padding:10px 20px 10px 30px;border-right:1px solid #eee;border-bottom:1px solid #eee;line-height:30px">'.$user_data->user_login.'</td></tr><tr><td style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center;width:100px">'.__('登录邮箱','moedog').'</td><td style="padding:10px 20px 10px 30px;border-right:1px solid #eee;border-bottom:1px solid #eee;line-height:30px">'.$user_data->user_email.'</td></tr><tr><td style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center">'.__('密码重设地址','moedog').'</td><td style="padding:10px 20px 10px 30px;border-right:1px solid #eee;border-bottom:1px solid #eee;line-height:30px"><a href="'.network_site_url("wp-login.php?action=rp&key=$key&login=".rawurlencode($user_data->user_login),'login').'">'.__('单击访问','moedog').'</a></td></tr></tbody></table><p style="color:#6e6e6e;font-size:13px;line-height:24px">'.__('如果您的账号有异常，请您在第一时间和我们取得联系哦~','moedog').'</p></div></div></div>';
    return $msg;
}
//Register mail
add_filter('password_change_email','__return_false');
add_action('user_register','kratos_pwd_register_mail',101);
add_filter('wp_new_user_notification_email','__return_false');
function kratos_pwd_register_mail($user_id){
    $user = get_user_by('id',$user_id);
    $blogname = htmlspecialchars_decode(get_option('blogname'),ENT_QUOTES);
    if(kratos_option('mail_reg')){
        $message = '<div class="emailcontent" style="width:100%;max-width:720px;text-align:left;margin:0 auto;padding-top:80px;padding-bottom:20px"><div class="emailtitle"><h1 style="color:#fff;background:#51a0e3;line-height:70px;font-size:24px;font-weight:400;padding-left:40px;margin:0">'.__('注册成功通知','moedog').'</h1><div class="emailtext" style="background:#fff;padding:20px 32px 20px"><div style="padding:0;font-weight:700;color:#6e6e6e;font-size:16px">Hi '.$user->nickname.':</div><p style="color:#6e6e6e;font-size:13px;line-height:24px">'.sprintf(__("欢迎您注册[%s]，下面是您的账号信息，请妥善保管！",'moedog'),$blogname).'</p><table cellpadding="0" cellspacing="0" border="0" style="width:100%;border-top:1px solid #eee;border-left:1px solid #eee;color:#6e6e6e;font-size:16px;font-weight:normal"><thead><tr><th colspan="2" style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center;background:#f8f8f8">'.__('您的详细注册信息','moedog').'</th></tr></thead><tbody><tr><td style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center;width:100px">'.__('用户名','moedog').'</td><td style="padding:10px 20px 10px 30px;border-right:1px solid #eee;border-bottom:1px solid #eee;line-height:30px">'.$user->user_login.'</td></tr><tr><td style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center;width:100px">'.__('登录邮箱','moedog').'</td><td style="padding:10px 20px 10px 30px;border-right:1px solid #eee;border-bottom:1px solid #eee;line-height:30px">'.$user->user_email.'</td></tr><tr><td style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center">'.__('登录密码','moedog').'</td><td style="padding:10px 20px 10px 30px;border-right:1px solid #eee;border-bottom:1px solid #eee;line-height:30px">'.__('您设定的密码','moedog').'</td></tr></tbody></table><p style="color:#6e6e6e;font-size:13px;line-height:24px">'.__('如果您的账号有异常，请您在第一时间和我们取得联系哦~','moedog').'</p></div></div></div>';
    }else{
        $pwd = wp_generate_password(10,false);
        $user->user_pass = $pwd;
        $new_user_id = wp_update_user($user);
        $message = '<div class="emailcontent" style="width:100%;max-width:720px;text-align:left;margin:0 auto;padding-top:80px;padding-bottom:20px"><div class="emailtitle"><h1 style="color:#fff;background:#51a0e3;line-height:70px;font-size:24px;font-weight:400;padding-left:40px;margin:0">'.__('注册成功通知','moedog').'</h1><div class="emailtext" style="background:#fff;padding:20px 32px 20px"><div style="padding:0;font-weight:700;color:#6e6e6e;font-size:16px">Hi '.$user->nickname.':</div><p style="color:#6e6e6e;font-size:13px;line-height:24px">'.sprintf(__("欢迎您注册[%s]，请使用下面的信息登录并修改密码！",'moedog'),$blogname).'</p><table cellpadding="0" cellspacing="0" border="0" style="width:100%;border-top:1px solid #eee;border-left:1px solid #eee;color:#6e6e6e;font-size:16px;font-weight:normal"><thead><tr><th colspan="2" style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center;background:#f8f8f8">'.__('您的注册信息','moedog').'</th></tr></thead><tbody><tr><td style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center;width:100px">'.__('用户名','moedog').'</td><td style="padding:10px 20px 10px 30px;border-right:1px solid #eee;border-bottom:1px solid #eee;line-height:30px">'.$user->user_login.'</td></tr><tr><td style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center;width:100px">'.__('登录邮箱','moedog').'</td><td style="padding:10px 20px 10px 30px;border-right:1px solid #eee;border-bottom:1px solid #eee;line-height:30px">'.$user->user_email.'</td></tr><tr><td style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center">'.__('临时密码','moedog').'</td><td style="padding:10px 20px 10px 30px;border-right:1px solid #eee;border-bottom:1px solid #eee;line-height:30px">'.$pwd.'</td></tr><tr><td style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center;width:100px">'.__('登录地址','moedog').'</td><td style="padding:10px 20px 10px 30px;border-right:1px solid #eee;border-bottom:1px solid #eee;line-height:30px"><a href="'.wp_login_url().'">'.__('单击访问','moedog').'</a></td></tr></tbody></table><p style="color:#6e6e6e;font-size:13px;line-height:24px">'.__('如果您的账号有异常，请您在第一时间和我们取得联系哦~','moedog').'</p></div></div></div>';
    }
    $headers = "Content-Type:text/html;charset=UTF-8\n";
    wp_mail($user->user_email,'['.$blogname.']'.__('欢迎注册','moedog'),$message,$headers);
}