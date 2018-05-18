<?php
	//名著人物
	class mz{
		public function getNextStepWords($con,$fromUsername,$step_id,$reply){
			$sql = "select * from wx_service_step where step_id = '".$step_id."' and service_id = 'mz';";
			$result = mysql_query($sql,$con);
			$s = "";
			while ($row = mysql_fetch_array($result)){
				//if(!$row['service_id']){
					$s .= " ".$row['step_id']." : ".$row['step_detail']."  .";
				//}
			}
			if($s == ""){
				$order = rand(1,4);
				//$s .= "今天白天到夜间，可惜我没看过《".$reply."》"; 
				$s = $this->getResultByKeyword($order,$con,$reply);
			}
			return $s;
		}
		
		private function getResultByKeyword($order,$con,$reply){
			$keyword = "";
			//$id = 0;
			switch($order){
				case 1:
					$keyword = "sanguo";
					//$id = rand(1,49);
					$ch = "三国";
				    break;
				case 2:
					$keyword = "xiyou";
					//$id = rand(1,45);
					$ch = "西游";
				    break;
				case 3:
					$keyword = "shuihu";
					//$id = rand(1,108);
					$ch = "水浒";
				    break;
				case 4:
					$keyword = "honglou";
					//$id = rand(1,28);
					$ch = "红楼";
				    break;
			}
			$sql = "select * from ".$keyword." order by rand() limit 1;";
			$result = mysql_query($sql,$con);
			$s = "";
			while ($row = mysql_fetch_array($result)){
				//if(!$row['service_id']){
					$s .= " 您要测的字是“".$reply."”，您在".$ch."中的人物是：".$row['name']." \n\r ".$row['detail']."  \r\n";
				//}
			}
			return $s;
		}
	}
?>