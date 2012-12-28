$(document).ready(function(){
	var offsetTop = 80; //for nav selector offset
	
	$('nav .leftArrow').css('top', $('nav.navpane li.selected').position().top + offsetTop);
	
	$('nav.navpane li').click(function(e){
		$('nav.navpane li.selected').removeClass('selected');
		$(this).addClass('selected');
		$('nav .leftArrow').css('top', $(this).position().top + offsetTop);
	});
	
	$('h1').click(function(e){
		$.ajax({
			url: 'form.html',
			success: function(data){
				$('section.content').html(data);
			}
		});
	});
	
	$('.btn-navbar').click(function(e){
		e.preventDefault();
		e.stopImmediatePropagation();
		
		//media query test
		var mqTest = Modernizr.mq('only screen and (max-width: 35em)');
		if(mqTest){
			//smartphone
			if($(this).data('toggle') == 'collapse'){
				$('nav.navpane').show();
				navHeight = $('header.topbar').height() + $('nav.navpane ul').height();
				$('section.content').stop(true, true).animate({'top': navHeight});
				$(this).data('toggle', "expand");
				
			}else if($(this).data('toggle') == 'expand'){
				$('section.content').stop(true, true).animate({'top': '4.2em'});
				$(this).data('toggle', "collapse");
			}
		}else{
			if($(this).data('toggle') == 'collapse'){
				$('section.content').stop(true, true).animate({'left': '16em'});
				$(this).data('toggle', "expand");
				
			}else if($(this).data('toggle') == 'expand'){
				$('section.content').stop(true, true).animate({'left': '0'});
				$(this).data('toggle', "collapse");
			}
		}
		
	});
});
