<?php

$con = mysql_connect("bdm313469474.my3w.com","bdm313469474","06113348");
 mysql_select_db("bdm313469474_db",$con);
 mysql_query("set names utf8");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
 
 ?>