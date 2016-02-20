<?php
/**
Template Name: 日志页面
Description: chenjianhang.com主题模板
*/
?>

<?php get_header(); ?>
<!---->
<div class="content">
	<div class="content-main">
    	<div class="main">
        	
            <div class="info">
                <?php echo do_shortcode("[spiderlogs]"); ?>
            </div>
           
        </div>
    	 <?php get_sidebar(); ?>
        
    </div>

</div>
<!---->
<?php get_footer(); ?>