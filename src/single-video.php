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
} 
elseif (is_single () || is_page ()) 
{ 
    single_post_title (); 
	echo ' - 陈建杭个人博客';
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
		$keywords = $keywords . $tag->name . ",";
	}
	if ($keywords == "")
	{
		$keywords = "陈建杭的博客,陈建杭,建杭,博客,seo";
	}
}
?>
<meta name="keywords" content="<?=trim($keywords)?>" />
<meta name="description" content="<?=trim($description)?>" />
<meta name="robots" content="nofollow" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!--
添加订阅feed链接，在header.php页面 <head> 标签中添加：
-->
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有文章" href="<?php echo get_bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有评论" href="<?php bloginfo('comments_rss2_url'); ?>" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style/common.css" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style/single.css" />
<link href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<style>

</style>
</head>

<body>
<div class="wrap">
<!---->
<?php get_header(); ?>
<!---->
<div class="content">
	<div class="content-main">
    	<div class="main">
        	<div>视频</div>
        	<div class="post">
				<?php while ( have_posts() ) : the_post(); ?><!—- 读取文章 —->
                <p class="post-title"><?php the_title(); ?></p>
                <div class="post-info">
                    <span class="post-author"><i class="fa fa-user"></i><?php the_author(); ?></span>
                    <span class="post-time"><i class="fa fa-clock-o"></i><?php the_time(__('Y年n月j日', 'yotheme')); ?></span>
                    <span class="post-tags"><i class="fa fa-tags"></i><?php the_tags('', '', ''); ?></span>
                </div>
                <br/>
                <div class="post-content"><?php the_content(); ?></div>
                
                <br/>
                <p>除非注明，文章均为原创。</p>
                <p>转载请注明出处：<?php echo "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]; ?>（陈建杭个人博客）</p>
                <?php get_template_part( 'content', get_post_format() ); ?> 
                <div class="post-like">
    <a href="javascript:;" data-action="ding" data-id="<?php the_ID(); ?>" class="specsZan <?php if(isset($_COOKIE['specs_zan_'.$post->ID])) echo 'done';?>">喜欢 <span class="count">
        <?php if( get_post_meta($post->ID,'specs_zan',true) ){
            		echo get_post_meta($post->ID,'specs_zan',true);
                } else {
					echo '0';
				}?></span>
    </a>
</div>
                
                
                <?php endwhile; // 循环结束 ?>
                
            </div>
            
        	
        
			<div>
				<?php if (get_previous_post()) : ?>
                    <div class="last-post">上一篇：<?php previous_post_link('%link') ?></div>
                <?php else: ?>
                <!--没有上一篇了-->
                <?php endif; ?>
                <?php next_post_link('<div class="next-post">下一篇：%link</div>') ?>
           	</div>
            <!-- 相关文章 -->
            <div class="clear"></div>
            <h3 class="big-title">相关文章</h3>
            <ul class="tags_related">
			<?php
            global $post;
            $post_tags = wp_get_post_tags($post->ID);
            if ($post_tags) {
              foreach ($post_tags as $tag) {
                // 获取标签列表
                $tag_list[] .= $tag->term_id;
              }
            
              // 随机获取标签列表中的一个标签
              $post_tag = $tag_list[ mt_rand(0, count($tag_list) - 1) ];
            
              // 该方法使用 query_posts() 函数来调用相关文章，以下是参数列表
              $args = array(
                    'tag__in' => array($post_tag),
                    'category__not_in' => array(NULL),  // 不包括的分类ID
                    'post__not_in' => array($post->ID),
                    'showposts' => 6,                           // 显示相关文章数量
                    'caller_get_posts' => 1
                );
              query_posts($args);
            
              if (have_posts()) {
                while (have_posts()) {
                  the_post(); update_post_caches($posts); ?>
                <li><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
            <?php
                }
              }
              else {
                echo '<li>* 暂无相关文章</li>';
              }
              wp_reset_query(); 
            }
            else {
              echo '<li>* 暂无相关文章</li>';
            }
            ?>
            </ul>
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
<script src="http://www.chenjianhang.com/resource/js/jquery-1.8.2.min.js"></script>
<script>
$.fn.postLike = function() {
	if ($(this).hasClass('done')) {
		alert('您已赞过该文章');
		return false;
	} else {
		$(this).addClass('done');
		var id = $(this).data("id"),
		action = $(this).data('action'),
		rateHolder = $(this).children('.count');
		var ajax_data = {
			action: "specs_zan",
			um_id: id,
			um_action: action
		};
		$.post("/wp-admin/admin-ajax.php", ajax_data,
		function(data) {
			$(rateHolder).html(data);
		});
		return false;
	}
};
$(document).on("click", ".specsZan",
	function() {
		$(this).postLike();
});

</script>
</body>
</html>