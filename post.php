<?php 
/**
 * 文章列表模板 
 */
?>
<!-- 文章内容开始 -->
<ul class="post-list">
	<?php 
	global $query_string; 
	query_posts($query_string . '&ignore_sticky_posts=0'); // 不起作用
	?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<?php 
		// 如果开启了幻灯片，主页的置顶文章不显示
        if (!is_home() || get_option('close_slide') || !is_sticky()) : 
        ?>
    	<li class="post-item">
        	<div>
            <?php if (is_sticky()) : ?>
                <span class="top-tag">置顶</span>
            <?php endif; ?>
            <?php  
			if (!get_option('hide_category') && !is_category()) {
				$category = get_the_category();
		        if ($category[0] /*&& $category[0]->term_id != 1*/) { // 未分类不显示分类名
					echo '<a class="label" href="' . get_category_link($category[0]->term_id) . '">' . $category[0]->cat_name . '<i class="label-arrow"></i></a>';
				}
	        }
			
			if (get_option('link_new_window')) {
				$target = 'target="_blank"';	
			} else {
				$target = '';	
			}
			?>
            
            
            
            <a class="post-title" <?php echo $target; ?> href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php if (get_post_format() == "gallery") echo '（相册）'; ?>
            <?php 
$t1=$post->post_date;
$t2=date("Y-m-d H:i:s");
$diff=(strtotime($t2)-strtotime($t1))/3600;
if($diff<24){echo '<img src="' . get_bloginfo('template_url') . '/images/new.gif" alt="new">';} //这里就是显示的内容了
else{echo "";} //时间超过时候显示空白
?>
        	</div>
        	<div>
            <?php
			$cats = get_categories();
			$cate = get_the_category();
			//echo $cate[0]->cat_ID;
			//echo $cats[]0;
			//$imageUrl = getPostImage($post->ID);
			//$imageUrl = getImageByPost($post);
			$imageUrl = getImageByPost($post);
			$loadingImage = get_lazyload_image();
			?>
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
                
            </div>
            
        
            
            <!-- 文章图片结束 -->  
            <div class="post-content"><?php the_excerpt(); ?></div>
            <!-- 文章概述结束 -->
            <div class="post-info">
                <?php //the_tags('标签：', ', ', ''); ?>
                <?php 
				if (!get_option('hide_author')) {
				?>
                	<span class="post-info-item"><i class="fa fa-user"></i><?php the_author(); ?> </span>
                <?
				}
				?>
                
                <span class="post-info-item"><i class="fa fa-clock-o"></i><?php the_time(get_option('date_format' )) ?></span>
                <span class="post-info-item"><i class="fa fa-eye"></i><?php get_post_views($post -> ID); ?></span>
                <span class="post-info-item"><i class="fa fa-comments-o"></i><?php comments_popup_link('评论：0', '评论：1', '评论：0', '', '评论已关闭'); ?></span>
                <span class="post-info-item post-like"><i class="fa fa-heart-o"></i><?php if( get_post_meta($post->ID,'specs_zan',true) ){ echo get_post_meta($post->ID,'specs_zan',true); } else { echo '0'; }?></span>
                <span><?php //edit_post_link('编辑', ' &bull; ', ''); ?></span>
            </div>
        </div>
    	</li>
    <?php endif; ?>
    <?php endwhile; ?>
    <?php else : ?>
        找不到文章
    <?php endif; ?>
    
</ul>
<!-- 文章内容结束 -->