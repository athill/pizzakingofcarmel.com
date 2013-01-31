$(function() {
	var options = getOpts();
	$('#star').star(options);
//	$("#canvas-wrapper .canvas-text span").html($(this).val().replace(/\n/g, '<br />'));
	$("#canvas-wrapper .canvas-text").textfill({ maxFontPixels: 100 });	
	$("#input-canvas-text").keyup(function() {
		//alert($(".canvas-text span", $('#star')).length);
		$("#canvas-wrapper .canvas-text span").html($(this).val().replace(/\n/g, '<br />'));
		$("#canvas-wrapper .canvas-text").textfill({ maxFontPixels: 100 });
	});	
	$('#input-canvas-inner-radius,#input-canvas-outer-radius,#input-canvas-numPoints').blur(function() {
		var options = getOpts();
		$('#star').star(options);		
		$("#canvas-wrapper .canvas-text").textfill({ maxFontPixels: 100 });
	});
	
});

function getOpts() {
	return {
		numPoints: parseInt($('#input-canvas-numPoints').val()),
		radius: {
			outer: parseInt($('#input-canvas-outer-radius').val()),
			inner: parseInt($('#input-canvas-inner-radius').val())
		}		
	};
}
