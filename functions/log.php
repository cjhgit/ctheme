<?php
// 保存日志文件至mylogs.txt
make_log_file();

function make_log_file()
{
	// log文件名
	$filename = 'mylogs.txt'; 
	// 去除rc-ajax评论以及cron机制访问记录
	if (strstr($_SERVER["REQUEST_URI"],"rc-ajax")== false 
		&& strstr($_SERVER["REQUEST_URI"],"wp-cron.php")== false ) 
	{
		$word .= date('mdHis',$_SERVER['REQUEST_TIME'] + 3600*8) . " ";
                //访问页面
		$word .= $_SERVER["REQUEST_URI"] ." ";
                //协议
		$word .= $_SERVER['SERVER_PROTOCOL'] ." ";
                //方法,POST OR GET
		$word .= $_SERVER['REQUEST_METHOD'] . " ";
		//$word .= $_SERVER['HTTP_ACCEPT'] . " ";
                //获得浏览器信息
		$word .= getbrowser(). " ";
                //传递参数
		$word .= "[". $_SERVER['QUERY_STRING'] . "] ";
                //跳转地址
		$word .= $_SERVER['HTTP_REFERER'] . " ";
                //获取IP
		$word .= getIP() . " ";
        $word .= "\n";
        $day = date('md',$_SERVER['REQUEST_TIME'] + 3600*8);    
        if (getIP() != "211.97.6.123")
		{
			if (file_exists($filename)) 
			{
				$fh = fopen($filename, "r");
				$data = fread($fh, 10);
				if(substr($data,0,4) == $day) 
					$fh = fopen($filename, "a");
				else 
					$fh = fopen($filename, "w");	//w
				fwrite($fh, $word);    
				fclose($fh);
			}
		}
		
	}
}

