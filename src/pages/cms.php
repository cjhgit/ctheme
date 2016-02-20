<?php
/**
 * CMS页面
 */
?>
<?php get_header(); ?>
<div class="content">
	<div class="content-main">
    	<?php 
		$args = array('post_type' => 'notice', 'posts_per_page' => 5); 
		$loop = new WP_Query($args);
    	if ($loop->have_posts()) {
		?>
        <?php if (get_option('show_notice')) { ?>
        <!-- 公告开始 -->
    	<div class="notice">
        	<i class="fa fa-volume-up"></i>
            <div id="notice" class="notice-list">
            	<ul>
				<?php
                while ($loop->have_posts()) { 
					$loop->the_post();
                	echo '<li>' . get_the_content() . '</li>';
				}
				?>
            	</ul>
            </div>
        </div>
        <!-- 公告结束 -->
        <?php } ?>
        <?php } ?>
    	<div class="main">
        	<?php 
			if (!get_option('close_slide') && (!$paged || $paged && $paged == 1)) {
				include 'banner.php';
			} 
			?>

            <?php 
			// 已经遍历过文章了，重置一下，才能再次遍历
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args = array(
				'caller_get_posts' => 1,
				'paged' => $paged
			);
			query_posts($args);
			?>

        	<?php get_template_part('post'); ?>
            <div class="page">
           		<?php wp_pagenavi(); ?>
            </div>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>