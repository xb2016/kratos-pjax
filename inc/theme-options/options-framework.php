<?php
if ( ! defined( 'WPINC' ) ) {
    die;
}
if (is_admin() && ! function_exists( 'optionsframework_init' ) ) :
function optionsframework_init() {
    if ( ! current_user_can( 'edit_theme_options' ) ) {
        return;
    }
    require plugin_dir_path( __FILE__ ) . 'includes/class-options-framework.php';
    require plugin_dir_path( __FILE__ ) . 'includes/class-options-framework-admin.php';
    require plugin_dir_path( __FILE__ ) . 'includes/class-options-interface.php';
    require plugin_dir_path( __FILE__ ) . 'includes/class-options-media-uploader.php';
    require plugin_dir_path( __FILE__ ) . 'includes/class-options-sanitization.php';
    $options_framework_admin = new Options_Framework_Admin;
    $options_framework_admin->init();
    $options_framework_media_uploader = new Options_Framework_Media_Uploader;
    $options_framework_media_uploader->init();
}
add_action( 'init', 'optionsframework_init', 20 );
endif;
if ( ! function_exists( 'kratos_option' ) ) :
function kratos_option( $name, $default = false ) {
    $option_name = '';
    if ( function_exists( 'optionsframework_option_name' ) ) {
        $option_name = optionsframework_option_name();
    }
    if ( '' == $option_name ) {
        $option_name = get_option( 'stylesheet' );
        $option_name = preg_replace( "/\W/", "_", strtolower( $option_name ) );
    }
    $options = get_option( $option_name );
    if ( isset( $options[$name] ) ) {
        return $options[$name];
    }
    return $default;
}
endif;