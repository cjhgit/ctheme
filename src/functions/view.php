<?php
/**
 * 主题界面相关的函数，如头部样式、导航栏，侧栏
 */
//============头部================
// 使主题支持自定义背景
add_theme_support('custom-background');	
	
// 使主题支持自定义头部
/*
if (function_exists('add_custom_image_header')) {
	add_custom_image_header('header_style', 'admin_header_style');
}
*/
// 自定义头部
define('HEADER_IMAGE', '%s/images/head_bg.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 930);
define('HEADER_IMAGE_HEIGHT', 200);
define('NO_HEADER_TEXT', true );
define('HEADER_TEXTCOLOR', '');

// 使主题支持导航菜单
if (function_exists('register_nav_menus')) {
	register_nav_menus( array(
		'primary' => '主菜单',
		'page_menu' => '页面导航',
		'header_menu' => '顶部菜单',
		'footer_menu' => '底部菜单',
	));
}

//============导航栏================
//============侧栏================
/* 彩色标签 */
function colorCloud($text) {
	$text = preg_replace_callback('|<a (.+?)>|i','colorCloudCallback', $text);
	return $text;
}
function colorCloudCallback($matches) {
	$text = $matches[1];
	$color = dechex(rand(0,16777215));
	$pattern = '/style=(\'|\”)(.*)(\'|\”)/i';
	$text = preg_replace($pattern, "style=\"color:#{$color};$2;\"", $text);
	return "<a $text>";
}
add_filter('wp_tag_cloud', 'colorCloud', 1);

/* 标签样式 */
add_filter('widget_tag_cloud_args', 'theme_tag_cloud_args');

function theme_tag_cloud_args($args) {
	$newargs = array(
		'smallest'    => 14,  // 最小字号
		'largest'     => 14, // 最大字号
		'unit'        => 'pt', // 字号单位，可以是pt、px、em或%
		'number'      => 45,     // 显示个数
		'format'      => 'flat',// 列表格式，可以是flat、list或array
		'separator'   => "\n",   // 分隔每一项的分隔符
		'orderby'     => 'name',// 排序字段，可以是name或count
		'order'       => 'ASC', // 升序或降序，ASC或DESC
		'exclude'     => null,   // 结果中排除某些标签
		'include'     => null,  // 结果中只包含这些标签
		'link'        => 'view', // taxonomy链接，view或edit
		'taxonomy'    => 'post_tag', // 调用哪些分类法作为标签云
	);
	$return = array_merge($args, $newargs);
	return $return;
}
?>