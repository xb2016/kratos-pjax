<?php if(post_password_required()) return; ?>
<div id="comments" class="comments-area">
    <ol class="comment-list">
    <?php if(have_comments()){ ?>
        <?php wp_list_comments(array('style'=>'ol','short_ping'=>true,'avatar_size'=>50,)); ?>
    </ol>
        <?php if(get_comment_pages_count()>1&&get_option('page_comments')){ ?>
            <div id="comments-nav">
                <?php paginate_comments_links('prev_text='.__('上一页','moedog').'&next_text='.__('下一页','moedog'));?>
            </div>
        <?php }
    }else echo '</ol>';
    $comment_num1=rand(0,9);
    $comment_num2=rand(0,9);
    $fields=array(
            'author'=>'<div class="comment-form-author form-group has-feedback"><div class="input-group"><div class="input-group-addon"><i class="fa fa-user"></i></div><input class="form-control" placeholder="'.__('昵称','moedog').'" id="author" name="author" type="text" value="'.esc_attr($commenter['comment_author']).'" size="30" /><span class="form-control-feedback required">*</span></div></div>',
            'email'=>'<div class="comment-form-email form-group has-feedback"><div class="input-group"><div class="input-group-addon"><i class="fa fa-envelope-o"></i></div><input class="form-control" placeholder="'.__('邮箱','moedog').'" id="email" name="email" type="text" value="'.esc_attr($commenter['comment_author_email']).'" size="30" /><span class="form-control-feedback required">*</span></div></div>',
            'code'=>'<div class="comment-form-url form-group has-feedback"><div class="input-group"><div class="input-group-addon"><i class="fa fa-key"></i></div><input class="form-control" placeholder="'.__('人机验证：','moedog').$comment_num1.' ＋ '.$comment_num2.' = ?" id="code" name="code" type="text" value="" autocomplete="off" size="30" /><span class="form-control-feedback required">*</span><input type="hidden" name="co_num1" value="'.($comment_num1 + 1).'" /><input type="hidden" name="co_num2" value="'.($comment_num2 + 2).'" /></div></div>',
            'url'=>'<div class="comment-form-url form-group has-feedback"><div class="input-group"><div class="input-group-addon"><i class="fa fa-link"></i></div><input class="form-control" placeholder="'.__('网站','moedog').'" id="url" name="url" type="text" value="'.esc_attr($commenter['comment_author_url']).'" size="30" /></div></div>',
            'cookies'=>'',
    );
    $args=array(
        'title_reply_before'=>'<h4 id="reply-title" class="comment-reply-title">',
        'title_reply_after'=>'</h4>',
        'fields'=>$fields,
        'class_submit'=>'btn btn-primary',
        'comment_notes_before' => '<p class="comment-notes">'.__('电子邮件地址不会被公开。必填项已用 * 标注','moedog').'</p>',
        'comment_field'=>'<div class="comment form-group has-feedback"><div class="input-group"><textarea class="form-control" id="comment" placeholder="'.__('|´・ω・)ノ还不快点说点什么呀poi~','moedog').'" name="comment" rows="5" aria-required="true" required  onkeydown="if(event.ctrlKey){if(event.keyCode==13){document.getElementById(\'submit\').click();return false}};"></textarea></div><div class="OwO"></div></div>',
    );
    comment_form($args); ?>
</div>