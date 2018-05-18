<?php
	//天气预报
	class tq{
		
		private function trim_result($s){
			//$s = 'getTodayWeather&&getTodayWeather({"error":0,"status":"success","date":"2018-04-11","results":[{"currentCity":"北京","pm25":"53","index":[{"des":"建议着薄外套、开衫牛仔衫裤等服装。年老体弱者应适当添加衣物，宜着夹克衫、薄毛衣等。","tipt":"穿衣指数","title":"穿衣","zs":"较舒适"},{"des":"较适宜洗车，未来一天无雨，风力较小，擦洗一新的汽车至少能保持一天。","tipt":"洗车指数","title":"洗车","zs":"较适宜"},{"des":"各项气象条件适宜，无明显降温过程，发生感冒机率较低。","tipt":"感冒指数","title":"感冒","zs":"少发"},{"des":"天气较好，但因风力稍强，户外可选择对风力要求不高的运动，推荐您进行室内运动。","tipt":"运动指数","title":"运动","zs":"较适宜"},{"des":"属中等强度紫外线辐射天气，外出时建议涂擦SPF高于15、PA+的防晒护肤品，戴帽子、太阳镜。","tipt":"紫外线强度指数","title":"紫外线强度","zs":"中等"}],"weather_data":[{"date":"周三 04月11日 (实时：20℃)","dayPictureUrl":"http://api.map.baidu.com/images/weather/day/qing.png","nightPictureUrl":"http://api.map.baidu.com/images/weather/night/qing.png","weather":"晴","wind":"西南风3-4级","temperature":"24 ~ 9℃"},{"date":"周四","dayPictureUrl":"http://api.map.baidu.com/images/weather/day/duoyun.png","nightPictureUrl":"http://api.map.baidu.com/images/weather/night/yin.png","weather":"多云转阴","wind":"东南风微风","temperature":"21 ~ 9℃"},{"date":"周五","dayPictureUrl":"http://api.map.baidu.com/images/weather/day/xiaoyu.png","nightPictureUrl":"http://api.map.baidu.com/images/weather/night/duoyun.png","weather":"小雨转多云","wind":"南风微风","temperature":"13 ~ 6℃"},{"date":"周六","dayPictureUrl":"http://api.map.baidu.com/images/weather/day/duoyun.png","nightPictureUrl":"http://api.map.baidu.com/images/weather/night/qing.png","weather":"多云转晴","wind":"北风4-5级","temperature":"19 ~ 8℃"}]}]})';
			$s = str_replace('getTodayWeather&&getTodayWeather(', '', $s);
			$s = str_replace('})', '}', $s);
			
			$arr = json_decode($s, true);
   			$status = $arr['status'];
   			
  			if($status == 'success'){
	  
					$results = $arr['results'];
					//var_dump($results);
					 //echo "\n\r pm25";
					$pm25 = $results[0]['pm25'];
					$currentCity = $results[0]['currentCity'];
					// $pm25;
					$s = "\n\r ".$currentCity."天气：\n\r";;
					$s .= "\n\r 今日空气污染指数: $pm25 \n\r";
					$weather = $results[0]['weather_data'];
					foreach($weather as $today_weather){
						//$today_weather = $weather[0];
						$date = $today_weather['date'];
						$weather = $today_weather['weather'];
						$wind = $today_weather['wind'];
						$temperature = $today_weather['temperature'];
						$s .= " \n\r $date  \n\r $weather  \n\r $wind  \n\r $temperature  \n\r  ";
					}
   			} else {
				$s = "\n\r请输入国内城市。\n\r";
			}
			return $s;
		}
		
		public function getNextStepWords($con,$fromUsername,$step_id,$reply){
			$sql = "select * from wx_service_step where step_id = '".$step_id."' and service_id = 'tq';";
			$result = mysql_query($sql,$con);
			
			$s = "";
			while ($row = mysql_fetch_array($result)){
				//if(!$row['service_id']){
					$s .= " ".$row['step_id']." : ".$row['step_detail']."  .";
				//}
			}
			if($s == ""){
				$url = "http://api.map.baidu.com/telematics/v3/weather?output=json&ak=2f1a476314eede849926c4766fa9cad7&callback=getTodayWeather&location=";
				$url .= $reply."";
				$s .= request($url);
				$s = $this->trim_result($s);
				//$s .= "今天白天到夜间，".$reply."晴转多云，9~25度，阵风3级"; 
			//$s = 'getTodayWeather&&getTodayWeather({error:0,status:success,date:2018-04-11,results:[{currentCity:北京,pm25:53,index:[{des:建议着薄外套、开衫牛仔衫裤等服装。年老体弱者应适当添加衣物，宜着夹克衫、薄毛衣等。,tipt:穿衣指数,title:穿衣,zs:较舒适},{des:较适宜洗车，未来一天无雨，风力较小，擦洗一新的汽车至少能保持一天。,tipt:洗车指数,title:洗车,zs:较适宜},{des:各项气象条件适宜，无明显降温过程，发生感冒机率较低。,tipt:感冒指数,title:感冒,zs:少发},{des:天气较好，但因风力稍强，户外可选择对风力要求不高的运动，推荐您进行室内运动。,tipt:运动指数,title:运动,zs:较适宜},{des:属中等强度紫外线辐射天气，外出时建议涂擦SPF高于15、PA+的防晒护肤品，戴帽子、太阳镜。,tipt:紫外线强度指数,title:紫外线强度,zs:中等}],weather_data:[{date:周三 04月11日 (实时：20℃),dayPictureUrl:http://api.map.baidu.com/images/weather/day/qing.png,nightPictureUrl:http://api.map.baidu.com/images/weather/night/qing.png,weather:晴,wind:西南风3-4级,temperature:24 ~ 9℃},{date:周四,dayPictureUrl:http://api.map.baidu.com/images/weather/day/duoyun.png,nightPictureUrl:http://api.map.baidu.com/images/weather/night/yin.png,weather:多云转阴,wind:东南风微风,temperature:21 ~ 9℃},{date:周五,dayPictureUrl:http://api.map.baidu.com/images/weather/day/xiaoyu.png,nightPictureUrl:http://api.map.baidu.com/images/weather/night/duoyun.png,weather:小雨转多云,wind:南风微风,temperature:13 ~ 6℃},{date:周六,dayPictureUrl:http://api.map.baidu.com/images/weather/day/duoyun.png,nightPictureUrl:http://api.map.baidu.com/images/weather/night/qing.png,weather:多云转晴,wind:北风4-5级,temperature:19 ~ 8℃}]}]})';
			
			}
			return $s;
		}
	}
?>