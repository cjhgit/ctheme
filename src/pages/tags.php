<?php
/*
Template Name: 标签云页面
Description: chenjianhang.com主题模板
*/
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
                	<?php 
					$tags_list = get_tags('orderby=count&order=DESC');
                    if ($tags_list) { 
                        foreach ($tags_list as $tag) {
                            echo '<li><a href="'.get_tag_link($tag).'">'. $tag->name .'</a>x '. $tag->count .'</li>'; 					
                        } 
                    } 
                    ?> 
                </ul>
            </div>
        </div>   
        <?php get_sidebar(); ?>
    </div>
</div>
<!-- 主体内容结束 -->
<?php get_footer(); ?>