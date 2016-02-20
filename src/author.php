<?php
/**
 * 作者模板（功能未实现）
 */
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>陈建杭的博客 - 网页设计-网站制作</title>
<meta name="keywords" content="" />
<!--
添加订阅feed链接，在header.php页面 <head> 标签中添加：
-->
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有文章" href="http://www.chenjianhang.com/feed/" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有评论" href="http://www.chenjianhang.com/comments/feed/" />
<link rel="stylesheet" href="http://www.chenjianhang.com/wp-content/themes/Aurelius/style/common.css" />
<link rel="stylesheet" href="http://www.chenjianhang.com/wp-content/themes/Aurelius/style/index.css" />
<style>
.info {
	padding: 10px;
	background: #FFF;
	border: #e1e1e1 solid 1px;
	border-radius: 5px;}
.info p {
	line-height: 30px;}
</style>
</head>

<body>
<div class="wrap">
<!---->
<?php get_header(); ?>
<!---->
<div class="content">
	<div class="content-main">
    	<div class="main">
        	
            <div class="info">
                <h2>关于我</h2>
                <p>姓名：陈建杭<p>
                <p>性别：男<p>
                <p>介绍：1993年made in Chine，长174cm, 净重50+kg，广东第二师范学院2013届本科生，软件工程专业，暂未毕业。</p>
                <p>QQ：1418503647</p>
                <p>电话：1110100001111101110010000000100011 （嘿嘿）</p>
                <h2>我的技能</h2>
                <p>0.熟悉安卓开发，能够独立开发小型安卓项目。</p>
                <p>1.熟悉html/css，会点jquery，将来准备学bootstrap。</p>
                <p>2.正在学wordpress开发。</p>
                <p>3.看得懂、会用C#、C++，但没做过相关语言的项目。</p>
				<p>4.会点java web。</p>
                <p>5.好吧你竟然看到这里了，真的没有了……</p>
                <h2>我的作品</h2>
                <p>暂无。。。</p>
            </div>
           
        </div>
    	 <?php get_sidebar(); ?>
        
    </div>

</div>
<!---->
<?php get_footer(); ?>
<!---->
</div>
<div class="dandelion">
    <span class="smalldan"></span>
    <span class="bigdan"></span>
</div>
<script src="http://www.chenjianhang.com/resource/js/jquery-1.8.2.min.js"></script>
<script src="http://www.chenjianhang.com/resource/js/navfix.js"></script>
<script>
$(document).ready(function(e) {
	$('#nav').navfix(0,999);    
});
</script>
</body>
</html>