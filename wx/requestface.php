<?php
   include 'initservice.php';
    $url2 = "http://api.avatardata.cn/Face/CheckOne?key=03c6e71c8b444a0ea63d64d93f345f33&imgUrl=";
	$url2 .= "http://f.hiphotos.baidu.com/image/pic/item/d31b0ef41bd5ad6ec8a8eee783cb39dbb6fd3c6d.jpg";
							
    $s = request($url2);		
  
  // $s = '{"result":{"id":"0688806d-eed7-4b86-8e53-787e8c042b6f","biaoti":"静夜思","jieshao":"【注释】：\r\n[1]疑：怀疑，以为。\r\n[2]举：抬、仰。\r\n\r\n【简析】：\r\n　　短短二十个字，创造了一种何等优美迷人、令人产生无限遐思的意境！作者曾有句云：「清水出芙蓉，天然去雕饰。」他的许多小诗，的确达到了这样清新自然的艺术境界。\r\n\r\n　　胡应麟说：「太白诸绝句，信口而成，所谓无意于工而无不工者。」（《诗薮·内编》卷六）王世懋认为：「（绝句）盛唐惟青莲（李白）、龙标（王昌龄）二家诣极。李更自然，故居王上。」（《艺圃撷馀》）怎样才算「自然」，才是「无意于工而无不工」呢？这首《静夜思》就是个样榜。所以胡氏特地把它提出来，说是「妙绝古今」。\r\n\r\n　　这首小诗，既没有奇特新颖的想象，更没有精工华美的辞藻；它只是用叙述的语气，写远客思乡之情，然而它却意味深长，耐人寻绎，千百年来，如此广泛地吸引着读者。\r\n\r\n　　一个作客他乡的人，大概都会有这样的感觉吧：白天倒还罢了，到了夜深人静的时候，思乡的情绪，就难免一阵阵地在心头泛起波澜；何况是月明之夜，更何况是明月如霜的秋夜！\r\n\r\n　　月白霜清，是清秋夜景；以霜色形容月光，也是古典诗歌中所经常看到的。例如梁简文帝萧纲《玄圃纳凉》诗中就有「夜月似秋霜」之句；而稍早于李白的唐代诗人张若虚在《春江花月夜》里，用「空里流霜不觉飞」来写空明澄澈的月光，给人以立体感，尤见构思之妙。可是这些都是作为一种修辞的手段而在诗中出现的。这诗的「疑是地上霜」，是叙述，而非摹形拟象的状物之辞，是诗人在特定环境中一刹那间所产生的错觉。为什么会有这样的错觉呢？不难想象，这两句所描写的是客中深夜不能成眠、短梦初回的情景。这时庭院是寂寥的，透过窗户的皎洁月光射到床前，带来了冷森森的秋宵寒意。诗人朦胧地乍一望去，在迷离恍惚的心情中，真好象是地上铺了一层白皑皑的浓霜；可是再定神一看，四周围的环境告诉他，这不是霜痕而是月色。月色不免吸引着他抬头一看，一轮娟娟素魄正挂在窗前，秋夜的太空是如此的明净！这时，他完全清醒了。\r\n\r\n　　秋月是分外光明的，然而它又是清冷的。对孤身远客来说，最容易触动旅思秋怀，使人感到客况萧条，年华易逝。凝望着月亮，也最容易使人产生遐想，想到故乡的一切，想到家里的亲人。想着，想着，头渐渐地低了下去，完全浸入于沉思之中。\r\n\r\n　　从「疑」到「举头」，从「举头」到「低头」，形象地揭示了诗人内心活动，鲜明地勾勒出一幅生动形象的月夜思乡图。\r\n\r\n　　短短四句诗，写得清新朴素，明白如话。它的内容是单纯的，但同时却又是丰富的。它是容易理解的，却又是体味不尽的。诗人所没有说的比他已经说出来的要多得多。它的构思是细致而深曲的，但却又是脱口吟成、浑然无迹的。从这里，我们不难领会到李白绝句的「自然」、「无意于工而无不工」的妙境。\r\n\r\n　　（马茂元）\r\n","zuozhe":"李白","neirong":"床前明月光，疑是地上霜。[1]\r\n举头望明月，低头思故乡。[2]\r\n"},"error_code":0,"reason":"Succes"}';
  
  
		 function trim_result($s){
			//$s = '{"total":0,"result":{"face":[{"attribute":{"age":24,"gender":"Female","becovered":null,"pose":{"tilting":4,"raise":-5,"turn":28}},"face_id":"b747e85308aa487891038055e290dba5","lefteye_opendegree":null,"righteye_opendegree":null,"mouth_opendegree":null,			"position":{"center":{"x":204.0,"y":246.0},"eye_left":{"x":308.0,"y":362.0},"eye_right":{"x":476.0,"y":359.0},"height":371.0,"width":371.0,"mouth_left":null,"mouth_right":null,"nose":null},"tip":null}],"img_height":"1000","img_id":"020-9353c8ec8d18bda1","img_width":"692"},"error_code":0,"reason":"Succes"}';
			
			
			$arr = json_decode($s, true);
   			
   			$reason = $arr['reason'];
			$total = $arr['total'];
			$index = 0;
			
  			if($reason == 'Succes'){
	  
					$results = $arr['result'];
					//var_dump($results);
					 //echo "\n\r pm25";
					$face = $results['face'];
					$attribute = $face[0]['attribute'];
					$age = $attribute['age'];
					$sex = $attribute['gender'];
					$face_id = $face[0]['face_id'];
					$s = "\n\r your sex is  ".$sex. " and your age is ".$age."\n\r";
   			} else {
				$s = "\n\r您输入的图像无法识别，请重新输入。\n\r";
			}
			return $s;
		}
  
	echo trim_result($s); 
?>