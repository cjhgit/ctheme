<?php 
/**
 * 评论相关的函数
 */
 
function my_fields($fields) {
	$fields['qq'] = '<p class="comment-form-qq">' . '<label for="qq">'.__('QQ').'</label> ' .
	'<input id="qq" name="qq" type="text" value="' . esc_attr( $commenter['comment_qq'] ) . '" size="30" /></p>';
	return $fields;
}
add_filter('comment_form_default_fields','my_fields');

/**
 * WordPress 添加评论之星
 */
function get_author_class($comment_author_email,$user_id){
	global $wpdb;
	$author_count = count($wpdb->get_results(
	"SELECT comment_ID as author_count FROM $wpdb->comments WHERE comment_author_email = '$comment_author_email' "));
	/*如果不需要管理员显示VIP标签，就把下面一行的 // 去掉*/
	// $adminEmail = get_option('admin_email');if($comment_author_email ==$adminEmail) return;
	if($author_count>=10 && $author_count<20)
		echo '<a class="vip1" title="评论达人 LV.1"></a>';
	else if($author_count>=20 && $author_count<40)
		echo '<a class="vip2" title="评论达人 LV.2"></a>';
	else if($author_count>=40 && $author_count<80)
		echo '<a class="vip3" title="评论达人 LV.3"></a>';
	else if($author_count>=80 && $author_count<160)
		echo '<a class="vip4" title="评论达人 LV.4"></a>';
	else if($author_count>=160 && $author_count<320)
		echo '<a class="vip5" title="评论达人 LV.5"></a>';
	else if($author_count>=320 && $author_count<640)
		echo '<a class="vip6" title="评论达人 LV.6"></a>';
	else if($author_count>=640)
		echo '<a class="vip7" title="评论达人 LV.7"></a>';
	
}

// 解决avatar服务器不能用的问题
function my_get_avatar($avatar, $id_or_email, $size, $default, $alt) {
	global $id_or_email;
	
	$default = 'https://www.baidu.com/img/bdlogo.png';
	$email = $id_or_email->comment_author_email;
	if ($email == '1418503647@qq.com') {
		$alt = '博主头像';
	} else {
		$alt = '用户头像';
	}

	if ($email != '1418503647@qq.com') {
		$avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/', '<img src="https://secure.gravatar.com/avatar/$1?s=$2" height="$2" width="$2" alt="ALT">', $avatar);
	} else {
		$tempPath = get_bloginfo('template_directory');
		$avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/', '<img src="' . $tempPath . '/images/my_head.jpg" height="$2" width="$2" alt="ALT">', $avatar);
	}
	
	$avatar = str_replace('ALT', $alt, $avatar);
	return $avatar;
}

add_filter('get_avatar', 'my_get_avatar', 10, 5);

// 设置默认头像 TODO 不起作用，可能是与上面的函数冲突了
function cjh_avatar_defaults($avatar_defaults) {  
    $myavatar = get_bloginfo('template_directory') . '/images/avatar_default.jpg';  
    $avatar_defaults[$myavatar] = "陈建杭的博客 默认头像";  
    return $avatar_defaults;  
}

add_filter('avatar_defaults', 'cjh_avatar_defaults');  

/** 获取评论者的链接 */
function cjh_get_comment_author_link() {
	global $comment_ID;
	$url = get_comment_author_url($comment_ID);
	$author = get_comment_author($comment_ID);
	if (empty( $url ) || 'http://' == $url ) {
		if ($author == "陈建杭") {
			return $author . '<span class="host-tag">博主</span>';
		} else {
			return $author;
		}
	} else {
		return "<a rel='external nofollow' href='$url' target='_blank'>$author</a>";
	}
}

add_filter('get_comment_author_link', 'cjh_get_comment_author_link');

// 评论添加@
function comment_add_at( $comment_text, $comment = '') {
  if ($comment->comment_parent > 0) {
    $comment_text = '@<a href="#comment-' . $comment->comment_parent . '">'.get_comment_author( $comment->comment_parent ) . '</a> ' . $comment_text;
  }

  return $comment_text;
}

add_filter('comment_text', 'comment_add_at', 20, 2);

const COMMENT_META_LIKE = 'c_like';

/** 获取评论顶次数 */
function get_comment_like($comment_id) {
	$like = get_comment_meta($comment_id, COMMENT_META_LIKE, true);
	if ($like == '') {
		$like = '0';
	}
	return $like;
}

const COMMENT_META_DISLIKE = 'c_dislike';

/** 获取评论踩次数 */
function get_comment_dislike($comment_id) {
	$dislike = get_comment_meta($comment_id, COMMENT_META_DISLIKE, true);
	if ($dislike == '') {
		$dislike = 0;
	}
	return $dislike;
}

