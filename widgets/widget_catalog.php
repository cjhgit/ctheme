<?php  
/**
 * 文章目录小工具
 */
add_action('widgets_init', 'register_catalog_widget');

function register_catalog_widget() {
	register_widget('CatalogWidget');
}

class CatalogWidget extends WP_Widget {
	
	function __construct() {
		$widget_ops = array('classname' => 'widget-catalog', 'description' => '显示文章目录，只能在文章页使用' );
		$this->WP_Widget('c_catalog', 'C-文章目录（小C主题）', $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		global $post_content;
		$title = apply_filters('widget_name', $instance['title']);
		$code = $instance['code'];

		echo $before_widget;
		echo '<div class="d_banner_inner">'. $post_content.'</div>';
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