<?php
/*
Copyright 2011 Ben Boyter
This program is distributed under the terms of the GNU General Public License
 
This file is part of BATF.

BATF is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

BATF is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with BATF.  If not, see <http://www.gnu.org/licenses/>.
*/

include_once('config.php');
include_once('difffunction.php');

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
  $result = mysql_query("select id,addeddatetime,content from batf order by addeddatetime desc limit 1;");
  $res = array();
  while ($row = mysql_fetch_array($result)) {
    $res = $row;
  }

  $id = mysql_real_escape_string($_GET['id']);
  $result2 = mysql_query("select id,addeddatetime,content from batf where id = $id limit 1;");
  
  $res2 = array();
  while ($row = mysql_fetch_array($result2)) {
    $res2 = $row;
  }
  $maxid = $res['id'];

  if(!isset($_GET['plain'])) {
    $content = nl2br(htmlDiff($res2['content'],$res['content']));
  }
  else {
    $content = nl2br($res2['content']);
  }
}

mysql_close($link);
?>
<html>
<head>
<title>diff view</title>
<style type="text/css">
body { font-family: "Courier New", Courier, monospace; }
del { color: red; }
ins { color: green; }
.box { border:1px solid grey; background: url('grey.png'); float:right; position:fixed; top:1%; right:1%; padding:3px;}
img { border: 0 none; }
</style>
</head>
<body>
<div class="box">
<a href="diff.php?id=<?php echo $id ?>&plain=1"><img src="text_align_left.png" alt="Plain"></a> <a href="diff.php?id=<?php echo $id ?>"><img src="arrow_divide.png" alt="Diff"></a>
<?php if ($id != 1) { ?><a href="diff.php?id=<?php echo $id > 1 ? $id-1 : $id;  ?><?php echo isset($_GET['plain']) ? '&plain=1' : '';?>"><img src="arrow_left.png" alt="previous"></a><?php } ?> <?php if ($id != $maxid) { ?><a href="diff.php?id=<?php echo $id < $maxid ? $id+1 : $id; ?><?php echo isset($_GET['plain']) ? '&plain=1' : '';?>"><img src="arrow_right.png" alt="next"></a><?php } ?>
</div>
<br>
<?php echo str_replace('  ','&nbsp;&nbsp;',$content); ?>
</body>
</html>

