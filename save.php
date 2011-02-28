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

if(isset($_POST['content'])) {
  $tag = 0;  
  if(isset($_POST['tag'])) {
    $tag = 1;
  }
  $clean_content = mysql_real_escape_string($_POST['content']);
  mysql_query("INSERT INTO `batf`.`batf` (`id`, `addeddatetime`, `content`,`tag`) VALUES (NULL, now(), '$clean_content',$tag);");
  echo "saved";
}
else {
  echo "failed";
}
mysql_close($link);
?>