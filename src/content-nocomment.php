
                
                <p class="post-title"><?php the_title(); ?></p>
                <div class="post-info">
                    <span class="post-author"><i class="fa fa-user"></i><?php the_author(); ?></span>
                    <span class="post-time"><i class="fa fa-clock-o"></i><?php the_time(__('Y年n月j日', 'yotheme')); ?></span>
                    <span class="post-tags"><i class="fa fa-tags"></i><?php the_tags('', '', ''); ?></span>
                    <?php edit_post_link('[编辑]'); ?>
                </div>
                <br/>
                <div class="post-content"><?php the_content(); ?></div>
              