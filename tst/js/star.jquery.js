(function($){  
	$.fn.star = function(options) {
		var defaults = {
			numPoints: 120,
			radius: {
				outer: 200,
				inner: 190
			},
			offset: {
				x: 0,
				y: 0
			}
		};
		var options = $.extend(defaults, options);      
		////these must be at least the outer radius or image will be cropped
		var offset = { 
			x: options.radius.outer + options.offset.x, 
			y: options.radius.outer + options.offset.y
		};
//		alert(offset.x + ' ' + offset.y);
		return this.each(function() { 
//			alert('um');
			////rendering engine
			var canvas= $(this).get(0);
			var containerSize = (options.radius.outer*2);
			var topLeft =  
				Math.sqrt(2*(Math.pow(options.radius.outer, 2))) - options.radius.inner;
			var bottomRight = containerSize - 2*topLeft;
//			alert($(this).parent().find('.canvas-text').length);
			$(this).parent().find('.canvas-text').css({ top: topLeft+'px', left: topLeft+'px', 
				width: bottomRight+'px', height: bottomRight+'px'}); 
			$(this).attr('width', containerSize).attr('height', containerSize);

			//$(this).css('width', options.radius.outer*4+'px');
			//$(this).css('height', options.radius.outer*4+'px');
//			alert(canvas);
			////calculations
			var degrees = 360/options.numPoints;
			var radians = degrees*(Math.PI/180);
			var inneroffset = radians/2;

			var c=canvas.getContext("2d");
			c.strokeStyle="#FFFF00"; //  line color
			c.lineWidth=3; // line width


			////build point arrays
			var outerpoints = [];
			var innerpoints = [];
			for (var i = 0; i < options.numPoints; i++) {
				////outer points
				var theta = i * radians;
				var outerpoint = {
					x: options.radius.outer*Math.cos(theta) + offset.x,
					y: options.radius.outer*Math.sin(theta) + offset.y
				}
				outerpoints.push(outerpoint);
				////inner points
				theta = (i * radians) + inneroffset;
				var innerpoint = {
					x: options.radius.inner*Math.cos(theta) + offset.x,
					y: options.radius.inner*Math.sin(theta) + offset.y
				}
				innerpoints.push(innerpoint);
			}
			////build vector graphic
			for (var i = 0; i < options.numPoints; i++) {
				var outerpoint = outerpoints[i];
				var innerpoint = innerpoints[i];
				if (i == 0) {
					c.moveTo(outerpoint.x, outerpoint.y);
					c.lineTo(innerpoint.x, innerpoint.y);
				} else {
					c.lineTo(outerpoint.x, outerpoint.y);
					c.lineTo(innerpoint.x, innerpoint.y);
				}
			}
			c.closePath();   
			//var grd=context.createRadialGradient(startX, startY, startRadius, endX, endY, endRadius);
			var canvasOffset = $(this).position();
			var boundaries = {
				top: canvasOffset.top,
				left: canvasOffset.left,
				bottom: canvasOffset.top + $(this).height(),
				right: canvasOffset.left + $(this).width()
			};
			var x = (boundaries.left + boundaries.right)/2;
			var y = (boundaries.top + boundaries.bottom)/2;
//			alert(boundaries.left +' '+ boundaries.top +' '+ 0 +' '+ boundaries.right +' '+ boundaries.bottom +' '+ options.radius.outer);
			var grd=c.createRadialGradient(options.radius.outer, options.radius.outer, 0, options.radius.outer, options.radius.outer, options.radius.outer);
			grd.addColorStop(0,"#FFFFFF");
			grd.addColorStop(1,"#FFFF00");
			c.fillStyle=grd;
	

			////render
			c.stroke();
			c.fill();
		});  
	};  
})(jQuery); 

/*
	var grd=c.createRadialGradient(200,100,400,300);
	grd.addColorStop(0,"#002691");
	grd.addColorStop(1,"#C4D3FF");
	c.fillStyle=grd;
	//c.fill();
*/

