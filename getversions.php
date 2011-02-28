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

$result = mysql_query('select id,addeddatetime from batf where tag = 0 order by addeddatetime desc limit 20;');

$res = array();
while ($row = mysql_fetch_array($result)) {
   $res[] = $row;
}
echo json_encode($res);

mysql_close($link);
?>