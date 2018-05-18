<?php
	include 'initservice.php';
	
	class user{
		
		public $toUsername;
		public $con;
		public $fromUsername;
				
		public function getStep0($con){
			$sql = "select * from wx_service;";
			
			$result = mysql_query($sql,$con);
			$s = "请输入字母简写选择服务:";
			while ($row = mysql_fetch_array($result)){
				
					$s .= " \n\r".$row['service_id']." : ".$row['service_name']."  ;";
				
			}
			
			return $s;
		}
		
		public function checkServiceValid($reply,$con){
			
			$servicename = "";
						
			$checksql = "select * from wx_service;";
			
			$checkresult = mysql_query($checksql,$con);
			
			while ($checkrow = mysql_fetch_array($checkresult)){
				
					if($checkrow['service_id'] == $reply){
						$servicename .= $checkrow['service_name'];
						break;
					}
				
			}
			
			return $servicename;
		}
		
		/***
		*@depressed
		***/
		public function getStep0_ ($con){
			
			$s = "请输入字母简写选择服务:\n\r 1.tq-天气预报 "
			     ."\n\r 2.sc-诗词大会  \n\r"
			     ."\n\r 3.mz-名著人物  "
			     ."\n\r 4.yw-鹦鹉学舌  ";
			
			
			return $s;
		}
		
		/***
		   *用户第一次使用，没有数据的时候插入0
		   */
		public function setStep0($con,$fromUsername){
			
			$sql = "insert into wx_service_user (service_id,user_id,step_id) values ('"."yw"."','".$fromUsername."','"."0"."') ;";
			
			$result = mysql_query($sql,$con);
						
			return $s;
		}
		
		public function updateStep($con,$fromUsername,$step_id,$service_id){
			$sql = "update wx_service_user set step_id = '".$step_id."' ,service_id = '".$service_id."' where user_id = '".$fromUsername."' ;";
			
			$result = mysql_query($sql,$con);
		}
		
		public function updateKeyword($con,$fromUsername,$step_id,$service_id,$keyword){
			$sql = "update wx_service_user set step_id = '".$step_id."' ,service_id = '".$service_id."' ,keyword = '".$keyword."' where user_id = '".$fromUsername."' ;";
			
			$result = mysql_query($sql,$con);
		}
		
		
		//根据用户所在游戏的状态，得到输出，并更新数据库step加1
		public function getStepByUser($fromUsername,$reply){
		
			if($reply == "bye"){
				$this->updateStep($this->con,$fromUsername,0,"yw");
				return "bye";
			}
			$sql = "select * from wx_service_user where user_id = '".$fromUsername."';";
			
			$result = mysql_query($sql,$this->con);
			$s = "";
			$step = 0;
			//用户第一次使用，没有数据的时候插入0
			//有step0记录的用户，如指定service，调用service的类打印回复,并且更新step为1
			//如果用户输入bye则更新step为0
			while ($row = mysql_fetch_array($result)){
				
				if($row['step_id'] == '0'){
				//step0 下一步 更新service和step
					$this->updateStep($this->con,$fromUsername,1,$row['service_id']);
				//返回step1的words
					return $this->getStep0($this->con);
				} else if($row['step_id'] == '1'){
					$servicename = $this->checkServiceValid($reply,$this->con);
					if($servicename != ""){
						$this->updateStep($this->con,$fromUsername,2,$reply);
						return "欢迎访问 ".$servicename ."，回复任意字符继续，回复bye退出";
					} else {
						//非法输入
						return "欢迎访问， ".$reply."是非法输入哦 \r\n".$this->getStep0($this->con);
					}
				//stepx 下一步 更新step
					
				//返回step1的words
					
				//返回stepx+1的words
				} else {
					//如果名著和诗词需要step3的keyword
					if($row['step_id'] == '3'){
						$this->updateKeyword($this->con,$fromUsername,$row['step_id']+1,$row['service_id'],$reply);
					}else{
						$this->updateStep($this->con,$fromUsername,$row['step_id']+1,$row['service_id']);
					}
					$serviceClass = new $row['service_id']();
					 $s = $serviceClass->getNextStepWords($this->con,$fromUsername,($row['step_id']-1),$reply);
					 //if($s == ""){
						$s .= "\r\n 谢谢您的使用，回复bye退出服务";
					//}
					return $s;
					//return "欢迎访问 ".$row['service_id'] .": step".($row['step_id']+1);
				}
				$step ++;
			}
			if(step == 0){
				$this->setStep0($this->con,$fromUsername);
				return $this->getStep0($this->con);
			}
		}
		
		//根据用户所在游戏的状态，得到输出，并更新数据库step加1
		//图片针对  yw和face特殊处理
		public function getStepByUserandPic($fromUsername,$reply,$picUrl,$mediaId){
			$sql = "select * from wx_service_user where user_id = '".$fromUsername."';";
			$result = mysql_query($sql,$this->con);
			$s = "";
			$step = 0;
			//用户第一次使用，没有数据的时候插入0
			//有step0记录的用户，如指定service，调用service的类打印回复,并且更新step为1
			//如果用户输入bye则更新step为0
			
			while ($row = mysql_fetch_array($result)){
				
				if($row['step_id'] == '0' || $row['step_id'] == '1'){
				//step0 下一步 更新service和step
					$this->updateStep($this->con,$fromUsername,1,$row['service_id']);
				//返回step1的words
					return $this->getStep0($this->con);
				}
				
				$serviceClass = new $row['service_id']();
				if($row['service_id'] == 'face'){
					$s = $serviceClass->getNextStepWords($this->con,$fromUsername,($row['step_id']-1),$picUrl);
					$s .= "\r\n 谢谢您的使用，回复bye退出服务";	 
					$step ++;
				} else if($row['service_id'] == 'yw' && $row['step_id'] > '2'){
					return "";
				} else {
					// $s = $serviceClass->getNextStepWords($this->con,$fromUsername,($row['step_id']-1),"");
					 $s = $this->getStepByUser($fromUsername,"");
					 
					 $step ++;
				}		
				
			}		
			
			return $s;		
		}
		
		public function setStepByUser($fromUsername){
			
		}
		
		
	}
?>