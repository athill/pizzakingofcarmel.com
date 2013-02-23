$(function() {
	$('#pics').sortable({
		update: function(e, ui) {
			//$('#sequence').val();
			updateSequence();
		}
	});
	$("#pics .delete").each(function(i) {
		$(this).removeAttr('checked');
	});
	$("#pics .delete").click(function() { 
		container = $(this).parent().parent();
	////Real time editing, would need to actually delete picture from server via XHR
	// if (confirm('Really delete?')) {
	//    	$(this).parent().parent().remove();
	//    	
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
	$('#add-form').submit(function(e) {
		var img = $('#img').val();
		////empty fields
		if (img == '' || $('#title').val() == '') {
			alert('You must supply both an image and a title');
			return false;	
		} 
		//// invalid image
		var pos = img.lastIndexOf('.');
		var ext = img.slice(pos).toLowerCase();
		if (pos == -1 || $.inArray(ext, ['.jpg', '.jpeg', '.gif', '.png']) == -1) {
			alert('Invalid Image');
			return false;
		}
		return true;
	});
	$('#pics-preview').click(function(e) {
		var ref = window.open('preview.php', 'previewWin', 'width=1060,height=1000,scrollbars=yes');
	});
});



function updateSequence() {
	$('#sequence').val($("#pics").sortable("toArray"));
}