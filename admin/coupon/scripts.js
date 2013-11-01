$(function() {
	////set up
	$(".coupon-body").textfill({ maxFontPixels: 80 });
	$(".body-text").each(function(index, domele) {
		$(this).val($(this).val().replace(/\t/g, ""));
	});
	$(".coupon-header").textfill({ maxFontPixels: 80 });
	$(".coupon-body").textfill({ maxFontPixels: 80 });
	$(".expire-text").datepicker();
	////events
	$(".header-text").keyup(function() {
		var id = $(this).attr("id");
		var coupon = "#coupon-"+id.replace(/.*-([^\-]+)$/, "$1");
		$(coupon + " .coupon-header span").html($(this).val());
		$(coupon + " .coupon-header").textfill({ maxFontPixels: 80 });
	});
	$(".body-text").keyup(function() {
		var id = $(this).attr("id");
		var coupon = "#coupon-"+id.replace(/.*-([^\-]+)$/, "$1");
		$(coupon + " .coupon-body span").html($(this).val().replace(/\n/g, "<br />"));
		$(coupon + " .coupon-body").textfill({ maxFontPixels: 80 });
	});
	$(".expire-text").change(function() {
		var id = $(this).attr("id");
		var coupon = "#coupon-"+id.replace(/.*-([^\-]+)$/, "$1");
		$(coupon + " .coupon-expire").html($(this).val());
	});
});