$(function() {
	$("ul.sf-menu").superfish({
            animation: {height:'show'},   // slide-down effect without fade-in 
            delay:     1200               // 1.2 second delay on mouseout 
    });
    $('#menu-toggle').click(function(e) {
    	// alert($('#leftcolumn').css('display'));
    	var display = $('#leftcolumn').css('display') == 'none' ? 'block' : 'none';
    	$('#leftcolumn').css('display', display);
    	e.stopPropagation();
    	return false;

    })
});
