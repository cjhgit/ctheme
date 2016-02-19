<?php
/**
 * 网页头部模板
 */
?>
<!doctype html>

<html <?php language_attributes(); ?>>
<head>
<meta name="baidu-site-verification" content="MvIUbl5H4b">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="keywords" content="<?php echo get_keywords(); ?>">
<meta name="description" content="<?php echo get_description(); ?>">
<?php if (is_single()) { ?>
<meta name="robots" content="nofollow">
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo_title(); ?></title>
<?php 
$shortcutIcon = get_option('web_shortcut_icon');
if (!empty($shortcutIcon)) { ?>
<!-- 网站图标 -->
<link rel="shortcut icon" href="<?php echo $shortcutIcon; ?>">
<?php } ?>
<?php 
$webIcon = get_option('web_icon');
if (!empty($webIcon)) { ?>
<!-- 网站图标 -->
<link rel="icon" href="<?php echo $webIcon; ?>">
<?php } ?>

<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有文章" href="<?php echo get_bloginfo('rss2_url'); ?>">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有评论" href="<?php bloginfo('comments_rss2_url'); ?>">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/common.css">
<?php if (is_home() || is_category () || is_archive() || is_search()) { ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/index.css">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/post.css">
<?php } elseif (is_single() || is_page()) { ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/single.css">
<?php } elseif (is_404()) { ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/404.css">
<?php } ?>
<!--[if lt IE 9]><script src="<?php echo get_template_directory_uri(); ?>/js/html5-css3.js"></script><![endif]-->
<!--[if lt IE 8]><link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ie7/ie7.css" /><![endif]-->
<!--[if lt IE 7]><script src="<?php echo get_template_directory_uri(); ?>/js/ie6.js" type="text/javascript"></script><![endif]-->
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/highslide/highslide.css">
<!--

<script src='http://www.chenjianhang.com/wp-includes/js/jquery/jquery.js?ver=1.11.2'></script>
<script src='http://www.chenjianhang.com/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
-->
<script src="<?php bloginfo('template_url'); ?>/js/jquery-2.0.3.min.js"></script>


<script>
$('#loading div').animate({'width':'20%'}, 50);  // 第一个节点
</script>
<style>


/* 主题配色方案 */
<?php
$themes = array(
    // 默认主题
    array(
        'themeColor' => '#6c6969',
        'navBgColor' => '#6c6969',
        'aColor' => '#73bef0', // 超链接的颜色
		'bgColor' => '#eee',
    ),
	// 蓝色经典
	array(
        'themeColor' => '#32a5e7',
        'navBgColor' => '#32a5e7',
        'aColor' => '#32a5e7',
		'bgColor' => '#eee',
    ),
	// 绿色生机
	array(
        'themeColor' => '#29cf71',
        'navBgColor' => '#29cf71',
        'aColor' => '#29cf71',
		'bgColor' => '#eee',
    ),
	// 紫色生机
	array(
        'themeColor' => '#a75eca',
        'navBgColor' => '#a75eca',
        'aColor' => '#a75eca',
		'bgColor' => '#eee',
    ),
	// 灰色稳重
	array(
        'themeColor' => '#606060',
        'navBgColor'    => '#606060',
        'aColor'  => '#606060',
		'bgColor'  => '#eee',
    ),
	// 红色喜庆
	array(
        'themeColor' => '#e74b3c',
        'navBgColor' => '#e74b3c',
        'aColor' => '#e74b3c',
		'bgColor' => '#eee',
    ),
	// 粉红回忆
	array(
        'themeColor' => '#ffa977',
        'navBgColor' => '#ffa977',
        'aColor' => '#ffa977',
		'bgColor' => '#eee',
		'footerBgColor' => '#ffa977',
    ),
	// 碧蓝色
	array(
        'themeColor' => '#1bb798',
        'navBgColor' => '#1bb798',
        'aColor' => '#1bb798',
		'bgColor' => '#eee',
    ),
	// 黄色
	array(
        'themeColor' => '#f4e439',
        'navBgColor' => '#f4e439',
        'aColor' => '#f4e439',
		'bgColor' => '#eee',
    ),
	// 橙色
	array(
        'themeColor' => '#f90',
        'navBgColor' => '#f90',
        'aColor' => '#fbb346',
		'bgColor' => '#eee',
    ),
	// 文艺-棕色
	array(
        'themeColor' => '#d0ab65',
		'headerHeight' => '250',
        'navBgColor' => '#d0ab65',
		'headerTextColor' => '#c19646',
        'aColor' => '#d0ab65',
		'bgColor' => '#eee',
		'bgUrl' => get_bloginfo('template_url') . '/images/themes/body_bg.jpg',
		'headerImage' => get_bloginfo('template_url') . '/images/themes/head_bg.jpg',
    ),
	// 小清新-天蓝色
	array(
        'themeColor' => '#7ac6dd',
		'headerHeight' => '250',
        'navBgColor' => '#7ac6dd',
		'headerTextColor' => '#55b9e3',
        'aColor' => '#a2dcf0',
		'bgColor' => '#eaf7fd',
		'headerImage' => get_bloginfo('template_url') . '/images/themes/head_bg2.jpg',
		'footerBgColor' => '#7ac6dd',
    ),
	// 喵星人-黑白
	array(
        'themeColor' => '#333',
		'headerHeight' => '333',
        'navBgColor' => '#333',
        'aColor' => '#a2dcf0',
		'bgColor' => '#eaf7fd',
		'headerImage' => get_bloginfo('template_url') . '/images/themes/head_bg2.jpg',
		'footerBgColor' => '#333',
    ),
);

// 读取主题数据
$theme = intval(get_option('themes'));

$themeColor = $themes[$theme]['themeColor'];


$themeColor2 = $themes[$theme]['themeColor2'];
if (empty($themeColor2)) {
	$themeColor2  = '#6c6969';
}
$footerBgColor = $themeColor2;

$navBgColor = $themes[$theme]['navBgColor'];
$aColor = $themes[$theme]['aColor'];
// get_background_color();
$bgColor = $themes[$theme]['bgColor'];
$bgUrl = $themes[$theme]['bgUrl'];

if (!$headerImage && $themes[$theme]['headerImage']) {
	$headerImage = $themes[$theme]['headerImage'];
}

if (array_key_exists('headerHeight', $themes[$theme])) {
	$headerHeight = $themes[$theme]['headerHeight'];
} else {
	$headerHeight = '100';
}

if (array_key_exists('headerTextColor', $themes[$theme])) {
	$headerTextColor = $themes[$theme]['headerTextColor'];
} else {
	$headerTextColor = '#fff';
}

if (array_key_exists('footerBgColor', $themes[$theme])) {
	$footerBgColor = $themes[$theme]['footerBgColor'];
}

// 读取用户特殊设置
$tc = get_option('theme_color');
if (!empty($tc)) {
	$themeColor = $tc;
	$navBgColor = $tc;
	$aColor = $tc;
	$footerBgColor = $tc;
}

$tc2 = get_option('theme_color2');
if (!empty($tc2)) {
	$themeColor2 = $tc2;
}

$htc = get_option('header_text_color');
if (!empty($htc)) {
	$headerTextColor = $htc;
}

$hh = get_option('header_height');
if (!empty($hh)) {
	$headerHeight = $hh;
}

$hi = get_option('header_image');
if (!empty($hi)) {
	$headerImage = $hi;
}

$nbc = get_option('nav_bg_color');
if (!empty($nbc)) {
	$navBgColor = $nbc;
}

$ac = get_option('theme_a_color');
if (!empty($ac)) {
	$aColor = $ac;
}

$bc = get_option('bg_color');
if (!empty($bc)) {
	$bgColor = $bc;
}

$bu = get_option('bg_image');
if (!empty($bu)) {
	$bgUrl = $bu;
}

$fbc = get_option('footer_bg_color');
if (!empty($fbc)) {
	$footerBgColor = $fbc;
}

$mw = get_option('max_width');
if (!empty($mw)) {
	$maxWidth = $mw;
} else {
	$maxWidth = 1250;
}
?>
.theme-color {
	color: <?php echo $themeColor; ?>;
}
.theme-color-bg {
	background: <?php echo $themeColor; ?>;
}
.theme-color2-bg {
	background: <?php echo $themeColor2; ?>;
}
.theme-body {
	background: <?php echo $bgColor; ?> url(<?php echo $bgUrl; ?>);
}
.theme-header {
	height: <?php echo $headerHeight ?>px;
	color: <?php echo $headerTextColor; ?>;
	background: <?php echo $themeColor; ?> url(<?php echo $headerImage; ?>);
	background-attachment: fixed;
	background-size: 100% 100%;
}
.theme-nav {
	background: <?php echo $navBgColor; ?>;
}
.theme-footer {
	background: <?php echo $footerBgColor; ?>;
}
a {
	color: <?php echo $aColor; ?>;
	text-decoration: none;
}
a:hover {
	color: #777;
}
.sub-menu .menu-item a {
	background: <?php echo $themeColor2; ?>;
	filter:alpha(opacity=95); 
	opacity: 0.95;  
	-moz-opacity:0.95;  
	-khtml-opacity: 0.95;  
}
.sub-menu .menu-item a:hover {
	color: #fff;
	background: <?php echo $themeColor; ?>;
	filter:alpha(opacity=100); 
	opacity: 1;  
	-moz-opacity: 1;  
	-khtml-opacity: 1; 
}
.theme-post-content h2 {
	color: <?php echo $themeColor; ?>;
}
.theme-post-content h3 {
	color: <?php echo $themeColor; ?>;
}
@media only screen and (max-width: 800px) {
.sub-menu .menu-item a {
	background: none;
}
}
@media only screen and (max-width: 400px) {
.theme-header {
	color: #fff;
	background-image: none;
	height: 100px;
}
.theme-header a {
	color: #fff;
}
}
.content-main {
	width: 100%;
	max-width: <?php echo $maxWidth; ?>px;
}

</style>

<!-- wp_head开始，到wp_head结束里面的内容是插件生成的 -->

<?php wp_head(); ?>
<!-- wp_head结束 -->

</head>

<body class="theme-body">
<div class="wrap">
<!-- 头部开始 -->
<header class="header theme-header">
	<div id="loading"><div></div></div>
    
    <?php if (current_user_can('level_10')) { ?>
 		<div class="admin"><a href="<?php bloginfo('url'); ?>/wp-admin">管理</a></div>
	<?php } ?>
    <?php if (current_user_can('level_10')) { 
if(function_exists('performance')) performance(true) ;
} ?>
	<div class="header-box">
        <a id="menu-btn" class="menu-button" href="javascript:void(0)"><i class="fa fa-list"></i></a>
        <div class="blog-info">
            <a href="<?php bloginfo('url'); ?>"><span class="blog-name"><?php bloginfo('name'); ?></span></a>
            <span class="blog-descption type"><?php bloginfo('description'); ?></span>
        </div>
    </div>
</header>
<!-- 头部结束 -->
<!-- 导航菜单开始 -->
<nav id="nav-header" class="navbar theme-nav">
	<div id="mask" class="mask"></div>
    <div class="navbar-box">
		<?php
        if (function_exists('wp_nav_menu')) {
            wp_nav_menu(array('theme_location'=>'primary', 'menu_id'=>'nav', 'container'=>'ul'));
        }
        ?>
    </div>
</nav>
<!-- 导航菜单结束-->