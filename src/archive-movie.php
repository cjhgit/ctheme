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
<?php
if (is_home() || is_archive() || is_tag() ) { //判断页面属性主页、栏目页、标签页等
	$description = "欢迎访问陈建杭的个人博客，这里有个人分享给大家的技术，开发过程中的所思所想，欢迎大家一起交流。站长：陈建杭";
	$keywords = "陈建杭的博客,陈建杭,建杭,博客,seo";
}
else if (is_single()) // 判断是否为内容页
{
	if ($post->post_excerpt) {
		$description = $post->post_excerpt;
	} else {
		$description = substr(strip_tags($post->post_content), 0, 220); //截取文章的前220字节作为描述
	}
	$keywords = "";
	$tags = wp_get_post_tags($post->ID);
	foreach ($tags as $tag ) {
		$keywords = $keywords . $tag->name . ", ";
	}
	if ($keywords == "")
	{
		$keywords = "陈建杭的博客,陈建杭,建杭,博客,seo";
	}
}
?>
<meta name="keywords" content="<?=trim($keywords)?>" />
<meta name="description" content="<?=trim($description)?>" />
<!--
添加订阅feed链接，在header.php页面 <head> 标签中添加：
-->
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有文章" href="<?php echo get_bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有评论" href="<?php bloginfo('comments_rss2_url'); ?>" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style/common.css" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style/index.css" />
</head>

<body>
<div class="wrap">
<!---->
<?php get_header(); ?>
<!---->
<div class="content">
	<div class="content-main">
    	<div class="main">
        	<h2>archieve</h2>
           

        	<ul class="post-list">
            	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <li class="post-item">
                	
                	<a class="post-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <div>
                    	<!-- 文章图片开始 -->
                    	<?php if( get_post_meta($post->ID, ‘thumbnail’, true) ) : ?>  
							<?php $image= get_post_meta($post->ID, ‘thumbnail’, true); ?>  
                            <img class="post-image" src="<?php echo $image; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
                        <?php else: ?>  
                            <img class="post-image" src="<?php bloginfo('template_url'); ?>/images/post-default.jpg" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
                        <?php endif; ?>
                        <!-- 文章图片结束 -->  
                        <div><span class="post-time"><?php the_time('y年m月d日') ?></span><span class="post-comment"><?php comments_popup_link('没有评论', '1 条评论', '% 条评论', '', '评论已关闭'); ?></span><?php the_tags('标签：', ', ', ''); ?>| <?php 
			if (!comments_open()) {
				_e( 'Comments are closed.', 'yotheme');
			} else {
				comments_popup_link(__('Leave a comment', 'yotheme'), __('1 Comment', 'yotheme'), __('% Comments', 'yotheme'));
			}
			?><?php edit_post_link('编辑', ' &bull; ', ''); ?></div>
                        <p class="post-content"><?php the_excerpt(); ?></p>
                    </div>
                    
                </li>
            	
                <?php endwhile; ?>
				<?php else : ?>
                    找不到文章
                <?php endif; ?>
                
            </ul>
            <div class="page">
           		<?php wp_pagenavi(); ?>
            </div>
           
        </div>
        <?php get_sidebar(); ?>
    	
    </div>

</div>
<div class="clear"></div>
<!---->
<?php get_footer(); ?>
<!---->
</div>
<div class="dandelion">
    <span class="smalldan"></span>
    <span class="bigdan"></span>
</div>
<script src="http://www.chenjianhang.com/resource/js/jquery-1.8.2.min.js"></script>
<script src="http://www.chenjianhang.com/resource/js/navfix.js"></script>
<script>
$(document).ready(function(e) {
	//$('#nav').navfix(0,999);    
});
</script>
</body>
</html>