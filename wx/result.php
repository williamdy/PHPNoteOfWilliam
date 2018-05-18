<?php
	
	class result{
		
		private function is_utf8($str)
		{
			return preg_match('//u', $str);
		}
		
		public function makeresultStr($fromUsername,$toUsername,$form_MsgType,$reply,$mediaId){
						
                if($form_MsgType == "text"){
					
				if ($this->is_utf8($reply)) {
					$reply = $reply;
				} else {
					$reply = iconv('gb2312', 'UTF-8//IGNORE', $reply);
				}
				
                $resultStr="<xml>
                                <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>
                                <FromUserName><![CDATA[".$toUsername."]]></FromUserName>
                                <CreateTime>".time()."</CreateTime>
                                <MsgType><![CDATA[text]]></MsgType>
                                <Content><![CDATA[".$reply."]]></Content>
                            </xml>";     
							
				}
            
			if($form_MsgType == "image"){
				$resultStr="<xml>
                                <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>
                                <FromUserName><![CDATA[".$toUsername."]]></FromUserName>
                                <CreateTime>".time()."</CreateTime>
                                <MsgType><![CDATA[image]]></MsgType>
								 <Image>
								<MediaId><![CDATA[".$mediaId."]]></MediaId>
                                </Image>
                            </xml>"; 
				}
				return  $resultStr;
		}
	}
?>