// 获取IP地址，网上现成代码
function getIP() //get ip address
{
	if (getenv('HTTP_CLIENT_IP')) 
	{
		$ip = getenv('HTTP_CLIENT_IP');
	} 
	else if (getenv('HTTP_X_FORWARDED_FOR')) 
	{
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	} 
	else if (getenv('REMOTE_ADDR')) 
	{
		$ip = getenv('REMOTE_ADDR');
	} 
	else 
	{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

// 获取浏览器信息，移动端，平板电脑数据还未加上。
function getbrowser()
{
	$Agent = $_SERVER['HTTP_USER_AGENT'];
	$browser = '';
	$browserver = '';

	if(ereg('Mozilla', $Agent) && ereg('Chrome', $Agent))
	{
		$temp = explode('(', $Agent);
		$Part = $temp[2];
		$temp = explode('/', $Part);
		$browserver = $temp[1];
		$temp = explode(' ', $browserver);
		$browserver = $temp[0];
		$browserver = $browserver;
		$browser = 'Chrome';
	}
	if(ereg('Mozilla', $Agent) && ereg('Firefox', $Agent))
	{
		$temp = explode('(', $Agent);
		$Part = $temp[1];
		$temp = explode('/', $Part);
		$browserver = $temp[2];
		$temp = explode(' ', $browserver);
		$browserver = $temp[0];
		$browserver = $browserver;
		$browser = 'Firefox';
	}
	if(ereg('Mozilla', $Agent) && ereg('Opera', $Agent)) 
	{
		$temp = explode('(', $Agent);
		$Part = $temp[1];
		$temp = explode(')', $Part);
		$browserver = $temp[1];
		$temp = explode(' ', $browserver);
		$browserver = $temp[2];
		$browserver = $browserver;
		$browser = 'Opera';
	}
	if(ereg('Mozilla', $Agent) && ereg('MSIE', $Agent))
	{
		$temp = explode('(', $Agent);
		$Part = $temp[1];
		$temp = explode(';', $Part);
		$Part = $temp[1];
		$temp = explode(' ', $Part);
		$browserver = $temp[2];
		$browserver = $browserver;
		$browser = 'Internet Explorer';
	}
	if($browser != '')
	{
		$browseinfo = $browser.' '.$browserver;
	} 
	else
	{
		$browseinfo = $_SERVER['HTTP_USER_AGENT'];
	}
	return $browseinfo;
}
	
// 日志文件查看	
function get_spider_log($atts) 
{
	extract(shortcode_atts(array(
    'text' => 'yes'),$atts));	// 如只需要显示圆饼图，则设置text为no即可
	$fh = fopen(site_url() ."/mylogs.txt", "r");
	$contents = "";
	while (!feof($fh))
	{
		$contents .= fread($fh, 8080);
    }
    fclose($fh);
	
	$str = "";	// 显示日志结果的html文本
	$showtime = date("md");
	if ($text == "yes") 
	{
		$str.= "当天蜘蛛爬行记录：";	
		$str.= "<div style='background-color:#33A1C9;color:white;text-align:center;'>以下为国内常用蜘蛛。</div>";
	}
	$mytmp = array();
	
	// google
	$google = 0;
	if ($text == "yes")
	{
		$str.= "<a href=http://www.google.com/bot.html target=_blank>Google Spider</a>: ";
	}
	$mytmp = show_spider_result($showtime,$contents,"Googlebot\/",$text);
	$google += $mytmp[0];
	$str.= $mytmp[1];
	$mytmp = show_spider_result($showtime,$contents,"Googlebot-Image\/",$text);
	$google += $mytmp[0];
	$str.= $mytmp[1];
	$mytmp = show_spider_result($showtime,$contents,"Googlebot-Mobile\/",$text);
	$google += $mytmp[0];
	$str.= $mytmp[1];
	$mytmp = show_spider_result($showtime,$contents,"Feedfetcher-Google",$text);
	$google += $mytmp[0];
	$str.= $mytmp[1];

	// baidu
	$baidu = 0;
	if($text == "yes")
		$str.= "<br><a href=http://www.baidu.com/search/spider.html target=_blank>Baidu Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"Baiduspider\/",$text);
	$baidu += $mytmp[0];
	$str.= $mytmp[1];
	$mytmp = show_spider_result($showtime,$contents,"Baiduspider-image",$text);
	$baidu += $mytmp[0];
	$str.= $mytmp[1];

	//bing
	$bing = 0;
	if($text == "yes")
		$str.= "<br><a href=http://www.bing.com/bingbot.htm target=_blank>bingbot Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"bingbot\/",$text);
	$bing += $mytmp[0];
	$str.= $mytmp[1];
	$mytmp = show_spider_result($showtime,$contents,"msnbot-media\/",$text);
	$bing += $mytmp[0];
	$str.= $mytmp[1];

	//sogou
	$sogou = 0;
	if($text == "yes")
		$str.= "<br><a href=http://www.sogou.com/docs/help/webmasters.htm#07 target=_blank>Sogou Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"Sogou web spider\/",$text);
	$sogou += $mytmp[0];
	$str.= $mytmp[1];

	//soso
	$soso = 0;
	if($text == "yes")
		$str.= "<br><a href=http://help.soso.com/webspider.htm target=_blank>Soso Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"Sosospider\/",$text);
	$soso += $mytmp[0];
	$str.= $mytmp[1];

	if($text == "yes")
		$str.= "<div style='background-color:#FA8072;color:white;text-align:center;'>以下为垃圾蜘蛛，可屏蔽抓取。</div>";
	//jike
	$else = 0;
	if($text == "yes")
		$str.= "<a href=http://shoulu.jike.com/spider.html target=_blank>Jike Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"JikeSpider",$text);
	$else += $mytmp[0];
	$str.= $mytmp[1];

	//easou
	if($text == "yes")
		$str.= "<br><a href=http://www.easou.com/search/spider.html target=_blank>Easou Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"EasouSpider",$text);
	$else += $mytmp[0];
	$str.= $mytmp[1];

	//yisou
	if($text == "yes")
		$str.= "<br>YisouSpider：";
	$mytmp = show_spider_result($showtime,$contents,"YisouSpider",$text);
	$else += $mytmp[0];
	$str.= $mytmp[1];

	if($text == "yes")
		$str.= "<br><a href=http://yandex.com/bots target=_blank>YandexBot Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"YandexBot\/",$text);
	$else += $mytmp[0];
	$str.= $mytmp[1];

	if($text == "yes")
		$str.= "<br><a href=http://go.mail.ru/help/robots target=_blank>Mail.RU Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"Mail.RU_Bot\/",$text);
	$else += $mytmp[0];
	$str.= $mytmp[1];

	if($text == "yes")
		$str.= "<br><a href=http://www.acoon.de/robot.asp target=_blank>AcoonBot Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"AcoonBot\/",$text);
	$else += $mytmp[0];
	$str.= $mytmp[1];

	if($text == "yes")
		$str.= "<br><a href=http://www.exabot.com/go/robot target=_blank>Exabot Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"Exabot\/",$text);
	$else += $mytmp[0];
	$str.= $mytmp[1];

	if($text == "yes")
		$str.= "<br><a href=http://www.seoprofiler.com/bot target=_blank>spbot Spider</a>: ";
	$mytmp = show_spider_result($showtime,$contents,"spbot\/",$text);
	$else += $mytmp[0];
	$str.= $mytmp[1];
	
	$str.= draw_canvas($google,$baidu,$bing,$sogou,$soso,$else); 
	return $str;
}


function show_spider_result($time,$contents,$str,$text)
{
	$count = array();
	$count[0] = preg_match_all("/".$time."\d*\s\/\S*\s.*".$str."/",$contents,$mymatches);
	if($text == "yes") {
		$str = preg_replace("{\\\/}","",$str);
		$count[1].= "<br> 蜘蛛类型=>".$str.": 爬行次数=".$count[0];
		if($count[0] >0) {
			$tmp = substr($mymatches[0][$count[0]-1],4,6);
			$tmp = substr($tmp,0,2) .":" . substr($tmp,2,2) .":" .substr($tmp,4,2) ;
			$count[1].= " 最后爬行时间：". $tmp;
		}
	}
	return $count;
}


function draw_canvas($google,$baidu,$bing,$sogou,$soso,$else){
	$tmp = $google + $baidu + $bing + $sogou + $soso + $else;
	if($tmp == 0) {
		return "<br><br>数据不足，无法生成分析图。<br><br>";
	}
	$google2 = $google*100/$tmp;
	$baidu2 = $baidu*100/$tmp;
	$bing2 = $bing*100/$tmp;
	$sogou2 = $sogou*100/$tmp;
	$soso2 = $soso*100/$tmp;
	$else2 = $else*100/$tmp;
	$str.= "<br><div style='border-top: 1px solid #e6e6e6;'><br>
	<div style='float:left;width:150px;border-width:1px;border-style:groove;padding:15px;'><b>蜘蛛爬行分析图：</b><br>";
	$str.= "日期：" . date("Y-m-d");
	$str.= "<br>蜘蛛一共爬行". $tmp . "次：<br>";
	$str.= "<li><span style='color:#33A1C9;'>google:". $google ."次(". intval($google2) ."%)</span></li>";
	$str.= "<li><span style='color:#0033ff;'>baidu:". $baidu ."次(". intval($baidu2) ."%)</span></li>";
	$str.= "<li><span style='color:#872657;'>bing:". $bing ."次(". intval($bing2) ."%)</span></li>";
	$str.= "<li><span style='color:#FF9912;'>sogou:". $sogou ."次(". intval($sogou2) ."%)</span></li>";
	$str.= "<li><span style='color:#FF6347;'>soso:". $soso ."次(". intval($soso2) ."%)</span></li>";
	$str.= "<li><span style='color:#55aa00;'>else:". $else ."次(". (100 - intval($google2) - intval($baidu2) - intval($bing2) - intval($sogou2) - intval($soso2)) ."%)</span></li></div>";
	//$str.=	"<img src = 'http://chart.apis.google.com/chart?cht=p3&chco=33A1C9,0033ff,872657,FF9912,FF6347,55aa00&chd=t:".$google2 .",".$baidu2.",".$bing2.",".$sogou2.",".$soso2.",".$else2."&chs=400x200&chl=google|baidu|bing|sogou|soso|else' />";
	$str.= "</div><br>";
	return $str;
}
add_shortcode('spiderlogs','get_spider_log');
