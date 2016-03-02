<?php
/**
Template Name: CMS 页面
Description: chenjianhang.com主题模板 
*/
?>
<?php get_header(); ?>
<!---->
<div class="content">
	<div class="content-main">
    	<div class="main">
    		<?php
    		$strArrIds = explode(",", '11,29,59');
			$ids = array();

			for ($i = 0, $length = count($strArrIds); $i < $length; $i++) {
				$ids[$i] = intval($strArrIds[$i]);
				$imageUrl = getImageByPost($post);
				?>
				
				<ul class="cms">
					<div class="cms-header">
	            		<h1><?php echo get_cat_name($ids[$i]); ?></h1>
	            		<a class="sms-more" href="<?php echo get_category_link($ids[$i]); ?>">更多</a>
	            	</div>

		    		<?php
		        	$args = array(
						'cat' => $ids[$i],
						'showposts' => 4,
					);
					query_posts($args);
					while (have_posts()) {
						the_post();
						?>
						<li class="post"> 
		                    <img class="post-image" src="<?php echo $imageUrl; ?>" alt="<?php the_title(); ?>"> 
		                    <a class="post-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		                </li>
						<p></p>
						
						<?php 
					} ?> 
				</ul> 
			<? }
			?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>
<!---->
<?php get_footer(); ?>
<script>
$.fn.postLike = function() {
	if ($(this).hasClass('done')) {
		alert('您已赞过该文章');
		return false;
	} else {
		$(this).addClass('done');
		var id = $(this).data("id"),
		action = $(this).data('action'),
		rateHolder = $(this).children('.count');
		var ajax_data = {
			action: "specs_zan",
			um_id: id,
			um_action: action
		};
		$.post("/wp-admin/admin-ajax.php", ajax_data,
		function(data) {
			$(rateHolder).html(data);
		});
		return false;
	}
};
$(document).on("click", ".specsZan",
	function() {
		$(this).postLike();
});

</script>