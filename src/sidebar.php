<?php
/**
 * 侧栏模板
 */
?>
<div id="sidebar" class="side">
	<?php 
	if (function_exists('dynamic_sidebar')) {
		dynamic_sidebar('widget_sitesidebar');
		
		if (is_single()) {
			dynamic_sidebar('widget_postsidebar'); 
		} elseif (is_page()) {
			dynamic_sidebar('widget_pagesidebar'); 
		} elseif (is_home()) {
			dynamic_sidebar('widget_sidebar'); 
		} else {
			dynamic_sidebar('widget_othersidebar');
		}
	}
    ?>
</div>
<script>
$('#loading div').animate({'width':'60%'}, 50);  // 第三个节点
</script>