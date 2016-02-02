<?php  
/**
 * 小仓鼠挂件小工具
 */
 
add_action('widgets_init', 'registerHamsterWidget');

function registerHamsterWidget() {
	register_widget('HamsterWidget');
}

class HamsterWidget extends WP_Widget {
	
	function __construct() {
		$widget_ops = array('classname' => 'widget-hamster', 'description' => '显示一只萌萌的小仓鼠');
		$this->WP_Widget('widget_hamster', 'C-小仓鼠挂件（小C主题）', $widget_ops);
	}

	function widget($args, $instance) {
		extract( $args );

		$title = apply_filters('widget_name', $instance['title']);
		$more = $instance['more'];

		echo $before_widget;
		echo $before_title . '小仓鼠' . $after_title; 
		echo '<ul class="side-item-content">
        	<p class="hamster-text">调戏小仓鼠？（点击空白、黄点）</p>
            <embed type="application/x-shockwave-flash" src="http://cdn.abowman.com/widgets/hamster/hamster.swf" width="100%" height="210" id="flashID" name="flashID" bgcolor="#FFFFFF" quality="high" flashvars="up_backgroundColor=FFFFFF" wmode="opaque" allowscriptaccess="always">
        </ul>';
		echo $after_widget;
	}

	function form($instance) {
?>
		<p>
			<label>
				名称：
				<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" class="widefat" />
			</label>
		</p>
		
		<p>
			<label>
				More 显示文字：
				<input style="width:100%;" id="<?php echo $this->get_field_id('more'); ?>" name="<?php echo $this->get_field_name('more'); ?>" type="text" value="<?php echo $instance['more']; ?>" size="24" />
			</label>
		</p>
		
<?php
	}
}

?>