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

$result = mysql_query('select content from batf order by addeddatetime desc limit 1;');
$content = '';
while ($row = mysql_fetch_array($result)) {
  $content = $row['content'];
}
mysql_close($link);
?>
<html>
<title>BATF</title>
<style type="text/css">
textarea#styled { width: 100%; height: 100%; border: 3px solid #cccccc; padding: 5px; font-family: "Courier New", Courier, monospace; }
table#full { width: 100%; height: 100%; }
ul.revs, ul.tags { display:none; margin-top:10px;font-size:xx-small; background: white;}
img { border: 0 none; }
</style>
<script src="jquery.js" type="text/javascript"></script>
<script src="typewatch.js" type="text/javascript"></script>
<script src="dateFormat.js" type="text/javascript"></script>
<script src="script.js" type="text/javascript"></script>
<body>
<table id="full">
<tr>
<td valign="top" width="20%">
<a href="."><img src="batf.png" /></a><!--<a href="#" id="savebutton" alt="save"><img src="disk.png" alt="tag" /></a>--><a href="#" id="tagbutton"><img src="tag_blue_add.png" /></a> <!--<a href="#" id="refreshbutton"><img src="arrow_refresh.png" /></a>--><br />
versions <a class="toggle" href="#"><img src="toggle.gif"></a>
	<ul class="revs">
	</ul>
	<br>
tags <a class="toggle" href="#"><img src="toggle.gif"></a>
	<ul class="tags">
	</ul>	
</td>
<td>
<textarea id="styled">
<?php echo $content; ?>
</textarea>
</td>
</tr>
</table>
</body>
</html>