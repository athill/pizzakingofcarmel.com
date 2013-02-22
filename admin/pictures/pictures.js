$(function() {
	$('#pics').sortable();
	$("#pics .delete").each(function(i) {
		$(this).removeAttr('checked');
	});
	$("#pics .delete").click(function() { 
		container = $(this).parent().parent();
	////Real time editing, would need to actually delete picture from server via XHR
	// if (confirm('Really delete?')) {
	//    	$(this).parent().parent().remove();
	//    	updateSequence();
	//    }
		var background = ($(this).attr('checked')) ? '#A00' : '#FFF';
		container.css('background', background);
		container.hover(
			function() {  
				$(this).css('background', 'lightgray');
			},
			function() {  
				$(this).css('background', background);
			}			
		);
	});	
});



function updateSequence() {
	$('#sequence').val($("#pics").sortable("toArray"));
}