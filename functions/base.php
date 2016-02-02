<?php 
/**
 * 基本函数
 */

/** 输出页面标题 */
function echo_title() {	
	global $page, $paged;
	
	$separator = ' - ';
	echo wp_title($separator, 0, 'right');

	bloginfo('name');
	
	$description = trim(get_bloginfo('description', 'display')); // 第二个参数？
 	if ($description && is_home() || is_front_page()) {
		echo $separator . $description;
	}
	if ($paged >= 2 || $page >= 2) {
		echo $separator . sprintf('第%s页', max($paged, $page));
	}
}
/*
global $page, $paged;
	$site_description = get_bloginfo( 'description', 'display' );
 	if ($site_description && ( is_home() || is_front_page() )) {
		bloginfo('name');
		echo " - $site_description";
	} else {
		echo trim(wp_title('',0));
		if ( $paged >= 2 || $page >= 2 )
			echo ' - ' . sprintf( __( '第%s页' ), max( $paged, $page ) );
		echo ' | ' ;
		bloginfo('name');
	}
*/

/** 获取页面关键词 */
function get_keywords() {
	if (is_home() || is_archive() || is_tag()) {
		$keywords = get_option('keywords');
	} elseif (is_single()) {
		$keywords = '';
		$tags = wp_get_post_tags($post->ID);
		foreach ($tags as $tag) {
			$keywords = $keywords . $tag->name . ',';
		}
		
	}
	if ($keywords == '') {
		$keywords = get_bloginfo('name');
	}
	return $keywords;
}

/** 获取网页描述 */
function get_description() {
	global $post;
	
	if (is_home() || is_archive() || is_tag() ) {
		$description = get_option('web_desc');
	} else if (is_single()) {
		if ($post->post_excerpt) {
			$description = $post->post_excerpt;
		} else {
			$description = substr(strip_tags($post->post_content), 0, 220); // 截取文章的前220字节作为描述
		}
		
	}
	if ($description == '') {
		$description = get_bloginfo('name');
	}
	return $description;
}

// 显示页面数据库查询次数、加载时间和内存占用
function performance($visible = false) {
	$stat = sprintf('数据库查询%d次，耗时%.3f秒，使用内存%.2fM',
		get_num_queries(),
		//timer_stop( 0, 3 ),
		timer_stop(0, 4),
		memory_get_peak_usage() / 1024 / 1024
	);
	echo $visible ? $stat : "{$stat}" ;
}

/**
 * WordPress 注册表单添加验证问题(支持多个随机问题)
 * http://www.wpdaxue.com/add-a-security-question-to-the-register-screen.html
 */
function rand_reg_question(){
	$register_number=rand(0,1); // 设置随机数的返回范围
	$_SESSION['register_number']=$register_number;
}
add_action('login_head','rand_reg_question');
 
global $register_questions;
global $register_answers;

$register_questions = array('中国的首都在哪里？', '1+1=？'); // 验证问题
$register_answers = array('北京', '2'); // 答案
 
add_action('register_form', 'add_security_question');
function add_security_question() {
	global $register_questions;
	$register_number=$_SESSION['register_number'];
	?>
	<p>
		<label><?php echo $register_questions[$register_number];?><br />
			<input type="text" name="user_proof" id="user_proof" class="input" size="25" tabindex="20" />
		</label>
	</p>
	<?php 
}
 
add_action('register_post', 'add_security_question_validate', 10, 3);

function add_security_question_validate( $sanitized_user_login, $user_email, $errors) {
	global $register_answers;
	$register_number = $_SESSION['register_number'];
	if (!isset($_POST['user_proof']) || empty($_POST['user_proof'])) {
		return $errors->add( 'proofempty', '<strong>错误</strong>: 您还没有回答问题。' );
	} elseif ( strtolower( $_POST[ 'user_proof' ] ) != $register_answers[$register_number] ) {
		return $errors->add( 'prooffail', '<strong>错误</strong>: 您的回答不正确。' );
	}
}