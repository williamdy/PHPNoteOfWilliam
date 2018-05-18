<?php
	//鹦鹉学舌
	class yw{
		public function getywStep($fromUsername,$toUsername,$form_MsgType,$reply){
			$resultClass = new result();
			$resultStr = $resultClass->makeresultStr($fromUsername,$toUsername,$form_MsgType,$reply);
			return $resultStr;
		}
		
		public function getNextStepWords($con,$fromUsername,$step_id,$reply){
			$sql = "select * from wx_service_step where step_id = '".$step_id."' and service_id = 'yw';";
			$result = mysql_query($sql,$con);
			$s = "";
			while ($row = mysql_fetch_array($result)){
				//if(!$row['service_id']){
					$s .= " ".$row['step_id']." : ".$row['step_detail']."  .";
				//}
			}
			if($s == ""){
				$s .= "今天白天到夜间，我只会说：".$reply.""; 
			}
			return $s;
		}
	}
?>