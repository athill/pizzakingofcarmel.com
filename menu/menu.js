$(function() {
	$('.tooltip').tooltip({ 
	    delay: 0, 
	    showURL: false, 
	    bodyHandler: function() { 
	        return $("<img/>").attr("src", this.src); 
	    } 
	});
});
