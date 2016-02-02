<?php 
/*
 * 文章列表（作品展示）
 */
?>
<!-- 文章内容开始 -->
<ul class="post-list2">
	<?php 
	global $query_string; 
	query_posts($query_string . '&ignore_sticky_posts=0'); // 不起作用
	?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php if (!is_home() || is_home() && !is_sticky()) : ?>
    	<?php
		$imageUrl = getImageByPost($post);
		$loadingImage = get_lazyload_image();
		?>
    	<li class="post-item">
        	<a href="<?php the_permalink(); ?>">
            	<div class="post-image-box">
                	<?php 
					if (get_option('close_lazy')) {
					?>
                    	<img class="post-image" src="<?php echo $imageUrl; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
                    <?php 
					} else {?>
                    	<img class="post-image" src="<?php echo $loadingImage; ?>" data-original="<?php echo $imageUrl; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
                    <?php 
					}
					?>
                    
                    <div class="post-mask"></div>
                    <div class="post-content"><p><?php the_excerpt(); ?></p></div>   
                </div>
            </a>
            <div><a class="post-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a> </div>
            <div class="post-info">
                <span class="post-time"><?php the_time('Y-m-d') ?></span>
                <span class="post-view"><i class="fa fa-eye"></i><?php get_post_views($post -> ID); ?></span>    
            </div>   
    	</li>
    <?php endif; ?>
    <?php endwhile; ?>
    <?php else : ?>
        找不到文章
    <?php endif; ?>
    
</ul>
<div class="clearfix"></div>
<!-- 文章内容结束 -->