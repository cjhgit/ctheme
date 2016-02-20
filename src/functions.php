<?php

require get_template_directory() . '/functions/index.php';



function add_title_to_avatar($avatar, $id_or_email) {
    $title = '';
    if (is_numeric($id_or_email)) {
        $id = (int) $id_or_email;
        $user = get_userdata($id);
        $title = $user ? (' title="' . $user->user_description . '"') : '';
    }
    $avatar = str_replace('<img', '<img'.$title, $avatar);
    return $avatar;
}

/**
 * 相关页面
 */
function wpdx_related_pages() { 
	$orig_post = $post;
	global $post;
	$tags = wp_get_post_tags($post->ID);
	if ($tags) {
		$tag_ids = array();
		foreach($tags as $individual_tag) {
			$tag_ids[] = $individual_tag->term_id; 
		}
		$args=array(
			'post_type' => 'page',  //检索页面类型
			'tag__in' => $tag_ids, //根据标签获取相关页面
			'post__not_in' => array($post->ID), //排除当前页面
			'posts_per_page' => 5  //显示5篇
			);
		$my_query = new WP_Query( $args );
		if ($my_query->have_posts()) {
			echo '<div id="relatedpages"><h3>相关页面</h3><ul>';
			while( $my_query->have_posts() ) {
				$my_query->the_post(); ?>

<li>
  <div class="relatedthumb"><a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>">
    <?php the_post_thumbnail('thumb'); ?>
    </a></div>
  <div class="relatedcontent">
    <h3><a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>">
      <?php the_title(); ?>
      </a></h3>
    <?php the_time('M j, Y') ?>
  </div>
</li>
<?php }
			echo '</ul></div>';
		} else { 
			echo "没有相关页面";
		}
	}
	$post = $orig_post;
	wp_reset_query(); 
}

//======分类图片==========
remove_filter('pre_term_description', 'wp_filter_kses'); // 使分类描述中支持html标签



global $texonomy_slug;
$texonomy_slug='category'; // texonomy slug
add_action($texonomy_slug.'_add_form_fields','categoryimage');
function categoryimage($taxonomy){ ?>
    <div>
    <label for="tag-image">分类图像</label>
    <input type="text" name="tag-image" id="tag-image" value="" /><br /><span>请在此输入图像URL地址。</span>
</div>
<?php script_css(); }
add_action($texonomy_slug.'_edit_form_fields','categoryimageedit');
function categoryimageedit($taxonomy){ ?>
<tr>
    <th scope="row" valign="top"><label for="tag-image">图像</label></th>
    <td><input type="text" name="tag-image" id="tag-image" value="<?php echo get_option('_category_image'.$taxonomy->term_id); ?>" /><br /><span>请在此输入图像URL地址。</span></td>
</tr>
<?php script_css(); }
function script_css(){ ?>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/category-image_thickbox.js"></script>
<link rel='stylesheet' id='thickbox-css'  href='<?php echo includes_url(); ?>js/thickbox/thickbox.css' type='text/css' media='all' />
<script type="text/javascript">
    jQuery(document).ready(function() {
    var fileInput = '';
    jQuery('#tag-image').live('click',
    function() {
        fileInput = jQuery('#tag-image');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        return false;
    });
        window.original_send_to_editor = window.send_to_editor;
    window.send_to_editor = function(html) {
        if (fileInput) {
            fileurl = jQuery('img', html).attr('src');
            if (!fileurl) {
                fileurl = jQuery(html).attr('src');
            }
            jQuery(fileInput).val(fileurl);
            tb_remove();
        } else {
            window.original_send_to_editor(html);
        }
    };
    });
</script>
<?php }
//edit_$taxonomy
add_action('edit_term','categoryimagesave');
add_action('create_term','categoryimagesave');
function categoryimagesave($term_id){
    if(isset($_POST['tag-image'])){
        if(isset($_POST['tag-image']))
            update_option('_category_image'.$term_id,$_POST['tag-image'] );
    }
}
function print_image_function(){
    $texonomy_slug='category';
    $_terms = wp_get_post_terms(get_the_ID(),$texonomy_slug);
    $_termsidlist=array();
    $result = '';
    foreach($_terms as $val){
        $result .= '<div style="float:left; margin-right:2px;"><a href="'.get_term_link($val).'"><img height="22px" title="'.$val->name.'" alt="'.$val->name.'" src="'.get_option('_category_image'.$val->term_id).'" /></a></div>';
    }
    return $result;
}
add_shortcode('print-image','print_image_function');




