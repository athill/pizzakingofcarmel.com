$(function() {
	$('#pics').sortable();
	$("#pics .delete").click(function() { 
		if (confirm('Really delete?')) {
	    	$(this).parent().parent().remove();
	    	updateSequence();
	    }
	});	
});

function updateSequence() {
	$('#sequence').val($("#pics").sortable("toArray"));
}