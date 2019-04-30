$(document).ready(function() {
  $('.navbar .active > a').css("color", "white");
  $('.navbar .active').removeClass('active');
  var path = location.pathname.split("/");
  $('a[href="' + path[path.length-1] + '"]').parent().addClass('active'); 
  $('.navbar .active > a').css("color", "rgb(237, 57, 36)");
});

$("#signUpBtn").on("click", function() {
	$("#signUpResult").load("queries/signUpSendMail.php", {
		firstname: $("#inputSignUpFirstName").val(), 
		lastname: $("#inputSignUpLastName").val(),
		gender: $("input[name='gender']:checked").val(),
		email: $("#inputSignUpEmailAddress").val(), 
		password: $("#inputSignUpPassword").val(), 
	});
});

// When the text is added as a response to the ajax call, we show the text
$("#signUpResult").bind("DOMNodeInserted", function() {
	$(this).css("opacity", "1");
})

$("#loginBtn").on("click", function() {
	$("#loginResult").load("queries/login.php", { 
		email: $("#inputEmailAddress").val(), 
		password: $("#inputPassword").val(), 
	});
});

$("#loginResult").bind("DOMNodeInserted", function() {
	$(this).css("opacity", "1");
})