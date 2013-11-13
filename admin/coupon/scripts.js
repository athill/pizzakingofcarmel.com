$(function() {
	////set up
	$(".coupon-body").textfill({ maxFontPixels: 80 });
	$(".body-text").each(function(index, domele) {
		$(this).val($(this).val().replace(/\t/g, ""));
	});
	$(".coupon-header").textfill({ maxFontPixels: 80 });
	$(".coupon-body").textfill({ maxFontPixels: 80 });
	$("[name^=admin-expire]").datepicker();
	////sequence
	$('#coupon-form-container').sortable({
		stop: function(e, ui) {
            console.log($(this).sortable('toArray'));
            $('#sequence').val($(this).sortable('toArray').join(','));
        }

	});
	$('#sequence').val($('#coupon-form-container').sortable('toArray').join(','));
	////add form
	$('#add-header').keyup(function() {
		var coupon = '#coupon-add';
		$(coupon + " .coupon-header span").html($(this).val());
		$(coupon + " .coupon-header").textfill({ maxFontPixels: 80 });
	});
	$("#add-body").keyup(function() {
		var coupon = '#coupon-add';
		$(coupon + " .coupon-body span").html($(this).val().replace(/\n/g, "<br />"));
		$(coupon + " .coupon-body").textfill({ maxFontPixels: 80 });
	});
	$("#add-expire").change(function() {
		var coupon = '#coupon-add';
		$(coupon + " .coupon-expire").html($(this).val());
	});

	////admin form
	$("input[name^='admin-header']").keyup(function() {
		var id = $(this).attr("id");
		var coupon = getCoupon(id);
		$(coupon + " .coupon-header span").html($(this).val());
		$(coupon + " .coupon-header").textfill({ maxFontPixels: 80 });
	});
	$("textarea[name^=admin-body]").keyup(function() {
		var id = $(this).attr("id");
		var coupon = getCoupon(id);
		$(coupon + " .coupon-body span").html($(this).val().replace(/\n/g, "<br />"));
		$(coupon + " .coupon-body").textfill({ maxFontPixels: 80 });
	});
	$("input[name^=admin-expire]").change(function() {
		var id = $(this).attr("id");
		var coupon = getCoupon(id);
		$(coupon + " .coupon-expire").html($(this).val());
	});
});

function getCoupon(id) {
	return "#coupon-"+id.replace(/.*-([^\-]+)$/, "$1");
}