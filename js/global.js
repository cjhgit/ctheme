// 公告滚动 公告代码放后面不行
function AutoScroll(obj) { 
	$(obj).find("ul:first").animate({ 
		marginTop:"-25px" }, 500, function() { 
			$(this).css({marginTop:"0px"}).find("li:first").appendTo(this); }); } $(document).ready(function(){ setInterval('AutoScroll("#notice")',4000) });
			
			
$(document).ready(function($) {
	
var offset = 300; // 开始显示返回顶部链接时与页面顶部的距离（像素）
var offset_opacity = 1200; // 开始隐藏返回顶部链接时与页面顶部的距离（像素）
var scroll_top_duration = 700; // 返回顶部滚动的时间(ms)
var $back_to_top = $('.cd-top'); // 返回顶部链接

// 隐藏或显示返回顶部链接
$(window).scroll(function() {
	($(this).scrollTop() > offset) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
	if ($(this).scrollTop() > offset_opacity) { 
		$back_to_top.addClass('cd-fade-out');
	}
});

// 平滑返回顶部
$back_to_top.on('click', function(event) {
	event.preventDefault();
	$('body,html').animate({
		scrollTop: 0 ,
		}, 
		scroll_top_duration
	);
});

// 导航菜单悬停
$("#nav-header").posfixed({
	distance: 0,
	pos: "top",
	type: "while",
	hide:false	// TODO 这里在false前面加一个空格会出错，原因未知
});  



var isShow = false; // 菜单是否显示

$("#mask").click(function(e) {
	$("#mask").hide(0.8);
	$('#nav').css('right', '-70%');
	isShow = false;
});

// 点击菜单按钮，显示/隐藏菜单
$("#menu-btn").click(function(e) {
	if (isShow) {
		$("#mask").hide(0.8);
		$('#nav').css('right', '-70%');
	} else {
		$("#mask").show();
		$('#nav').css('right', '0');
	}
	isShow = !isShow;
});

// 侧栏悬停（因为代码可以出问题，放在最后^_^）
//$('#sidebar').myFix();
	
// 文章顶
$.fn.postLike = function() {
	if ($(this).hasClass('done')) {
		alert('您已赞过该文章');
		return false;
	} else {
		$(this).addClass('done');
		var id = $(this).data("id"),
		action = $(this).data('action'),
		rateHolder = $(this).children('.count');
		var ajax_data = {
			action: "specs_zan",
			um_id: id,
			um_action: action
		};
		$.post("/wp-admin/admin-ajax.php", ajax_data,
		function(data) {
			$(rateHolder).html(data);
		});
		return false;
	}
};

$(document).on("click", "#post-like",
	function() {
		$(this).postLike();
});

// 文章踩

$.fn.postDislike = function() {
	if ($(this).hasClass('done')) {
		alert('您已赞过该文章');
		return false;
	} else {
		$(this).addClass('done');
		var id = $(this).data("id");
		var umAction = $(this).data('action'),
		rateHolder = $(this).children('.count');
		var ajax_data = {
			action: "specs_zan",
			um_id: id,
			um_action: umAction
		};
		$.post("/wp-admin/admin-ajax.php", ajax_data,
		function(data) {
			$(rateHolder).html(data);
		});
		return false;
	}
};

$(document).on("click", "#post-dislike",
	function() {
		$(this).postDislike();
});

// 评论顶
$.fn.commentLike = function() {
	if ($(this).hasClass('done')) {
		alert('您已发表过意见了');
		return false;
	} else {
		$(this).addClass('done');
		var id = $(this).data("id"),
		action = $(this).data('action'),
		rateHolder = $(this).children('.count');
		var ajax_data = {
			action: "specs_zan",
			um_id: id,
			um_action: action
		};
		$.post("/wp-admin/admin-ajax.php", ajax_data,
		function(data) {
			$(rateHolder).html(data);
		});
		return false;
	}
};

$(document).on("click", ".comment-like",
	function() {
		$(this).commentLike();
});

// 评论踩
$.fn.commentDislike = function() {
	if ($(this).hasClass('done')) {
		alert('您已发表过意见了');
		return false;
	} else {
		$(this).addClass('done');
		var id = $(this).data("id"),
		action = $(this).data('action'),
		rateHolder = $(this).children('.count');
		var ajax_data = {
			action: "specs_zan",
			um_id: id,
			um_action: action
		};
		$.post("/wp-admin/admin-ajax.php", ajax_data,
		function(data) {
			$(rateHolder).html(data);
		});
		return false;
	}
};

$(document).on("click", ".comment-dislike",
	function() {
		$(this).commentDislike();
});



});

// 选择表情图片
function grin(tag) {
	var myField;
	tag = ' ' + tag + ' ';
	if (document.getElementById('comment') && document.getElementById('comment').type == 'textarea') {
		myField = document.getElementById('comment');
	} else {
		return false;
	}
	if (document.selection) {
		myField.focus();
		sel = document.selection.createRange();
		sel.text = tag;
		myField.focus();
	} else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		var cursorPos = endPos;
		myField.value = myField.value.substring(0, startPos)
					  + tag
					  + myField.value.substring(endPos, myField.value.length);
		cursorPos += tag.length;
		myField.focus();
		myField.selectionStart = cursorPos;
		myField.selectionEnd = cursorPos;
	} else {
		myField.value += tag;
		myField.focus();
	}
}
;
//