<?php
/* 
 * 移植自 https://github.com/mashirozx/sakura/blob/3.x/inc/dash-scheme.php
 * 下游分支 https://github.com/KJZH001/Moe-kratos-pjax
 * 将 樱花庄 主题 移植到 moe-kratos-pjax
 * by 晓空 2025.11.20
 */

// 注册后台配色方案
function kratos_sakura_dash_scheme($key, $name, $col1, $col2, $col3, $col4, $base, $focus, $current, $rules = '') {
    $hash = 'color_1=' . str_replace('#', '', $col1) .
            '&color_2=' . str_replace('#', '', $col2) .
            '&color_3=' . str_replace('#', '', $col3) .
            '&color_4=' . str_replace('#', '', $col4) .
            '&rules=' . urlencode($rules);
    wp_admin_css_color(
        $key,
        $name,
        // 因为反正也没指望从域名能进后台，就这样吧
        get_template_directory_uri() . '/inc/dash-scheme.php?' . $hash,
        array($col1, $col2, $col3, $col4),
        array('base' => $base, 'focus' => $focus, 'current' => $current)
    );
}

function kratos_register_sakura_admin_scheme() {
    kratos_sakura_dash_scheme(
        'sakura',                   // 配色方案关键字
        'Sakura',                   // 显示名称
        '#8fbbb1', '#bfd8d2', '#fedcd2', '#df744a', // 四个主要色调
        '#e5f8ff', '#ffffff', '#ffffff',           // 基础色、焦点色、当前色
        // 自定义 CSS 规则：修改菜单文字颜色、设置后台背景图等
        '#adminmenu .wp-has-current-submenu .wp-submenu a,#adminmenu .wp-has-current-submenu.opensub .wp-submenu a,#adminmenu .wp-submenu a,#adminmenu a.wp-has-current-submenu:focus+.wp-submenu a,#wpadminbar .ab-submenu .ab-item,#wpadminbar .quicklinks .menupop ul li a,#wpadminbar .quicklinks .menupop.hover ul li a,#wpadminbar.nojs .quicklinks .menupop:hover ul li a,.folded #adminmenu .wp-has-current-submenu .wp-submenu a{color:#f3f2f1}body{background-image:url(https://view.moezx.cc/images/2018/01/29/FLOWER.jpg);background-attachment:fixed;}#wpcontent{background:rgba(255,255,255,.6)}'
    );
}
add_action('admin_init', 'kratos_register_sakura_admin_scheme');

// 后台样式和脚本（完全移植 Sakura 的用法）
function kratos_sakura_admin_assets( $hook_suffix ) {
    // 1. 后台图标（等价于原来直接引 dashicons.css）
    wp_enqueue_style( 'dashicons' );

    // 2. 通用后台修正样式（对应 Sakura 的 dashboard-fix.css）
    // wp_enqueue_style(
    //     'kratos-sakura-admin-dashboard-fix',
    //     get_template_directory_uri() . '/static/css/dashboard-fix.css',
    //     array(),
    //     '1.0'
    // );

    // 3. “明亮”样式：控制全局背景、半透明 card 等
    // Sakura 原本只在 admin_color == "light" 时加载
    // 你有两种选择：
    //   A) 跟它保持一致，只在 "light" 方案时加载
    //   B) 只要是你自定义的方案（比如 sakura/custom）就加载
    $admin_color = get_user_option( 'admin_color' );
    // A 版，完全复刻逻辑
    // if ( $admin_color === 'light' ) {
    // B 版，只要是sakura方案就加载light方案
    if ( in_array( $admin_color, array( 'light', 'sakura', 'custom' ), true ) ) {
        wp_enqueue_style(
            'kratos-sakura-admin-dashboard-light',
            get_template_directory_uri() . '/static/css/dashboard-light.css',
            array( 'kratos-sakura-admin-dashboard-fix' ),
            '1.0'
        );
    }

    // 4. 懒加载脚本（照抄 Sakura，实际上你不一定需要）
    // wp_enqueue_script(
    //     'kratos-sakura-admin-lazyload',
    //     'https://cdn-js.moeworld.top/npm/lazyload@2.0.0-beta.2/lazyload.min.js',
    //     array(),
    //     null,
    //     true
    // );
}
add_action( 'admin_enqueue_scripts', 'kratos_sakura_admin_assets' );

// 后台字体（酌情考虑添加）
// 毕竟谷歌字体的服务器在大陆是啥情况你也应该明白的……
/*
// 1) 后台整体字体
function kratos_sakura_admin_font() {
    echo '<link href="https://fonts.googleapis.com/css?family=Noto+Serif+SC&display=swap" rel="stylesheet">' . PHP_EOL;
    echo '<style>
        body,
        #wpadminbar *:not([class="ab-icon"]),
        .wp-core-ui,
        .media-menu,
        .media-frame *,
        .media-modal * {
            font-family: "Noto Serif SC","Source Han Serif SC","Source Han Serif",
                         "source-han-serif-sc","PT Serif","SongTi SC","MicroSoft Yahei",
                         Georgia,serif !important;
        }
    </style>' . PHP_EOL;
}
add_action( 'admin_head', 'kratos_sakura_admin_font' );

// 2) 前台顶部工具条字体（只给管理员看）
function kratos_sakura_adminbar_font_frontend() {
    if ( current_user_can( 'administrator' ) ) {
        echo '<link href="https://fonts.googleapis.com/css?family=Noto+Serif+SC&display=swap" rel="stylesheet">' . PHP_EOL;
        echo '<style>
            #wpadminbar *:not([class="ab-icon"]) {
                font-family: "Noto Serif SC","Source Han Serif SC","Source Han Serif",
                             "source-han-serif-sc","PT Serif","SongTi SC","MicroSoft Yahei",
                             Georgia,serif !important;
            }
        </style>' . PHP_EOL;
    }
}
add_action( 'wp_head', 'kratos_sakura_adminbar_font_frontend' );

// 3) 登录页字体
function kratos_sakura_login_font() {
    echo '<link href="https://fonts.googleapis.com/css?family=Noto+Serif+SC&display=swap" rel="stylesheet">' . PHP_EOL;
    echo '<style>
        body {
            font-family: "Noto Serif SC","Source Han Serif SC","Source Han Serif",
                         "source-han-serif-sc","PT Serif","SongTi SC","MicroSoft Yahei",
                         Georgia,serif !important;
        }
    </style>' . PHP_EOL;
}
add_action( 'login_head', 'kratos_sakura_login_font' );
*/

?>