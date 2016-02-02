<?php
/**
 * WordPress內置嵌套評論專用 Ajax comments
 *
 * 說明: 這個文件是由 WP 3.0 根目錄的 wp-comment-post.php 修改的, 修改的地方有注解. 當 WP 升級, 請注意可能有所不同.
 *
 * zww: 匹配到 WP3.5.2
 */

if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
	header('Allow: POST');
	header('HTTP/1.1 405 Method Not Allowed');
	header('Content-Type: application/json');
	exit;
}

/** Sets up the WordPress Environment. */
require( dirname(__FILE__) . '/../../../wp-load.php' ); // 此 comments-ajax.php 位於主題資料夾,所以位置已不同

nocache_headers();

$comment_post_ID = isset($_POST['comment_post_ID']) ? (int) $_POST['comment_post_ID'] : 0;

$post = get_post($comment_post_ID);

if (empty($post->comment_status)) {
	do_action('comment_id_not_found', $comment_post_ID);
	err('评论状态无效。'); // 將 exit 改為錯誤提示
}

// get_post_status() will get the parent status for attachments.
$status = get_post_status($post);

$status_obj = get_post_status_object($status);

if ( !comments_open($comment_post_ID) ) {
	do_action('comment_closed', $comment_post_ID);
	err('不好意思，评论已经关闭。');
} elseif ('trash' == $status) {
	do_action('comment_on_trash', $comment_post_ID);
	err('评论状态有误。');
} elseif (!$status_obj->public && !$status_obj->private) {
	do_action('comment_on_draft', $comment_post_ID);
	err('评论状态有误。');
} elseif (post_password_required($comment_post_ID)) {
	do_action('comment_on_password_protected', $comment_post_ID);
	err('密码保护！');
} else {
	do_action('pre_comment_on_post', $comment_post_ID);
}

$comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
$comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
$comment_author_url   = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
$comment_content      = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;
$edit_id              = ( isset($_POST['edit_id']) ) ? $_POST['edit_id'] : null; // 提取 edit_id

// If the user is logged in
$user = wp_get_current_user();
if ($user->exists()) {
	if (empty($user->display_name)) {
		$user->display_name = $user->user_login;
	}
	$comment_author = $wpdb->escape($user->display_name);
	$comment_author_email = $wpdb->escape($user->user_email);
	$comment_author_url = $wpdb->escape($user->user_url);
	if (current_user_can('unfiltered_html')) {
		if ( wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != $_POST['_wp_unfiltered_html_comment'] ) {
			kses_remove_filters(); // start with a clean slate
			kses_init_filters(); // set up the filters
		}
	}
} else {
	if (get_option('comment_registration') || 'private' == $status)
		err('对不起, 必须登录才可以评论。');
}

$comment_type = '';

if (get_option('require_name_email') && !$user->exists()) {
	if (6 > strlen($comment_author_email) || '' == $comment_author) {
		err('请填写姓名和邮箱');
	} elseif (!is_email($comment_author_email)) {
		err('请填写邮箱');
	}
}

if ('' == $comment_content) {
	err('评论内容不能为空');
}

// 錯誤提示
function err($ErrMsg) {
    header('HTTP/1.1 405 Method Not Allowed');
    echo $ErrMsg;
    exit;
}

// 防止重复提交评论
$dupe = "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = '$comment_post_ID' AND ( comment_author = '$comment_author' ";
if ($comment_author_email) {
	$dupe .= "OR comment_author_email = '$comment_author_email' ";
}
$dupe .= ") AND comment_content = '$comment_content' LIMIT 1";
if ($wpdb->get_var($dupe)) {
    err('请勿重复提交评论!');
}

// 禁止评论太快
if ($lasttime = $wpdb->get_var($wpdb->prepare("SELECT comment_date_gmt FROM $wpdb->comments WHERE comment_author = %s ORDER BY comment_date DESC LIMIT 1", $comment_author))) { 
	$time_lastcomment = mysql2date('U', $lasttime, false);
	$time_newcomment  = mysql2date('U', current_time('mysql', 1), false);
	$flood_die = apply_filters('comment_flood_filter', false, $time_lastcomment, $time_newcomment);
	if ($flood_die) {
    	err('您刚刚评论过了，请等会儿再评论！');
	}
}

$comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;

$commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');

// 检查评论是否正被编辑、更新或新建评论
if ($edit_id) {
	$comment_id = $commentdata['comment_ID'] = $edit_id;
	wp_update_comment($commentdata);
} else {
	$comment_id = wp_new_comment($commentdata);
}

$comment = get_comment($comment_id);
do_action('set_comment_cookies', $comment, $user);

//$location = empty($_POST['redirect_to']) ? get_comment_link($comment_id) : $_POST['redirect_to'] . '#comment-' . $comment_id; //取消原有的刷新重定向
//$location = apply_filters('comment_post_redirect', $location, $comment);

//wp_safe_redirect( $location );
//exit;


$comment_depth = 1;   //为评论的 class 属性准备的
$tmp_c = $comment;
while ($tmp_c->comment_parent != 0) {
	$comment_depth++;
	$tmp_c = get_comment($tmp_c->comment_parent);
}

// 以下是评论样式，不含 "回复"。
?>
	<li class="comment-content" id="comment-<?php comment_ID(); ?>">
        <div class="head-image">
		<?php
        if (function_exists('get_avatar') && get_option('show_avatars')) { 
            echo get_avatar($comment, 48); // 头像尺寸为48 
        }
        ?>
        </div>
        <div class="comment-content" id="comment-<?php comment_ID(); ?>">
		<div class="comment-info">
			<div class="comment-author-name"><?php echo get_comment_author_link(); ?></div>
			<div class="comment-text">
				<?php if ($comment->comment_approved == '0') : ?>
                    <em>改评论正在审核！</em><br />
                <?php endif; ?>
                <?php comment_text(); ?>
			</div>
			<span class="comment-time"><?php echo get_comment_time('Y-m-d H:i'); ?></span>
			<!--a-->
            <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"></a>
            <!--a-->
			<?php //edit_comment_link('修改'); ?>
		</div>
       