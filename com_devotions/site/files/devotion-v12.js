(function (window, $) {
    "use strict";
    
    var Pagination, openForm, include_js, myfancy, addPrintLink, unorderedList, template;
    

    Pagination = {
    
        data: [],
        
        currentPage: 0,
        
        currentBatch: 0,
    
        perPage: 5,
        
        perBatch: 10,
    
        totalPages: 0,
        
        toolBatches:  0,
    
        pagenationDiv: '#page_navigation',
    
        contentDiv: '#blessingsDiv',
    
    
        init: function (data) {
            var totalPages = Math.ceil(data.length/Pagination.perPage),
                toolBatches = 1;
                
            if (totalPages > 1) {
                Pagination.totalPages = totalPages;
                $(Pagination.pagenationDiv).parent().css({'display': 'block'});
            }
            else {
                Pagination.totalPages = 1;
                $(Pagination.pagenationDiv).parent().css({'display': 'none'});
            }
            
            if (totalPages > Pagination.perBatch) {
                toolBatches = Math.ceil(totalPages/Pagination.perBatch);
                
                Pagination.toolBatches = toolBatches;
            }
            
            Pagination.data = data; 
            
            Pagination.goToPage(Pagination.currentPage);            
        },
    
    
        next: function () {
            var new_page = Pagination.currentPage + 1;
        
            if (new_page < Pagination.totalPages) {
                Pagination.goToPage(new_page);
            }
        },
    
    
        prev: function () {
            var new_page = Pagination.currentPage - 1;
        
            if (new_page >= 0) {
                Pagination.goToPage(new_page);
            }
        },
    
    
        pager: function () {
            var i,  html = '', c, k;
            
            Pagination.currentBatch = Math.floor(Pagination.currentPage/Pagination.perBatch);
                
            c = Pagination.currentBatch * Pagination.perBatch;
            
            if (Pagination.totalPages < (c + Pagination.perBatch)) {
                k = Pagination.totalPages;
            }
            else {
                k = c + Pagination.perBatch;
            }
            
            if (Pagination.currentPage === 0) {
                html += '<span>&laquo;</span> <span>Start</span> <span>Prev</span>';
            }
            else {
                html += '<span>&laquo;</span> <a class="next_link" href="javascript:goToPage(0);">Start</a> <a class="previous_link" href="javascript:prev();">Prev</a>';
            }
            
            
        
            for (i = c; i < k; i++) {
                if (Pagination.currentPage === i) {
                    html += '<strong><span>'+ (i  + 1) +'</span></strong>';
                }
                else {
                    html += '<strong><a class="page_link" href="javascript:goToPage(' + i +');">'+ (i  + 1) +'</a></strong>';
                }
            }
            
            if ((Pagination.currentPage + 1) === Pagination.totalPages) {
                html += '<span>Next</span> <span>End</span> <span>&raquo;</span>';
            }
            else {
                html += '<a class="next_link" href="javascript:next();">Next</a> <a class="next_link" href="javascript:goToPage(' + (Pagination.totalPages - 1) +');">End</a> <span>&raquo;</span>';
            }
            
            if (Pagination.totalPages > 1) {
                $(Pagination.pagenationDiv).fadeOut('slow', function() {
                    $(Pagination.pagenationDiv).html(html).fadeIn('slow');
                });
                
                $('#total-pages').fadeOut('slow', function() {
                    $('#total-pages').html("Page " + (Pagination.currentPage + 1) + " of " + Pagination.totalPages).fadeIn('slow');
                });
                
            }
        },
    
    
        unorderedList: function (user) {
            var item, link = '<a href="http://www.holinesspage.com/index.php?option=com_devotions&view=profile&pid=' + user.pastorid + '">' + user.username + '</a>';
    
            link += ' is truly blessed by this devotion';
    
            item = $('<li>', {
                html:  link 
            });
    
            return item;
        },

    
        goToPage: function (page) {
            var start_from, end_on, i,  container;
        
            container = $('<ul>', {
                'class': 'mod_devotions'
            });     
            
            start_from = page * Pagination.perPage;
    
            end_on = start_from + Pagination.perPage;
        
            end_on = (Pagination.data.length >= end_on) ? end_on : Pagination.data.length;
    
            for (i = start_from; i < end_on; i++) {
                var mylist = Pagination.unorderedList(Pagination.data[i]);
        
                container.append(mylist)
            }
        
            Pagination.currentPage = page;
            Pagination.pager();
        
            $(Pagination.contentDiv).fadeOut('slow', function() {
                $(Pagination.contentDiv).html(container).fadeIn('slow');
            });
        }    
    };
    
    window.Pagination = Pagination;
    
    window.prev = function () {
        Pagination.prev()
    };
    
    window.next = function () {
        Pagination.next();
    };
    
    window.goToPage = function (page) {
        Pagination.goToPage(page);
    };
    
    window.blessingButton = function (data) {
        $(function () {
            Pagination.init(data);
        });
    };	
 

    include_js = function (url, callback) {  // http://www.nczonline.net
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
    };

    myfancy = function() {
        $("a#emaildevotion").fancybox({
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

    window.openForm = function (url) {
        var newWindow = window.open(url, 'myWin', 'width=600,height=600,scrollbars=0,top=100,left=200,toolbar=0,menubar=0,status=0');		        		
    };

    addPrintLink = {
	    init:function(sTargetEl,sLinkText) {
            var oTarget, oLink;
            
		    if (!document.getElementById || !document.createTextNode) {
                return;
            } 
		    
            if (!document.getElementById(sTargetEl)) {
                return;
            } 
		    
            if (!window.print) {
                return;
            } 
		    
            oTarget = document.getElementById(sTargetEl);
		    oLink = document.createElement('a');
            
		    oLink.id = 'print-link'; 
		    oLink.href = '#'; 
		    oLink.appendChild(document.createTextNode(sLinkText));
		    oLink.onclick = function() {
                window.print(); 
                return false;
            } 
		    oTarget.appendChild(oLink);
	    },

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
    
    
    addPrintLink.addEvent(window, 'load', function () { 
        addPrintLink.init('article','Print this page');
    });
    
    
    window.blessMe = function (devotionId, pastorId) {
        if (Pagination.data.length < 1) {
            $(Pagination.contentDiv).html('<img src="/components/com_devotions/files/loading.gif" />');
        }
        
        $.post('index.php?option=com_devotions&task=blessMe', {did: devotionId, pid: pastorId}, function (res) {
            if (res === 'success') {
                var name = document.forms.commentForm.name.value,
                userObj = {id: pastorId, pastorid: pastorId, username: name}, user;
      
                if (Pagination.data.length > 0) {
                   //user = Pagination.unorderedList(userObj);
                    Pagination.data.unshift(userObj);
                    Pagination.init(Pagination.data);
                }
                else {
                    Pagination.init([userObj]);
                }
            }
            else {
              var q = '';
            }
        });
    };
    
    
    $(function () {
        myfancy();
        var img = new Image();
        
        img.src = "/components/com_devotions/files/loading.gif";
        
        $("#mydevotion").submit(function (e) {
        e.preventDefault();
            
        var THIS = this,
        data = $(THIS).serialize(),
        responseP = $('#responseP');
            
        responseP.html('<img src="/components/com_devotions/files/loading.gif">').slideDown('slow');
        
        $.post('index.php?option=com_devotions&task=emaildevotion', data, function (result) {
        
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
    });
}(window, jQuery));