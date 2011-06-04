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
var dirty = false;
$(document).ready(function () {
	getversions();
	gettags();
	$("#styled").typeWatch( { highlight:false, callback:finished, wait:2000 } );
	$("#styled").change(function() {
		dirty = true;
	});
	
	$('#styled').live('keydown', function(e) { 
		var keyCode = e.keyCode || e.which; 
		if (keyCode == 9) { 
			e.preventDefault();
			$(this).insertAtCaret('    ');
		} 
	});
	
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
		if(dirty == true) {
		  msg = "You have unsaved changes. Are you sure that you want to close?";
		  return e.returnValue = msg; 
		}
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
	
	$.fn.insertAtCaret = function (tagName) {
		return this.each(function(){
			if (document.selection) {
				//IE support
				this.focus();
				sel = document.selection.createRange();
				sel.text = tagName;
				this.focus();
			}else if (this.selectionStart || this.selectionStart == '0') {
				//MOZILLA/NETSCAPE support
				startPos = this.selectionStart;
				endPos = this.selectionEnd;
				scrollTop = this.scrollTop;
				this.value = this.value.substring(0, startPos) + tagName + this.value.substring(endPos,this.value.length);
				this.focus();
				this.selectionStart = startPos + tagName.length;
				this.selectionEnd = startPos + tagName.length;
				this.scrollTop = scrollTop;
			} else {
				this.value += tagName;
				this.focus();
			}
		});
	};
});