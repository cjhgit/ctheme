<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>在线工具</title>
    <link rel="stylesheet" href="http://apps.bdimg.com/libs/bootstrap/3.2.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/asset/code/css/codemirror.min.css"/>
    <link rel="stylesheet" href="/asset/code/css/index.css"/>


    <style>

    </style>
</head>
<body>
<div class="container" style="width:100%;height:100%; font-size:12px;">
    <div class="row" style="background-color: #e5eecc;">
        <div class="panel panel-default" style="margin-bottom:0;">
            <div class="panel-body" style="background-color: #e5eecc;border-color: #e5eecc;">
                <form autocomplete="off" role="form">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row-fluid">
                                <label class="inline"><strong style="font-size: 16px;color:#617f10;">
                                    源代码:</strong></label>
                                <input id="submitBTN" class="btn btn-success btn-xs pull-right" type="button"
                                       value="提交运行(Ctrl+Enter)">
                                <input type="hidden" id="bt" name="bt">
                                <input type="hidden" name="code" id="code">
                            </div>
                            <textarea class="form-control" id="textareaCode" name="textareaCode" style="display: none;"><?php
  while ( have_posts() ) : the_post(); ?><?php the_content(); ?><?php endwhile; // 循环结束 ?></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label><strong style="font-size: 16px;color:#617f10;"> 运行结果：</strong></label>

                            <div id="iframewrapper">
                                <iframe frameborder="0" id="iframeResult"></iframe>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/asset/code/js/codemirror.min.js"></script>
<script src="/asset/code/js/htmlmixed.js"></script>
<script src="/asset/code/js/css.js"></script>
<script src="/asset/code/js/javascript.js"></script>
<script src="/asset/code/js/xml.js"></script>
<script src="/asset/code/js/closetag.js"></script>
<script src="/asset/code/js/closebrackets.js"></script>
<!--[if lt IE 9]>
<script src="http://apps.bdimg.com/libs/html5shiv/3.7/html5shiv.min.js"></script>
<![endif]-->
<script>
    // Define an extended mixed-mode that understands vbscript and
    // leaves mustache/handlebars embedded templates in html mode
    var mixedMode = {
        name: "htmlmixed",
        scriptTypes: [{
            matches: /\/x-handlebars-template|\/x-mustache/i,
            mode: null
        },
            {
                matches: /(text|application)\/(x-)?vb(a|script)/i,
                mode: "vbscript"
            }]
    };
    var editor = CodeMirror.fromTextArea(document.getElementById("textareaCode"), {
        mode: mixedMode,
        selectionPointer: true,
        lineNumbers: false,
        matchBrackets: true,
        indentUnit: 4,
        indentWithTabs: true
    });

    function submitTryit() {
        var text = editor.getValue();
        var patternBody = /<body[^>]*>((.|[\n\r])*)<\/body>/im;
        var array_matches_body = patternBody.exec(text);
        basepath = '<base href="http://www.runoob.com/try/demo_source/" target="_blank">';
        if (array_matches_body) {
            text = text.replace('<body>', '<body>' + basepath);
        } else {
            text = basepath + text;
        }
        var ifr = document.createElement("iframe");
        ifr.setAttribute("frameborder", "0");
        ifr.setAttribute("id", "iframeResult");
        document.getElementById("iframewrapper").innerHTML = "";
        document.getElementById("iframewrapper").appendChild(ifr);

        var ifrw = (ifr.contentWindow) ? ifr.contentWindow : (ifr.contentDocument.document) ? ifr.contentDocument.document : ifr.contentDocument;
        ifrw.document.open();
        ifrw.document.write(text);
        ifrw.document.close();
    }
    submitTryit();
    document.getElementById('submitBTN').onclick = submitTryit;
    document.onkeydown = function(e) {
        if (e.ctrlKey && e.which == 13) {
            submitTryit();
        }
    }
</script>
</body>
</html>