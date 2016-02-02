

                <p class="post-title"><?php the_title(); ?></p>
                <div class="post-info">
                    <span class="post-author"><i class="fa fa-user"></i><?php the_author(); ?></span>
                    <span class="post-time"><i class="fa fa-clock-o"></i><?php the_time(__('Y年n月j日', 'yotheme')); ?></span>
                    <span class="post-tags"><i class="fa fa-tags"></i><?php the_tags('', '', ''); ?></span>
                </div>
                <br/>
                <ul class="gallery">
<?php all_img($post->post_content);?>
</ul>
                
                <br/>
                
                
                <div class="post-like">
    <a href="javascript:;" data-action="ding" data-id="<?php the_ID(); ?>" class="specsZan <?php if(isset($_COOKIE['specs_zan_'.$post->ID])) echo 'done';?>">喜欢 <span class="count">
        <?php if( get_post_meta($post->ID,'specs_zan',true) ){
            		echo get_post_meta($post->ID,'specs_zan',true);
                } else {
					echo '0';
				}?></span>
    </a>
</div>