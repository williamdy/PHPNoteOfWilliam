<?php
	 include 'result.php';
	 include 'user.php';
	 
$toUsername = 'gh_fb11541106a2';
$fromUsername = 'oEX6q0kDjx-2sR4s0NhhaWuJke8c';
$form_MsgType = 'text';
$mediaId = '';
$form_Content = 'mz';


$tb_name = $_GET['tbname'];
$col = array();
$i = 0;
$sql = "SELECT * from  ".$tb_name." ;";


$con = mysql_connect("bdm313469474.my3w.com","bdm313469474","06113348");
mysql_select_db("bdm313469474_db",$con);
if (!$con)
  {
	die('Could not connect: ' . mysql_error());
  }

  $result = new result();
                //回复欢迎文字信息  
				$reply = "";
				if($form_MsgType != "text" && $form_MsgType != "image"){
					$reply = "哎呀我滴乖乖，你发了个啥";	
					$resultStr=$result->makeresultStr($fromUsername,$toUsername,"text","$reply : $toUsername",$mediaId); 
				}   else if($form_MsgType == "image"){
					$reply = $fromUsername."，您好，欢迎关注威廉的学习笔记，您想对我说的话是：".$form_Content;
					$resultStr=$result->makeresultStr($fromUsername,$toUsername,$form_MsgType,$reply,$mediaId); 
				}   else{
					$user = new user();
					$user->con = $con;
					$user->fromUsername = $fromUsername;
					$user->toUsername = $toUsername;
					$reply = $user->getStepByUser($fromUsername,$form_Content);
					$resultStr=$result->makeresultStr($fromUsername,$toUsername,$form_MsgType,$reply,$mediaId);
				}
				
           
       
        echo $reply;
  
mysql_close($con);
?>