<?php
add_filter( 'of_sanitize_text', 'sanitize_text_field' );
add_filter( 'of_sanitize_password', 'sanitize_text_field' );
add_filter( 'of_sanitize_select', 'of_sanitize_enum', 10, 2 );
add_filter( 'of_sanitize_radio', 'of_sanitize_enum', 10, 2 );
add_filter( 'of_sanitize_images', 'of_sanitize_enum', 10, 2 );
function of_sanitize_textarea( $input ) {
    global $allowedposttags;
    $output = wp_kses( $input, $allowedposttags );
    return $output;
}
add_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
function of_sanitize_checkbox( $input ) {
    if ( $input ) {
        $output = '1';
    } else {
        $output = false;
    }
    return $output;
}
add_filter( 'of_sanitize_checkbox', 'of_sanitize_checkbox' );
function of_sanitize_multicheck( $input, $option ) {
    $output = '';
    if ( is_array( $input ) ) {
        foreach( $option['options'] as $key => $value ) {
            $output[$key] = false;
        }
        foreach( $input as $key => $value ) {
            if ( array_key_exists( $key, $option['options'] ) && $value ) {
                $output[$key] = '1';
            }
        }
    }
    return $output;
}
add_filter( 'of_sanitize_multicheck', 'of_sanitize_multicheck', 10, 2 );
function of_sanitize_upload( $input ) {
    $output = '';
    $filetype = wp_check_filetype( $input );
    if ( $filetype["ext"] ) {
        $output = esc_url( $input );
    }
    return $output;
}
add_filter( 'of_sanitize_upload', 'of_sanitize_upload' );
function of_sanitize_editor( $input ) {
    if ( current_user_can( 'unfiltered_html' ) ) {
        $output = $input;
    }
    else {
        global $allowedposttags;
        $output = wpautop( wp_kses( $input, $allowedposttags ) );
    }
    return $output;
}
add_filter( 'of_sanitize_editor', 'of_sanitize_editor' );
function of_sanitize_allowedtags( $input ) {
    global $allowedtags;
    $output = wpautop( wp_kses( $input, $allowedtags ) );
    return $output;
}
function of_sanitize_allowedposttags( $input ) {
    global $allowedposttags;
    $output = wpautop( wp_kses( $input, $allowedposttags) );
    return $output;
}
function of_sanitize_enum( $input, $option ) {
    $output = '';
    if ( array_key_exists( $input, $option['options'] ) ) {
        $output = $input;
    }
    return $output;
}
function of_sanitize_background( $input ) {
    $output = wp_parse_args( $input, array(
        'color' => '',
        'image'  => '',
        'repeat'  => 'repeat',
        'position' => 'top center',
        'attachment' => 'scroll'
    ) );
    $output['color'] = apply_filters( 'of_sanitize_hex', $input['color'] );
    $output['image'] = apply_filters( 'of_sanitize_upload', $input['image'] );
    $output['repeat'] = apply_filters( 'of_background_repeat', $input['repeat'] );
    $output['position'] = apply_filters( 'of_background_position', $input['position'] );
    $output['attachment'] = apply_filters( 'of_background_attachment', $input['attachment'] );
    return $output;
}
add_filter( 'of_sanitize_background', 'of_sanitize_background' );
function of_sanitize_background_repeat( $value ) {
    $recognized = of_recognized_background_repeat();
    if ( array_key_exists( $value, $recognized ) ) {
        return $value;
    }
    return apply_filters( 'of_default_background_repeat', current( $recognized ) );
}
add_filter( 'of_background_repeat', 'of_sanitize_background_repeat' );
function of_sanitize_background_position( $value ) {
    $recognized = of_recognized_background_position();
    if ( array_key_exists( $value, $recognized ) ) {
        return $value;
    }
    return apply_filters( 'of_default_background_position', current( $recognized ) );
}
add_filter( 'of_background_position', 'of_sanitize_background_position' );
function of_sanitize_background_attachment( $value ) {
    $recognized = of_recognized_background_attachment();
    if ( array_key_exists( $value, $recognized ) ) {
        return $value;
    }
    return apply_filters( 'of_default_background_attachment', current( $recognized ) );
}
add_filter( 'of_background_attachment', 'of_sanitize_background_attachment' );
function of_sanitize_typography( $input, $option ) {
    $output = wp_parse_args( $input, array(
        'size'  => '',
        'face'  => '',
        'style' => '',
        'color' => ''
    ) );
    if ( isset( $option['options']['faces'] ) && isset( $input['face'] ) ) {
        if ( !( array_key_exists( $input['face'], $option['options']['faces'] ) ) ) {
            $output['face'] = '';
        }
    }
    else {
        $output['face']  = apply_filters( 'of_font_face', $output['face'] );
    }
    $output['size']  = apply_filters( 'of_font_size', $output['size'] );
    $output['style'] = apply_filters( 'of_font_style', $output['style'] );
    $output['color'] = apply_filters( 'of_sanitize_color', $output['color'] );
    return $output;
}
add_filter( 'of_sanitize_typography', 'of_sanitize_typography', 10, 2 );
function of_sanitize_font_size( $value ) {
    $recognized = of_recognized_font_sizes();
    $value_check = preg_replace('/px/','', $value);
    if ( in_array( (int) $value_check, $recognized ) ) {
        return $value;
    }
    return apply_filters( 'of_default_font_size', $recognized );
}
add_filter( 'of_font_size', 'of_sanitize_font_size' );
function of_sanitize_font_style( $value ) {
    $recognized = of_recognized_font_styles();
    if ( array_key_exists( $value, $recognized ) ) {
        return $value;
    }
    return apply_filters( 'of_default_font_style', current( $recognized ) );
}
add_filter( 'of_font_style', 'of_sanitize_font_style' );
function of_sanitize_font_face( $value ) {
    $recognized = of_recognized_font_faces();
    if ( array_key_exists( $value, $recognized ) ) {
        return $value;
    }
    return apply_filters( 'of_default_font_face', current( $recognized ) );
}
add_filter( 'of_font_face', 'of_sanitize_font_face' );
function of_recognized_background_repeat() {
    $default = array(
        'no-repeat' => __( '不重复', 'moedog' ),
        'repeat-x'  => __( '水平重复', 'moedog' ),
        'repeat-y'  => __( '垂直重复', 'moedog' ),
        'repeat'    => __( '全部重复', 'moedog' ),
        );
    return apply_filters( 'of_recognized_background_repeat', $default );
}
function of_recognized_background_position() {
    $default = array(
        'top left'      => __( '上部左边', 'moedog' ),
        'top center'    => __( '上部中间', 'moedog' ),
        'top right'     => __( '上部右边', 'moedog' ),
        'center left'   => __( '中部左边', 'moedog' ),
        'center center' => __( '中部中间', 'moedog' ),
        'center right'  => __( '中部右边', 'moedog' ),
        'bottom left'   => __( '下部左边', 'moedog' ),
        'bottom center' => __( '下部中间', 'moedog' ),
        'bottom right'  => __( '下部右边', 'moedog')
        );
    return apply_filters( 'of_recognized_background_position', $default );
}
function of_recognized_background_attachment() {
    $default = array(
        'scroll' => __( '正常滚动', 'moedog' ),
        'fixed'  => __( '固定', 'moedog')
        );
    return apply_filters( 'of_recognized_background_attachment', $default );
}
function of_sanitize_hex( $hex, $default = '' ) {
    if ( of_validate_hex( $hex ) ) {
        return $hex;
    }
    return $default;
}
add_filter( 'of_sanitize_color', 'of_sanitize_hex' );
function of_recognized_font_sizes() {
    $sizes = range( 9, 71 );
    $sizes = apply_filters( 'of_recognized_font_sizes', $sizes );
    $sizes = array_map( 'absint', $sizes );
    return $sizes;
}
function of_recognized_font_faces() {
    $default = array(
        'arial'     => 'Arial',
        'verdana'   => 'Verdana, Geneva',
        'trebuchet' => 'Trebuchet',
        'georgia'   => 'Georgia',
        'times'     => 'Times New Roman',
        'tahoma'    => 'Tahoma, Geneva',
        'palatino'  => 'Palatino',
        'helvetica' => 'Helvetica*'
        );
    return apply_filters( 'of_recognized_font_faces', $default );
}
function of_recognized_font_styles() {
    $default = array(
        'normal'      => __( '常规', 'moedog' ),
        'italic'      => __( '斜体', 'moedog' ),
        'bold'        => __( '粗体', 'moedog' ),
        'bold italic' => __( '斜粗体', 'moedog' )
        );
    return apply_filters( 'of_recognized_font_styles', $default );
}
function of_validate_hex( $hex ) {
    $hex = trim( $hex );
    if ( 0 === strpos( $hex, '#' ) ) {
        $hex = substr( $hex, 1 );
    }
    elseif ( 0 === strpos( $hex, '%23' ) ) {
        $hex = substr( $hex, 3 );
    }
    if ( 0 === preg_match( '/^[0-9a-fA-F]{6}$/', $hex ) ) {
        return false;
    }
    else {
        return true;
    }
}