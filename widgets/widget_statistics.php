<?php  
/**
 * 网站统计小工具
 */
add_action('widgets_init', 'register_statistics_widget');

function register_statistics_widget() {
	register_widget('StatisticsWidget');
}

/** 获取网站今日访问人数 */
function get_web_view() {
	$count = get_option('c_web_view');
	if ($count == '') {
		$count = 0;	
	}
	return $count + 100;
}

function set_web_view() {

	if (!isset($_COOKIE['c_web_view'])) {
		$count = get_option('c_web_view');
		if ($count == '') {
			$count = 0;	
		}
		$count++;
		update_option('c_web_view', $count++);
		
		$expire = time() + 3600 * 24; // 24小时过期 TODO
		$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
		setcookie('c_web_view', 'c', $expire, '/', $domain, false);
	}
}

add_action('get_header', 'set_web_view');

class StatisticsWidget extends WP_Widget {
	
	function __construct() {
		$widget_ops = array('classname' => 'widget-statistics', 'description' => '网站统计（不能统计网站访问量）');
		$this->WP_Widget('widget_statistics', 'C-网站统计（小C主题）', $widget_ops);
	}

	function widget($args, $instance) {
		extract( $args );

		$title = apply_filters('widget_name', $instance['title']);
		$more = $instance['more'];
		if (empty($instance['establish_time'])) {
			$establishTime = '未设置';
			$day = '未设置建站日期';
		} else {
			$establishTime = empty($instance['establish_time']) ? '2013-01-27' : $instance['establish_time'];
			$day = floor((time() - strtotime($establishTime)) / 86400) . '天';
		}
		
		
		echo $before_widget;
		echo $before_title . '站点统计' . $after_title; 
		global $wpdb;
		?>
        <ul class="side-item-content">
        	<li>文章总数：<?php $count_posts = wp_count_posts(); echo $published_posts = $count_posts->publish; ?> 篇</li>
            <li>标签数量：<?php echo $count_tags = wp_count_terms('post_tag'); ?> 个</li>
            <li>会员数量：<?php $users = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->users"); echo $users; ?> 个</li>
            <li>评论数量：<?php $total_comments = get_comment_count(); echo $total_comments['approved'];?> 条</li>
            <?php if (!empty($instance['show_date'])) { ?>
            	<li>建站日期：<?php echo$establishTime; ?></li>
			<?php } ?>
            
            <li>运行天数：<?php echo $day; ?></li>
            <li>最后更新：<?php $last = $wpdb->get_results("SELECT MAX(post_modified) AS MAX_m FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')");$last = date('Y-n-j', strtotime($last[0]->MAX_m));echo$last; ?></li>
            
            <?php if (!empty($instance['view_count'])) { ?>
            	<li>今日访问：<?php echo get_web_view(); ?> 人</li>
			<?php } ?>
        </ul>
        <?php
		echo $after_widget;
	}

	function form($instance) {
	?>
		<p>
		<label>建站日期（格式yyyy-mm-dd不要写错）：
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('establish_time'); ?>" type="text" value="<?php echo $instance['establish_time']; ?>" class="widefat" />
			</label>
		</p>
        <p>
            <label>
                <input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['show_date'], 'on' ); ?> id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>">显示建站日期：
            </label>
        </p>

        <p>
            <label>
                <input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['view_count'], 'on' ); ?> id="<?php echo $this->get_field_id('view_count'); ?>" name="<?php echo $this->get_field_name('view_count'); ?>">今日访问：
            </label>
        </p>

<?php
	}
}

?>