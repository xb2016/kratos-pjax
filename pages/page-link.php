<?php /** template name: 友情链接模板 */ get_header(); ?>
  <div id="container" class="container">
    <div class="row">
      <?php if(kratos_option( 'page_side_bar')=='left_side' &&!wp_is_mobile()){ ?>
        <aside id="kratos-widget-area" class="col-md-4 hidden-xs hidden-sm scrollspy">
          <div id="sidebar" class="affix-top">
            <?php dynamic_sidebar( 'sidebar_tool'); ?></div>
        </aside>
        <?php } ?>
          <section id="main" class='<?php echo (kratos_option(' page_side_bar ')=='center ')?'col-md-12 ':'col-md-8 '; ?>'>
            <?php if(have_posts()){the_post(); ?>
              <article>
                <div class="kratos-hentry kratos-post-inner clearfix">
                  <div class="kratos-post-content-l">
                    <h2 class="title-h2" style="text-align:center;font-size:18pt">友情链接</h2>
                    <?php $bookmarks=get_bookmarks(); if(!empty($bookmarks)){ foreach($bookmarks as $bookmark){ if ($bookmark->link_rel == 'me'){ $me_links[] = $bookmark; } else { $friend_links[] = $bookmark; } } if(!empty($me_links)){ ?>
                      <p style="text-align:center">
                        <span style="color:#999999">自己的项目</span></p>
                      <div class="linkpage">
                        <hr/>
                        <ul>
                          <?php foreach($me_links as $link){ $friendimg=$link->link_image; if(empty($friendimg)){ echo '
                            <li>
                              <a href="'.$link->link_url.'" target="_blank" rel="nofollow">
                                <img src="'.get_stylesheet_directory_uri().'/images/avatar.jpg">
                                <h4>'.$link->link_name.'</h4>
                                <p>'.$link->link_description.'</p>
                              </a>
                            </li>'; } else { echo '
                            <li>
                              <a href="'.$link->link_url.'" target="_blank" rel="nofollow">
                                <img src="'.$link->link_image.'">
                                <h4>'.$link->link_name.'</h4>
                                <p>'.$link->link_description.'</p>
                              </a>
                            </li>'; } } ?></ul>
                        <hr/></div>
                      <?php } if(!empty($friend_links)){ ?>
                        <p style="text-align:center">
                          <span style="color:#999999">dalao们的友链</span></p>
                        <div class="linkpage">
                          <hr/>
                          <ul>
                            <?php foreach($friend_links as $link){ $friendimg=$link->link_image; if(empty($friendimg)){ echo '
                              <li>
                                <a href="'.$link->link_url.'" target="_blank" rel="nofollow">                                 
                                  <img src="'.get_stylesheet_directory_uri().'/images/avatar.jpg">
                                  <h4>'.$link->link_name.'</h4>
                                  <p>'.$link->link_description.'</p>
                                </a>
                              </li>'; } else { echo '
                              <li>
                                <a href="'.$link->link_url.'" target="_blank" rel="nofollow">
                                  <img src="'.$link->link_image.'">
                                  <h4>'.$link->link_name.'</h4>
                                  <p>'.$link->link_description.'</p>
                                </a>
                              </li>'; } } ?></ul>
                          <hr/></div>
                        <?php } } the_content(); ?></div>
                </div>
                <?php comments_template(); ?></article>
              <?php } ?></section>
          <?php if(kratos_option( 'page_side_bar')=='right_side' &&!wp_is_mobile()){ ?>
            <aside id="kratos-widget-area" class="col-md-4 hidden-xs hidden-sm scrollspy">
              <div id="sidebar" class="affix-top">
                <?php dynamic_sidebar( 'sidebar_tool'); ?></div>
            </aside>
            <?php } ?></div>
    <?php if(current_user_can( 'manage_options')&&is_single()||is_page()){ ?>
      <div class="cd-tool text-center">
        <div class="<?php if(kratos_option('cd_weixin')) echo 'edit-box2 '; ?>edit-box">
          <?php echo edit_post_link( '<span class="fa fa-pencil"></span>'); ?></div>
      </div>
      <?php } if(kratos_option( 'script_tongji')) echo '<script type="text/javascript">'.kratos_option( 'script_tongji'). '</script>'; ?></div>
  </div>
  <?php get_footer(); ?>
