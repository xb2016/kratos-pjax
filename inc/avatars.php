<?php
//Replace Gravatar server
function kratos_get_avatar($avatar){
    $avatar = str_replace(array('www.gravatar.com/avatar','0.gravatar.com/avatar','1.gravatar.com/avatar','2.gravatar.com/avatar','3.gravatar.com/avatar','secure.gravatar.com/avatar'),kratos_option('gravatar_url'),$avatar);
    return $avatar;
}
add_filter('get_avatar','kratos_get_avatar');
//Local avatar
class kratos_local_avatars{
    private $user_id_being_edited;
    public function __construct(){
        add_filter('get_avatar',array($this,'get_avatar'),10,5);
        add_action('show_user_profile',array($this,'edit_user_profile'));
        add_action('edit_user_profile',array($this,'edit_user_profile'));
        add_action('personal_options_update',array($this,'edit_user_profile_update'));
        add_action('edit_user_profile_update',array($this,'edit_user_profile_update'));
        add_filter('avatar_defaults',array($this,'avatar_defaults'));
    }
    public function get_avatar($avatar='',$id_or_email,$size=96,$default='',$alt=false){
        if(is_numeric($id_or_email)) $user_id = (int)$id_or_email;
        elseif(is_string($id_or_email)&&($user=get_user_by('email',$id_or_email))) $user_id = $user->ID;
        elseif(is_object($id_or_email)&&!empty($id_or_email->user_id)) $user_id = (int)$id_or_email->user_id;
        if(empty($user_id)) return $avatar;
        $local_avatars = get_user_meta($user_id,'kratos_local_avatar',true);
        if(empty($local_avatars)||empty($local_avatars['full'])) return $avatar;
        $size = (int)$size;
        if(empty($alt)) $alt = get_the_author_meta('display_name',$user_id);
        if(empty($local_avatars[$size])){
            $upload_path = wp_upload_dir();
            $avatar_full_path = str_replace($upload_path['baseurl'],$upload_path['basedir'],$local_avatars['full']);
            $image_sized = image_resize($avatar_full_path,$size,$size,true);       
            $local_avatars[$size] = is_wp_error($image_sized)?$local_avatars[$size]=$local_avatars['full']:str_replace($upload_path['basedir'],$upload_path['baseurl'],$image_sized); 
            update_user_meta($user_id,'kratos_local_avatar',$local_avatars);
        }elseif(substr($local_avatars[$size],0,4)!='http') $local_avatars[$size] = home_url($local_avatars[$size]);
        $author_class = is_author($user_id)?' current-author':'';
        $avatar = "<img alt='".esc_attr($alt)."' src='".$local_avatars[$size]."' class='avatar avatar-{$size}{$author_class} photo' height='{$size}' width='{$size}' />";
        return apply_filters('kratos_local_avatar',$avatar);
    }
    public function edit_user_profile($profileuser){ ?>
    <table class="form-table">
        <tr>
            <th><label for="kratos-local-avatar"><?php _e('上传头像','moedog'); ?></label></th>
            <td style="width: 50px;" valign="top">
                <?php echo get_avatar($profileuser->ID); ?>
            </td>
            <td><?php
                if(kratos_option('lo_ava')||current_user_can('upload_files')){ ?>
                    <input type="file" name="kratos-local-avatar" id="kratos-local-avatar" /><br /><?php
                    if(empty($profileuser->kratos_local_avatar)) echo '<span class="description">'.__('尚未设置本地头像，请点击“浏览”按钮上传本地头像。','moedog').'</span>';
                    else echo '
                            <input type="checkbox" name="kratos-local-avatar-erase" value="1" /> '.__('移除本地头像','moedog').'<br />
                            <span class="description">'.__('如需要修改本地头像，请重新上传新头像。如需要移除本地头像，请选中上方的“移除本地头像”复选框并更新个人资料即可。<br/>移除本地头像后，将恢复使用 Gravatar 头像。','moedog').'</span>';      
                }else{
                    if(empty($profileuser->kratos_local_avatar)) echo '<span class="description">'.__('尚未设置本地头像，请在 Gravatar.com 网站设置头像。','moedog').'</span>';
                    else echo '<span class="description">'.__('你没有本地头像上传权限，如需要修改本地头像，请联系站点管理员。','moedog').'</span>';
                } ?>
            </td>
        </tr>
    </table>
    <script type="text/javascript">var form=document.getElementById('your-profile');form.encoding='multipart/form-data';form.setAttribute('enctype','multipart/form-data');</script><?php
    }
    public function edit_user_profile_update($user_id){
        if(!empty($_FILES['kratos-local-avatar']['name'])){
            $mimes = array(
                'jpg|jpeg|jpe' => 'image/jpeg',
                'gif' => 'image/gif',
                'png' => 'image/png',
                'bmp' => 'image/bmp',
                'tif|tiff' => 'image/tiff'
            );
            if(!function_exists('wp_handle_upload')) require_once(ABSPATH.'wp-admin/includes/file.php');
            $this->avatar_delete($user_id);
            if(strstr($_FILES['kratos-local-avatar']['name'],'.php')) wp_die(__('.php不能出现在文件名中！','moedog'));
            $this->user_id_being_edited = $user_id;
            $avatar = wp_handle_upload($_FILES['kratos-local-avatar'],array('mimes'=>$mimes,'test_form'=>false,'unique_filename_callback'=>array($this,'unique_filename_callback')));
            if(empty($avatar['file'])){
                switch($avatar['error']){
                    case 'Sorry, this file type is not permitted for security reasons.':
                        wp_die(__('请上传jpg,gif,png,bmp,tif格式文件！','moedog'));break;
                    default: wp_die('<strong>'.__('上传头像过程中出现以下错误：','moedog').'</strong> '.esc_attr($avatar['error']));
                }
                return;
            }
            update_user_meta($user_id,'kratos_local_avatar',array('full'=>$avatar['url']));
        }else{
            if(!empty($_POST['kratos-local-avatar-erase'])) $this->avatar_delete( $user_id );
        }
    }
    public function avatar_defaults($avatar_defaults){
        remove_action('get_avatar',array($this,'get_avatar'));
        return $avatar_defaults;
    }
    public function avatar_delete($user_id){
        $old_avatars = get_user_meta($user_id,'kratos_local_avatar',true);
        $upload_path = wp_upload_dir();
        if(is_array($old_avatars)){
            foreach($old_avatars as $old_avatar){
                $old_avatar_path = str_replace($upload_path['baseurl'],$upload_path['basedir'],$old_avatar);
                @unlink($old_avatar_path);    
            }
        }
        delete_user_meta($user_id,'kratos_local_avatar');
    }
    public function unique_filename_callback($dir,$name,$ext){
        $user = get_user_by('id',(int)$this->user_id_being_edited); 
        $name = $base_name = sanitize_file_name($user->user_login.'_avatar');
        $number = 1;
        while(file_exists($dir."/$name$ext")){
            $name = $base_name.'_'.$number;
            $number++;
        }
        return $name.$ext;
    }
}
$kratos_local_avatars = new kratos_local_avatars;
function get_kratos_local_avatar($id_or_email,$size='96',$default='',$alt=false){
    global $kratos_local_avatars;
    $avatar = $kratos_local_avatars->get_avatar('',$id_or_email,$size,$default,$alt);
    if(empty($avatar)) $avatar = get_avatar($id_or_email,$size,$default,$alt);
    return $avatar;
}