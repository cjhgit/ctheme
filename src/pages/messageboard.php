<?php
/*
Template Name: 留言板页面
Description: chenjianhang.com主题模板
*/
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>留言板 - 陈建杭个人主页</title>
<meta name="keywords" content="陈建杭的博客,陈建杭,建杭" />
<meta name="description" content="欢迎大家给我留言" />
<!--
添加订阅feed链接，在header.php页面 <head> 标签中添加：
-->
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有文章" href="<?php echo get_bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有评论" href="<?php bloginfo('comments_rss2_url'); ?>" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style/common.css" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style/single.css" />
</head>

<body>
<div class="wrap">
<!---->
<?php get_header(); ?>
<!---->
<div class="content">
	<div class="content-main">
    	<div class="main">
        	<div>有什么想对我说的，在下面留言</div>
          	<?php comments_template( '/comments.php' ); ?>
        </div>
        <?php get_sidebar(); ?>
    </div>

</div>
<!---->
<?php get_footer(); ?>
<!---->
</div>
</body>
</html>