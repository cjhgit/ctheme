<?php
/**
 * 作品展示分类模板
 */
?>
<?php get_header(); ?>
<!---->
<div class="content">
	<div class="content-main">
    	<div class="main2">
        	
        	<!-- 分类介绍开始 -->
        	<div class="cat-header">
            	<?php
				$cat_name = single_cat_title('',false);
				$cat_id = get_cat_ID($cat_name); // php 55
				$imageUrl = get_option('_category_image'.$cat_id);
				if ($imageUrl) {
					echo<<<IMG
					<div class="cat-img-box">
						<img class="cat-img" src="{$imageUrl}" />
					</div>
IMG;
				}
				?>
            	
            	<div class="cat-info">
                    <span class="cat-name"><?php echo single_cat_title( '', true); ?></span>
                    <?php
					$category_description = category_description();
					if (!empty( $category_description )) {
						echo "<p class='cat-desc'>" . $category_description . "</p>";
					} else {
						//echo "<p class='cat-desc'>暂无频道介绍。</p>";
					}
					?>
                    <ul class="sub-cat">
                    	<?php
						$args=array(
							'orderby' => 'name',
							'order' => 'ASC',
							'child_of' => $cat, 
						);
						$categories=get_categories($args);
						foreach($categories as $category) {
							// $category->description
							echo '<li class="cat"><a href="' . get_category_link( $category->term_id ) . '">' . $category->name . ' (' . $category->count . ')</a></li>';
						}
						?>   
                    </ul>
                </div>
            </div>
            <!-- 分类介绍结束 -->
        	<?php get_template_part('post', '2'); ?>
            <div class="page">
           		<?php wp_pagenavi(); ?>
            </div>
           
        </div>
    </div>

</div>
<!---->
<?php get_footer(); ?>