//=====================
/**
 * 文章模板 single.php 获取当前文章所属的分类名称
 * http://www.wpdaxue.com/get-post-category.html
 */
function get_post_category_id($post_ID){
	global $wpdb;
	$sql="SELECT `term_taxonomy_id` FROM $wpdb->term_relationships WHERE `object_id`='".$post_ID."';";
	$cat_id=$wpdb->get_results($sql); 
	foreach($cat_id as $catId){
		$output=$catId->term_taxonomy_id;
	}
	$myCatId=intval($output);//这里就获得当前文章所属分类的分类ID
	$term = get_term( $myCatId, 'taxonomy_name' );//taxonomy_name为自己定义的或者默认的
	echo $term->name;//得到当前文章所属分类的分类名称
}

//IT ？？？
function deel_avatar_default() {
    return get_bloginfo('template_directory') . '/img/default.png';
}
function timeago($ptime) {
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if ($etime < 1) return '刚刚';
    $interval = array(
        12 * 30 * 24 * 60 * 60 => '年前 (' . date('Y-m-d', $ptime) . ')',
        30 * 24 * 60 * 60 => '个月前 (' . date('m-d', $ptime) . ')',
        7 * 24 * 60 * 60 => '周前 (' . date('m-d', $ptime) . ')',
        24 * 60 * 60 => '天前',
        60 * 60 => '小时前',
        60 => '分钟前',
        1 => '秒前'
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}
 


// Auto-highslide图片灯箱
function addhighslideclass_replace ($content) {   
	global $post;
	$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
    $replacement = '<a$1href=$2$3.$4$5 class="highslide-image" onclick="return hs.expand(this);"$6>$7</a>';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}

add_filter('the_content', 'addhighslideclass_replace');



// 判断是不是手机
function is_mobile() {
    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        return false;
    } elseif ((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false  && strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') === false) // many mobile devices (all iPh, etc.)
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false ) {
            return true;
    } else {
        return false;
    }
}

// 检测百度是否收录
function baidu_check($url) {
	global $wpdb;
	$post_id = (null === $post_id) ? get_the_ID() : $post_id;
	$baidu_record  = get_post_meta($post_id, 'baidu_record', true);
	if ($baidu_record != 1) {
		$url = 'http://www.baidu.com/s?wd=' . $url;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$rs = curl_exec($curl);
		curl_close($curl);
		if (!strpos($rs, '没有找到')) {
			if ($baidu_record == 0) {
				update_post_meta($post_id, 'baidu_record', 1);
			} else {
				add_post_meta($post_id, 'baidu_record', 1, true);
			}    
			return 1;
		} else {
			if( $baidu_record == false){
				add_post_meta($post_id, 'baidu_record', 0, true);
			}    
			return 0;
		}
	} else {
		return 1;
	}
}

// 输出百度收录的html
function baidu_record() {
	if (baidu_check(get_permalink()) == 1) {
		echo '<i class="fa fa-smile-o"></i><a target="_blank" title="点击查看" rel="external nofollow" href="http://www.baidu.com/s?wd='.get_the_title().'">百度已收录</a>';
	} else {
		echo '<i class="fa fa-frown-o"></i><a style="color:red;" rel="external nofollow" title="点击提交，谢谢您！" target="_blank" href="http://zhanzhang.baidu.com/sitesubmit/index?sitename='.get_permalink().'">百度未收录</a>';
	}
}

// 禁止加载默认jq库，慎用，很容易造成插件不能用
function c_deregister_script() {
	wp_deregister_script('jquery');
}

if (!is_admin()) {
	add_action('wp_enqueue_scripts', 'c_deregister_script', 1 );
}

// 修复 WordPress 4.2-4.3简体中文版的菜单“显示选项”无法点击
function Bing_fixed_zh_CN_display_option( $translations, $text, $domain ){
	if( get_locale() == 'zh_CN' && $text == 'To add a custom link, <strong>expand the Custom Links section, enter a URL and link text, and click Add to Menu</strong>' && $domain == 'default' ) $translations = '要添加自定义链接，<strong>展开自定义链接小节，输入URL和链接文本，然后点击添加到菜单</strong>';
	return $translations;
}

add_action('gettext', 'Bing_fixed_zh_CN_display_option', 10, 3);