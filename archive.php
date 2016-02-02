<?php
/**
 * 文章归档模板
 * 该模板将会分别被category.php，author.php，date.php所覆盖（如果存在的话）
 */
?>
<?php get_header(); ?>
<!---->
<div class="content">
	<div class="content-main">
    	<div class="main">
        	<div class="archive-header"><span class="archive-name">归档：<?php 
				if(is_day()) echo the_time('Y年m月j日');
				elseif(is_month()) echo the_time('Y年m月');
				elseif(is_year()) echo the_time('Y年'); 
			?>的内容</span></div>
        	<?php get_template_part('post', ''); ?>
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