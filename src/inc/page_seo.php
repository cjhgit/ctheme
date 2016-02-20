<?php
/**
 * SEO设置
 */
?>
<div class="wrap">
    <h2>SEO设置</h2><span>更多主题，请访问<a href="http://www.chenjianhang.com/" target="_blank">陈建杭个人博客</a></span>
    <form method="POST" action="">
    <input type="hidden" name="update_options" value="true" />
    <table class="form-table">
    <tbody>
    <tr valign="top">
    	<th scope="row"><label for="d_latest_news">网站描述</label></th>
        <td>
        <input type="input" class="large-text" name="web_desc" value="<?php echo get_option('web_desc'); ?>" />
        <p class="description">用简洁的文字描述网站，建议80-120个字。</p>
        </td>
    </tr>
     <tr valign="top">
    	<th scope="row"><label for="d_latest_news">关键词</label></th>
        <td>
        <input type="input" class="large-text" name="keywords" value="<?php echo get_option('keywords'); ?>" />
        <p class="description">多个关键词之间用英文逗号（,）分隔，建议关键词数量为3-6</p>
        </td>
    </tr>
    
    
    
    </tbody>
    </table>
    <p><input type="submit" class="button-primary" name="admin_options" value="更新数据"/></p>
    </form>
    </div>