<?php
/**
 * 基本设置页面
 */
 
// 基本设置
function BaseSettings() {
	
$options = array(
	array(
        'label' => '首页公告',
        'type' => 'checkbox',
		'id' => 'show_notice',
		'desc' => '开启 【开启后，请在左边菜单选择：公告->添加公告】',
    ),
	
	array(
        'label' => '首页幻灯片',
        'type' => 'checkbox',
		'id' => 'close_slide',
		'desc' => '关闭',
    ),
	array(
        'label' => '作品展示',
        'type' => 'textarea',
		'id' => 'works_ids',
		'desc' => '作品展示页面的分类ID，ID之间用英文逗号分隔（如13,64）',
    ),
	array(
        'label' => '文章列表属性',
        'type' => 'title',
    ),
	array(
        'label' => '列表显示分类',
        'type' => 'checkbox',
		'id' => 'hide_category',
		'desc' => '关闭',
    ),
	array(
        'label' => '显示百度收录',
        'type' => 'checkbox',
		'id' => 'baidu_record',
		'desc' => '开启 【玩玩就好，感觉不准的】',
    ),
	
	
	array(
        'label' => '列表显示作者',
        'type' => 'checkbox',
		'id' => 'hide_author',
		'desc' => '关闭',
    ),
	array(
        'label' => '文章目录',
        'type' => 'checkbox',
		'id' => 'post_catalog',
		'desc' => '开启',
    ),
	array(
        'label' => '文章内容属性【文章内容页上面显示的属性】',
        'type' => 'title',
    ),
	array(
        'label' => '显示最后编辑时间',
        'type' => 'checkbox',
		'id' => 'show_edit_time',
		'desc' => '开启【开启后，如果文章的最后编辑日期与创建日期不一致，会显示“最后编辑于XXX”】',
    ),
	array(
        'label' => '显示评论',
        'type' => 'checkbox',
		'id' => 'content_show_comment',
		'desc' => '开启',
    ),
	array(
        'label' => '文章二维码',
        'type' => 'checkbox',
		'id' => 'show_qrcode',
		'desc' => '开启 【开启后，用户可以扫描二维码在手机看文章。会耗一点点性能，如果不是必须的，就不要开启】',
    ),
	array(
        'label' => '版权相关',
        'type' => 'title',
    ),
	array(
        'label' => '禁止复制',
        'type' => 'checkbox',
		'id' => 'prevent_copy',
		'desc' => '开启 【开启后用户无法复制网站上的内容，可选择文字，但复制不成功】',
    ),
	array(
        'label' => '复制弹窗提示',
        'type' => 'checkbox',
		'id' => 'copy_tip',
		'desc' => '开启 【开启后，复制之后会弹窗提示。开启时应该关闭“禁止复制”选项】',
    ),
	array(
        'label' => '页脚版权信息',
        'type' => 'textarea',
		'id' => 'copyright',
		'desc' => '如：Copyright © 2015-2016 陈建杭',
    ),
	array(
        'label' => '其他',
        'type' => 'title',
    ),
	array(
        'label' => '图片延迟加载',
        'type' => 'checkbox',
		'id' => 'close_lazy',
		'desc' => '关闭 【除非是图片站点，否则不建议关闭】',
    ),
	array(
        'label' => '网站图标',
        'type' => 'textarea',
		'id' => 'web_shortcut_icon',
		'desc' => '网站图标地址。浏览器中地址栏左侧显示的图标，一般大小为16x16，后缀名为.icon。如果不设置，默认图标是网站根目录下的favicon.ico。',
    ),
	array(
        'label' => '网站图标',
        'type' => 'textarea',
		'id' => 'web_icon',
		'desc' => '网站图标地址。格式可为PNG\GIF\JPEG，尺寸一般为16x16、24x24、36x36等。不设置也无所谓。',
    ),
);

	if ($_POST['update_options']=='true') {
		
		
		// 数据更新验证
		foreach ($options as $opt) {
			if ($opt['type'] == 'checkbox') {
				$display = $_POST[$opt['id']] == 'on' ? true : false;
				update_option($opt['id'], $display);
			} else if ($opt['type'] == 'title') {
				// do nothing
			} else {
				update_option($opt['id'], $_POST[$opt['id']]);	
			}
		}

		update_option('select-demo', $_POST['select-demo']); //select

		echo SuccessInfo;
	}
	
	
	
	
	
	
	
	
	
	
	?>
	
<div class="wrap">
    <h2>基本设置</h2><span>更多主题，请访问<a href="http://www.chenjianhang.com/" target="_blank">陈建杭个人博客</a></span>
    <br/>
    <br/>
    <?php 
	if (function_exists('mail')) { 
		echo "您的主机/空间支持mail()函数^_^"; 
	} else {
		echo "您的主机/空间不支持mail()函数！"; 
	}
	?>
    <br/>
    <br/>
    <?php echo Bing_show_category(); ?>
	
    
    <form method="POST" action="">
    <input type="hidden" name="update_options" value="true" />
    <table class="form-table">
    <tbody>
    
    
    <?php
	outputHtml($options);
	?>

    <tr valign="top">
        <th scope="row"><label>下拉列表(Select)示例</label></th>
        <td><select name ="select-demo">
        <?php $colour = get_option('select-demo'); ?>
        <option value="gray" <?php if ($colour=='gray') { echo 'selected'; } ?>>灰色</option>
        <option value="blue" <?php if ($colour=='blue') { echo 'selected'; } ?>>浅蓝</option>
        </select></td>
    </tr>
    
   
    </tbody>
    </table>
    <p><input type="submit" class="button-primary" name="admin_options" value="更新数据"/></p>
    </form>
    </div>	
	
	
	
	
	
	
	
	
	
	<?php

	add_action('admin_menu', 'BaseSettings');
}
?>

