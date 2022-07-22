//var $j = jQuery.noConflict();
jQuery(document).ready(function($) {  // Opening jQuery this way allows for the use of the '$' vs having to change it to the word 'jQuery'
  
  
  // This is the javascript to stops the default click beahvior and replaces it with a tap funtionality on ipad and other small touch devices 
  if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
    $(".menu li a").each(function() {
          if ($(this).next().length > 0) {
            $(this).addClass("parent");
        };
      });
    
    $(".parent").click(function(event) {
      event.preventDefault();
      $(this).unbind('click');
    });
  }
  

  // This is the javascript to control the drawer menu behavior
  $(function() {
    $("#drawer-menu").mmenu({
      extensions: ['pageshadow'],
      offCanvas: {
               position  : "right",
            },
      configuration: {
          menuNodetype: "div",
          pageNodetype: '<footer>'
        }
    });
  });


$(document.links).filter(function() {
  return this.hostname != window.location.hostname;
}).attr('target', '_blank');
  

  // Functions adds the collapsing archive behavior to archive list in sidebar
  $('#blogArchiveList > ul > li:has(ul)').addClass("has-sub");
  $('#blogArchiveList > ul > li a').click(function() {
    var checkElement = $(this).next();
    
    $('#blogArchiveList li').removeClass('active');
      $(this).closest('li').addClass('active');
    
    
    if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
      $(this).closest('li').removeClass('active');
      checkElement.slideUp('normal');
  }

  if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
    $('#blogArchiveList ul ul:visible').slideUp('normal');
    checkElement.slideDown('normal');
  }

  if (checkElement.is('ul')) {
    return false;
  } else {
    return true;  
  }
  });


  // Functions add class affix for navbar that sticks on scroll
  /*$('#navigation').affix({
    offset: {
      top: 175,
      bottom: function () {
        return (this.bottom = $('.footer').outerHeight(true))
      }
    }
  });*/


  // Functions add class to allow for responsive videos
  $(function() {
   // Run code for each element
   $('.embed-responsive iframe').addClass('embed-responsive-item');
  });
  
	// THIS SECTION MAKES THE PADDING AT THE TOP OF THE PAGE ADJUST TO THE NAV BAR HEIGHT
	//$( window ).load(function() {
		$("#internalfeatured").css({'padding-top':($("#navigation.fixed").outerHeight()+'px')});
		//$("#homeContentWrap").css({'padding-top':($("#navigation.fixed").outerHeight()+'px')}); 
        $("#navigation.fixed").addClass('affix-top')
		
		if($(window).width() >= 974){
			
			$("#page .pagebreak_left:first-child .pagebreak_left_img").css({'height':($("#page .pagebreak_left:first-child .pagebreak_left_content").outerHeight()+'px')});
			$("#page .pagebreak_left:nth-child(2) .pagebreak_left_img").css({'height':($("#page .pagebreak_left:nth-child(2) .pagebreak_left_content").outerHeight()+'px')});
			$("#page .pagebreak_left:nth-child(3) .pagebreak_left_img").css({'height':($("#page .pagebreak_left:nth-child(3) .pagebreak_left_content").outerHeight()+'px')});
			$("#page .pagebreak_left:nth-child(4) .pagebreak_left_img").css({'height':($("#page .pagebreak_left:nth-child(4) .pagebreak_left_content").outerHeight()+'px')});
			$("#page .pagebreak_left:nth-child(5) .pagebreak_left_img").css({'height':($("#page .pagebreak_left:nth-child(5) .pagebreak_left_content").outerHeight()+'px')});
			$("#page .pagebreak_left:nth-child(6) .pagebreak_left_img").css({'height':($("#page .pagebreak_left:nth-child(6) .pagebreak_left_content").outerHeight()+'px')});
			$("#page .pagebreak_left:nth-child(7) .pagebreak_left_img").css({'height':($("#page .pagebreak_left:nth-child(7) .pagebreak_left_content").outerHeight()+'px')});
			$("#page .pagebreak_left:nth-child(8) .pagebreak_left_img").css({'height':($("#page .pagebreak_left:nth-child(8) .pagebreak_left_content").outerHeight()+'px')});
			$("#page .pagebreak_left:nth-child(9) .pagebreak_left_img").css({'height':($("#page .pagebreak_left:nth-child(9) .pagebreak_left_content").outerHeight()+'px')});
			$("#page .pagebreak_left:nth-child(10) .pagebreak_left_img").css({'height':($("#page .pagebreak_left:nth-child(10) .pagebreak_left_content").outerHeight()+'px')});
						
			$("#page .pagebreak_right:first-child .pagebreak_right_img").css({'height':($("#page .pagebreak_right:first-child .pagebreak_right_content").outerHeight()+'px')});
			$("#page .pagebreak_right:nth-child(2) .pagebreak_right_img").css({'height':($("#page .pagebreak_right:nth-child(2) .pagebreak_right_content").outerHeight()+'px')});
			$("#page .pagebreak_right:nth-child(3) .pagebreak_right_img").css({'height':($("#page .pagebreak_right:nth-child(3) .pagebreak_right_content").outerHeight()+'px')});
			$("#page .pagebreak_right:nth-child(4) .pagebreak_right_img").css({'height':($("#page .pagebreak_right:nth-child(4) .pagebreak_right_content").outerHeight()+'px')});
			$("#page .pagebreak_right:nth-child(5) .pagebreak_right_img").css({'height':($("#page .pagebreak_right:nth-child(5) .pagebreak_right_content").outerHeight()+'px')});
			$("#page .pagebreak_right:nth-child(6) .pagebreak_right_img").css({'height':($("#page .pagebreak_right:nth-child(6) .pagebreak_right_content").outerHeight()+'px')});
			$("#page .pagebreak_right:nth-child(7) .pagebreak_right_img").css({'height':($("#page .pagebreak_right:nth-child(7) .pagebreak_right_content").outerHeight()+'px')});
			$("#page .pagebreak_right:nth-child(8) .pagebreak_right_img").css({'height':($("#page .pagebreak_right:nth-child(8) .pagebreak_right_content").outerHeight()+'px')});
			$("#page .pagebreak_right:nth-child(9) .pagebreak_right_img").css({'height':($("#page .pagebreak_right:nth-child(9) .pagebreak_right_content").outerHeight()+'px')});
			$("#page .pagebreak_right:nth-child(10) .pagebreak_right_img").css({'height':($("#page .pagebreak_right:nth-child(10) .pagebreak_right_content").outerHeight()+'px')});	
			
		}	
		
		$( "#myCarousel .active .slideDesc" ).each(function() {
			var newHeight = 0, $this = $( this );
			$.each( $this.children(), function() {
				newHeight += $( this ).height();
			});
			$this.height( newHeight );
		});		
		
		var maxHeight = 0;

		$(".equal_height").each(function(){
		   if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
		});

		$(".equal_height").height(maxHeight);
		
		 
	//}); 
	
	$(window).scroll(function() {
		if($(this).scrollTop() >= 175){} else {
			$("#internalfeatured").css({'padding-top':($("#navigation.fixed").outerHeight()+'px')});
		// 	$("#homeContentWrap").css({'padding-top':($("#navigation.fixed").outerHeight()+'px')});
		}
		if($(this).scrollTop() < 175){} else {
			$("#navigation.fixed").addClass('affix');
			$("#navigation.fixed").removeClass('affix-top');
		} 
		if($(this).scrollTop() >= 175){} else {
			$("#navigation.fixed").addClass('affix-top');
			$("#navigation.fixed").removeClass('affix');
		}        
	});
	
	$(window).resize(function() {
		$("#internalfeatured").css({'padding-top':($("#navigation.fixed").outerHeight()+'px')});	
		//$("#homeContentWrap").css({'padding-top':($("#navigation.fixed").outerHeight()+'px')});	
		if($(window).width() >= 974){
			
			$("#page .pagebreak_left:first-child .pagebreak_left_img").css({'height':($("#page .pagebreak_left:first-child .pagebreak_left_content").outerHeight()+'px')});
			$("#page .pagebreak_left:nth-child(2) .pagebreak_left_img").css({'height':($("#page .pagebreak_left:nth-child(2) .pagebreak_left_content").outerHeight()+'px')});
			$("#page .pagebreak_left:nth-child(3) .pagebreak_left_img").css({'height':($("#page .pagebreak_left:nth-child(3) .pagebreak_left_content").outerHeight()+'px')});
			$("#page .pagebreak_left:nth-child(4) .pagebreak_left_img").css({'height':($("#page .pagebreak_left:nth-child(4) .pagebreak_left_content").outerHeight()+'px')});
			$("#page .pagebreak_left:nth-child(5) .pagebreak_left_img").css({'height':($("#page .pagebreak_left:nth-child(5) .pagebreak_left_content").outerHeight()+'px')});
			$("#page .pagebreak_left:nth-child(6) .pagebreak_left_img").css({'height':($("#page .pagebreak_left:nth-child(6) .pagebreak_left_content").outerHeight()+'px')});
			$("#page .pagebreak_left:nth-child(7) .pagebreak_left_img").css({'height':($("#page .pagebreak_left:nth-child(7) .pagebreak_left_content").outerHeight()+'px')});
			$("#page .pagebreak_left:nth-child(8) .pagebreak_left_img").css({'height':($("#page .pagebreak_left:nth-child(8) .pagebreak_left_content").outerHeight()+'px')});
			$("#page .pagebreak_left:nth-child(9) .pagebreak_left_img").css({'height':($("#page .pagebreak_left:nth-child(9) .pagebreak_left_content").outerHeight()+'px')});
			$("#page .pagebreak_left:nth-child(10) .pagebreak_left_img").css({'height':($("#page .pagebreak_left:nth-child(10) .pagebreak_left_content").outerHeight()+'px')});		
			
			$("#page .pagebreak_right:first-child .pagebreak_right_img").css({'height':($("#page .pagebreak_right:first-child .pagebreak_right_content").outerHeight()+'px')});
			$("#page .pagebreak_right:nth-child(2) .pagebreak_right_img").css({'height':($("#page .pagebreak_right:nth-child(2) .pagebreak_right_content").outerHeight()+'px')});
			$("#page .pagebreak_right:nth-child(3) .pagebreak_right_img").css({'height':($("#page .pagebreak_right:nth-child(3) .pagebreak_right_content").outerHeight()+'px')});
			$("#page .pagebreak_right:nth-child(4) .pagebreak_right_img").css({'height':($("#page .pagebreak_right:nth-child(4) .pagebreak_right_content").outerHeight()+'px')});
			$("#page .pagebreak_right:nth-child(5) .pagebreak_right_img").css({'height':($("#page .pagebreak_right:nth-child(5) .pagebreak_right_content").outerHeight()+'px')});
			$("#page .pagebreak_right:nth-child(6) .pagebreak_right_img").css({'height':($("#page .pagebreak_right:nth-child(6) .pagebreak_right_content").outerHeight()+'px')});
			$("#page .pagebreak_right:nth-child(7) .pagebreak_right_img").css({'height':($("#page .pagebreak_right:nth-child(7) .pagebreak_right_content").outerHeight()+'px')});
			$("#page .pagebreak_right:nth-child(8) .pagebreak_right_img").css({'height':($("#page .pagebreak_right:nth-child(8) .pagebreak_right_content").outerHeight()+'px')});
			$("#page .pagebreak_right:nth-child(9) .pagebreak_right_img").css({'height':($("#page .pagebreak_right:nth-child(9) .pagebreak_right_content").outerHeight()+'px')});
			$("#page .pagebreak_right:nth-child(10) .pagebreak_right_img").css({'height':($("#page .pagebreak_right:nth-child(10) .pagebreak_right_content").outerHeight()+'px')});	
			
		}
		
		if($(window).width() <= 974){
			
			$(".pagebreak_left_img").height('auto');
			$(".pagebreak_right_img").height('auto');
			
		}
		
		$( "#myCarousel .active .slideDesc" ).each(function() {
			var newHeight = 0, $this = $( this );
			$.each( $this.children(), function() {
				newHeight += $( this ).height();
			});
			$this.height( newHeight );
		});	
		
		var maxHeight = 0;

		$(".equal_height").each(function(){
		   if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
		});

		$(".equal_height").height(maxHeight);
		
	}).resize();
	
	$('#myCarousel').on('slid.bs.carousel', function() {
		$( "#myCarousel .active .slideDesc" ).each(function() {
			var newHeight = 0, $this = $( this );
			$.each( $this.children(), function() {
				newHeight += $( this ).height();
			});
			$this.height( newHeight );
		});	
	});

	
	const container = document.getElementById('pagewrapper');
	const highlight = document.getElementById('js-highlight');
	var containerHeight;
	
	window.onscroll = function(){
		containerHeight = container.offsetHeight - window.innerHeight;
		containerPos = container.getBoundingClientRect();
		diff = containerHeight + containerPos.top;
		progressPercentage = diff / containerHeight * 100;
		cssWidth = Math.floor(100 - progressPercentage);
		highlight.style.width = cssWidth + "%";
	}
	
	
	for (var i = 0; i < 150; i++) {
	  create(i);
	}
	
	function create(i) {
	  var width = Math.random() * 8;
	  var height = width * 0.4;
	  var colourIdx = Math.ceil(Math.random() * 3);
	  var colour = "red";
	  switch(colourIdx) {
		case 1:
		  colour = "yellow";
		  break;
		case 2:
		  colour = "blue";
		  break;
		default:
		  colour = "red";
	  }
	  $('<div class="confetti-'+i+' '+colour+'"></div>').css({
		"width" : width+"px",
		"height" : height+"px",
		"top" : -Math.random()*20+"%",
		"left" : Math.random()*100+"%",
		"opacity" : Math.random()+0.5,
		"transform" : "rotate("+Math.random()*360+"deg)"
	  }).appendTo('.wrapper');  
	  
	  drop(i);
	}
	
	function drop(x) {
	  $('.confetti-'+x).animate({
		top: "100%",
		left: "+="+Math.random()*15+"%"
	  }, Math.random()*2000 + 2000, function() {
		reset(x);
	  });
	}
	
	function reset(x) {
	  $('.confetti-'+x).animate({
		"top" : -Math.random()*20+"%",
		"left" : "-="+Math.random()*15+"%"
	  }, 0, function() {
		drop(x);             
	  });
	}
  /* 
  *  Function calls the javascript and establishes settings for the featured image slider.
  * 
  *  Credit to Sachin N. at http://sachinchoolur.github.io/lightslider/ for the cool slider for posts
  *  For documentation of all of the different settings that you can use visit http://sachinchoolur.github.io/lightslider/settings.html
  *
  */

if( /Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
    var slider = $('#lightSlider').lightSlider({
        pause: 6000,
        autoWidth: false,
        pager: false,
        loop:true,
        auto: true,
        controls: false,
        enableDrag: false,
		item: 1
    });
} else if( /iPad/i.test(navigator.userAgent) ) {
    var slider = $('#lightSlider').lightSlider({
        pause: 6000,
        autoWidth: false,
        pager: false,
        loop:true,
        auto: true,
        controls: false,
        enableDrag: false,
		item: 2
    });
} else {
    var slider = $('#lightSlider').lightSlider({
        pause: 6000,
        autoWidth: false,
        pager: false,
        loop:true,
        auto: true,
        controls: false,
        enableDrag: false,
		item: 5
    });
}
	
    $('#goToPrevSlide').on('click', function () {
        slider.goToPrevSlide();
    });
    $('#goToNextSlide').on('click', function () {
        slider.goToNextSlide();
    });

    //Add/remove a class to labels with checkboxes and radio buttons and style them
	$('label input[type=radio], label input[type=checkbox]').click(function() {
	  $('label:has(input:checked)').addClass('active');
	  $('label:has(input:not(:checked))').removeClass('active');
	});   

});

