<?php 
$sticky = get_option('sticky_posts'); 
rsort($sticky);  
$sticky = array_slice( $sticky, 0, 10); // 最多读取10条置顶文章作为banner
query_posts(array('post__in' => $sticky, 'caller_get_posts' => 1 ));   
$count = 0; // 置顶文章的数量
if (have_posts()) { ?>				
<!-- 轮播开始 -->
<div id="banner_tabs" class="flexslider clearfix">
    <ul class="slides">					
		<?php
		$titles = array();
        while (have_posts()) {
        the_post();
		$titles[$count] = get_the_title();
        $count += 1;  
		$image = getImageByPost($post);   
        ?>
        <li>
            <a title="" target="_blank" href="<?php the_permalink(); ?>">
                <img alt="" style="background-image: url(<?php echo $image; ?>);" src="<?php bloginfo('template_directory') ?>/images/alpha.png">
            </a>
        </li>
    	<?php } ?>
       
    </ul>
    <ul class="flex-direction-nav">
        <li><a class="flex-prev" href="javascript:;">Previous</a></li>
        <li><a class="flex-next" href="javascript:;">Next</a></li>
    </ul>
    <ol id="bannerCtrl" class="flex-control-nav flex-control-paging">
    	<?php
		for ($i = 0; $i < $count; $i++) {
			echo '<li><a></a></li>';	
		}
		?>
    </ol>
    <ol id="text-all" class="text-all">
    	<?php
        for ($i = 0; $i < $count; $i++) {
			echo '<li><span class="slide-text">' . $titles[$i] . '</span></li>';	
		}
		?>
    </ol>
 
</div>
<!-- 轮播结束 -->	
<?php } ?>   

        
