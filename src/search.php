<?php
/**
 * 搜索页
 */
?>
<?php get_header(); ?>
<!-- 主体内容开始 -->
<div class="content">
	<div class="content-main">
    	<div class="main">
        	<?php get_template_part('post', ''); ?>
            <div class="page">
           		<?php wp_pagenavi(); ?>
            </div>
           
        </div>
    	<?php get_sidebar(); ?>
        
    </div>

</div>
<!-- 主题内容结束 -->
<?php get_footer(); ?>