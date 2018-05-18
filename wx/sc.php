<?php
	//诗词大会
	class sc{
		public function getNextStepWords($con,$fromUsername,$step_id,$reply){
			$sql = "select * from wx_service_step where step_id = '".$step_id."' and service_id = 'sc';";
			$result = mysql_query($sql,$con);
			$s = "";
			while ($row = mysql_fetch_array($result)){
				//if(!$row['service_id']){
					$s .= " ".$row['step_id']." : ".$row['step_detail']."  .";
				//}
			}
			if($s == ""){
				//游戏规则
				$rule = $this->getKeyword($con,$fromUsername);
				$s = $this->getResultByKeyword($rule,$reply);
							
			}
			return $s;
		}
		
		private function getKeyword($con,$fromUsername){
			$sql = "select * from wx_service_user where user_id = '".$fromUsername."';";
			
			$result = mysql_query($sql,$con);
			$s = "";
			while ($row = mysql_fetch_array($result)){
				//if(!$row['service_id']){
					$s = $row['keyword'];
				//}
			}
			return $s;
		}
		
		private function trim_result($s,$rule,$reply){
			$arr = json_decode($s, true);
   			$reason = $arr['reason'];
			$total = $arr['total'];
			$index = 0;
			
			if($reason == "Succes" && $total > 0){
					$index = rand(0,($total-1));
					
					if($index > 19){
						$page = intval(($index+1)/20);
						$randomResult = $this->request_title($page,$reply);
						//$randomResult = preg_replace('/\[[0-9]?\]/', '', $randomResult);
						//return $page;
					}
			}
			if($reason == "Succes" && $total > 0)
			{
				$result = $arr['result'];
				switch($rule){
				case "命题":
					$s = "";
				    for($i=0;$i<=($total-1);$i++){
						if( strpos($result[$i]["name"],$reply)){
							$s = $result[$i]["id"];
						}
					}
					if($s == ""){
						$index = rand(0,($total-1));
						$s = $result[$index]["id"];
					}
				    break;
				case "对句":
					$s = $result[0]["id"];
				    break;
				case "飞花令":
				//随机返回一句含有某个字的诗句
					
				default :
				    $randomarr = json_decode($s, true);
					$result = $randomarr['result'];
				    $s = $result[(($index+1)%20 -1)]["id"];
					break;
			}
			} else {
				$s = "";
			}
			return $s;
		}
		
		private function trim_result_content($s,$rule,$reply){
			
			$arr = json_decode($s, true);
   			$reason = $arr['reason'];
			
			if($reason == "Succes"){
				$result = $arr['result'];				
				$neirong = $result['neirong'];
				$s = preg_replace('/\[[0-9]?\]/', '', $neirong);
						
				switch($rule){
				case "命题":
					
				    break;
				case "对句":
					$var=explode("\r\n",$s);
					$total = count($var);
					/*
					for($i=0;$i<=($total-1);$i++){
						
							$s = "";
							$s .= $var[$i];
						if(strpos($s,$reply)){
							
							break;
						}
					}*/
					
				    break;
				case "飞花令":
				//随机返回一句含有某个字的诗句
					$var=explode("\r\n",$s);
					$total = count($var);
					/*
					for($i=0;$i<=($total-1);$i++){
						
							$s = "";
							$s .= $var[$i];
							//return $reply;
						if(strpos($s,$reply)){
							
							break;
						}
					}*/
					break;
			}
			} else {
				$s = "";
			}
			return $s;
		}
		
		private function getResultByKeyword($rule,$reply){
			$s = "";
			$s .= $this->request_title("1",$reply);
			
			$s = $this->trim_result($s,$rule,$reply);
			
			if($s == ""){
				$s = "\n\r不好意思，未找到您期望的诗词。\n\r";
			}else{
				$url2 = "http://api.avatardata.cn/TangShiSongCi/LookUp?key=8c3d0a813b6a4ee08c48a519893458e8&id=";
				$url2 .= $s;				
				$s = request($url2);
				//$s = preg_replace('/\[[0-9]?\]/', '', $s);
				
				$s = $this->trim_result_content($s,$rule,$reply);
			}
			return $s;
		}
		
		private function request_title($page,$keyWord){
			$url1 = "http://api.avatardata.cn/TangShiSongCi/Search?key=8c3d0a813b6a4ee08c48a519893458e8";
			$url1 .= "&keyWord=".$keyWord;
			$url1 .= "&page=".$page;
			
			$s = request($url1);
			return $s;
		}
		
	}
?>