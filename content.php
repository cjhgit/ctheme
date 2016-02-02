
                
                <p class="post-title"><?php the_title(); ?></p>
                
                <div class="post-info">
                    <span class="post-author"><i class="fa fa-user"></i><?php the_author(); ?></span>
                    <span class="post-time"><i class="fa fa-clock-o"></i>
                    <?php 
					if (get_option('show_edit_time') && (get_the_modified_time('Y')*365+get_the_modified_time('z')) > (get_the_time('Y')*365+get_the_time('z'))) { 
						
					
					?>
                    
						最后更新于 <?php the_modified_time(get_option('date_format'), false); ?>
					<?php  } else { ?>
                    	<?php the_time(get_option('date_format' )); ?>
                    <?php } ?>
                    </span>
                    
                    
                    <?php 
					// 百度收录
					if (get_option('baidu_record')) {
						baidu_record();
					}

					if (get_option('content_show_comment') && comments_open()) { 
						echo '<span class="muted"><i class="fa fa-comments-o"></i> <a href="' . get_comments_link() . '">' . get_comments_number('去', '1', '%') . '评论</a></span>'; 
					} ?>
                    <?php if (get_option('show_qrcode') && !is_mobile()) { ?>
                    <span class="muted">
                    	<i class="fa fa-qrcode"></i> 
                        <a style="cursor : pointer;" onMouseOver="document.all.qr.style.visibility=''" onMouseOut="document.all.qr.style.visibility='hidden'">扫描二维码</a>
						<span id="qr" style="visibility: hidden;"><img style="position:absolute;z-index:99999;" src="<?php echo get_bloginfo("template_url")?>/phpqrcode.php?url=<?php
        the_permalink(); ?>"/>
        				</span>
                    </span>
        			<?php } ?>
                    <span class="post-tags"><?php the_tags('<i class="fa fa-tags"></i>', '', ''); ?></span>
                    <?php edit_post_link('[编辑]'); ?>
                </div>
                <br/>
                <div class="post-content theme-post-content"><?php the_content(); ?></div>
                <?php //wp_link_pages('before=<div id="page-links">&after=</div>'); ?>
                </br><?php wp_link_pages(array('before' => '<div class="fenye">文章分页：', 'after' => '', 'next_or_number' => 'next', 'previouspagelink' => '上一页', 'nextpagelink' => "")); ?>
<?php wp_link_pages(array('before' => '', 'after' => '', 'next_or_number' => 'number', 'link_before' =>'<span>', 'link_after'=>'</span>')); ?>
<?php wp_link_pages(array('before' => '', 'after' => '</div>', 'next_or_number' => 'next', 'previouspagelink' => '', 'nextpagelink' => "下一页")); ?>
				
                <div class="protocol">
                	<p>原文地址：<?php echo "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]; ?></p>
                    <p>版权声明：自由转载-非商用-非衍生-保持署名 | <a href="http://creativecommons.org/licenses/by-nc-nd/4.0/deed.zh" target="_blank">Creative Commons BY-NC-ND 4.0</a></p>
                </div>
                <div class="post-like">
    <a href="javascript:;" data-action="like" data-id="<?php the_ID(); ?>" id="post-like" class="specsZan <?php if(isset($_COOKIE['c_like'.$post->ID])) echo 'done';?>">顶 <span class="count">
        		<?php 
				if (get_post_meta($post->ID, 'c_like', true)) {
					echo get_post_meta($post->ID,'c_like',true);
                } else {
					echo '0';
				}
				?>
                </span>
    </a>
    				<a href="javascript:;" data-action="dislike" data-id="<?php the_ID(); ?>" id="post-dislike" class="specsZan <?php if(isset($_COOKIE['c_dislike'.$post->ID])) echo 'done';?>">踩 <span class="count">
        		<?php 
				if (get_post_meta($post->ID, 'c_dislike', true)) {
					echo get_post_meta($post->ID,'c_dislike',true);
                } else {
					echo '0';
				}
				?>
                </span>
                    </a>
                </div>
				<?php if(function_exists('the_ratings')) { the_ratings(); } ?>