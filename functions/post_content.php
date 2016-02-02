<?php
/**
 * 文章内容相关的函数
 */

/** 文章添加目录导航 */
function post_catalog($content) {
	
	if (!get_option('post_catalog')) {
		return $content;
	}

	$matches = array();
	$ul_li = '';

	$r = "/<h2>([^<]+)<\/h2>/im";

	if (is_singular() && preg_match_all($r, $content, $matches)) {
      foreach($matches[1] as $num => $title) {
         $title = trim(strip_tags($title));
         $content = str_replace($matches[0][$num], '<h2 id="title-'.$num.'">'.$title.'</h2>', $content);
         $ul_li .= '<li><a href="#title-'.$num.'" title="'.$title.'">'.$title."</a></li>\n";
      }

      $content = '<div id="post-catalog" class="post-catalog">
                     <p class="catalog-title">文章目录</p>
                     <ol id="catalog-content">' . $ul_li . '</ol>
                  </div>' . $content;
   }

   return $content;
}

add_filter('the_content', 'post_catalog');

// 文章添加二级目录导航（未实现）
function article_index2($content) {
$matches = array();
$ul_li = '';

$r = '/<h([3-6]).*?\>(.*?)<\/h[2-6]>/is';

if(is_single() && preg_match_all($r, $content, $matches)) {
foreach($matches[1] as $key => $value) {
$title = trim(strip_tags($matches[2][$key]));
$content = str_replace($matches[0][$key], '<h' . $value . ' id="title-' . $key . '">'.$title.'</h2>', $content);
$ul_li .= '<li><a href="#title-'.$key.'" title="'.$title.'">'.$title."</a></li>\n";
}

$content = "\n<div id=\"article-index\">
<strong>文章目录</strong>
<ol id=\"index-ul\">\n" . $ul_li . "</ol>
</div>\n" . $content;
}

return $content;
}

//add_filter( 'the_content', 'article_index2' );


const POST_META_VIEWS = 'views';

/** 获取文章浏览次数 */
function get_post_views($post_id) {

	$count = get_post_meta($post_id, POST_META_VIEWS, true);
	if ($count == '') {
		delete_post_meta($post_id, POST_META_VIEWS);
		add_post_meta($post_id, POST_META_VIEWS, '0');
		$count = '0';
	}
	echo number_format_i18n($count);
}

/** 文章浏览次数加1 */
function set_post_views() {
	global $post;
	
	$post_id = $post->ID;
	
	// cookie防止重复计数
	if (!isset($_COOKIE['c_post_views' . $post->ID])) {
		$count = get_post_meta($post_id, POST_META_VIEWS, true);
		if ((is_single() || is_page()) && !current_user_can('level_10')) { // 管理员浏览文章不计数
			if ($count == '') {
				delete_post_meta($post_id, POST_META_VIEWS);
				add_post_meta($post_id, POST_META_VIEWS, '1');
			} else {
				update_post_meta($post_id, POST_META_VIEWS, $count + 1);
			}
			
			$expire = time() + 3600 * 24; // 24小时过期
			$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
			setcookie('c_post_views' . $post->ID, $post->ID, $expire, '/', $domain, false);
		}
	}	
}

add_action('get_header', 'set_post_views');

// 点赞
add_action('wp_ajax_nopriv_specs_zan', 'specs_zan');
add_action('wp_ajax_specs_zan', 'specs_zan');
const COMMENT_META_LIKE = 'c_comment_like';
const COMMENT_META_DISLIKE = 'c_comment_dislike';
function specs_zan() {
    global $wpdb, $post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    if ($action == 'like') {
        $specs_raters = get_post_meta($id, 'c_like', true);
        
		// 设置cookie防止重复操作
		$expire = time() + 99999999;
        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
        setcookie('c_like' . $id, $id, $expire, '/', $domain, false);
		
        if (!$specs_raters || !is_numeric($specs_raters)) {
            update_post_meta($id, 'c_like', 1);
        } else {
            update_post_meta($id, 'c_like', ($specs_raters + 1));
        }
        echo get_post_meta($id,'c_like',true);
    } 
	
	if ($action == 'dislike') {
        $specs_raters = get_post_meta($id, 'c_dislike', true);
		
        $expire = time() + 99999999;
        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
        setcookie('c_dislike' . $id, $id, $expire, '/', $domain, false);
		
        if (!$specs_raters || !is_numeric($specs_raters)) {
            update_post_meta($id, 'c_dislike', 1);
        } else {
            update_post_meta($id, 'c_dislike', ($specs_raters + 1));
        }
        echo get_post_meta($id,'c_dislike',true);
    } 
	
	if ($action == 'comment_like') {
		echo counter($id, COMMENT_META_LIKE);
    } 
	
	if ($action == 'comment_dislike') {
		echo counter($id, COMMENT_META_DISLIKE);
    } 
	
    die;
}

