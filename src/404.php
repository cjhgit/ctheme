<?php
/**
 * 404错误页面模板
 */
?>
<?php get_header(); ?>
<!-- 主要内容开始 -->
<div class="content">
	<div class="content-main">
    	<div class="main">
        	<div class="error404">
            	<p class="state-code">404</p>
        		<p class="tip-text">您的页面找不到了</p>
            	<ul class="recommend">
                	<h3>文章推荐</h3>
					<?php 
                    $post_num = 10; // 设置调用条数 
                    $args = array( 
						'post_password' => '', 
						'post_status' => 'publish', // 只选公开的文章. 
						//'post__not_in' => array($post->ID),//排除当前文章 
						'caller_get_posts' => 1, // 排除置顶文章. 
						'orderby' => 'comment_count', // 依评论数排序. 
						'posts_per_page' => 8 // 显示8条 
                    ); 
                    $query_posts = new WP_Query(); 
                    $query_posts->query($args); 
                    while ($query_posts->have_posts()) { 
						$query_posts->the_post(); 
						$image = getImageByPost($post);
						?>
                        <li class="post"> 
                            <img class="post-image" src="<?php echo $image; ?>" alt="一套完整的安卓开发推荐方案" title="一套完整的安卓开发推荐方案"/> 
                            <a class="post-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </li>
                    <?php } wp_reset_query();?> 
                    
                </ul> 
        	</div>
        </div>
    	<?php get_sidebar(); ?> 
    </div>
</div>
<!-- 主要内容结束 -->
<?php get_footer(); ?>