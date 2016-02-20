<?php
/**
Template Name: 通用页面
Description: chenjianhang.com主题模板 
*/
?>
<?php get_header(); ?>
<!---->
<div class="content">
	<div class="content-main">
    	<div class="main">
        	<div class="post">
				<?php while ( have_posts() ) : the_post(); ?>
                	<?php get_template_part('content', get_post_format()); ?>
                <?php endwhile;  ?> 
            </div>
          	<?php comments_template( '/comments.php' ); ?>
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