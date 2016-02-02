<?php
/*
Template Name: 文章归档页面
Description: chenjianhang.com主题模板
*/
?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/archives.css" />
<!-- 主体内容开始 -->
<div class="content">
	<div class="content-main">
    	<div class="main">
        	<div class="archives">
                <p class="tag-name"><?php the_title(); ?></p>
                <ul class="archives-list">
                	<?php while (have_posts()) : the_post(); ?>
                        <article class="archives">
                            <?php
                            $previous_year = $year = 0;
                            $previous_month = $month = 0;
                            $ul_open = false;
                             
                            $myposts = get_posts('numberposts=-1&orderby=post_date&order=DESC');
                            
                            foreach($myposts as $post) {
                                setup_postdata($post);
                             
                                $year = mysql2date('Y', $post->post_date);
                                $month = mysql2date('n', $post->post_date);
                                $day = mysql2date('j', $post->post_date);
                                
                                if ($year != $previous_year || $month != $previous_month) {
                                    if ($ul_open) {
                                        echo '</ul></div>';
									}
                             
                                    echo '<div class="item"><h3>'; echo the_time('F Y'); echo '</h3>';
                                    echo '<ul class="archives-list">';
                                    $ul_open = true;
                             
								}
                             
                                $previous_year = $year; 
								$previous_month = $month;
                            ?>
                                <li>
                                    <time><?php the_time('j'); ?>日</time>
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    <span class="muted"><?php comments_number('', '1评论', '%评论'); ?></span>
                                </li>
                            <?php } ?>
            
                        </article>
        			<?php endwhile;  ?>
                </ul>
            </div>
            <div class="page">
           		<?php wp_pagenavi(); ?>
            </div>
        </div>   
        <?php get_sidebar(); ?>
    </div>
</div>
<!-- 主体内容结束 -->
<?php get_footer(); ?>