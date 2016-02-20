<?php  
/**
 * 社交图标小工具
 */
 
add_action('widgets_init', 'register_about_widget');

function register_about_widget() {
    register_widget('AboutWidget');
}

class AboutWidget extends WP_Widget {
	
    function __construct() {
        $widget_ops = array(
            'classname' => 'widget-about',
            'description' => '显示常用的社交联系方式'
        );
        $this->WP_Widget('widget_about', 'C-社交图标（小C主题）', $widget_ops);
    }
	
    function widget($args, $instance) {
        extract($args);
		$qq = $instance['qq'];
		$email = $instance['email'];
		$webchat = $instance['webchat'];
		$tieba = $instance['tieba'];
		
        echo $before_widget;
		?>
		<ul class="side-item-content">
            <?php if (!empty($qq)) { ?>
            	<a href="<?php echo $qq; ?>" title="QQ" target="_blank"><i class="qq fa fa-qq"></i></a>
			<?php } ?>
            <?php if (!empty($email)) { ?>
            	<a href="<?php echo $email; ?>" title="邮箱" target="_blank"><i class="email fa fa-envelope-o"></i></a>
			<?php } ?>
            <?php if (!empty($webchat)) { ?>
            	<a href="<?php echo $webchat; ?>" title="微信" target="_blank"><i class="weixin fa fa-weixin"></i></a>
			<?php } ?>
            <?php if (!empty($tieba)) { ?>
            	<a href="<?php echo $tieba; ?>" target="_blank" title="贴吧"><i class="baidu fa fa-paw"></i></a>
			<?php } ?>
        	<?php if (!empty($instance['sina_weibo'])) { ?>
            	<a href="<?php echo $instance['sina_weibo']; ?>" target="_blank" title="新浪微博"><i class="sina-weibo fa fa-weibo"></i></a>
			<?php } ?>
            <?php if (!empty($instance['tecent_weibo'])) { ?>
            	<a href="<?php echo $instance['tecent_weibo']; ?>" target="_blank" title="腾讯微博"><i class="tencent-weibo fa fa-tencent-weibo"></i></a>
			<?php } ?>
            <?php if (!empty($instance['github'])) { ?>
            	<a href="<?php echo $instance['github']; ?>" target="_blank" title="github"><i class="github fa fa-github"></i></a>
			<?php } ?>
            <?php if (!empty($instance['facebook'])) { ?>
            	<a href="<?php echo $instance['facebook']; ?>" target="_blank" title="facebook"><i class="facebook fa fa-facebook"></i></a>
			<?php } ?>
            <?php if (!empty($instance['pay'])) { ?>
            	<a href="<?php echo $instance['pay']; ?>" target="_blank" title="支付宝"><img class="image-icon" src="<?php bloginfo('template_url'); ?>/images/pay.png" alt="支付宝" /></a>
			<?php } ?>
            <?php if (!empty($instance['csdn'])) { ?>
            	<a href="<?php echo $instance['csdn']; ?>" target="_blank" title="csdn"><img class="image-icon" src="<?php bloginfo('template_url'); ?>/images/csdn.png" alt="csdn" /></a>
			<?php } ?>
            <?php if (!empty($instance['cnblogs'])) { ?>
            	<a href="<?php echo $instance['cdblogs']; ?>" target="_blank" title="博客园"><img class="image-icon" src="<?php bloginfo('template_url'); ?>/images/cnblogs.png" alt="博客园" /></a>
			<?php } ?>
            <?php if (!empty($instance['feed'])) { ?>
            	<a href="<?php echo get_bloginfo('url'); ?>/feed" target="_blank" title="订阅"><i class="rss fa fa-rss"></i></a>
			<?php } ?>
            
            
            
        </ul>
		<?php
        echo $after_widget;
    }
	
    function form($instance) {
?>
		<p>
			<label>
				QQ：
				<input id="<?php echo $this->get_field_id('qq'); ?>" name="<?php echo $this->get_field_name('qq'); ?>" type="text" value="<?php echo $instance['qq']; ?>" class="widefat" />
			</label>
		</p>
        <p>
			<label>
				邮箱：
				<input id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $instance['email']; ?>" class="widefat" />
			</label>
		</p>
		<p>
			<label>
				微信：
				<input id="<?php echo $this->get_field_id('webchat'); ?>" name="<?php echo $this->get_field_name('webchat'); ?>" type="text" value="<?php echo $instance['webchat']; ?>" class="widefat" />
			</label>
		</p>
        <p>
			<label>
				贴吧：
				<input id="<?php echo $this->get_field_id('tieba'); ?>" name="<?php echo $this->get_field_name('tieba'); ?>" type="text" value="<?php echo $instance['tieba']; ?>" class="widefat" />
			</label>
		</p>
        <p>
			<label>
				新浪微博：
				<input id="<?php echo $this->get_field_id('sina_weibo'); ?>" name="<?php echo $this->get_field_name('sina_weibo'); ?>" type="text" value="<?php echo $instance['sina_weibo']; ?>" class="widefat" />
			</label>
		</p>
        <p>
			<label>
				腾讯微博：
				<input id="<?php echo $this->get_field_id('tecent_weibo'); ?>" name="<?php echo $this->get_field_name('tecent_weibo'); ?>" type="text" value="<?php echo $instance['tecent_weibo']; ?>" class="widefat" />
			</label>
		</p>
        <p>
			<label>
				Github：
				<input id="<?php echo $this->get_field_id('github'); ?>" name="<?php echo $this->get_field_name('github'); ?>" type="text" value="<?php echo $instance['github']; ?>" class="widefat" />
			</label>
		</p>
        <p>
			<label>
				Facebook：
				<input id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo $instance['facebook']; ?>" class="widefat" />
			</label>
		</p>
        <p>
			<label>
				支付宝：
				<input id="<?php echo $this->get_field_id('pay'); ?>" name="<?php echo $this->get_field_name('pay'); ?>" type="text" value="<?php echo $instance['pay']; ?>" class="widefat" />
			</label>
		</p>
        <p>
			<label>
				Csdn：
				<input id="<?php echo $this->get_field_id('csdn'); ?>" name="<?php echo $this->get_field_name('csdn'); ?>" type="text" value="<?php echo $instance['csdn']; ?>" class="widefat" />
			</label>
		</p>
        <p>
			<label>
				博客园：
				<input id="<?php echo $this->get_field_id('cnblogs'); ?>" name="<?php echo $this->get_field_name('cnblogs'); ?>" type="text" value="<?php echo $instance['cnblogs']; ?>" class="widefat" />
			</label>
		</p>
        <p>
            <label>
                <input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['feed'], 'on' ); ?> id="<?php echo $this->get_field_id('feed'); ?>" name="<?php echo $this->get_field_name('feed'); ?>">订阅
            </label>
        </p>
<?php
    }
}