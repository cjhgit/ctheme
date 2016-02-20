QTags.addButton( 'demo', '代码演示', "[demo]", "[/demo]" );
QTags.addButton( 'zyy', '引用',  "<blockquote>", "</blockquote>\n" );//添加引用
QTags.addButton( 'hr', '横线', "<hr />\n" );//添加横线
QTags.addButton( 'sb', '上标', "<sup>","</sup>" );
QTags.addButton( 'xb', '下标', "<sub>","</sub>" );
QTags.addButton( 'shsj', '首行缩进', "&nbsp;&nbsp;" );
QTags.addButton( 'mark', '黄字', "<mark>","</mark>" );
QTags.addButton( 'g</>', '</>', "&lt;", "&gt;" );
QTags.addButton( 'ipre', '代码高亮', '<pre class="prettyprint linenums" >\n\n</pre>', "" );//添加高亮代码
QTags.addButton( 'ilinks', '链接按钮', "[dm href='']", "[/dm]" );
QTags.addButton( 'idownload', '下载按钮', "[dl href='']", "[/dl]" );
QTags.addButton( 'ikaiyuan', '开源按钮', "[gt href='']开源地址[/gt]", "" );
QTags.addButton( 'v_notice', '绿色通知', "[v_notice]", "[/v_notice]" );
QTags.addButton( 'v_error', '红色警告', "[v_error]", "[/v_error]" );
QTags.addButton( 'v_warn', '黄色错误', "[v_warn]", "[/v_warn]" );
QTags.addButton( 'v_tips', '灰色提示', "[v_tips]", "[/v_tips]" );
QTags.addButton( 'v_blue', '蓝色提示', "[v_blue]", "[/v_blue]" );
QTags.addButton( 'v_act', '蓝边文本', "[v_act]", "[/v_act]" );
QTags.addButton( 'v_organge', '橙色文本', "[v_organge]", "[/v_organge]" );
QTags.addButton( 'v_qing', '青色文本', "[v_qing]", "[/v_qing]" );
QTags.addButton( 'v_pink', '粉色文本', "[v_pink]", "[/v_pink]" );
QTags.addButton( 'gb', '绿色按钮', "[gb href='']", "[/gb]" );
QTags.addButton( 'bb', '蓝色按钮', "[bb href='']", "[/bb]" );
QTags.addButton( 'yb', '黄色按钮', "[yb href='']", "[/yb]" );
QTags.addButton( 'lhb', '透明按钮', "[lhb href='']", "[/lhb]" );
QTags.addButton( 'music', '音乐按钮', "[music]", "[/music]" );
QTags.addButton( 'video', '视频按钮', "[video]", "[/video]" );
QTags.addButton( 'collapse', '隐藏收缩', '[collapse title=""]', '[/collapse]' );
QTags.addButton( 'reply', '回复可见', "[reply]", "[/reply]" );
QTags.addButton( 'imobv', '手机可见', "[mb_view]", "[/mb_view]" );
QTags.addButton( 'ipcv', '电脑可见', "[pc_view]", "[/pc_view]" );
QTags.addButton( 'fancydl', '弹窗下载', "[fanctdl filename='这里填写文件名' filesize='这里填写文件大小' filedate='这里填写的是文件的发布日期' href='这里填写的主下载链接' filedown='这里填写的是文件的主下载名称']这里填写的文件的辅助下载链接，A标签即可！[/fanctdl]" );
QTags.addButton( 'dltable', '下载面板', '[dltable file="在此处写下文件名称" size="在这里写下文件大小"]这里留文件下载A标签链接，可以放多个链接[/dltable]' );
QTags.addButton( 'download', '单页下载', "[download]", "[/download]" );
QTags.addButton( 'nextpage', '下一页', '<!--nextpage-->', "" );

//这儿共有四对引号，分别是按钮的ID、显示名、点一下输入内容、再点一下关闭内容（此为空则一次输入全部内容），\n表示换行。