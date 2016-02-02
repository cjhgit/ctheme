<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php
if (is_home ()) { // is_home() 当前页面为主页时返回true
    bloginfo ( 'name' ); // 返回站点标题
    echo " - ";
    bloginfo ( 'description' ); // 返回站点副标题，站点描述
} elseif (is_category ()) { // is_category() 当前页面为分类页时返回true
    single_cat_title ();
    echo " - ";
    bloginfo ( 'name' );
} elseif (is_single () || is_page ()) { // is_single() 当前页面为单文章页时返回true 。 is_page() 当前页面为单页面时返回true
    single_post_title ();
} elseif (is_search ()) { // is_search() 当前页面为搜索页时返回true
    echo "搜索结果";
    echo " - ";
    bloginfo ( 'name' );
} elseif (is_404 ()) { // is_404() 当前页面为404页时返回true
    echo '页面未找到!';
} else {
    wp_title ( '', true );
}
?></title>
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
        	<div>21212121212121111111</div>
        	<div class="post">
				<?php while ( have_posts() ) : the_post(); ?><!—- 读取文章 —->
                <p class="post-title"><?php the_title(); ?></p>
                <div class="post-info">
                    <span class="post-author"><?php the_author(); ?></span><span class="post-time"><?php the_time(__('Y年n月j日', 'yotheme')); ?></span>
                </div>
                <div class="post-content"><?php the_content(); ?></div>
                <?php endwhile; // 循环结束 ?>
            </div>
            
        	<h2>相关页面</h2>
<?php if(function_exists(' wpdx_related_pages')) wpdx_related_pages(); ?>
        
			<div>
				<?php if (get_previous_post()) : ?>
                    <div class="last-post">上一篇：<?php previous_post_link('%link') ?></div>
                <?php else: ?>
                <!--没有上一篇了-->
                <?php endif; ?>
                <?php next_post_link('<div class="next-post">下一篇：%link</div>') ?>
           	</div>
            <div class="clear"></div>

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