<?php
/*
Template Name: 无评论模板
Description: chenjianhang.com主题模板
*/
?>
<?php get_header(); ?>
<!-- 主体内容开始 -->
<div class="content">
	<div class="content-main">
    	<div class="main">
        	<div class="post">
				<?php while ( have_posts() ) : the_post(); ?>
                	<?php get_template_part('content', 'nocomment'); ?>
                <?php endwhile; ?>
            </div>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>
<!-- 主体内容结束 -->
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