<?php
class Options_Framework_Media_Uploader {
    public function init() {
        add_action( 'admin_enqueue_scripts', array( $this, 'optionsframework_media_scripts' ) );
    }
    static function optionsframework_uploader( $_id, $_value, $_desc = '', $_name = '' ) {
        $options_framework = new Options_Framework;
        $option_name = $options_framework->get_option_name();
        $output = '';
        $id = '';
        $class = '';
        $int = '';
        $value = '';
        $name = '';
        $id = strip_tags( strtolower( $_id ) );
        if ( $_value != '' && $value == '' ) {
            $value = $_value;
        }
        if ($_name != '') {
            $name = $_name;
        }
        else {
            $name = $option_name.'['.$id.']';
        }
        if ( $value ) {
            $class = ' has-file';
        }
        $output .= '<input id="' . $id . '" class="upload' . $class . '" type="text" name="'.$name.'" value="' . $value . '" placeholder="' . __('未选择任何文件', 'moedog') .'" />' . "\n";
        if ( function_exists( 'wp_enqueue_media' ) ) {
            if ( ( $value == '' ) ) {
                $output .= '<input id="upload-' . $id . '" class="upload-button button" type="button" value="' . __( '上传', 'moedog' ) . '" />' . "\n";
            } else {
                $output .= '<input id="remove-' . $id . '" class="remove-file button" type="button" value="' . __( '移除', 'moedog' ) . '" />' . "\n";
            }
        } else {
            $output .= '<p><i>' . __( '请更新您的 WordPress 版本以获取完整的媒体文件支持。', 'moedog' ) . '</i></p>';
        }
        if ( $_desc != '' ) {
            $output .= '<span class="of-metabox-desc">' . $_desc . '</span>' . "\n";
        }
        $output .= '<div class="screenshot" id="' . $id . '-image">' . "\n";
        if ( $value != '' ) {
            $remove = '<a class="remove-image">Remove</a>';
            $image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value );
            if ( $image ) {
                $output .= '<img src="' . $value . '" alt="" />' . $remove;
            } else {
                $parts = explode( "/", $value );
                for( $i = 0; $i < sizeof( $parts ); ++$i ) {
                    $title = $parts[$i];
                }
                $output .= '';
                $title = __( '查看文件', 'moedog' );
                $output .= '<div class="no-image"><span class="file_link"><a href="' . $value . '" target="_blank" rel="external">'.$title.'</a></span></div>';
            }
        }
        $output .= '</div>' . "\n";
        return $output;
    }
    function optionsframework_media_scripts( $hook ) {
        $menu = Options_Framework_Admin::menu_settings();
        if ( substr( $hook, -strlen( $menu['menu_slug'] ) ) !== $menu['menu_slug'] )
            return;
        if ( function_exists( 'wp_enqueue_media' ) )
            wp_enqueue_media();
        wp_register_script( 'of-media-uploader', OPTIONS_FRAMEWORK_DIRECTORY .'js/media-uploader.js', array( 'jquery' ), Options_Framework::VERSION );
        wp_enqueue_script( 'of-media-uploader' );
        wp_localize_script( 'of-media-uploader', 'optionsframework_l10n', array(
            'upload' => __( '上传', 'moedog' ),
            'remove' => __( '移除', 'moedog' )
        ) );
    }
}