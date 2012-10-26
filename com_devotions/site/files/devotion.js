(function () {
var img = new Image();
img.src = '/components/com_devotions/files/loading.gif';

function include_js(url, callback) {  // http://www.nczonline.net
    var script = document.createElement("script");
    script.type = "text/javascript";
	
    if (script.readyState) {  //IE
        script.onreadystatechange = function(){
            if (script.readyState == "loaded" || script.readyState == "complete"){
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {  //Others
        script.onload = function(){
            callback();
        };
    }
    script.src = url;
    document.getElementsByTagName("head")[0].appendChild(script);
}

  function myfancy () {
    jQuery("a#emaildevotion").fancybox({
        'autoScale': true,
        'autoDimensions': true,
        'overlayColor': '#000',
        'overlayOpacity': '0.5',
        'hideOnOverlayClick': false,
        'centerOnScroll': true,
        'transitionIn': 'none',
        'transitionOut': 'none',
        'type': 'inline'
    });
  };

  window.onload = function () {
    if(!window.jQuery) {
        include_js('/components/com_devotions/files/jquery-1.6.2.min.js', function(){
            include_js('/components/com_devotions/files/fancybox/jquery.fancybox-1.3.4.pack.js', myfancy);
        });
    }
    else {
        include_js('/components/com_devotions/files/fancybox/jquery.fancybox-1.3.4.pack.js', myfancy);
    }
    
    jQuery("#mydevotion").submit(function (e) {
        e.preventDefault();
        var THIS = this,
            data = jQuery(THIS).serialize(),
            responseP = jQuery('#responseP');
            
        responseP.html('<img src="/components/com_devotions/files/loading.gif">').slideDown('slow');
        
        jQuery.post('index.php?option=com_devotions&task=emaildevotion', data, function (result) {
        
            if (result) {
                responseP.slideUp(function () {
                    responseP.html('Thank you! Message sent.').addClass('green').slideDown('slow');
                });
                
                setTimeout(function () {
                     responseP.removeClass('green').slideUp();
                 }, 10 * 1000);
            }
            else {
                responseP.slideUp(function () {
                     responseP.html('Error! Message not sent.').addClass('red').slideDown('slow');
                }); 
                setTimeout(function () {
                     responseP.removeClass('red').slideUp();
                 }, 10 * 1000);           
            }
        }, 'json');       
    });
  };

}());

var openForm = function (url) {
        var newWindow = window.open(url, 'myWin', 'width=600,height=600,scrollbars=0,top=100,left=200,toolbar=0,menubar=0,status=0');		        		
};

var addPrintLink = {
	init:function(sTargetEl,sLinkText) {
		if (!document.getElementById || !document.createTextNode) {return;} // Check for DOM support
		if (!document.getElementById(sTargetEl)) {return;} // Check that the target element actually exists
		if (!window.print) {return;} // Check that the browser supports window.print
		var oTarget = document.getElementById(sTargetEl);
		var oLink = document.createElement('a');
		oLink.id = 'print-link'; // Give the link an id to allow styling
		oLink.href = '#'; // Make the link focusable for keyboard users
		oLink.appendChild(document.createTextNode(sLinkText));
		oLink.onclick = function() {window.print(); return false;} // Return false prevents the browser from following the link and jumping to the top of the page after printing
		oTarget.appendChild(oLink);
	},
/*
addEvent function included here for portability. Replace with your own addEvent function if you use one.
*/
/* addEvent function from http://www.quirksmode.org/blog/archives/2005/10/_and_the_winner_1.html */
	addEvent:function(obj, type, fn) {
		if (obj.addEventListener)
			obj.addEventListener(type, fn, false);
		else if (obj.attachEvent) {
			obj["e"+type+fn] = fn;
			obj[type+fn] = function() {obj["e"+type+fn](window.event);}
			obj.attachEvent("on"+type, obj[type+fn]);
		}
	}
};
addPrintLink.addEvent(window, 'load', function(){addPrintLink.init('article','Print this page');});