$(function(){
	$('#questions div.socials .logo-quiz a:last').click(
		function(){ 
			$('div:first', $(this).closest('div.socials'))
				.fadeOut('normal', 'swing');
			$('div:last', $(this).closest('div.socials'))
				.fadeIn('narmal', 'swing');
			return false;
		}//,
		// function(){
		// 	$('div:first', $(this)).fadeIn('normal', 'swing');
		// 	$('div:last', $(this)).fadeOut('narmal', 'swing');
		// }
	);

	$("#questions div.batch div.question").each(function(){
		if($(this).find('ul li').length > 5){
			$(this).width(($(this).width()*2) + 20);
			$(this).find('.right h2').width($(this).find('.right h2').width() * 2);
		}
	});

	//make the select null answer turn to gray
	$(".choices").change(function () {
	    if($(this).val() == "0") $(this).addClass("empty");
	    else $(this).removeClass("empty")

	    if($(this).val() == "other"){
	    	elem = $('<input type="text">');
	    	elem.addClass('other').hide();
	    	elem.insertAfter($(this));
	    	elem.fadeIn('slow');
	    	//$(this).next('input').fadeIn('fast');
	    }else{
	    	$(this).next('input').hide('normal', function(){$(this).remove()});
	    }
	});
	$(".choices").change();

	$('#questions div.socials .m-over').click(function(){ 
		$('div:first', $(this).closest('div.socials'))
			.fadeIn('normal', 'swing');
		$('div:last', $(this).closest('div.socials'))
			.fadeOut('normal', 'swing');
		return false;
	})

	$('#questions .batch :not(socials) ul li a').click(function(){
		if(!$(this).closest('ul').hasClass('multi-2')){
			$(this).closest('ul').find('li a').removeClass('selected');
			$(this).closest('dd').find('select option').removeAttr('selected');
		}else if($(this).closest('ul').hasClass('multi-2') && 
				 $('.multi-2 .selected').length == 2)
		{
			$(this).closest('ul').find('li a').removeClass('selected');
			$(this).closest('dd').find('select option').removeAttr('selected');
		}
		$(this).addClass('selected');
		if($(this).closest('ul').hasClass('multi-2')){
			liIndex = $(this).closest('ul').find('li').index($(this).closest('li'));
		}else{
			liIndex = $(this).closest('ul').find('li').index($(this).closest('li')) + 1;
		}
		$(this).closest('dd').find('select option:eq('+ liIndex +')').attr("selected", "selected");
		return false;
	})

	var wdoc = $(document).width();
	var margins = wdoc - 970;
	$('div.batch').css('padding-left', margins/2);

	//$('#questions .batch:last').show();
	$('.main#quiz').height(1350);
	$('.main#quiz').width($(window).width());

	//$('#wrapper, #questions').css({'left': '-1240px'});
	//$('.batch').wrap('<div class="batch-wrapper">');

	//validate when clicking on next
	$('.link-btn.footer a').click(function(){

		var empty = new Array();
		var i = 0;

		$('#questions .batch div.question').not('.socials').each(function(){
			if(i<9){
				if(	
					$(this).find('select').length && 
					$(this).find('select').val()==0
				  )
					empty[i] = i;

				else if($(this).find('textarea').val() == '') empty[i] = i;
				i++;
			}
		})

		if(!empty.length){
			$('#wrapper, #questions').animate({
				left: -(margins/2 + 970),
			}, 900, 'swing');
			
			$.scrollTo('#questions', { 
				duration: 900, 
				easing:'swing', 
				onAfter: function(){
					$('.main#quiz').height(1400);
				}});

			$(this).fadeOut();

			$('.error').slideUp('slow');
			
		}else{
			
			$.scrollTo('#questions', {
										duration: 300, 
										easing:'swing', 
										onAfter: function(){
											$('.error')
												.html('please answer all the \
													questions before \
													proceeding')
												.slideDown('normal', 'swing')
										}
									}
			);
		}
		$('.main#quiz').height($('.main#quiz').height() + 100);
		return false;
	});

	// $('#questions div.batch textarea').each(function(){
	// 	$(this).height(
	// 		$(this).closest('div').height() - 
	// 		$(this).closest('div').find('img').height() -
	// 		50
	// 	);
	// });

	$("#submit").click(function(){
		var query = {}
		var empty2 = new Array();
		var i = 0;
//alert(empty2.length);
		$('#questions .batch div.question').not('.socials').each(function(){
			if(i<18){
				if(	
					$(this).find('select').length && 
					$(this).find('select').val()==0
				  )
					{ empty2[i] = i; console.log($(this).find('select').html()); }

				else if($(this).find('textarea').val() == '') empty2[i] = i;
				i++;
			}
		})

		if(empty2.length){
			//alert(empty2.length);
			$.scrollTo('#questions', {
										duration: 300, 
										easing:'swing', 
										onAfter: function(){
											$('.error')
												.html('please answer all the \
													question before \
													proceeding')
												.slideDown('normal', 'swing')
										}
									}
			);
			$('.main#quiz').height($('.main#quiz').height() + 100);
			return false
		}
		i=0;
		$('#questions .batch div').not('.socials').each(
			function(){
				if(i < 18){
					if($(this).find('select').length){
						var select = $(this).find('select');
						if(select.val() == 'other'){
							query[select.attr('name')] = select.next('input.other').val();
						}else{
							query[select.attr('name')] = select.val();
						}
						// if(elem.length){
						// 	query['data_'+i] = "";
						// 	elem.each(function(){
						// 		query['data_'+i] += $(this).text() + ', ';
						// 	})
						// 	iQuery = query['data_'+i];
						// 	query['data_'+i] = iQuery.substr(
						// 								0, 
						// 								iQuery.length-2
						// 							  );
						// }else{
						// 	query['data_'+i] = $(this)
						// 						 .find('a.selected')
						// 						 .text();
						// }
					}else{
						query[$(this).find('textarea').attr('name')] = $(this).find('textarea').val();
					}
				}i++;
			}
		)

		// alert(query[0]);

		// for(var k in query){
		// 	alert('key is: ' + k + ', value is: ' + query[k]);
		// }

		$.ajax({
		  type: "POST",
		  url: "submit.php",
		  data: query
		}).done(function( msg ) {
		  console.log( "Data Saved: " + msg );
		  $('#submit').attr('disabled', 'disabled');
		});
	});

	$('a.subscribe').click(function(){
		$('form#subscribe').submit();
		return false;
	});

	
})