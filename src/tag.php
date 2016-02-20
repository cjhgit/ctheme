<?php
/**
 * 标签模板
 */
?>
<?php get_header(); ?>
<!-- 主体内容结束 -->
<div class="content">
	<div class="content-main">
    	<div class="main">
        	<div class="archive-header"><i class="fa fa-folder-open"></i><span class="archive-name">标签：<?php echo single_tag_title(); ?></span></div>
            <?php get_template_part('post', ''); ?>
            <div class="page">
           		<?php wp_pagenavi(); ?>
            </div>
        </div>
    	<?php get_sidebar(); ?>  
    </div>
</div>
<!-- 主体内容开始 -->
<?php get_footer(); ?>