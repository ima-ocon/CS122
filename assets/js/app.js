$(document).ready(function() {
	$(".nav-link").on("click", function() {
		$("#home-nav-marker").remove();
		$(this).prepend("<div id='home-nav-marker'></div>");
		$(".home-section").hide();
		closeCard();

		activeSection = $(this).attr("class").split(" ")[1];

		if (activeSection != "dashboard-section")
			$("#main-fab").addClass("visible");
		else
			$("#main-fab").removeClass("visible");

		$("." + activeSection).show();
	});

	$(".feed-card").on("click", function(e) {
		e.stopPropagation();
		openCard();
	});

	$(".fab").on("click", function(e) {
		e.stopPropagation();

		if (!$("#focused-card").hasClass("active")) {
			$("#main-fab > .add-icon").toggleClass("rotate");
			$(".sub-fab").toggleClass("active");
			$(".sub-fab").css("visibility", "visible");
		}
	});

	$(".sub-fab").on("click", openCard);

	$(".sub-fab").on("transitionend", function() {
		if (!$(this).hasClass("active"))
			$(this).css("visibility", "hidden");
	});

	function openCard() {
		$(".home-section").addClass("inactive");
		$("#focused-card").addClass("active");
		$(".home-section").css("overflow", "hidden");
		$(".feed-card, .fab").css("cursor", "default");
		$(".feed-card, .fab").removeClass("hoverable");
	}

	$("#home-content").on("click", function() {
		closeCard();
		$("#main-fab > .add-icon").removeClass("rotate");
		$(".sub-fab").removeClass("active");
		$(".sub-fab").css("visibility", "visible");
	});

	function closeCard() {
		$(".home-section").removeClass("inactive");
		$("#focused-card").removeClass("active");
		$(".home-section").css("overflow-y", "scroll");
		$(".feed-card, .fab").css("cursor", "pointer");
		$(".feed-card, .fab").addClass("hoverable");
	}
});
