<?php
/**
 * 主题拖拽功能相关的函数
 */

/** 使主题支持小工具 */
if (function_exists('register_sidebar')) {
	register_sidebar(array(
		'name'          => '全站侧栏',
		'id'            => 'widget_sitesidebar',
		'before_widget' => '<div class="side-item %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="side-item-title">',
		'after_title'   => '</div>'
	));
	register_sidebar(array(
		'name'          => '首页侧栏',
		'id'            => 'widget_sidebar',
		'before_widget' => '<div class="side-item %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="side-item-title">',
		'after_title'   => '</div>'
	));
	register_sidebar(array(
		'name'          => '分类/标签/搜索页侧栏',
		'id'            => 'widget_othersidebar',
		'before_widget' => '<div class="side-item %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="side-item-title">',
		'after_title'   => '</div>'
	));
	register_sidebar(array(
		'name'          => '文章页侧栏',
		'id'            => 'widget_postsidebar',
		'before_widget' => '<div class="side-item %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="side-item-title">',
		'after_title'   => '</div>'
	));
	register_sidebar(array(
		'name'          => '页面侧栏',
		'id'            => 'widget_pagesidebar',
		'before_widget' => '<div class="side-item %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="side-item-title">',
		'after_title'   => '</div>'
	));
	register_sidebar(array(
		'name'          => '正文底部小工具',
		'id'            => 'widget_post_bottom',
		'before_widget' => '<div class="side-item %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="side-item-title">',
		'after_title'   => '</div>'
	));
	register_sidebar(array(
		'name'          => '正文跟随滚动',
		'id'            => 'widget_post_fixed',
		'before_widget' => '<div class="side-item %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="side-item-title">',
		'after_title'   => '</div>'
	));
	register_sidebar(array(
		'name'          => '首页、分类、文档跟随滚动',
		'id'            => 'widget_fixed',
		'before_widget' => '<div class="side-item %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="side-item-title">',
		'after_title'   => '</div>'
	));
}


?>