function counter($id, $filed_name) {
	$expire = time() + 99999999;
	$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
	setcookie($filed_name . $id, $id, $expire, '/', $domain, false);
	
	$count = get_comment_meta($id, $filed_name, true);
	if ($count == '') {
		delete_comment_meta($id, $filed_name);
		add_comment_meta($id, $filed_name, 1);
		$count = 1;
	} else {
		$count += 1;
		update_comment_meta($id, $filed_name, $count);
	}
	return $count;
}

// 获取文章所有图片
function all_img($soContent) {	
	$soImages = '~<img [^\>]*\ />~';
	preg_match_all( $soImages, $soContent, $thePics );
	$allPics = count($thePics);
	if ($allPics > 0) {
		foreach ($thePics[0] as $v) {
			echo $v;
		}
	} else {
		echo "<img src='";
		echo bloginfo('template_url');
		echo "/images/thumb.gif'>";
	}
}

/* 获取懒加载图片的路径 */
function get_lazyload_image() {
	return get_bloginfo('template_directory') . '/images/nothing.png';
}

/* 文章内容的图片懒加载 */
function lazyload($content) {  
    if (!get_option('close_lazy') && (!is_feed() || !is_robots)) {
		$loadimg_url = get_bloginfo('template_directory') . '/images/loading.gif';
        $content = preg_replace('/<img(.+)src=[\'"]([^\'"]+)[\'"](.*)>/i',"<img\$1data-original=\"\$2\" src=\"$loadimg_url\"\$3>\n<noscript>\$0</noscript>", $content);
    }
    return $content;
}

add_filter('the_content', 'lazyload');

// ==========文章类型==========

// 使文章支持更多的类型
add_theme_support('post-formats', array('aside', 'chat', 'gallery', 'image', 
	'link','quote', 'status', 'video', 'audio'));

// 使页面支持不同的文章类型
//add_post_type_support('page', 'post-formats' );   

//============文章评论===============

// 让文章内容和评论支持emoji并禁用emoji加载的乱七八糟的脚本
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
$wpsmiliestrans = array(
	':?:' => 'icon_question.gif',
	':razz:' => 'icon_razz.gif',
	':sad:' => 'icon_sad.gif',
	':evil:' => 'icon_evil.gif',
	':!:' => 'icon_exclaim.gif',
	':smile:' => 'icon_smile.gif',
	':oops:' => 'icon_redface.gif',
	':grin:' => 'icon_biggrin.gif',
	':eek:' => 'icon_surprised.gif',
	':shock:' => 'icon_eek.gif',
	':???:' => 'icon_confused.gif',
	':cool:' => 'icon_cool.gif',
	':roll:' => 'icon_rolleyes.gif',
	':mad:' => 'icon_mad.gif',
	':twisted:' => 'icon_twisted.gif',
	':lol:' => 'icon_lol.gif',
	':wink:' => 'icon_wink.gif',
	':idea:' => 'icon_idea.gif',
	':arrow:' => 'icon_arrow.gif',
	':neutral:' => 'icon_neutral.gif',
	':cry:' => 'icon_cry.gif',
	':mrgreen:' => 'icon_mrgreen.gif',

	'8-)' => 'icon_cool.gif',
	'8-O' => 'icon_eek.gif',
	':-(' => 'icon_sad.gif',
	':-)' => 'icon_smile.gif',
	':-?' => 'icon_confused.gif',
	':-D' => 'icon_biggrin.gif',
	':-P' => 'icon_razz.gif',
	':-o' => 'icon_surprised.gif',
	':-x' => 'icon_mad.gif',
	':-|' => 'icon_neutral.gif',
	';-)' => 'icon_wink.gif',
	'8O' => 'icon_eek.gif',
	':(' => 'icon_sad.gif',
	':)' => 'icon_smile.gif',
	':?' => 'icon_confused.gif',
	':D' => 'icon_biggrin.gif',
	':P' => 'icon_razz.gif',
	':o' => 'icon_surprised.gif',
	':x' => 'icon_mad.gif',
	':|' => 'icon_neutral.gif',
	';)' => 'icon_wink.gif',
	':!:' => 'icon_exclaim.gif',
	':?:' => 'icon_question.gif',
	'[\疑问]' => 'icon_question.gif',
);

