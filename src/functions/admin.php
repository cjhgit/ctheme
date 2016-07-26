<?php
/**
 * 跟管理后台相关的函数
 */

// 完全去除工具条
add_filter('show_admin_bar', '__return_false');
	
// 设置后台编辑器样式
add_editor_style('/asset/css/editor-style.css'); // TODO 常量化

// 去掉后台首页一些没用的功能
function disable_dashboard_widgets() {   
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // 近期评论 
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'normal'); // 近期草稿
    remove_meta_box('dashboard_primary', 'dashboard', 'core'); // wordpress博客  
    remove_meta_box('dashboard_secondary', 'dashboard', 'core'); // wordpress其它新闻  
    remove_meta_box('dashboard_right_now', 'dashboard', 'core'); // wordpress概况  
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'core'); // wordresss链入链接  
    remove_meta_box('dashboard_plugins', 'dashboard', 'core'); // wordpress链入插件  
    remove_meta_box('dashboard_quick_press', 'dashboard', 'core'); // wordpress快速发布   
}  

add_action('admin_menu', 'disable_dashboard_widgets');

// 小工具设置页面上方的提示文字
function widgets_info() {
	echo '<p style="clear:both;">将左边的小工具拖到右边，就可以在网站上使用了。</p>';
}

add_action('widgets_admin_page', 'widgets_info');

/** 自定义后台版权 */
function admin_footer_text () {
	echo '<div>感谢使用小C主题！如需帮助，可以到我网站留言：<a href="http://www.chenjianhang.com" target="_blank">陈建杭个人博客</a></div>';
}

add_action('admin_footer_text', 'admin_footer_text');

// 更改后台字体
function admin_style() {
    echo'<style type="text/css">
        * { font-family: "Microsoft YaHei" !important; }
        i, .ab-icon, .mce-close, i.mce-i-aligncenter, i.mce-i-alignjustify, i.mce-i-alignleft, i.mce-i-alignright, i.mce-i-blockquote, i.mce-i-bold, i.mce-i-bullist, i.mce-i-charmap, i.mce-i-forecolor, i.mce-i-fullscreen, i.mce-i-help, i.mce-i-hr, i.mce-i-indent, i.mce-i-italic, i.mce-i-link, i.mce-i-ltr, i.mce-i-numlist, i.mce-i-outdent, i.mce-i-pastetext, i.mce-i-pasteword, i.mce-i-redo, i.mce-i-removeformat, i.mce-i-spellchecker, i.mce-i-strikethrough, i.mce-i-underline, i.mce-i-undo, i.mce-i-unlink, i.mce-i-wp-media-library, i.mce-i-wp_adv, i.mce-i-wp_fullscreen, i.mce-i-wp_help, i.mce-i-wp_more, i.mce-i-wp_page, .qt-fullscreen, .star-rating .star { font-family: dashicons !important; }
        .mce-ico { font-family: tinymce, Arial !important; }
        .fa { font-family: FontAwesome !important; }
        .genericon { font-family: "Genericons" !important; }
        .appearance_page_scte-theme-editor #wpbody *, .ace_editor * { font-family: Monaco, Menlo, "Ubuntu Mono", Consolas, source-code-pro, monospace !important; }
        </style>';
}

add_action('admin_head', 'admin_style');

//===========自定义登陆界面==========

// 登录页面的LOGO图片
function login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_bloginfo('template_directory').'/images/logo.jpg) !important; }
    </style>';
}

add_action('login_head', 'login_logo');

// 登录页面的LOGO链接为首页链接
add_filter('login_headerurl', create_function(false, "return get_bloginfo('url');"));

// 登录页面的LOGO提示为网站名称
add_filter('login_headertitle', create_function(false, "return get_bloginfo('name');"));

// 在登录框添加欢迎信息
function welcome_info() {
    echo '<p>欢迎访问' . get_bloginfo('name') . '</p><br />';
}

add_action('login_form', 'welcome_info');

// 自定义底部版权信息
function copyright_info() {
    echo '<p class="copyright">Copyright © ' . get_bloginfo(name).'</p>';
}