// 评论垃圾词汇过滤
function in_comment_post_like($string, $array) {   
    foreach($array as $ref) { if(strstr($string, $ref)) { return true; } }   
    return false;  
}  
function drop_bad_comments() {  
    if (!empty($_POST['comment'])) {  
        $post_comment_content = $_POST['comment'];  
        $lower_case_comment = strtolower($_POST['comment']);  
        $bad_comment_content = array('网攒', '营销', '免费', '流量', '排名', '营销');
		  
        if (in_comment_post_like($lower_case_comment, $bad_comment_content)) {  
            $comment_box_text = wordwrap(trim($post_comment_content), 80, "\n  ", true);  
            $txtdrop = fopen(get_template_directory() . '/tmp/test.txt', 'a');  
            fwrite($txtdrop, "  --------------\n  [COMMENT] = " . $post_comment_content . "\n  --------------\n");  
            fwrite($txtdrop, "  [SOURCE_IP] = " . $_SERVER['REMOTE_ADDR'] . " @ " . date("F j, Y, g:i a") . "\n");  
            fwrite($txtdrop, "  [USERAGENT] = " . $_SERVER['HTTP_USER_AGENT'] . "\n");  
            fwrite($txtdrop, "  [REFERER  ] = " . $_SERVER['HTTP_REFERER'] . "\n");  
            fwrite($txtdrop, "  [FILE_NAME] = " . $_SERVER['SCRIPT_NAME'] . " - [REQ_URI] = " . $_SERVER['REQUEST_URI'] . "\n");  
            fwrite($txtdrop, '--------------**********------------------'."\n");  
            header("HTTP/1.1 406 Not Acceptable");  
            header("Status: 406 Not Acceptable");  
            header("Connection: Close");  
            err('您的评论含有非法、广告信息！');  
        }  
    }  
}  

add_action('init', 'drop_bad_comments');

// 评论过滤（评论必须带中文，不能包含日语）
function refused_spam_comments( $comment_data ) {  
	$pattern = '/[一-龥]/u';  
	$jpattern ='/[ぁ-ん]+|[ァ-ヴ]+/u';
	if (!preg_match($pattern, $comment_data['comment_content'])) {  
		err('写点汉字吧，博主外语很捉急！You should type some Chinese word!');  
	} 
	if (preg_match($jpattern, $comment_data['comment_content'])){
		err('日文滚粗！Japanese Get out！日本語出て行け！ You should type some Chinese word！');  
	}
	return($comment_data);  
}  

add_filter('preprocess_comment','refused_spam_comments');
?>
<?
// 打印评论的html代码
function aurelius_comment($comment, $args, $depth) {   
	$GLOBALS['comment'] = $comment; ?>
    
<li class="comment-item" id="li-comment-<?php comment_ID(); ?>">
	<div class="head-image">
    <?php
    if (function_exists('get_avatar') && get_option('show_avatars')) { 
		echo get_avatar($comment, 48); // 头像尺寸为48 
	}
	?>
	</div>
	<div class="comment-content" id="comment-<?php comment_ID(); ?>">
		<div class="comment-info">
			<div class="comment-author-name"><?php echo get_comment_author_link(); ?><?php get_author_class($comment->comment_author_email,$comment->user_id); ?><?php if(user_can($comment->user_id, 1)){echo "<a title='博主' class='vip'></a>";}; ?></div>
			<div class="comment-text">
				<?php if ($comment->comment_approved == '0') : ?>
                    <em>改评论正在审核！</em><br />
                <?php endif; ?>
                <?php comment_text(); ?>
			</div>
			<span class="comment-time"><?php echo get_comment_time('Y-m-d H:i'); ?></span>
			<?php comment_reply_link(array_merge( $args, array('reply_text' => '回复','depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			<?php edit_comment_link('修改'); ?>
            <?php   
if ( is_user_logged_in() ) {   
$url = get_bloginfo('url');   
echo '<a id="delete-'. $comment->comment_ID .'" href="' . wp_nonce_url("$url/wp-admin/comment.php?action=deletecomment&amp;p=" . $comment->comment_post_ID . '&amp;c=' . $comment->comment_ID, 'delete-comment_' . $comment->comment_ID) . '"" >删除</a>';   
}   
			?>  
            <a href="javascript:;" data-action="comment_like" data-id="<?php echo $comment->comment_ID; ?>" class="comment-like <?php if(isset($_COOKIE['c_comment_like'.$comment->comment_ID])) echo 'done';?>">顶 <span class="count"><?php echo get_comment_like($comment->comment_ID); ?></span></a>
            <a href="javascript:;" data-action="comment_dislike" data-id="<?php echo $comment->comment_ID; ?>" class="comment-dislike <?php if(isset($_COOKIE['c_comment_dislike'.$comment->comment_ID])) echo 'done';?>">踩 <span class="count"><?php echo get_comment_dislike($comment->comment_ID); ?></span></a>
			
		</div>
	</div>
  
  <!-- 
    </li> 
    -->
  
  <?php } ?>
