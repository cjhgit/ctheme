<?php  
/**
 * 文章公告小工具
 */
 
add_action('widgets_init', 'register_notice_widget');

function register_notice_widget() {
	register_widget('NoticeWidget');
}

class NoticeWidget extends WP_Widget {
	
	function __construct() {
		$widget_ops = array('classname' => 'widget-notice', 'description' => '显示一个公告栏');
		$this->WP_Widget('d_notice', 'C-网站公告（小C主题）', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args);

		$title = apply_filters('widget_name', $instance['title']);
	
		$style = $instance['style'];

		$blank = $instance['blank'] ? ' target="_blank"' : '';

		echo '<ul class="side-item-content2">';
		?>
        <ul class="side-item-content">
        	<?php if ($instance['link']) { ?>
            <a href="<?php echo $instance['link']; ?>" <?php echo $blank; ?>>
			<?php } ?>
            
            <?php
            echo '<h3 class="notice-title">' . $instance['notice_title'] . '</h3>';
            echo '<p class="notice-content" style="color: #999;">' . $instance['content'] . '</p>';
            ?>
            
            <?php if ($instance['link']) { ?>
            </a>
			<?php } ?>
            
        </ul>
        <?php
		echo '</ul>';
	}

	function form($instance) {
	?>
		<p>
			<label>
				标题：
				<input id="<?php echo $this->get_field_id('tag'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" class="widefat" />
			</label>
		</p>
		<p>
			<label>
				公告标题：
				<input id="<?php echo $this->get_field_id('notice_title'); ?>" name="<?php echo $this->get_field_name('notice_title'); ?>" type="text" value="<?php echo $instance['notice_title']; ?>" class="widefat" />
			</label>
		</p>
		<p>
			<label>
				公告内容：
				<textarea id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" class="widefat" rows="3"><?php echo $instance['content']; ?></textarea>
			</label>
		</p>		
		<p>
			<label>
				链接：
				<input style="width:100%;" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="url" value="<?php echo $instance['link']; ?>" size="24" />
			</label>
		</p>
		<p>
			<label>
				样式：
				<select id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
					<option value="style01" <?php selected('style01', $instance['style']); ?>>蓝色</option>
					<option value="style02" <?php selected('style02', $instance['style']); ?>>橘红色</option>
					<option value="style03" <?php selected('style03', $instance['style']); ?>>绿色</option>
					<option value="style04" <?php selected('style04', $instance['style']); ?>>紫色</option>
					<option value="style05" <?php selected('style05', $instance['style']); ?>>青色</option>
					<option value="style06" <?php selected('style06', $instance['style']); ?>>红色</option>
				</select>
			</label>
		</p>
		<p>
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['blank'], 'on' ); ?> id="<?php echo $this->get_field_id('blank'); ?>" name="<?php echo $this->get_field_name('blank'); ?>">新打开浏览器窗口
			</label>
		</p>
<?php
	}
}

?>
