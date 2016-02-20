<?php
/*
 Template Name: 读者墙页面
 Description: chenjianhang.com主题模板
*/

function readers_wall( $outer='1',$timer='100',$limit='60' ){
	global $wpdb;
	$counts = $wpdb->get_results("select count(comment_author) as cnt, comment_author, comment_author_url, comment_author_email from (select * from $wpdb->comments left outer join $wpdb->posts on ($wpdb->posts.id=$wpdb->comments.comment_post_id) where comment_date > date_sub( now(), interval $timer month ) and user_id='0' and comment_author != '".$outer."' and post_password='' and comment_approved='1' and comment_type='') as tempcmt group by comment_author order by cnt desc limit $limit");
	foreach ($counts as $count) {
		$c_url = $count->comment_author_url;
		if (!$c_url) $c_url = 'javascript:;';
		$type .= '<a id="duzhe" target="_blank" href="'. $c_url . '" title="['.$count->comment_author.']近期评论'. $count->cnt . '次">'.get_avatar( $count->comment_author_email, $size = '64' , deel_avatar_default() ).'<span>'.$count->comment_author.'</span></a>';
	}
	echo $type;
};

?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/tags.css" />
<!-- 主体内容开始 -->
<div class="content">
	<div class="content-main">
    	<div class="main">
        	<div class="tag">
                <p class="tag-name"><?php the_title(); ?></p>
                <ul class="tags">
                	<?php readers_wall(); ?>
                </ul>
            </div>
        </div>   
        <?php get_sidebar(); ?>
    </div>
</div>
<!-- 主体内容结束 -->
<?php get_footer(); ?>