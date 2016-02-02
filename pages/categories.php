<?php
/**
Template Name: 文章分类页面
Description: chenjianhang.com主题模板
*/
?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/categories.css" />
<!-- 主体内容开始 -->
<div class="content">
	<div class="content-main">
    	<div class="main">
        	<div class="category">
                <p class="category-name"><?php the_title(); ?></p>
                
                    
					<ul id="cat_list">
                    	<?php 
						$args = array(
							'show_count' => 1, // 是否显示文章数量
							'orderby' => 'count',
							'order' => 'DESC',
						);
						?>
						<?php wp_list_categories($args); ?>   
					</ul>
				
            	</div>
            <?php  
			/*
$categories=get_categories($args);  
foreach($categories as $category) {   
    if ( get_option('_category_image'.$category->term_id) ){  
            echo '<div><a href="'.get_term_link($category).'"><img title="'.$category->name.'" alt="'.$category->name.'" src="'.get_option('_category_image'.$category->term_id).'" /></a></div>';   
    }  
    echo '<div style=" text-align:center;"><a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '><b>' . $category->name.'</b></a></div>';  
}
*/?>  
        </div>   
        <?php get_sidebar(); ?>
    </div>
</div>
<!-- 主体内容结束 -->
<?php get_footer(); ?>