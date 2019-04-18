var listingid;

$("#submitInvestmentBtn").on("click", function() {
	$.post('queries/submitInvestment.php', { VALUE: $("#inputInvestment").val(), LISTINGID: listingid }).done(
		function (data) {
			$("#investmentResult").css("color", "green");
			$("#investmentResult").html("Investment complete! Refreshing...");
			setTimeout("document.location.reload(true)", 2000);
	});
});

// update the listing we are currently viewing
$(".investBtn").on("click", function() {
	listingid = $(this).attr("id");
});

//$(document).ajaxComplete(function() {
//});