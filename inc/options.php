<?php
// 加载小C主题设置文件
add_action('admin_head', 'c_admin_head');

function c_admin_head() {
	require_once(get_template_directory() . '/inc/option.php' );
}

// 启用主题后自动跳转到设置页面
global $pagenow;
if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php') {
	wp_redirect(admin_url('admin.php?page=c_settings'));
	exit;
}

// 添加小C主题设置菜单，注意add_menu_page和add_submenu_page的写法
function c_admin_menu() {
	add_menu_page('小C主题设置', '小C主题设置', 'administrator', 'c_settings', 'BaseSettings', '', 59); // 主题后面的数字，有时会与插件冲突，如100时与WP-PostRatings冲突，造成插件菜单无法显示
	add_submenu_page('c_settings', '基本设置', '基本设置', 'administrator', 'base-settings', 'BaseSettings');
	add_submenu_page('c_settings', '界面设置', '界面设置', 'administrator', 'view-setting', 'viewSetting');
	add_submenu_page('c_settings', 'SEO设置', 'SEO设置', 'administrator', 'seo-setting', 'seoSetting');
	add_submenu_page('c_settings', '高级设置', '高级设置', 'administrator', 'advanced-settings', 'AdvancedSettings');
}

add_action('admin_menu', 'c_admin_menu');
?>