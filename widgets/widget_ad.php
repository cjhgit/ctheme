<?php  
/**
 * 广告小工具
 */
add_action('widgets_init', 'register_ad_widget');

function register_ad_widget() {
	register_widget('AdWidget');
}

class AdWidget extends WP_Widget {
	
	function __construct() {
		$widget_ops = array('classname' => 'd_banner', 'description' => '显示一个广告、图片、文本什么的');
		$this->WP_Widget('d_banner', 'C-广告（小C主题）', $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_name', $instance['title']);
		$code = $instance['code'];

		echo $before_widget;
		echo '<div class="d_banner_inner">'.$code.'</div>';
		echo $after_widget;
	}

	function form($instance) {
?>
		<p>
			<label>
				广告名称：
				<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" class="widefat" />
			</label>
		</p>
		<p>
			<label>
				广告代码：
				<textarea id="<?php echo $this->get_field_id('code'); ?>" name="<?php echo $this->get_field_name('code'); ?>" class="widefat" rows="12" style="font-family:Courier New;"><?php echo $instance['code']; ?></textarea>
			</label>
		</p>
<?php
	}
}

?>