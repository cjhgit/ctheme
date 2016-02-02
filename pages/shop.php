<?php
/*
Template Name: 商城
*/
?>
<!doctype html>
<html>
<head>
<meta name="baidu-site-verification" content="MvIUbl5H4b" />
<meta charset="utf-8">
<title><?php
if (is_home ()) { // is_home() 当前页面为主页时返回true
    bloginfo ( 'name' ); // 返回站点标题
    echo " - 专注IT分享";
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
<meta name="keywords" content="陈建杭,建杭,陈建杭个人主页,陈建杭的博客" />
<meta name="description" content="欢迎访问陈建杭的个人主页，这里有我分享给大家的技术以及开发过程中的所思所想，欢迎大家一起交流。欢迎收藏陈建杭的博客" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!--
添加订阅feed链接，在header.php页面 <head> 标签中添加：
-->
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有文章" href="<?php echo get_bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有评论" href="<?php bloginfo('comments_rss2_url'); ?>" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style/common.css" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style/index_product.css" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css" />
<link href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body background="#<?php background_color(); ?>">
<div class="wrap">
<?php get_header(); ?>
<!---->
<div class="content">
	<div class="content-main">
    	<div class="main">
        	<!--
        	<div class="banner">
            	<img src="<?php bloginfo('template_url'); ?>/images/banner1.jpg" alt="banner" />
            </div>
            -->
        	<ul class="product-list">
            	<?php $args = array( 'post_type' => 'product', 'posts_per_page' => 10 

); 
$loop = new WP_Query( $args );?>
            	<?php if ($loop->have_posts()) : while ( $loop->have_posts() )  : $loop->the_post(); ?>
                <li class="product-item">
                	<?php if (has_post_thumbnail()) : ?>
                        	<?php $image= wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium');
							$image = $image[0]; ?>  
                            <img class="product-image" src="<?php echo $image; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
                        <?php elseif (strlen(getFirstImage($post->ID)) > 0) : ?> 
                        	<?php $image= getFirstImage($post->ID);
							 ?>  
                            <img class="product-image" src="<?php echo $image; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
						<?php else: ?> 
                        	<img class="product-image" src="<?php bloginfo('template_url'); ?>/images/post-default.jpg" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
						<?php endif; ?>
                    	<a class="product-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        
                    <div>
                    
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

</div>
<div class="dandelion">
    <span class="smalldan"></span>
    <span class="bigdan"></span>
</div>
<!--
<script src="http://www.chenjianhang.com/resource/js/jquery-1.8.2.min.js"></script>
<script src="http://www.chenjianhang.com/resource/js/navfix.js"></script>
<script>
$(document).ready(function(e) {
	//$('#nav').navfix(0, 999);    
});
</script>
-->
<script>
var isShow = false;
function showMenu() {
	if (isShow)
	{
		document.getElementById("menu").style.display = "none";
	}
	else
	{
		document.getElementById("menu").style.display = "block";
	}
	isShow = !isShow;
}
</script>
</body>
</html>