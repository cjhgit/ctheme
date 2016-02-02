<?php
/**
 * 普通文章内容页模板
 */
?>
<?php get_header(); ?>
<!-- 主体内容开始 -->
<div class="content">
	<div class="content-main">
    	<?php //获取当前文章IDecho get_the_ID(); ?>
    	<div class="main">
        	<!-- 面包屑导航开始 -->
        	<div class="crumb">
        		<a href="<?php echo get_bloginfo('url'); ?>">首页</a> &gt; <?php echo the_category(' &gt; ', 'multiple'); ?> &gt;  正文
        	</div>
            <!-- 面包屑导航结束 -->
        	<div class="post">
				<?php while ( have_posts() ) : the_post(); ?><!—- 读取文章 —->
                	<?php get_template_part('content', get_post_format()); ?>
                <?php endwhile; // 循环结束 ?>
            </div>
            <!-- 翻页开始 -->
			<div class="turn-page">
            	<div class="trun-prev">
                    <p class="trun-prev-icon">上一篇</p>
                    <?php
					$next_post = get_next_post();
					if (!empty( $next_post )): ?>
                    	<a class="prev-post" href="<?php echo get_permalink( $next_post->ID ); ?>" rel="prev"><?php echo $next_post->post_title; ?></a>
					<?php endif; ?>
                </div>
            	<div class="trun-next">
                	<p class="trun-next-icon">下一篇</p>
                    <?php
					$prev_post = get_previous_post();
					if (!empty( $prev_post )): ?>
                    	<a class="next-post" href="<?php echo get_permalink( $prev_post->ID ); ?>" rel="next"><?php echo $prev_post->post_title; ?></a>
					<?php endif; ?>

                    
                </div>
			</div>
            <!-- 翻页结束 -->
            <!-- 相关文章开始 -->
            <div class="clear"></div>
            <h3 class="big-title theme-color-bg">相关文章</h3>
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
<!-- 主体内容结束 -->
<?php get_footer(); ?>
