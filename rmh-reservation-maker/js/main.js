$(document).ready(function(){
	var offsetTop = 80; //for nav selector offset
	if($('nav.navpane li.selected').size() > 0){
		$('nav .leftArrow').css('top', $('nav.navpane li.selected').position().top + offsetTop);
	}
	
	//hash change ajax
	var newHash = '';

	$(window).bind('hashchange', function(){
		newHash = window.location.hash.substring(1);
		if(newHash)
		{
			$('nav.navpane li').removeClass('selected')
			$('nav.leftmenu li[data-href="'+newHash+'"]').addClass('selected');
				//newHash = newHash.replace('-','/');
		}
	});
	
	$(window).trigger('hashchange'); 
	
	//ajax load tracker
	var ajaxLoading = false;
	
	//ajax load for navigation
	$('nav.navpane li').click(function(e){
		//window.location.hash = $(this).data('href');
		window.location = $(this).data('href');
	});

	function loadAjaxURL(URL){
		if(ajaxLoading)
			return;
		$('<div id="loading">Loading</div>').appendTo('body').fadeIn('slow', function(){
				$.ajax({
				url: URL,
				type: 'POST',
				data:{'requestType': 'ajax'},
				timeout: 5000,
				done: function(data){
					$('#loading').remove();
					$('section.content').html(data);
				},
				always: function(){
					alert("hell");
				}
				
			})
		});
		
	}
	
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
	
	/*session message click*/
	$('.session_message').click(function(e){
		$(this).slideUp();
	});
});
