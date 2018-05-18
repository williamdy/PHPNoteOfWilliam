<?php
    //service 初始化
			
	include 'tq.php';		
	include 'sc.php';		
	include 'mz.php';		
	include 'yw.php';		
	include 'face.php';
	
	function request($url){
	
		//return "request ".$url;
		//初始化一个 cURL 对象
		$ch  = curl_init();
		//设置你需要抓取的URL
		curl_setopt($ch, CURLOPT_URL, $url);
		// 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//是否获得跳转后的页面
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$data = curl_exec($ch);
		curl_close($ch);
		//return $url;
		return  "".$data;
	}
?>