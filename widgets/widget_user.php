<?php  
/**
 * 作者简介小工具
 */
add_action('widgets_init', 'register_user_widget');

function register_user_widget() {
	register_widget('UserWidget');
}

class UserWidget extends WP_Widget {
	
	function __construct() {
		$widget_ops = array('classname' => 'd_banner', 'description' => '显示一个作者简介');
		$this->WP_Widget('d_banner', 'C-作者介绍（小C主题）', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args);

		echo '<div class="side-item2">';
		echo '<img class="author-img" src="' . $instance['url'] . '" />';
		echo '<p class="author-desc">' . $instance['text'] . '</p>';       
		echo '</div>';
	}

	function form($instance) {
?>
		<p>
			<label>
				图片网址：
				<textarea id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" class="widefat" rows="12" style="font-family:Courier New;"><?php echo $instance['url']; ?></textarea>
			</label>
		</p>
        <p>
			<label>
				描述文字：
				<textarea id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" class="widefat" rows="12" style="font-family:Courier New;"><?php echo $instance['text']; ?></textarea>
			</label>
		</p>
<?php
	}
}

?>