// 解决表情变成□□的问题
function smilies_initx() {
	global $wpsmiliestrans, $wp_smiliessearch;
	if (!get_option('use_smilies'))
		return;
 
	if (!isset($wpsmiliestrans)) {
		// TODO
	}
	if (count($wpsmiliestrans) == 0) {
 		return;
	}
	krsort($wpsmiliestrans);
	$spaces = wp_spaces_regexp();
	$wp_smiliessearch = '/(?<=' . $spaces . '|^)';
	$subchar = '';
	foreach ((array) $wpsmiliestrans as $smiley => $img) {
		$firstchar = substr($smiley, 0, 1);
		$rest = substr($smiley, 1);
		if ($firstchar != $subchar) {
			if ($subchar != '') {
				$wp_smiliessearch .= ')(?=' . $spaces . '|$)'; // End previous "subpattern"
				$wp_smiliessearch .= '|(?<=' . $spaces . '|^)'; // Begin another "subpattern"
			}
			$subchar = $firstchar;
			$wp_smiliessearch .= preg_quote($firstchar, '/') . '(?:';
		} else {
			$wp_smiliessearch .= '|';
		}
		$wp_smiliessearch .= preg_quote($rest, '/');
	}
	$wp_smiliessearch .= ')(?=' . $spaces . '|$)/m';
}
 
remove_action('init', 'smilies_init', 5);
add_action( 'init' , 'smilies_initx' , 5 );

$smiles = array(
	':?:' => 'icon_question.gif',
	':razz:' => 'icon_razz.gif',
	':sad:' => 'icon_sad.gif',
	':evil:' => 'icon_evil.gif',
	':!:' => 'icon_exclaim.gif',
	':smile:' => 'icon_smile.gif',
	':oops:' => 'icon_redface.gif',
	':grin:' => 'icon_biggrin.gif',
	':eek:' => 'icon_surprised.gif',
	':shock:' => 'icon_eek.gif',
	':???:' => 'icon_confused.gif',
	':cool:' => 'icon_cool.gif',
	':roll:' => 'icon_rolleyes.gif',
	':mad:' => 'icon_mad.gif',
	':twisted:' => 'icon_twisted.gif',
	':lol:' => 'icon_lol.gif',
	':wink:' => 'icon_wink.gif',
	':idea:' => 'icon_idea.gif',
	':arrow:' => 'icon_arrow.gif',
	':neutral:' => 'icon_neutral.gif',
	':cry:' => 'icon_cry.gif',
	':mrgreen:' => 'icon_mrgreen.gif',
);
 
// 输出表情
function output_smilies() {
	global $smiles;

	reset($smiles);
	while (key($smiles) !== null) {
		?>
        <a href="javascript:grin('<?php echo key($smiles); ?>')"><img src="<?php bloginfo('template_url'); ?>/images/smilies/<?php echo current($smiles); ?>" alt="" /></a>
        
        <?
		next($smiles);
	}
}

// 自定义表情路径
/*
第一个参数，如：http://www.chenjianhang.com/wp-includes/images/smilies/frownie.png
第二个参数，如：frownie.png
不是加载每个表情都会调用
*/
function fa_smilies_src($img_src, $img) {
	$img = rtrim($img, "gif");
	return get_bloginfo('template_directory') . '/images/smilies/' . $img . 'gif';
}

add_filter('smilies_src', 'fa_smilies_src', 1, 10);

// 后台编辑界面添加表情
function fa_smilies_custom_button($context) {
    $context .= '<style>.smilies-wrap{background:#fff;border: 1px solid #ccc;box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.24);padding: 10px;position: absolute;top: 60px;width: 400px;display:none}.smilies-wrap img{height:24px;width:24px;cursor:pointer;margin-bottom:5px} .is-active.smilies-wrap{display:block}</style><a id="insert-media-button" style="position:relative" class="button insert-smilies add_smilies" title="添加表情" data-editor="content" href="javascript:;">
<span class="dashicons dashicons-admin-users"></span>
添加表情
</a><div class="smilies-wrap">'. fa_get_wpsmiliestrans() .'</div><script>jQuery(document).ready(function(){jQuery(document).on("click", ".insert-smilies",function() { if(jQuery(".smilies-wrap").hasClass("is-active")){jQuery(".smilies-wrap").removeClass("is-active");}else{jQuery(".smilies-wrap").addClass("is-active");}});jQuery(document).on("click", ".add-smily",function() { send_to_editor(" " + jQuery(this).data("smilies") + " ");jQuery(".smilies-wrap").removeClass("is-active");return false;});});</script>';
    return $context;
}

// 输出WordPress表情
function fa_get_wpsmiliestrans(){
    global $wpsmiliestrans;
    $wpsmilies = array_unique($wpsmiliestrans);
    foreach($wpsmilies as $alt => $src_path){
        $output .= '<a class="add-smily" data-smilies="'.$alt.'"><img class="wp-smiley" src="'.get_bloginfo('template_directory').'/images/smilies/'. $src_path. '" /></a>';
    }
    return $output;
}///images/smilies/'.rtrim($src_path, "gif").'gif" /></a>';

add_action('media_buttons_context', 'fa_smilies_custom_button');



