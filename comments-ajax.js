var i = 0,
got = -1,
len = document.getElementsByTagName('script').length;
while (i <= len && got == -1) {
	var js_url = document.getElementsByTagName('script')[i].src,
	got = js_url.indexOf('comments-ajax.js');
	i++; 
}
var edit_mode = '1',// 再编辑模式 ( '1'=开; '0'=关 )
ajax_php_url = js_url.replace('-ajax.js', '-ajax.php'),
txt1 = '<div id="ajax_loading">正在提交，请稍候...</div>',
txt2 = '<div id="ajax_error"></div>',
txt3 = '"<div id="ajax_success">提交成功',
edt1 = ', 刷新页面之前可以<a rel="nofollow" class="comment-reply-link" href="#edit" onclick=\'return addComment.moveForm("',
edt2 = ')\'> [ 再次编辑 ]</a></div>',
cancel_edit = '取消编辑',
edit,
num = 1,
comm_array = [];
comm_array.push('');

jQuery(document).ready(function($) {
	$comments = $('#comments-title'); // 评论数的ID
	$cancel = $('#cancel-comment-reply-link');
	cancel_text = $cancel.text();
	$submit = $('#commentform #submit');
	$submit.attr('disabled', false);
	$('#comment').after(txt1 + txt2);
	$('#ajax_loading').hide();
	$('#ajax_error').hide();
	$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');

	$('#commentform').submit(function() {
		$('#ajax_loading').slideDown();
		$submit.attr('disabled', true).fadeTo('slow', 0.5);
		if (edit) $('#comment').after('<input type="text" name="edit_id" id="edit_id" value="' + edit + '" style="display:none;" />');

		$.ajax({
			url: ajax_php_url,
			data: $(this).serialize(),
			type: $(this).attr('method'),
			error: function(request) {
				$('#ajax_loading').slideUp();
				
				$('#it').slideDown().html(request.responseText);
				setTimeout(function() {
					$submit.attr('disabled', false).fadeTo('slow', 1);
					$('#ajax_error').slideUp();
				},
				3000);
			},

			success: function(data) {
				$('#ajax_loading').hide();
				comm_array.push($('#comment').val());
				$('textarea').each(function() {
					this.value = ''
				});
				var t = addComment,
				cancel = t.I('cancel-comment-reply-link'),
				temp = t.I('wp-temp-form-div'),
				respond = t.I(t.respondId),
				post = t.I('comment_post_ID').value,
				parent = t.I('comment_parent').value;

				if (!edit && $comments.length) {
					n = parseInt($comments.text().match(/\d+/));
					$comments.text($comments.text().replace(n, n + 1));
				}

				new_htm = '" id="new_comm_' + num + '"></';
				new_htm = (parent == '0') ? ('\n<ul class="comment-list' + new_htm + 'ul>') : ('\n<ol class="children' + new_htm + 'ol>');

				ok_htm = '\n<span id="success_' + num + txt3;
				if (edit_mode == '1') {
					div_ = (document.body.innerHTML.indexOf('div-comment-') == -1) ? '': ((document.body.innerHTML.indexOf('li-comment-') == -1) ? 'div-': '');
					ok_htm = ok_htm.concat(edt1, div_, 'comment-', parent, '", "', parent, '", "respond", "', post, '", ', num, edt2);
				}
				ok_htm += '</span><span></span>\n';

				$('#respond').before(new_htm);
				$('#new_comm_' + num).hide().append(data);
				$('#new_comm_' + num + ' li').append(ok_htm);
				$('#new_comm_' + num).fadeIn(4000);

				$body.animate({
					scrollTop: $('#new_comm_' + num).offset().top - 200
				},
				900);
				countdown();
				num++;
				edit = '';
				$('*').remove('#edit_id');
				cancel.style.display = 'none';
				cancel.onclick = null;
				t.I('comment_parent').value = '0';
				if (temp && respond) {
					temp.parentNode.insertBefore(respond, temp);
					temp.parentNode.removeChild(temp)
				}
			}
		});
		return false;
	});
	addComment = {
		moveForm: function(commId, parentId, respondId, postId, num) {
			var t = this,
			div, comm = t.I(commId),
			respond = t.I(respondId),
			cancel = t.I('cancel-comment-reply-link'),
			parent = t.I('comment_parent'),
			post = t.I('comment_post_ID');
			if (edit) exit_prev_edit();
			num ? (
			t.I('comment').value = comm_array[num], edit = t.I('new_comm_' + num).innerHTML.match(/(comment-)(\d+)/)[2], $new_sucs = $('#success_' + num), $new_sucs.hide(), $new_comm = $('#new_comm_' + num), $new_comm.hide(), $cancel.text(cancel_edit)) : $cancel.text(cancel_text);

			t.respondId = respondId;
			postId = postId || false;

			if (!t.I('wp-temp-form-div')) {
				div = document.createElement('div');
				div.id = 'wp-temp-form-div';
				div.style.display = 'none';
				respond.parentNode.insertBefore(div, respond)
			}

			! comm ? (
			temp = t.I('wp-temp-form-div'), t.I('comment_parent').value = '0', temp.parentNode.insertBefore(respond, temp), temp.parentNode.removeChild(temp)) : comm.parentNode.insertBefore(respond, comm.nextSibling);

			$body.animate({
				scrollTop: $('#respond').offset().top - 180
			},
			400);

			if (post && postId) post.value = postId;
			parent.value = parentId;
			cancel.style.display = '';

			cancel.onclick = function() {
				if (edit) exit_prev_edit();
				var t = addComment,
				temp = t.I('wp-temp-form-div'),
				respond = t.I(t.respondId);

				t.I('comment_parent').value = '0';
				if (temp && respond) {
					temp.parentNode.insertBefore(respond, temp);
					temp.parentNode.removeChild(temp);
				}
				this.style.display = 'none';
				this.onclick = null;
				return false;
			};

			try {
				t.I('comment').focus();
			}
			catch(e) {}

			return false;
		},

		I: function(e) {
			return document.getElementById(e);
		}
	};
	function exit_prev_edit() {
		$new_comm.show();
		$new_sucs.show();
		$('textarea').each(function() {
			this.value = ''
		});
		edit = '';
	}

	var wait = 30,
	submit_val = $submit.val();
	function countdown() {
		if (wait > 0) {
			$submit.val(wait + " 秒以后可以发表新评论");
			wait--;
			setTimeout(countdown, 1000);
		} else {
			$submit.val(submit_val).attr('disabled', false).fadeTo('slow', 1);
			wait = 15;
		}
	}

});
