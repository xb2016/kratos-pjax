<?php

define('KRATOS_VERSION','0.3.7');

require_once(get_template_directory().'/inc/core.php');
require_once(get_template_directory().'/inc/shortcode.php');
require_once(get_template_directory().'/inc/imgcfg.php');
require_once(get_template_directory().'/inc/post.php');
require_once(get_template_directory().'/inc/ua.php');
require_once(get_template_directory().'/inc/widgets.php');
require_once(get_template_directory().'/inc/smtp.php');
require_once(get_template_directory().'/inc/logincfg.php');
require_once(get_template_directory().'/inc/avatars.php');

function add_prism() {
	wp_register_script(
		'prismjs',
		get_stylesheet_directory_uri() . '/static/js/prism.min.js'   
	);
	wp_register_style(
		'prismcss', 
		get_stylesheet_directory_uri() . '/static/css/prism.min.css' 
	);
	wp_enqueue_script('prismjs');
	wp_enqueue_style('prismcss');
}
add_action('wp_enqueue_scripts', 'add_prism');
