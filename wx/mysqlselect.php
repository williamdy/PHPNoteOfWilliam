<?php
$tb_name = $_GET['tbname'];
$col = array();
$i = 0;
$sql = "SELECT * from  ".$tb_name." ;";


include 'conn.php';

$result = mysql_query($sql,$con);
if ($result)
  {
	echo "record query";
	$count = 0;
	echo "<table border = '1'>";
	while ($row = mysql_fetch_array($result)){
		$title = "<tr>";
		foreach($row as $k => $v){
			if($count === 0){
				$title .= "<td>".$k."</td>";
			}
			$content .= "<td>".$v."</td>";
		}
		if($count !== 0){
			$title = "";
		}else{
			$title .= "</tr>";
		}
		$content = "<tr>".$content."</tr>";
		echo $title;
		echo $content;
		$count++;
	}
	
  }
else
  {
	echo "Error query record: " . mysql_error();
  }

mysql_close($con);
?>