add_action('login_footer', 'copyright_info');

// 添加自定义CSS
function login_css() {
    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_directory') . '/css/login.css" />';
}

add_action('login_head', 'login_css');

//===========编辑器增强==========

// 分页按钮
function page_button($buttons, $id) {
    if ('content' != $id)
        return $buttons;
    array_splice($buttons, 13, 0, 'wp_page');
    return $buttons;
}

add_filter('mce_buttons', 'page_button', 1, 2);

// 表格按钮
function init_button() {
   if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
      return;
   }
 
   if (get_user_option('rich_editing') == 'true') {
      add_filter('mce_external_plugins', 'add_plugin');
      add_filter('mce_buttons', 'add_button');
   }
}

function add_plugin($plugin_array) {
   $plugin_array['recentposts'] = get_template_directory_uri() . '/asset/js/editor_table.js'; // TODO 常量化
   return $plugin_array;
}

function add_button($buttons) {
   array_push($buttons, '|', 'recentposts', 'demo', 'gb','bb','yb');
   return $buttons;
}
wp_enqueue_script(
        'my_quicktags',
        get_stylesheet_directory_uri().'/asset/js/quicktags.js',
        array('quicktags')
    ); // TODO 常量化
    
	
add_action('init', 'init_button');

// 编辑文章页面添加自定义提示文字
function ct_edit_form_after_title() { ?>
    <div class="postbox">
        <h3>使用提示</h3>
        <div class="inside">
            <p>这是一段测试文字~~~</p>
        </div>
    </div>
<?php }

//add_action('edit_form_after_title', 'ct_edit_form_after_title');

//===========短代码==========

// 下载按钮
function download($atts, $content=null) {
	//extract(shortcode_atts(array("href" => 'http://'), $atts));
	return '<p><a class="download-button" href="'.$content.'" rel="external nofollow" target="_blank" title="点击查看例子"><i class="fa fa-cloud-download"></i>下载</a></p>';
}

add_shortcode("download", "download");

// demo按钮
function demo($atts, $content=null) {
	return '<p><a class="download-button" href="' . $content . '" rel="external nofollow" target="_blank" title="查看例子"><i class="fa fa-external-link"></i>例子</a></p>';
}

add_shortcode("demo", "demo");

function register_button2( $buttons ) {
   array_push( $buttons, "|", "recentposts2" );
   return $buttons;
}
function add_plugin2( $plugin_array ) {
   $plugin_array['recentposts2'] = get_template_directory_uri() . '/asset/js/editor_table.js'; // TODO 常量化
   return $plugin_array;
}
function my_recent_posts_button2() {
 
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
      return;
   }
 
   if ( get_user_option('rich_editing') == 'true' ) {
      add_filter( 'mce_external_plugins', 'add_plugin2' );
      add_filter( 'mce_buttons', 'register_button2' );
   }
 
}
add_action('init', 'my_recent_posts_button2');

// 普通按钮
function button($atts, $content=null) {
	extract(shortcode_atts(array(
      'text' => '按钮',
   ), $atts));
	return '<p><a class="download-button" href="'.$content.'" rel="external nofollow" target="_blank">' . $text . '</a></>';
}

add_shortcode("button", "button");
//add_filter('widget_text', 'do_shortcode'); // 使侧边栏小工具支持短代码
//add_filter( 'comment_text', 'do_shortcode' ); // 使评论支持短代码
//add_filter( 'the_excerpt', 'do_shortcode'); // 使摘要支持短代码

//获取所有站点分类id
function Bing_show_category() {
    global $wpdb;
    $request = "SELECT $wpdb->terms.term_id, name FROM $wpdb->terms ";
    $request.= " LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ";
    $request.= " WHERE $wpdb->term_taxonomy.taxonomy = 'category' ";
    $request.= " ORDER BY term_id asc";
    $categorys = $wpdb->get_results($request);
    foreach ($categorys as $category) { //调用菜单
        $output = '<span>' . $category->name . "=(<em>" . $category->term_id . '</em>)</span>&nbsp;&nbsp;';
        echo $output;
    }
}

