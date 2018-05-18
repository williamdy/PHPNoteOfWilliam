<?php
	include 'conn.php';
	include 'result.php';
	include 'user.php';
	 
    define("TOKEN", "williamdy");
    
    //获取微信发送数据
    $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];    
    //返回回复数据
    if (!empty($postStr))
    {        
        //解析数据
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);       
        //发送消息方ID
        $fromUsername = $postObj->FromUserName;
       //接送消息方ID
        $toUsername = $postObj->ToUserName;       
        //消息类型
        $form_MsgType = $postObj->MsgType; 
                        
        //获取消息内容
        $form_Content = $postObj->Content;           
		
		$mediaId = $postObj->MediaId;
		
		$picUrl = $postObj->PicUrl;
		
                                                 
                
                //回复欢迎图文信息
                /*
                $resultStr = "<xml>
                                <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>
                                <FromUserName><![CDATA[".$toUsername."]]></FromUserName>
                                <CreateTime>".time()."</CreateTime>
                                <MsgType><![CDATA[news]]></MsgType>
                                <ArticleCount>2</ArticleCount>
                                <Articles>
                                    <item>
                                        <Title><![CDATA[  欢迎关注***微信服务平台，****]]></Title> 
                                        <Description><![CDATA[这是简短描述文字]]></Description>
                                       <PicUrl><![CDATA[http://a.hiphotos.baidu.com/baike/c0%3Dbaike116%2C5%2C5%2C116%2C38/sign=5cae7405f21f3a294ec5dd9cf84cd754/32fa828ba61ea8d32de5a1df950a304e241f5822.jpg]]></PicUrl>
                                        <Url><![CDATA[http://www.baidu.com]]></Url> </item>
                                    <item>
                                        <Title><![CDATA[最新动态]]></Title>
                                        <Description><![CDATA[]]></Description>
                                       <PicUrl><![CDATA[http://a.hiphotos.baidu.com/baike/c0%3Dbaike116%2C5%2C5%2C116%2C38/sign=5cae7405f21f3a294ec5dd9cf84cd754/32fa828ba61ea8d32de5a1df950a304e241f5822.jpg]]></PicUrl>
                                        <Url><![CDATA[http://www.baidu.com]]></Url> </item>
                                   
                                </Articles>
                               </xml> ";                
                */
				
				$result = new result();
				$user = new user();
				$user->con = $con;
				$user->fromUsername = $fromUsername;
				$user->toUsername = $toUsername;
                //回复欢迎文字信息  
				if($form_MsgType != "text" && $form_MsgType != "image"){
					$reply = "哎呀我滴乖乖，你发了个啥";	
					$resultStr=$result->makeresultStr($fromUsername,$toUsername,"text","$reply : $toUsername",$mediaId); 
				}   else if($form_MsgType == "image"){
					//$reply = $fromUsername."，您好，欢迎关注威廉的学习笔记，您想对我说的话是：".$form_Content;
					//图片服务
					
					$reply = $user->getStepByUserandPic($fromUsername,$form_Content,$picUrl,$mediaId);
					if($reply == ""){
						$resultStr=$result->makeresultStr($fromUsername,$toUsername,"image",$reply,$mediaId); 
					}else{
						$resultStr=$result->makeresultStr($fromUsername,$toUsername,"text",$reply,$mediaId);
					}
				}   else{
					//文字服务
					
					$reply = $user->getStepByUser($fromUsername,$form_Content);
					$resultStr=$result->makeresultStr($fromUsername,$toUsername,$form_MsgType,$reply,$mediaId);
				}
				
           
       
        echo $resultStr;
        exit; 
    }
    else
    {
        echo "";
        exit;
    }
    include 'close.php';
?>