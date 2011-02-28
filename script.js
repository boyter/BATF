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

$(document).ready(function () {
	getversions();
	gettags();
	$("#styled").typeWatch( { highlight:false, callback:finished, wait:2000 } );
	$("#styled").change(function() {
		dirty = true;
	});
	dirty = false;
	
	var refreshId = setInterval(function() {
      getversions();
	  gettags();
    }, 5000);
	
	$('a').each(function(index) {
		$(this).click(function() {
			$(window).unbind('beforeunload');
		});
    });

	$(window).bind("beforeunload", function(e){
		if(dirty) {
		  msg = "You have unsaved changes. Are you sure that you want to close?";
		  return e.returnValue = msg; 
		}
		return true;
	});
	
	
	$('a.toggle').click(function() {
	    getversions();
	    gettags();
		if($(this).children('img').attr('src') == 'toggle.gif') {
		  $(this).children('img').attr('src','toggle2.gif');
		}
		else {
		  $(this).children('img').attr('src','toggle.gif');
		}
		$(this).next().slideToggle('fast');
	});
	
	$("#savebutton").click(function() {
	  save($('#styled').val());
	  getversions();
	});
	
	$("#tagbutton").click(function() {
	  savetag($('#styled').val());
	  gettags();
	});
	
	$("#refreshbutton").click(function() {
	  getversions();
	  gettags();
	});
	
	function finished(txt) {
  	  save(txt);
	  getversions();
	}

	function getversions() {
		$.getJSON('getversions.php', function(data) {
		  var items = [];
		  $.each(data, function(key, val) {
			items.push('<li><a href="#" onclick="window.open(\'diff.php?id='+val['id']+'&plain=1\',\'_blank\') ">Version ' + val['id'] + ' - ' + val['addeddatetime'] + '</a></li>');
		  });
		  $('ul.revs').html(items.join(''));
		});
	}
	
	function gettags() {
		$.getJSON('gettags.php', function(data) {
		  var items = [];
		  $.each(data, function(key, val) {
			items.push('<li><a href="#" onclick="window.open(\'diff.php?id='+val['id']+'&plain=1\',\'_blank\') ">Version ' + val['id'] + ' - ' + val['addeddatetime'] + '</a></li>');
		  });
		  $('ul.tags').html(items.join(''));
		});
	}
	
	function save(txt) {
	  $.post("save.php", { content: txt } );
	  dirty = false;
	}
	function savetag(txt) {
	  $.post("save.php", { content: txt,tag:1 } );
	}
});